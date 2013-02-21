<?php 
if($_POST && !empty($_POST)){
	tw_create_rsvp($_POST);
}?>


<?php 

	/* Creating array for RSVP user in $arr_rsvpuser */
	$arr_rsvpuser = tw_get_rsvps_by_event($_REQUEST['evid']);

	/* Varialbe for Looping */
	$i = 0;
?>

<!-- Click here to RSVP & RSVP Attendance Picture code -->
<a class="rsvpBtn bold" data-ref-panel="LoginPanel" href="#">Click here to RSVP</a>
<div class="checkins fl">
	<div class="pad">
		<span>5 attending:</span>
		<?php
		//Looping RSVP data object to get RSVP User image
		foreach($arr_rsvpuser as $value){
			//Fetching All RSVP user image profile from social site
			$img_url = tw_get_user_image_url($arr_rsvpuser[$i]->user);
			//Printg user profile Image from social site
			echo "<img class='fl' src=$img_url />";	
			//Increment varialbe
			$i++;
		}
		?>
		<a class="seeAll fl" data-ref-panel="AttendancePanel" href="#">See all »</a>
	</div>
</div>


<?php
if(empty($_POST))  {
	if($_SESSION['tw_user_name']){ ?> 
		<!-- Code for RSVP begin here --> 
		<!-- <form id="rsvp_form" method="POST" onsubmit="tw_create_rsvp();"> -->
		<!--<form id="rsvp_form" method="POST" action="">
			Please enter your reponse.<br/><br/>
			<input type="hidden" value="<?php echo $_REQUEST['evid']?>" name="eventId" />
			<input type="hidden" value="" name="eventDate" />
			<b>Yes <input type="radio" name="value" value="Y"/>
			No <input type="radio" name="value" value="N" />
			May be <input type="radio" name="value" value="M" />&nbsp;&nbsp;
			</b>
			<input type="submit" name="Submit" />
		</form>-->
		 <!-- Code for RSVP End here --> 
	<?php }else{ ?>

		
		
		
		<div id="panel">
			<a href="javascript:void(0)" onclick="fb_login();"><img alt="Login with Facebook" src="<?php echo "http://".$_SERVER['HTTP_HOST'] ?>/templates/townwizard/images/header/fbLoginBtn.png" /></a>
			<a href="javascript:void(0)" onclick="twitter_login();"><img alt="Login with Twitter" src="<?php echo "http://".$_SERVER['HTTP_HOST'] ?>/templates/townwizard/images/header/twtLoginBtn.png" /></a>
			</div>
	<?php } 
}
?>
<!-- Attendance Overlay Start -->

  <div id="AttendancePanel" class="takeOverlay">
    <a class="close">x</a>
    <span>
      <h5 class="bold">50 are Attending</h5> 
      <div class="attendeeList">
        <div class="attendee">
          <img class="fl" alt="" src="images/mock/faces/person1.jpg" />
          Jack Faceson
        </div>
        <div class="attendee">
          <img class="fl" alt="" src="images/mock/faces/person3.jpg" />
          Emily Jones
        </div>
        <div class="attendee">
          <img class="fl" alt="" src="images/mock/faces/person4.jpg" />
          Mort Finchelman
        </div>
        <div class="attendee">
          <img class="fl" alt="" src="images/mock/faces/person5.jpg" />
          Jamie Forthun
        </div>
        <div class="attendee">
          <img class="fl" alt="" src="images/mock/faces/person6.jpg" />
          Nadia Temple
        </div>
        <div class="attendee">
          <img class="fl" alt="" src="images/mock/faces/person7.jpg" />
          Ingleford Brummington Carver
        </div>
        <div class="attendee">
          <img class="fl" alt="" src="images/mock/faces/person8.jpg" />
          Steve
        </div>
      </div>
    </span>
  </div>

  <!-- Attendance Overlay End -->