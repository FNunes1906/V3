<?php
/**
 * JEvents Component for Joomla 1.5.x
 *
 * @version     $Id: icalevent.php 1868 2010-12-17 11:51:10Z geraint $
 * @package     JEvents
 * @copyright   Copyright (C) 2008-2009 GWE Systems Ltd, 2006-2008 JEvents Project Group
 * @license     GNU/GPLv2, see http://www.gnu.org/licenses/gpl-2.0.html
 * @link        http://www.jevents.net
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');


class AdminIcaleventController extends JController {

	var $_debug = false;
	var $queryModel = null;
	var $dataModel = null;

	var $editCopy = false;
	var $_largetDataSet = false;

	/**
	 * Controler for the Ical Functions
	 * @param array		configuration
	 */
	function __construct($config = array())
	{
		parent::__construct($config);
		$this->registerTask( 'list',  'overview' );
		$this->registerDefaultTask("overview");

		$cfg = & JEVConfig::getInstance();
		$this->_debug = $cfg->get('jev_debug', 0);

		$this->dataModel = new JEventsDataModel("JEventsAdminDBModel");
		$this->queryModel = new JEventsDBModel($this->dataModel);
	}

	/**
	 * List Ical Events
	 *
	 */
	function overview( )
	{
		// get the view
		$this->view = & $this->getView("icalevent","html");

		$this->_checkValidCategories();

		$showUnpublishedICS = true;
		$showUnpublishedCategories = true;

		global  $mainframe;

		$db	=& JFactory::getDBO();

		$icsFile	= intval( $mainframe->getUserStateFromRequest("icsFile","icsFile", 0 ));

		$catid		= intval( $mainframe->getUserStateFromRequest( "catidIcalEvents", 'catid', 0 ));
		$catidtop	= $catid;

		$state		= intval( $mainframe->getUserStateFromRequest( "stateIcalEvents", 'state', 0 ));

		$limit		= intval( $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', 10 ));
		$limitstart = intval( $mainframe->getUserStateFromRequest( "view{".JEV_COM_COMPONENT."}limitstart", 'limitstart', 0 ));
		$search		= $mainframe->getUserStateFromRequest( "search{".JEV_COM_COMPONENT."}", 'search', '' );
		$search		= $db->getEscaped( trim( strtolower( $search ) ) );

		$created_by	= $mainframe->getUserStateFromRequest( "createdbyIcalEvents", 'created_by', 0 );

		// Is this a large dataset ?
		$query = "SELECT count(rpt.rp_id) from #__jevents_repetition as rpt ";
		$db->setQuery( $query);
		$totalrepeats = $db->loadResult();
		$this->_largeDataSet = 0;
		$cfg = & JEVConfig::getInstance();
		if ($totalrepeats>$cfg->get('largeDataSetLimit', 100000 )){
			$this->_largeDataSet = 1;
		}
		$cfg = & JEVConfig::getInstance();
		$cfg->set('largeDataSet',$this->_largeDataSet  );

		$where = array();
		$join = array();

		if( $search ){
			$where[] = "LOWER(detail.summary) LIKE '%$search%'";
		}

		if( $catid > 0 ){
			$where[] = "ev.catid='$catid'";
		}

		if ($created_by==="") {
			$where[] = "ev.created_by=0";
		}
		else {
			$created_by = intval($created_by );
			if ($created_by>0)	$where[] = "ev.created_by=".$db->Quote($created_by);
		}

		if ($icsFile>0) {
			$join[] = " #__jevents_icsfile as icsf ON icsf.ics_id = ev.icsid";
			$where[] = "\n icsf.ics_id = $icsFile";
			if (!$showUnpublishedICS){
				$where[] = "\n icsf.state=1";
			}
		}
		else {
			if (!$showUnpublishedICS){
				$join[] = " #__jevents_icsfile as icsf ON icsf.ics_id = ev.icsid";
				$where[] = "\n icsf.state=1";
			}
			else {
				$icsFrom = "";
			}
		}

		$hidepast = intval( $mainframe->getUserStateFromRequest("hidepast","hidepast", 1 ));
		if ($hidepast){
			$datenow =& JFactory::getDate("-1 day");
			if (!$this->_largeDataSet){
				$where[] = "\n rpt.endrepeat>'".$datenow->toMysql()."'";
			}
		}
		if ($state==1){
			$where[] = "\n ev.state=1";
		}
		else if ($state==2){
			$where[] = "\n ev.state=0";
		}

		// get the total number of records
		$query = "SELECT count(distinct rpt.eventid)"
		. "\n FROM #__jevents_vevent AS ev "
		. "\n LEFT JOIN #__jevents_vevdetail as detail ON ev.detail_id=detail.evdet_id"
		. "\n LEFT JOIN #__jevents_rrule as rr ON rr.eventid = ev.ev_id"
		. "\n LEFT JOIN #__jevents_repetition as rpt ON rpt.eventid = ev.ev_id"
		. "\n LEFT JOIN #__groups AS g ON g.id = ev.access"
		. ( count( $join) ? "\n LEFT JOIN  " . implode( ' LEFT JOIN ', $join) : '' )
		. ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : '' );
		$db->setQuery( $query);
		//echo $db->_sql;
		$total = $db->loadResult();
		echo $db->getErrorMsg();
		if( $limit > $total ) {
			$limitstart = 0;
		}

		// if anon user plugin enabled then include this information
		$anonfields = "";
		$anonjoin = "";
		if (JPluginHelper::importPlugin("jevents", "jevanonuser")){

			$anonfields = ", ac.name as anonname, ac.email as anonemail";
			$anonjoin = "\n LEFT JOIN #__jev_anoncreator as ac on ac.ev_id = ev.ev_id";
		}

		$query = "SELECT ev.*, ev.state as evstate, detail.*, g.name AS _groupname ".$anonfields
		. "\n , rr.rr_id, rr.freq,rr.rinterval"//,rr.until,rr.untilraw,rr.count,rr.bysecond,rr.byminute,rr.byhour,rr.byday,rr.bymonthday"
		. ($this->_largeDataSet?"":"\n ,MAX(rpt.endrepeat) as endrepeat ,MIN(rpt.startrepeat) as startrepeat"
		. "\n , YEAR(rpt.startrepeat) as yup, MONTH(rpt.startrepeat ) as mup, DAYOFMONTH(rpt.startrepeat ) as dup"
		. "\n , YEAR(rpt.endrepeat  ) as ydn, MONTH(rpt.endrepeat   ) as mdn, DAYOFMONTH(rpt.endrepeat   ) as ddn"
		. "\n , HOUR(rpt.startrepeat) as hup, MINUTE(rpt.startrepeat ) as minup, SECOND(rpt.startrepeat ) as sup"
		. "\n , HOUR(rpt.endrepeat  ) as hdn, MINUTE(rpt.endrepeat   ) as mindn, SECOND(rpt.endrepeat   ) as sdn")
		. "\n FROM #__jevents_vevent as ev "
		. ($this->_largeDataSet?"":"\n LEFT JOIN #__jevents_repetition as rpt ON rpt.eventid = ev.ev_id")
		. $anonjoin
		. "\n LEFT JOIN #__jevents_vevdetail as detail ON ev.detail_id=detail.evdet_id"
		. "\n LEFT JOIN #__jevents_rrule as rr ON rr.eventid = ev.ev_id"
		. "\n LEFT JOIN #__groups AS g ON g.id = ev.access"
		. ( count( $join) ? "\n LEFT JOIN  " . implode( ' LEFT JOIN ', $join) : '' )
		. ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : '' )
		//. "\n WHERE ev.catid IN(".$this->queryModel->accessibleCategoryList().")"
		. ($this->_largeDataSet?"\n ORDER BY detail.dtstart ASC": "\n GROUP BY  ev.ev_id ORDER BY rpt.startrepeat ASC")
		;

		if ($limit>0){
			$query .= "\n LIMIT $limitstart, $limit";
		}
		$db->setQuery( $query );

		//echo $db->explain();
		$rows = $db->loadObjectList();
		foreach ($rows as $key=>$val) {
			// set state variable to the event value not the event detail value
			$rows[$key]->state = $rows[$key]->evstate;
			$groupname = $rows[$key]->_groupname;
			$rows[$key]=new jIcalEventRepeat($rows[$key]);
			$rows[$key]->_groupname = $groupname;
		}
		if( $this->_debug ){
			echo '[DEBUG]<br />';
			echo 'query:';
			echo '<pre>';
			echo $query;
			echo '-----------<br />';
			echo 'option "' . JEV_COM_COMPONENT . '"<br />';
			echo '</pre>';
			//die( 'userbreak - mic ' );
		}

		if ($db->getErrorNum()) {
			echo $db->stderr();
			return false;
		}

		// get list of categories
		$attribs = 'class="inputbox" size="1" onchange="document.adminForm.submit();"';
		$clist = JEventsHTML::buildCategorySelect( $catid, $attribs, null, $showUnpublishedCategories, false, $catidtop,"catid");

		// get list of ics Files
		$icsfiles = array();
		//$icsfiles[] =  JHTML::_('select.option', '0', "Choose ICS FILE" );
		$icsfiles[] = JHTML::_('select.option', '-1', JText::_("ALL ICS FILES"));

		$query = "SELECT ics.ics_id as value, ics.label as text FROM #__jevents_icsfile as ics ";
		if (!$showUnpublishedICS){
			$query .= " WHERE ics.state=1";
		}
		$query .= " ORDER BY ics.isdefault DESC, ics.label ASC";

		$db->setQuery( $query );
		$result = $db->loadObjectList() ;

		$icsfiles = array_merge( $icsfiles, $result);
		$icslist = JHTML::_('select.genericlist', $icsfiles, 'icsFile', 'class="inputbox" size="1" onchange="document.adminForm.submit();"', 'value', 'text', $icsFile );

		// get list of creators
		$sql = "SELECT distinct u.id, u.* FROM #__jevents_vevent as jev LEFT JOIN #__users as u on u.id=jev.created_by";
		$db=& JFactory::getDBO();
		$db->setQuery( $sql );
		$users = $db->loadObjectList();
		$userOptions = array();
		$userOptions[] = JHTML::_('select.option', 0, JText::_("JEV_EVENT_CREATOR") );
		foreach( $users as $user )
		{
			$userOptions[] = JHTML::_('select.option', $user->id, $user->name. " ($user->username)" );
		}
		$userlist = JHTML::_('select.genericlist', $userOptions, 'created_by', 'class="inputbox" size="1"  onchange="document.adminForm.submit();"', 'value', 'text', $created_by);

		$options[] = JHTML::_('select.option', '0', JText::_('No'));
		$options[] = JHTML::_('select.option', '1', JText::_('Yes'));
		$plist = JHTML::_('select.genericlist', $options, 'hidepast', 'class="inputbox" size="1" onchange="document.adminForm.submit();"', 'value', 'text', $hidepast );

		$options = array();
		$options[] = JHTML::_('select.option', '0', JText::_('All Events'));
		$options[] = JHTML::_('select.option', '1', JText::_('Published'));
		$options[] = JHTML::_('select.option', '2', JText::_('Unpublished'));
		$statelist = JHTML::_('select.genericlist', $options, 'state', 'class="inputbox" size="1" onchange="document.adminForm.submit();"', 'value', 'text', $state );

		$catData = JEV_CommonFunctions::getCategoryData();

		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit  );


		// Set the layout
		$this->view->setLayout('overview');

		$this->view->assign('rows',$rows);
		$this->view->assign('userlist',$userlist);
		$this->view->assign('clist',$clist);
		$this->view->assign('plist',$plist);
		$this->view->assign('statelist',$statelist);
		$this->view->assign('search',$search);
		$this->view->assign('icsList',$icslist);
		$this->view->assign('pageNav',$pageNav);

		$this->view->display();
	}

	function editcopy(){
		// Must be at least an event creator to edit or create events
		$is_event_editor = JEVHelper::isEventCreator();
		if (!$is_event_editor){
			JError::raiseError( 403, JText::_("ALERTNOTAUTH") );
		}
		$this->editCopy = true;
		$this->edit();
	}

	function edit () {
		// get the view
		$this->view = & $this->getView("icalevent","html");

		$cid = JRequest::getVar(	'cid',	array(0) );
		JArrayHelper::toInteger($cid);
		if (is_array($cid) && count($cid)>0) $id=$cid[0];
		else $id=0;

		// front end passes the id as evid
		if ($id==0){
			$id = JRequest::getInt("evid",0);
		}

		if (!JEVHelper::isEventCreator()){
			JError::raiseError( 403, JText::_("ALERTNOTAUTH") );
		}

		$repeatId = 0;

		$db= JFactory::getDBO();

		// iCal agid uses GUID or UUID as identifier
		if ($id>0){
			if ($repeatId==0) {
				// this version gives us a repeat not an event so
				//$row = $this->queryModel->getEventById($id, true, "icaldb");
				$vevent = $this->dataModel->queryModel->getVEventById( $id);
				if (!$vevent){
					global $Itemid;
					JFactory::getApplication()->redirect(JRoute::_("index.php?option=".JEV_COM_COMPONENT."&Itemid=$Itemid",false), JText::_("JEV SORRY UPDATED"));
				}

				$row = new jIcalEventDB($vevent);

				$row->fixDtstart();

			}
			else {
				$row = $this->queryModel->listEventsById($repeatId, true, "icaldb");
			}

			if (!JEVHelper::canEditEvent($row)){
				JError::raiseError( 403, JText::_("ALERTNOTAUTH") );
			}
		}
		else {
			$vevent = new iCalEvent($db);
			$vevent->set("freq","DAILY");
			$vevent->set("description","");
			$vevent->set("summary","");
			list($year,$month,$day) = JEVHelper::getYMD();

			$params = JComponentHelper::getParams(JEV_COM_COMPONENT);
			$defaultstarttime = $params->get("defaultstarttime","08:00");
			$defaultendtime = $params->get("defaultendtime","17:00");
			list($starthour,$startmin) = explode(":",$defaultstarttime);
			list($endhour,$endmin) = explode(":",$defaultendtime);

			$vevent->set("dtstart",mktime($starthour,$startmin,0,$month,$day,$year));
			$vevent->set("dtend",mktime($endhour,$endmin,0,$month,$day,$year));
			$row = new jIcalEventDB($vevent);

			// TODO - move this to class!!
			// populate with meaningful initial values
			$row->starttime($defaultstarttime);
			$row->endtime($defaultendtime);

		}

		$db =& JFactory::getDBO();
		// get list of groups
		$user = JFactory::getUser();
		$query = "SELECT id AS value, name AS text"
		. "\n FROM #__groups"
		. "\n WHERE id <= ".$user->aid
		. "\n ORDER BY id"	;
		$db->setQuery( $query );
		$groups = $db->loadObjectList();

		// build the html select list
		$glist = JHTML::_('select.genericlist', $groups, 'access', 'class="inputbox" size="1"',
		'value', 'text', intval( $row->access() ) );

		// get all the raw native calendars
		$nativeCals = $this->dataModel->queryModel->getNativeIcalendars();

		// Strip this list down based on user permissions
		$jevuser =& JEVHelper::getAuthorisedUser();
		if ($jevuser && $jevuser->calendars!="" && $jevuser->calendars!="all"){
			$cals = array_keys($nativeCals);
			$allowedcals = explode("|",$jevuser->calendars);
			foreach ( $cals as $calid) {
				if (!in_array($calid,$allowedcals)) unset($nativeCals[$calid]);
			}
		}

		// Are we allowed to edit events within a URL based iCal
		$params = JComponentHelper::getParams(JEV_COM_COMPONENT);
		if ($params->get("allowedit",0) && $row->icsid()>0){
			$calsql = 'SELECT * FROM #__jevents_icsfile WHERE ics_id='.intval($row->icsid());
			$db->setQuery( $calsql );
			$cal = $db->loadObject();
			if ($cal && $cal->icaltype==0) {
				$nativeCals[$cal->ics_id]=$cal;
				$this->view->assign("offerlock",1);
			}

		}

		$excats = "0";
		if ($jevuser && $jevuser->categories!="" && $jevuser->categories!="all"){
			// Find which categories to exclude
			$catsql = 'SELECT id  FROM #__categories WHERE id NOT IN ('.str_replace("|",",",$jevuser->categories).') AND section="com_jevents"';
			$db->setQuery( $catsql );
			$excats = implode(",",$db->loadResultArray());
		}


		// only offer a choice of native calendars if it exists!
		if (count($nativeCals)>1){
			$icalList = array();
			$icalList[] = JHTML::_('select.option', '0', JText::_('JEV_EVENT_CHOOSE_ICAL'), 'ics_id', 'label' );
			$icalList = array_merge( $icalList, $nativeCals );
			$clist = JHTML::_('select.genericlist', $icalList, 'ics_id', " onchange='preselectCategory(this);'", 'ics_id', 'label', $row->icsid() );
			$this->view->assign('clistChoice',true);
			$this->view->assign('defaultCat',0);
		}
		else {
			if (count($nativeCals)==0 || !is_array($nativeCals)){
				JError::raiseWarning(870, JText::_("INVALID CALENDAR STRUCTURE") );
			}

			$icsid = $row->icsid()>0?$row->icsid():current($nativeCals)->ics_id;

			$clist = '<input type="hidden" name="ics_id" value="'.$icsid.'" />';
			$this->view->assign('clistChoice',false);
			$params = JComponentHelper::getParams(JEV_COM_COMPONENT);
			if ($params->get("defaultcat",false)){
				$this->view->assign('defaultCat',current($nativeCals)->catid);
			}
			else {
				$this->view->assign('defaultCat',0);
			}
		}

		// Set the layout
		$this->view->setLayout('edit');

		$this->view->assign('editCopy',$this->editCopy);
		$this->view->assign('id',$id);
		$this->view->assign('row',$row);
		$this->view->assign('excats',$excats);
		$this->view->assign('nativeCals',$nativeCals);
		$this->view->assign('clist',$clist);
		$this->view->assign('repeatId',$repeatId);
		$this->view->assign('glist',$glist);
		// only those who can publish globally can set priority field
		if (JEVHelper::isEventPublisher(true)){
			$list = array();
			for ($i=0;$i<10;$i++)	{
				$list[] = JHTML::_('select.option', $i, $i, 'val', 'text' );
			}
			$priorities = JHTML::_('select.genericlist', $list, 'priority', "", 'val', 'text', $row->priority() );
			$this->view->assign('setPriority',true);
			$this->view->assign('priority',$priorities);
		}
		else {
			$this->view->assign('setPriority',false);
		}
		$this->view->assignRef('dataModel',$this->dataModel);

		// for Admin interface only
		global $mainframe;
		$this->view->assign('with_unpublished_cat',$mainframe->isAdmin());

		$this->view->display();

	}

	function save(){

		$msg="";
		$event = $this->doSave($msg);

		global $mainframe;
		if ($mainframe->isAdmin()){
			$this->setRedirect( 'index.php?option=' . JEV_COM_COMPONENT. '&task=icalevent.list',$msg);
		}
		else {
			global $Itemid;
			list($year,$month,$day) = JEVHelper::getYMD();

			$params = JComponentHelper::getParams(JEV_COM_COMPONENT);
			if ($params->get("editpopup",0)) {
				ob_end_clean();
				if (!headers_sent()){
					header('Content-Type:text/html;charset=utf-8');
				}
				?>
				<script type="text/javascript">				
				window.parent.SqueezeBox.close();
				window.parent.alert("<?php echo $msg;?>");
				window.parent.location="<?php echo JRoute::_('index.php?option=' . JEV_COM_COMPONENT. "&task=day.listevents&year=$year&month=$month&day=$day&Itemid=$Itemid",false);?>";
				</script>
				<?php
				exit();
			}

			// if the event is published then return to the event
			if ($event && $event->state() ){
				list($year,$month,$day) = JEVHelper::getYMD();
				$this->setRedirect($event->viewDetailLink($year,$month,$day,$sef,$itemid) ,$msg);
			}
			else {
				// I can't go back to the same repetition since its id has been lost
				$this->setRedirect( JRoute::_('index.php?option=' . JEV_COM_COMPONENT. "&task=day.listevents&year=$year&month=$month&day=$day&Itemid=$Itemid",false),$msg);
			}
		}
	}

	function apply() {

		$msg="";
		$event = $this->doSave($msg);

		// reload the event to get the reptition ids
		$evid = intval($event->ev_id());
		$testevent = $this->queryModel->getEventById( $evid, 1, "icaldb" );
		$rp_id = $testevent->rp_id();

		global $mainframe;
		if ($mainframe->isAdmin()){
			$this->setRedirect( 'index.php?option=' . JEV_COM_COMPONENT. "&task=icalevent.edit&evid=$evid&rp_id=$rp_id&year=$year&month=$month&day=$day&Itemid=$Itemid",$msg);
		}
		else {
			global $Itemid;
			list($year,$month,$day) = JEVHelper::getYMD();

			$params = JComponentHelper::getParams(JEV_COM_COMPONENT);
			if ($params->get("editpopup",0)) {
				ob_end_clean();
				?>
				<script type="text/javascript">				
				window.parent.alert("<?php echo $msg;?>");
				window.location="<?php echo JRoute::_('index.php?option=' . JEV_COM_COMPONENT. "&task=icalevent.edit&evid=$evid&rp_id=$rp_id&year=$year&month=$month&day=$day&Itemid=$Itemid",false);?>";
				</script>
				<?php
				exit();
			}

			// return to the event
			$this->setRedirect( JRoute::_('index.php?option=' . JEV_COM_COMPONENT. "&task=icalevent.edit&evid=$evid&rp_id=$rp_id&year=$year&month=$month&day=$day&Itemid=$Itemid",false),$msg);
		}
	}


	function csvimport () {
		global $mainframe;
		if (!$mainframe->isAdmin()){
			JError::raiseError( 403, JText::_("ALERTNOTAUTH") );
		}

		// get the view
		$this->view = & $this->getView("icalevent","html");
		
		// get all the raw native calendars
		$nativeCals = $this->dataModel->queryModel->getNativeIcalendars();

		// Strip this list down based on user permissions
		$jevuser =& JEVHelper::getAuthorisedUser();
		if ($jevuser && $jevuser->calendars!="" && $jevuser->calendars!="all"){
			$cals = array_keys($nativeCals);
			$allowedcals = explode("|",$jevuser->calendars);
			foreach ( $cals as $calid) {
				if (!in_array($calid,$allowedcals)) unset($nativeCals[$calid]);
			}
		}
		// only offer a choice of native calendars if it exists!
		if (count($nativeCals)>0){
			$icalList = array();
			$icalList[] = JHTML::_('select.option', '0', JText::_('JEV_EVENT_CHOOSE_ICAL'), 'ics_id', 'label' );
			$icalList = array_merge( $icalList, $nativeCals );
			$callist = JHTML::_('select.genericlist', $icalList, 'ics_id', " onchange='preselectCategory(this);'", 'ics_id', 'label', 0 );
			$this->view->assign('callist',$callist);
		}
		else {
			JError::raiseWarning(870, JText::_("INVALID CALENDAR STRUCTURE") );
		}

		// Set the layout
		$this->view->setLayout('csvimport');

		$this->view->display();
	}


	private function doSave(& $msg){
		if (!JEVHelper::isEventCreator()){
			JError::raiseError( 403, JText::_("ALERTNOTAUTH") );
		}

		// clean out the cache
		$cache = &JFactory::getCache('com_jevents');
		$cache->clean(JEV_COM_COMPONENT);

		// JREQUEST_ALLOWHTML requires at least Joomla 1.5 svn9979 (past 1.5 stable)
		$array = JRequest::get('request', JREQUEST_ALLOWHTML);
		// Should we allow raw content through unfiltered
		$params = JComponentHelper::getParams(JEV_COM_COMPONENT);
		if ($params->get("allowraw",0)){
			$array['jevcontent'] = JRequest::getString("jevcontent","","POST",JREQUEST_ALLOWRAW);
		}

		$rrule = SaveIcalEvent::generateRRule($array);

		// ensure authorised
		if (isset($array["evid"]) &&  $array["evid"]>0){
			$event = $this->queryModel->getEventById( intval($array["evid"]), 1, "icaldb" );
			if (!$event || !JEVHelper::canEditEvent($event)){
				JError::raiseError( 403, JText::_("ALERTNOTAUTH") );
			}
		}

		$clearout = false;
		// remove all exceptions since they are no longer needed
		if (isset($array["evid"]) &&  $array["evid"]>0){
			$clearout = true;
		}

		if ($event = SaveIcalEvent::save($array, $this->queryModel, $rrule)){

			$row = new jIcalEventDB($event);
			if (JEVHelper::canPublishEvent($row)){
				$msg = JText::_("Event Saved", true);
			}
			else {
				$msg = JText::_("Event Saved Under Review", true);
			}
			if ($clearout) {
				$db = JFactory::getDBO();
				$query = "DELETE FROM #__jevents_exception WHERE eventid = ".$array["evid"];
				$db->setQuery( $query);
				$db->query();
				// TODO clear out old exception details
			}
		}
		else {
			$msg = JText::_("Event Not Saved", true);
		}

		return $row;
	}

	function close(){
		ob_end_clean();
		?>
		<script type="text/javascript">
		window.parent.SqueezeBox.close();
		try {
			window.parent.closedialog();
		}
		catch (e){}
		</script>
		<?php
		exit();
	}

	function publish(){
		$cid = JRequest::getVar(	'cid',	array(0) );
		JArrayHelper::toInteger($cid);
		$this->toggleICalEventPublish($cid,1);
	}

	function unpublish(){
		$cid = JRequest::getVar(	'cid',	array(0) );
		JArrayHelper::toInteger($cid);
		$this->toggleICalEventPublish($cid,0);
	}

	protected function toggleICalEventPublish($cid,$newstate){
		// clean out the cache
		$cache = &JFactory::getCache('com_jevents');
		$cache->clean(JEV_COM_COMPONENT);

		// Must be at least an event creator to publish events
		$is_event_editor = JEVHelper::isEventPublisher();
		if (!$is_event_editor){
			if (is_array($cid)) {
				foreach ($cid as $id) {
					if (!JEVHelper::canPublishOwnEvents($id)){
						JError::raiseError( 403, JText::_("ALERTNOTAUTH") );
					}
				}
			}
			$is_event_editor = true;
		}
		if (!$is_event_editor){
			JError::raiseError( 403, JText::_("ALERTNOTAUTH") );
		}

		$db	=& JFactory::getDBO();
		foreach ($cid as $id) {

			// I should be able to do this in one operation but that can come later
			$event = $this->queryModel->getEventById( intval($id), 1, "icaldb" );
			if (is_null($event) || !JEVHelper::canPublishEvent($event)){
				JError::raiseError( 403, JText::_("ALERTNOTAUTH") );
			}

			$sql = "UPDATE #__jevents_vevent SET state=$newstate where ev_id='".$id."'";
			$db->setQuery($sql);
			$db->query();
			
			$detail_id="select detail_id from #__jevents_vevent where ev_id='".$id."'";
			$db->setQuery($detail_id);
			$did = $db->loadResult();
					
			
			$sql1 ="UPDATE #__jevents_vevdetail SET state=$newstate where evdet_id='".$did."'";
			$db->setQuery($sql1);
			$db->query();

			$params = JComponentHelper::getParams(JEV_COM_COMPONENT);
			if ($newstate==1 && $params->get("com_notifyauthor",0) && !$event->_author_notified) {
				$sql = "UPDATE #__jevents_vevent SET author_notified=1 where ev_id='".$id."'";
				
				$db->setQuery($sql);
			
				$db->query();

				JEV_CommonFunctions::notifyAuthorPublished( $event );

			}

		}

		// I also need to trigger any onpublish event triggers
		$dispatcher	=& JDispatcher::getInstance();
		// just incase we don't have jevents plugins registered yet
		JPluginHelper::importPlugin("jevents");
		$res = $dispatcher->trigger( 'onPublishEvent' , array($cid, $newstate));

		global $mainframe;
		if ($mainframe->isAdmin()){
			$this->setRedirect( 'index.php?option=' . JEV_COM_COMPONENT. '&task=icalevent.list',"IcalEvent  : New published state Saved");
		}
		else {
			global $Itemid;
			list($year,$month,$day) = JEVHelper::getYMD();
			$rettask = JRequest::getString("rettask","month.calendar");
			// Don't return to the event detail since we may be filtering on published state!
			//$this->setRedirect( JRoute::_('index.php?option=' . JEV_COM_COMPONENT. "&task=icalrepeat.detail&evid=$id&year=$year&month=$month&day=$day&Itemid=$Itemid",false),"IcalEvent  : New published state Saved");
			$this->setRedirect( JRoute::_('index.php?option=' . JEV_COM_COMPONENT. "&task=$rettask&year=$year&month=$month&day=$day&Itemid=$Itemid",false),"IcalEvent  : New published state Saved");
		}
	}

	function delete(){
		// clean out the cache
		$cache = &JFactory::getCache('com_jevents');
		$cache->clean(JEV_COM_COMPONENT);

		/*
		// This is covered by canDeleteEvent below
		if (!JEVHelper::isEventDeletor()){
		JError::raiseError( 403, JText::_("ALERTNOTAUTH") );
		}
		*/
		$cid = JRequest::getVar(	'cid',	array(0) );
		JArrayHelper::toInteger($cid);

		// front end passes the id as evid
		if (count($cid)==1 && $cid[0]==0 ){
			$cid = array(JRequest::getInt("evid",0));
		}

		$db	=& JFactory::getDBO();

		foreach ($cid as $key=>$id) {
			// I should be able to do this in one operation but that can come later
			$event = $this->queryModel->getEventById( intval($id), 1, "icaldb" );
			if (is_null($event) || !JEVHelper::canDeleteEvent($event)){
				JError::raiseWarning( 534, JText::_("JEV_NO_DELETE_ROW") );
				unset($cid[$key]);
			}
		}

		if (count($cid)>0){
			$veventidstring = implode(",",$cid);

			// TODO the ruccurences should take care of all of these??
			// This would fail if all recurrances have been 'adjusted'
			$query = "SELECT DISTINCT (eventdetail_id) FROM #__jevents_repetition WHERE eventid IN ($veventidstring)";
			$db->setQuery( $query);
			$detailids = $db->loadResultArray();
			$detailidstring = implode(",",$detailids);

			$query = "DELETE FROM #__jevents_rrule WHERE eventid IN ($veventidstring)";
			$db->setQuery( $query);
			$db->query();

			$query = "DELETE FROM #__jevents_repetition WHERE eventid IN ($veventidstring)";
			$db->setQuery( $query);
			$db->query();

			$query = "DELETE FROM #__jevents_exception WHERE eventid IN ($veventidstring)";
			$db->setQuery( $query);
			$db->query();

			if (strlen($detailidstring)>0){
				$query = "DELETE FROM #__jevents_vevdetail WHERE evdet_id IN ($detailidstring)";
				$db->setQuery( $query);
				$db->query();

				// I also need to clean out associated custom data
				$dispatcher	=& JDispatcher::getInstance();
				// just incase we don't have jevents plugins registered yet
				JPluginHelper::importPlugin("jevents");
				$res = $dispatcher->trigger( 'onDeleteEventDetails' , array($detailidstring));

			}

			$query = "DELETE FROM #__jevents_vevent WHERE ev_id IN ($veventidstring)";
			$db->setQuery( $query);
			$db->query();

			// I also need to delete custom data
			$dispatcher	=& JDispatcher::getInstance();
			// just incase we don't have jevents plugins registered yet
			JPluginHelper::importPlugin("jevents");
			$res = $dispatcher->trigger( 'onDeleteCustomEvent' , array(&$veventidstring));

		}
		global $mainframe;
		if ($mainframe->isAdmin()){
			$this->setRedirect( "index.php?option=".JEV_COM_COMPONENT."&task=icalevent.list", "ICal Event(s) deleted" );
		}
		else {
			global $Itemid;
			list($year,$month,$day) = JEVHelper::getYMD();
			$rettask = JRequest::getString("rettask","month.calendar");
			$this->setRedirect( JRoute::_('index.php?option=' . JEV_COM_COMPONENT. "&task=$rettask&year=$year&month=$month&day=$day&Itemid=$Itemid", false),"IcalEvent Deleted");
		}

	}


	function _checkValidCategories(){
		// TODO switch this after migration
		$component_name = "com_jevents";

		$db	=& JFactory::getDBO();
		$query = "SELECT count(*) as count FROM #__categories"
		. "\n WHERE section='$component_name'";
		$db->setQuery($query);
		$count = intval($db->loadResult());
		if ($count<=0){
			$this->setRedirect("index.php?option=".JEV_COM_COMPONENT."&task=categories.list","You must first create at least one category");
			$this->redirect();
		}
	}

}
