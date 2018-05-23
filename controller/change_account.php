<?php
if (isset($_POST) && isset($_POST["oldPassword"])
    && $_POST["oldPassword"] !== "" && $userManager->authenticate(
        $sessionManager->get_logged_user_name(),
        $_POST["oldPassword"]))
{
    if (isset($_POST["login"]) && $_POST["login"] !== ""
        && $_POST["login"] !== $sessionManager->get_logged_user_name())
    {
        if ($userManager->change_login(
            $sessionManager->get_logged_user_name(), $_POST["login"]))
        {
            $sessionManager->update_user_name($_POST["login"]);
            $siteManager->success_log("Login changed");
        }
        else
            $siteManager->error_log("Unable to change login, login maybe already existing");
    }
    if (isset($_POST["newPassword"]) && $_POST["newPassword"] !== "")
    {
        if ($userManager->change_password(
            $sessionManager->get_logged_user_name(), $_POST["newPassword"]))
            $siteManager->success_log("Password changed");
        else
            $siteManager->error_log("Cannot change your password");

    }
    if (isset($_POST["mail"]) && $_POST["mail"] !== ""
        && $_POST["mail"] !== $userManager->get_user($sessionManager->get_logged_user_name())["mail"])
        $mailChange = $userManager->change_mail(
            $sessionManager->get_logged_user_name(), $_POST["mail"]);
}