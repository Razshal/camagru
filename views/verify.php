<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . "/views/structure/head.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/controller/C_verify.php");
?>
<html lang="en">
    <body>
        <?php include($_SERVER["DOCUMENT_ROOT"] . "/views/structure/header.php") ?>
        <main>
            <div id="errorPlace">
                <?php
                if ($done === false)
                    echo ("<h2 class='error'>Error wrong token/login</h2>");
                if ($done === true)
                    echo ("<h2 class='success'>Account activated</h2>");
                ?>
            </div>
        </main>
    </body>
<?php include($_SERVER["DOCUMENT_ROOT"] . "/views/structure/footer.php") ?>
</html>