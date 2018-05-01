<?php
include_once ("structure/head.php");
include_once ("../model/get_database.php");

?>
<html lang="en">
    <body>
        <?php include ("structure/header.php") ?>
        <main>
            <form class="loginForm" method="post" action="login.php">
                <p>Login</p><br/>
                <input type="text" placeholder="Login" title="login" name="login"><br/>
                <input type="password" placeholder="Password" title="password" name="password"><br/>
                <input class="submit" type="submit" title="send" name="submit" value="Login"><br/>
            </form>
        </main>
    </body>
    <?php include ("structure/footer.php") ?>
</html>