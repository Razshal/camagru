<?php
if (isset($_POST) && isset($_POST['image'])
    && isset($_POST['filter'])
    && ($imageSize = getimagesize($_POST['image'])))
{
    $width = 1280;
    $height = 720;
    $finalImage = imagecreatetruecolor($width, $height);

    imagecopyresized($finalImage, $_POST['image'],
        0, 0, 0, 0,
        $width, $height, $imageSize[0], $imageSize[1]);
    file_put_contents(
        $_SERVER["DOCUMENT_ROOT"] . '/user_images/test.jpg',
        file_get_contents($finalImage));
}
else if (isset($_POST) && isset($_POST['image']))
    header('HTTP/1.1 400 Bad Request');
else
    require ($_SERVER["DOCUMENT_ROOT"] . "/views/post.php");
