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

if (isset($_GET["action"]) && $_GET["action"] === "login") {
        if (isset($_POST)
            && isset($_POST["submit"]) && $_POST["submit"] === "Login"
            && isset($_POST["login"]) && isset($_POST["password"])
            && ($auth = $database->authenticate($_POST["login"], $_POST["password"])))
            $_SESSION["user"] = $_POST["login"];
    require ("views/login.php");
}

else if (isset($_GET["action"]) && $_GET["action"] === "logout") {
    if ($database !== NULL) {
        if (isset($_SESSION)
            && isset($_SESSION["user"]) && $_SESSION["user"] != "")
            $_SESSION["user"] = "";
    }
}

else if (isset($_GET["action"]) && $_GET["action"] === "setup") {
    if ($database !== NULL)
        $success = $database->initiate();
    else
        $success= false;
    require ("config/setup.php");
}


require ("views/structure/template.php");