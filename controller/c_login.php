<?php
if (isset($auth) && $auth === false)
    $info = ("<h2 class='error'>Wrong username or account needs verifying</h2>");
else if (isset($_SESSION) && isset($_SESSION["user"])
    && $_SESSION["user"] != "")
    $info = ("<h2 class='success'>Logged as {$_SESSION["user"]}</h2>");
else if ($database === NULL)
    $info = $DB_ERROR;
require ($_SERVER["DOCUMENT_ROOT"] . "/views/login.php");