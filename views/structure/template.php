<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?= $title ?></title>
        <link rel="stylesheet" type="text/css" href="/views/style/style.css">
        <link href='https://fonts.googleapis.com/css?family=Handlee' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>
    </head>
    <body>
        <header>
            <a class="headerLink" href="/" id="siteTitle"><h1>Camagru</h1></a>
            <a class="headerLink" href="#">Post</a>
            <a class="headerLink" href="/index.php?action=account">Account</a>
            <?php
                if (!isset($_SESSION) || !isset($_SESSION["user"]) || $_SESSION["user"] === "")
                    echo("<a class=\"headerLink\" href=\"/index.php?action=login\">Login</a>");
                else
                    echo("<a class=\"headerLink\" href=\"/index.php?action=logout\">Logout</a>");?>
        </header>
        <main>
            <div id="errorPlace">
                <?php if (isset($info))
                    echo $info;
                ?>
            </div>
            <?= $content ?>
        </main>
        <footer>
            <h2>Camagru is a 42 school project</h2>
            <h3>made by mfonteni</h3>
        </footer>
    </body>
</html>
<script src="/views/style/style.js"></script>