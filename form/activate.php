<?php

$con = mysql_pconnect("localhost","root","bitnami");
if (!$con){die('Could not connect: ' . mysql_error($con));}
$dblink = mysql_select_db("master");


if (isset($_REQUEST['createguide'])) { 
    
		//calling of creating internal site

		$querystring = "id=2&token=EBDBB91F-BCFE-4f00-AFF5-F33F19A345E8&email=".$_REQUEST['email']."&password=".$_REQUEST['pass']."&guideinternalurl=".$_REQUEST['gname']."&guidezipcode=".$_REQUEST['zip']."&timezone=".$_REQUEST['time_zone']."&language=".$_REQUEST['language']."&tformat=".$_REQUEST['time_format']."&dformat=".$_REQUEST['date_format']."&wunit=".$_REQUEST['temperature']."&dunit=".$_REQUEST['distance'];
		//$querystring = "signuptype=website&email=".$_REQUEST['email'];
		//echo $querystring;

		header("Location: http://operations.townwizard.com/internal_cms_create.php?".$querystring);
		
		//update status for user
		//user_status = 1 = Active
		//signup_type = 0 = Email
    
		//$updateuser="UPDATE user_signup SET signup_type = '0', user_status = '1' WHERE activation = '".$_REQUEST['key']."' ";
                
		//$result = mysql_query($updateuser);
	
		// Send the email:
		//$twadminemail = "info@townwizard.com";
		//$message = " First Name : ".$_REQUEST['fname']."\n";
		$message.= " Last Name : ".$_REQUEST['lname']."\n";
		$message.= " Email : ".$_REQUEST['email']."\n";
		$message.= " Guide Name : ".$_REQUEST['gname']."\n";
		$message.= " Zip Code : ".$_REQUEST['zip']."\n";
		$message.= " Time zone : ".$_REQUEST['time_zone']."\n";
		$message.= " Language : ".$_REQUEST['language']."\n";
		$message.= " Time Format : ".$_REQUEST['time_format']."\n";
		$message.= " Date Format : ".$_REQUEST['date_format']."\n";
		$message.= " Temperature : ".$_REQUEST['temperature']."\n";
		$message.= " Distance : ".$_REQUEST['distance']. "";
		
		$finalmail = mail($twadminemail, 'New Guide Registration Confirmation', $message, 'From: info@townwizard.com');
		
		if($finalmail){
			// Confirmation
			$_REQUEST['fname'] = "";
			$_REQUEST['lname'] = "";
			$_REQUEST['email'] = "";
			$_REQUEST['gname'] = "";
			$_REQUEST['zip'] = "";
			header('Location:http://<?php echo $_SERVER["HTTP_HOST"];?>/form/thanks2.html');
			exit;		
		}else{
			echo '<div class="errormsgbox">You could not be registered due to a mail error.</div>';
		}
	}		



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Partner Activation</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php

if (isset($_REQUEST['key']) && (strlen($_REQUEST['key']) == 32)){//The Activation key will always be 32 since it is MD5 Hash
   $key = $_REQUEST['key']; 
   
}else{
	echo '<div class="errormsgbox">Key is not Proper.</div>';
	?>
	<br/> 
	<a href="http://akashbarot.com/form/">Click here</a> for registration. 
	<?php
	exit;
}

