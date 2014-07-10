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
<style>
body {
    background: none repeat scroll 0 0 #E4E4E4;
    font-family: arial;
	color: #000;
}
input{
	margin: 0px;
}
input[type="text"],input[type="email"]{
	border: 1px solid rgba(0,0,0,0.3);
	box-shadow: -1px -2px 3px rgba(0,0,0,0.2);
	color: rgba(101,100,90,1);
	padding: 8px;
	width: 95%;
}
#upgradeform table{
	background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #ABABAB;
    border-radius: 5px 5px 5px 5px;
    box-shadow: 1px 2px 1px #A9A9A9;
    font-family: arial;
    font-size: 15px;
    margin: auto;
    padding:2px 10px;
    width: 396px;
}

.button {
    background-image: linear-gradient(to top, #c00c13 48%, #d72128 51%);
    border-radius: 5px 5px 5px 5px;
	border: none;
    color: #FFFFFF;
    font-weight: bold;
    padding: 5px 8px;
	text-transform: uppercase;
}

.admin_button{
	border: none;
    color: #333;
    font-weight: bold;
    padding: 5px 8px;
	text-transform: uppercase;
	text-align: center;
	width: 209px;
	margin: auto;
	display: block;
}

.title{
	color: #FF0000;
    font-size: 20px;
    line-height: 50px;
    text-align: center;
    text-decoration: underline;}

.thanks{
	margin: 0 auto;
	width:560px;
}
.success {
	border: 1px solid;
	padding: 10px;
	background-repeat: no-repeat;
	background-position: 10px center;
	text-align: center;
	width: 525px;
	color: #4F8A10;
	background-color: #DFF2BF;
	font-size: 115%;
	margin-bottom: 10px;
}
.required{
	text-align: right;
	font-size: 12px;
	font-weight: bold;
	padding-right: 12px;
}

input:required{
	outline: 2px solid transparent;
}

input:invalid:focus {
	outline: 2px solid rgba(200, 76, 76, 0.89);
}
</style>
</head>
<body>

<div style="text-align: center;">
	<img width="296" height="75" title="ttown" alt="TW LOGO" src="tw_logo_icon.png">
</div>

<div class="title">Professional Upgrade</div>

<?php 
 
if(isset($_POST['submit']) && $_POST['submit']!=NULL)
{
		//=========MAIL SENT TO SUPPORT ==========//
		$to = "arpit@townwizard.com";
		$subject = $_REQUEST['guidename']. "-site needs to be upgrade";
		$message = "The following guide has requested an upgrade.<br/><br/>";
		$message .= "<div style='float: left;width: 190px;line-height:28px;'>
						<div>Name:</div>
						<div>Email:</div>
						<div>Guide Name:</div>
						<div>Phone Number:</div>
						<div>Package:</div>
						<div>Upgrade Request Date:</div>
					</div>
					<div style='float: left;line-height:28px;'>
						<div>".$_REQUEST['name']."</div>
						<div>".$_REQUEST['email']."</div>
						<div>".$_REQUEST['guidename']."</div>
						<div>".$_REQUEST['phonenumber']."</div>
						<div>".$_REQUEST['packages']."</div>
						<div>".$_REQUEST['date']."</div>
					</div>
					<div style='clear: both;'><br/><br/>Thanks!</div>";
		
		$from = $_REQUEST['email'];
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type:text/html;charset=iso-8859-1' . "\r\n";	
		$headers .= 'From:' . $from;
		$mailcheck = mail($to,$subject,$message,$headers);
		
		//=========MAIL SENT TO PARTNER ==========//
		$to_p = $_REQUEST['email'];
		$subject_p = "Your TownWizard Guide Upgrade";
		$message_p = "Thanks for upgrading! Your upgrade is currently being processed. You will be contacted shortly to complete the process.<br/><br/>The TownWizard Team</div>";
		$from_p = "Townwizard-Operations";
		$headers_p = 'MIME-Version: 1.0' . "\r\n";
		$headers_p .= 'Content-type:text/html;charset=iso-8859-1' . "\r\n";	
		$headers_p .= 'From:' . $from_p;
		$mailcheck_p = mail($to_p,$subject_p,$message_p,$headers_p);
		
		if($mailcheck && $mailcheck_p){
			echo "<div class='thanks'><div class='success'>Thanks for upgrading! You will be contacted shortly to complete the upgrade process.<br/><br/>The TownWizard Team</div><a class='admin_button' href='/administrator'>Back to Joomla Admin</a></div>";
		}else{
			echo "<div class='thanks'>Mail is not sent due to server issue.</div>";
		}
	
}
?>
<?php if(!isset($_POST['submit'])) { ?>

<form id="upgradeform" name="upgradeform" action="" method="POST" >
	<table cellpadding="0" cellspacing="10">
		<tbody>
			<tr>
				<td colspan="2">
					<div class="required">*All fields are required</div>
				</td>
			</tr>
			<tr>
				<td><label for="name">Contact Name:</label></td>
				<td><input name="name" id="name"  value="" type="text"  oninvalid="setCustomValidity('Please complete the Contact Name field.')" onchange="try{setCustomValidity('')}catch(e){}" required>*</td>
			</tr>
			<tr>
				<td><label for="email">Email Address:</label></td>
				<td><input name="email" id="email"  value="<?php echo $email ?>" type="email" pattern="([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})" oninvalid="setCustomValidity('Please complete the Email Address field.')" onchange="try{setCustomValidity('')}catch(e){}" required>*</td>
			</tr>
			<tr>
				<td><label for="guidename">Guide Name:</label></td>
				<td><input name="guidename" id="guidename"  value="<?php echo $guidename; ?>" type="text" oninvalid="setCustomValidity('Please complete the Guide Name field.')" onchange="try{setCustomValidity('')}catch(e){}" required>*</td>
			</tr>
			<tr>
				<td><label for="phonenumber">Phone Number:</label></td>
				<td><input name="phonenumber" id="phonenumber" value="" type="text" pattern="^[+]?([\d]{0,3})?[\(\.\-\s]?([\d]{3})[\)\.\-\s]*([\d]{3})[\.\-\s]?([\d]{4})$" oninvalid="setCustomValidity('Please complete the Phone Number field.ex:(000)000-0000')" onchange="try{setCustomValidity('')}catch(e){}" required>*</td>
			</tr>
			<tr>
				<td><label for="Packages">Packages:</label></td>
				<td><input style="width: 8%" name="packages" id="packages" value="$1044" type="radio" checked="checked" required> $1044 (PROFESSIONAL)</td>
			</tr>
			<tr>
				<td><input type="hidden" value="<?php echo date("F j, Y, g:i a");?>" name="date"/></td>
			</tr>
			<tr>
				<td></td>
				<td><input class="button" type="submit" name="submit" value="Upgrade"></td>
			</tr>
  		</tbody>
  </table>
	
	
</form>
<?php } ?>
</body>
</html>