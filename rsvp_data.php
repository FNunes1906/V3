<?php if($_POST && !empty($_POST))
{ tw_create_rsvp($_POST); }
?>

<?php 
	//Creating array for RSVP user in $arr_rsvpuser
	$arr_rsvpuser = tw_get_rsvps_by_event($_REQUEST['evid']);
	
	/* Need to address later */
	//$eventDetail = getEventDetail($_REQUEST['evid']);
	
	//Varialbe for Looping
	$i = 0;
	$imgCnt = 0;
	
	// function to count all RSVP user with Y
	$userCount = rsvpUserCnt($arr_rsvpuser);
	
	//echo "<pre>";
	//print_r($arr_rsvpuser);
?>

<script>

function rsvpSubmit(rsvpvalue){
	document.getElementById('value').value = rsvpvalue;
	document.rsvp_form.submit();
}
</script>

<!--<div id="Feat" class="centerCol fl">-->
<div id="yogi">
	<!--<div id="EventDetail" class="detailFeature sect">-->
		<div class="clickrsvp">
			<!-- Map here -->
			<?php if($_SESSION['tw_user_name']): ?>
				<a class="rsvpBtn bold" data-ref-panel="RsvpPanel" href="#">Click here to RSVP</a>
			<?php else : ?>	
				<a class="rsvpBtn bold" data-ref-panel="LoginPanel" href="#">Click here to RSVP</a>
			<?php endif; ?>
		</div>

		<div class="clickrsvp1">
			<div class="checkins fl" style="float:right;margin-top:20px;">
				<div class="pad">
					<span><?php echo $userCount ?> attending:</span>
					<?php
					//Looping RSVP data object to get RSVP User image
					foreach($arr_rsvpuser as $value){

						if($arr_rsvpuser[$i]->value == 'Y'){
							//Printg user profile Image from social site
							echo "<img class='fl' src=".tw_get_user_image_url($arr_rsvpuser[$i]->user)." />";	
							//echo $arr_rsvpuser[$i]->value;
							//echo "<br>";
							//echo $arr_rsvpuser[$i]->value;
							$imgCnt += 1;
						}	
							//Increment varialbe and total image count to break loop
							$i++; if($imgCnt >= 5) break;
					}?>
					<a class="seeAll fl" data-ref-panel="AttendancePanel" href="#">See all &raquo;</a>
				</div>
			</div>
			<div class="cb"></div>
		</div>
</div> 
<!--</div>-->
 <form id="rsvp_form" name="rsvp_form" method="post" action="">
        <input type="hidden" value="<?php echo $_REQUEST['evid'];?>" name="eventId" />
        <input type="hidden" value="" name="eventDate" />
        <!--<input type="text" name="value" id="value" /><br/>-->
        <input type="hidden" name="value" id="value" /><br/>
        <!--<input type="submit" name="Submit" />-->
    </form>
<div id="Darkness"></div>

<!-- Login Overlay Start -->

<div id="LoginPanel" class="takeOverlay">
	<a class="close">x</a>
	<span>
		You must login in order to RSVP to events on <?php echo $var->site_name;?>.
		<div class="socialLinks cb">
			<a class="fbLogin fl" href="javascript:void(0)" onclick="fb_login();"><span><?php echo JText::_("TW_LOGIN_WITH") ?></span></a>
        	<a class="twtLogin fl" href="javascript:void(0)" onclick="twitter_login();"><span><?php echo JText::_("TW_LOGIN_WITH") ?></span></a>
			<!--<a class="fbLogin" data-ref-panel="RsvpPanel" href="#"><span>Login with</span></a>
			<a class="twtLogin" data-ref-panel="RsvpPanel" href="#"><span>Login with</span></a>-->
		</div>
	</span>
</div>

<!-- Login Overlay End -->

<!-- RSVP Overlay Start -->
<div id="RsvpPanel" class="takeOverlay">
	<a class="close">x</a>
	<span>
		<h5 class="bold">Do you plan to attend?</h5> 
		<p class="details">
			<?php echo $_REQUEST['title']?> : at<br />
			Alys Beach Ampitheater<br />
			West Philadelphia, PA<br />
			at 8PM Today?
		</p>
		<div class="socialLinks rsvp cb">
			<a class="yes" href="#" onclick="rsvpSubmit('Y');">Attending</a>
			<a class="maybe" href="#" onclick="rsvpSubmit('M');">Maybe</a>
			<a class="no" href="#" onclick="rsvpSubmit('N');">Not Attending</a>
		</div>
	</span>
</div>
<!-- RSVP Overlay End -->

<!-- Attendance Overlay Start -->

<div id="AttendancePanel" class="takeOverlay">
	<a class="close">x</a>
	<span>
		<h5 class="bold"><?php echo $userCount ?> are Attending</h5> 
		<div class="attendeeList">
			<?php
				$i=0;
				foreach($arr_rsvpuser as $value){
					if($arr_rsvpuser[$i]->value == 'Y'){
						echo "<div class='attendee'>";
						echo "<img class='fl' src=".tw_get_user_image_url($arr_rsvpuser[$i]->user)." />";	
						echo $arr_rsvpuser[$i]->user->name;
						echo "</div>";
					}	
					$i++;
				}?>
		</div>
	</span>
</div>

<!-- Attendance Overlay Etart -->

<?php 

/* RSVP user count
 * Parameter : User array
 * Return : Total RSVP user count
 * Type : Integer
 * Developer : Yogi
 */
 
function rsvpUserCnt($arr_rsvpuser){
$userCount = 0;
$i = 0;
 	// Count total numebr of user attending this event
	foreach($arr_rsvpuser as $value){
		if($arr_rsvpuser[$i]->value == 'Y'){ $userCount += 1; }
		$i++;
	}
	return $userCount;
}

/* RSVP Event detail
 * Parameter : Event ID
 * Return : Event detail array
 * Return Type : Array
 * Developer : Yogi
 */
 
/*function getEventDetail($eventId){

 	// Count total numebr of user attending this event
	foreach($arr_rsvpuser as $value){
		if($arr_rsvpuser[$i]->value == 'Y'){ $userCount += 1; }
		$i++;
	}
	return $userCount;
}
*/
?>