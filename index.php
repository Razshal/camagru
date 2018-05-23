<?php
session_start();
require_once ("config/database.php");
require_once ("config/site.php");
require_once ("model/UserManager.php");
require_once ("model/SessionManager.php");
require_once ("model/siteManager.php");
date_default_timezone_set ( "Europe/Paris");

$title = "Camagru";
$content = "<h2>Welcome To Camagru</h2>";

try {
    $userManager = new UserManager($DB_DSN, $DB_USER, $DB_PASSWORD,
        $SITE_ADDRESS, $RESET_PASSWORD_TOKEN_VALIDITY);
    $sessionManager = new SessionManager($userManager);
    $siteManager = new siteManager();

    if (!$sessionManager->is_logged_user_valid())
            $sessionManager->log_out_user();
}
catch (Exception $e)
{
    $userManager = NULL;
    $sessionManager = NULL;
    $info = $DB_ERROR;
    $content = "";
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
            $siteManager->success_log("Account activated");
        else
            $siteManager->error_log("Error wrong token/login");
        $content = "";
    }
    else if ($_GET["action"] === "reset") {
        require("controller/password_reset.php");
    }
    else if ($_GET["action"] === "account") {
        if (!$sessionManager->is_logged_user_valid())
            require ("controller/signin.php");
        else
            require ("views/account.php");
    }
}
require ("views/structure/template.php");