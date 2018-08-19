<?php
require ($_SERVER["DOCUMENT_ROOT"] . "/views/post.php");

if (isset($_FILES) && isset($_FILES[0]))
{
    if ($array = getimagesize($_FILES[0]))
    {
        print 'success';
    }

}
