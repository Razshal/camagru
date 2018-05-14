<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . "/model/checks.php");

class Database
{
    private $PDO = NULL;
    private $SITE_ADDRESS = NULL;

    public function __construct($DB_DSN, $DB_USER, $DB_PASSWORD, $SITE_ADDRESS)
    {
        try
        {
            $this->PDO = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            $this->SITE_ADDRESS = $SITE_ADDRESS;
        } catch (Exception $exception) {
            throw new Exception("Cannot connect to database");
        }
    }

    public function initiate() {
        try {
            $this->PDO->exec("
            CREATE TABLE IF NOT EXISTS user (
              id          INT         NOT NULL AUTO_INCREMENT UNIQUE,
              login       VARCHAR(20) NOT NULL,
              password    VARCHAR(128),
              mail        VARCHAR(254),
              check_token VARCHAR(128),
              reset_token VARCHAR(128),
              reset_date  TIMESTAMP,
              is_verified INT NOT NULL DEFAULT 0,
              PRIMARY KEY (id))
              ENGINE = InnoDB;");

            $this->PDO->exec("
            CREATE TABLE IF NOT EXISTS post (
              id          INT       NOT NULL AUTO_INCREMENT UNIQUE,
              user_id     INT       NOT NULL,
              image       VARCHAR(100),
              description VARCHAR(256),
              post_date   TIMESTAMP NOT NULL DEFAULT now(),
              PRIMARY KEY (id),
              CONSTRAINT fk_user_id
              FOREIGN KEY (user_id)
              REFERENCES user (id))
              ENGINE = InnoDB;");

            $this->PDO->exec("
            CREATE TABLE IF NOT EXISTS comment (
              id           INT          NOT NULL AUTO_INCREMENT UNIQUE,
              post_id      INT          NOT NULL,
              `text`       VARCHAR(256) NOT NULL,
              comment_date TIMESTAMP    NOT NULL DEFAULT now(),
              PRIMARY KEY (id),
              CONSTRAINT fk_post_id
              FOREIGN KEY (post_id)
              REFERENCES post (id))
              ENGINE = InnoDB;");

            $this->PDO->exec("
            CREATE TABLE IF NOT EXISTS `like` (
              post_id      INT          NOT NULL,
              user_id      INT          NOT NULL,
              CONSTRAINT fk_like_post_id FOREIGN KEY (post_id) REFERENCES post(id),
              CONSTRAINT fk_like_user_id FOREIGN KEY (user_id) REFERENCES user(id))
              ENGINE = InnoDB;
            ");
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    private function hash_pw($pw) {
        return hash("SHA512", $pw);
    }

    private function generate_random_token() {
        return bin2hex(openssl_random_pseudo_bytes(16));
    }

    public function validNewMail ($mail) {
        return isset($mail) && filter_var($mail, FILTER_VALIDATE_EMAIL)
            && empty($this->get_mail($mail));
    }

    public function validNewPassword ($password) {
        return isset($password)
            && strlen($password) >= 8
            && preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $password);
    }

    public function validNewLogin ($login) {
        return isset($login) && strlen($login) >= 4
            && empty($this->get_user($login));
    }

    public function validChars ($login) {
        /*if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $login))*/
        if (preg_match('/[\\\]/', $login))
            return false;
        return true;
    }

    public function get_mail($mail) {
        try
        {
            $query = $this->PDO->prepare("
            SELECT * FROM user WHERE mail LIKE :mail");
            $query->execute(array(":mail" => $mail));
            return ($query->fetchAll());
        } catch (Exception $e) {
            return false;
        }
    }

    private function sendUserMail($mail, $subject, $message)
    {
        $headers =
            "From: noreply@{$this->SITE_ADDRESS}" . "\r\n" .
            "Reply-To: noreply@{$this->SITE_ADDRESS}" . "\r\n" .
            'X-Mailer: PHP/' . phpversion() .
            'MIME-Version: 1.0' . "\r\n" .
            'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        return mail($mail, $subject, $message, $headers);
    }

    public function newUser($login, $mail, $password)
    {
        try
        {
            $password = $this->hash_pw($password);
            $token = $this->generate_random_token();
            $query = $this->PDO->prepare("
                INSERT INTO user VALUES 
                (NULL, :login, :password, :mail, :token, NULL, NULL, 0);");
            $query->execute(array(
                ':login' => $login,
                ':password' => $password,
                ':mail' => $mail,
                ':token' => $token));
            $token =
                "http://{$this->SITE_ADDRESS}/index.php" .
                "?action=verify&user={$login}&token={$token}";
            $message =
                "<div style='
                text-align: center;
                background-color: #e98e4e;
                border-radius: 20px;
                color: whitesmoke;
                padding: 30px;'>" .
                "<h2 style='text-align: center; color: whitesmoke'>Hello {$login}</h2><br>
                To connect to your new account you need to click on this link<br>" .
                "<a style='color: whitesmoke' href=\"{$token}\">Validate account</a><br>" .
                "Or access this page on a web browser<br>{$token}</div>";
            if (!$this->sendUserMail($mail, 'Activate your Camagru account', $message))
            {
                $query = $this->PDO->prepare("
                  DELETE FROM user 
                  WHERE user.login LIKE :login;");
                $query->execute(array(":login" => $login));
                return false;
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function initiatePasswordReset ($mail) {
        try
        {
            if (empty($user = $this->get_mail($mail)[0]) || !isset($user['id']))
            {
                return false;
            }
            else
            {
                $token = $this->generate_random_token();
                $query = $this->PDO->prepare("
                    UPDATE user 
                    SET reset_token = :token AND reset_date = now() 
                    WHERE mail LIKE :mail");
                $query->execute(array(':token' => $token, ':mail' => $mail));
                $query = $query->rowCount();
                $token =
                    "http://{$this->SITE_ADDRESS}/index.php" .
                    "?action=reset&mail={$mail}&token={$token}";
                $message =
                    "<div style='
                text-align: center;
                background-color: #e98e4e;
                border-radius: 20px;
                color: whitesmoke;
                padding: 30px;'>" .
                    "<h2 style='text-align: center; color: whitesmoke'>Hello {$user["login"]}</h2><br>
                Someone asked to reset your password, if it's not you just ignore this email<br>" .
                    "<a style='color: whitesmoke' href=\"{$token}\">Reset Password</a><br>" .
                    "Otherwise click to the link to enter your new password</div>";
                return $query > 0
                    && $this->sendUserMail($mail, 'Password reset', $message);
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function verify_user ($login, $token) {
        try
        {
            if ($this->validChars($login)
                && !empty($user = $this->get_user($login)[0])
                && !$user["is_verified"] == 1)
            {
                $query = $this->PDO->prepare("
                    UPDATE user SET is_verified = 1 
                    WHERE login = :login 
                    AND check_token = :token");
                $query->execute(array(
                    ':login' => $login,
                    ':token' => $token));
                return ($query->rowCount() > 0);
            } else if (isset($user) && $user["is_verified"] == 1)
                return true;
        } catch (Exception $e) {
            return false;
        }
        return false;
    }

    public function get_user($login) {
        try
        {
            $query = $this->PDO->prepare("
              SELECT * FROM user WHERE login LIKE :login");
            $query->execute(array(":login" => $login));
            return ($query->fetchAll());
        } catch (Exception $e) {
            return false;
        }
    }

    public function authenticate ($login, $password) {
        try
        {
            if (!validChars($login) || $login === "" || $password === "")
                return false;
            $password = $this->hash_pw($password);
            $query = $this->PDO->prepare("
          SELECT * FROM user 
          WHERE user.login = :login 
          AND user.password = :password");
            $query->execute(array(':login' => $login, ':password' => $password));
            return !empty($query->fetchAll());
        } catch (Exception $e) {
            return false;
        }
    }
}