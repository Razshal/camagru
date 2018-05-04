<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . "/views/structure/head.php");
include_once ("../model/get_database.php");
include_once ("../model/checks.php");
include_once ("../controller/tools.php");
include_once ("../config/database.php");

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
        var_dump($done);
    }
} catch (Exception $s) {
    echo $databaseError;
}?>
<html lang="en">
    <body>
        <?php include($_SERVER["DOCUMENT_ROOT"] . "/views/structure/header.php") ?>
        <main>
            <h2>Account verification</h2>
        </main>
    </body>
<?php include($_SERVER["DOCUMENT_ROOT"] . "/views/structure/footer.php") ?>
</html>