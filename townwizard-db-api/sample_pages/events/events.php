<?php

include_once('../../global-api.php');

?>

<html>
<head></head>
<body>

<?php if(empty($_POST)) { ?>

    Search events<br/><br/>
    
    <form id="events_form" method="post" action="events.php"> 
        <input type="text" name="search_text" /><br/>
        <input type="submit" name="Submit" />
    </form>

<?php } else {
    
    $events = tw_global_events($_POST['search_text']);

    foreach($events as $e) {
        echo "<br/></br/>";
        echo $e->name; 

        echo "<br/>";

        var_dump($e);
    }
} 

?>

</body>
</html>