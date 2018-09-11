<?php
if (isset($_POST) && isset($_POST['page']) && is_numeric($_POST['page']))
{
    header('Content-Type: application/json;charset=utf-8');
    echo json_encode($postManager->get_last_posts($_POST['page']), JSON_FORCE_OBJECT);
    die();
}
else
{
    header('location: index.php?action=login');
    die();
}