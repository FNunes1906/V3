<?php 
defined('_JEXEC') or die('Restricted access');

/* $current_cat Used to get current category id for event when search through datepicker */
global $current_cat;		
$current_cat =  $this->datamodel->catidList;

/* Timezone Block Begin August 2013 */
$timezoneValue 	= $_SESSION['tw_timezone'];

//Setting up Timezone time (hour, minut and second) varible
$timeZoneArray 	= explode(':',$timezoneValue);
$totalHours	= date("H") + $timeZoneArray[0];
$totalMinutes = date("i") + $timeZoneArray[1];
$totalSeconds = date("s") + $timeZoneArray[2];

// Using mktime function setting up final date in timestamp based on timezone specified in $totalHours & $totalMinutes
$timeZoneDate = mktime($totalHours, $totalMinutes, $totalSeconds, $this->month, $this->day, $this->year);

// Create array from modified time timzondate varialbe
$weekStartDate = explode('/',strftime("%m/%d/%Y",$timeZoneDate));

// Assign final week start date to date,year,month data set.
list($this->month, $this->day, $this->year) = $weekStartDate;

/* Timezone Block End August 2013 */

$cfg	 = & JEVConfig::getInstance();
$data = $this->datamodel->getWeekData($this->year, $this->month, $this->day);

$option = JEV_COM_COMPONENT;
$Itemid = JEVHelper::getItemid();
$menu = JFactory::getApplication()->getMenu();
$menuname = $menu->getActive()->name;

?>
<!-- Event listing CATEGORY FILTER
<div class="bc fr" ><span class="bold"><?php echo JText::_("TW_EVENT_TYPE") ?>:</span><?php $this->viewNavCatText( $this->catids, JEV_COM_COMPONENT, 'cat.listevents', $this->Itemid );?></div>
-->
<?php 

	/* Fetching Date Format from Page Global */
	$db1 =& JFactory::getDBO();
	$pageglobal = "select date_format,time_format,site_name from `jos_pageglobal`";
	$db1->setQuery($pageglobal);
	$df=$db1->query();
	$d=mysql_fetch_row($df);
	$df=$d[0];
	$tf=$d[1];
	
	
if($_REQUEST['searchdate']!=''){
	$search_date = explode(" - ",$_REQUEST['searchdate']);
	$start_date=(strftime ($df,strtotime($search_date[0])));
	$end_date=(strftime ($df,strtotime($search_date[1])));
	echo "<h2 class='fl heading display'>". JText::_('JEV_EVENTFROM') ." ".$start_date." to ".$end_date."</h2><br/>";
}elseif ( JRequest::getVar('task') === 'week.listevents' AND JRequest::getVar('view') === 'week' AND JRequest::getVar('Itemid') == 97){
	echo "<h2 class='fl heading display'>". JText::_('TW_THIS_WEEK')." ".JText::_('EVENTS_IN')." ".$d[2]."</h2><br/>";
}elseif ( JRequest::getVar('task') === 'week.listevents' AND JRequest::getVar('view') === 'week' ){
	echo "<h2 class='fl heading display'>". JText::_('TW_THIS_WEEK')." ".$menuname." ".JText::_('EVENTS_IN')." ".$d[2]."</h2><br/>";
}else {
	echo "<h2 class='fl heading display'>". JText::_('TW_LIST_OF_EVENTS'). "</h2><br/>";
}

//CODE START BY AKASH

if($_REQUEST['searchdate']!=''){
	
	$raw_search_date = explode(" - ",$_REQUEST['searchdate']);
	$ser_start_date=date("Y-m-d",strtotime($raw_search_date[0]));
	$ser_end_date=date("Y-m-d",strtotime($raw_search_date[1]));

		$row = mysql_fetch_array($rows);

		$data1 = $this->datamodel->getRangeDataCalender($ser_start_date, $ser_end_date);
		
		echo "<ul class='ev_ul'>\n";
		
		$loopcounter = $_SESSION['listcaldays'];
		$_SESSION['listcaldays'] = "";
		
		// Loop Start for display each day data
		for( $d = 0; $d < $loopcounter; $d++ ){

			$day_link = '<div class="date fl">'. JEventsHTML::getDateFormat( $data1['days'][$d]['week_year'], $data1['days'][$d]['week_month'], $data1['days'][$d]['week_day'], 5 ).'</div>'."\n";

			if( $data1['days'][$d]['today'])	$bg = 'class="ev_td_today"';
			else $bg = 'class="ev_td_left"';

			$num_events	= count($data1['days'][$d]['rows']);
			if ($num_events>0) {
				
				echo "<div class='ev_td_right'>";
				for( $r = 0; $r < $num_events; $r++ ){
					$row = $data1['days'][$d]['rows'][$r];
					echo "<li class='ev_td_li' $listyle><div class='date fl'>$day_link </div><div class='details'>\n";
					if (!$this->loadedFromTemplate('icalevent.list_row', $row, 5)){
						$this->viewEventRowNew ( $row);
						echo "&nbsp;::&nbsp;";
						$this->viewEventCatRowNew($row);
					}
					echo "</div></li>\n";
				}
				echo "</div>";
			}
		} 
	//CODE END BY AKASH 
	
}else{/* Code End by Rinkal */

	if (count($data['catids'])==1 && $data['catids'][0]!=0 && strlen($data['catdesc'])>0){
		echo "<div class='jev_catdesc'>".$data['catdesc']."</div>";
	}
	echo "<ul class='ev_ul'>\n";

	for( $d = 0; $d < 7; $d++ ){

		$day_link = '<div class="date fl">'

		. JEventsHTML::getDateFormat( $data['days'][$d]['week_year'], $data['days'][$d]['week_month'], $data['days'][$d]['week_day'], 5 ).'</div>'."\n";

		if( $data['days'][$d]['today'])	$bg = 'class="ev_td_today"';
		else $bg = 'class="ev_td_left"';

		$num_events	= count($data['days'][$d]['rows']);
		if ($num_events>0) {
			
	echo "<div class='ev_td_right'>";
			for( $r = 0; $r < $num_events; $r++ ){
				$row = $data['days'][$d]['rows'][$r];
				
				echo "<li class='ev_td_li' $listyle><div class='date fl'>$day_link </div><div class='details'>\n";
				if (!$this->loadedFromTemplate('icalevent.list_row', $row, 5)){
					$this->viewEventRowNew ( $row);
					echo "&nbsp;::&nbsp;";
					$this->viewEventCatRowNew($row);
				}
				echo "</div></li>\n";
			}
			echo "</div>";
		}
	} 
	
	echo "</ul>\n";
}
