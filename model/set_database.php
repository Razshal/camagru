<?php

include_once ("../controller/tools.php");

function newUser($database, $login, $mail, $password) {
    $password = hash_pw($password);
    $token = bin2hex(openssl_random_pseudo_bytes(16));
    return $database->exec("
    INSERT INTO user VALUES (NULL, '{$login}', 0, '{$password}', '{$mail}', '{$token}', 0);
    ");
}