<?php
if (isset($_POST) && isset($_POST["mail"]) && isset($_POST["submit"])
    && $_POST["submit"] === "Reset")
{
    if (!empty($user = $userManager->get_mail($_POST["mail"]))
        && $userManager->initiatePasswordReset($_POST["mail"]))
        $siteManager->success_log("Reset account mail sent");
    else
        $siteManager->error_log("Unable to send reset mail, 
        check if your mail is valid");
    require ($DOCUMENT_ROOT . "views/ask_password_reset.php");
}
else if (isset($_GET["token"]) && isset($_GET["mail"]))
{
    if (!empty($user = $userManager->get_mail($_GET["mail"]))
        && $user[0]["reset_token"] === $_GET["token"])
    {
        require ($DOCUMENT_ROOT . "views/chose_new_password.php");
    }
    else
        $siteManager->error_log("Wrong token/mail");
}
else if (isset($_POST) && isset($_POST["submit"])
    && isset($_POST["mail"]) && isset($_POST["password"])
    && isset($_POST["submit"]) && $_POST["submit"] === "Change")
{
    $content = "";
    if (!empty($user = $userManager->get_mail($_POST["mail"]))
        && $user[0]["reset_token"] === $_POST["token"]
        && $userManager->is_reset_token_still_valid($_POST["mail"]))
    {
        if (!$userManager->validNewPassword($_POST["password"]))
            $siteManager->error_log("Invalid password, must be between 8 and 127 
                            chars with at least a digit and a letter");
        else if (!$userManager->reset_password($_POST["mail"], $_POST["password"]))
            $siteManager->error_log("Error reseting your password, please retry");
        else
            $siteManager->success_log("Password reseted");
    }
    else
        $siteManager->error_log("Invalid token");
}
else
    require ($DOCUMENT_ROOT . "views/ask_password_reset.php");