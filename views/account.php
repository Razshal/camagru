<?php include("structure/head.php") ?>
<html lang="en">
    <body>
        <?php include("structure/header.php") ?>
        <main>
            <h2><?php
                if (isset($_SESSION) && isset($_SESSION["user"]) && $_SESSION["user"] != "")
                echo $_SESSION["user"];?></h2>
        </main>
    </body>
<?php include("structure/footer.php") ?>
</html>