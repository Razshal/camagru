<?php

$databaseError = "<p class='error'>Fatal error, cannot access database</p>";
$GLOBALS["httpAddress"] = "192.168.99.100";

function hash_pw($pw) {
    return hash("SHA512", $pw);
}

function authenticate ($databasePDO, $login, $password) {
    $password = hash_pw($password);
    $query = $databasePDO->query("
    SELECT * FROM user WHERE login LIKE '{$login}' AND password LIKE '{$password}'");
    return !empty($query->fetchAll());
}