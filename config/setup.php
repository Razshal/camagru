<? ob_start(); ?>
<div>
    <h2>Setup tried, Site status :</h2>
    <?php
    if ($success === true)
        echo ("<p class='success'>Website is ok</p>");
    else if ($success === false)
        echo $DB_ERROR;
    ?>
</div>
<?php $content = ob_get_clean(); ?>