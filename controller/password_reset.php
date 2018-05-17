<?php
if (isset($_POST) && isset($_POST["mail"]) && isset($_POST["submit"])
    && $_POST["submit"] === "Reset")
{
    if (!empty($user = $userManager->get_mail($_POST["mail"]))
        && $userManager->initiatePasswordReset($_POST["mail"]))
        $info = $info . "<h2 class='success'>Reset account mail sent</h2>";
    else
        $info = $info . "<h2 class='error'>Unable to send reset mail, 
        check if your mail is valid</h2>";
    require ($_SERVER["DOCUMENT_ROOT"] . "/views/ask_password_reset.php");
}
else if (isset($_GET["token"]) && isset($_GET["mail"]))
{
    if (!empty($user = $userManager->get_mail($_GET["mail"]))
        && $user[0]["reset_token"] === $_GET["token"])
    {
        require ($_SERVER["DOCUMENT_ROOT"] . "/views/chose_new_password.php");
    }
    else
        $info = $info . "<p class='error'>Wrong token/mail</p>";
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
            $info = $info . "<p class='error'>Invalid password, must be between 8 and 127 
                            chars with at least a digit and a letter</p>";
        else if (!$userManager->reset_password($_POST["mail"], $_POST["password"]))
            $info = $info . "<p class='error'>Error reseting your password, please retry</p>";
        else
            $info = $info . "<p class='success'>Password reseted</p>";
    }
    else
        $info = $info . "<p class='error'>Invalid token</p>";
}
else
    require ($_SERVER["DOCUMENT_ROOT"] . "/views/ask_password_reset.php");