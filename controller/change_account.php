<?php
if (isset($_POST) && isset($_POST["oldPassword"])
    && $_POST["oldPassword"] !== "" && $userManager->authenticate(
        $sessionManager->get_logged_user_name(),
        $_POST["oldPassword"]))
{
    if (isset($_POST["login"]) && $_POST["login"] !== ""
        && $_POST["login"] !== $sessionManager->get_logged_user_name())
    {
        $loginChange = $userManager->change_login(
            $sessionManager->get_logged_user_name(), $_POST["login"]);
        if ($loginChange)
            $sessionManager->update_user_name($_POST["login"]);
    }
    if (isset($_POST["newPassword"]) && $_POST["newPassword"] !== "")
        $passwordChange = $userManager->change_password(
            $sessionManager->get_logged_user_name(), $_POST["newPassword"]);
    if (isset($_POST["mail"]) && $_POST["mail"] !== ""
        && $_POST["mail"] !== $userManager->get_user($sessionManager->get_logged_user_name())["mail"])
        $mailChange = $userManager->change_mail(
            $sessionManager->get_logged_user_name(), $_POST["mail"]);
}