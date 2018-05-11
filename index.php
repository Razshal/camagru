<?php
session_start();
require ("config/database.php");
require ("config/site.php");
require ("model/class_database.php");

$title = "Camagru";

try {
    $database = new Database($DB_DSN, $DB_USER, $DB_PASSWORD, $SITE_ADDRESS);
    if (isset($_SESSION) && isset($_SESSION["user"]) && $_SESSION["user"] != "")
        if (empty($database->get_user($_SESSION["user"])))
            $_SESSION["user"] = "";
} catch (Exception $e) {
    $database = NULL;
    echo "<h1 class='error'>Fatal database error</h1>";
}

$content = "<h2>Welcome To Camagru</h2>";

require ("views/structure/template.php");