<?php

if (isset($_POST) && isset($_POST['image'])
    && $sessionManager->is_logged_user_valid()
    && !empty($post = $userManager->get_user_post_by_image($_POST['image']))
    && $post['login'] === $sessionManager->get_logged_user_name()
    && $userManager->delete_post($post['id'])
    && unlink($DOCUMENT_ROOT . $_POST['image']))
{
    header('HTTP/1.1 200 Success');
    die();
}
else
{
    header('HTTP/1.1 400 Bad Request');
    die();
}
