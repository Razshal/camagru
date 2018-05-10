<?php
$DB_IP = "127.0.0.1";
$DB_PORT = "8888";
$DB_DSN = "mysql:host={$DB_IP};port={$DB_PORT};dbname=camagru";
$DB_USER = "root";
$DB_PASSWORD = "jaimeles1576483bonnesmontagnesrectangulaires";
$DB_ERROR = false;

try {
    $databasePDO = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD,
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $exception) {
    $DB_ERROR = "<p class='error'>Fatal error, cannot access database</p>";
}