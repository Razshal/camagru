<?php
if (isset($_POST) && isset($_POST['image'])
    && isset($_POST['filter'])
    && ($imageSize = getimagesize($_POST['image'])))
{
    $width = 1280;
    $height = 720;
    $finalImage = imagecreatetruecolor($width, $height);
    $receivedImage = imagecreatefromstring(file_get_contents($_POST['image']));
    var_dump($imageSize);
    var_dump($receivedImage);

    imagecopyresampled($finalImage, $receivedImage,
        0, 0, 0, 0,
        $width, $height, $imageSize[0], $imageSize[1]);
    imagedestroy($receivedImage);
    imagepng($finalImage, $_SERVER["DOCUMENT_ROOT"]
        . '/user_images/'. $sessionManager->get_logged_user_name()
        . '_' . date( 'd_m_Y.H:i:s') .'.png');
}
else if (isset($_POST) && isset($_POST['image']))
    header('HTTP/1.1 400 Bad Request');
else
    require ($_SERVER["DOCUMENT_ROOT"] . "/views/post.php");
