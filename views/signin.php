<?php
include_once ("structure/head.php");
include_once ("../model/checks.php");
include_once ("../model/get_database.php");
include_once ("../model/set_database.php");
include_once ("../config/site.php");

$validMail = true;
$validPass = true;
$validLogin = true;
$queryError = 0;

try {
    if (isset($_POST) && $_POST["submit"] === "Sign-in") {
        $databasePDO = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD,
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

        $validMail = validNewMail($databasePDO, $_POST["mail"]);
        $validPass = validNewPassword($_POST["password"]);
        $validLogin = validNewLogin($databasePDO, $_POST["login"]);

        if ($validMail && $validPass && $validLogin) {
            $queryError = newUser($databasePDO, $_POST["login"],
                $_POST["mail"], $_POST["password"]);
        }
    }
} catch (Exception $e) {
    echo $databaseError;
}
?>
<html lang="en">
    <body>
        <?php include("structure/header.php") ?>
        <main>
            <div id="errorPlace">
            <?php
                if (!$validMail)
                    echo ("<h2 class='error'>Mail is already in use or not valid</h2>");
                if (!$validLogin)
                    echo ("<h2 class='error'>Login is already in use or not valid 
                    (4 chars >= login <= 20 chars)</h2>");
                if (!$validPass)
                    echo ("<h2 class='error'>Password should be at least 8 chars and
                    contains at least one letter and one digit</h2>");
                if ($queryError === false)
                    echo ("<h2 class='error'>Error during creating new user, please retry</h2>");
                else if ($queryError === true) {
                    echo ("<h2 class='success'>Account created</h2>");
                }
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
<script src="style/style.js"></script>