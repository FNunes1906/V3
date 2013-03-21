<?php

include_once('../../townwizard-db-api/global-api.php');

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<link rel="image_src" href="http://www.destinshines.com/partner/destinshines/images/logo/logo.png">   	
<meta property="og:image" content="http://www.destinshines.com/partner/destinshines/images/logo/logo.png">
<meta property="og:title" content="Destin | Event">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="index,follow" name="robots">
<meta content="text/html; charset=ISO-8859-1" http-equiv="Content-Type">
<link href="pics/homescreen.gif" rel="apple-touch-icon">
<meta content="minimum-scale=1.0, width=device-width, maximum-scale=0.6667, user-scalable=no" name="viewport">
<!--<link href="css/style.css" rel="stylesheet" media="screen" type="text/css" />-->
<link href="http://www.destinshines.com/components/com_shines_v2.1/css/style.css" rel="stylesheet" media="screen" type="text/css">
<script type="text/javascript" async="" src="http://www.google-analytics.com/ga.js"></script><script type="text/javascript">
var iWebkit;if(!iWebkit){iWebkit=window.onload=function(){function fullscreen(){var a=document.getElementsByTagName("a");for(var i=0;i<a.length;i++){if(a[i].className.match("noeffect")){}else{a[i].onclick=function(){window.location=this.getAttribute("href");return false}}}}function hideURLbar(){window.scrollTo(0,0.9)}iWebkit.init=function(){fullscreen();hideURLbar()};iWebkit.init()}}
</script>
<script language="javascript">
			function linkClicked(link) { document.location = link; } 
</script>
<title>Destin | Event</title>
<script type="text/javascript">
	// TOUCH-EVENTS SINGLE-FINGER SWIPE-SENSING JAVASCRIPT
	// this script can be used with one or more page elements to perform actions based on them being swiped with a single finger
	var triggerElementID = null; // this variable is used to identity the triggering element
	var fingerCount = 0;
	var startX = 0;
	var startY = 0;
	var curX = 0;
	var curY = 0;
	var deltaX = 0;
	var deltaY = 0;
	var horzDiff = 0;
	var vertDiff = 0;
	var minLength = 72; // the shortest distance the user may swipe
	var swipeLength = 0;
	var swipeAngle = null;
	var swipeDirection = null;	
	// The 4 Touch Event Handlers
	// NOTE: the touchStart handler should also receive the ID of the triggering element
	// make sure its ID is passed in the event call placed in the element declaration, like:
	// <div id="picture-frame" ontouchstart="touchStart(event,'picture-frame');"  ontouchend="touchEnd(event);" ontouchmove="touchMove(event);" ontouchcancel="touchCancel(event);">
	function touchStart(event,passedName) {
		// disable the standard ability to select the touched object
		// event.preventDefault();
		// get the total number of fingers touching the screen
		fingerCount = event.touches.length;
		// since we're looking for a swipe (single finger) and not a gesture (multiple fingers),
		// check that only one finger was used
		if ( fingerCount == 1 ) {
			// get the coordinates of the touch
			startX = event.touches[0].pageX;
			startY = event.touches[0].pageY;
			// store the triggering element ID
			triggerElementID = passedName;
		} else {
			// more than one finger touched so cancel
			touchCancel(event);
		}
}

	function touchMove(event) {
		//event.preventDefault();
		if ( event.touches.length == 1 ) {
			curX = event.touches[0].pageX;
			curY = event.touches[0].pageY;
		} else {
			touchCancel(event);
		}
}	

	function touchEnd(event) {
		event.preventDefault();
		// check to see if more than one finger was used and that there is an ending coordinate
		if ( fingerCount == 1 && curX != 0 ) {
			// use the Distance Formula to determine the length of the swipe
			swipeLength = Math.round(Math.sqrt(Math.pow(curX - startX,2) + Math.pow(curY - startY,2)));
			// if the user swiped more than the minimum length, perform the appropriate action
			if ( swipeLength >= minLength ) {
				caluculateAngle();
				determineSwipeDirection();
				processingRoutine();
				touchCancel(event); // reset the variables
			} else {
				touchCancel(event);
			}	
		} else {
			touchCancel(event);
		}
}

	function touchCancel(event) {
		// reset the variables back to default values
		fingerCount = 0;
		startX = 0;
		startY = 0;
		curX = 0;
		curY = 0;
		deltaX = 0;
		deltaY = 0;
		horzDiff = 0;
		vertDiff = 0;
		swipeLength = 0;
		swipeAngle = null;
		swipeDirection = null;
		triggerElementID = null;
	}

	function caluculateAngle() {
		var X = startX-curX;
		var Y = curY-startY
		var Z = Math.round(Math.sqrt(Math.pow(X,2)+Math.pow(Y,2))); //the distance - rounded - in pixels
		var r = Math.atan2(Y,X); //angle in radians (Cartesian system)
		swipeAngle = Math.round(r*180/Math.PI); //angle in degrees
		if ( swipeAngle < 0 ) { swipeAngle =  360 - Math.abs(swipeAngle); }
	}

	function determineSwipeDirection() {
		if ( (swipeAngle <= 45) && (swipeAngle >= 0) ) {
			swipeDirection = 'left';
		} else if ( (swipeAngle <= 360) && (swipeAngle >= 315) ) {
			swipeDirection = 'left';
		} else if ( (swipeAngle >= 135) && (swipeAngle <= 225) ) {
			swipeDirection = 'right';
		} else if ( (swipeAngle > 45) && (swipeAngle < 135) ) {
			swipeDirection = 'down';
		} else {
			swipeDirection = 'up';
		}
	}

	function processingRoutine() {
		var swipedElement = document.getElementById(triggerElementID);
		if ( swipeDirection == 'right' ) {
			// REPLACE WITH YOUR ROUTINES
			window.history.back()
		} 
	}

