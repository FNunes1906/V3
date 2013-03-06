<?php

require_once('../jevents.php');
include_once('user-api.php');

function tw_external_login($login_url) {

  if(isset ($_GET['l']))    $location = $_GET['l'];    
  if(isset ($_GET['uid']))  $user_id = $_GET['uid'];

  if(empty($user_id)) {  //if user id is empty, we need to call FB or twitter login url

    //redirect the page to the login url
    if(empty($location)) {
      echo '<script>window.location.href="'.$login_url.'?l="+window.opener.location.href;</script>';
    } else {
      echo '<script>window.location.href="'.$login_url.'?l='.$location.'";</script>';
    }

  } else { //this is the second call to this page, when the user id and redirect location is known
    //login the user (this will add the user to the session)
    tw_login_with_id($user_id);

    //redirect to the location.  For mobile page open in the same page; for the site open in the parent page    
    echo '<script>';    
    echo 'if(window.opener) {';
    echo '  window.opener.location.href="'.$location.'";';
    echo '  window.close();';
    echo '} else {';
    echo '  window.location.href="'.$location.'";';
    echo '}';
    echo '</script>';
  }
}

?>