<?php
/**
 * capable de créer ou recréer le schéma de la base de données,
 * en utilisant les infos contenues dans le fichier config/database.php.
 */
include_once ("database.php");
include_once ("../model/get_database.php");

/* IMPORTANT: supprimer le try catch, il ne faut pas ecrire le mdp de
 * la database sur une page a laquelle les utilisateurs peuvent tenter d'acceder
 *
 */

$database = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD,
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

if (!$database)
    echo ("<h1 style='color: red'>Failed to connect to database</h1>");
else {
    $database->exec("
CREATE TABLE IF NOT EXISTS user (
  id       INT         NOT NULL AUTO_INCREMENT,
  login    VARCHAR(20) NOT NULL,
  isAdmin  INT         NOT NULL DEFAULT 0,
  password VARCHAR(64),
  mail     VARCHAR(254),
  PRIMARY KEY (`id`))
  ENGINE = InnoDB;
");

    $database->exec("
CREATE TABLE IF NOT EXISTS post (
  id          INT       NOT NULL AUTO_INCREMENT,
  user_id     INT       NOT NULL,
  image       VARCHAR(100),
  description VARCHAR(256),
  post_date   TIMESTAMP NOT NULL DEFAULT now(),
  PRIMARY KEY (id),
  CONSTRAINT fk_user_id
  FOREIGN KEY (user_id)
  REFERENCES user (id))
  ENGINE = InnoDB;
");

    $database->exec("
CREATE TABLE IF NOT EXISTS comment (
  id           INT          NOT NULL AUTO_INCREMENT,
  post_id      INT          NOT NULL,
  `text`       VARCHAR(256) NOT NULL,
  comment_date TIMESTAMP    NOT NULL DEFAULT now(),
  PRIMARY KEY (id),
  CONSTRAINT fk_post_id
  FOREIGN KEY (post_id)
  REFERENCES post (id))
  ENGINE = InnoDB;
");

    $database->exec("
CREATE TABLE IF NOT EXISTS `like` (
  post_id      INT          NOT NULL,
  user_id      INT          NOT NULL,
  CONSTRAINT fk_like_post_id FOREIGN KEY (post_id) REFERENCES post(id),
  CONSTRAINT fk_like_user_id FOREIGN KEY (user_id) REFERENCES user(id))
  ENGINE = InnoDB;
");
    ?>
    <!DOCTYPE html>
    <html lang="en">
        <?php include("../views/head.php") ?>
        <body>
            <?php include("../views/header.php") ?>
            <main>
                <h2>Setup Page</h2>
                <p style='color:mediumseagreen'>Website is Ok</p>
            </main>
        </body>
        <?php include("../views/footer.php") ?>
    </html>

    <?php
}?>


