<?php
if (isset($_POST) && isset($_POST["oldPassword"])
    && $_POST["oldPassword"] !== "" && $userManager->authenticate(
        $sessionManager->get_logged_user_name(), $_POST["oldPassword"]))
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
            $siteManager->error_log("Unable to change login, login maybe already existing.
            <br>{$siteManager->login_policy()}");
    }
    if (isset($_POST["newPassword"]) && $_POST["newPassword"] !== "")
    {
        if ($userManager->change_password(
            $sessionManager->get_logged_user_name(), $_POST["newPassword"]))
            $siteManager->success_log("Password changed");
        else
            $siteManager->error_log("Cannot change your password.
            <br>{$siteManager->password_policy()}");

    }
    if (isset($_POST["mail"]) && $_POST["mail"] !== ""
        && $_POST["mail"] !== $userManager->get_user($sessionManager->get_logged_user_name())["mail"])
    {
        if ($userManager->change_mail($sessionManager->get_logged_user_name(), $_POST["mail"]))
            $siteManager->success_log("Mail changed");
        else
            $siteManager->error_log("Unable to change mail : mail is not valid");
    }
    if (isset($_POST["notifications"]))
        $userManager->toggle_notifications($sessionManager->get_logged_user_name(), 1);
    else
        $userManager->toggle_notifications($sessionManager->get_logged_user_name(), 0);
}
else if (isset($_POST) && !isset($_POST['oldPassword']))
    $siteManager->error_log('Please confirm password');
require ($DOCUMENT_ROOT . "/views/account.php");