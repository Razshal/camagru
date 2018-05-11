<?php

include_once ($_SERVER["DOCUMENT_ROOT"] . "/controller/tools.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/model/checks.php");

class Database
{
    private $PDO = NULL;
    private $SITE_ADDRESS = NULL;

    public function __construct($DB_DSN, $DB_USER, $DB_PASSWORD, $SITE_ADDRESS)
    {
        try {
            $this->PDO = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            $this->SITE_ADDRESS = $SITE_ADDRESS;
        } catch (Exception $exception) {
            throw new Exception("Cannot connect to database");
        }
    }

    private function hash_pw($pw) {
        return hash("SHA512", $pw);
    }

    private function sendUserCheckMail($login, $mail, $token)
    {
        $token =
            "http://{$this->SITE_ADDRESS}/views/verify.php" .
            "?action=verify&user={$login}&token={$token}";
        $subject = 'Activate your Camagru account';
        $message =
            "<div style='
                text-align: center;
                background-color: #e98e4e;
                border-radius: 20px;
                color: whitesmoke;
                padding: 30px;
        '>" .
            "<h2 style='text-align: center; color: whitesmoke'>Hello {$login}</h2><br>
        To connect to your new account you need to click on this link<br>" .
            "<a style='color: whitesmoke' href=\"{$token}\">Validate account</a><br>" .
            "Or access this page on a web browser<br>{$token}</div>";
        $headers =
            "From: noreply@{$this->SITE_ADDRESS}.com" . "\r\n" .
            "Reply-To: noreply@{$this->SITE_ADDRESS}.com" . "\r\n" .
            'X-Mailer: PHP/' . phpversion() .
            'MIME-Version: 1.0' . "\r\n" .
            'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        if (!($success = mail($mail, $subject, $message, $headers))) {
            try {
                $query = $this->PDO->prepare("
                    DELETE FROM user 
                    WHERE user.login LIKE :login;");
                $query->execute(array(":login" => $login));
            } catch (Exception $e) {
                return false;
            }
        }
        return $success;
    }

    public function newUser($login, $mail, $password)
    {
        try {
            $password = $this->hash_pw($password);
            $token = bin2hex(openssl_random_pseudo_bytes(16));
            $query = $this->PDO->prepare("
        INSERT INTO user VALUES 
        (NULL, :login, 0, :password, :mail, :token, 0);");
            $success = $query->execute(array(
                ':login' => $login,
                ':password' => $password,
                ':mail' => $mail,
                ':token' => $token));
            return $success && $this->sendUserCheckMail($login, $mail, $token);
        } catch (Exception $e) {
            return false;
        }
    }

    public function verify_user ($login) {
        if (validChars($login) && !empty($this->get_user($login))) {
            $query = $this->PDO->prepare("
            UPDATE user 
            SET is_verified = 1 
            WHERE login = :login");
            $query->execute(array(':login' => $_GET["user"]));
            return (!empty($query->fetchAll()));
        }
        return false;
    }

    public function get_user($login) {
        try {
            $query = $this->PDO->query("
            SELECT * FROM user WHERE login LIKE '{$login}'");
            return ($query == NULL ? false : $query->fetchAll());
        } catch (Exception $e) {
            return false;
        }
    }

    public function get_mail($mail) {
        try {
            $query = $this->PDO->query("
            SELECT * FROM user WHERE mail LIKE '{$mail}'");
            return ($query == NULL ? false : $query->fetchAll());
        } catch (Exception $e) {
            return false;
        }
    }

    public function authenticate ($login, $password) {
        try {
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