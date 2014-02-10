<?php
		//This page will return menu items for mobile aap.
		//You can type ?name="menu name" to fetch data from specific menu item
		//Order can be set from backend joomla default orderiing.
		//If UI type is null then respective menu URL wont display.
		
		
		$pageURL_actual = $_SERVER["HTTP_HOST"];
		$pageURL        = str_replace ('www.','',$pageURL_actual); 
		
		// Connetion with Master DB to retrive Slave DB informaiton
 		$link = mysql_pconnect("localhost","root","bitnami");
		
		$dblink = mysql_select_db("master");
		
		$queryMaster = "SELECT mid FROM master WHERE site_url LIKE '$pageURL'";
		
		$result = mysql_query($queryMaster);
		
		if (mysql_num_rows($result)>0) {
			$row = mysql_fetch_array($result);
			$partnerid = $row['mid'];
			mysql_close($link);
		}

include("connection.php");

$menuname	=  isset($_GET['name']) ? $_GET['name']:'';

$query="select * from `jos_menu` where ";

if(isset($menuname)  && $menuname != ''){
	$query.="menutype = '".$menuname."' AND ";
}

$query.="published = 1 AND parent = 0 ORDER BY menutype ASC, ordering ASC";

$rec=mysql_query($query) or die(mysql_error());
$num_records = mysql_num_rows($rec);


$k = 0; 
while($row	= mysql_fetch_array($rec)){
	
	//Data Processing
	$dataname = explode("iphoneurl",$row['params'],2);
	$displayname = explode("=",$dataname[0]);
	
	$dataiphoneurl = explode("iphoneurlview",$dataname[1]);
	$displayiphoneurl = explode("=",$dataiphoneurl[0],2);
	
	$dataiphoneurltype = explode("andurl",$dataiphoneurl[1]);
	$displayiphoneurltype = explode("=",$dataiphoneurltype[0],2);
	
	$dataandroidurl = explode("androidurlview",$dataiphoneurltype[1]);
	$displayandroidurl = explode("=",$dataandroidurl[0],2);
	
	$dataandroidurltype = explode("mobilemenu_image",$dataandroidurl[1]);
	$displayandroidurltype = explode("=",$dataandroidurltype[0],2);
	
	$dataimage = explode("Parent",$dataandroidurltype[1]);
	$displayimage = explode("=",$dataimage[0],2);
	$finalimage = explode("page_title",$displayimage[1]);
	
	$arr=explode('mobilemenu_image=',$row['params']);
	$arr1=explode('secure=',$arr[1]);
	
	//Menu type
	//$data[$k]['menutype']		= $row['menutype'];
	$data[$k]['id']					= $row['id'];
	
	//Menu name to display
	$data[$k]['display_name']	= str_replace("\n","",$displayname[1]);
	
	if(isset($finalimage[0])!= "" && $finalimage[0] != -1){
		$temp		= "/images/stories/mobilenav/".$finalimage[0];
		$data[$k]['image_url']		= str_replace("\n","",$temp);
	}else{
		$data[$k]['image_url']		= "";
	}
	
	$data[$k]['partner_id']		= $partnerid;
	
	//Section Name
	$data[$k]['section_name']	= $row['name'];
	
	if($displayiphoneurltype[1] == 0){
		$data[$k]['ui_type']		= "json";
		$data[$k]['url']			= str_replace("\n","",$displayiphoneurl[1]);
	}else if($displayiphoneurltype[1] == 1){
		$data[$k]['ui_type']		= "webview";
		$data[$k]['url']			= str_replace("\n","",$displayiphoneurl[1]);
	}else{
		$data[$k]['ui_type']		= "none";
		$data[$k]['url']			= "";
	}
	
	if($displayandroidurltype[1] == 0){
		$data[$k]['android_ui_type']	= "json";
		$data[$k]['android_url']		= str_replace("\n","",$displayandroidurl[1]);
	}else if($displayandroidurltype[1] == 1){
		$data[$k]['android_ui_type']	= "webview";
		$data[$k]['android_url']		= str_replace("\n","",$displayandroidurl[1]);
	}else{
		$data[$k]['android_ui_type']	= "none";
		$data[$k]['android_url']		= "";
	}

//	$akash[] = array;
	$data[$k]['sub_sections'] = "";
	
	++$k;
}

if(count($data) > 1){
	$status = "1";
	$error = "";	
}else{
	$status = "0";
	$error = "No data found for menu.";
}
	  
$response = array(
	'status' => $status,
	'error' => $error,
   	'data' => $data,
   	'meta' => array(
		'total' => $num_records,
		'limit' => $num_records,
		'offset' => 0
	)
);

//echo "<pre>";
//print_r($response);
header('Content-type: application/json');
echo json_encode($response);

?>