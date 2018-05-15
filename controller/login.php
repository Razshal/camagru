<?php
if (isset($_POST)
    && isset($_POST["submit"]) && $_POST["submit"] === "Login"
    && isset($_POST["login"]) && isset($_POST["password"]))
{
    $auth = $sessionManager->log_in_user($_POST["login"], $_POST["password"]);
}
if (isset($auth) && $auth === false)
    $info = $info . ("<h2 class='error'>Unable to connect, check you username/password and if your account is activated</h2>");
else if ($sessionManager->is_logged_user_valid())
    $info = $info . ("<h2 class='success'>Logged as {$sessionManager->get_logged_user_name()}</h2>");
require ($_SERVER["DOCUMENT_ROOT"] . "/views/login_form.php");