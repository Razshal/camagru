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