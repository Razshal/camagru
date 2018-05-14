<?php

class DatabaseManager
{
    protected $PDO = NULL;
    protected $SITE_ADDRESS = NULL;

    public function __construct($DB_DSN, $DB_USER, $DB_PASSWORD, $SITE_ADDRESS)
    {
        try
        {
            $this->PDO = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            $this->SITE_ADDRESS = $SITE_ADDRESS;
        }
        catch (Exception $exception)
        {
            throw new Exception("Object cannot connect to database");
        }
    }

    public function initiate()
    {
        try
        {
            $this->PDO->exec("
            CREATE TABLE IF NOT EXISTS user (
              id            INT           NOT NULL AUTO_INCREMENT UNIQUE,
              login         VARCHAR(20)   NOT NULL,
              password      VARCHAR(128)  NOT NULL,
              mail          VARCHAR(254)  NOT NULL,
              check_token   VARCHAR(64)   NOT NULL,
              reset_token   VARCHAR(64),
              creation_date TIMESTAMP     NOT NULL DEFAULT now(),
              reset_date    TIMESTAMP,
              is_verified   INT           NOT NULL DEFAULT 0,
              PRIMARY KEY (id))
              ENGINE = InnoDB;");

            $this->PDO->exec("
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
              ENGINE = InnoDB;");

            $this->PDO->exec("
            CREATE TABLE IF NOT EXISTS comment (
              id           INT          NOT NULL AUTO_INCREMENT UNIQUE,
              post_id      INT          NOT NULL,
              `text`       VARCHAR(256) NOT NULL,
              comment_date TIMESTAMP    NOT NULL DEFAULT now(),
              PRIMARY KEY (id),
              CONSTRAINT fk_post_id
              FOREIGN KEY (post_id)
              REFERENCES post (id))
              ENGINE = InnoDB;");

            $this->PDO->exec("
            CREATE TABLE IF NOT EXISTS `like` (
              post_id      INT          NOT NULL,
              user_id      INT          NOT NULL,
              CONSTRAINT fk_like_post_id FOREIGN KEY (post_id) REFERENCES post(id),
              CONSTRAINT fk_like_user_id FOREIGN KEY (user_id) REFERENCES user(id))
              ENGINE = InnoDB;
            ");
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    protected function generate_random_token()
    {
        return bin2hex(openssl_random_pseudo_bytes(16));
    }
}