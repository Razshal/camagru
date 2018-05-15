<?php ob_start() ?>
<h2>
    <?php
    if ($sessionManager->is_logged_user_valid())
        echo "Hello " . $sessionManager->get_logged_user_name();?>
</h2>
<?php $content = ob_get_clean() ?>