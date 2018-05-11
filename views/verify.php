<?php ob_start(); ?>
    <div id="errorPlace">
        <?php
        if ($done === false)
            echo ("<h2 class='error'>Error wrong token/login</h2>");
        if ($done === true)
            echo ("<h2 class='success'>Account activated</h2>");
        ?>
    </div>
<?php $content = ob_get_clean() ?>