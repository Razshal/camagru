<?php
if (isset($_POST) && isset($_POST["mail"]) && isset($_POST["submit"])
    && $_POST["submit"] === "Reset"
    && !empty($user = $database->get_mail($_POST["email"])))
{
    if ($database->initiatePasswordReset($_POST["mail"]))
        $done = "<h2 class='success'>Reset account mail sent</h2>";
    else
        $done = "<h2 class='error'>Unable to send reset mail, 
        check if your mail is valid</h2>";
}
else if (isset($_GET) && isset($_GET["token"]) && isset($_GET["mail"]))
{
    if (!empty($user = $database->get_mail($_GET["mail"]))
        && $user["check_token"] === $_GET["token"])
    {
        var_dump($user["reset_date"]);
    }
}