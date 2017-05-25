<?php

class EventsController extends Controller
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
				'actions'=>array('index','view','updatestatus','ajaxupdate','featuredstatus'),
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
	public function actionCreate()
	{
		$model = new Events;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Events']))
		{
			$model->attributes=$_POST['Events'];
			if($model->save()){
				Yii::app()->user->setFlash('success', '<i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i><strong>&nbsp; Success!</strong> Your Event created successfully.');
				$this->redirect(array('index'));
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
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Events']))
		{
			$model->attributes=$_POST['Events'];
			if($model->save()){
				Yii::app()->user->setFlash('success', '<i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i><strong>&nbsp; Success!</strong> Your Event updated successfully.');
				$this->redirect(array('index'));
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
		$model = $this->loadModel($id);
		/*$model_rep_delete = Eventsrepetition::model()->findByAttributes(array('eventid'=>$model->ev_id));
		$model_rep_delete->delete();
		$model_evdetails_delete = EventsDetail::model()->findByAttributes(array('evdet_id'=>$model->detail_id));
		$model_evdetails_delete->delete();
		$model_feature_delete = Eventcustomfields::model()->findByAttributes(array('evdet_id'=>$model->detail_id));
		if(isset($model_feature_delete) AND $model_feature_delete!=''){
				$model_feature_delete->delete();
		}
		$this->loadModel($id)->delete();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));*/
			
			
			
	// new-----------start
	# Delete data from jos_jevents_rrule table
		EventsRule::model()->deleteAll("eventid ='" . $model->ev_id . "'");
		
		# Delete data from jos_jevents_repetition table
		Eventsrepetition::model()->deleteAll("eventdetail_id ='" . $model->detail_id . "'");
		
		# Delete data from jos_jev_customfields table
		Eventcustomfields::model()->deleteAll("evdet_id ='" . $model->detail_id . "'");
		
		# Delete data from jos_jevents_vevdetail table
		EventsDetail::model()->deleteAll("evdet_id ='" . $model->detail_id . "'");

		# Delete data from jos_jevents_vevdetail table
		//$this->loadModel($id)->delete();
		
		try{
			# Delete data from jos_jevents_vevdetail table
			$this->loadModel($id)->delete();
			if(!isset($_GET['ajax']))
				Yii::app()->user->setFlash('success','<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your Event deleted successfully.');
			else
				echo '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your Event deleted successfully.';
		}catch(CDbException $e){
			if(!isset($_GET['ajax']))
				Yii::app()->user->setFlash('error','Normal - error message');
			else
				echo "<div class='flash-error'>Ajax - error message</div>"; //for ajax
		}
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		/*$dataProvider=new CActiveDataProvider('Events');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));*/
		
		# CODE FOR SET PAGE SIZE START
		if ( isset( $_GET[ 'pageSize' ] ) )
		{
			Yii::app()->user->setState( 'pageSize', (int) $_GET[ 'pageSize' ] );
			unset( $_GET[ 'pageSize' ] );
		}
		# CODE FOR SET PAGE SIZE END 

		
		$model=new Events('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Events']))
			$model->attributes=$_GET['Events'];

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
	 * @return Events the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Events::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Events $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='events-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	/**
	* Function to change Location status from Active to Inactive and Vice versa
	* Developer: rinkal 
	*/	
	public function actionUpdatestatus($id) {
		$newStatus = ($_REQUEST['status'] == 1)?0:1;
        $model = Events::model()->findByPk($id);
        $model->state = $newStatus;
        $model->save();
		$model_ev_details = EventsDetail::model()->findByAttributes(array('evdet_id'=>$model->detail_id));
        $model_ev_details->state = $newStatus;
        $model_ev_details->save();
        Yii::app()->user->setFlash('success', '<i class="glyphicon glyphicon-circle-exclamation-mark"></i><strong> Success! </strong> Event status updated successfully.');
		$this->redirect(array('/events?'.$_REQUEST["query_url"]));
    }
	
	public function actionfeaturedstatus($id) {
		$newStatus = ($_REQUEST['status'] == 1)?0:1;
        $model_feature = Eventcustomfields::model()->findByAttributes(array('evdet_id'=>$id));
       	
		if(isset($model_feature) AND $model_feature!=''){
			$model_feature->value 	 = $newStatus;
			$model_feature->save();
	  	}else{
			$model_feature_events = new Eventcustomfields;
			$model_feature_events->evdet_id = $id;
			$model_feature_events->name	 ='field4';
	    	$model_feature_events->value 	 = $newStatus;
			$model_feature_events->save();
		}
		Yii::app()->user->setFlash('success', '<i class="glyphicon glyphicon-circle-exclamation-mark"></i><strong> Success! </strong> Featured event status updated successfully.');
		$this->redirect(array('/events?'.$_REQUEST["query_url"]));
    }
	public function actionAjaxupdate(){

		$act = $_GET['act'];
	    $autoIdAll = $_POST['autoId'];
	    if(count($autoIdAll)>0){
	        foreach($autoIdAll as $autoId){
	            $model=$this->loadModel($autoId);
	            if($act=='doDelete'){
					Yii::app()->user->setFlash('success', '<strong>Success!</strong> Your Event deleted successfully.');
					$model_rep_delete = Eventsrepetition::model()->findByAttributes(array('eventid'=>$model->ev_id));
					$model_rep_delete->delete();
					$model_evdetails_delete = EventsDetail::model()->findByAttributes(array('evdet_id'=>$model->detail_id));
					$model_evdetails_delete->delete();
					$model_feature_delete = Eventcustomfields::model()->findByAttributes(array('evdet_id'=>$model->detail_id));
					if(isset($model_feature_delete) AND $model_feature_delete!=''){
						$model_feature_delete->delete();
				  	}
					$model->delete();
					$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your Event deleted successfully.';
				}
	            if($act=='doActive'){
	                $model->state = '1';
					$model_ev_details = EventsDetail::model()->findByAttributes(array('evdet_id'=>$model->detail_id));
        			$model_ev_details->state = '1';
        			$model_ev_details->save();
        			$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your Event published successfully.';	
				}
	            if($act=='doInactive'){
	                $model->state = '0';                     
					$model_ev_details = EventsDetail::model()->findByAttributes(array('evdet_id'=>$model->detail_id));
        			$model_ev_details->state = '0';
        			$model_ev_details->save();
        			$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your Event unpublished successfully.';					
				}
	            if(!$model->save())
	                throw new Exception("Sorry",500);
	        } // foreach loop
	        echo $msg;
	    }
	} // Ending Function
	
}
