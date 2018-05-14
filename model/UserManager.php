<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/model/DatabaseManager.php");

class UserManager extends DatabaseManager
{
    private function hash_pw($pw)
    {
        return hash("SHA512", $pw);
    }

    public function validNewMail($mail)
    {
        return isset($mail) && filter_var($mail, FILTER_VALIDATE_EMAIL)
            && empty($this->get_mail($mail));
    }

    public function validNewPassword($password)
    {
        return isset($password)
            && strlen($password) >= 8 && strlen($password) <= 127
            && preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $password);
    }

    public function validNewLogin($login)
    {
        return isset($login) && strlen($login) >= 4
            && empty($this->get_user($login));
    }

    public function validChars($login)
    {
        /*if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $login))*/
        if (preg_match('/[\\\]/', $login))
            return false;
        return true;
    }

    public function get_mail($mail)
    {
        try
        {
            $query = $this->PDO->prepare("
            SELECT * FROM user WHERE mail LIKE :mail");
            $query->execute(array(":mail" => $mail));
            return ($query->fetchAll());
        }
        catch (Exception $e)
        {
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
                (NULL, :login, :password, :mail, :token, :token, now(), now(), 0);");
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

    public function initiatePasswordReset($mail)
    {
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
                    WHERE mail = :mail");
                $query->execute(array(':token' => $token, ':mail' => $mail));
                $query = $query->rowCount();
                $tokenLink =
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
                    "Otherwise click to the link to set a new password</div>" .
                    "<a style='color: whitesmoke' href=\"{$tokenLink}\">Reset Password</a><br>";
                var_dump($query, $mail, $tokenLink, $token);
                return ($query > 0
                    && $this->sendUserMail($mail, 'Password reset', $message));
            }
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    public function verify_user($login, $token)
    {
        try
        {
            if ($this->validChars($login)
                && !empty($user = $this->get_user($login)[0])
                && !$user["is_verified"] == 1)
            {
                $query = $this->PDO->prepare("
                    UPDATE user SET is_verified = 1 
                    WHERE login LIKE :login 
                    AND check_token LIKE :token");
                $query->execute(array(
                    ':login' => $login,
                    ':token' => $token));
                return ($query->rowCount() > 0);
            }
            else if (isset($user) && $user["is_verified"] == 1)
                return true;
        }
        catch (Exception $e)
        {
            return false;
        }
        return false;
    }

    public function get_user($login)
    {
        try
        {
            $query = $this->PDO->prepare("
              SELECT * FROM user WHERE login LIKE :login");
            $query->execute(array(":login" => $login));
            return ($query->fetchAll());
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    public function authenticate($login, $password)
    {
        try
        {
            if (!$this->validChars($login) || $login === "" || $password === "")
                return false;
            $password = $this->hash_pw($password);
            $query = $this->PDO->prepare("
          SELECT * FROM user 
          WHERE user.login = :login 
          AND user.password = :password");
            $query->execute(array(':login' => $login, ':password' => $password));
            return !empty($query->fetchAll());
        }
        catch (Exception $e)
        {
            return false;
        }
    }
}