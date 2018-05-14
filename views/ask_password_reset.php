<?php ob_start() ?>
<form class="loginForm" method="post" action="index.php?action=reset">
    <p>Password reset</p>
    <input type="email" placeholder="Email" title="mail" name="mail"><br/>
    <input class="submit" type="submit" title="send" name="submit" value="Reset"><br/>
</form>
<?php $content = ob_get_clean() ?>