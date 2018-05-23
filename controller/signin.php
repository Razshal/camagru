<?php
if ($userManager !== NULL && isset($_POST)
    && isset($_POST["submit"])
    && $_POST["submit"] === "Sign-in")
{
    $validMail = $userManager->validNewMail($_POST["mail"]);
    $validPass = $userManager->validNewPassword($_POST["password"]);
    $validLogin = $userManager->validNewLogin($_POST["login"]);
    if ($validMail && $validPass && $validLogin)
    {
        $querySuccess = $userManager->newUser($_POST["login"],
            $_POST["mail"], $_POST["password"]);
    }
}
else if (isset($_POST["submit"]))
    $querySuccess = false;
if (isset($validMail) && !$validMail)
    $siteManager->error_log("Mail is already in use or not valid");
if (isset($validLogin) && !$validLogin)
    $siteManager->error_log("Login is already in use or not valid, {$siteManager->login_policy()}");
if (isset($validPass) && !$validPass)
    $siteManager->error_log("{$siteManager->password_policy()}");
if (isset($querySuccess) && $querySuccess === false)
    $siteManager->error_log("Error during user creation, please retry");
else if (isset($querySuccess) && $querySuccess === true)
    $siteManager->success_log("Account created");

require($_SERVER["DOCUMENT_ROOT"] . "/views/signin_form.php");