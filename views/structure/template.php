<?php require_once ($_SERVER["DOCUMENT_ROOT"] . "/controller/C_head.php"); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Camagru</title>
        <link rel="stylesheet" type="text/css" href="/views/style/style.css">
        <link href='https://fonts.googleapis.com/css?family=Handlee' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>
    </head>
    <body>
        <header>
            <a class="headerLink" href="/" id="siteTitle"><h1>Camagru</h1></a>
            <a class="headerLink" href="#">Post</a>
            <a class="headerLink" href="/views/account.php">Account</a>
            <a class="headerLink" href="/views/login.php"><?php
                if (!isset($_SESSION) || !isset($_SESSION["user"])
                    || $_SESSION["user"] === "")
                    echo("Login");
                else
                    echo("Logout");?>
            </a>
        </header>
        <main>
            <?= $content ?>
            <h2>Welcome To Camagru</h2>
        </main>
        <footer>
            <h2>Camagru 42 school project</h2>
            <h3>made by mfonteni</h3>
        </footer>
    </body>

</html>