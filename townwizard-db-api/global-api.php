<?php

include_once('user-api.php');

define("TOWNWIZARD_DB_GLOBAL_EVENTS_URL", "http://www.townwizardconnect.com/g/events");

/***
  Takes a search string or zip and returns an array of events.
***/
function tw_global_events($searchStringOrZip) {

    if(_is_zip($searchStringOrZip)) {
        $params = '?zip='.$searchStringOrZip;
    } else {
        $params = '?s='.urlencode($searchStringOrZip);
    }

    list($status, $response_msg) = _tw_get_json(TOWNWIZARD_DB_GLOBAL_EVENTS_URL, $params);
    if($status == 200) {
        $events = json_decode($response_msg);
        return $events;
    }

    return NULL;
}


//////////////// private functions
function _is_zip($str) {
    return preg_match ('/^[0-9]{5}$/', $str);
}

?>