<?php

include_once ($_SERVER["DOCUMENT_ROOT"] . "/model/checks.php");
$databaseError = "<p class='error'>Fatal error, cannot access database</p>";

function hash_pw($pw) {
    return hash("SHA512", $pw);
}

function authenticate ($databasePDO, $login, $password) {
    try {
        if (!validChars($login))
            return false;
        $password = hash_pw($password);
        $query = $databasePDO->prepare("
          SELECT * FROM user 
          WHERE login LIKE ':login' 
          AND password LIKE ':password'");
        $query = $query->execute(array(':login' => $login, ':password' => $password));
        return $query;
    } catch (Exception $e) {
        return false;
    }
}
//TODO https://stackoverflow.com/questions/16381365/difference-between-pdo-query-and-pdo-exec