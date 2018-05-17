<?php ob_start(); ?>
    <form class="loginForm" method="post" action="index.php?action=reset">
        <p>New Password</p>
        <input type="password" placeholder="New password" title="password" name="password"><br/>
        <input type="hidden" title="mail" name="mail" value="<?=$_GET["mail"]?>"><br/>
        <input type="hidden" title="token" name="token" value="<?=$_GET["token"]?>"><br/>
        <input class="submit" type="submit" title="send" name="submit" value="Change"><br/>
    </form>
<?php $content = ob_get_clean(); ?>