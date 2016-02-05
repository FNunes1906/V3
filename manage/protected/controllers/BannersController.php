<?php

class BannersController extends Controller
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
				'actions'=>array('index','view','updatestatus','ajaxupdate','changestatus'),
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
		$model = new Banners;
		
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Banners']))
		{
			$model->attributes	= $_POST['Banners'];
			
			# This will give uploded file name
			$uploadedFile = CUploadedFile::getInstance($model,'imageurl');
			
			# Rename Uploded image file name with current timestamp
			$temp = explode(".",  $uploadedFile);
			$fileName = round(microtime(true)) .$temp[0]. '.' . end($temp);
			
			# Assign filename to model Image object
			$model->imageurl = $fileName;
			
			$model->alias = strtolower(str_replace(" ","-",$_POST['Banners']['name']));
			
			if($model->save()){
				
				# Image Upload condition and code by Yogi
				if(!empty($uploadedFile)){
					# Set ORIGINAL image path
					$originalImagePath	= Yii::app()->basePath.'/../../partner/'.Yii::app()->db->tablePrefix.'/images/banners/'.$fileName;
					
					# this will save ORIGINAL image
					$uploadedFile->saveAs($originalImagePath,true);
				}
				
				Yii::app()->user->setFlash('success', '<i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i><strong>Success!</strong> Your Banner added Successfully.');			
				$this->redirect(array('/banners'));
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

		if(isset($_POST['Banners']))
		{
			
			# This will give uploded file name
			$uploadedFile = CUploadedFile::getInstance($model,'imageurl');
			$old_file_name = $model->imageurl;

			# Assign filename to model Image object
			if(isset($uploadedFile) && $uploadedFile != ''){
				
				# Assigning Post data to attribute array of class
				$model->attributes = $_POST['Banners'];
				
				# Rename Uploded image file name with current timestamp
				$temp = explode(".", $uploadedFile);
				$fileName = round(microtime(true)) .$temp[0]. '.' . end($temp);
				
				$model->imageurl = $fileName;
			}else{
				$_POST['Banners']['imageurl'] = $model->imageurl;
				# Assigning Post data to attribute array of class
				$model->attributes = $_POST['Banners'];
			}
			
			$model->alias = strtolower(str_replace(" ","-",$_POST['Banners']['name']));

			if($model->save()){
				
				if(!empty($uploadedFile)){
					
					# Set ORIGINAL image path
					$originalImagePath	= Yii::app()->basePath.'/../../partner/'.Yii::app()->db->tablePrefix.'/images/banners/'.$fileName;
					
					# this will save ORIGINAL image
					$uploadedFile->saveAs($originalImagePath,false);
					
					# Remove OLD FILE from SERVER via Delete Function
					if($old_file_name != ''){
						$this->deleteMyAssociatedImage($old_file_name);
					}
				}else{
					$model->updateByPk($id, array('imageurl' => $old_file_name,));
				}
				
				
				
				Yii::app()->user->setFlash('success', '<i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i><strong>Success!</strong> Your Banner updated Successfully.');
				$this->redirect(array('/banners'));
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
		try{
		    $this->loadModel($id)->delete();
		    if(!isset($_GET['ajax']))
		        Yii::app()->user->setFlash('success','<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your banner deleted successfully.');
		    else
		        echo '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your banner deleted successfully.';
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
		/*$dataProvider=new CActiveDataProvider('Banners');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));*/
		
		$model=new Banners('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Banners']))
			$model->attributes=$_GET['Banners'];

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
		/*$model=new Banners('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Banners']))
			$model->attributes=$_GET['Banners'];

		$this->render('admin',array(
			'model'=>$model,
		));*/
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Banners the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Banners::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Banners $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='banners-form')
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
	 	$model = $this->loadModel($id);
		$model->updateByPk($id, array('showBanner' => $newStatus));
		$this->redirect(array('/banners'));
    }
	
	/**
	* Function To modify locaiton via CHECKBOX SELECTION
	* Developer: rinkal 
	*/
	public function actionAjaxupdate(){

		$act = $_GET['act'];
		if($act=='doSortOrder'){
		    $sortOrderAll = $_POST['ordering'];
		    if(count($sortOrderAll)>0){
		        foreach($sortOrderAll as $bid=>$ordering){
		            $model = $this->loadModel($bid);
		            $model->ordering = $ordering;
		            //$model->save();
		            $model->updateByPk($bid, array('ordering' => $ordering));
		        }
		        $msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> New order set successfully.';
		    }
		}else{           
		    $autoIdAll = $_POST['autoId'];
		    if(count($autoIdAll)>0){
		        foreach($autoIdAll as $autoId){
		            $model = $this->loadModel($autoId);
		            if($act == 'doDelete'){
						$model->delete();
						$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your banner deleted successfully.';
					}
		            if($act == 'doActive'){
						$model->showBanner = '1';
						$model->updateByPk($autoId, array('showBanner' => 1));
						$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your banner published successfully.';
					}
		            if($act == 'doInactive'){
						$model->showBanner = '0';
						$model->updateByPk($autoId, array('showBanner' => 0));
						$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your banner unpublished successfully.';
					}
		            /*if(!$model->save()){throw new Exception("Sorry",500);}*/
		        }
		    }
		}
		echo $msg;
	} // Ending Function
	
	
	
	/**
	* Function To modify locaiton via CHECKBOX SELECTION
	* Developer: rinkal 
	*/
	public function actionChangeStatus(){

		$newStatus = ($_GET['status'] == 1)?0:1;
        $model = Locations::model()->findByPk($_GET['id']);
        $model->showBanner = $newStatus;
		if($model->save())
			echo 'ok';
		else
			throw new Exception("Sorry",500);
	} // Ending Function


# Function to UNLINK image from server
	public function deleteMyAssociatedImage($img_to_unlink) {
		if(file_exists(Yii::app()->basePath.'/../../partner/'.Yii::app()->db->tablePrefix.'/images/banners/'.$img_to_unlink)) {
			unlink(Yii::app()->basePath.'/../../partner/'.Yii::app()->db->tablePrefix.'/images/banners/'.$img_to_unlink);
		} else {
			return true;
		}
    }


}
