<?php
if (isset($_POST) && isset($_POST['image'])
    && isset($_POST['filter'])
    && ($imageSize = getimagesize($_POST['image']))
    && ($filter = substr($_POST['filter'], strrpos($_POST['filter'], '/') + 1))
    && file_exists($_SERVER["DOCUMENT_ROOT"] . '/views/camera/filters/' . $filter))
{
    $width = 1280;
    $height = 720;
    $filter = $_SERVER["DOCUMENT_ROOT"] . '/views/camera/filters/' . $filter;
    $finalImage = imagecreatetruecolor($width, $height);
    $receivedImage = imagecreatefromstring(file_get_contents($_POST['image']));

    if (!imagecopyresampled($finalImage, $receivedImage,
        0, 0, 0, 0,
        $width, $height, $imageSize[0], $imageSize[1])
        || !imagedestroy($receivedImage)
        || !($filter = imagecreatefrompng($filter))
        || imagecopy($finalImage, $filter,
            0, 0, 0, 0,
            $width, $height)
        || !imagedestroy($filter)
        || !imagepng($finalImage, $_SERVER["DOCUMENT_ROOT"]
        . '/user_images/'. $sessionManager->get_logged_user_name()
        . '_' . date( 'd_m_Y.H:i:s') .'.png'))
    {
        header('HTTP/1.1 400 Bad Request');
        var_dump($filter);
    }
    else
        header('HTTP/1.1 201 Created');
}
else if (isset($_POST) && isset($_POST['image']))
    header('HTTP/1.1 400 Bad Request');
else
    require ($_SERVER["DOCUMENT_ROOT"] . "/views/post.php");
