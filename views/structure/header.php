<header>
    <a href="/" id="siteTitle"><h1>Camagru</h1></a>
    <a href="#">Browse</a>
    <a href="/views/account.php">Account</a>
    <a href="/views/login.php"><?php
        if (!isset($_SESSION) || !isset($_SESSION["user"])
        || $_SESSION["user"] === "")
            echo("Login");
        else
            echo("Logout");?>
    </a>
</header>