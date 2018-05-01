<?php
include("structure/head.php");
include_once ("../model/checks.php");
include_once ("../model/get_database.php");
include_once ("../model/set_database.php");
include_once ("../config/database.php");

//TODO: Auto login after creating account (easy)

$valid_mail = true;
$valid_pass = true;
$login_error = true;
$query_error = false;

if (isset($_POST) && $_POST["submit"] === "Sign-in") {
    $database_PDO = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD,
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    $valid_mail = valid_mail($_POST["mail"]) && !get_mail($database_PDO, $_POST["mail"]);
    $valid_pass = valid_new_password($_POST["password"]);
    $valid_login = valid_login($_POST["login"]) && !get_user($database_PDO, $_POST["login"]);

    if ($valid_mail && $valid_pass && $valid_login) {
        $query_error = new_user($database_PDO, $_POST["login"], $_POST["mail"], $_POST["password"]);
    }
    var_dump(!get_mail($database_PDO, $_POST["mail"]));
}

?>

<html lang="en">
    <body>
        <?php include("structure/header.php") ?>
        <main>
            <div id="errorPlace">
            <?php
            if (!$valid_mail)
                echo ("<h2 class='error'>Mail is already used or not valid</h2>");
            if (!$valid_login)
                echo ("<h2 class='error'>Login is already used or not valid</h2>");
            if (!$valid_pass)
                echo ("<h2 class='error'>Bad Password</h2>");
            if ($query_error != false && $query_error < 1)
                echo ("<h2 class='error'>Error during creating new user, please retry</h2>");
            ?>
            </div>
            <form class="loginForm" method="post" action="signin.php">
                <p>Sign-in</p><br/>
                <input type="text" placeholder="Login" title="login" name="login"><br/>
                <input type="email" placeholder="Mail" title="mail" name="mail"><br/>
                <input type="password" placeholder="Password" title="password" name="password"><br/>
                <input class="submit" type="submit" title="send" name="submit" value="Sign-in"><br/>
            </form>
        </main>
    </body>
    <?php include("structure/footer.php") ?>
</html>