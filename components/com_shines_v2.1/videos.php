<?php
include("connection.php");
include("iadbanner.php");
include("model/galleries_class.php");	

$data = new photosdata();
$rec = $data->fetchVideo();

$urlpara = '/videos';
$pagemeta = $data->title($urlpara);

header( 'Content-Type:text/html;charset=utf-8');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="yes" name="apple-mobile-web-app-capable" />
<meta content="index,follow" name="robots" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<!--<meta content="minimum-scale=1.0, width=device-width, maximum-scale=0.6667, user-scalable=no" name="viewport" />-->
<meta name="viewport" content="width=280, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link href="pics/homescreen.gif" rel="apple-touch-icon" />
<link href="pics/startup.png" rel="apple-touch-startup-image" />
<link href="/components/com_shines_v2.1/css/style.css" rel="stylesheet" media="screen" type="text/css" />
<link rel="shortcut icon" href="images/l/apple-touch-icon.png">
<script src="/components/com_shines/javascript/functions.js" type="text/javascript"></script>

<title>
<?php 
	/*Code for Page Title*/
	$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
	if(stripos($ua,'android') == True) { 
		$title = $site_name.' ~ '.JText::_('TW_VID');
		if($pagemeta['title']!=''){
			$title.= ' ~ '.$pagemeta['title'];
		}
		echo $title;
	}else{
		$title = $site_name.' : '.JText::_('TW_VID');
		if($pagemeta['title']!=''){
			$title .= ' : '.$pagemeta['title'];
		}
		echo $title;
	}
?>
</title>

<!--<link href="pics/startup.png" rel="apple-touch-startup-image" /> -->
<meta content="destin, vacactions in destin florida, destin, florida, real estate, sandestin resort, beaches, destin fl, maps of florida, hotels, hotels in florida, destin fishing, destin hotels, best florida beaches, florida beach house rentals, destin vacation rentals for destin, destin real estate, best beaches in florida, condo rentals in destin, vacaction rentals, fort walton beach, destin fishing, fl hotels, destin restaurants, florida beach hotels, hotels in destin, beaches in florida, destin, destin fl" name="keywords" />
<meta content="Destin Florida's FREE iPhone application and website guide to local events, live music, restaurants and attractions" name="description" />
<?php include($_SERVER['DOCUMENT_ROOT']."/ga.php"); ?>



<!-- New styles add by Doug Schaffer to be moved to CSS file -->

<style type="text/css">
  	#placesList li { position:relative;padding:10px !important; }
  	#placesList li strong a img { display:block;position:absolute;top:50%;margin-top:-22px;right:0;padding:0 !important; }
</style>

</head>
<body>

<!--code for ad banner-->
	<?php
		$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
		if(stripos($ua,'android') == true) { 
	?>
	<div class="iphoneads" style="vertical-align:bottom;">
	<?php 
		m_show_banner('android-videos-screen'); 
	?>
		</div>
	<?php
		 } else {
	?>
	<div class="iphoneads" style="vertical-align:bottom;">
	<?php 
		m_show_banner('iphone-videos-screen'); 
	?>
	</div>
	<?php } ?>
	
	<div id="main" role="main">  
		<div id="zigzag" style="vertical-align:bottom;"> </div>
		<div id="content">
			<ul style="background:url('/partner/<?php echo $_SESSION['partner_folder_name']?>/images/twBg.png') repeat-y scroll 100% 100% !important;" class="mainList" id="placesList">

			<?php 
			while($row=mysql_fetch_array($rec)){
				$arr=explode('/v/',$row['videocode']);
				$arr1=explode('?',$arr[1]);
				$arr2=explode('&',$arr1[0]);
				$yturl=$arr2[0];
				$arr2[0]='http://www.youtube.com/watch?v='.$arr2[0];
				
			?>
			
			<li class="textbox"  style="padding-bottom:20px;">
				<a href="<?php echo $arr2[0]; ?>">
					<img src="http://img.youtube.com/vi/<?php echo $yturl; ?>/0.jpg" border="0" align="left" style="padding-right:10px;width:100px; height:100px;" />
				</a>
				<font color="#999999"><strong>
					<a href="<?php echo $arr2[0]; ?>">
						<img src="images/next-videos.gif" align="right" style="padding-top:20px;"  border="0"/>
					</a>
					<a style="line-height:100px;" href="<?php echo $arr2[0]; ?>"><?php echo $row['title'] ; ?></a>
				</strong></font> 
			</li>
			<?php
			}

			?>
			</ul>
		</div>
	</div>
	<div style='display:none;'><?php echo $pageglobal['googgle_map_api_keys']; ?></div>
</body>
</html>
