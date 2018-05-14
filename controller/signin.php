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
    $info = $info . ("<h2 class='error'>Mail is already in use or not valid</h2><br>");
if (isset($validLogin) && !$validLogin)
    $info = $info . ("<h2 class='error'>Login is already in use or not valid 
                   (4 chars >= login <= 20 chars)</h2><br>");
if (isset($validPass) && !$validPass)
    $info = $info . ("<h2 class='error'>Password must be at least 8 long and
                   contains at least one letter and one digit</h2><br>");
if (isset($querySuccess) && $querySuccess === false)
    $info = $info . ("<h2 class='error'>Error during user creation, please retry</h2><br>");
else if (isset($querySuccess) && $querySuccess === true)
    $info = $info . ("<h2 class='success'>Account created</h2><br>");

require($_SERVER["DOCUMENT_ROOT"] . "/views/signin_form.php");