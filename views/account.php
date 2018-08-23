<?php ob_start(); ?>
<h2>
    <form class="loginForm" method="post" action="/index.php?action=account">
        <p>Account modifications</p><br/>
        <input type="text" placeholder="Change Login" title="login" name="login"
               value="<?=$sessionManager->get_logged_user_name()?>"><br/>
        <input type="password" placeholder="Change Password" title="password" name="newPassword"><br/>
        <input type="email" placeholder="Change Mail" title="password" name="mail"
               value="<?=$userManager->get_user($sessionManager->get_logged_user_name())["mail"]?>"><br/>
        <input type="password" placeholder="Confirm your actual password" title="password" name="oldPassword"><br/>
        <a class="link">Receive mail for new comments on my posts</a>
        <input type="checkbox" title="notifications" name="notifications"
               checked="<?=$userManager->get_user($sessionManager->get_logged_user_name())["notifications"]?>"><br/>
        <input class="submit" type="submit" title="send" name="submit" value="Change"><br/>
    </form>
</h2>
<?php $content = ob_get_clean(); ?>