</script>
<meta content="destin, vacactions in destin florida, destin, florida, real estate, sandestin resort, beaches, destin fl, maps of florida, hotels, hotels in florida, destin fishing, destin hotels, best florida beaches, florida beach house rentals, destin vacation rentals for destin, destin real estate, best beaches in florida, condo rentals in destin, vacaction rentals, fort walton beach, destin fishing, fl hotels, destin restaurants, florida beach hotels, hotels in destin, beaches in florida, destin, destin fl" name="keywords">

<meta content="Destin Florida's FREE iPhone application and website guide to local events, live music, restaurants and attractions" name="description">

<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-31932515-1']);
  _gaq.push(['_setDomainName', 'auto']);
  _gaq.push(['_trackPageview']);

    				_gaq.push(['t2._setAccount', 'UA-11548891-1']);  
  				_gaq.push(['t2._trackPageview']);
		
  	(function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
	<link type="text/css" rel="stylesheet" href="chrome-extension://cpngackimfmofbokmjmljamhdncknpmg/style.css"><script type="text/javascript" charset="utf-8" src="chrome-extension://cpngackimfmofbokmjmljamhdncknpmg/page_context.js"></script></head>
	<body screen_capture_injected="true">
	<!--Google Adsense -->
	<div id="main" role="main" ontouchstart="touchStart(event,'list');" ontouchend="touchEnd(event);" ontouchmove="touchMove(event);" ontouchcancel="touchCancel(event);">
	<div class="social">
		<a class="fr" href="#"><img alt="Sign in with Twitter" src="images/twt-icon.png" /></a>
		<a class="fr" href="#"><img alt="Sign in with Facebook" src="images/fb-icon.png" /></a>
		<a class="fr">Sign in: </a>
	</div>
	<ul id="locationList" class="mainList"><li>



						<!-- Added by Doug Facebook Results Start -->


						<style type="text/css">

					.fl { float:left; }
					.fr { float:right; }
					.cb { clear:both; }
					.social {
						border:1px dotted #666;
						-webkit-border-radius: 10px;
						border-radius: 10px;
						padding-left:10px;
						position:absolute;
						top:0;
						right:0;
						z-index:2000;
						line-height:24px;
						margin:5px;
					}
					.social a {
						padding:5px 2px;
						margin-right:15px;
						display:block;
						color:#333;
					}
					ul li .moreInfo {
						float:left;
					}
					.fbEventImg {
						/*width:100%;*/
						margin:15px auto;
						display:block;
					}
					.when {
						margin:10px 0;
					}
						

						#Darkness {
						  background:rgba(0,0,0,.5);
						  position:fixed;
						  width:100%;
						  height:100%;
						  z-index:4000;
						  top:0;
						  left:0;
						  display:none;
						}
						.takeOverlay {
						  background:#e6e6e6;
						  -webkit-box-shadow:0 0 15px rgba(0,0,0,.31);
						  -moz-box-shadow:0 0 15px rgba(0,0,0,.31);
						  box-shadow:0 0 15px rgba(0,0,0,.31);
						  -webkit-border-radius:10px;
						  border-radius:10px; 
						  border:solid 2px #ff8a00;
						  width:94%;
						  height:auto;
						  position:absolute;
						  top:20px;
						  left:10px;
						  z-index:4001;
						  padding-bottom:20px;
						  display:none;
						}
						.takeOverlay .pad {
							padding:10px;
						}
						.takeOverlay .close {
						  background:#e6e6e6;
						  -webkit-box-shadow:0 0 15px rgba(0,0,0,.31);
						  -moz-box-shadow:0 0 15px rgba(0,0,0,.31);
						  box-shadow:0 0 15px rgba(0,0,0,.31);
						  -webkit-border-radius:50px;
						  border-radius:50px; 
						  border:solid 2px #ff8a00;
						  width:18px;
						  height:18px;
						  display:block;
						  position:absolute;
						  top:-10px;
						  right:-10px;
						  font-size:12px;
						  line-height:16px;
						  text-align:center;
						  cursor:pointer;
						  text-decoration:none;
						}
						#VidPanel.takeOverlay, 
						#VidPanel.takeOverlay .close {
						  background:#000;
						  color:#fff;
						}
						.takeOverlay span {
						  padding:10px;
						  font-size:18px;
						  line-height:28px;
						  display:block;
						  text-align:center;
						}
						.takeOverlay h5 {
						  font-size:16px;
						  margin-bottom:15px;
						}
						.takeOverlay .details {
						  font-size:13px;
						  line-height:18px;
						}
						.takeOverlay .socialLinks {
						  margin:20px 33%;
						  text-align:center;
						  height:auto;
						}
						.takeOverlay .socialLinks a {
						  display:block;
						  height:45px;
						  display:block;
						  position:relative;
						  text-align:center;
						}
						.takeOverlay .fbLogin {
						  background:url('images/fbLoginBtn.png') no-repeat left top;
						  width:121px;
						}
						.takeOverlay .twtLogin {
						  background:url('images/twtLoginBtn.png') no-repeat left top;
						  width:113px;
						  margin-left:4px;
						  margin-top:20px;
						}
						.takeOverlay .fbLogin span, 
						.takeOverlay .twtLogin span {
						  font-size:10px;
						  color:#666;
						  text-transform:uppercase;
						  line-height:10px;
						  position:absolute;
						  top:10px;
						  left:39px;
						  padding:0;
						}
						.takeOverlay .rsvp {
						  margin:40px 27% 20px;
						  text-align:left;
						  height:auto;
						}
						.takeOverlay .rsvp a {
						  display:block;
						  height:30px;
						  padding-left:35px;
						  font-size:14px;
						  color:#666;
						  text-transform:uppercase;
						  line-height:30px;
						  text-align:left;
						  margin:20px 0;
						  text-decoration:none;
						}
						.takeOverlay .rsvp a:hover {
						  text-decoration:underline;
						}
						.takeOverlay a.yes {
						  background:url('images/yesBtn.png') no-repeat left top;
						}
						.takeOverlay a.no {
						  background:url('images/noBtn.png') no-repeat left top;
						}
						.takeOverlay a.maybe {
						  background:url('images/maybeBtn.png') no-repeat left top;
						}
						#AttendancePanel .attendeeList {
						  text-align:left;
						  height:300px;
						  overflow:auto;
						}
						#AttendancePanel .attendeeList .attendee {
						  clear:both;
						  padding:5px 0;
						  width:55%;
						  line-height:20px;
						  margin:auto;
						}
						#AttendancePanel .attendeeList .attendee img {
						  width:50px;
						  height:50px;
						  margin-bottom:15px;
						  margin-right:30px;
						}
					</style>

					<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

					<script>

					jQuery(document).ready(function() {
						//Bind all modal buttons
					  jQuery('a[data-ref-panel]').each(function() {
					    jQuery(this).click(showTip);
					  });

					});


				  var showTip = function(refPanel) {
					  if (typeof(refPanel) != "string") {
					    var refPanel = '#' + jQuery(this).data('ref-panel');
					  }
					  jQuery('#Darkness').fadeIn('fast',function() {
					    jQuery(refPanel).fadeIn();
					    jQuery(refPanel + ' .close, #Darkness, ' + refPanel + ' .socialLinks a').click(function() {
					      hideTip(refPanel);
					    });
					    if (refPanel == "#LoginPanel") {
					      jQuery(refPanel + ' .socialLinks a').unbind('click').click(passLoginGate);
					    }

					    //Dynamically add YouTube embed code and description to VidPanel overlay
					    if (refPanel == "#VidPanel") {
					      jQuery('.vidModalHolder').html('<iframe width="420" height="315" src="https://www.youtube.com/embed/RfrueeBmfXo?rel=0" frameborder="0" allowfullscreen></iframe><p>Video description goes here</p>');
					    }

					  });
					}

					var hideTip = function(refPanel) {
					  jQuery(refPanel).fadeOut('fast',function() {
					    
					    //If there is a YouTube player, remove it when modal is closed so it does not continue to play
					    if (jQuery('.vidModalHolder').length) {
					      jQuery('.vidModalHolder').html('');
					    }
					    
					    jQuery('#Darkness').fadeOut();
					  });
					}

					var passLoginGate = function() {
					  var refPanel = '#' + jQuery(this).data('ref-panel');
					  jQuery('.takeOverlay').fadeOut('fast', function() {
					    showTip(refPanel);
					  });
					}


  				</script>


				

  				<?php if(empty($_GET['zip'])) { ?>

					    Search locations<br/><br/>
					    
					    <form id="locations_form" method="get" action="outside-locations.php"> 
					        <input type="text" name="zip" /><br/>
					        <input type="submit" />
					    </form>

					<?php } else {
					    
					    $fbLocations = tw_global_locations($_GET['zip']);

					    if(!empty($fbLocations)) {
						    foreach($fbLocations as $e) {
						        echo '<li id="' . $e->id . '">';
						        echo '<h3 class="fr">';
				        			if (isset($e->street)) {
				        				echo '<div>' . $e->street . '</div>';
				        			}
				        			echo '<div>';
					        			if (isset($e->city)) {
					        				echo $e->city . ', ';
					        			}
					        			if (isset($e->state)) {
					        				echo $e->state . ' ';
					        			}
					        			if (isset($e->zip)) {
					        				echo $e->zip;
					        			}
				        			echo '</div>';
				        			echo "<div>" . $e->phone . "</div>"; 
				        		echo '</h3>';
						        echo "<h1>" . $e->name . "</h1>";
						        echo '<h2>';
						        	echo $e->category;
						        echo '</h2>';
						        echo '<ul class="btnList">';
							        echo '<li><a href="javascript:void(0);tel:' . preg_replace('/(\W*)/', '', $e->phone) . '" class="button small">call</a></li>';
							        if (isset($e->latitude) && isset($e->longitude)) {
												echo '<li><a class="button small" href="javascript:linkClicked(\'APP30A:FBCHECKIN:' . $e->latitude . ':' . $e->longitude . '\')">check in</a></li>';
												echo '<li><a class="button small" href="javascript:linkClicked(\'APP30A:SHOWMAP:' . $e->latitude . ':' . $e->longitude . '\')">map</a></li>';
											}
										echo '</ul>';
						        echo '</li>';



						        //var_dump($e);
						    }
						}


					} 

					?>




					<!-- Added by Doug Facebook Results End -->



				</ul>


		<div style="float:left;padding:3px 3px 3px 8px;">
		<a expr:share_url="data:post.url" href="http://www.facebook.com/sharer.php?u=http://www.destinshines.com/event_details.php?event_id=3640%26title=Rudy Applewhite%26date=2013-03-04%26rp_id=14225" name="fb_share" type="box_count">
				<div class="facebook">
				</div>
			</a>
			<!--
		<script src='http://static.ak.fbcdn.net/connect.php/js/FB.Share' type='text/javascript'>
	</script>
	-->
		</div>
