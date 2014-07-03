<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style>
body {
    background: none repeat scroll 0 0 #E4E4E4;
    font-family: arial;

}
input{
	margin: 0px;
}
#upgradeform table{
background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #ABABAB;
    border-radius: 5px 5px 5px 5px;
    box-shadow: 1px 2px 1px #A9A9A9;
    font-family: arial;
    font-size: 15px;
    margin: auto;
    padding: 20px;
    width: 648px;
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

.title{color: #FF0000;
    font-size: 20px;
    line-height: 50px;
    text-align: center;
    text-decoration: underline;}

.success {
	border: 1px solid;
	margin: 0 auto;
	padding: 10px 60px;
	background-repeat: no-repeat;
	background-position: 10px center;
	text-align: center;
	width: 525px;
	color: #4F8A10;
	background-color: #DFF2BF;
	font-size: 115%;
	margin-bottom: 10px;
}

</style>
</head>
<body>

<div style="text-align: center;">
	<img width="296" height="75" title="ttown" alt="TW LOGO" src="tw_logo_icon.png">
</div>

<div class="title">Please fill below form for upgrading package</div>

<?php 
 
if(isset($_POST['submit']) && $_POST['submit']!==NULL)
{
		//=========MAIL SENT TO SUPPORT ==========//
		$to = "darren@townwizard.com";
		$subject = $_REQUEST['guidename']. "-site needs to be upgrade";
		$message = "Below are Guide information for upgradation.<br/><br/>";
		$message .= "<div style='padding-right:125px;float:left'>Name</div><div>:".$_REQUEST['name']."</div>";
		$message .= "<br/><div style='padding-right:128px;float:left'>Email</div><div>:".$_REQUEST['email']."</div>";;
		$message .= "<br/><div style='padding-right:80px;float:left'>Guide Name</div><div>:".$_REQUEST['guidename']."</div>";;
		$message .= "<br/><div style='padding-right:64px;float:left'>Phone Number</div><div>:".$_REQUEST['phonenumber']."</div>";;
		$message .= "<br/><div style='padding-right:7px;float:left'>Upgrade Request Date	</div><div>:".$_REQUEST['date']."<br/><br/>Thanks!</div>";
		$from = $_REQUEST['email'];
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type:text/html;charset=iso-8859-1' . "\r\n";	
		$headers .= "From:" . $from;
		$mailcheck = mail($to,$subject,$message,$headers);
		
		//=========MAIL SENT TO PARTNER ==========//
		$to_p = $_REQUEST['email'];
		$subject_p = "Your Guide ".$_REQUEST['guidename']." will be upgraded soon";
		$message_p = "Thanks for upgrading guide ".$_REQUEST['guidename'].".<br/><br/>Our team will contact you soon and your guide will be upgraded with professional version within 2 days.<br/><br/>Thanks!</div>";
		$from_p = "Townwizard-Operations";
		$headers_p = 'MIME-Version: 1.0' . "\r\n";
		$headers_p .= 'Content-type:text/html;charset=iso-8859-1' . "\r\n";	
		$headers_p .= "From:" . $from_p;
		$mailcheck_p = mail($to_p,$subject_p,$message_p,$headers_p);
		
		if($mailcheck && $mailcheck_p){
			echo "<div class='success'>Your site will be upgraded very soon.</div>";
		}else{
			echo "<div>Mail is not sent due to server issue.</div>";
		}
	
}
 
?>
<form id="upgradeform" name="upgradeform" action="" method="POST" >
	<table cellpadding="0" cellspacing="10">
		<tbody>
			<tr>
				<td><label for="name">Name:</label></td>
				<td><input name="name" id="name" style="width: 60%;" value="" type="text" required></td>
			</tr>
			<tr>
				<td><label for="email">Email id:</label></td>
				<td><input name="email" id="email" style="width: 60%;" value="" type="email" pattern="([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})" required></td>
			</tr>
			<tr>
				<td><label for="guidename">Guide Name:</label></td>
				<td><input name="guidename" id="guidename" style="width: 60%;" value="" type="text" required></td>
			</tr>
			<tr>
				<td><label for="phonenumber">Phone Number:</label></td>
				<td><input name="phonenumber" id="phonenumber" style="width: 60%;" value="" type="text" pattern="^[+]?([\d]{0,3})?[\(\.\-\s]?([\d]{3})[\)\.\-\s]*([\d]{3})[\.\-\s]?([\d]{4})$" required></td>
			</tr>
			<tr>
				<td><label for="Packages">Packages:</label></td>
				<td><input name="packages" id="packages" value="$1044" type="radio" checked="checked" required> $1044 (PROFESSIONAL)</td>
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
</body>
</html>