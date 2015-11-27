<?php
include("iadbanner.php"); 
include("connection.php");

$todaydate = date("Y-m-j",strtotime("+1 day"));
$today = date("Y-m-d G:i:s");
$sql = "select jc.*,jcf.ordering from `jos_content` jc,`jos_categories` jcs,`jos_content_frontpage` jcf where jc.id = jcf.content_id and (jcs.id = jc.catid || jc.catid=0) and jc.state=1 and (jc.publish_down>'".$today."' or jc.publish_down='0000-00-00 00:00:00') and (jc.publish_up <= '".$todaydate."' or jc.publish_up='0000-00-00 00:00:00') GROUP BY jc.id order by jcf.ordering";
$param = mysql_query($sql);
  
header('Content-type: text/html;charset=utf-8', true);

//bhavan: need to instruct ios8.3 not to cache the page
//header('Expires: Thu, 19 Nov 1981 08:52:00 GMT', true);
header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
//header ('Pragma: no-cache');

/* code start by rinkal for page title */
$pagemeta_res = mysql_query("select title from `jos_pagemeta`where uri='/index.php'");
$pagemeta =mysql_fetch_array($pagemeta_res);
/* code end by rinkal for page title */
?>
<html>
<head>
<link href="/components/com_shines_v2.1/css/style.css" rel="stylesheet" media="screen" type="text/css" />

<title>
<?php 
	/* code start by rinkal for page title */
	$page_title = JText::_('APP_NEWS');
	$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
	if(stripos($ua,'android') == True) { 
		$title = $site_name.' ~ '.$page_title;
		if($pagemeta['title']!='')
		{
			$title.= ' ~ '.$pagemeta['title'];
		}
		echo $title;
	}
	else{
		$title = $site_name.' : '.$page_title;
		if($pagemeta['title']!='')
		{
			$title .= ' : '.$pagemeta['title'];
		}
		echo $title;
	}
?>
</title>
<meta name="viewport" content="width=280, initial-scale=1.0, maximum-scale=1.0, user-scalable=false" />
<!--<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />-->
 <?php include($_SERVER['DOCUMENT_ROOT']."/ga.php"); ?>
</head>
<body>
  <div id="main" role="main">
  <?php	$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
		if(stripos($ua,'android') == true) { ?>
			<div id="zigzag" style="vertical-align:bottom;text-align: center;">
				<?php m_show_banner('android-news-screen'); ?>
			</div>
  <?php }else { ?>
			<div id="zigzag" style="vertical-align:bottom;text-align: center;">
				<?php m_show_banner('iphone-news-screen'); ?>
			</div>
  <?php } ?>
  <ul style="background:url('/partner/<?php echo $_SESSION['partner_folder_name']?>/images/twbg.png') repeat-y scroll 100% 100% !important;" id="placesList" class="mainList offer">
		<?php
			$data = '';
			if($param) 
			{ 
			 	while($data = mysql_fetch_array($param))
				{ ?>
					<li style="text-align:center;" id="blog_text">
						<a href="blog_details.php?id=<?php echo $data['id'] ?>&category_id=<?php echo $data['catid'] ?>"><div class="contentheading"><?php echo $data['title'] ?></div></a>
						<p><?php echo $data['introtext'] ?></p>
						<?php if($data['fulltext']!=''){ ?>
						<a class="readmore" href="blog_details.php?id=<?php echo $data['id'] ?>&category_id=<?php echo $data['catid'] ?>"><?php echo JText::_('APP_READMORE');?></a>
						<br/><br/><?php } ?>
					</li>
				<?php
				}
			}?>
	</ul>
  </div>
</body>
</html>
