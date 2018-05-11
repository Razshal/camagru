<?php
session_start();
require_once ("config/database.php");
require_once ("config/site.php");
require_once ("model/class_database.php");
require_once ("model/checks.php");

$title = "Camagru";
$content = "<h2>Welcome To Camagru</h2>";

try {
    $database = new Database($DB_DSN, $DB_USER, $DB_PASSWORD, $SITE_ADDRESS);
    if (isset($_SESSION) && isset($_SESSION["user"]) && $_SESSION["user"] != "")
        if (empty($database->get_user($_SESSION["user"])))
            $_SESSION["user"] = "";
} catch (Exception $e) {
    $database = NULL;
    echo "<h1 class='error'>Fatal database error</h1>";
}

/************* Router ************/

if (isset($_GET) && isset($_GET["action"]))
{
    if ($_GET["action"] === "login")
    {
        if (isset($_POST)
            && isset($_POST["submit"]) && $_POST["submit"] === "Login"
            && isset($_POST["login"]) && isset($_POST["password"])
            && ($auth = $database->authenticate(
                $_POST["login"], $_POST["password"])))
            $_SESSION["user"] = $_POST["login"];
        require ("views/login.php");
    }

    else if ($_GET["action"] === "logout")
    {
        if ($database !== NULL) {
            if (isset($_SESSION)
                && isset($_SESSION["user"]) && $_SESSION["user"] != "")
                $_SESSION["user"] = "";
        }
        header('location: index.php');
        die();
    }

    else if ($_GET["action"] === "setup")
    {
        if ($database !== NULL)
            $success = $database->initiate();
        else
            $success = false;
        require ("config/setup.php");
    }

    else if ($_GET["action"] === "signin")
    {
        if ($database !== NULL && isset($_POST)
            && isset($_POST["submit"])
            && $_POST["submit"] === "Sign-in")
        {
            $validMail = validNewMail($database, $_POST["mail"]);
            $validPass = validNewPassword($_POST["password"]);
            $validLogin = validNewLogin($database, $_POST["login"]);
            if ($validMail && $validPass && $validLogin)
            {
                $querySuccess = $database->newUser($_POST["login"],
                    $_POST["mail"], $_POST["password"]);
            }
        }
        else if (isset($_POST["submit"]))
            $querySuccess = false;
        require ("views/signin.php");
    }

    else if ($_GET["action"] === "verify")
    {
        $done = 0;
        if (isset($_GET) && isset($_GET["user"]) && isset($_GET["token"]))
            $done = $database->verify_user($_GET["user"], $_GET["token"]);
        else
            $done = false;
        require ("views/verify.php");
    }

    else if ($_GET["action"] === "reset")
    {


    }
    else if ($_GET["action"] === "account") {
        require ("views/account.php");
    }
}
require ("views/structure/template.php");