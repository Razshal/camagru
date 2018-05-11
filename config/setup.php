<?php
/**
 * capable de créer ou recréer le schéma de la base de données,
 * en utilisant les infos contenues dans le fichier config/class_database.php.
 */

include_once($_SERVER["DOCUMENT_ROOT"] . "/views/structure/head.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/config/database.php");

if ($database !== NULL)
    $success = $database->initiate();
else
    $success = false;
?>
<html lang="en">
    <body>
    <?php include($_SERVER["DOCUMENT_ROOT"] . "/views/structure/header.php") ?>
        <main>
            <div>
                <h2>Setup tried, Site status :</h2>
                <?php
                if ($success === true)
                    echo ("<p class='success'>Website is ok</p>");
                else if ($success !== false)
                    echo $DB_ERROR;
                ?>
            </div>
        </main>
    </body>
    <?php include($_SERVER["DOCUMENT_ROOT"] . "/views/structure/footer.php") ?>
</html>