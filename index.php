<?php
session_start();
require_once "config/database.php";
require_once "config/site.php";
require_once "model/UserManager.php";
require_once "model/SessionManager.php";
require_once "model/PostManager.php";
require_once "model/SiteManager.php";
date_default_timezone_set("Europe/Paris");

/************* Managers init ************/

$title = "Camagru";
$content = "<h2>Welcome To Camagru</h2>";

try
{
    $siteManager = new siteManager();
    $userManager = new UserManager($DB_DSN, $DB_USER, $DB_PASSWORD,
        $SITE_ADDRESS, $RESET_PASSWORD_TOKEN_VALIDITY);
    $postManager = new PostManager($DB_DSN, $DB_USER, $DB_PASSWORD,
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
    switch($_GET["action"])
    {
        case 'login':
            require 'controller/login.php';
            break;
        case 'logout':
            $sessionManager->log_out_user();
            header('location: index.php');
            die();
        case 'setup':
            require 'config/setup.php';
            break;
        case 'signin':
            require 'controller/signin.php';
            break;
        case 'verify':
            if (isset($_GET["user"]) && isset($_GET["token"])
                && $userManager->verify_user($_GET["user"], $_GET["token"]))
                $siteManager->success_log("Account activated");
            else
                $siteManager->error_log("Error wrong token/login");
            break;
        case 'reset':
            require 'controller/password_reset.php';
            break;
        case 'account':
            if ($sessionManager->is_logged_user_valid())
                require 'controller/change_account.php';
            else
                require 'controller/login.php';
            break;
        case 'post':
            if ($sessionManager->is_logged_user_valid())
                require 'controller/post.php';
            else
            {
                header('location: index.php?action=login');
                die();
            }
            break;
        case 'getUserPosts':
            require 'controller/API_get_user_posts.php';
            break;
        case 'getFilters':
            require 'controller/API_get_filters.php';
            break;
        case 'whoAmI':
            require 'controller/API_who_am_i.php';
            break;
        case 'getAllPosts':
            require 'controller/API_get_all_posts.php';
            break;
        case 'deletePost':
            require 'controller/delete_post.php';
            break;
        default:
            $content = "Error 404 : This page doesn't exists";
            header('HTTP/1.1 404 Not Found');
    }
}
require 'views/structure/template.php';