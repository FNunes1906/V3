<?php

class GalleriesController extends Controller
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
				'actions'=>array('index','view','updatestatus','approvedstatus','ajaxupdate','changestatus'),
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
		$model = new Galleries;
		$model->published = 1;
		$model->approved = 1;
		
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Galleries']))
		{
			# Assigning Post data to attribute array of class
			$model->attributes = $_POST['Galleries'];
			
			# This will give uploded file name
			$uploadedFile = CUploadedFile::getInstance($model,'filename');
		
			# Rename Uploded image file name with current timestamp
			$temp = explode(".", $uploadedFile);
			$fileName = round(microtime(true)) .$temp[0]. '.' . end($temp);
			
			# Assign filename to model Image object
			$model->filename 	= $fileName;
			//$fileName = $uploadedFile;
			
			# Assign DATE FORMAT 2010-11-18 18:26:28
			$model->date 	= date("Y-m-d h:i:s");
			
			# Assign alias
			// Remove any white space in title
			$aliasTitle = preg_replace('/\s+/', '', $_POST['Galleries']['title']);
			$model->alias  	= strtolower($aliasTitle);  // Assigin title to alias in lower case
			
			# Assign meta description
			//$model->metadesc 	= "a:3:{s:8:"username";s:0:"";s:8:"location";s:0:"";s:15:"metadescription";s:0:"";}"		
			
			# Assign Image Original size
			//$model->imgorigsize 	= '1111';
			
			if($model->save()){
				
				# Image Upload condition and code by Yogi
				if(!empty($uploadedFile)){
					
					# Set ORIGINAL image path
					$originalImagePath	= Yii::app()->basePath.'/../../partner/'.Yii::app()->db->tablePrefix.'/images/phocagallery/'.$fileName;
					
					# Set SMALL IMAGE PATH
					$s_img_path = Yii::app()->basePath.'/../../partner/'.Yii::app()->db->tablePrefix.'/images/phocagallery/thumbs/phoca_thumb_s_'.$fileName;
					
					# Set MEDIUM IMAGE PATH
					$m_img_path = Yii::app()->basePath.'/../../partner/'.Yii::app()->db->tablePrefix.'/images/phocagallery/thumbs/phoca_thumb_m_'.$fileName;
					# Set LARGE IMAGE PATH
					$l_img_path = Yii::app()->basePath.'/../../partner/'.Yii::app()->db->tablePrefix.'/images/phocagallery/thumbs/phoca_thumb_l_'.$fileName;
				
					# this will save ORIGINAL image
					$uploadedFile->saveAs($originalImagePath,false);
					
					# This will create and save SMALL thumbnail image
					if($uploadedFile->saveAs($s_img_path,false)){
                       
					   # This code will load thumbnail then Resize it and then save it
					   $thumbnail = Yii::app()->image->load($s_img_path);
                       $thumbnail->resize(120, 80);
                       $thumbnail->save();
					   //$thumbnail->resize(400, 100)->rotate(-45)->quality(75)->sharpen(20);
					}
					
					# This will create and save MEDIUM thumbnail image
					if($uploadedFile->saveAs($m_img_path,false)){
                       
					   # This code will load thumbnail then Resize it and then save it
					   $thumbnail = Yii::app()->image->load($m_img_path);
                       $thumbnail->resize(180, 150);
                       $thumbnail->save();
					   //$thumbnail->resize(400, 100)->rotate(-45)->quality(75)->sharpen(20);
					}
					
					# This will create and save LARGE thumbnail image
					if($uploadedFile->saveAs($l_img_path,false)){
                       
					   # This code will load thumbnail then Resize it and then save it
					   $thumbnail = Yii::app()->image->load($l_img_path);
                       $thumbnail->resize(640, 480);
                       $thumbnail->save();
					   //$thumbnail->resize(400, 100)->rotate(-45)->quality(75)->sharpen(20);
					}
				}
				
				Yii::app()->user->setFlash('success', '<i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i><strong>Success!</strong> Image added Successfully.');
				# Redirect to Galleries/index page after insert operation				
				$pre_url_sep = explode('?', $_POST['Galleries']['last_url']);
				$this->redirect(array('/galleries?'.$pre_url_sep[1]));
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
		//$model->scenario = 'update';

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Galleries'])){
			
			# This will give uploded file name
			$uploadedFile = CUploadedFile::getInstance($model,'filename');
			$old_file_name = $model->filename;
			
			# Assign filename to model Image object
			if(isset($uploadedFile) && $uploadedFile != ''){
				
				# Assigning Post data to attribute array of class
				$model->attributes = $_POST['Galleries'];
				
				# Rename Uploded image file name with current timestamp
				$temp = explode(".", $uploadedFile);
				$fileName = round(microtime(true)) .$temp[0]. '.' . end($temp);
				
				$model->filename = $fileName;
			}
			else{
				$_POST['Galleries']['filename'] = $model->filename;
				# Assigning Post data to attribute array of class
				$model->attributes = $_POST['Galleries'];
				
			}
			
			# Assign alias & Remove any white space in title
			$aliasTitle = preg_replace('/\s+/', '', $_POST['Galleries']['title']);
			$model->alias  	= strtolower($aliasTitle);  // Assigin title to alias in lower case

			
			//var_dump($uploadedFile);exit;
			if($model->save()){
			
				# Image Upload condition and code by Yogi
				if(!empty($uploadedFile)){
					
					# Set ORIGINAL image path
					$originalImagePath	= Yii::app()->basePath.'/../../partner/'.Yii::app()->db->tablePrefix.'/images/phocagallery/'.$fileName;
					
					# Set SMALL IMAGE PATH
					$smallImagePath = Yii::app()->basePath.'/../../partner/'.Yii::app()->db->tablePrefix.'/images/phocagallery/thumbs/phoca_thumb_s_'.$fileName;
					# Set MEDIUM IMAGE PATH
					$mediumImagePath = Yii::app()->basePath.'/../../partner/'.Yii::app()->db->tablePrefix.'/images/phocagallery/thumbs/phoca_thumb_m_'.$fileName;
					# Set LARGE IMAGE PATH
					$largeImagePath = Yii::app()->basePath.'/../../partner/'.Yii::app()->db->tablePrefix.'/images/phocagallery/thumbs/phoca_thumb_l_'.$fileName;
					
				
					# this will save ORIGINAL image
					$uploadedFile->saveAs($originalImagePath,false);
					
					# This will create and save SMALL thumbnail image
					if($uploadedFile->saveAs($smallImagePath,false)){
                       
					   # This code will load thumbnail then Resize it and then save it
					   $thumbnail = Yii::app()->image->load($smallImagePath);
                       $thumbnail->resize(120, 80);
					   //$thumbnail->resize(400, 100)->rotate(-45)->quality(75)->sharpen(20);
                       $thumbnail->save();
					}
					
					# This will create and save MEDIUM thumbnail image
					if($uploadedFile->saveAs($mediumImagePath,false)){
                       
					   # This code will load thumbnail then Resize it and then save it
					   $thumbnail = Yii::app()->image->load($mediumImagePath);
                       $thumbnail->resize(180, 150);
					   //$thumbnail->resize(400, 100)->rotate(-45)->quality(75)->sharpen(20);
                       $thumbnail->save();
					}
					
					# This will create and save LARGE thumbnail image
					if($uploadedFile->saveAs($largeImagePath,false)){
                       
					   # This code will load thumbnail then Resize it and then save it
					   $thumbnail = Yii::app()->image->load($largeImagePath);
                       $thumbnail->resize(640, 480);
					   //$thumbnail->resize(400, 100)->rotate(-45)->quality(75)->sharpen(20);
                       $thumbnail->save();
					}
					
					# Remove OLD FILE from SERVER via Delete Function
					if($old_file_name != ''){
						$this->deleteMyAssociatedImage($old_file_name);
					}
				}else{
					$model->updateByPk($id, array('filename' => $old_file_name,));
				}
				
				
				Yii::app()->user->setFlash('success', '<i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i><strong>Success!</strong> Image Updated Successfully.');
				# Redirect to Galleries/index page after insert operation				
				$pre_url_sep = explode('?', $_POST['Galleries']['last_url']);
				$this->redirect(array('/galleries?'.$pre_url_sep[1]));
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
		    //$this->loadModel($id)->delete();
		
			$model = $this->loadModel($id);
			// then, delete using a function:
			$this->deleteMyAssociatedImage($model->filename);
			$model->delete();
	
			
		    if(!isset($_GET['ajax']))
		        Yii::app()->user->setFlash('success','<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your photo deleted successfully.');
		    else
		        echo '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your photo deleted successfully.';
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
		/*$dataProvider=new CActiveDataProvider('Galleries');
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
		
		$model=new Galleries('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Galleries']))
			$model->attributes=$_GET['Galleries'];

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
		/*$model=new Galleries('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Galleries']))
			$model->attributes=$_GET['Galleries'];

		$this->render('admin',array(
			'model'=>$model,
		));*/
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Galleries the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Galleries::model()->findByPk($id);
		if($model === null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Galleries $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='galleries-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	 public function actionUpdatestatus($id) {
		$newStatus = ($_REQUEST['published'] == 1)?0:1;
		Galleries::model()->updateByPk($id, array('published' => $newStatus,));
		$this->redirect(array('/galleries?'.$_REQUEST["query_url"]));
		//$this->redirect(array('/galleries'));
    }
	
	public function actionApprovedstatus($id) {
		$newStatus = ($_REQUEST['approved'] == 1)?0:1;
		Galleries::model()->updateByPk($id, array('approved' => $newStatus,));
		$this->redirect(array('/galleries?'.$_REQUEST["query_url"]));
		//$this->redirect(array('/galleries'));
    }
	
	# Function to UNLINK image from server
	public function deleteMyAssociatedImage($img_to_unlink) {
		if(file_exists(Yii::app()->basePath.'/../../partner/'.Yii::app()->db->tablePrefix.'/images/phocagallery/'.$img_to_unlink)) {
			unlink(Yii::app()->basePath.'/../../partner/'.Yii::app()->db->tablePrefix.'/images/phocagallery/'.$img_to_unlink);
			unlink(Yii::app()->basePath.'/../../partner/'.Yii::app()->db->tablePrefix.'/images/phocagallery/thumbs/phoca_thumb_s_'.$img_to_unlink);
			unlink(Yii::app()->basePath.'/../../partner/'.Yii::app()->db->tablePrefix.'/images/phocagallery/thumbs/phoca_thumb_m_'.$img_to_unlink);
			unlink(Yii::app()->basePath.'/../../partner/'.Yii::app()->db->tablePrefix.'/images/phocagallery/thumbs/phoca_thumb_l_'.$img_to_unlink);	
		} else {
			return true;
		}
	
    }
	
	
	
	/**
	* Function To modify galleru via CHECKBOX SELECTION
	* Developer: rinkal 
	*/
	public function actionAjaxupdate(){

		$act = $_GET['act'];
		if($act=='doSortOrder'){
		    $sortOrderAll = $_POST['ordering'];
		    if(count($sortOrderAll)>0){
		        foreach($sortOrderAll as $id=>$ordering){
		            $model=$this->loadModel($id);
		            $model->ordering = $ordering;
		            $model->save();
					$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> New order set successfully.';
		        }
		    }
		}else{           
		    $autoIdAll = $_POST['autoId'];
		    if(count($autoIdAll)>0){
		        foreach($autoIdAll as $autoId){
		            $model=$this->loadModel($autoId);
					if($act=='doDelete'){	
						// then, delete using a function:
						if($model->filename != ''){
							$this->deleteMyAssociatedImage($model->filename);
						}
						$model->delete();
						$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your photo deleted successfully.';
					}
		            if($act=='doActive'){
						//$model->published = '1';
						$model->updateByPk($autoId, array('published' => '1',));
						$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your photo published successfully.';
					}		
		            if($act=='doInactive')	{
						//$model->published = '0';
						$model->updateByPk($autoId, array('published' => '0',));                     
						$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your photo unpublished successfully.';
					}	
		            if($act=='doAuthorize')	{
						//$model->approved = '1';
						$model->updateByPk($autoId, array('approved' => '1',));                      
						$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your photo authorized successfully.';
					}	
		            if($act=='doUnauthorize'){
						//$model->approved = '0';
						$model->updateByPk($autoId, array('approved' => '0',));                     
						$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your photo unauthorized successfully.';
					}	
		            /*if($model->save())
		                echo '';
		            else
		                throw new Exception("Sorry",500);*/

		        }
		    }
		}
		echo $msg;
	} // Ending Function
}
