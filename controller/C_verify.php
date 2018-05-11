<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . "/model/checks.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/controller/tools.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/config/site.php");

$done = 0;
$success = false;

if (isset($_GET)
    && isset($_GET["action"]) && $_GET["action"] === "verify"
    && isset($_GET["user"]) && isset($_GET["token"]))
    $done = $database->verify_user($_POST["login"]);
else
    $done = false;