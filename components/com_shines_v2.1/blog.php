<!-- jquery for ajax loader -->
<script src="javascript/libs/ajax_jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="javascript/libs/jquery-1.7.1.min.js"><\/script>')</script>

<?php
include("iadbanner.php"); 
include("connection.php");

# Include blog class file
include("model/blog_class.php");
$objBlog = new blog();

if(isset($_REQUEST['category_id']) && $_REQUEST['category_id'] != ''){
	$cat_id = $_REQUEST['category_id'];
}

$start_at 			= 0;
$entries_per_page	= 10;
$end_at 			= $entries_per_page;
$todaydate 			= date("Y-m-j",strtotime("+1 day"));
$today 				= date("Y-m-d G:i:s");
$param 				= $objBlog->fetch_blog_data($todaydate, $today,$start_at,$end_at,$cat_id);
$total_data 		= mysql_num_rows($param);


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
	$title = JText::_('APP_BLOG');
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

<input type="hidden" id="hdncid" value="<?php echo $cat_id;?>"/>
<div id="main" role="main">
  <?php
/* 
Code Begin 
Result  : display banner for category
Request : Fetching category title from category id
Developer:Rinkal 
Last update Date:10-02-2014
*/
if(isset($cat_id) && $cat_id!=''){
	$blog_cat = $objBlog->fetch_banner_category($cat_id);
	while($bann_cat_name = mysql_fetch_array($blog_cat))
	{
		$banner_cat_name = $bann_cat_name['title'];
	}
	$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
	if(stripos($ua,'android') == True) { ?>
		<div id="zigzag" style="vertical-align:bottom;text-align: center;">
			<?php m_show_banner('android-'.$banner_cat_name.'-screen'); ?>
		</div>
		<?php } else { ?>
		<div id="zigzag" style="vertical-align:bottom;text-align: center;">
			<?php m_show_banner('iphone-'.$banner_cat_name.'-screen');?>
		</div>
		<?php } 
}else{
	$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
	if(stripos($ua,'android') == True) { ?>
	<div id="zigzag" style="vertical-align:bottom;text-align: center;">
		<?php m_show_banner('android-blog-screen'); ?>
	</div>
  	<?php } else { ?>
	<div id="zigzag" style="vertical-align:bottom;text-align: center;">
		<?php m_show_banner('iphone-blog-screen'); ?>
	</div>
  <?php }
}
?>
<!--Code End -->
	<ul id="placesList" class="mainList offer">
		<?php
		 $data = '';
		 if(mysql_num_rows($param) > 0){
		 	while($data=mysql_fetch_array($param))
			{ ?>
				<li style="text-align:center;" id="blog_text">
					<div class="contentheading"><?php echo $data['title'] ?></div>
					
					<p><?php echo $data['introtext'] ?></p><br/>
					<?php if($data['fulltext']!=''){ ?>
					<a class="readmore" href="blog_details.php?id=<?php echo $data['id'] ?>&category_id=<?php echo $cat_id ?>"><?php echo JText::_('APP_READMORE');?></a>
					<br/><br/><?php } ?>
				</li>
			<?php
			}
		if(mysql_num_rows($param) >= $entries_per_page){ ?>
		
		<!-- Code for Ajax Lazy loader START -->
		<script type="text/javascript">
					 $(document).ready(function() { 
						var start_at = <?php echo $end_at?>;
						var end_at   = <?php echo $end_at?>;
						var catid    =  document.getElementById('hdncid').value;
						
						$(window).scroll(function() {
						   	if($(window).scrollTop() == $(document).height() - $(window).height())
							{
								$.ajax({
									dataType : "html" ,
									contentType : "application/x-www-form-urlencoded" ,
									url: "blog_ajax.php?category_id="+catid+"&start_at="+start_at+"&end_at="+end_at ,
									success: function(html) {
										if(html){		
											$('#placesList').append('<div id="loadMoreComments"> <center><b><?php echo JText::_("LOADING");?></b></center></div>');
											$("#placesList").append(html);
											start_at = start_at + end_at;
											$('div#loadMoreComments').fadeOut(1000);
										}else{		
											$('div#loadMoreComments').hide();
											$('#placesList').append('<div id="loadMoreComments"> <center><br><?php echo JText::_("NO_MORE_RECORDS");?></center></div>');
										}
									}
								});
								
							}
						});
					});
		</script>
		<!-- Code for Ajax Lazy loader END -->
		<?php } 
		} else {
			echo "<div style='text-align:center;font-weight:bold;'><br/>".JText::_("LOC_RES")."</div>";
		} ?>
	</ul>
  </div>
</body>
</html>