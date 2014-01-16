<!--<form method="POST" action="">
<textarea name="desc"></textarea>
<input type="submit"/>
</form>-->


<?php
/* echo "<pre>";
print_r($_POST);
echo var_dump($_POST['desc']);
echo isNoScriptDescription($_POST['desc']);*/

/* This file is contain all FORM validation function */


###
# Email Validation
# Function to check for Image type and size
# Parameter: Email = String
# Devloped By : Yogi
###
function isValidEmail($name){ 
	$regexp = "/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/";

	if(preg_match($regexp, $name)) {
	    return TRUE;
	}else{
		return FALSE;
	}
}


# Function to not allowed other Script tag 
function isNoScript($text)
{
    $allowed = array('.','=','-','+', '_',' ','"',"'",'[','(',']',')','$',':','%','!','/','?','*','&','@','|'); // you can add here more value, you want to allow.
    if(ctype_alnum(str_replace($allowed, '', $text ))) {
        return TRUE;
    } else {
        return FALSE;
    }
}


###
# Function to check for Image type and size
# Parameter: Event description - String
# Devloped By : Yogi
##
function isNoScriptDescription($text)
{
    $allowed = array('.','=','-','+', '_',' ','"',"'",'[','(',']',')','$',':','%','!','/','?','*','&','@','|'); // you can add here more value, you want to allow.
    if($text == "")
	{
		 return TRUE;
	}
	elseif(ctype_alnum(str_replace($allowed,'', $text ))) {
    	return TRUE;
    } else {
		return FALSE;
    }
}

##Function only for Photo Upload validation
function isNoScriptWithNull($text)
{
    $allowed = array('.','=','-','+', '_',' ','"',"'",'[','(',']',')','$',':','%','!','/','?','*','&','@','|'); // you can add here more value, you want to allow.
	if($text == "")
	{
		 return TRUE;
	}
    elseif(ctype_alnum(str_replace($allowed, '', $text ))) {
        return TRUE;
    } else {
        return FALSE;
    }
}


###
#Function to check for Image type and size
#Parameter: File Array
#Devloped By : Yogi
### 
function isValidFile($fileArray)
{
	# Creating image type array
	$imgTypeArr = array('jpg','gif','png','jpeg');
	
	# image size variable
	$fileSize	= $fileArray['file']['size']; 
	
	# image type variable
	$fileType	= $fileArray['file']['name']; 
	
	# Creating Image extension variable and converting to lowercase
		$imageExt	= strtolower(substr($fileType, strrpos($fileType, '.') + 1));
	
	# Checking weather file type is image and size is less then OR equal to 2 MB
	if(in_array($imageExt,$imgTypeArr) && $fileSize <= '2090000'){
		return TRUE;
	}else{
		return FALSE;
	}
}


function isvalidchar($text)
{
	$text = strtolower($text);	
	$s1= explode("<html",$text);
	$s2= explode("<script",$text);
	$s3= explode("<?php",$text);
	
	if((isset($s1) && count($s1) > 1) OR (isset($s2) && count($s2) > 1) OR (isset($s3) && count($s3) > 1) )
	{
		return FALSE;
	}else{
		return TRUE;
	}
}

?>