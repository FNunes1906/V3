<?php
//session_start(); 
defined('_JEXEC') or die('Restricted access');


$cfg	 = & JEVConfig::getInstance();
$data = $this->data;
if(JRequest::getVar('Itemid') == 98){
	echo "<h3 class='fl heading display'>".JText::_('JEV_VIEWBYWEEK')."</h3>";
}else{
	echo "<h3 class='fl heading display'>".JText::_('TW_THISMONTH')."</h3>";
}


/*echo "<div id='cal_title'>". JText::_('JEV_EVENTSFOR') ."</div>\n";	*/
?>
<!-- Event listing CATEGORY FILTER
<div class="bc fr" >
	<span class="bold"><?php echo JText::_('JEV_VIEWBYCAT');?>:</span>
	<?php $this->viewNavCatText( $this->catids, JEV_COM_COMPONENT, 'cat.listevents', $this->Itemid );?>
</div>
-->
<table align="center" width="100%" cellspacing="0" cellpadding="5" class="ev_table">
    
    <?php

	$num_events = count($data['rows']);
    $chdate ="";
    if( $num_events > 0 ){
    	echo "<tr>\n";

    	for( $r = 0; $r < $num_events; $r++ ){
    		$row = $data['rows'][$r];
			
			/*Code by Yogi for catgory list event begin */
			$_stDate = $row->yup()."-".$row->mup()."-".$row->dup();
			$_edDate = $row->ydn()."-".$row->mdn()."-".$row->ddn();
			
			if($_stDate != $_edDate){
				//continue;
			}
			
			/*Code by Yogi for catgory list event End */
		
    		$event_day_month_year 	= $row->dup() . $row->mup() . $row->yup();
    		// Ensure we reflect multiday setting
    		if (!$row->eventOnDate(mktime(0,0,0,$row->mup(),$row->dup(),$row->yup()))) continue;

    		if(( $event_day_month_year <> $chdate ) && $chdate <> '' ){
    			echo '</ul></td></tr>' . "\n";
    		}

    		if( $event_day_month_year <> $chdate ){
    			$date =JEventsHTML::getDateFormat( $row->yup(), $row->mup(), $row->dup(), 5 );
    			//echo $row->yup(), $row->mup(), $row->dup();
    			
				$strday = explode('-',$_SESSION['saturday_date']);
				$sndday = explode('-',$_SESSION['sunday_date']);
    			$date_sunday	=	JEventsHTML::getDateFormat($sndday[0],$sndday[1],$sndday[2], 5 );
				$date_saturday	=	JEventsHTML::getDateFormat($strday[0],$strday[1],$strday[2], 5 );
				echo '<tr>' . "\n";
    			echo '<td align="left" valign="top" class="ev_td_right"><ul class="ev_ul1">' . "\n";
    		}

    		$listyle = 'style="border-color:'.$row->bgcolor().';"';
			if($_stDate < $_SESSION['saturday_date']){
    			echo "<li class='ev_td_li' $listyle><div class='date fl'>".$date_saturday.'<br>&nbsp;&nbsp;&nbsp;&nbsp;-<br>'.$date_sunday."</div><div class='details'>\n";
    		}else{
				/* getDateFormat is chaging session variable so setting it back to the start result row */
				$reset_date =  JEventsHTML::getDateFormat( $row->yup(), $row->mup(), $row->dup(), 5 ); 	
				echo "<li class='ev_td_li' $listyle><div class='date fl'>".$date."</div><div class='details'>\n";
    		
			}

			if (!$this->loadedFromTemplate('icalevent.list_row', $row, 0)){
    			$this->viewEventRowNew ( $row,'view_detail',JEV_COM_COMPONENT, $Itemid);
    		}
    		echo "</li>\n";

    		$chdate = $event_day_month_year;
    	}
    	echo "</ul></td>\n";
    } else {
    	echo '<tr>';
    	echo '<td align="left" valign="top" class="ev_td_right">' . "\n";

   		echo JText::_('JEV_NO_EVENTS') .'</td>';
    }

    echo '</tr></table><br />' . "\n";
    echo '</fieldset><br /><br />' . "\n";

    // Create the pagination object
    if ($data["total"]>$data["limit"]){
    	$this->paginationForm($data["total"], $data["limitstart"], $data["limit"]);
    }
