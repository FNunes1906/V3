<?php
include("iadbanner.php"); 
include("connection.php");

# Include blog class file
include("model/blog_class.php");
$objBlog = new blog();

$article_res = $objBlog->fetch_blog_detail_data($_REQUEST['id']);

header('Content-type: text/html;charset=utf-8', true);

/* code start by rinkal for page title */
$pagemeta = $objBlog->fetch_pagemeta_title();
/* code end by rinkal for page title */
?>
<html>
<head>
<link href="/components/com_shines_v2.1/css/style.css" rel="stylesheet" media="screen" type="text/css" />

<title>
<?php 
	/* code start by rinkal for page title */
	if ($_SESSION['tpl_folder_name'] == 'defaultportuguese'){
		$title = 'Blog Detalhe';
	}elseif($_SESSION['tpl_folder_name'] == 'defaultspanish'){
		$title = 'Blog Detalle';
	}elseif($_SESSION['tpl_folder_name'] == 'defaultdutch'){
		$title = 'Blog Detail';
	}elseif($_SESSION['tpl_folder_name'] == 'defaultcroatian'){
		$title = 'Blog Detalj';
	}elseif($_SESSION['tpl_folder_name'] == 'default'){
		$title = 'Blog Detail';
	}
	
	$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
	if(stripos($ua,'android') == True) { 
		$page_title = $site_name.' ~ '.$title;
		if($pagemeta['title']!='')
		{
			$page_title.= ' ~ '.$pagemeta['title'];
		}
		echo $page_title;
	}
	else{
		$page_title = $site_name.' : '.$title;
		if($pagemeta['title']!='')
		{
			$page_title .= ' : '.$pagemeta['title'];
		}
		echo $page_title;
	}
?>
</title>
<meta name="viewport" content="width=280, initial-scale=1.0, maximum-scale=1.0, user-scalable=false" />
<!--<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />-->
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
	<ul id="placesList" class="mainList offer">
		<?php if($article_res){ ?>
			 	<li style="text-align:left;">
						<div class="contentheading"><?php echo $article_res['title'] ?></div>
						<p><?php echo $article_res['introtext'].$article_res['fulltext'] ?></p>
				</li>
		<?php } ?>
	</ul>
  </div>
</body>
</html>