<?php
if ($userManager !== NULL && $success = $userManager->initiate())
    $info = $info . "<p class='success'>Website is ok</p><br>";
else
    $info = $info . "<p class='error'>Error during database init</p><br>";
$content = "";