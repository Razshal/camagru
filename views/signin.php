<?php ob_start(); ?>
<form class="loginForm" method="post" action="index.php?action=signin">
    <p>Sign-in</p><br/>
    <input type="text" placeholder="Login" title="login" name="login"><br/>
    <input type="email" placeholder="Mail" title="mail" name="mail"><br/>
    <input type="password" placeholder="Password" title="password" name="password"><br/>
    <input class="submit" type="submit" title="send" name="submit" value="Sign-in"><br/>
</form>
<?php $content = ob_get_clean(); ?>