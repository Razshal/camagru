<?php ob_start() ?>
<form class="loginForm" method="post" action="index.php?action=reset">
    <h2>Password reset</h2>
    <input type="email" placeholder="Email" title="email" name="email"><br/>
    <input class="submit" type="submit" title="send" name="submit" value="Reset"><br/>
</form>
<?php $content = ob_get_clean() ?>