if (isset($key)){
	
	//echo $_REQUEST['key'];

	// Select from database to set the "activation" field
	$sql="SELECT * FROM user_signup WHERE `activation`='$key' LIMIT 1";
	$result = mysql_query($sql);
	$data = mysql_fetch_array($result);


   // Print a customized message:
	if($data['activation'] == TRUE){
		echo '<div class="success">Please select guide configuration given below and click activation button.</div>';
		?>
		
	<form id="contact2" method="post">	
		<table width="100%" cellpadding="0" cellspacing="5" border="0">
			<tr>
				<td>
					<label for="website">Guide Name</label>
					<input type="text"  name="gname" id="gname" title="Enter your guide name" placeholder="Selected guide name" value="<?php echo $data['guide_name'];?>" ReadOnly=true>
				</td>
				<td>		
					<label for="fname">First Name</label>
					<input type="text" name="fname" id="fname" placeholder="First Name" title="Enter your first name" value="<?php echo $data['first_name'];?>" ReadOnly=true>
				</td>				
			</tr>
			<tr>
				<td>
					<label for="email">Guide Login E-mail</label>
					<input type="email" name="email" id="email" placeholder="yourname@domain.com" title="Enter your e-mail address" value="<?php echo $data['email'];?>" ReadOnly=true>
				</td>
				<td>
					<label for="lname">Last Name</label>
					<input type="text" name="lname" id="lname" placeholder="Last Name" title="Enter your last name" value="<?php echo $data['last_name'];?>" ReadOnly=true>
				</td>				
			</tr>
			<tr>
				<td>
					<label for="email">Guide Login Password</label>
					<input type="password" name="pass" id="pass" placeholder="Password" title="Enter Admin's password" value="<?php echo $data['password'];?>" ReadOnly=true>
				</td>
				<td>&nbsp;</td>				
			</tr>
		</table>
	
		<label for="zip">City zip code<span class="require">*</span></label>
		<input type="text" name="zip" id="zip" placeholder="City zip code" title="Enter your City zip code" required pattern="[a-zA-Z0-9\s]+" />	
		
		<label for="language">Language</label>
		<select name="language" id="language">
			<option value="english">English</option>
			<option value="spanish">Spanish</option>
			<option value="dutch">Dutch</option>
			<option value="portuguese">Portuguese</option>
			<option value="croatian">Croatian</option>
		</select>		
		
		<label for="time_zone">Time zone</label>
		<select name="time_zone" id="time_zone" class="inputbox" size="1">
			<option value="-12:00:00">(GMT -12:00) Eniwetok, Kwajalein</option>
			<option value="-11:00:00">(GMT -11:00) Midway Island, Samoa</option>
			<option value="-10:00:00">(GMT -10:00) Hawaii</option>
			<option value="-9:00:00">(GMT -9:00) Alaska</option>
			<option value="-8:00:00">(GMT -8:00) Pacific Time (US &amp; Canada)</option>
			<option value="-7:00:00">(GMT -7:00) Mountain Time (US &amp; Canada)</option>
			<option value="-6:00:00">(GMT -6:00) Central Time (US &amp; Canada), Mexico City</option>
			<option value="-5:00:00" selected>(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima</option>
			<option value="-4:00:00">(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz</option>
			<option value="-3:30:00">(GMT -3:30) Newfoundland</option>
			<option value="-3:00:00">(GMT -3:00) Brazil, Buenos Aires, Georgetown</option>
			<option value="-2:00:00">(GMT -2:00) Mid-Atlantic</option>
			<option value="-1:00:00">(GMT -1:00 hour) Azores, Cape Verde Islands</option>
			<option value="00:00:00">(GMT) Western Europe Time, London, Lisbon, Casablanca</option>
			<option value="1:00:00">(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris</option>
			<option value="2:00:00">(GMT +2:00) Kaliningrad, South Africa</option>
			<option value="3:00:00">(GMT +3:30) Tehran</option>
			<option value="4:00:00">(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi</option>
			<option value="4:30:00">(GMT +4:30) Kabul</option>
			<option value="5:00:00">(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
			<option value="5:30:00">(GMT +5:30) Bombay, Calcutta, Madras, New Delhi</option>
			<option value="6:00:00">(GMT +6:00) Almaty, Dhaka, Colombo</option>
			<option value="7:00:00">(GMT +7:00) Bangkok, Hanoi, Jakarta</option>
			<option value="8:00:00">(GMT +8:00) Beijing, Perth, Singapore, Hong Kong</option>
			<option value="9:00:00">(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk</option>
			<option value="9:30:00">(GMT +9:30) Adelaide, Darwin</option>
			<option value="10:00:00">(GMT +10:00) Eastern Australia, Guam, Vladivostok</option>
			<option value="11:00:00">(GMT +11:00) Magadan, Solomon Islands, New Caledonia</option>
			<option value="12:00:00">(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka</option>
		</select>
	
		<label for="time_format">Time format</label>
		<select name="time_format" id="time_format">
			<option value="12">12 hrs (e.g. 07:10 PM)</option>
			<option value="24">24 hrs (e.g. 19:10)</option>
		</select>		

		<label for="date_format">Date Format</label>
		<select name="date_format" id="date_format">
			<option value="mmdd">Month/Date</option>
			<option value="ddmm">Date/Month</option>
		</select>			
		
		<label for="temperature">Temperature</label>
		<select name="temperature" id="temperature">
			<option value="c">Celsius</option>
			<option value="f" selected>Fahrenheit</option>
		</select>			

		<label for="distance">Distance</label>
		<select name="distance" id="distance">
			<option value="KM">KM</option>
			<option value="Miles" selected>Miles</option>
		</select>			
		<div style="clear: both"></div>
		<input type="submit" name="createguide" class="myButton" id="submit" value="Activation" />
	</form>
	
	<?php
	}else{
		echo '<div class="errormsgbox">Oops !Your account could not be activated. Link is either expired or wrong.</div>';
	}	

	$key="";
 	mysql_close($con);

} else {
	echo '<div class="errormsgbox">Error Occured .</div>';
}


?>
</body>
</html>