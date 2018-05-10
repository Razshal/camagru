<?php
session_start();
include_once ($_SERVER["DOCUMENT_ROOT"] . "/model/get_database.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/config/database.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/controller/tools.php");

try {
    if (isset($_SESSION) && isset($_SESSION["user"]) && $_SESSION["user"] != "")
        if (empty(get_user($databasePDO, $_SESSION["user"])))
            $_SESSION["user"] = "";
} catch (Exception $e) {
    echo $databaseError;
}