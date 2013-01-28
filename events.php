<?php
require('jevents.php');

/**
Purpose: Code for Joomla menu
Developer: Yogi
Last Updated Date: 27-12-2012
**/
require('jmenu.php');
/** Code for Joomla menu End **/

global $var;
include_once('./inc/var.php');
include_once($var->inc_path.'base.php');
_init();



// for facebook description issue.
$intro = db_fetch("select introtext from `jos_content` where `title` = 'Events Page Introduction'");
?>

<!DOCTYPE HTML>
<html>
<head>

<title><?php echo $var->site_name.' | '.$var->page_title; ?></title>
<link rel="image_src" href="http://<?php echo $_SERVER['HTTP_HOST']?>/partner/<?php echo $_SESSION['partner_folder_name']?>/images/logo/logo.png" />  
<meta property="og:image" content="http://<?php echo $_SERVER['HTTP_HOST']?>/partner/<?php echo $_SESSION['partner_folder_name']?>/images/logo/logo.png"/>
<meta property="og:title" content="<?php echo $var->site_name.' | '.$var->page_title; ?>"/>
<meta property="og:description" content="<?php echo strip_tags($intro); ?>"/>

<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="<?php echo $var->keywords; ?>" />
<meta name="description" content="<?php echo $var->metadesc; ?>" />
<meta name="description" content="<?php echo $var->extra_meta; ?>" />

<script>
  document.createElement('header');
  document.createElement('nav');
  document.createElement('section');
  document.createElement('article');
  document.createElement('aside');
  document.createElement('footer');
</script>

<!-- set css and js path for new design v3 -->

<meta name="viewport" content="width=device-width;initial-scale = 1.0,maximum-scale = 1.0" />
<link rel="stylesheet" type="text/css" href="common/<?php echo $_SESSION['style_folder_name'];?>/css/fonts.css" />
<link rel="stylesheet" type="text/css" href="common/<?php echo $_SESSION['style_folder_name'];?>/css/core.css" />
<link rel="stylesheet" type="text/css" href="common/<?php echo $_SESSION['style_folder_name'];?>/css/tablet.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="common/<?php echo $_SESSION['style_folder_name'];?>/js/jquery.carouFredSel-6.1.0-packed.js"></script>
<script type="text/javascript" src="common/<?php echo $_SESSION['style_folder_name'];?>/js/jquery.touchSwipe.min.js"></script>
<script type="text/javascript" src="common/<?php echo $_SESSION['style_folder_name'];?>/js/yetii-min.js"></script>
<script type="text/javascript" src="common/<?php echo $_SESSION['style_folder_name'];?>/js/tw.js"></script>

<!-- End css and js path for new design v3 -->

<!-- V2 css and js 
<link rel="stylesheet" type="text/css" href="common/templatecolor/<?php echo $_SESSION['style_folder_name'];?>/css/all.css" media="screen" />
<link rel="stylesheet" type="text/css" href="common/css/jquery-ui.css" media="screen" />
<script type="text/javascript" src="common/js/jquery.min.js"></script>
<script type="text/javascript" src="common/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="common/js/default.js"></script>
-->
<link rel="stylesheet" type="text/css" media="all" href="common/DatePick/jsDatePick_ltr.min.css" />


<script type="text/javascript" src="common/DatePick/jsDatePick.jquery.full.1.3.js"></script> 

<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"inputField",
			dateFormat:"%d-%M-%Y"
			/*selectedDate:{				This is an example of what the full configuration offers.
				day:5,						For full documentation about these settings please see the full version of the code.
				month:9,
				year:2006
			},
			yearsRange:[1978,2020],
			limitToToday:false,
			cellColorScheme:"beige",
			dateFormat:"%m-%d-%Y",
			imgPath:"img/",
			weekStartDay:1*/
		});

		if(document.getElementById('inputField').value == ''){
			document.getElementById('inputField').value='Search Events by Date';
		}
	};

	function setBlank(htmlObj)
	{
		if(htmlObj.value=='Search Events by Date')
		{
			htmlObj.value='';
		}
	}

	function setEventDate(htmlObj)
	{
		htmlObj.value= date();
	}

	function subForm()
	{
		document.getElementById('frmEventDateSubmit').submit();
	}

</script>
<?php include("ga.php"); ?>
</head>

<body>

<header>
	<?php m_header(); ?> <!-- header -->
</header>

<!-- Content Start -->
<div id="Content" class="sWidth">
	<div id="MainContent">
	  	<aside>
	    	<?php m_aside(); ?>
		</aside> <!-- left Column -->
	

		<div id="WidgetArea">
			<section>
			  		 <?php //m_event_list_intro(); ?>
				
				<!-- This Week Section Start -->
				<div class="centerCol fl">
          			<div id="ThisWeek" class="sect horiz list">
           				 <div class="cont">
				 
							 <?php m_event_list(); ?>
						 </div>
          			</div>
        		</div>

       			 <!-- This Week Section End -->
				 
				<div id="EventsInfo" class="neg rightCol fr spread">

		          		          
		          <!-- List Your Event Section Start -->

		          <div class="fl">
		            <div id="ListEvent" class="sect list">
		              <div class="cont">
		                <h3 class="fl"><a class="heading display" href="events_submit.php">Submit Your Event!</a></h3>
		                <p class="cl">Click Here to Submit your event!</p>
		              </div>
		            </div>
		          </div>
				
		          <!-- List Your Event Section End -->
				  
				</div>
				
				 <div id="LowerAds" class="neg adSect dual rightCol fr">

			          <!-- 300 x 250_3 Banner Ad Start -->

				          <?php for($i=1;$i<=3;++$i):?>
							<div class="ad space">
				  	      		<?php m_show_banner("Website right $i"); ?>
							</div>
							<?php endfor; ?>
			          <!-- 300 x 250_4 Banner Ad End -->

			     </div>

			     <div id="LowerTallAd" class="neg adSect tall rightCol fr cr">

			          <!-- 300 x 600 Banner Ad Start -->

			          <div class="ad">
			            <?php m_show_banner('Website right 4'); ?>
			          </div>

			          <!-- 300 x 600 Banner Ad End -->

			     </div>
			</section>
		</div>
	</div> 
</div> <!-- Content end -->
<div id="Footer">
	<div class="sWidth">
		<footer>
			<?php m_footer(); ?> <!-- footer -->
		</footer>
	</div>
</div>

</body>
</html> 


