<?php

class EventsDetailController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				//'users'=>array('admin'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate(){
		$model = new EventsDetail;
		
		# Fetch Current login user's information
		$currentLoginUser = CommonController::userinfo(Yii::app()->user->id);
		
		
		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['EventsDetail'])){
			
			//if(strtotime($_POST['EventsDetail']['dtstart']) <= strtotime($_POST['EventsDetail']['dtend'])){
			
			$model->attributes	=	$_POST['EventsDetail'];
			# TABLE 1 Inserting data in jos_jevents_vevdetail table
			if(isset($_POST['EventsDetail']['dtstart']) && isset($_POST['EventsDetail']['dtend'])){
				$model->dtstart		= strtotime($_POST['EventsDetail']['dtstart']);
				$model->dtend		= strtotime($_POST['EventsDetail']['dtend']);
				$model->description	= $_POST['EventsDetail']['description'];
			}
			if($model->save()){

				# TABLE 2 Inserting data in jos_jevents_vevent table
				$model_icsfile					= new EventsIcsfile;
				$icsfile_id						= $model_icsfile::model()->findByAttributes(array('label'=>'Events'));
				$model_events 					= new Events;
   				$model_events->icsid 			= $icsfile_id->ics_id;
   				$model_events->catid 			= $model->catid;
   				$model_events->uid 				= $this->genRandomPassword(32);
   				$model_events->refreshed 		= '0000-00-00 00:00:00';
   				$model_events->created 			= date('Y-m-d H:i:s');
   				$model_events->created_by 		= $currentLoginUser->id;
   				$model_events->modified_by 		= $currentLoginUser->id;
   				$model_events->access 			= 0;
   				$model_events->lockevent 		= 0;
   				$model_events->author_notified 	= 0;
   				$model_events->detail_id 		= $model->evdet_id;
   				$model_events->state 			= $model->state;
				$model_events->save();
				
				# TABLE 3 Inserting data in jos_jev_customfields table for feature event
				$model_feature_events	= new Eventcustomfields;
				$feature_id				= $model_feature_events::model()->findByAttributes(array('evdet_id'=>$model->evdet_id));
				if(empty($feature_id) && $feature_id == ''){
					$model_feature_events->evdet_id		= $model->evdet_id;
					$model_feature_events->name			= 'field4';
					if($_POST['Eventcustomfields']['value'] == 1){
						$model_feature_events->value = 1;
					}else{
						$model_feature_events->value = 0;
					}
				}
				$model_feature_events->save();
							
				
				/******* TABLE 4 @CODE FOR REPEATATION START ***********/
				
				# Start date and time calculation
				$start_date_array 					= explode(" ",$_POST['EventsDetail']['dtstart']); // Array of Start date & time
				$start_date 						= $start_date_array[0]; // Assign start date
				$start_time 						= $start_date_array[1]; // Assign Start Time
				$numeric_start_date 				= strtotime($start_date); 	// Numeric Start Date
				
				# End date and time calculation
				$end_date_array 					= explode(" ",$_POST['EventsDetail']['dtend']);	// Array of end date & time	
				$end_date 							= $end_date_array[0]; // Assign end date
				$end_time 							= $end_date_array[1]; // Assign end time
				
				# Repeat Until Date Calculation
				$numeric_repeat_until_date			= strtotime($_POST['EventsDetail']['repeatUntil']); // Assgin numeric value of repeat until date
				$repeat_until_date					= $_POST['EventsDetail']['repeatUntil']; // Assgin numeric value of repeat until date
				 
				# DAILY
				if(isset($_POST['freq']) && $_POST['freq'] == 'daily'){
					#Process to insert data in jos_jevents_repetition table
					$total_days = CommonController::datediffyogi('d',date("d F Y", strtotime($start_date)),date("d F Y", strtotime($repeat_until_date)),false);
					
					# Loop to insert repeat table entry
					for($i=0; $i <= $total_days; $i++){
						# TABLE 4 Inserting data in jos_jevents_repetition table for REPEAT TYPE = DAILY
						$model_rp_events 					= new Eventsrepetition;
						$model_rp_events->eventid 			= $model_events->ev_id;
						$model_rp_events->eventdetail_id 	= $model->evdet_id;
						$model_rp_events->duplicatecheck	= $this->genRandomPassword(32);
						$model_rp_events->startrepeat 		= date("Y-m-d H:i:s", strtotime($start_date.' '.$start_time."+$i days"));
						$model_rp_events->endrepeat 		= date("Y-m-d H:i:s", strtotime($start_date.' '.$end_time."+$i days"));
						$model_rp_events->save();
					}
				
					# TABLE 5 Process to insert data in  jos_jevents_rrule table
					$model_event_rule				= new EventsRule;
					$model_event_rule->eventid		= $model_events->ev_id;
					$model_event_rule->freq			= 'DAILY';
					$model_event_rule->until 		= $numeric_repeat_until_date;
					$model_event_rule->count		= 999;
					$model_event_rule->rinterval	= 1;
					$model_event_rule->save();
					
				# YEARLY
				}elseif(isset($_POST['freq']) && $_POST['freq'] == 'yearly'){
					
					# Process to insert data in jos_jevents_repetition table
					$total_year = CommonController::datediffyogi('yyyy',date("d F Y", strtotime($start_date)),date("d F Y", strtotime($repeat_until_date)),false);
	
					# Loop to insert repeat table entry
					for($i=0; $i <= $total_year; $i++){
						# TABLE 4 Inserting data in jos_jevents_repetition table for REPEAT TYPE = DAILY
						$model_rp_events 					= new Eventsrepetition;
						$model_rp_events->eventid 			= $model_events->ev_id;
						$model_rp_events->eventdetail_id 	= $model->evdet_id;
						$model_rp_events->duplicatecheck	= $this->genRandomPassword(32);
						$model_rp_events->startrepeat 		= date("Y-m-d H:i:s", strtotime($start_date.' '.$start_time."+$i years"));
						$model_rp_events->endrepeat 		= date("Y-m-d H:i:s", strtotime($start_date.' '.$end_time."+$i years"));
						$model_rp_events->save();
					}
					
					# TABLE 5 Inserting data in jos_jevents_rrule table for REPEAT TYPE = YEARLY
					$model_event_rule				= new EventsRule;
					$model_event_rule->eventid		= $model_events->ev_id;
					$model_event_rule->freq			= 'YEARLY';
					$model_event_rule->until 		= $numeric_repeat_until_date;
					$model_event_rule->count		= 999;
					$model_event_rule->rinterval	= 1;
					$model_event_rule->save();
				
				# WEEKLY
				}elseif(isset($_POST['freq']) && $_POST['freq'] == 'weekly'){ // CODE FOR REPEAT = weekly
					# Process to insert data in jos_jevents_repetition table
					$week_interval = $_POST['rinterval'];				
					foreach($_POST['byday'] as $value){
						$wk_start_date = $start_date; $i = 0;
						while(strtotime($wk_start_date) <= strtotime($repeat_until_date)){ //5 for count Friday, 6 for Saturday , 7 for Sunday
							if(date("N",strtotime($wk_start_date)) == $value ){
								$i = 1;
								# TABLE 4 Inserting data in jos_jevents_repetition table for REPEAT TYPE = DAILY
								$model_rp_events 					= new Eventsrepetition;
								$model_rp_events->eventid 			= $model_events->ev_id;
								$model_rp_events->eventdetail_id 	= $model->evdet_id;
								$model_rp_events->duplicatecheck	= $this->genRandomPassword(32);
								$model_rp_events->startrepeat 		= date("Y-m-d H:i:s", strtotime($wk_start_date.' '.$start_time));
								$model_rp_events->endrepeat 		= date("Y-m-d H:i:s", strtotime($wk_start_date.' '.$end_time));
								$model_rp_events->save();
							}
							
							if($i == 0){ // For first time keep the current week dates
								$wk_start_date = date ("Y-m-d", strtotime("+1 day", strtotime($wk_start_date)));
							}else{
								$wk_start_date = date ("Y-m-d", strtotime("+$week_interval day", strtotime($wk_start_date)));
							}
						} // While loop
					} // Foreach
			
					# TABLE 5 Inserting data in jos_jevents_rrule table for REPEAT TYPE = WEEKLY
					$weekdays_list 					= CommonController::weekday_comma_seprated_list($_POST['byday']);
					$model_event_rule				= new EventsRule;
					$model_event_rule->eventid		= $model_events->ev_id;
					$model_event_rule->freq			= 'WEEKLY';
					$model_event_rule->until 		= $numeric_repeat_until_date;
					$model_event_rule->count		= 999;
					$model_event_rule->rinterval	= $_POST['rinterval'];
					$model_event_rule->byday		= $weekdays_list;
					$model_event_rule->save();				
				
				# MONTHLY
				}elseif(isset($_POST['freq']) && $_POST['freq'] == 'monthly'){
					$month_days_array = explode(',',$_POST['month_days']);
					$month_start_date = $start_date;
					while(strtotime($month_start_date) <= strtotime($repeat_until_date)){
						if(in_array(date("d",strtotime($month_start_date)),$month_days_array)){
							$model_rp_events 					= new Eventsrepetition;
							$model_rp_events->eventid 			= $model_events->ev_id;
							$model_rp_events->eventdetail_id 	= $model->evdet_id;
							$model_rp_events->duplicatecheck	= $this->genRandomPassword(32);
							$model_rp_events->startrepeat 		= date("Y-m-d H:i:s", strtotime($month_start_date.' '.$start_time));
							$model_rp_events->endrepeat 		= date("Y-m-d H:i:s", strtotime($month_start_date.' '.$end_time));
							$model_rp_events->save();
						}
						$month_start_date = date ("Y-m-d", strtotime("+1 day", strtotime($month_start_date)));
					} // While loop	
				
					# TABLE 5 Inserting data in jos_jevents_rrule table for REPEAT TYPE = MONTHLY
					$model_event_rule				= new EventsRule;
					$model_event_rule->eventid		= $model_events->ev_id;
					$model_event_rule->freq			= 'MONTHLY';
					$model_event_rule->until 		= $numeric_repeat_until_date;
					$model_event_rule->count		= 999;
					$model_event_rule->rinterval	= 1;
					$model_event_rule->bymonthday	= '+'.$_POST['month_days'];
					$model_event_rule->save();	
					
				# NO REPEAT
				}elseif(isset($_POST['freq']) && $_POST['freq'] == 'norepeat'){
					
					# Inserting data in jos_jevents_repetition table for REPEAT TYPE = NO REPEAT
					$model_rp_events = new Eventsrepetition;
	   				$model_rp_events->eventid 			= $model_events->ev_id;
	   				$model_rp_events->eventdetail_id 	= $model->evdet_id;
	   				$model_rp_events->duplicatecheck	= $this->genRandomPassword(32);
	   				$model_rp_events->startrepeat 		= $_POST['EventsDetail']['dtstart'];
	   				$model_rp_events->endrepeat 		= $_POST['EventsDetail']['dtend'];
					$model_rp_events->save();
					
					# Inserting data in jos_jevents_rrule table for REPEAT TYPE = NO REPEAT
					$model_event_rule				= new EventsRule;
					$model_event_rule->eventid		= $model_events->ev_id;
					$model_event_rule->freq			= 'none';
					$model_event_rule->until 		= 0;
					$model_event_rule->count		= 1;
					$model_event_rule->rinterval	= 1;
					$model_event_rule->save();
				}
				/******* @CODE FOR REPEATATION ENDS ***********/
				
				Yii::app()->user->setFlash('success', '<i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i><strong>Success!</strong> Your Event added Successfully.');
				//$this->redirect(array('/events'));
				$previousURL = explode('?', $_POST['EventsDetail']['last_url']);
				$this->redirect(array('/events?'.$previousURL[1]));
			}
			
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		
		# Fetch Current login user's information
		$currentLoginUser = CommonController::userinfo(Yii::app()->user->id);
		
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['EventsDetail']))
		{
			$model->attributes=$_POST['EventsDetail'];
			if(isset($_POST['EventsDetail']['dtstart']) and isset($_POST['EventsDetail']['dtend'])){
				$model->dtstart = strtotime($_POST['EventsDetail']['dtstart']);
				$model->dtend = strtotime($_POST['EventsDetail']['dtend']);
				$model->description = $_POST['EventsDetail']['description'];
			}
			
			if($model->save()){
				
				//Updating data in jos_jevents_vevent table
				$model_events = Events::model()->findByAttributes(array('detail_id'=>$model->evdet_id));
   				$model_events->catid 		= $model->catid;
   				$model_events->state 		= $model->state;
   				$model_events->modified_by 	= $currentLoginUser->id;
				$model_events->save();
				
				//Updating data in jos_jevents_repetition table
/*				$model_rp_events = Eventsrepetition::model()->findByAttributes(array('eventdetail_id'=>$model->evdet_id));
   				$model_rp_events->startrepeat 	= $_POST['EventsDetail']['dtstart'];
   				$model_rp_events->endrepeat 	= $_POST['EventsDetail']['dtend'];
				$model_rp_events->save();*/
				
				//Updating data in jos_jev_customfields table for feature event
				$model_feature_events = Eventcustomfields::model()->findByAttributes(array('evdet_id'=>$model->evdet_id));
				
				if(isset($model_feature_events) && $model_feature_events!=''){
					if($_POST['Eventcustomfields']['value']==1){
						$model_feature_events->value = 1;
					}else{
						$model_feature_events->value = 0;
					}
				}
				$model_feature_events->save();
				
				
				/******* TABLE 4 @CODE FOR REPEATATION START ***********/
				
				# Start date and time calculation
				$start_date_array 					= explode(" ",$_POST['EventsDetail']['dtstart']); // Array of Start date & time
				$start_date 						= $start_date_array[0]; // Assign start date
				$start_time 						= $start_date_array[1]; // Assign Start Time
				$numeric_start_date 				= strtotime($start_date); 	// Numeric Start Date
				
				# End date and time calculation
				$end_date_array 					= explode(" ",$_POST['EventsDetail']['dtend']);	// Array of end date & time	
				$end_date 							= $end_date_array[0]; // Assign end date
				$end_time 							= $end_date_array[1]; // Assign end time
				
				# Repeat Until Date Calculation
				$numeric_repeat_until_date			= strtotime($_POST['EventsDetail']['repeatUntil']); // Assgin numeric value of repeat until date
				$repeat_until_date					= $_POST['EventsDetail']['repeatUntil']; // Assgin numeric value of repeat until date
				 
				# DAILY
				if(isset($_POST['freq']) && $_POST['freq'] == 'daily'){
					#Process to insert data in jos_jevents_repetition table
					$total_days = CommonController::datediffyogi('d',date("d F Y", strtotime($start_date)),date("d F Y", strtotime($repeat_until_date)),false);
					Eventsrepetition::model()->deleteAll("eventdetail_id ='" . $model->evdet_id . "'");
					# Loop to insert repeat table entry
					for($i=0; $i <= $total_days; $i++){
						# TABLE 4 Inserting data in jos_jevents_repetition table for REPEAT TYPE = DAILY
						$model_rp_events 					= new Eventsrepetition;
						$model_rp_events->eventid 			= $model_events->ev_id;
						$model_rp_events->eventdetail_id 	= $model->evdet_id;
						$model_rp_events->duplicatecheck	= $this->genRandomPassword(32);
						$model_rp_events->startrepeat 		= date("Y-m-d H:i:s", strtotime($start_date.' '.$start_time."+$i days"));
						$model_rp_events->endrepeat 		= date("Y-m-d H:i:s", strtotime($start_date.' '.$end_time."+$i days"));
						$model_rp_events->save();
					}
				
					# TABLE 5 Process to insert data in  jos_jevents_rrule table
					$model_event_rule				= EventsRule::model()->findByAttributes(array('eventid'=>$model_events->ev_id));
					$model_event_rule->eventid		= $model_events->ev_id;
					$model_event_rule->freq			= 'DAILY';
					$model_event_rule->until 		= $numeric_repeat_until_date;
					$model_event_rule->count		= 999;
					$model_event_rule->rinterval	= 1;
					$model_event_rule->save();
					
				# YEARLY
				}elseif(isset($_POST['freq']) && $_POST['freq'] == 'yearly'){
					
					# Process to insert data in jos_jevents_repetition table
					$total_year = CommonController::datediffyogi('yyyy',date("d F Y", strtotime($start_date)),date("d F Y", strtotime($repeat_until_date)),false);
					// deleteAll() is yii inbuilt function
					Eventsrepetition::model()->deleteAll("eventdetail_id ='" . $model->evdet_id . "'");
					# Loop to insert repeat table entry
					for($i=0; $i <= $total_year; $i++){
						# TABLE 4 Inserting data in jos_jevents_repetition table for REPEAT TYPE = DAILY
						$model_rp_events 					= new Eventsrepetition;
						$model_rp_events->eventid 			= $model_events->ev_id;
						$model_rp_events->eventdetail_id 	= $model->evdet_id;
						$model_rp_events->duplicatecheck	= $this->genRandomPassword(32);
						$model_rp_events->startrepeat 		= date("Y-m-d H:i:s", strtotime($start_date.' '.$start_time."+$i years"));
						$model_rp_events->endrepeat 		= date("Y-m-d H:i:s", strtotime($start_date.' '.$end_time."+$i years"));
						$model_rp_events->save();
					}
					
					# TABLE 5 Inserting data in jos_jevents_rrule table for REPEAT TYPE = YEARLY
					$model_event_rule				= EventsRule::model()->findByAttributes(array('eventid'=>$model_events->ev_id));
					$model_event_rule->eventid		= $model_events->ev_id;
					$model_event_rule->freq			= 'YEARLY';
					$model_event_rule->until 		= $numeric_repeat_until_date;
					$model_event_rule->count		= 999;
					$model_event_rule->rinterval	= 1;
					$model_event_rule->save();
				
				# WEEKLY
				}elseif(isset($_POST['freq']) && $_POST['freq'] == 'weekly'){ // CODE FOR REPEAT = weekly
					# Process to insert data in jos_jevents_repetition table
					$week_interval = $_POST['rinterval'];
					Eventsrepetition::model()->deleteAll("eventdetail_id ='" . $model->evdet_id . "'");				
					
					foreach($_POST['byday'] as $value){
						$wk_start_date = $start_date; $i = 0;
						
						while(strtotime($wk_start_date) <= strtotime($repeat_until_date)){ //5 for count Friday, 6 for Saturday , 7 for Sunday
							if(date("N",strtotime($wk_start_date)) == $value ){
								$i = 1;
								# TABLE 4 Inserting data in jos_jevents_repetition table for REPEAT TYPE = DAILY
								$model_rp_events 					= new Eventsrepetition;
								$model_rp_events->eventid 			= $model_events->ev_id;
								$model_rp_events->eventdetail_id 	= $model->evdet_id;
								$model_rp_events->duplicatecheck	= $this->genRandomPassword(32);
								$model_rp_events->startrepeat 		= date("Y-m-d H:i:s", strtotime($wk_start_date.' '.$start_time));
								$model_rp_events->endrepeat 		= date("Y-m-d H:i:s", strtotime($wk_start_date.' '.$end_time));
								$model_rp_events->save();
							}
							
							if($i == 0){ // For first time keep the current week dates
								$wk_start_date = date ("Y-m-d", strtotime("+1 day", strtotime($wk_start_date)));
							}else{
								$wk_start_date = date ("Y-m-d", strtotime("+$week_interval day", strtotime($wk_start_date)));
							}
						} // While loop
					} // Foreach
			
					# TABLE 5 Inserting data in jos_jevents_rrule table for REPEAT TYPE = WEEKLY
					$weekdays_list 					= CommonController::weekday_comma_seprated_list($_POST['byday']);
					$model_event_rule				= EventsRule::model()->findByAttributes(array('eventid'=>$model_events->ev_id));
					$model_event_rule->eventid		= $model_events->ev_id;
					$model_event_rule->freq			= 'WEEKLY';
					$model_event_rule->until 		= $numeric_repeat_until_date;
					$model_event_rule->count		= 999;
					$model_event_rule->rinterval	= $_POST['rinterval'];
					$model_event_rule->byday		= $weekdays_list;
					$model_event_rule->save();				
				
				# MONTHLY
				}elseif(isset($_POST['freq']) && $_POST['freq'] == 'monthly'){
					$month_days_array = explode(',',$_POST['month_days']);
					$month_start_date = $start_date;
					// Deleter all existing entry for this event ID3_BEST
					Eventsrepetition::model()->deleteAll("eventdetail_id ='" . $model->evdet_id . "'");
					
					while(strtotime($month_start_date) <= strtotime($repeat_until_date)){
						if(in_array(date("d",strtotime($month_start_date)),$month_days_array)){
							$model_rp_events 					= new Eventsrepetition;
							$model_rp_events->eventid 			= $model_events->ev_id;
							$model_rp_events->eventdetail_id 	= $model->evdet_id;
							$model_rp_events->duplicatecheck	= $this->genRandomPassword(32);
							$model_rp_events->startrepeat 		= date("Y-m-d H:i:s", strtotime($month_start_date.' '.$start_time));
							$model_rp_events->endrepeat 		= date("Y-m-d H:i:s", strtotime($month_start_date.' '.$end_time));
							$model_rp_events->save();
						}
						$month_start_date = date ("Y-m-d", strtotime("+1 day", strtotime($month_start_date)));
					} // While loop	
				
					# TABLE 5 Inserting data in jos_jevents_rrule table for REPEAT TYPE = MONTHLY

					$model_event_rule				= EventsRule::model()->findByAttributes(array('eventid'=>$model_events->ev_id));
					$model_event_rule->eventid		= $model_events->ev_id;
					$model_event_rule->freq			= 'MONTHLY';
					$model_event_rule->until 		= $numeric_repeat_until_date;
					$model_event_rule->count		= 999;
					$model_event_rule->rinterval	= 1;
					$model_event_rule->bymonthday	= '+'.$_POST['month_days'];
					$model_event_rule->save();	
					
				# NO REPEAT
				}elseif(isset($_POST['freq']) && $_POST['freq'] == 'norepeat'){
					
					# Inserting data in jos_jevents_repetition table for REPEAT TYPE = NO REPEAT
					$model_rp_events					= Eventsrepetition::model()->findByAttributes(array('eventdetail_id'=>$model->evdet_id));
	   				$model_rp_events->eventid 			= $model_events->ev_id;
	   				$model_rp_events->eventdetail_id 	= $model->evdet_id;
	   				$model_rp_events->duplicatecheck	= $this->genRandomPassword(32);
	   				$model_rp_events->startrepeat 		= $_POST['EventsDetail']['dtstart'];
	   				$model_rp_events->endrepeat 		= $_POST['EventsDetail']['dtend'];
					$model_rp_events->save();
					
					# Inserting data in jos_jevents_rrule table for REPEAT TYPE = NO REPEAT
					$model_event_rule				= EventsRule::model()->findByAttributes(array('eventid'=>$model_events->ev_id));
					$model_event_rule->eventid		= $model_events->ev_id;
					$model_event_rule->freq			= 'none';
					$model_event_rule->until 		= 0;
					$model_event_rule->count		= 1;
					$model_event_rule->rinterval	= 1;
					$model_event_rule->save();
				}
				/******* @CODE FOR REPEATATION ENDS ***********/
				
				# Yogi: Redirect to previous URL
				Yii::app()->user->setFlash('success', '<i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i><strong>Success!</strong> Your Event updated Successfully.');
				//$this->redirect(array('/events'));
				$previousURL = explode('?', $_POST['EventsDetail']['last_url']);
				$this->redirect(array('/events?'.$previousURL[1]));
			}
		}
		

		$this->render('update',array(
			'model'=>$model,
		));
		
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		# Delete data from jos_jevents_rrule table
		$model_events = Events::model()->findByAttributes(array('detail_id'=>$id));
		EventsRule::model()->deleteAll("eventid ='" . $model_events->ev_id . "'");
		
		# Delete data from jos_jevents_repetition table
		Eventsrepetition::model()->deleteAll("eventdetail_id ='" . $id . "'");
		
		# Delete data from jos_jev_customfields table
		Eventcustomfields::model()->deleteAll("evdet_id ='" . $id . "'");
		
		# Delete data from jos_jevents_vevent table
		Events::model()->deleteAll("detail_id ='" . $id . "'");

		# Delete data from jos_jevents_vevdetail table
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new EventsDetail('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['EventsDetail']))
			$model->attributes=$_GET['EventsDetail'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->redirect(array('index'));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return EventsDetail the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=EventsDetail::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param EventsDetail $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='events-detail-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	// Function to generate random 32 character SALT string by YOGI
	public function genRandomPassword($length = 8){
		$salt = "abcdefghijklmnopqrstuvwxyz0123456789";
		$len = strlen($salt);
		$makepass = '';

		for($i = 0; $i < $length; $i ++){
			$makepass .= $salt[mt_rand(0, $len -1)];
		}
		return $makepass;
	}
}
