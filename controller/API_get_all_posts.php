<?php
if (isset($_GET['startFrom']))
{
    header('Content-Type: application/json;charset=utf-8');
    echo json_encode($posts, JSON_FORCE_OBJECT);
    die();
}
else if (isset($_GET['user'])
    && $sessionManager->is_logged_user_valid()
    && !($posts = $postManager->get_user_posts($_GET['user'])))
{
    print '{}';
    die();
}
else
{
    header('location: index.php?action=login');
    die();
}