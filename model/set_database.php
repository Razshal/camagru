<?php

include_once ("../controller/tools.php");

function new_user($database, $login, $mail, $password) {
    $password = hash_pw($password);
    return $database->exec("
    INSERT INTO user VALUES (NULL, '{$login}', 0, '{$password}', '{$mail}');
    ");
}