<?php
session_start();
include_once ($_SERVER["DOCUMENT_ROOT"] . "/model/get_database.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/config/database.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/controller/tools.php");

try {
    if (isset($_SESSION) && isset($_SESSION["user"]) && $_SESSION["user"] != "") {
        $database = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD,
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        if (empty(get_user($database, $_SESSION["user"]))) {
            $_SESSION["user"] = "";
        }
    }
} catch (Exception $e) {
    echo $databaseError;
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Camagru</title>
        <link rel="stylesheet" type="text/css" href="/views/style/style.css">
        <link href='https://fonts.googleapis.com/css?family=Handlee' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>
    </head>
</html>