<?php

class TemplatesController extends Controller
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
				'actions'=>array('index','view','ajaxupdate','languages','langupdate'),
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
		$model=new Templates;
		
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

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new Templates('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Templates']))
			$model->attributes=$_GET['Templates'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
	
	public function actionLanguages()
	{
		/*$model=new Templates('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Templates']))
			$model->attributes=$_GET['Templates'];*/

		$this->render('languages');
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Contents the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Contents::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	
	/**
	* Function to make template default
	* Developer: rinkal 
	*/	
	public function actionAjaxupdate(){
		$model=new Templates;
		$act = $_GET['act'];
	    $template = $_POST['template'];
        if($act=='doActive'){
			$def = $model->findByAttributes(array('client_id'=>0));
	        if(isset($def)){
				$def->delete();
				$model->template=$template;
				if($model->save()){
					echo "ok";
				}else{
					echo "Not Saved";
				}
			}
		}else
            throw new Exception("Sorry",500);

	} // Ending Function
	
	/**
	* Function to make Language default
	* Developer: rinkal 
	*/	
	public function actionLangupdate(){
		//$model=new Components;
		$act = $_GET['act'];
	    $language = $_POST['language'];
        if($act=='doActive'){
			$model = Components::model()->findByAttributes(array('option'=>'com_languages'));
	        if(isset($model)){
				$model->params='administrator=en-GB
site='.$language.'

';
				if($model->save()){
					echo "ok";
				}else{
					echo "no";
				}
			}
		}else
            throw new Exception("Sorry",500);

	}
	
	
	

}