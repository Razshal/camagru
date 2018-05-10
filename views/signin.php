<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . "/views/structure/head.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/model/checks.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/model/set_database.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/config/database.php");

$validMail = true;
$validPass = true;
$validLogin = true;
$querySuccess = 0;

if ($DB_ERROR === false && isset($_POST) && $_POST["submit"] === "Sign-in") {
    $validMail = validNewMail($databasePDO, $_POST["mail"]);
    $validPass = validNewPassword($_POST["password"]);
    $validLogin = validNewLogin($databasePDO, $_POST["login"]);
    if ($validMail && $validPass && $validLogin)
        $querySuccess = newUser($databasePDO, $_POST["login"],
            $_POST["mail"], $_POST["password"]);
}
else if (isset($_POST["submit"]))
    $querySuccess = false;
?>
<html lang="en">
    <body>
        <?php include("structure/header.php") ?>
        <main>
            <div id="errorPlace">
            <?php
                if ($DB_ERROR !== false)
                    echo $DB_ERROR;
                if (!$validMail)
                    echo ("<h2 class='error'>Mail is already in use or not valid</h2>");
                if (!$validLogin)
                    echo ("<h2 class='error'>Login is already in use or not valid 
                    (4 chars >= login <= 20 chars)</h2>");
                if (!$validPass)
                    echo ("<h2 class='error'>Password should be at least 8 chars and
                    contains at least one letter and one digit</h2>");
                if ($querySuccess === false)
                    echo ("<h2 class='error'>Error during user creation, please retry</h2>");
                else if ($querySuccess === true)
                    echo ("<h2 class='success'>Account created</h2>");
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