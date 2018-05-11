<?php
include($_SERVER["DOCUMENT_ROOT"] . "/views/structure/head.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/controller/C_password_reset.php");
?>
<html lang="en">
    <body>
        <?php include($_SERVER["DOCUMENT_ROOT"] . "/views/structure/header.php") ?>
        <main>
            <form class="loginForm" method="post" action="login.php">
                <h2>Password reset</h2>
                <input type="email" placeholder="Email" title="email" name="email"><br/>
                <input class="submit" type="submit" title="send" name="submit" value="Reset"><br/>
            </form>
        </main>
    </body>
<?php include($_SERVER["DOCUMENT_ROOT"] . "/views/structure/footer.php") ?>
</html>