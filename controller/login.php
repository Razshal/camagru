<?php
if (isset($_POST)
    && isset($_POST["submit"]) && $_POST["submit"] === "Login"
    && isset($_POST["login"]) && isset($_POST["password"]))
    $auth = $sessionManager->log_in_user($_POST["login"], $_POST["password"]);
if (isset($auth) && $auth === false)
    $siteManager->error_log("Unable to connect, check you username/password and if your account is activated");
else if ($sessionManager->is_logged_user_valid())
    $siteManager->success_log("Logged as {$sessionManager->get_logged_user_name()}");
require ($DOCUMENT_ROOT . "views/login_form.php");