<?php

function valid_mail ($mail) {
    return isset($mail) && filter_var($mail, FILTER_VALIDATE_EMAIL);
}

function valid_new_password ($password) {
    return isset($password)
        && strlen($password) >= 8
        && preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $password);
}

function valid_login ($login) {
    return isset($login) && strlen($login) >= 5;
}

/*
function is_there_admins($database_pdo)
{
    return !!$database_pdo->query("
              SELECT * FROM user WHERE user.isAdmin LIKE 1");
}
*/