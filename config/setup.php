<?php
if ($userManager !== NULL && $success = $userManager->initiate())
    $siteManager->success_log("Website is ok");
else
    $siteManager->error_log("Error during database init");