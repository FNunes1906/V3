<?php echo "hello"; ?>
<div id="Feat" class="centerCol fl">
	<div id="EventDetail" class="detailFeature sect">
		<div class="evtTmb fr">
			<!-- Map here -->
			<img alt="" src="images/mock/lists/feat.jpg" />
			<a class="rsvpBtn bold" data-ref-panel="LoginPanel" href="#">Click here to RSVP</a>
		</div>

		<div class="people cb">
			<div class="checkins fl">
				<div class="pad">
					<span>50 attending:</span>
					<img class="fl" alt="" src="images/mock/faces/person1.jpg" />
					<img class="fl" alt="" src="images/mock/faces/person2.jpg" />
					<img class="fl" alt="" src="images/mock/faces/person3.jpg" />
					<img class="fl" alt="" src="images/mock/faces/person4.jpg" />
					<img class="fl" alt="" src="images/mock/faces/person5.jpg" />
					<a class="seeAll fl" data-ref-panel="AttendancePanel" href="#">See all &raquo;</a>
				</div>
			</div>
			<div class="cb"></div>
		</div>
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

<!-- Attendance Overlay Etart -->