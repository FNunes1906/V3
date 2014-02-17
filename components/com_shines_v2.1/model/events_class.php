<?php
# Class for all Event related queries and operation
class event {

	# Fetch events when events date is not specifed or start and end date are same
	function select_events($toyear,$tomonth,$today,$totalHours,$totalMinutes,$totalSeconds,$arrstrcat){
		$query = "SELECT rpt.*, ev.*, rr.*, det.*, ev.state as published , loc.loc_id,loc.title as loc_title, loc.title as location, loc.street as loc_street, loc.description as loc_desc, loc.postcode as loc_postcode, loc.city as loc_city, loc.country as loc_country, loc.state as loc_state, loc.phone as loc_phone , loc.url as loc_url    , loc.geolon as loc_lon , loc.geolat as loc_lat , loc.geozoom as loc_zoom    , YEAR(rpt.startrepeat) as yup, MONTH(rpt.startrepeat ) as mup, DAYOFMONTH(rpt.startrepeat ) as dup , YEAR(rpt.endrepeat ) as ydn, MONTH(rpt.endrepeat ) as mdn, DAYOFMONTH(rpt.endrepeat ) as ddn , HOUR(rpt.startrepeat) as hup, MINUTE(rpt.startrepeat ) as minup, SECOND(rpt.startrepeat ) as sup , HOUR(rpt.endrepeat ) as hdn, MINUTE(rpt.endrepeat ) as mindn, SECOND(rpt.endrepeat ) as sdn FROM jos_jevents_repetition as rpt LEFT JOIN jos_jevents_vevent as ev ON rpt.eventid = ev.ev_id LEFT JOIN jos_jevents_icsfile as icsf ON icsf.ics_id=ev.icsid LEFT JOIN jos_jevents_vevdetail as det ON det.evdet_id = rpt.eventdetail_id LEFT JOIN jos_jevents_rrule as rr ON rr.eventid = rpt.eventid LEFT JOIN jos_jev_locations as loc ON loc.loc_id=det.location LEFT JOIN jos_jev_peopleeventsmap as persmap ON det.evdet_id=persmap.evdet_id LEFT JOIN jos_jev_people as pers ON pers.pers_id=persmap.pers_id WHERE ev.catid IN(".$arrstrcat.") AND rpt.endrepeat >= '".$toyear."-".$tomonth."-".$today." 00:00:00' AND rpt.startrepeat <= '".$toyear."-".$tomonth."-".$today." 23:59:59' AND ev.state=1 AND rpt.endrepeat>='".date('Y',mktime($totalHours, $totalMinutes, $totalSeconds))."-".date('m',mktime($totalHours, $totalMinutes, $totalSeconds))."-".date('d', mktime($totalHours, $totalMinutes, $totalSeconds))." 00:00:00' AND ev.access <= 0 AND icsf.state=1 AND icsf.access <= 0 and ((YEAR(rpt.startrepeat)=".$toyear." and MONTH(rpt.startrepeat )=".$tomonth." and DAYOFMONTH(rpt.startrepeat )=".$today.") or freq<>'WEEKLY')GROUP BY rpt.rp_id";
		$result = mysql_query($query) or die(mysql_error());
		return $result;
	}
	
	# Fetch events when events date is not specifed or start and end date are same
	function select_events_from_rpid($strchk){
		$query = "select *,DATE_FORMAT(`startrepeat`,'%h:%i %p') as timestart, DATE_FORMAT(`endrepeat`,'%h:%i %p') as timeend from jos_jevents_repetition where rp_id in ($strchk) ORDER BY `startrepeat` ASC ";
		$result = mysql_query($query) or die(mysql_error());
		return $result;
	}
	
	# Select Pagemeta Title for Event
	function select_pagemeta_title(){
		$query 		= "select title from `jos_pagemeta`where uri='/events'";
		$result		= mysql_query($query) or die(mysql_error());
		$pagemeta	= mysql_fetch_array($result);
		return $pagemeta;
	}
	
	/* @@@@ Event TPL File function BEGIN @@@ */
	
