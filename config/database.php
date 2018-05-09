<?php
$DB_IP = "192.168.99.100";
$DB_PORT = "3306";
$DB_DSN = "mysql:host={$DB_IP};port={$DB_PORT};dbname=camagru";
$DB_USER = "root";
$DB_PASSWORD = "jaimeles1576483bonnesmontagnesrectangulaires";

try {
    $databasePDO = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD,
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    $databaseSuccess = true;
} catch (Exception $exception) {
    $DB_ERROR_MESSAGE = "<p class='error'>Fatal error, cannot access database</p>";
    $databaseSuccess = false;
}