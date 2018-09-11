<?php

if (!is_dir($IMAGE_STORAGE_FULL_LOCATION))
    mkdir($IMAGE_STORAGE_FULL_LOCATION);

if (isset($_POST) && isset($_POST['image']) && isset($_POST['filter'])
    && ($imageSize = getimagesize($_POST['image']))
    && ($filter = substr($_POST['filter'], strrpos($_POST['filter'], '/') + 1))
    && file_exists($FILTERS_LOCATION_FULL . $filter))
{
    $filter = imagecreatefrompng($FILTERS_LOCATION_FULL . $filter);
    $finalImage = imagecreatetruecolor($IMAGE_WIDTH, $IMAGE_HEIGHT);
    $receivedImage = imagecreatefromstring(file_get_contents($_POST['image']));
    $fileName = $sessionManager->get_logged_user_name() . '_'
        . date( 'd_m_Y.H:i:s') .'.png';

    if (!imagecopyresampled($finalImage, $receivedImage,
        0, 0, 0, 0,
        $IMAGE_WIDTH, $IMAGE_HEIGHT, $imageSize[0], $imageSize[1])
        || !imagecopy($finalImage, $filter,
            0, 0, 0, 0,
            $IMAGE_WIDTH, $IMAGE_HEIGHT)
        || !imagepng($finalImage, $IMAGE_STORAGE_FULL_LOCATION . $fileName)
        || !imagedestroy($receivedImage) || !imagedestroy($filter)
        || !$postManager->new_post($sessionManager->get_logged_user_name(),
            $IMAGE_STORAGE_LOCATION . $fileName, $_POST['desc']))
    {
        header('HTTP/1.1 400 Bad Request');
    }
    else
    {
        header('HTTP/1.1 201 Created');
        die();
    }
}
else if (isset($_POST) && isset($_POST['image']))
    header('HTTP/1.1 400 Bad Request');
else
    require ($DOCUMENT_ROOT . "views/post.php");
