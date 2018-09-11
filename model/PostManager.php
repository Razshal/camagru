<?php

require_once $DOCUMENT_ROOT . "model/UserManager.php";

class PostManager extends UserManager
{
    public function new_post($login, $image, $description)
    {
        try
        {
            if (empty($user = $this->get_user($login)))
                return false;
            $query = $this->PDO->prepare("
                INSERT INTO post VALUES 
                (NULL, :user_id, :image, :description, now());");
            $query->execute(array(
                ':user_id' => $user['id'],
                ':image' => $image,
                ':description' => $description
            ));
            return $query->rowCount() > 0;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    public function get_user_posts($login)
    {
        try
        {
            if (empty($user = $this->get_user($login)))
                return false;
            $query = $this->PDO->prepare("
            SELECT user.login, post.image, post.description, post.post_date
            FROM post, user
            WHERE user_id = :id");
            $query->execute(array(
                ':id' => $user['id']
            ));
            return $query->fetchAll();
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    public function get_user_post_by_image($image)
    {
        try
        {
            $query = $this->PDO->prepare("
            SELECT user.login, post.id, post.image, post.description, post.post_date
            FROM post, user
            WHERE post.image = :image");
            $query->execute(array(
                ':image' => $image
            ));
            return $query->fetchAll()[0];
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    public function delete_post($id)
    {
        try
        {
            $query = $this->PDO->prepare("
                DELETE FROM post
                WHERE post.id = :id");
            $query->execute(array('id' => $id));
            return $query->rowCount() > 0;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    public function get_last_posts($page = 0)
    {
        try
        {

        }
        catch (Exception $e)
        {
            return false;
        }
    }
}