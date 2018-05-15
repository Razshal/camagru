<?php
session_start();
require_once ("config/database.php");
require_once ("config/site.php");
require_once ("model/UserManager.php");
require_once ("model/SessionManager.php");
date_default_timezone_set ( "Europe/Paris");

$title = "Camagru";
$content = "<h2>Welcome To Camagru</h2>";
$info = "";

try {
    $userManager = new UserManager($DB_DSN, $DB_USER, $DB_PASSWORD,
        $SITE_ADDRESS, $RESET_PASSWORD_TOKEN_VALIDITY);
    $sessionManager = new SessionManager($userManager);

    if (!$sessionManager->is_logged_user_valid())
            $sessionManager->log_out_user();
}
catch (Exception $e)
{
    $userManager = NULL;
    $sessionManager = NULL;
    $info = "<h1 class='error'>Fatal database error</h1><br>";
    $info = $DB_ERROR;
}

/************* Router ************/

if ($userManager != NULL && $sessionManager != NULL
    && isset($_GET) && isset($_GET["action"]))
{
    if ($_GET["action"] === "login") {
        require("controller/login.php");
    }
    else if ($_GET["action"] === "logout") {
        $sessionManager->log_out_user();
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
            && $userManager->verify_user($_GET["user"], $_GET["token"]))
            $info = $info . "<h2 class='success'>Account activated</h2><br>";
        else
            $info = $info . "<h2 class='error'>Error wrong token/login</h2><br>";
        $content = "";
    }
    else if ($_GET["action"] === "reset") {
        require("controller/password_reset.php");
    }
    else if ($_GET["action"] === "account") {
        require ("views/account.php");
    }
}
require ("views/structure/template.php");