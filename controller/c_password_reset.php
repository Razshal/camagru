<?php
if (isset($_POST) && isset($_POST["mail"]) && isset($_POST["submit"])
    && $_POST["submit"] === "Reset"
    && !empty($user = $database->get_mail($_POST["mail"])))
{
    if ($database->initiatePasswordReset($_POST["mail"]))
        $done = "<h2 class='success'>Reset account mail sent</h2>";
    else
        $done = "<h2 class='error'>Unable to send reset mail, 
        check if your mail is valid</h2>";
    require ($_SERVER["DOCUMENT_ROOT"] . "/views/ask_password_reset.php");
}
else if (isset($_GET) && isset($_GET["token"]) && isset($_GET["mail"]))
{
    if (!empty($user = $database->get_mail($_GET["mail"]))
        && $user["check_token"] === $_GET["token"])
    {
        var_dump($user["reset_date"]);
    }
}
else
    require ($_SERVER["DOCUMENT_ROOT"] . "/views/ask_password_reset.php");