<?php
session_start();
require_once ("config/database.php");
require_once ("config/site.php");
require_once ("model/class_database.php");

$title = "Camagru";
$content = "<h2>Welcome To Camagru</h2>";

try {
    $database = new Database($DB_DSN, $DB_USER, $DB_PASSWORD, $SITE_ADDRESS);
    if (isset($_SESSION) && isset($_SESSION["user"])
        && $_SESSION["user"] != ""
        && $database != NULL && empty($database->get_user($_SESSION["user"])))
            $_SESSION["user"] = "";
} catch (Exception $e) {
    $database = NULL;
    $info = "<h1 class='error'>Fatal database error</h1><br>";
}

if ($database === NULL)
    $info = $DB_ERROR;

/************* Router ************/

if (isset($_GET) && isset($_GET["action"]))
{
    if ($_GET["action"] === "login") {
        if (isset($_POST)
            && isset($_POST["submit"]) && $_POST["submit"] === "Login"
            && isset($_POST["login"]) && isset($_POST["password"])
            && ($auth = $database->authenticate(
                $_POST["login"], $_POST["password"])))
            $_SESSION["user"] = $_POST["login"];
        require("controller/login.php");
    }
    else if ($_GET["action"] === "logout") {
        if ($database !== NULL) {
            if (isset($_SESSION)
                && isset($_SESSION["user"]) && $_SESSION["user"] != "")
                $_SESSION["user"] = "";
        }
        header('location: index.php');
        die();
    }
    else if ($_GET["action"] === "setup") {
        require ("config/setup.php");
    }
    else if ($_GET["action"] === "signin") {
        require("controller/signin.php");
    }
    else if ($_GET["action"] === "verify") {
        $done = 0;
        if (isset($_GET["user"]) && isset($_GET["token"])
            && $database->verify_user($_GET["user"], $_GET["token"]))
            $info = $info . ("<h2 class='success'>Account activated</h2><br>");
        else
            $info = $info . ("<h2 class='error'>Error wrong token/login</h2><br>");;
    }
    else if ($_GET["action"] === "reset") {
        require("controller/password_reset.php");

    }
    else if ($_GET["action"] === "account") {
        require ("views/account.php");
    }
}
require ("views/structure/template.php");