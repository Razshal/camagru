<?php
include_once ("structure/head.php");
include_once ("../config/database.php");
include_once ("../model/get_database.php");
include_once ("../controller/tools.php");

$auth = NULL;

if (isset($_SESSION) && isset($_SESSION["user"]) && $_SESSION["user"] != "") {
    $_SESSION["user"] = "";
}
else if (isset($_POST) && isset($_POST["submit"]) && $_POST["submit"] === "Login"
&& isset($_POST["login"]) && $_POST["login"] != ""
&& isset($_POST["password"]) && $_POST["password"] != ""
&& ($auth = authenticate((new PDO($DB_DSN, $DB_USER, $DB_PASSWORD,
array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION))), $_POST["login"], $_POST["password"]))) {
    $_SESSION["user"] = $_POST["login"];
}

var_dump($auth);
var_dump(hash_pw($_POST["password"]));

?>
<html lang="en">
    <body>
        <?php include ("structure/header.php") ?>
        <main>
            <div id="errorPlace">
                <?php if ($auth === false) echo ("<h2 class='error'>Failed to authenticate</h2>");?>
            </div>
            <form class="loginForm" method="post" action="login.php">
                <p>Login</p><br/>
                <input type="text" placeholder="Login" title="login" name="login"><br/>
                <input type="password" placeholder="Password" title="password" name="password"><br/>
                <input class="submit" type="submit" title="send" name="submit" value="Login"><br/>
                <a class="link" href="signin.php">Don't have an account ? Sign in</a>
            </form>
        </main>
    </body>
    <?php include ("structure/footer.php") ?>
</html>
<script src="style/style.js"></script>