<?php
$host = $_SERVER[HTTP_HOST];
$eurl = utf8_encode("http://$host/event_details.php");
$egurl = str_replace('%20','%2B',$eurl);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Callback Example Button</title>
		<style>
			
/* AddThisEvent (add to your existing CSS) START */
.addthisevent-drop       {display:inline-block;position:relative;z-index:999998;font-family:'Roboto',sans-serif;color:#fff!important;text-decoration:none;font-size:15px;text-decoration:none;}
.addthisevent-drop:hover     {color:#fff;font-size:15px;text-decoration:none;}
.addthisevent_dropdown      {position:relative;text-align:left;display:block!important;}
.addthisevent_dropdown span    {display:inline-block;position:relative;line-height:110%;background:#ebebeb url(../gfx/button-bg.png) repeat-x;text-decoration:none;font-size:14px;font-weight:300;color:#333;cursor:pointer;padding:7px 12px 8px 12px;border:1px solid #e1e1e1;margin:0px 6px 0px 0px;-moz-border-radius:4px;-webkit-border-radius:4px; border-radius: 4px;}
.addthisevent_dropdown span:hover   {background:#f4f4f4;color:#000;text-decoration:none;font-size:14px;}
.addthisevent_dropdown span:active   {top:1px;}
.addthisevent_dropdown .ateoutlook   {border-top:3px solid #fa9d00;}
.addthisevent_dropdown .ategoogle   {border-top:3px solid #d53900;}
.addthisevent_dropdown .atehotmail   {border-top:3px solid #1473c5;}
.addthisevent_dropdown .ateyahoo   {border-top:3px solid #65106e;}
.addthisevent_dropdown .ateical   {border-top:3px solid #ab373a;}
.addthisevent span       {display:none!important;}
.addthisevent-drop ._url,.addthisevent-drop ._start,.addthisevent-drop ._end,.addthisevent-drop ._summary,.addthisevent-drop ._description,.addthisevent-drop ._location,.addthisevent-drop ._organizer,.addthisevent-drop ._organizer_email,.addthisevent-drop ._facebook_event,.addthisevent-drop ._all_day_event {display:none!important;}
.addthisevent_dropdown .copyx    {display:none;}
.addthisevent_dropdown .brx    {display:none;}
.addthisevent_dropdown .frs    {position:absolute;top:8px;cursor:pointer;right:13px;padding-left:10px;font-style:normal;font-weight:normal;text-align:right;z-index:101;line-height:110%;background:#fff;text-decoration:none;font-size:10px;color:#cacaca;}
.addthisevent_dropdown .frs:hover   {color:#6d84b4;}
.addthisevent        {visibility:hidden;}
/* AddThisEvent (add to your existing CSS) END */
		</style>
		<script src="javascript/libs/ical.js"></script>
		<?php
		$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
		if(stripos($ua,'android') == True){
			?>
			<script type="text/javascript">
				addthisevent.settings({
						mouse	: false,
						css		: false,
						outlook:{show:false, text:"Outlook"},
						google	:{show:true,  text:"Add to cal"},
						yahoo:{show:false, text:"Yahoo"},
						ical	:{show:false, text:"Add to cal"},
						hotmail:{show:false, text:"Hotmail"}
					});
			</script>
			<?php
		}else{
			?>
			<script type="text/javascript">
				addthisevent.settings({
						mouse	: false,
						css	: false,
						outlook:{show:false, text:"Outlook"},
						google	:{show:false, text:"Add to Gcal"},
						yahoo:{show:false, text:"Yahoo"},
						ical	:{show:true,  text:"Add to cal"},
						hotmail:{show:false, text:"Hotmail"}
					});
			</script>
			<?php } ?>
	</head>

	<body>
		  <p>
	  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum commodo nibh a metus tempor fringilla. Suspendisse sagittis arcu sed ultricies faucibus. Vivamus et pulvinar erat. Praesent a tempus purus, ac viverra augue. Morbi ac elit non justo tempus porta sit amet sit amet lectus. Vestibulum vulputate diam nibh, a sodales dolor tempor eu. Sed elementum neque vitae egestas consectetur. Sed in metus vel justo rhoncus lobortis vitae et neque. </p>
	  <p>Vivamus id quam et neque tincidunt aliquam. Donec lacus ante, commodo sed laoreet sodales, ultrices pulvinar erat. Suspendisse condimentum scelerisque lorem, id fringilla massa. Quisque lacinia arcu vitae tortor vehicula tristique.
	    
	    Cras in viverra massa, tincidunt luctus felis. Vivamus augue lectus, facilisis a elit nec, hendrerit egestas mauris. Pellentesque justo sapien, vehicula aliquet egestas a, consectetur ut lacus. Integer eget augue vitae nisl luctus vehicula. Proin lectus massa, luctus eu nisl at, laoreet faucibus neque. Fusce quis ultrices libero. Praesent id metus sed mi tristique dapibus.</p>
	  
	 	  <p>Sed non vulputate arcu. Integer volutpat mauris sit amet justo bibendum cursus. Suspendisse malesuada mauris eu tortor aliquet mollis.  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean faucibus lacinia luctus. Aliquam sodales egestas mauris, sed congue sem viverra eget. </p>

	  <p>Sed non vulputate arcu. Integer volutpat mauris sit amet justo bibendum cursus. Suspendisse malesuada mauris eu tortor aliquet mollis.  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean faucibus lacinia luctus. Aliquam sodales egestas mauris, sed congue sem viverra eget. </p>
	  <p>Sed tristique eros at tortor vehicula porta. Cras tristique quam lacinia risus tincidunt, quis ullamcorper sem egestas. Suspendisse fringilla, turpis vitae hendrerit consectetur, tellus elit aliquam nibh, sed fermentum dui sem sit amet nisl. Aliquam vulputate lectus a nunc consequat, quis sagittis lectus sollicitudin. In scelerisque mattis gravida. Maecenas ut vestibulum tellus. Sed a elementum orci, ac imperdiet augue. Sed aliquet lorem augue, ut consequat augue iaculis eu. Nullam a purus eu lectus blandit mattis. Mauris vel odio leo. Pellentesque ut fringilla lorem. </p>
	 <hr />
		 <!-- code for ical calendar start-->
								
					<div class="addthisevent">
						<span class="_start">02-25-2014 09:00 AM</span>
			    			<span class="_end">02-25-2014 11:59 PM</span> 
					  	<span class="_summary">Party to night</span>
					   	<span class="_description">testting call</span>
					    	<span class="_location">Ahmedabad</span>
					  	<span class="_date_format">MM/DD/YYYY</span>
					</div>
			<!-- code for ical calendar end--> 
	 <hr/>

		<!-- AddThis Button BEGIN -->
		<a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=300&amp;amp;pubid=xa-52fe09cd1d487e27"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0"/></a>
		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-52fe09cd1d487e27"></script>
		<!-- AddThis Button END -->
		<hr/>
		<span class='st_facebook_large' displayText='Facebook'></span>
		<span class='st_googleplus_large' displayText='Google +'></span>
		<span class='st_twitter_large' displayText='Tweet'></span>
		<span class='st_email_large' displayText='Email'></span>
		<script type="text/javascript">var switchTo5x=true;</script>
		<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
		<script type="text/javascript">stLight.options({publisher: "d6b276ac-1b12-4992-ba44-8f62d7452c2e", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
		<hr/>
		<div>
			<div style='float:left;padding:3px 3px 3px 8px;'>
				<a expr:share_url='data:post.url' href='http://www.facebook.com/sharer.php?u=<?php echo $eurl; ?>' name='fb_share' type='box_count'><div class="facebook">facebook</div></a>
			</div>
			<div style='float:left;padding:3px 3px 3px 8px;'>
				<a href="https://plus.google.com/share?url=<?php echo $egurl; ?>" onclick="javascript:window.open(this.href,'','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><div class="google">google</div></a>
			</div>
			<div style='float:left;padding:3px 3px 3px 8px;'>
				<a href="mailto:<?php echo $email;?>?body=<?php echo $eurl; ?>">mail</a>
			</div>
		</div>
	</body>
</html>


