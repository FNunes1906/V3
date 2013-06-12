<?php

include_once('../townwizard-db-api/global-api.php');

$zip  = isset($_GET['zip']) ? $_GET['zip'] : NULL;
$cat  = isset($_GET['cat']) ? $_GET['cat'] : NULL;
$s    = isset($_GET['s']) ? $_GET['s'] : NULL;
$l    = isset($_GET['l']) ? $_GET['l'] : NULL;
$page = isset($_GET['page']) ? $_GET['page'] : 1;

$qString = tw_global_query_string($zip, $l, $cat, $s, $page);
$pageOfLocations = tw_global_locations($qString);
if(!empty($pageOfLocations)) {
    $directoryLocations = $pageOfLocations->objects;
    $currentPage        = $pageOfLocations->page;
    $hasMore            = $pageOfLocations->more;
}

if(!empty($directoryLocations)) { 
    foreach($directoryLocations as $e) {
        echo '<li id="' . $e->id . '">';
        echo '<h3 class="fr">';
        if (isset($e->street)) echo '<div>' . $e->street . '</div>';
        echo '<div>';
        if (isset($e->city)) echo $e->city . ', ';
        if (isset($e->state)) echo $e->state . ' ';
        if (isset($e->zip)) echo $e->zip;                            
        echo '</div>';
        if (isset($e->phone)) echo "<div>" . $e->phone . "</div>"; 
        echo '</h3>';
        echo "<h1>" . $e->name . "</h1>";
        echo '<h2>';
        echo $e->category;
        echo '</h2>';
        echo '<ul class="btnList">';
        echo '<li><a href="tel:' . preg_replace('/(\W*)/', '', $e->phone) . '" class="button small">call</a></li>';
        if (isset($e->latitude) && isset($e->longitude)) {
            echo '<li><a class="button small" href="javascript:linkClicked(\'APP30A:FBCHECKIN:' . $e->latitude . ':' . $e->longitude . '\')">check in</a></li>';
            echo '<li><a class="button small" href="javascript:linkClicked(\'APP30A:SHOWMAP:' . $e->latitude . ':' . $e->longitude . '\')">map</a></li>';
        }
        echo '</ul>';
        echo '</li>';
    }

    if($hasMore) {
        echo '<li onclick="submitCategory(' . ($currentPage+1) . ');"><h1 style="text-align:center">More</div></h1></li>';
    }

} else if(isset($s)) { 
    echo '<p>Sorry, there were no results for your search.</p>';
}
?>