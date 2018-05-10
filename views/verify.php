<?php
include_once ("/views/structure/head.php");
include_once ("/model/get_database.php");
include_once ("/model/checks.php");
include_once ("/controller/tools.php");
include_once ("/config/database.php");

$done = 0;

try {
    $database = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD,
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    $success = false;

    if (isset($_GET)
        && isset($_GET["action"]) && $_GET["action"] === "verify"
        && isset($_GET["user"])
        && !empty($user = get_user($database, $_GET["user"]))
        && isset($_GET["token"])) {
        if (validChars($_GET["user"])) {
            $query = $database->prepare("
        UPDATE user 
        SET is_verified = 1 
        WHERE login = :login");
            $done = $query->execute(array(':login' => $_GET["user"]));
        }
    } else {
        $done = false;
    }
} catch (Exception $s) {
    echo $databaseError;
}?>
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