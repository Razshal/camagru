<?php

function get_user($databasePDO, $login) {
    $query = $databasePDO->query("
    SELECT * FROM user WHERE login LIKE '{$login}'");
    if ($query == NULL)
        return false;
    else {
        return $query->fetchAll();
    }
}

function get_mail($databasePDO, $mail) {
    $query = $databasePDO->query("
    SELECT * FROM user WHERE mail LIKE '{$mail}'");
    if ($query == NULL)
        return false;
    else {
        return $query->fetchAll();
    }
}

