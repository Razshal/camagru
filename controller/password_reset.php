<?php
if (isset($_POST) && isset($_POST["mail"]) && isset($_POST["submit"])
    && $_POST["submit"] === "Reset"
    && !empty($user = $userManager->get_mail($_POST["mail"])))
{
    if ($userManager->initiatePasswordReset($_POST["mail"]))
        $info = $info . "<h2 class='success'>Reset account mail sent</h2>";
    else
        $info = $info . "<h2 class='error'>Unable to send reset mail, 
        check if your mail is valid</h2>";
    require ($_SERVER["DOCUMENT_ROOT"] . "/views/ask_password_reset.php");
}
else if (isset($_GET["token"]) && isset($_GET["mail"]))
{
    echo $_GET["token"] . "<br>";
    if (!empty($user = $userManager->get_mail($_GET["mail"]))
        && $user[0]["check_token"] === $_GET["token"])
    {
        require ($_SERVER["DOCUMENT_ROOT"] . "/views/chose_new_password.php");
    }
    var_dump($user[0]["reset_date"]);
}
else
    require ($_SERVER["DOCUMENT_ROOT"] . "/views/ask_password_reset.php");