<?php
/**
 * JEvents Component for Joomla 1.5.x
 *
 * @version     $Id: iCalEvent.php 1756 2010-05-05 09:19:47Z geraint $
 * @package     JEvents
 * @copyright   Copyright (C) 2008-2009 GWE Systems Ltd, 2006-2008 JEvents Project Group
 * @license     GNU/GPLv2, see http://www.gnu.org/licenses/gpl-2.0.html
 * @link        http://www.jevents.net
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );



class iCalEvent extends JTable  {

	/** @var int Primary key */
	var $ev_id					= null;

	/**
	 * This holds the raw data as an array 
	 *
	 * @var array
	 */
	var $data;
	var $rrule = null;

	var $_detail;
	var $vevent;

	var $_start = null;
	var $_end = null;

	// array of exception date via EXDATE tag
	var $_exdate = array();

	// default values
	//var $rinterval = 1;
	//var $freq = "DAILY";
	//var $description = "";
	//var $summary = "";
	//var $dtstart="";
	//var $dtend="";

	var $access = 0;
	var $state = 1;

	/**
	 * Null Constructor
	 */
	function iCalEvent( &$db ) {
		parent::__construct( '#__jevents_vevent', 'ev_id', $db );
	}


	/**
	 * override store function to force rrule to save too!
	 *
	 * @param unknown_type $updateNulls
	 */
	function store($updateNulls=false , $overwriteCreator = false) {
		$user =& JFactory::getUser();

		if ($this->ev_id==0){
			$date =& JFactory::getDate();
			$this->created = $date->toMySQL();
		}

		if (!isset($this->created_by) || is_null($this->created_by) || $this->created_by==0){
			$this->created_by		= $user->id;
		}
		$this->modified_by		= $user->id;
		if (!isset($this->created_by_alias) || is_null($this->created_by_alias) || $this->created_by_alias==""){
			$this->created_by_alias		= "";
		}

		// make sure I update existing detail
		$matchingDetail = $this->matchingEventDetails();
		if (isset($matchingDetail) && isset($matchingDetail->evdet_id)){
			$this->_detail->evdet_id = $matchingDetail->evdet_id;
		}

		// if existing row preserve created by - unless being overwritten by authorised user
		// If user is jevents can deleteall or has backend access then allow them to specify the creator
		$jevuser	= JEVHelper::getAuthorisedUser();
		$creatorid = JRequest::getInt("jev_creatorid",0);
		$access = false;
		if ($user->get('id')>0){
			// does this logged in have backend access
			// Get an ACL object
			$acl =& JFactory::getACL();
			$grp = $acl->getAroGroup($user->get('id'));
			// if no valid group (e.g. anon user) then skip this.
			if (!$grp) return;

			$access = $acl->is_group_child_of($grp->name, 'Public Backend');
		}

		if (!(($jevuser && $jevuser->candeleteall) || $access) || $creatorid==0){
			if (!is_null($this->ev_id) || $this->ev_id>0) {
				// we can overwrite the creator if refreshing/saving an ical with specified creator
				if (isset($matchingDetail) && $matchingDetail->created_by>0 && !$overwriteCreator){
					$this->created_by = $matchingDetail->created_by;
				}
			}
		}

		$db =& JFactory::getDBO();
		$detailid = $this->_detail->store($updateNulls);
		if (!$detailid){
			JError::raiseError( 104, JText::_("Problems storing Event Detail"));
			echo $db->getErroMsg()."<br/>";
			return false;
		}
		$this->detail_id = $detailid;
		if (!parent::store($updateNulls)){
			JError::raiseError( 105, JText::_("Problems storing Event") );
			echo $db->getErrorMsg()."<br/>";
			return false;
		}

		// I also need to store custom data - when we need the event itself and not just the detail
		$dispatcher	=& JDispatcher::getInstance();
		// just incase we don't have jevents plugins registered yet
		JPluginHelper::importPlugin("jevents");
		$res = $dispatcher->trigger( 'onStoreCustomEvent' , array(&$this));

		if (isset($this->rrule)) {
			$this->rrule->eventid = $this->ev_id;
			if($id = $this->rrule->isDuplicate()){
				$this->rrule->rr_id = $id;
			}
			$this->rrule->store($updateNulls);
			echo $db->getErrorMsg()."<br/>";
		}
		return true;
	}

	function isDuplicate(){
		$sql = "SELECT ev_id from #__jevents_vevent as vev WHERE vev.uid = '".$this->uid."'";
		$this->_db->setQuery($sql);
		$matches = $this->_db->loadObjectList();
		if (count($matches)>0 && isset($matches[0]->ev_id)) {
			return $matches[0]->ev_id;
		}
		return false;
	}

	function matchingEventDetails(){
		$sql = "SELECT *  from #__jevents_vevent as vev,#__jevents_vevdetail as det"
		."\n WHERE vev.uid = '".$this->uid."'"
		."\n AND vev.detail_id = det.evdet_id";
		$this->_db->setQuery($sql);
		$matches = $this->_db->loadObjectList();
		if (count($matches)>0 && isset($matches[0]->ev_id)) {
			return $matches[0];
		}
		return false;
	}

	/**
	 * Pseudo Constructor
	 *
	 * @param iCal Event parsed from ICS file as an array $ice
	 * @return n/a
	 */
	function iCalEventFromData($ice){
		$db	=& JFactory::getDBO();
		$temp = new iCalEvent($db);
		$temp->data = $ice;
		if (array_key_exists("RRULE",$temp->data)){
			$temp->rrule =iCalRRule::iCalRRuleFromData($temp->data['RRULE']);
		}
		$temp->convertData();
		$temp->setupEventDetail();
		//		$temp->map_iCal_to_Jevents();
		return $temp;
		//print_r($this->data);
	}

	/**
	 * Pseudo Constructor
	 *
	 * @param iCal Event parsed from ICS file as an array $ice
	 * @return n/a
	 */
	function iCalEventFromDB($icalrowAsArray){
		$db	=& JFactory::getDBO();
		$temp = new iCalEvent($db);
		foreach ($icalrowAsArray as $key=>$val) {
			$temp->$key = $val;
		}
		if ($temp->freq!=""){
			$temp->rrule = iCalRRule::iCalRRuleFromDB($icalrowAsArray);
		}
		$temp->setupEventDetailFromDB($icalrowAsArray);
		return $temp;
	}

	/**
	 * private function
	 *
	 * @param string $field
	 */
	function processField($field,$default,$targetFieldName=""){
		if ($targetFieldName==""){
			$targetfield = str_replace("-","_",$field);
		}
		else {
			$targetfield = $targetFieldName;
		}
		$this->$targetfield = array_key_exists(strtoupper($field),$this->data)?$this->data[strtoupper($field)]:$default;
	}


	/**
	 * Converts $data into class values 
	 *
	 */
	function convertData(){
		$this->processField("uid",0);
		$this->rawdata = serialize($this->data);
		//$this->processField("catid","");

		/* most of this now goes in the eventdetail
		$this->processField("dtstart",0);
		$this->processField("dtstartraw","");
		$this->processField("duration",0);
		$this->processField("durationraw","");
		$this->processField("dtend",0);
		$this->processField("dtendraw","");
		$this->processField("dtstamp","");
		$this->processField("class","");
		$this->processField("categories","");
		$this->processField("description","");
		$this->processField("geolon","");
		$this->processField("geolat","");
		$this->processField("location","");
		$this->processField("priority","");
		$this->processField("status","");
		$this->processField("summary","");
		$this->processField("contact","");
		$this->processField("organizer","");
		$this->processField("url","");
		$this->processField("created","");
		$this->processField("sequence","");
		*/
		$this->processField("recurrence-id","");

		// old events access and published state
		$this->processField("x-access",0, "access");
		$this->processField("x-state",1, "state");
		$user =& JFactory::getUser();
		$this->processField("x-createdby",$user->id, "created_by");
		$this->processField("x-createdbyalias","", "created_by_alias");
		$this->processField("x-modifiedby",$user->id, "modified_by");

		/*

		if (isset($this->rrule)) $this->trueend = $this->rrule->trueEndDate($this->dtend);
		else $this->trueend = $this->dtend;
		*/

		if (array_key_exists("EXDATE",$this->data) && count($this->data["EXDATE"])>0){
			$this->_exdate= $this->data["EXDATE"];
		}
	}


	/**
	 * Create and setup event detail
	 *
	 * @param data array
	 */
	function setupEventDetail() {
		//if ($this->recurrence_id==""){
		$this->_detail = iCalEventDetail::iCalEventDetailFromData($this->data);
		/*
}
else $this->_detail = false;
*/
	}

	function setupEventDetailFromDB($icalrowAsArray) {
		//if ($this->recurrence_id==""){
		$this->_detail = iCalEventDetail::iCalEventDetailFromDB($icalrowAsArray);
		/*
}
else $this->_detail = false;
*/
	}

	function hasRepetition() {
		return isset($this->rrule);
	}

	/**
	 * Generates repetition from vevent & rrule data from scratch
	 * The result can then be saved to the database
	 */
	function getRepetitions($recreate=false) {
		if (!$recreate && isset($this->_repetitions)) return $this->_repetitions;
		$this->_repetitions = array();
		if (!isset($this->ev_id)) {
			echo "no id set in generateRepetitions<br/>";
			return $this->_repetitions;
		}
		// if no rrule then only one instance
		if (!isset($this->rrule)){
			$db	=& JFactory::getDBO();
			$repeat = new iCalRepetition($db);
			$repeat->eventid = $this->ev_id;
			$repeat->startrepeat = strftime('%Y-%m-%d %H:%M:%S',$this->_detail->dtstart);
			$repeat->endrepeat = strftime('%Y-%m-%d %H:%M:%S',$this->_detail->dtend);
			$repeat->duplicatecheck = md5($repeat->eventid . $this->_detail->dtstart);
			$this->_repetitions[] = $repeat;
			return $this->_repetitions;
		}
		else {
			$this->_repetitions = $this->rrule->getRepetitions($this->_detail->dtstart,$this->_detail->dtend,$this->_detail->duration, $recreate,$this->_exdate);
			return $this->_repetitions;
		}
	}

	/**
	 * function that removed cancelled instances from repetitions table
	 *
	 */
	function cancelRepetition() {
		// TODO - rather than deleting the repetition I should save the new detail and report it as cancelled
		// this would make subsequent export easier
		$eventid = $this->ev_id;
		$start = iCalImport::unixTime($this->recurrence_id);

		// TODO CHECK THIS logic - an make it more abstract since a few functions do the same !!!

		// TODO if I implement this outsite of upload I need to clean the detail table too
		$duplicatecheck = md5($eventid . $start);
		$db	=& JFactory::getDBO();
		$sql = "DELETE FROM #__jevents_repetition WHERE duplicatecheck='".$duplicatecheck."'";
		$db->setQuery($sql);
		return $db->query();
	}

	/**
	 * function that adjusts instances in the repetitions table
	 *
	 */
	function adjustRepetition($matchingEvent){
		$eventid = $this->ev_id;
		$start = iCalImport::unixTime($this->recurrence_id);
		$duplicatecheck = md5($eventid . $start );

		// find the existing repetition in order to get the detailid
		$db	=& JFactory::getDBO();
		$sql = "SELECT * FROM #__jevents_repetition WHERE duplicatecheck='$duplicatecheck'";
		$db->setQuery($sql);
		$matchingRepetition=$db->loadObject();
		if (!isset($matchingRepetition)) {
			return false;
		}
		// I now create a new evdetail instance
		$newDetail = iCalEventDetail::iCalEventDetailFromData($this->data);
		if (isset($matchingRepetition) && isset($matchingRepetition->eventdetail_id)){
			// This traps the first time through since the 'global id has not been overwritten
			if ($matchingEvent->detail_id!=$matchingRepetition->eventdetail_id){
				//$newDetail->evdet_id = $matchingRepetition->eventdetail_id;
			}
		}
		if (!$newDetail->store()){
			return false;
		}

		// clumsy - add in the new version with the correct times (does not deal with modified descriptions and sequence)
		$start= strftime('%Y-%m-%d %H:%M:%S',$newDetail->dtstart);
		if ($newDetail->dtend!=0){
			$end = $newDetail->dtend;
		}
		else {
			$end = $start + $newDetail->duration;
		}
		// iCal for whole day uses 00:00:00 on the next day JEvents uses 23:59:59 on the same day
		list ($h,$m,$s) = explode(":",strftime("%H:%M:%S",$end));
		if (($h+$m+$s)==0) {
			$end = strftime('%Y-%m-%d 23:59:59',($end-86400));
		}
		else {
			$end = strftime('%Y-%m-%d %H:%M:%S',$end);
		}

		$duplicatecheck = md5($eventid . $start );
		$db	=& JFactory::getDBO();
		$sql = "UPDATE #__jevents_repetition SET eventdetail_id=".$newDetail->evdet_id
		.", startrepeat='".$start."'"
		.", endrepeat='".$end."'"
		.", duplicatecheck='".$duplicatecheck."'"
		." WHERE rp_id=".$matchingRepetition->rp_id;
		$db->setQuery($sql);
		return $db->query();

	}

	function storeRepetitions() {
		if (!isset($this->_repetitions)) $this->getRepetitions(true);
		if (count($this->_repetitions)==0) return false;
		$db	=& JFactory::getDBO();
		// I must delete the eventdetails for repetitions not matching the global event detail
		// these will be recreated later to match the new adjusted repetitions

		$sql = "SELECT evdet_id FROM #__jevents_vevdetail as detail"
		."\n LEFT JOIN #__jevents_repetition as rpt ON rpt.eventdetail_id=detail.evdet_id"
		."\n WHERE eventid=".$this->ev_id
		."\n AND rpt.eventdetail_id != ".$this->_detail->evdet_id;
		$db->setQuery($sql);
		$ids = $db->loadResultArray();
		if (count($ids)>0){
			$idlist = implode(",",$ids);
			$sql = "DELETE FROM #__jevents_vevdetail  WHERE evdet_id IN(".$idlist.")";
			$db->setQuery($sql);
			$db->query();

			// I also need to clean out associated custom data
			$dispatcher	=& JDispatcher::getInstance();
			// just incase we don't have jevents plugins registered yet
			JPluginHelper::importPlugin("jevents");
			$res = $dispatcher->trigger( 'onDeleteEventDetails' , array($idlist));

		}

		// attempt to find repetitions that match so I can replace them
		$sql = "select * FROM #__jevents_repetition  WHERE eventid=".$this->ev_id. " ORDER BY startrepeat ASC";
		$db->setQuery($sql);
		$oldrepeats = $db->loadObjectList();
		foreach ($oldrepeats as &$oldrepeat) {
			// find matching day
			$oldrepeat->startday = substr($oldrepeat->startrepeat,0,10);
			// free the reference
			unset($oldrepeat);
		}

		// First I delete all existing repetitions - I can't do an update or replace
		// since the repeat may have been= adjusted
		$sql = "DELETE FROM #__jevents_repetition  WHERE eventid=".$this->ev_id." ORDER BY startrepeat ASC";
		$db->setQuery($sql);
		$db->query();

		/*
		SELECT * FROM #__jevents_vevdetail as detail ,#__jevents_repetition as rpt, #__jevents_vevent as event
		WHERE eventid=1
		AND rpt.eventdetail_id=detail.evdet_id
		AND rpt.eventid = event.ev_id
		AND rpt.eventdetail_id != detail.evdet_id
		*/

		// Now attempt to replace repetitions using the old repeat ids
		for ($r = 0;$r<count($this->_repetitions);$r++){
			$repeat =& $this->_repetitions[$r];
			// find matching day and only one!!
			$repeat->startday = substr($repeat->startrepeat,0,10);
			$matched = false;
			foreach ($oldrepeats as $oldrepeat) {
				if ($oldrepeat->startday == $repeat->startday){
					$matched = true;
					$repeat->old_rpid = $oldrepeat->rp_id;
					break;
				}
				if ($oldrepeat->startday > $repeat->startday){
					break;
				}
			}
			if (!$matched) $repeat->old_rpid = 0;
			// free the reference
			unset($repeat);
		}



		$sql = "REPLACE INTO #__jevents_repetition (rp_id,eventid,eventdetail_id,startrepeat,endrepeat,duplicatecheck) VALUES ";
		for ($r = 0;$r<count($this->_repetitions);$r++){
			$repeat = $this->_repetitions[$r];
			if (!isset($repeat->duplicatecheck)){
				echo "fred";
			}
			// for now use the 'global' detail id - I really should override this
			$sql .= "\n ($repeat->old_rpid, $repeat->eventid,".$this->detail_id.",'".$repeat->startrepeat."','".$repeat->endrepeat."','".$repeat->duplicatecheck."')";
			if ($r+1 < count($this->_repetitions)) $sql .= ",";
		}
		$db->setQuery($sql);
		return $db->query();
	}

	function eventOnDate($testDate){
		if (!isset($this->_start)){
			$this->_start = mktime(0,0,0,$this->mup,$this->dup,$this->yup);
			$this->_end = mktime(0,0,0,$this->mup,$this->dup,$this->yup);
		}
		if (!isset($this->rrule)){
			if ($this->_start<=$testDate && $this->_end>=$testDate){
				return true;
			}
			else return false;
		}
		else {
			if (isset($this->rrule)) {
				//				if ($testDate>$this->trueend) return false;
				return $this->rrule->checkDate($testDate, $this->_start,$this->_end);
			}
		}
		return false;

	}

	function eventInPeriod($startDate,$endDate){
		if (!isset($this->_start)){
			$this->_start = mktime(0,0,0,$this->mup,$this->dup,$this->yup);
			$this->_end = mktime(0,0,0,$this->mdn,$this->ddn,$this->ydn);
		}
		if (!isset($this->rrule)){
			if ($this->_start<=$endDate && $this->_end>=$startDate){
				return true;
			}
			else return false;
		}
		else {
			if (isset($this->rrule)) {
				return $this->rrule->eventInPeriod($startDate,$endDate, $this->_start,$this->_end);
			}
		}
		return false;

	}

	function isCancelled() {
		if ($this->_detail){
			return $this->_detail->isCancelled();
		}
		return false;
	}

	function isRecurrence() {
		return $this->recurrence_id!="";
	}

	/**
	 * Utility function since DTEND really only tells me the end time in repeated events
	 *
	 */
	/*
	function getEndDate(){
	if (isset($this->rrule)) {
	return $this->rrule->getEndDate($this->dtstart,$this->dtend);
	}
	else return $this->dtend;
	}
	*/

	function dumpData(){
		echo "starting : ".$this->dtstart."<br/>";
		echo "ending : ".$this->dtend."<br/>";
		if (isset($this->rrule)){
			$this->rrule->dumpData();
		}
		print_r($this->data);
		echo "<hr/>";
	}
}
