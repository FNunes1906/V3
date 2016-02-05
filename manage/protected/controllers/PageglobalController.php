<?php

class PageglobalController extends Controller
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
		$model=new Pageglobal;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Pageglobal']))
		{
			$model->attributes=$_POST['Pageglobal'];
			if($model->save())
				$this->redirect(array('index','id'=>$model->id));
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
		$this->performAjaxValidation($model);

		if(isset($_POST['Pageglobal']))
		{
			
			$model->attributes =  $_POST['Pageglobal'];
			
			if($model->save()){
			
				if(isset($_POST['Menu']['home']) and $_POST['Menu']['home']!=''){
						$menu_id = Menu::model()->findByAttributes(array('home'=>1));
						if(isset($menu_id) && $menu_id!=''){
							$menu_id->home=0;
							$menu_id->save();
							$default_id = Menu::model()->findByAttributes(array('id'=>$_POST['Menu']['home']));
							$default_id->home = 1;
							$default_id->save();
						}
				}
			
				$default_template = Templates::model()->findByAttributes(array('client_id'=>0));
				if(isset($default_template)){
					$default_template->template=$_POST['Templates']['template'];
					$default_template->save();
				}
				
				# This will give uploded file name
				$upload_logo = CUploadedFile::getInstanceByName('Pageglobal[logo]');

				if(isset($upload_logo) OR $upload_logo!='')
				{
					#Storing logo in partner/partnerfoldername/images/logo
					$logo_url = Yii::app()->basePath.'/../../partner/'.Yii::app()->db->tablePrefix.'/images/logo/logo.png';
					# this will save logo image
					$upload_logo->saveAs($logo_url);
					$upload_logo = Yii::app()->image->load($logo_url);
                    $upload_logo->resize(196,120);
					$upload_logo->save();
				}
				
				Yii::app()->user->setFlash('success', '<i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i><strong>Success!</strong> Your site settings updated Successfully.');
				$this->redirect(array('update','id'=>$model->id));
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		/*$dataProvider=new CActiveDataProvider('Pageglobal');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));*/
		
		$model=new Pageglobal('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Pageglobal']))
			$model->attributes=$_GET['Pageglobal'];

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
		/*$model=new Pageglobal('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Pageglobal']))
			$model->attributes=$_GET['Pageglobal'];

		$this->render('admin',array(
			'model'=>$model,
		));*/
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Pageglobal the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Pageglobal::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Pageglobal $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='pageglobal-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
