<?php

function validNewMail ($databasePDO, $mail) {
    return isset($mail) && filter_var($mail, FILTER_VALIDATE_EMAIL)
        && empty(get_mail($databasePDO, $mail));
}

function validNewPassword ($password) {
    return isset($password)
        && strlen($password) >= 8
        && preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $password);
}

function validNewLogin ($databasePDO, $login) {
    return isset($login) && strlen($login) >= 4
        && empty(get_user($databasePDO, $login));
}

function validChars ($login) {
    /*if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $login))*/
    if (preg_match('/[\\\]/', $login))
        return false;
    return true;
}

/*
function is_there_admins($database_pdo)
{
    return !!$database_pdo->query("
              SELECT * FROM user WHERE user.isAdmin LIKE 1");
}
*/