	# Fetch event data from "event" table
	function ev_from_id($eventid){
		$query 		= "select *  from jos_jevents_vevent where ev_id=$eventid";
		$result		= mysql_query($query) or die(mysql_error());
		$evDetails 	= mysql_fetch_array($result);
		return $evDetails;
	}
	# Fetch category name of the event from "category" table
	function cat_from_id($catid){
		$query 		= "select title  from jos_categories where id=$catid";
		$result		= mysql_query($query) or die(mysql_error());
		$catData 	= mysql_fetch_object($result);
		return $catData;
	}
	# Fetch Event detail from "event detail" table
	function evdetail_from_id($evDetailId){
		$query 			= "select *  from jos_jevents_vevdetail where evdet_id=$evDetailId";
		$result			= mysql_query($query) or die(mysql_error());
		$evDetailData 	= mysql_fetch_array($result);
		return $evDetailData;
	}
	# Fetch event location detail from "location" table
	function location_from_id($locationId){
		$query 			= "select *  from jos_jev_locations where loc_id=$locationId";
		$result			= mysql_query($query) or die(mysql_error());
		$locationData 	= mysql_fetch_array($result);
		return $locationData;
	}
	
	# Function to fetch Event for given date	
	function fetch_ev_for_given_date($arrstrcat,$ev_toyear,$ev_tomonth,$ev_today,$totalHours,$totalMinutes,$totalSeconds){
		$query 	= "SELECT rpt.*, ev.*, rr.*, det.*, ev.state as published , loc.loc_id,loc.title as loc_title, loc.title as location, loc.street as loc_street, loc.description as loc_desc, loc.postcode as loc_postcode, loc.city as loc_city, loc.country as loc_country, loc.state as loc_state, loc.phone as loc_phone , loc.url as loc_url    , loc.geolon as loc_lon , loc.geolat as loc_lat , loc.geozoom as loc_zoom    , YEAR(rpt.startrepeat) as yup, MONTH(rpt.startrepeat ) as mup, DAYOFMONTH(rpt.startrepeat ) as dup , YEAR(rpt.endrepeat ) as ydn, MONTH(rpt.endrepeat ) as mdn, DAYOFMONTH(rpt.endrepeat ) as ddn , HOUR(rpt.startrepeat) as hup, MINUTE(rpt.startrepeat ) as minup, SECOND(rpt.startrepeat ) as sup , HOUR(rpt.endrepeat ) as hdn, MINUTE(rpt.endrepeat ) as mindn, SECOND(rpt.endrepeat ) as sdn FROM jos_jevents_repetition as rpt LEFT JOIN jos_jevents_vevent as ev ON rpt.eventid = ev.ev_id LEFT JOIN jos_jevents_icsfile as icsf ON icsf.ics_id=ev.icsid LEFT JOIN jos_jevents_vevdetail as det ON det.evdet_id = rpt.eventdetail_id LEFT JOIN jos_jevents_rrule as rr ON rr.eventid = rpt.eventid LEFT JOIN jos_jev_locations as loc ON loc.loc_id=det.location LEFT JOIN jos_jev_peopleeventsmap as persmap ON det.evdet_id=persmap.evdet_id LEFT JOIN jos_jev_people as pers ON pers.pers_id=persmap.pers_id WHERE ev.catid IN(".$arrstrcat.") AND rpt.endrepeat >= '".$ev_toyear."-".$ev_tomonth."-".$ev_today." 00:00:00' AND rpt.startrepeat <= '".$ev_toyear."-".$ev_tomonth."-".$ev_today." 23:59:59' AND ev.state=1 AND rpt.endrepeat>='".date('Y',mktime($totalHours, $totalMinutes, $totalSeconds))."-".date('m',mktime($totalHours, $totalMinutes, $totalSeconds))."-".date('d', mktime($totalHours, $totalMinutes, $totalSeconds))." 00:00:00' AND ev.access <= 0 AND icsf.state=1 AND icsf.access <= 0 and ((YEAR(rpt.startrepeat)=".$ev_toyear." and MONTH(rpt.startrepeat )=".$ev_tomonth." and DAYOFMONTH(rpt.startrepeat )=".$ev_today.") or freq<>'WEEKLY')GROUP BY rpt.rp_id";
		$result		= mysql_query($query) or die(mysql_error());
		return $result;
	}
	
	/* @@@ Event TPL File function END @@@ */
	
