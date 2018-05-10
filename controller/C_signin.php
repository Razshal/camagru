<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . "/model/checks.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/model/set_database.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/config/database.php");

if ($DB_ERROR === false && isset($_POST) && $_POST["submit"] === "Sign-in") {
    $validMail = validNewMail($databasePDO, $_POST["mail"]);
    $validPass = validNewPassword($_POST["password"]);
    $validLogin = validNewLogin($databasePDO, $_POST["login"]);
    if ($validMail && $validPass && $validLogin)
        $querySuccess = newUser($databasePDO, $_POST["login"],
            $_POST["mail"], $_POST["password"]);
}
else if (isset($_POST["submit"]))
    $querySuccess = false;