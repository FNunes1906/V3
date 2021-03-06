<?php
/**
 * JEvents Component for Joomla 1.5.x
 *
 * @version     $Id: jicaleventrepeat.php 1631 2009-11-26 05:38:33Z geraint $
 * @package     JEvents
 * @copyright   Copyright (C) 2008-2009 GWE Systems Ltd, 2006-2008 JEvents Project Group
 * @license     GNU/GPLv2, see http://www.gnu.org/licenses/gpl-2.0.html
 * @link        http://www.jevents.net
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

class jIcalEventRepeat extends jIcalEventDB{

	private $_nextRepeat=null;
	private $_prevRepeat=null;

	function id() {
		if (!isset($this->_rp_id)) return parent::id();
		return $this->_rp_id;
	}

	function rp_id() {
		return $this->_rp_id;
	}

	function ev_id() {
		return parent::id();
	}

	function checkRepeatMonth($cellDate, $year, $month){
		// builds and returns array
		if (!isset($this->eventDaysMonth)){
			$this->eventDaysMonth = array();
		}

		if (!array_key_exists($cellDate,$this->eventDaysMonth)){
			if ($this->eventOnDate($cellDate)) {
				$this->eventDaysMonth[$cellDate]=true;
			}
			/*
			// I don't need to do this since eventOnDate checks the multiday condition
			if ($this->eventOnDate($cellDate) && ($this->_multiday || !isset($this->_alreadyShown) || !$this->_alreadyShown)) {
			$this->eventDaysMonth[$cellDate]=true;
			$this->_alreadyShown = true;
			}
			*/
			else {
				$this->eventDaysMonth[$cellDate]=false;
			}
		}

		return $this->eventDaysMonth[$cellDate];
	}

	function eventOnDate($testDate){
		if (!isset($this->_startday)){
			$this->_startday = mktime(0,0,0,$this->mup(),$this->dup(),$this->yup());
			$this->_endday = mktime(0,0,0,$this->mdn(),$this->ddn(),$this->ydn());
			// if ends on midnight then testing day should ignore the second day since no one wants this event to show
			if ($this->hdn()+$this->mindn()+$this->sdn() ==0){
				$this->_endday -= 86400;
			}
		}
		if ($this->_startday<=$testDate && $this->_endday>=$testDate){
			// don't show multiday suppressed events after the first day if multiday is not true
			if (!$this->_multiday && $testDate>=($this->_startday+86400)){
				return false;
			}
			return true;
		}
		else return false;
	}

	function isEditable(){
		return true;
	}

	function hasrepetition(){
		#if (isset($this->_rr_id)  && $this->_rr_id>0 ) return true;
		if (isset($this->_freq) && ($this->_freq != 'none')) return true;
		else return false;
	}

	function editTask(){
		// TODO add methods for editing specific repeats
		return "icalrepeat.edit";
	}

	function detailTask(){
		// TODO add methods for editing specific repeats
		return "icalrepeat.detail";
	}

	function editLink($sef=false) {
		$Itemid	= JEVHelper::getItemid();
		// rp_id is added for return via cancel only
		// I pass in the rp_id so that I can return to the repeat I was viewing before editing
		// I need $year,$month,$day So that I can return to an appropriate date after saving an event (the repetition ids have all changed so I can't go back there!!)
		list($year,$month,$day) = JEVHelper::getYMD();
		$link =  "index.php?option=".JEV_COM_COMPONENT."&task=".parent::editTask().'&evid='. parent::id().'&Itemid='.$Itemid .'&rp_id='.$this->rp_id()."&year=$year&month=$month&day=$day";
		//$link = $sef?JRoute::_( $link ,true ):$link;
		$link = JRoute::_( $link ,true );
		return $link;
	}

	function editCopyLink($sef=false) {
		$Itemid	= JEVHelper::getItemid();
		// rp_id is added for return via cancel only
		// I pass in the rp_id so that I can return to the repeat I was viewing before editing
		// I need $year,$month,$day So that I can return to an appropriate date after saving an event (the repetition ids have all changed so I can't go back there!!)
		list($year,$month,$day) = JEVHelper::getYMD();
		$link =  "index.php?option=".JEV_COM_COMPONENT."&task=".parent::editCopyTask().'&evid='. parent::id().'&Itemid='.$Itemid .'&rp_id='.$this->rp_id()."&year=$year&month=$month&day=$day";
		//$link = $sef?JRoute::_( $link ,true ):$link;
		$link = JRoute::_( $link ,true );
		return $link;
	}

	function editRepeatLink($sef=false) {
		$Itemid	= JEVHelper::getItemid();
		list($year,$month,$day) = JEVHelper::getYMD();
		$link =  "index.php?option=".JEV_COM_COMPONENT."&task=".$this->editTask().'&evid='. $this->id().'&Itemid='.$Itemid
		."&year=$year&month=$month&day=$day";
		//$link = $sef?JRoute::_( $link ,true ):$link;
		$link = JRoute::_( $link ,true );
		return $link;
	}

	function deleteLink($sef=false) {
		$Itemid	= JEVHelper::getItemid();
		// I need $year,$month,$day So that I can return to an appropriate date after deleting a repetition!!!
		list($year,$month,$day) = JEVHelper::getYMD();
		$link =  "index.php?option=".JEV_COM_COMPONENT."&task=".parent::deleteTask().'&evid='. parent::id().'&Itemid='.$Itemid."&year=$year&month=$month&day=$day" ;
		//$link = $sef?JRoute::_( $link ,true ):$link;
		$link = JRoute::_( $link ,true );
		return $link;
	}

	function deleteRepeatLink($sef=false ){
		$Itemid	= JEVHelper::getItemid();
		// I need $year,$month,$day So that I can return to an appropriate date after deleting a repetition!!!
		list($year,$month,$day) = JEVHelper::getYMD();
		$link ="index.php?option=".JEV_COM_COMPONENT."&task=".$this->deleteTask().'&cid='. $this->id().'&Itemid='.$Itemid."&year=$year&month=$month&day=$day" ;
		//$link = $sef?JRoute::_( $link ,true ):$link;
		$link = JRoute::_( $link ,true );
		return $link;
	}

	function deleteFutureLink($sef=false ){
		$Itemid	= JEVHelper::getItemid();
		// I need $year,$month,$day So that I can return to an appropriate date after deleting a repetition!!!
		list($year,$month,$day) = JEVHelper::getYMD();
		$link ="index.php?option=".JEV_COM_COMPONENT."&task=".$this->deleteFutureTask().'&cid='. $this->id().'&Itemid='.$Itemid."&year=$year&month=$month&day=$day" ;
		//$link = $sef?JRoute::_( $link ,true ):$link;
		$link = JRoute::_( $link ,true );
		return $link;
	}

	function viewDetailLink($year,$month,$day,$sef=true, $Itemid=0){
		$Itemid	= $Itemid>0?$Itemid:JEVHelper::getItemid();
		// uid = event series unique id i.e. the actual event
		$title = JFilterOutput::stringURLSafe($this->title());
		$link = "index.php?option=".JEV_COM_COMPONENT."&task=".$this->detailTask()."&evid=".$this->rp_id() .'&Itemid='.$Itemid
		."&year=$year&month=$month&day=$day&title=".$title."&uid=".urlencode($this->uid());
		// SEF is applied later
		$link = $sef?JRoute::_( $link ,true ):$link;
		return $link;

	}

	function deleteTask(){
		return "icalrepeat.delete";
	}

	function deleteFutureTask(){
		return "icalrepeat.deletefuture";
	}

	function checkRepeatWeek($this_currentdate,$week_start,$week_end) {
		//TODO fix this
		//if ($this->vevent->eventOnDate($this_currentdate)) return true;
		if ($this->eventOnDate($this_currentdate) && ($this->_multiday || !isset($this->_alreadyShown) || !$this->_alreadyShown)) {
			$this->_alreadyShown = true;
			return true;
		}
		return false;
	}

	function checkRepeatDay($this_currentdate){
		//if ($this->vevent->eventOnDate($this_currentdate)) return true;
		if ($this->eventOnDate($this_currentdate)) return true;
		return false;
	}

	function repeatSummary() {
		$result = parent::repeatSummary();
		if ($this->_eventdetail_id!=$this->_detail_id){
			$result .= "<div class='ev_repeatexception'>".JText::_('JEV_REPEATEXCEPTION')."</div>";
		}

		//$result .= "<div style='font-weight:bold;color:black;background-color:yellow'>Repeat Summary needs more work still!</div>";
		return $result;
	}

	function previousnextLinks(){
		$cfg = & JEVConfig::getInstance();
		$result = parent::previousnextLinks();
		if ($this->prevRepeat() || $this->nextRepeat()){
			if ($this->prevRepeat()){
				$result .= "<div class='ev_prevrepeat'>";
				$result .= "<a href='".$this->prevRepeat()."' title='".JText::_('JEV_PREVIOUSREPEAT')."' class='".$cfg->get('com_navbarcolor')."'>".JText::_('JEV_PREVIOUSREPEAT')."</a>";
				$result .= "</div>";
			}
			if ($this->nextRepeat()){
				$result .= "<div class='ev_nextrepeat'>";
				$result .= "<a href='".$this->nextRepeat()."' title='".JText::_('JEV_NEXTREPEAT')."' class='".$cfg->get('com_navbarcolor')."'>".JText::_('JEV_NEXTREPEAT')."</a>";
				$result .= "</div>";
			}
		}
		return $result;
	}

	function previousLink(){
		$cfg = & JEVConfig::getInstance();
		$result = parent::previousnextLinks();
		if ($this->prevRepeat()){
			$result .= "<div class='ev_prevrepeat'>";
			$result .= "<a href='".$this->prevRepeat()."' title='".JText::_('JEV_PREVIOUSREPEAT')."' class='".$cfg->get('com_navbarcolor')."'>".JText::_('JEV_PREVIOUSREPEAT')."</a>";
			$result .= "</div>";
		}
		return $result;
	}

	function nextLink(){
		$cfg = & JEVConfig::getInstance();
		$result = parent::previousnextLinks();
		if ($this->nextRepeat()){
			$result .= "<div class='ev_nextrepeat'>";
			$result .= "<a href='".$this->nextRepeat()."' title='".JText::_('JEV_NEXTREPEAT')."' class='".$cfg->get('com_navbarcolor')."'>".JText::_('JEV_NEXTREPEAT')."</a>";
			$result .= "</div>";
		}
		return $result;
	}

	function prevRepeat(){
		if (is_null($this->_prevRepeat)){
			$this->getAdjacentRepeats();
		}
		return $this->_prevRepeat;
	}

	function nextRepeat(){
		if (is_null($this->_nextRepeat)){
			$this->getAdjacentRepeats();
		}
		return $this->_nextRepeat;
	}

	private function getAdjacentRepeats(){

		$Itemid	= JEVHelper::getItemid();
		list($year,$month,$day) = JEVHelper::getYMD();

		$db	=& JFactory::getDBO();

		$sql = "SELECT *,YEAR(startrepeat) as yup, MONTH(startrepeat ) as mup, DAYOFMONTH(startrepeat ) as dup FROM #__jevents_repetition WHERE eventid=".$this->ev_id()." AND startrepeat<'".$this->_startrepeat."' ORDER BY startrepeat DESC limit 1";
		$db->setQuery($sql);
		$prior = $db->loadObject();
		if (!is_null($prior)) {
			$link = "index.php?option=".JEV_COM_COMPONENT."&task=".$this->detailTask()."&evid=".$prior->rp_id .'&Itemid='.$Itemid
			."&year=$prior->yup&month=$prior->mup&day=$prior->dup&uid=".urlencode($this->uid());
			$link = JRoute::_( $link  );
			$this->_prevRepeat = $link;
		}
		else {
			$this->_prevRepeat = false;
		}

		$sql = "SELECT *,YEAR(startrepeat) as yup, MONTH(startrepeat ) as mup, DAYOFMONTH(startrepeat ) as dup FROM #__jevents_repetition WHERE eventid=".$this->ev_id()." AND startrepeat>'".$this->_startrepeat."' ORDER BY startrepeat ASC limit 1";
		$db->setQuery($sql);
		$post = $db->loadObject();
		if (!is_null($post)) {
			$link = "index.php?option=".JEV_COM_COMPONENT."&task=".$this->detailTask()."&evid=".$post->rp_id .'&Itemid='.$Itemid
			."&year=$post->yup&month=$post->mup&day=$post->dup&uid=".urlencode($this->uid());
			$link = JRoute::_( $link  );
			$this->_nextRepeat = $link;
		}
		else {
			$this->_nextRepeat = false;
		}

	}

}
