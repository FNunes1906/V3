<?php 
include("connection.php");

$start_at = $_GET['start_at'];
$end_at	= $_GET['end_at'];

$todaydate = date("Y-m-j",strtotime("+1 day"));
$today = date("Y-m-d G:i:s");

$sql = "select jc.* from `jos_content` jc, `jos_categories` jcs where jcs.title = 'Blog' and jcs.id = jc.catid and jc.state=1 and (jc.publish_down>'".$today."' or jc.publish_down='0000-00-00 00:00:00') and (jc.publish_up <= '".$todaydate."' or jc.publish_up='0000-00-00 00:00:00') order by jc.ordering LIMIT " .$start_at.",".$end_at;
$recblogdata = mysql_query($sql);

header('Content-type: text/html;charset=ISO-8859-1', true);

if(mysql_num_rows($recblogdata)>0)
{
	while($data = mysql_fetch_array($recblogdata)){
		$b_title = $data["title"];
		$b_intro = $data["introtext"];
		$b_id = $data["id"];
		echo "<li style='text-align:center;' id='blog_text'><div class='contentheading'>$b_title</div>
		<p>$b_intro</p><br/><a class='readmore' href='blog_details.php?id=$b_id'>Read more</a><br/><br/></li>";
	}
}
?>