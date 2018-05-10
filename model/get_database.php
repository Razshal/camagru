<?php

function get_user($databasePDO, $login) {
    try {
        $query = $databasePDO->query("
        SELECT * FROM user WHERE login LIKE '{$login}'");
        return ($query == NULL ? false : $query->fetchAll());
    } catch (Exception $e) {
        return false;
    }
}

function get_mail($databasePDO, $mail) {
    try {
        $query = $databasePDO->query("
        SELECT * FROM user WHERE mail LIKE '{$mail}'");
        return ($query == NULL ? false : $query->fetchAll());
    } catch (Exception $e) {
    return false;
    }
}