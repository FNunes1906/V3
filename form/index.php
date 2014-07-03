<?php 


	session_start(); 
/*	echo "<pre>";
	print_r($_SESSION);
	echo "</pre>";*/
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
	<link rel="stylesheet" href="css/style.css">
	<title>Initial Sign Up</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function(){
			
			$('#gname').blur(function() {
				$('#samplegname').empty();
				var string0 = "<b>Guide name = </b>";
				var string1 = $(this).val();
				var string2 = ".townwizard.com";
				$('#samplegname').append(string0).append(string1).append(string2);
			});
		
			$('.myButton').unbind().bind('click', myMethod);
			$('#contact').removeAttr('onsubmit');
			
			function myMethod(){
                 
				$('#contact').submit(function(e){        
                        
                        var postData = $("#contact").serializeArray();
                        var formURL = $("#contact").attr("action");
					
					$.ajax({
						url : formURL,
						type: "POST",
						data : postData,
						dataType : 'jsonp',
						success:function(data, textStatus, jqXHR){
						//console.log(data);
						//console.log(textStatus);
					     if(data.status===100){
						  	window.location.href = 'http://<?php echo $_SERVER['HTTP_HOST'];?>/form/thanks.html';
							//$("#simple-msg").html('sucessfull.');
							//$("#simple-msg").css('color','red');
						}else if(data.status===101){
							//console.log('else');
							$("#simple-msg").html('Guide already activated.');
							$("#simple-msg").css('color','red');
							$("#email").css('border','1px solid #CCCCCC');
							$("#email").css('box-shadow','none');
							$("#gname").css('border','1px solid #FF5656');
							$("#gname").css('box-shadow','0 0 2px #FF5656');
						}else if(data.status===102){
							//console.log('else'); 
							$("#simple-msg").html('This Email is registered in last 24 hours. So you can not submit new guide name.');
							$("#simple-msg").css('color','red');
							$("#email").css('border','1px solid #FF5656');
							$("#email").css('box-shadow','0 0 2px #FF5656');
							$("#gname").css('border','1px solid #CCCCCC');
							$("#gname").css('box-shadow','none');	
						}else if(data.status===103){
							//console.log('else'); 
							window.location.href = 'http://<?php echo $_SERVER['HTTP_HOST'];?>/form/thanks.html';
							//$("#simple-msg").html('Entry updated and mail sent.');
							//$("#simple-msg").css('color','red');
							//$("#email").css('border','1px solid #CCCCCC');
							//$("#email").css('box-shadow','none');	
							//$("#gname").css('border','1px solid #CCCCCC');
							//$("#gname").css('box-shadow','none');						
						}else if(data.status===104){
							//console.log('else'); 
							$("#simple-msg").html('This Guide name is already registered in last 24 hours.');
							$("#simple-msg").css('color','red');
							$("#email").css('border','1px solid #CCCCCC');
							$("#email").css('box-shadow','none');	
							$("#gname").css('border','1px solid #FF5656');
							$("#gname").css('box-shadow','0 0 2px #FF5656');															
						}else if(data.status===105){
							//console.log('else'); 
							$("#simple-msg").html('Guide already aaded but it is older than 24 hours and not activated yet so updating new email id.');
							$("#simple-msg").css('color','red');
							$("#email").css('border','1px solid #CCCCCC');
							$("#email").css('box-shadow','none');	
							$("#gname").css('border','1px solid #CCCCCC');
							$("#gname").css('box-shadow','none');																
						}else if(data.status===106){
							//console.log('else'); 
							$("#simple-msg").html('You could not be registered due to a system error. We apologize for any inconvenience.');
							$("#simple-msg").css('color','red');
							$("#email").css('border','1px solid #CCCCCC');
							$("#email").css('box-shadow','none');	
							$("#gname").css('border','1px solid #CCCCCC');
							$("#gname").css('box-shadow','none');											
						}else if(data.status===107){
							//console.log('else'); 
							$("#simple-msg").html('Please enter valid captcha.');
							$("#simple-msg").css('color','red');
							$("#email").css('border','1px solid #CCCCCC');
							$("#email").css('box-shadow','none');	
							$("#gname").css('border','1px solid #CCCCCC');
							$("#gname").css('box-shadow','none');									
						}
                                                        
						$('#contact').unbind('submit');
						},
                             error: function(jqXHR, textStatus, errorThrown) {
                                  //  $("#simple-msg").html('<pre><code class="prettyprint">AJAX Request Failed<br/> textStatus='+textStatus+', errorThrown='+errorThrown+'</code></pre>');
                             }
                        });

                    	e.preventDefault();
                    	return false;
               	});    
          	}
   		});
	</script>

</head>
<!--<body onload="document.getElementById('captcha-form').focus()">-->
<body >
<div id="logo"><img src="http://www.townwizard.com/wp-content/themes/5506/images/2012/header/townwizard_logo.png" alt="townwizard logo"></div>
<div id="simple-msg"></div>

<form id="contact"  action="process.php" method="POST">
    
		<label for="fname">First Name</label>
		<input type="text" name="fname" id="fname" placeholder="First Name" required oninvalid="setCustomValidity('First name is required.')" onchange="try{setCustomValidity('')}catch(e){}" pattern="[a-zA-Z0-9\s]+">
		
		<label for="lname">Last Name</label>
		<input type="text" name="lname" id="lname" placeholder="Last Name" required oninvalid="setCustomValidity('Last name is required.')" onchange="try{setCustomValidity('')}catch(e){}" pattern="[a-zA-Z0-9\s]+" />
		
		<label for="website">Guide Name</label>
		<input type="text" name="gname" id="gname" placeholder="Selected guide name" required oninvalid="setCustomValidity('Guide name is required without space.')" onchange="try{setCustomValidity('')}catch(e){}" pattern="[a-zA-Z0-9]+" /><span id="samplegname"></span>
	
		<label for="email">Guide Login E-mail</label>
		<input type="email" name="email" id="email" placeholder="yourname@domain.com" required oninvalid="setCustomValidity('Valid email is required ex: info@townwizard.com')" onchange="try{setCustomValidity('')}catch(e){}" pattern="([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})" >
		
		<label for="pass">Guide Login Password</label>
		<input type="password" name="pass" id="pass" placeholder="Password" required oninvalid="setCustomValidity('Password should be 5 - 15 character long.')" onchange="try{setCustomValidity('')}catch(e){}" pattern=".{5,15}">		
		
		<img src="captcha.php" id="captcha" style="margin-left: 39px;" /><br/>
		<a href="#" onclick="document.getElementById('captcha').src='captcha.php?'+Math.random(); document.getElementById('captcha-form').focus();" id="change-image" style="color: rgb(102, 102, 102); text-decoration: none; text-align: center; margin-left: 97px;">Update Text.</a><br/><br/>

		<label for="captcha">Add captcha word:</label>
		<input type="text" name="captcha" id="captcha-form" autocomplete="off" /><br/>
		
		<input type="submit" name="submit" class="myButton" id="Signup" value="Signup" />
	</form>

</body>
</html>