<?php
/**
 * capable de créer ou recréer le schéma de la base de données,
 * en utilisant les infos contenues dans le fichier config/database.php.
 */
include_once("../views/structure/head.php");
include_once ("database.php");
include_once ("../model/get_database.php");

/* IMPORTANT: supprimer le try catch, il ne faut pas ecrire le mdp de
 * la database sur une page a laquelle les utilisateurs peuvent tenter d'acceder
 *
 */

if ($databaseSuccess === true) {
    $success += $databasePDO->exec("
    CREATE TABLE IF NOT EXISTS user (
      id          INT         NOT NULL AUTO_INCREMENT UNIQUE,
      login       VARCHAR(20) NOT NULL,
      isAdmin     INT         NOT NULL DEFAULT 0,
      password    VARCHAR(128),
      mail        VARCHAR(254),
      check_token VARCHAR(128),
      is_verified INT NOT NULL DEFAULT 0,
      PRIMARY KEY (`id`))
      ENGINE = InnoDB;
    ");

    $success += $databasePDO->exec("
    CREATE TABLE IF NOT EXISTS post (
      id          INT       NOT NULL AUTO_INCREMENT UNIQUE,
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

    $success += $databasePDO->exec("
    CREATE TABLE IF NOT EXISTS comment (
      id           INT          NOT NULL AUTO_INCREMENT UNIQUE,
      post_id      INT          NOT NULL,
      `text`       VARCHAR(256) NOT NULL,
      comment_date TIMESTAMP    NOT NULL DEFAULT now(),
      PRIMARY KEY (id),
      CONSTRAINT fk_post_id
      FOREIGN KEY (post_id)
      REFERENCES post (id))
      ENGINE = InnoDB;
    ");

    $success = $databasePDO->exec("
    CREATE TABLE IF NOT EXISTS `like` (
      post_id      INT          NOT NULL,
      user_id      INT          NOT NULL,
      CONSTRAINT fk_like_post_id FOREIGN KEY (post_id) REFERENCES post(id),
      CONSTRAINT fk_like_user_id FOREIGN KEY (user_id) REFERENCES user(id))
      ENGINE = InnoDB;
    ");
}
?>
<html lang="en">
    <body>
    <?php include("../views/structure/header.php") ?>
        <main>
            <div>
                <h2>Setup tried, Site status :</h2>
                <?php
                if ($databaseSuccess === true)
                    echo ("<p class='success'>Website is ok</p>");
                else if (isset($DB_ERROR_MESSAGE))
                    echo $DB_ERROR_MESSAGE;?>
            </div>
        </main>
    </body>
    <?php include("../views/structure/footer.php") ?>
</html>