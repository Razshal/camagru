<?php
if ($database !== NULL)
    $success = $database->initiate();
else
    $success = false;
ob_start();
?>
<div>
    <h2>Setup tried</h2>
    <?php
    if ($success === true)
        $info = $info . "<p class='success'>Website is ok</p>";
    ?>
</div>
<?php $content = ob_get_clean(); ?>