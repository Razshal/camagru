<?php
include_once ("../model/get_database.php");
include_once ("../config/database.php");

$database = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD,
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

if (isset($_GET)
    && isset($_GET["action"]) && $_GET["action"] === "verify"
    && isset($_GET["user"])
    && !empty($user = get_user($database, $_GET["user"]))
    && isset($_GET["token"])) {
    var_dump($user);
}