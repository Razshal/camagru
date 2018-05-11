<?php
require_once ($_SERVER["DOCUMENT_ROOT"] . "/config/site.php");

if (isset($_POST)
    && isset($_POST["submit"]) && $_POST["submit"] === "Reset"
    && isset($_POST["mail"]) && !empty($database->get_mail($_POST["mail"])))
{

}
