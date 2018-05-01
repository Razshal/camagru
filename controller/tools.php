<?php

function hash_pw($pw) {
    return hash("SHA512", $pw);
}

function authenticate ($databasePDO, $login, $password) {
    $password = hash_pw($password);
    $query = $databasePDO->query("
    SELECT login FROM user WHERE login LIKE '{$login}' AND password LIKE '{$password}'");
    return !empty($query->fetchAll());
}