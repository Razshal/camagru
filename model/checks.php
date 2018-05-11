<?php

function validNewMail ($database, $mail) {
    return isset($mail) && filter_var($mail, FILTER_VALIDATE_EMAIL)
        && empty($database->get_mail($mail));
}

function validNewPassword ($password) {
    return isset($password)
        && strlen($password) >= 8
        && preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $password);
}

function validNewLogin ($database, $login) {
    return isset($login) && strlen($login) >= 4
        && empty($database->get_user($login));
}

function validChars ($login) {
    /*if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $login))*/
    if (preg_match('/[\\\]/', $login))
        return false;
    return true;
}