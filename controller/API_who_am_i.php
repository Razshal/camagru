<?php
header('Content-Type: application/json;charset=utf-8');
echo json_encode($sessionManager->get_logged_user_name(), JSON_FORCE_OBJECT);
die();