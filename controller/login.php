<?php
if (isset($auth) && $auth === false)
    $info = $info . ("<h2 class='error'>Unable to connect, check you username/password and if your account is activated</h2>");
else if (isset($_SESSION) && isset($_SESSION["user"])
    && $_SESSION["user"] != "")
    $info = $info . ("<h2 class='success'>Logged as {$_SESSION["user"]}</h2>");
require($_SERVER["DOCUMENT_ROOT"] . "/views/login_form.php");