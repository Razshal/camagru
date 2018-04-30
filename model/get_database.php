<?php

function is_there_admins($database_pdo)
{
    return !!$database_pdo->query("
              SELECT * FROM user WHERE user.isAdmin LIKE 1");

}