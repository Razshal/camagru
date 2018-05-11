<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . "/model/checks.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/model/class_database.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/config/database.php");

if ($DB_ERROR === false && isset($_POST)
    && isset($_POST["submit"]) && $_POST["submit"] === "Sign-in")
{
    $validMail = validNewMail($database, $_POST["mail"]);
    $validPass = validNewPassword($_POST["password"]);
    $validLogin = validNewLogin($database, $_POST["login"]);
    if ($validMail && $validPass && $validLogin)
        $querySuccess = $database->newUser($_POST["login"],
            $_POST["mail"], $_POST["password"]);
}
else if (isset($_POST["submit"]))
    $querySuccess = false;