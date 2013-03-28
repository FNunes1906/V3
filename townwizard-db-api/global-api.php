<?php

include_once('user-api.php');

define("TOWNWIZARD_DB_GLOBAL_EVENTS_URL", "http://www.townwizardconnectinternal.com/g/events");
define("TOWNWIZARD_DB_GLOBAL_LOCATIONS_URL", "http://www.townwizardconnectinternal.com/g/locations");
define("TOWNWIZARD_DB_GLOBAL_LOCATION_CATEGORIES_URL", "http://www.townwizardconnectinternal.com/g/lcategories");

/***
  Get events
***/
function tw_global_events($queryString) {
    return _get_global_objects(TOWNWIZARD_DB_GLOBAL_EVENTS_URL, $queryString);
}

/***
  Get locations
***/
function tw_global_locations($queryString) {
    return _get_global_objects(TOWNWIZARD_DB_GLOBAL_LOCATIONS_URL, $queryString);
}

/***
  Get location categories
***/
function tw_global_location_categories($queryString) {
    return _get_global_objects(TOWNWIZARD_DB_GLOBAL_LOCATION_CATEGORIES_URL, $queryString);
}

/***
  Compose a query string for global locations, location categories, or event retrieval.
  Use this query string to call methods above.
***/
function tw_global_query_string($zip, $location, $mainCategory, $categories) {
    $qs = "?";
    
    if(!empty($zip)) $qs = $qs."zip=".$zip;
    else if(!empty($location)) $qs = $qs."l=".$location;
    else {
        $ip = $_SERVER['REMOTE_ADDR'];
        if(!empty($ip)) {
            $qs = $qs."ip=".$ip;              
        }
    }
    
    if(!empty($mainCategory)) {
        if($qs != "?") $qs = $qs."&";
        $qs = $qs."cat=".$mainCategory;
    }

    if(!empty($categories)) {
        if($qs != "?") $qs = $qs."&";
        $qs = $qs."s=".$categories;
    }

    if($qs != "?") return $qs;
    return "";
}

//////////////// private functions
function _get_global_objects($url, $queryString) {
    list($status, $response_msg) = _tw_get_json($url, $queryString);
    if($status == 200) {
        $objects = json_decode($response_msg);
        return $objects;
    }
    return NULL;
}


?>