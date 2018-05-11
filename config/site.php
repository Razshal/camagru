<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . "/config/database.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/model/class_database.php");
$SITE_ADDRESS = "127.0.0.1:8080";
try {
    $database = new Database($DB_DSN, $DB_USER, $DB_PASSWORD, $SITE_ADDRESS);
} catch (Exception $e) {
    $database = NULL;
}
