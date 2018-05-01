<?php

function get_user($database_PDO, $login) {
    return $database_PDO->query("
    SELECT login FROM user WHERE login LIKE '{$login}'");
}

function get_mail($database_PDO, $mail) {
    return $database_PDO->query("
    SELECT * FROM user WHERE `mail` LIKE '{$mail}'");
}

