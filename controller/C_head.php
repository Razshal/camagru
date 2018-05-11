<?php
session_start();
include_once ($_SERVER["DOCUMENT_ROOT"] . "/config/site.php");

try {
    if (isset($_SESSION) && isset($_SESSION["user"]) && $_SESSION["user"] != "")
        if (empty($database->get_user($_SESSION["user"])))
            $_SESSION["user"] = "";
} catch (Exception $e) {
    echo $database->userErrorMessage();
}