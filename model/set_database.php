<?php

include_once ("../controller/tools.php");
include_once ("../config/site.php");

function newUser($database, $login, $mail, $password) {
    $password = hash_pw($password);
    $token = bin2hex(openssl_random_pseudo_bytes(16));
    $database->prepare("
    INSERT INTO user VALUES (NULL, :login, 0, :password, :mail, :token, 0);");
    $usccess =
        $database->exec(array(
            ':login' => $login,
            ':password' => $password,
            ':mail' => $mail,
            ':token' => $token));
    $token =
        "http://{$GLOBALS["httpAddress"]}/views/verify.php" .
        "?action=verify&user={$login}&token={$token}";
    echo "<a href=\"{$token}\">Token</a>";
    $subject = 'Activate your Camagru account';
    $message =
        "Hello, to connect to your new account you need to click on this link" .
        "<a href=\"{$token}\">Validate account</a><br>" .
        "Or to access this page on your web browser {$token}";
    $headers =
        "From: webmaster@{$GLOBALS["siteAddress"]}.com" . "\r\n" .
        'Reply-To: webmaster@{$GLOBALS["siteAddress"]}.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion() .
        'MIME-Version: 1.0' . "\r\n" .
        'Content-type: text/html; charset=iso-8859-1' . "\r\n";

/*    if (!mail($mail, $subject, $message, $headers)) {
        $success = -3;
        $database->exec("DELETE FROM user 
        WHERE user.login LIKE '{$login}';");
    }*/
    return $success;
}