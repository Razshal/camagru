<?php ob_start(); ?>
<form class="loginForm">
    <input type="text" name="title" placeholder="Post title">
    <textarea placeholder="Post description" name="text"></textarea>
</form>
<?php $content = ob_get_clean(); ?>