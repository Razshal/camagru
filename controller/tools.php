<?php

function hash_pw($pw) {
    return hash("SHA512", $pw);
}

function authenticate ($databasePDO, $login, $password) {
    $password = hash_pw($password);
    $query = $databasePDO->query("
    SELECT * FROM user WHERE login LIKE '{$login}' AND password LIKE '{$password}'");
    var_dump($query->fetchAll());
    return !empty($query->fetchAll());
}