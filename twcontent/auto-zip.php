<?php

include_once('../townwizard-db-api/global-api.php');


$lat = isset($_GET['lat']) ? $_GET['lat'] : NULL;
$lon = isset($_GET['lon']) ? $_GET['lon'] : NULL;
$l   = isset($lat) && isset($lon) ? $lat.",".$lon : (isset($_GET['l']) ? $_GET['l'] : NULL);

$qString = tw_global_query_string(NULL, $l, NULL, NULL);
echo tw_global_zip_code($qString);

?>