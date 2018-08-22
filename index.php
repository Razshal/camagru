<?php
session_start();
require_once ("config/database.php");
require_once ("config/site.php");
require_once ("model/UserManager.php");
require_once ("model/SessionManager.php");
require_once ("model/siteManager.php");
date_default_timezone_set("Europe/Paris");

/************* Manager and page init ************/

$title = "Camagru";
$content = "<h2>Welcome To Camagru</h2>";

try
{
    $siteManager = new siteManager();
    $userManager = new UserManager($DB_DSN, $DB_USER, $DB_PASSWORD,
        $SITE_ADDRESS, $RESET_PASSWORD_TOKEN_VALIDITY);
    $sessionManager = new SessionManager($userManager);
}
catch (Exception $e)
{
    $userManager = NULL;
    $sessionManager = NULL;
    $siteManager->strong_error_log($DB_ERROR);
    $content = "";
}

if (!$sessionManager->is_logged_user_valid())
    $sessionManager->log_out_user();

/************* Router ************/

if ($userManager != NULL && $sessionManager != NULL
    && isset($_GET) && isset($_GET["action"]))
{
    $content = "";
    if ($_GET["action"] === "login")
        require("controller/login.php");
    else if ($_GET["action"] === "logout")
    {
        $sessionManager->log_out_user();
        header('location: index.php');
        die();
    }
    else if ($_GET["action"] === "setup")
        require("config/setup.php");
    else if ($_GET["action"] === "signin")
        require("controller/signin.php");
    else if ($_GET["action"] === "verify")
    {
        if (isset($_GET["user"]) && isset($_GET["token"])
            && $userManager->verify_user($_GET["user"], $_GET["token"]))
            $siteManager->success_log("Account activated");
        else
            $siteManager->error_log("Error wrong token/login");
        $content = "";
    }
    else if ($_GET["action"] === "reset")
        require("controller/password_reset.php");
    else if ($_GET["action"] === "account" && $sessionManager->is_logged_user_valid())
        require("controller/change_account.php");
    else if ($_GET["action"] === "post")
    {
        if ($sessionManager->is_logged_user_valid())
            require("controller/post.php");
        else
        {
            header('location: index.php?action=login');
            die();
        }
    }
    else if ($_GET['action'] === 'getUserPosts' && isset($_GET['user'])
        && $sessionManager->is_logged_user_valid()
        && $posts = $userManager->get_user_posts($_GET['user']))
    {
        header('Content-Type: application/json;charset=utf-8');
        echo json_encode($posts);
        die();
    }
}
require ("views/structure/template.php");