<?php ob_start() ?>
<h2>
    <?php
    if (isset($_SESSION) && isset($_SESSION["user"]) && $_SESSION["user"] != "")
    echo $_SESSION["user"];?>
</h2>
<?php $content = ob_get_clean() ?>