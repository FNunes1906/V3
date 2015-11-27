<?php
include("iadbanner.php"); 
include("connection.php");

# Include blog class file
include("model/blog_class.php");
$objBlog = new blog();

$article_res = $objBlog->fetch_blog_detail_data($_REQUEST['id']);

header('Content-type: text/html;charset=UTF-8', true);

/* code start by rinkal for page title */
$pagemeta = $objBlog->fetch_pagemeta_title();
/* code end by rinkal for page title */

/*CODE FOR FACEBOOK SHARING*/
$catId = $_REQUEST['category_id'];
if(isset($catId) && $catId != ""){
	
	// CHECK FOR MENU ITEMS OF BLOG
	$param_res = "SELECT `parent`,`id`,`link`,`alias` FROM `jos_menu` WHERE `link` like '%option=com_content%' and parent='0' AND menutype='leftmenu' AND published = '1'";
	$menu_param=mysql_query($param_res);
	if(count($menu_param)){
		
		while($menu_ids = mysql_fetch_array($menu_param)){
			$iParams = explode("&id=",$menu_ids["link"]);
			if($iParams[1] == $catId){
					$cat_name = $menu_ids[3];
			}else{ //IF BLOG CONTENT IS NOT ASSIGN TO MENU ID THEN FIND CATEGORY NAME
				if($cat_name == ""){
					$param_res = "SELECT `alias` FROM `jos_categories` WHERE `id`='".$_REQUEST['category_id']."' AND published = '1'";
					$cat_param=mysql_query($param_res);
					$menu_name = mysql_fetch_assoc($cat_param);
					$cat_name=$menu_ids['alias']."/".$_REQUEST['category_id']."-".$menu_name['alias'];
				}
			}
		}
	}
}else{
	//IF CATEGORY IS NOT ASSIGN THEN BY DEFAUT TAKING "BLOG" IN URL
	$cat_name = "blog";
}

?>
<!DOCTYPE html >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb">
<head>
<link href="/components/com_shines_v2.1/css/style.css" rel="stylesheet" media="screen" type="text/css" />

<title>
<?php 
	/* code start by rinkal for page title */
	$title = $article_res['title'];
	
	$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
	if(stripos($ua,'android') == True) { 
		$page_title = $site_name.' ~ '.$title;
		if($pagemeta['title']!=''){
			$page_title.= ' ~ '.$pagemeta['title'];
		}
		echo $page_title;
	}else{
		$page_title = $site_name.' : '.$title;
		if($pagemeta['title']!=''){
			$page_title .= ' : '.$pagemeta['title'];
		}
		echo $page_title;
	}
?>
</title>
<meta name="viewport" content="width=280, initial-scale=1.0, maximum-scale=1.0, user-scalable=false" />
<!--<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />-->
<script type="text/javascript" src="javascript/jquery-1.10.2.min.js"></script>
<script type="text/javascript">
$(document).ready(

	function() {
		$("#myshare").click(function() {
		  $("ul.share-inner-wrp").fadeToggle();
		 $("ul.share-inner-wrp").delay(3500).fadeOut("slow");
		});
    });
</script>
 <?php include($_SERVER['DOCUMENT_ROOT']."/ga.php"); ?>
</head>
<body>
 
  <div id="main" role="main">
  <?php
$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
if(stripos($ua,'android') == true) { ?>
	<div id="zigzag" style="vertical-align:bottom;">
		<?php m_show_banner('android-blog-screen'); ?>
	</div>
  <?php } 
  else {
  ?>
  <div id="zigzag" style="vertical-align:bottom;">
    <?php m_show_banner('iphone-blog-screen'); ?>
  </div>
  <?php } ?>
	<ul style="background:url('/partner/<?php echo $_SESSION['partner_folder_name']?>/images/twbg.png') repeat-y scroll 100% 100% !important;" id="placesList" class="mainList offer">
		<?php if($article_res){ ?>
		 	<li style="text-align:left;">
				<div class="contentheading"><?php echo $article_res['title'] ?></div>
				<p><?php echo $article_res['introtext'].$article_res['fulltext'] ?></p>
				<br />
				<ul class="btnList2">
					<li>
						<span id="myshare" class="button2 small2"><?php echo JText::_('TW_SHARE');?></span>
						<div id="share-wrapper">		
				 			<ul class="share-inner-wrp">
				
							<?php 
							if($cat_name != ""){
								$url = "http://".$_SERVER['SERVER_NAME']."/".$cat_name."/".$_REQUEST['id'];
							}else{
								$url = "http://".$_SERVER['SERVER_NAME'];
							}
							?>						
							
							<li class="button-wrap"><a  class="addthis_button_facebook" addthis:url="<?php echo $url;?>">Facebook</a></li>
							<li class="button-wrap"><a class="addthis_button_twitter" addthis:url="<?php echo $url;?>">Twitter</a></li>
							<li class="button-wrap"><a class="addthis_button_google_plusone_share" addthis:url="<?php echo $url;?>">Google +</a></li>
							<li class="button-wrap"><a class="addthis_button_email" addthis:url="<?php echo $url;?>">Email</a></li>
							
						      </ul>		
						</div>
					</li>
				</ul>
			</li>
		<?php } ?>
	</ul>
  </div>
 <script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-530f25e212b3622b"></script>
</body>
</html>