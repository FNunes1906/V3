<?php

class LocationsController extends Controller
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
				'actions'=>array('index','view','updatestatus','ajaxupdate','changestatus','featuredstatus'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
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
		# Creating class object
		$model = new Locations;
		$model->published = 1;
		# Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Locations'])){
			
			# Uncomment below line to make work multiple category work
			if(isset($_POST['Locations']['catid_list']) AND $_POST['Locations']['catid_list'] != ''){
				$_POST['Locations']['catid_list'] = implode(',',$_POST['Locations']['catid_list']);
			}
			
			# Assigning Post data to attribute array of class
			$model->attributes	= $_POST['Locations'];
			$model->alias		= strtolower(str_replace(" ","-",$_POST['Locations']['title']));
			$model->global		= 1;
			
			
			# This will give uploded file name
			$uploadedFile = CUploadedFile::getInstance($model,'image');
			
			# Rename file name with mktime function
			$fileName = mktime().'.'.$uploadedFile;
			
			# Assign filename to model Image object
			$model->image 		= $fileName;
			$model->imagetitle 	= $uploadedFile;
		
			if($model->save()){

				if(!empty($uploadedFile)){
					
					# Set ORIGINAL image path
					$largeImagePath	= Yii::app()->basePath.'/../../partner/'.Yii::app()->db->tablePrefix.'/images/stories/jevents/jevlocations/'.$fileName;
					
					# Set THUMBNAIL image path
					$thumbImagePath = Yii::app()->basePath.'/../../partner/'.Yii::app()->db->tablePrefix.'/images/stories/jevents/jevlocations/thumbnails/thumb_'.$fileName;
					
					# this will save Large image
					$uploadedFile->saveAs($largeImagePath,false);
					
					# This will create and save thumbnail image
					if($uploadedFile->saveAs($thumbImagePath)){
                       
					   # This code will load thumbnail then Resize it and then save it
					   $thumbnail = Yii::app()->image->load($thumbImagePath);
                       $thumbnail->resize(120, 80);
					   //$thumbnail->resize(400, 100)->rotate(-45)->quality(75)->sharpen(20);
                       $thumbnail->save();
					}
				}
				
				//Inserting data in jos_jev_customfields3 table for feature location
				$model_feature_location = new LocationCustomfields;
				$feature_id = $model_feature_location::model()->findByAttributes(array('target_id'=>$model->loc_id));
				if(empty($feature_id) || $feature_id==''){
					$model_feature_location->target_id 	= $model->loc_id;
					$model_feature_location->targettype	= 'com_jevlocations';
					$model_feature_location->name		= 'field5';
					if($_POST['LocationCustomfields']['value'] == 1){
						$model_feature_location->value = 1;
					}else{
						$model_feature_location->value = 0;
					}
				}
				$model_feature_location->save();
				
				Yii::app()->user->setFlash('success', '<i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i><strong>Success!</strong> Location created Successfully.');
				# Redirect to Location/index page after insert operation				
				
				if(isset($_GET['type']) && $_GET['type']=='com_jevents'){
					Yii::app()->session['addLocationFromEvent'] = $model->loc_id;
					$this->redirect($_POST['Locations']['last_url']);
				}else{
					$pre_url_sep = explode('?', $_POST['Locations']['last_url']);
					$this->redirect(array('/locations?'.$pre_url_sep[1]));
				}
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
		$this->performAjaxValidation($model);
		
		if(isset($_POST['Locations']))
		{
			//echo $_POST['Locations']['catid_list']."test123";
			# Uncomment below line to make work multiple category work
			if(isset($_POST['Locations']['catid_list']) || $_POST['Locations']['catid_list']!=''){
				$_POST['Locations']['catid_list'] = implode(',',$_POST['Locations']['catid_list']);
			}
			
			# This will give uploded file name
			$uploadedFile	= CUploadedFile::getInstance($model,'image');
			$old_file_name	= $model->image;
			
			if(empty($uploadedFile) || $uploadedFile == ''){
				$_POST['Locations']['image'] 		= $model->image;
				$_POST['Locations']['imagetitle'] 	= $model->imagetitle;
				# Assigning Post data to attribute array of class
				$model->attributes = $_POST['Locations'];
				
			}else{
				# Assigning Post data to attribute array of class
				$model->attributes = $_POST['Locations'];
				
				# Rename file name with mktime function
				$fileName = mktime().'.'.$uploadedFile;
				
				# Assign filename to model Image object
				$model->image 		= $fileName;
				$model->imagetitle 	= $uploadedFile;
			}	
			
			if($model->save()){
				
				if(!empty($uploadedFile)){
					
					# Set ORIGINAL image path
					$largeImagePath	= Yii::app()->basePath.'/../../partner/'.Yii::app()->db->tablePrefix.'/images/stories/jevents/jevlocations/'.$fileName;
					
					# Set THUMBNAIL image path
					$thumbImagePath = Yii::app()->basePath.'/../../partner/'.Yii::app()->db->tablePrefix.'/images/stories/jevents/jevlocations/thumbnails/thumb_'.$fileName;
					
					# this will save Large image
					$uploadedFile->saveAs($largeImagePath,false);
					
					# This will create and save thumbnail image
					if($uploadedFile->saveAs($thumbImagePath)){
                       
					   # This code will load thumbnail then Resize it and then save it
					   $thumbnail = Yii::app()->image->load($thumbImagePath);
                       $thumbnail->resize(120, 80);
					   //$thumbnail->resize(400, 100)->rotate(-45)->quality(75)->sharpen(20);
                       $thumbnail->save();
					}
				}else{ // Checking uploadedfile variable if new file is not uploded then go to else section
					$model->updateByPk($id, array('image' => $old_file_name,));
				}
				
				
				//updating data in jos_jev_customfields3 table for feature location
				$model_feature_id = LocationCustomfields::model()->findByAttributes(array('target_id'=>$model->loc_id));
				
				if(empty($model_feature_id) || $model_feature_id==''){
					$model_feature_id->target_id 	= $model->loc_id;
					$model_feature_id->targettype	= 'com_jevlocations';
					$model_feature_id->name			= 'field5';
					if($_POST['LocationCustomfields']['value'] == 1){
						$model_feature_id->value = 1;
					}else{
						$model_feature_id->value = 0;
					}
					$model_feature_id->save();
				}else{
					$model_feature_id->value 	 = $_POST['LocationCustomfields']['value'];
					$model_feature_id->save();
				}
				
				
				Yii::app()->user->setFlash('success', '<i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i><strong> Success !</strong>Location updated Successfully.');
				$previousURL = explode('?', $_POST['Locations']['last_url']);
				$this->redirect(array('/locations?'.$previousURL[1]));
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
		//deleting data from jos_jev_customfields3 table for feature location
		$feature_loc_delete = LocationCustomfields::model()->findByAttributes(array('target_id'=>$id));
		if(isset($feature_loc_delete) AND $feature_loc_delete!=''){
				$feature_loc_delete->delete();
		}
		try{
		    $this->loadModel($id)->delete();
		    if(!isset($_GET['ajax']))
		        Yii::app()->user->setFlash('success','<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Location deleted successfully.');
		    else
		        echo '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Location deleted successfully.';
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
	/*	$dataProvider=new CActiveDataProvider('Locations');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));*/
		# CODE FOR SET PAGE SIZE START
		if ( isset( $_GET[ 'pageSize' ] ) )
		{
			Yii::app()->user->setState( 'pageSizeLocations', (int) $_GET[ 'pageSize' ] );
			unset( $_GET[ 'pageSize' ] );
		}
		# CODE FOR SET PAGE SIZE END
		$model=new Locations('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Locations']))
			$model->attributes=$_GET['Locations'];

		$this->render('index',array(
			'model'=>$model,
		));
		
		
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->redirect(array('/locations'));
		/*$model=new Locations('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Locations']))
			$model->attributes=$_GET['Locations'];

		$this->render('admin',array(
			'model'=>$model,
		));*/
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Locations the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Locations::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Locations $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='locations-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	/**
	* Function to change Location status from Active to Inactive and Vice versa
	* Developer: Yogi 
	*/	
	 public function actionUpdatestatus($id) {
		$newStatus = ($_REQUEST['status'] == 1)?0:1;
        $model = Locations::model()->findByPk($id);
        $model->published = $newStatus;
        $model->save();
		$this->redirect(array('/locations?'.$_REQUEST["query_url"]));
    }
	
	/**
	* Function to change Location status from Feature to unfeature and Vice versa
	* Developer: rinkal 
	*/	
	public function actionfeaturedstatus($id) {
		$newStatus = ($_REQUEST['status'] == 1)?0:1;
        $model_feature = LocationCustomfields::model()->findByAttributes(array('target_id'=>$id));
       	
		if(isset($model_feature) AND $model_feature!=''){
			$model_feature->value 	 = $newStatus;
			$model_feature->save();
	  	}else{
			$model_feature_locations = new LocationCustomfields;
			$model_feature_locations->target_id = $id;
			$model_feature_locations->name	 	='field5';
	    	$model_feature_locations->value 	= $newStatus;
			$model_feature_locations->save();
		}
		$this->redirect(array('/locations?'.$_REQUEST["query_url"]));
    }
	/**
	* Function To modify locaiton via CHECKBOX SELECTION
	* Developer: Yogi 
	*/
	public function actionAjaxupdate(){

		$act = $_GET['act'];
		if($act=='doSortOrder'){
		    $sortOrderAll = $_POST['sortOrder'];
		    if(count($sortOrderAll)>0){
		        foreach($sortOrderAll as $menuId=>$sortOrder){
		            $model=$this->loadModel($menuId);
		            $model->sortOrder = $sortOrder;
		            $model->save();
		        }
		    }
		}else{           
		    $autoIdAll = $_POST['autoId'];
		    if(count($autoIdAll)>0){
		        foreach($autoIdAll as $autoId){
		            $model=$this->loadModel($autoId);
		            if($act=='doDelete'){
						//deleting data from jos_jev_customfields3 table for feature location
						$feature_loc_delete = LocationCustomfields::model()->findByAttributes(array('target_id'=>$model->loc_id));
						if(isset($feature_loc_delete) AND $feature_loc_delete!=''){
								$feature_loc_delete->delete();
						}
						$model->delete();
						$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your Location deleted successfully.';
					}
		            if($act=='doActive'){
		                $model->published = '1';
						$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your Location published successfully.';					
					}
		            if($act=='doInactive'){
		                $model->published = '0';                     
						$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your Location unpublished successfully.';					
					}
		            if(!$model->save())
		            	throw new Exception("Sorry",500);

		        } //foreach loop
				echo $msg;
		    }
		}
	} // Ending Function
	
	
	
	/**
	* Function To modify locaiton via CHECKBOX SELECTION
	* Developer: Yogi 
	*/
	public function actionChangeStatus(){

		$newStatus = ($_GET['status'] == 1)?0:1;
        $model = Locations::model()->findByPk($_GET['id']);
        $model->published = $newStatus;
		if($model->save())
			echo 'ok';
		else
			throw new Exception("Sorry",500);
	} // Ending Function
	
	
	
}