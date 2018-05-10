<?php

include_once ($_SERVER["DOCUMENT_ROOT"] . "/controller/tools.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/config/site.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/config/site.php");

function sendUserCheckMail ($database, $login, $mail, $token) {
    $token =
        "http://{$GLOBALS["httpAddress"]}/views/verify.php" .
        "?action=verify&user={$login}&token={$token}";
    echo "<a href=\"{$token}\">Token</a>";
    $subject = 'Activate your Camagru account';
    $message =
        "Hello {$login}, to connect to your new account you need to click on this link" .
        "<a href=\"{$token}\">Validate account</a><br>" .
        "Or to access this page on your web browser {$token}";
    $headers =
        "From: noreply@{$GLOBALS["siteAddress"]}.com" . "\r\n" .
        "Reply-To: noreply@{$GLOBALS["siteAddress"]}.com" . "\r\n" .
        'X-Mailer: PHP/' . phpversion() .
        'MIME-Version: 1.0' . "\r\n" .
        'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    if (!($success = mail($mail, $subject, $message, $headers))) {
        try {
            $query = $database->prepare("DELETE FROM user WHERE user.login LIKE :login;");
            $query->execute(array(":login" => $login));
        } catch (Exception $e) {
            return false;
        }
    }
    return $success;
}

function newUser($database, $login, $mail, $password) {
    try {
        $password = hash_pw($password);
        $token = bin2hex(openssl_random_pseudo_bytes(16));
        $query = $database->prepare("
    INSERT INTO user VALUES (NULL, :login, 0, :password, :mail, :token, 0);");
        $success = $query->execute(array(
            ':login' => $login,
            ':password' => $password,
            ':mail' => $mail,
            ':token' => $token));
        return $success && sendUserCheckMail($database, $login, $mail, $token);
    } catch (Exception $e) {
        return false;
    }
}