<div style="float:left;padding:3px 3px 3px 8px;">
<a href="https://plus.google.com/share?url=http://www.destinshines.com/event_details.php?event_id=3640%26title=Rudy Applewhite%26date=2013-03-04%26rp_id=14225" onclick="javascript:window.open(this.href,'','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
<div class="google">
</div>
</a>
</div>
</div>



	<div id="Darkness"></div>

  <!-- Login Overlay Start -->

  <div id="LoginPanel" class="takeOverlay">
    <a class="close">x</a>
    <span>
      You must login in order to RSVP to events on Social Life Merida.
      <div class="socialLinks cb">
        <a class="fbLogin" data-ref-panel="RsvpPanel" href="#"><span>Login with</span></a>
        <a class="twtLogin" data-ref-panel="RsvpPanel" href="#"><span>Login with</span></a>
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
        Sonic Youth: The Eternal Tour at<br />
        Alys Beach Ampitheater<br />
        West Philadelphia, PA<br />
        at 8PM Today?
      </p>
      <div class="socialLinks rsvp cb">
        <a class="yes" href="#">Attending</a>
        <a class="maybe" href="#">Maybe</a>
        <a class="no" href="#">Not Attending</a>
      </div>
    </span>
  </div>

  <!-- RSVP Overlay End -->

  <!-- Attendance Overlay Start -->

  <div id="AttendancePanel" class="takeOverlay">
    <a class="close">x</a>
    <span>
      <h5 class="bold">50 are Attending</h5> 
      <div class="attendeeList">
        <div class="attendee">
          <img class="fl" alt="" src="images/person1.jpg" />
          Jack Faceson
        </div>
        <div class="attendee">
          <img class="fl" alt="" src="images/person3.jpg" />
          Emily Jones
        </div>
        <div class="attendee">
          <img class="fl" alt="" src="images/person4.jpg" />
          Mort Finchelman
        </div>
        <div class="attendee">
          <img class="fl" alt="" src="images/person5.jpg" />
          Jamie Forthun
        </div>
        <div class="attendee">
          <img class="fl" alt="" src="images/person6.jpg" />
          Nadia Temple
        </div>
        <div class="attendee">
          <img class="fl" alt="" src="images/person7.jpg" />
          Ingleford Brummington Carver
        </div>
        <div class="attendee">
          <img class="fl" alt="" src="images/person8.jpg" />
          Steve
        </div>
      </div>
    </span>
  </div>

  <!-- Attendance Overlay End -->


</body>
</html>