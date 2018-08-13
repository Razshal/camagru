<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?=$title?></title>
        <link rel="stylesheet" type="text/css" href="/views/style/style.css">
        <link href='https://fonts.googleapis.com/css?family=Handlee' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>
    </head>
    <body>
        <header>
            <a class="headerLink" href="/" id="siteTitle"><h1>Camagru</h1></a>
            <?php
            if ($userManager && $userManager->isInitiated() === false)
                echo "<a class=\"headerLink\" href=\"/index.php?action=setup\">Initiate</a>";?>
            <a class="headerLink" href="/index.php?action=post">Post</a>
            <?php
            if ($sessionManager && $sessionManager->is_logged_user_valid())
            {
                echo "<a class=\"headerLink\" href=\"/index.php?action=account\">Account</a>"
                    . "<a class=\"headerLink\" href=\"/index.php?action=logout\">Logout</a>";
            }
            else
            {
                echo "<a class=\"headerLink\" href=\"/index.php?action=signin\">Sign-in</a>"
                    . "<a class=\"headerLink\" href=\"/index.php?action=login\">Login</a>";
            }?>
        </header>
        <main class="container">
            <div id="errorPlace">
                <?=$siteManager->get_logs()?>
            </div>
            <?=$content?>
        </main>
        <footer>
            <h2>Camagru is a 42 school project</h2>
            <h3>made by mfonteni</h3>
        </footer>
    </body>
</html>
<script src="/views/style/style.js"></script>