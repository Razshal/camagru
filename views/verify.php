<?php
include_once ("../model/checks.php");
include_once ("../config/database.php");

$database = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD,
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

if (isset($_GET)
    && isset($_GET["action"]) && $_GET["action"] === "verify"
    && isset($_GET["user"]) && !validNewLogin($database, $_GET["user"])
    && isset($_GET["token"])
) {

}