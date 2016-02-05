<?php

// Code for retriving the Current Page url from the browser
// handle www and now-www version (e.g. www.30a.com and 30a.com)
// $pageURL = $_SERVER["HTTP_HOST"];
$pageURL_actual = $_SERVER["HTTP_HOST"];
$pageURL        = str_replace ('www.','',$pageURL_actual); 
		
// Connetion with Master DB to retrive Slave DB informaiton
$link = mysql_pconnect("localhost","root","bitnami");
$dblink = mysql_select_db("master");
$queryMaster = "SELECT * FROM master WHERE site_url LIKE '$pageURL'";
$result = mysql_query($queryMaster);

if (mysql_num_rows($result)>0) {
	$row = mysql_fetch_array($result);
	
	// Assigning the Slave DB information to PHP SESSION variable 	
    $_SESSION['c_db_id']       = $row['mid'];
	$_SESSION['c_db_name']     = $row['db_name'];
	$_SESSION['c_db_user']     = $row['db_user'];
	$_SESSION['c_db_password'] = $row['db_password'];
	
	// Assign Partner Site folder Name and Style Folder Name for Common Folder
	
	$_SESSION['tpl_folder_name'] 	    = $row['tpl_folder_name'];
	$_SESSION['partner_type'] 			= $row['partner_type'];
	$_SESSION['style_folder_name'] 		= $row['style_folder_name'];
	$_SESSION['partner_folder_name'] 	= $row['partner_folder_name'];
	
	mysql_close($link);
}


/*$session = new Session;
$session->open();
$session['partner_folder_name'] = $_SESSION['partner_folder_name'];  // set session variable 'name3'*/

//Yii::app()->session['partner_folder_name'] = $_SESSION['partner_folder_name'];

// This is the database connection configuration.
return array(
	//'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database
	'connectionString' => 'mysql:host=localhost;dbname='.$_SESSION['c_db_name'],
	'emulatePrepare' => true,
	'username' => $_SESSION['c_db_user'],
	'password' => $_SESSION['c_db_password'],
	'charset' => 'utf8',
	'tablePrefix' => $_SESSION['partner_folder_name'],
	
);