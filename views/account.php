<?php ob_start(); ?>
<h2>
    <?php
//    if ($sessionManager->is_logged_user_valid())
//        echo "Hello " . $sessionManager->get_logged_user_name();?>
    <form class="loginForm" method="post" action="/index.php?action=account">
        <p>Account modifications</p><br/>
        <input type="text" placeholder="Change Login" title="login" name="login"><br/>
        <input type="password" placeholder="Change Password" title="password" name="password"><br/>
        <input type="password" placeholder="Change Mail" title="password" name="password"><br/>
        <input type="password" placeholder="Actual password" title="password" name="atualPassword"><br/>
        <input class="submit" type="submit" title="send" name="submit" value="Change"><br/>
    </form>
</h2>
<?php $content = ob_get_clean(); ?>