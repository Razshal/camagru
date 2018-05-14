<?php
if ($database !== NULL && isset($_POST)
    && isset($_POST["submit"])
    && $_POST["submit"] === "Sign-in")
{
    $validMail = $database->validNewMail($_POST["mail"]);
    $validPass = $database->validNewPassword($_POST["password"]);
    $validLogin = $database->validNewLogin($_POST["login"]);
    if ($validMail && $validPass && $validLogin)
    {
        $querySuccess = $database->newUser($_POST["login"],
            $_POST["mail"], $_POST["password"]);
    }
}
else if (isset($_POST["submit"]))
    $querySuccess = false;
if (isset($validMail) && !$validMail)
    $info = ("<h2 class='error'>Mail is already in use or not valid</h2>");
if (isset($validLogin) && !$validLogin)
    $info = ("<h2 class='error'>Login is already in use or not valid 
                   (4 chars >= login <= 20 chars)</h2>");
if (isset($validPass) && !$validPass)
    $info = ("<h2 class='error'>Password must be at least 8 long and
                   contains at least one letter and one digit</h2>");
if (isset($querySuccess) && $querySuccess === false)
    $info = ("<h2 class='error'>Error during user creation, please retry</h2>");
else if (isset($querySuccess) && $querySuccess === true)
    $info = ("<h2 class='success'>Account created</h2>");

require ($_SERVER["DOCUMENT_ROOT"] . "/views/signin.php");