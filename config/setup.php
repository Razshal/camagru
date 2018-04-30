<?php
/**
 * capable de créer ou recréer le schéma de la base de données,
 * en utilisant les infos contenues dans le fichier config/database.php.
 */
include ("database.php");

/* IMPORTANT: supprimer le try catch, il ne faut pas ecrire le mdp de
 * la database sur une page a laquelle les utilisateurs peuvent tenter d'acceder
 *
 */

$databse = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD,
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

if (!$databse)
    echo ("<h1>Failed to connect to database</h1>");

$databse->exec("
  CREATE TABLE IF NOT EXISTS user (
    `id` INT NOT NULL AUTO_INCREMENT,
    `login` varchar(20) NOT NULL,
    `isAdmin` INT NOT NULL DEFAULT 0,
    `password` varchar(64),
    `mail` varchar(254),
    PRIMARY KEY (`id`))");
try {
    $databse->exec("
  CREATE TABLE IF NOT EXISTS user (
CREATE TABLE IF NOT EXISTS post (
  id INT NOT NULL AUTO_INCREMENT,
  user_id INT NOT NULL,
  image VARCHAR(100),
  description VARCHAR(256),
  post_date DATE NOT NULL DEFAULT now(),
  PRIMARY KEY (id),
  CONSTRAINT fk_user_id
    FOREIGN KEY (user_id)
    REFERENCES USER(id)
)ENGINE=InnoDB;");
}
catch (Exception $e) {
    echo $e;
}