	# Fetch Featured event
	function select_featured_event($featureyear,$featuremonth,$featureday,$LY,$LM,$LD){
		$query = "SELECT rpt.rp_id, rpt.startrepeat,DATE_FORMAT(rpt.startrepeat,'%Y') as Eyear,DATE_FORMAT(rpt.startrepeat,'%m') as Emonth,DATE_FORMAT(rpt.startrepeat,'%d') as EDate,DATE_FORMAT(rpt.startrepeat,'%m/%d') as Date,DATE_FORMAT(rpt.startrepeat,'%h:%i %p') as timestart,DATE_FORMAT(rpt.endrepeat,'%h:%i %p') as timeend,rpt.endrepeat,ev.ev_id,evd.evdet_id, ev.catid,cat.title as category,evd.description, loc.title, evd.location,evd.summary,cf.value FROM jos_jevents_vevent AS ev,jos_jevents_vevdetail AS evd,jos_jev_locations as loc, jos_categories AS cat,jos_jevents_repetition AS rpt,jos_jev_customfields AS cf WHERE rpt.eventid = ev.ev_id AND loc.loc_id = evd.location AND rpt.eventdetail_id = evd.evdet_id AND ev.catid = cat.id AND ev.state = 1 AND rpt.eventdetail_id = cf.evdet_id AND cf.value = 1 AND rpt.endrepeat >= '".$featureyear."-".$featuremonth."-".$featureday." 00:00:00' AND rpt.startrepeat <= '".$LY."-".$LM."-".$LD." 23:59:59' GROUP BY rpt.eventid,rpt.startrepeat ORDER BY rpt.startrepeat";
		$result = mysql_query($query) or die(mysql_error());
		return $result;
	}
	
	function select_rowfilter_rpid($rec_filter){
		while($row_filter = mysql_fetch_array($rec_filter)){
			$arr_rr_id[] = $row_filter['rp_id'];
		}	
		return $arr_rr_id;
	}

	function select_event_categories_from_id($catId){
		$query				= "SELECT  id,name FROM `jos_categories` WHERE (`parent_id` =".$catId." OR `id` =".$catId.") AND PUBLISHED = 1 ORDER BY name";
		$result_event_cat 	= mysql_query($query) or die(mysql_error());
		return $result_event_cat;
	}

	function select_event_categories(){
		$query				= "SELECT id,name FROM jos_categories WHERE section LIKE 'com_jevents' AND PUBLISHED = 1 ORDER BY name";
		$result_event_cat 	= mysql_query($query) or die(mysql_error());
		return $result_event_cat;
	}
	
	function select_cat_id($catId){
		$query				= "SELECT c.id FROM jos_categories AS c WHERE (c.id=".$catId." OR parent_id=".$catId.") and c.access <= 2 AND c.published = 1 AND c.section = 'com_jevents'";
		$result_event_cat 	= mysql_query($query) or die(mysql_error());
		return $result_event_cat;
	}	
	
	function select_cat(){
		$query				= "SELECT c.id FROM jos_categories AS c LEFT JOIN jos_categories AS p ON p.id=c.parent_id LEFT JOIN jos_categories AS gp ON gp.id=p.parent_id LEFT JOIN jos_categories AS ggp ON ggp.id=gp.parent_id WHERE c.access <= 2 AND c.published = 1 AND c.section = 'com_jevents'";
		$result_event_cat 	= mysql_query($query) or die(mysql_error());
		return $result_event_cat;
	}

	// Fetch location detail data
	function fetch_eventdetail_time($eid) {
		$query	= "select *,DATE_FORMAT(`startrepeat`,'%h:%i %p') as timestart, DATE_FORMAT(`endrepeat`,'%h:%i %p') as timeend from jos_jevents_repetition where rp_id=".$eid;
		$rec	= mysql_query($query) or die(mysql_error());
		return $rec;
	}
	
	function fetch_event_title($ev_id){
		$queryvevdetail = "select summary from jos_jevents_vevdetail where evdet_id=".$ev_id;
		$recvevdetail   = mysql_query($queryvevdetail) or die(mysql_error());
		$rowvevdetail   = mysql_fetch_array($recvevdetail);
		return $rowvevdetail;
	}
	
	function fetch_eventdetail_data($evd_id){
		$queryvevdetail = "select *  from jos_jevents_vevdetail where evdet_id=".$evd_id;
		$recvevdetail 	= mysql_query($queryvevdetail) or die(mysql_error());
		$rowvevdetail	= mysql_fetch_array($recvevdetail);
		return $rowvevdetail;
	}
	
	function fetch_location_detail($row_ev_id){
		$querylocdetail	= "select *  from jos_jev_locations where loc_id=".$row_ev_id;
		$reclocdetail	= mysql_query($querylocdetail) or die(mysql_error());
		$rowlocdetail	= mysql_fetch_array($reclocdetail);
		return $rowlocdetail;
	}
}	