<?php
require_once ($_SERVER["DOCUMENT_ROOT"] . "/views/structure/head.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/config/database.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/model/get_database.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/controller/tools.php");

if ($DB_ERROR === false) {
    if (isset($_SESSION) && isset($_SESSION["user"]) && $_SESSION["user"] != "")
        $_SESSION["user"] = "";
    else if (isset($_POST) && isset($_POST["submit"]) && $_POST["submit"] === "Login"
        && isset($_POST["login"]) && $_POST["login"] != ""
        && isset($_POST["password"]) && $_POST["password"] != ""
        && ($auth = authenticate($databasePDO, $_POST["login"], $_POST["password"]))) {
        $_SESSION["user"] = $_POST["login"];
    }
}
?>
<html lang="en">
    <body>
        <?php include ("structure/header.php") ?>
        <main>
            <div id="errorPlace">
                <?php
                if (isset($auth) && $auth === false)
                    echo ("<h2 class='error'>Wrong username or account needs verifying</h2>");
                else if (isset($_SESSION) && isset($_SESSION["user"]) && $_SESSION["user"] != "")
                    echo ("<h2 class='success'>Logged as {$_SESSION["user"]}</h2>");
                else if ($DB_ERROR !== false)
                    echo $DB_ERROR;
                ?>
            </div>
            <?php
            if (!isset($_SESSION) || !isset($_SESSION["user"])
                || $_SESSION["user"] === "") {
                ?>
            <form class="loginForm" method="post" action="login.php">
                <p>Login</p><br/>
                <input type="text" placeholder="Login" title="login" name="login"><br/>
                <input type="password" placeholder="Password" title="password" name="password"><br/>
                <input class="submit" type="submit" title="send" name="submit" value="Login"><br/>
                <a class="link" href="signin.php">Don't have an account ? Sign in</a>
            </form>
            <?php
            }?>
        </main>
    </body>
    <?php include ("structure/footer.php") ?>
</html>
<script src="style/style.js"></script>