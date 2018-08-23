<?php
$filters = scandir($FILTERS_LOCATION_FULL);
$array = array();

foreach ($filters as $filter)
{
    if ($filter !== '.' && $filter !== '..')
    array_push($array, $FILTERS_LOCATION . $filter);
}
header('Content-Type: application/json;charset=utf-8');
echo json_encode($array, JSON_FORCE_OBJECT);
die();
