<?php 
defined('_JEXEC') or die('Restricted access');

$cfg	 = & JEVConfig::getInstance();

$data = $this->datamodel->getCatData( $this->catids,false, $this->limit, $this->limitstart);
$Itemid = JEVHelper::getItemid();

?>

<!-- Event listing CATEGORY FILTER
<div class="bc fr" >
	<span class="bold"><?php echo JText::_('JEV_VIEWBYCAT');?>:</span><?php $this->viewNavCatText( $this->catids, JEV_COM_COMPONENT, 'cat.listevents', $this->Itemid );?>
</div>
-->

<?php 
if ( JRequest::getVar('task') === 'cat.listevents' ){
	echo "<h3 class='fl heading display'>".JText::_('JEV_EVENTLIST')."</h3>";
}

?>

<?php
if (count($data['catids'])==1 && $data['catids'][0]!=0 && strlen($data['catdesc'])>0){
	echo "<div class='jev_catdesc'>".$data['catdesc']."</div>";
}
echo '<table align="center" width="90%" cellspacing="0" cellpadding="5" class="ev_table">' . "\n";
$num_events = count($data['rows']);
$chdate ="";
if( $num_events > 0 ){
	echo "<tr>\n";

	for( $r = 0; $r < $num_events; $r++ ){
		$row = $data['rows'][$r];
		
		/*Code by Yogi for catgory list event begin */
		$_stDate = $row->yup()."-".$row->mup()."-".$row->dup();
		$_edDate = $row->ydn()."-".$row->mdn()."-".$row->ddn();
		/*Code by Yogi for catgory list event End */
		
		$event_day_month_year 	= $row->dup() . $row->mup() . $row->yup();

		if(( $event_day_month_year <> $chdate ) && $chdate <> '' ){
			echo '</ul></td></tr>' . "\n";
		}

		if( $event_day_month_year <> $chdate ){
		
			/* Code by Yogi for to check if event start and end date is diffrent then show today date Begin */
			if($_stDate == $_edDate){
				$date =JEventsHTML::getDateFormat( $row->yup(), $row->mup(), $row->dup(), 5 );
			}else{
				$date =JEventsHTML::getDateFormat( date("Y"), date("m"), date("d"), 5 );
			}
			/* Code by Yogi for to check if evetn start and end date is diffrent then show today date End */
			
			//echo '<tr><td class="ev_td_left">'.$date.'</td>' . "\n";
			//echo '<td align="left" valign="top" class="ev_td_right"><ul class="ev_ul">' . "\n";
			echo '<ul class="ev_ul">' . "\n";
		}

		//$listyle = 'style="border-color:'.$row->bgcolor().';"';
		echo "<li class='ev_td_li' $listyle><div class='date fl'>$date </div><div class='details'>\n";
			if (!$this->loadedFromTemplate('icalevent.list_row', $row, 5)){
				$this->viewEventRowNew ( $row);
				echo "&nbsp;::&nbsp;";
				$this->viewEventCatRowNew($row);
			}
		echo "</div></li>\n";

		$chdate = $event_day_month_year;
	}
	echo "</ul></td>\n";
} else {
	echo '<tr>';
	echo '<td align="left" valign="top" class="ev_td_right">' . "\n";

	if( count($this->catids)==0 ){
		echo JText::_('JEV_EVENT_CHOOSE_CATEG') . '</td>';
	} else {
		echo JText::_('JEV_NO_EVENTFOR') . '&nbsp;<b>' . $data['catname']. '</b></td>';
	}
}

echo '</tr></table><br />' . "\n";
echo '<br /><br />' . "\n";

// Create the pagination object
//if ($data["total"]>$data["limit"]){
//	$this->paginationForm($data["total"], $data["limitstart"], $data["limit"]);
//}
