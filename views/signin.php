<?php ob_start(); ?>
<div id="errorPlace"><?php
    if ($database === NULL)
        echo $DB_ERROR;
    if (isset($validMail) && !$validMail)
        echo ("<h2 class='error'>Mail is already in use or not valid</h2>");
    if (isset($validLogin) && !$validLogin)
        echo ("<h2 class='error'>Login is already in use or not valid 
                   (4 chars >= login <= 20 chars)</h2>");
    if (isset($validPass) && !$validPass)
        echo ("<h2 class='error'>Password should be at least 8 chars and
                   contains at least one letter and one digit</h2>");
    if (isset($querySuccess) && $querySuccess === false)
        echo ("<h2 class='error'>Error during user creation, please retry</h2>");
    else if (isset($querySuccess) && $querySuccess === true)
        echo ("<h2 class='success'>Account created</h2>");?>
</div>
<form class="loginForm" method="post" action="index.php?action=signin">
    <p>Sign-in</p><br/>
    <input type="text" placeholder="Login" title="login" name="login"><br/>
    <input type="email" placeholder="Mail" title="mail" name="mail"><br/>
    <input type="password" placeholder="Password" title="password" name="password"><br/>
    <input class="submit" type="submit" title="send" name="submit" value="Sign-in"><br/>
</form>
<?php $content = ob_get_clean(); ?>