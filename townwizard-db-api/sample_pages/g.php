<?php

include_once('../global-api.php');

?>

<html>
<head></head>
<body>

<?php 

/*
var_dump(all_categories_by_zip());
echo ("<br/><br/>");

var_dump(restaurant_categories_by_zip());
echo ("<br/><br/>");

var_dump(directory_categories_by_location());
echo ("<br/><br/>");


var_dump(locations_by_location_and_word_wedding());
echo ("<br/><br/>");

var_dump(locations_by_ip_and_word_wedding());
echo ("<br/><br/>");

var_dump(events_by_location());
echo ("<br/><br/>");
*/

echo zip_by_location();
echo ("<br/><br/>");

function all_categories_by_zip() {
    $qs = tw_global_query_string("10308", NULL, NULL, NULL);
    echo $qs."<br/><br/>";
    return tw_global_location_categories($qs);    
}

function restaurant_categories_by_zip() {
    $qs = tw_global_query_string("10308", NULL, "restaurants", NULL);
    echo $qs."<br/><br/>";
    return tw_global_location_categories($qs);    
}

function directory_categories_by_location() {
    $qs = tw_global_query_string(NULL, "37.422006,-122.084095", "directory", NULL);
    echo $qs."<br/><br/>";
    return tw_global_location_categories($qs);    
}

function locations_by_location_and_word_wedding() {
    $qs = tw_global_query_string(NULL, "37.422006,-122.084095", "directory", "wedding");
    echo $qs."<br/><br/>";
    return tw_global_locations($qs);    
}

function locations_by_ip_and_word_wedding() {
    $qs = tw_global_query_string(NULL, NULL, "directory", NULL);
    echo $qs."<br/><br/>";
    return tw_global_locations($qs);    
}

function events_by_location() {
    $qs = tw_global_query_string(NULL, "37.422006,-122.084095", NULL, NULL);
    echo $qs."<br/><br/>";
    return tw_global_events($qs);    
}

function zip_by_location() {
    $qs = tw_global_query_string(NULL, "37.422006,-122.084095", NULL, NULL);    
    return tw_global_zip_code($qs);
}

?>



</body>
</html>