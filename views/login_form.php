<?php ob_start();
if (!isset($_SESSION) || !isset($_SESSION["user"])
    || $_SESSION["user"] === "")
{
    ?>
    <form class="loginForm" method="post" action="/index.php?action=login">
        <p>Login</p><br/>
        <input type="text" placeholder="Login" title="login" name="login"><br/>
        <input type="password" placeholder="Password" title="password" name="password"><br/>
        <input class="submit" type="submit" title="send" name="submit" value="Login"><br/>
        <a class="link" href="index.php?action=signin">Don't have an account ? Sign in</a>
        <a class="link" href="index.php?action=reset">Forgot your password ? Reset password</a>
    </form>
    <?php
}
$content = ob_get_clean();
?>

