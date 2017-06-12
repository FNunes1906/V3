<?php

class SectionsController extends Controller
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
				'actions'=>array('index','view','updatestatus','ajaxupdate','findchildren'),
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
		$model = new Sections;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Sections'])){
		
			$model->attributes=$_POST['Sections'];
			$model->alias = strtolower($_POST['Sections']['title']);
			
			$parentCatId = explode('cat_id=',$_POST['Sections']['last_url']);

			if($model->save())
			{
				$model_categories = new Categories;
   				$model_categories->parent_id 		= isset($parentCatId[1])?$parentCatId[1]:0;
   				$model_categories->title 			= $model->title;
   				$model_categories->alias 			= $model->title;
   				$model_categories->section 			= $model->id;
   				$model_categories->image_position 	= 'left';
   				$model_categories->published 		= $model->published;
				$model_categories->save();
				Yii::app()->user->setFlash('success', '<i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i><strong>Success!</strong> Your Category added Successfully.');
				//$pre_url_sep = explode('?', $_POST['Sections']['last_url']);
				$this->redirect($_POST['Sections']['last_url']);
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Sections'])){
			$parentCatId = explode('cat_id=',$_POST['Sections']['last_url']);
			$model_categories = Categories::model()->findByAttributes(array('section'=>$model->id));
			
			$model->attributes = $_POST['Sections'];
			$model->alias = strtolower($_POST['Sections']['title']);
			if($_POST['Sections']['published'] == '0'){
				if(isset($model_categories) AND $model_categories!=''){
					if($this->actionFindChildren($model_categories->id)){
						Yii::app()->user->setFlash('success','<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true"></span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Sorry!</strong> Your Can not Unpublished Category Assigned to Menu.');
					}else{
						if($model->save()){
							Yii::app()->user->setFlash('success', '<i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i><strong>&nbsp; Success!</strong> Your Category updated successfully.');
						}
					}
				}
			}else{
				if($model->save()){
					if(isset($model_categories) AND $model_categories!=''){
						$model_categories->parent_id 		= isset($parentCatId[1])?$parentCatId[1]:0;
		   				$model_categories->title 			= $model->title;
		   				$model_categories->alias 			= $model->title;
		   				$model_categories->section 			= $model->id;
		   				$model_categories->image_position 	= 'left';
		   				$model_categories->published 		= $model->published;
						$model_categories->save();
					}
	   				
					Yii::app()->user->setFlash('success', '<i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i><strong>&nbsp; Success!</strong> Your Category updated successfully.');
					//$this->redirect(array('/sections'));
				}
			}
			$pre_url_sep = explode('?', $_POST['Sections']['last_url']);
			$this->redirect(array('/sections?'.$pre_url_sep[1]));
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
		# Get category of section from category table
		$model_categories = Categories::model()->findByAttributes(array('section'=>$id));
		
		# check if category is assigned to menu or now if yes then do not allow to delete
		if((isset($_REQUEST['cat_id'])) && ($_REQUEST['cat_id'] ==  $model_categories->id)){
			echo '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Sorry!</strong> Your Can not remove Category Assigned to Menu.';
		}else{
			# Delete category entry from jos_categories table
			if(isset($model_categories) AND $model_categories!=''){
				$model_categories->delete();
			}
			
			# Delete category entry from jos_sections table
			try{
				$this->loadModel($id)->delete();
				if(!isset($_GET['ajax']))
					Yii::app()->user->setFlash('success','<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your Category deleted successfully.');
				else
					echo '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your Category deleted successfully.';
			}catch(CDbException $e){
				if(!isset($_GET['ajax']))
					Yii::app()->user->setFlash('error','Normal - error message');
				else
					echo "<div class='flash-error'>Ajax - error message</div>"; //for ajax
			}
		}

		# if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model = new Sections('search');
		
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['Sections']))
			$model->attributes = $_GET['Sections'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->redirect(array('/sections'));	
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Sections the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Sections::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Sections $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='sections-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionUpdatestatus($id) {
		$newStatus = ($_REQUEST['status'] == 1)?0:1;
		$model = Sections::model()->findByAttributes(array('id'=>$id));
        # Code to unpublish/Publish category in jos_categories table
		$model_categories = Categories::model()->findByAttributes(array('section'=>$id));
		
		# code for unpublish
		if(isset($model_categories) AND $model_categories != ''){
			$model->published = $newStatus;
			$model_categories->published = $newStatus;

			if($newStatus == 0){
				if($this->actionFindChildren($model_categories->id)){
					Yii::app()->user->setFlash('success','<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true"></span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Sorry!</strong> Your Can not Unpublished Category Assigned to Menu.');
				}else{
					$model->save();
					Yii::app()->user->setFlash('success','<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true"></span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong>Category Unpublished Successfully!');
				}
				
			}else{
				if($model_categories->id == $_REQUEST['cat_id']){
					Yii::app()->user->setFlash('success','<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true"></span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Sorry!</strong> Your Can not Unpublished Category Assigned to Menu.');
				}else{
					# unpublish/Publish category in jos_category table
					$model_categories->save();
					
					# Code to unpublish/Publish category in jos_sections table
					$model->save();
			        
			        if($newStatus == 1)
			        	Yii::app()->user->setFlash('success','<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true"></span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong>Category Published Successfully!');
			        else
			        	Yii::app()->user->setFlash('success','<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true"></span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong>Category Unpublished Successfully!');
				}
			}
		}
		 
		# Redirect after status change
		$this->redirect(array('/sections?menu_id='.$_REQUEST['menu_id'].'&cat_id='.$_REQUEST['cat_id']));
    }
	
	public function actionAjaxupdate(){
		$success = FALSE;
		$act = $_GET['act'];
		if($act=='doSortOrder'){
		    $sortOrderAll = $_POST['ordering'];
		    if(count($sortOrderAll)>0){
		        foreach($sortOrderAll as $id=>$ordering){
		            $model=$this->loadModel($id);
		            $model->ordering = $ordering;
		            $model->save();
					//$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> New order set successfully.';
		        }
		    }
		}else{           
		    $autoIdAll = $_POST['autoId'];
		    if(count($autoIdAll)>0){
		        foreach($autoIdAll as $autoId){
		            $model=$this->loadModel($autoId);
		            if($act=='doDelete'){
						$model_categories = Categories::model()->findByAttributes(array('section'=>$model->id));
						if(isset($model_categories) AND $model_categories!=''){
							$model_categories->delete();
						}
						$model->delete();
						$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your Category deleted successfully.';
					}
		            if($act=='doActive'){
		                $model->published = '1';
						$model_categories = Categories::model()->findByAttributes(array('section'=>$model->id));
						if(isset($model_categories) AND $model_categories!=''){
							$model_categories->published = 1;
							$model_categories->save();
						}
						$model->save();
						
						$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your Category published successfully.';
					}
		            if($act=='doInactive'){
						$model->published = '0';  
						$model_categories = Categories::model()->findByAttributes(array('section'=>$model->id));
						if(isset($model_categories) AND $model_categories!=''){
							# CHECK IF ARTICLE ASSIGNED TO THIS CATEGORY OR NOT
							# IF YES THEN NOT ABLE TO UNPUBLISH
							if($this->actionFindChildren($model_categories->id)){
								$menuName = $model->title;
								$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-circle-exclamation-mark" style="color:#d9534f;font-size: 16px;"></i><span style="color:#d9534f;"><strong> Sorry!! </strong> Category(ies): '.$menuName.' cannot be removed as they contain Articles. There may currently be Articles within the Article Trash Manager which you must delete first..</span>';
							}else{
								/*$model_categories->published = 0;
								$model_categories->save();*/
								$model->save();
								$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your Category unpublished successfully.';
							}
						}
						
					}
					
		            /*if($model->save())
		                echo '';
		            else
		                throw new Exception("Sorry",500);*/

		        }
				echo $msg;
		    }
		}
		
	} // Ending Function
	
	/**
	* check category if it has child article or not
	* @param int $id
	* @param int $level
	* 
	* @return bool true if child else false
	*/
	public function actionFindChildren($id,$level = 0)
	{
		$return = FALSE;
		if((int)$level > 0){
			$return = true;
		}
		if((int)$level == 0){
			$criteria = new CDbCriteria;
	        $criteria->condition='catid=:id';
	        $criteria->params=array(':id'=>$id);
	        $model = Contents::model()->findAll($criteria);
			foreach ($model as $key) {
				$return = $this->actionFindChildren($key->id, (int)$level+1);
			}
		}
		return $return;
	}

}
