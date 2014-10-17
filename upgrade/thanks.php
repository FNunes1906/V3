<?php
require_once($_SERVER['DOCUMENT_ROOT']."/configuration.php");

// Set flag that this is a parent file
define( '_JEXEC', 1 );
define( 'DS', DIRECTORY_SEPARATOR );
$x = realpath(dirname(__FILE__)."/../") ;
define( 'JPATH_BASE', $x );
require_once JPATH_BASE.DS.'includes'.DS.'defines.php';
require_once JPATH_BASE.DS.'includes'.DS.'framework.php';
$mainframe =& JFactory::getApplication('site');
$mainframe->initialise();
$rec		= mysql_query("select * from `jos_pageglobal`");
$pageglobal	= mysql_fetch_array($rec);
$site_name 	= $pageglobal['site_name'];
$email 		= $pageglobal['email'];

//$pageURL_actual	 = $_SERVER["SERVER_NAME"];
$split_url = explode('.',$_SERVER["SERVER_NAME"]);
if($split_url[0]=="www"){
	$guidename = $split_url[1];
}else{
	$guidename = $split_url[0];
}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width; initial-scale=1.0">
<style>
body {
    color: #526066;
	background: #f7f7f7;
	font-size: 1em;
	font-family: sans-serif;
	text-align: center;
}
html {
    font-size:100%;
}
.button {
	-moz-box-shadow:inset 0px 1px 0px 0px #caefab;
	-webkit-box-shadow:inset 0px 1px 0px 0px #caefab;
	box-shadow:inset 0px 1px 0px 0px #caefab;
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #77d42a), color-stop(1, #5cb811) );
	background:-moz-linear-gradient( center top, #77d42a 5%, #5cb811 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#77d42a', endColorstr='#5cb811');
	background-color:#77d42a;
	-webkit-border-top-left-radius:20px;
	-moz-border-radius-topleft:20px;
	border-top-left-radius:20px;
	-webkit-border-top-right-radius:20px;
	-moz-border-radius-topright:20px;
	border-top-right-radius:20px;
	-webkit-border-bottom-right-radius:20px;
	-moz-border-radius-bottomright:20px;
	border-bottom-right-radius:20px;
	-webkit-border-bottom-left-radius:20px;
	-moz-border-radius-bottomleft:20px;
	border-bottom-left-radius:20px;
	text-indent:0;
	border:1px solid #268a16;
	display:inline-block;
	color:#306108;
	font-family:Arial;
	font-size:15px;
	font-weight:bold;
	font-style:normal;
	height:50px;
	line-height:50px;
	width:167px;
	text-decoration:none;
	text-align:center;
	text-shadow:1px 1px 0px #aade7c;
	cursor: pointer;
}
.button:hover {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #5cb811), color-stop(1, #77d42a) );
	background:-moz-linear-gradient( center top, #5cb811 5%, #77d42a 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#5cb811', endColorstr='#77d42a');
	background-color:#5cb811;
}
.thanks{ 
	text-transform: capitalize;
}
</style>

</head>
<body> 
<div style="text-align: center;">
	<img width="296" height="75" title="ttown" alt="TW LOGO" src="tw_logo_icon.png"><br><br>
</div>
<?php 
//if(isset($_POST['payment_status']) && $_POST['payment_status']=="Completed")
//{
		//=========MAIL SENT TO SUPPORT ==========//
		$to = "operations@townwizard.com";
		$subject = $guidename. "-site needs to be upgrade";
		$message = "The following guide has requested an upgrade.<br/><br/>";
		$message .= "<div style='float: left;width: 190px;line-height:28px;'>
						<div>Email Address:</div>
						<div>Guide Name:</div>
						<div>Package:</div>
						<div>Upgrade Request Date:</div>
					</div>
					<div style='float: left;line-height:28px;'>
						<div>".$email."</div>
						<div>".$guidename."</div>
						<div>".$_GET['item_name']." Plan(".$_GET['payment_gross']." per month)</div>
						<div>".date('F j, Y, g:i a')."</div>
					</div>
					<div style='clear: both;'><br/><br/>Thanks!</div>";
		
		$from = $email;
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type:text/html;charset=iso-8859-1' . "\r\n";	
		$headers .= 'From:' . $from;
		$mailcheck = mail($to,$subject,$message,$headers);
		
		//=========MAIL SENT TO PARTNER ==========//
		$to_p = $email;
		$subject_p = "Your TownWizard Guide Upgrade";
		$message_p = '<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f5f5f5"><tbody>
								<tr>
									<td>
										<table width="550" border="0" align="center" cellpadding="0" cellspacing="0"><tbody>
											<tr>
												<td width="161"><a href="http://www.townwizard.com" target="_blank"><img src="http://www.townwizard.com/wp-content/themes/5506/images/2012/header/townwizard_logo.png" alt="townwizard" width="262" height="84" border="0"></a></td>
												<td width="338" align="right"></td>
											</tr>
											<tr>
												<td height="50" colspan="2" >
													<table width="550" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" style="border:1px double #e3e3e3;padding:0;margin:0"><tbody>
														
														<tr><td height="100" width="40">&nbsp;</td><td>Thanks for upgrading! Your upgrade is currently being processed. You will be contacted shortly to complete the process.</td><td width="40">&nbsp;</td></tr>
														<tr><td height="100">&nbsp;</td><td> 
							<p style="font:14px Helvetica Neue,Helvetica,Arial,sans-serif;color:#777777;margin:20px 0 5px 0;padding:0;">Sincerely,</p>
							<p style="font:14px Helvetica Neue,Helvetica,Arial,sans-serif;color:#777777;margin:20px 0 5px 0;padding:0;">The TownWizard Team</p>
						</td><td>&nbsp;</td></tr>

						</tbody></table>
						</td>
					</tr>
					<tr>
						<td height="10" align="center" valign="middle"  colspan="2" ></td>
					</tr>
					<tr>
						<td align="center" valign="middle" colspan="2"><p style="font:15px Helvetica Neue,Helvetica,Arial,sans-serif;font-weight:bold;margin:10px 0 10px 0;padding:10px 0 0 0;color:#000000;">OUR ADDRESS & SOCIAL MEDIA DETAILS</p></td>

					</tr>
					<tr>
						<td align="center" valign="middle" colspan="2" style="border-top:1px solid #e3e3e3">&nbsp;</td>
					</tr>
					<tr>
						<td height="20" align="center" colspan="2"><p style="font:12px Helvetica Neue,Helvetica,Arial,sans-serif;margin:0;padding:0;color:#777777;text-decoration:none">2, Overhill Road, Suite 400, Scarsdale, NY 10583 , USA</p></td>
					</tr>
					<tr>
						<td height="20" align="center" colspan="2">
						<p style="font:12px Helvetica Neue,Helvetica,Arial,sans-serif;margin:0;padding:0;color:#777777;text-decoration:none"><a style="font:12px Helvetica Neue,Helvetica,Arial,sans-serif;margin:0;padding:0;color:#777777;text-decoration:none" href="http://www.facebook.com/TownWizard"  target="_blank">Facebook &bull; </a><a style="font:12px Helvetica Neue,Helvetica,Arial,sans-serif;margin:0;padding:0;color:#777777;text-decoration:none" href="http://www.twitter.com/townwiz"  target="_blank">Twitter &bull; </a><a style="font:12px Helvetica Neue,Helvetica,Arial,sans-serif;margin:0;padding:0;color:#777777;text-decoration:none" href="http://www.linkedin.com/company/1592698?trk=tyah&amp;trkInfo=tas%3Atownwizard%20llc"  target="_blank">LinkedIn &bull; </a><a style="font:12px Helvetica Neue,Helvetica,Arial,sans-serif;margin:0;padding:0;color:#777777;text-decoration:none" href="http://www.youtube.com/channel/UCrwiyabEFIS0n0e87CB5nTg"  target="_blank">YouTube</a>
						</p>
						</td>
					</tr>
					<tr>
						<td height="50" align="center">&nbsp;</td>
					</tr>
		</tbody></table></td>
		</tr>
	</tbody></table>';
		$from_p = "Townwizard-Operations";
		$headers_p = 'MIME-Version: 1.0' . "\r\n";
		$headers_p .= 'Content-type:text/html;charset=iso-8859-1' . "\r\n";	
		$headers_p .= 'From:' . $from_p;
		$mailcheck_p = mail($to_p,$subject_p,$message_p,$headers_p);
	
	echo "<div><b>Congratulations!</b><br><br>You have upgraded to <b class='thanks'>".$_GET['item_name']."</b> plan (". $_GET['payment_gross']." per month).<br>Get started now.</div><br><br>
<a class='button' href='/administrator'>Back to Site Admin</a>";
/*}else{
	echo "<div class='thanks'>Paypal payment is not completed succesfully so please try again.</div>";
}*/
?>

</body>

</html>