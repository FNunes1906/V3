<!-- jquery for ajax loader -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="javascript/libs/jquery-1.7.1.min.js"><\/script>')</script>

<?php
include("iadbanner.php"); 
include("connection.php");

# Include blog class file
include("model/blog_class.php");
$objBlog = new blog();

$start_at 			= 0;
$entries_per_page	= 10;
$end_at 			= $entries_per_page;
$todaydate 			= date("Y-m-j",strtotime("+1 day"));
$today 				= date("Y-m-d G:i:s");
$param 				= $objBlog->fetch_blog_data($todaydate, $today,$start_at,$end_at);
$total_data 		= mysql_num_rows($param);


header('Content-type: text/html;charset=ISO-8859-1', true);

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
	if ($_SESSION['tpl_folder_name'] == 'defaultspanish'){
		$title = 'Blog';
		$read_more = 'Leer más';
	}elseif($_SESSION['tpl_folder_name'] == 'defaultportuguese'){
		$title = 'Blog';
		$read_more = 'Leia mais';
	}elseif($_SESSION['tpl_folder_name'] == 'defaultdutch'){
		$title = 'Blog';
		$read_more = 'Lees meer';
	}elseif($_SESSION['tpl_folder_name'] == 'defaultcroatian'){
		$title = 'Blog';
		$read_more = 'opširnije';
	}elseif($_SESSION['tpl_folder_name'] == 'default'){
		$title = 'Blog';
		$read_more = 'Read More';
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
		<?php
			$data = '';
			  if($param) 
			 { 
			 	while($data=mysql_fetch_array($param))
				{ ?>
					<li style="text-align:center;" id="blog_text">
						<div class="contentheading"><?php echo $data['title'] ?></div>
						<p><?php echo $data['introtext'] ?></p><br/>
						<a class="readmore" href="blog_details.php?id=<?php echo $data['id'] ?>">Read more</a>
						<br/><br/>
					</li>
					
				<?php
				}
			 }
		?>
		
		<!-- Code for Ajax Lazy loader START -->
		 <div id="loading" style="display:none;" ><center>Content loading..</center></div>
		<script type="text/javascript">
					 $(document).ready(function() { 
						var start_at = <?php echo $end_at?>;
						var end_at = <?php echo $end_at?>;
						$(window).scroll(function() {
						   	if($(window).scrollTop() == $(document).height() - $(window).height()) {
								$('div#loading').show();
								$.ajax({
									dataType : "html" ,
									contentType : "application/x-www-form-urlencoded" ,
									url: "blog_ajax.php?start_at="+start_at+"&end_at="+end_at ,
									success: function(html) {
										if(html){		
											$("#placesList").append(html);
											start_at = start_at + end_at;
										}
									}
								});
								$('div#loading').hide();
							}
						});
					});
		</script>
		<!-- Code for Ajax Lazy loader END -->
	</ul>
  </div>
</body>
</html>