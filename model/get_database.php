<?php

function get_user($databasePDO, $login) {
    $query = $databasePDO->query("
    SELECT * FROM user WHERE login LIKE '{$login}'");
    return ($query == NULL ? false : $query->fetchAll());
}

function get_mail($databasePDO, $mail) {
    $query = $databasePDO->query("
    SELECT * FROM user WHERE mail LIKE '{$mail}'");
    return ($query == NULL ? false : $query->fetchAll());
}

