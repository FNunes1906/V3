<?php

class ContentsController extends Controller
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
				'actions'=>array('index','view','front','updatestatus','frontstatus','frontupdatestatus','ajaxupdate','articlecat'),
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
		$model = new Contents;
		$model->state = 1;
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
		
		if(isset($_POST['Contents'])){
			
			$pattern = '#<hr\s+id=("|\')system-readmore("|\')\s*\/*>#i';
			$tagPos	= preg_match($pattern, $_POST['Contents']['introtext']);
			if ($tagPos == 0 )
			{
				$_POST['Contents']['introtext']	= $_POST['Contents']['introtext'];
			}else{
				
				list($_POST['Contents']['introtext'],$_POST['Contents']['fulltext']) = preg_split($pattern,$_POST['Contents']['introtext'], 2);
			}
			$model->attributes = $_POST['Contents'];
			if(isset($_POST['Contents']['fulltext']) AND $_POST['Contents']['fulltext']!='')
			{
				$model->fulltext   = $_POST['Contents']['fulltext'];
			}else{
				$model->fulltext   = '';
			}
			
			if(isset($_POST['Contents']['sectionid']) AND $_POST['Contents']['sectionid']!='')
				{
					$model_categories = Categories::model()->findByAttributes(array('section'=>$model->sectionid));
					if(isset($model_categories) AND $model_categories!=''){
		   				$model->catid = $model_categories->id;
						//$model->save();
					}
			}
			
			
			
			if($model->save()){
				
				$model_frontpage = new Frontpage;
				if($_POST['Frontpage']['content_id']==1)
				{
       				$model_frontpage->content_id = $model->id;
					$model_frontpage->save();
				}
				
				 Yii::app()->user->setFlash('success', '<i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i><strong>Success!</strong> Your Article added Successfully.');
                //$this->redirect(array('index', 'id' => $model->id));
				$pre_url_sep = explode('?', $_POST['Contents']['last_url']);
				
				if(isset($_REQUEST['front']) && $_REQUEST['front'] == 1)
					$this->redirect(array('/contents/front?menu_id='.$_REQUEST["menu_id"]));
				else
					$this->redirect(array('/contents?'.$pre_url_sep[1]));
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
		
		if(isset($_POST['Contents']))
		{
			$pattern = '#<hr\s+id=("|\')system-readmore("|\')\s*\/*>#i';
			$tagPos	= preg_match($pattern, $_POST['Contents']['introtext']);
			if ($tagPos == 0 )
			{
				$_POST['Contents']['introtext']	= $_POST['Contents']['introtext'];
				$_POST['Contents']['fulltext'] = '';
			}else{
				
				list($_POST['Contents']['introtext'],$_POST['Contents']['fulltext']) = preg_split($pattern,$_POST['Contents']['introtext'], 2);
			}
			$model->attributes = $_POST['Contents'];
			if(isset($_POST['Contents']['fulltext']) AND $_POST['Contents']['fulltext']!='')
			{
				$model->fulltext   = $_POST['Contents']['fulltext'];
			}else{
				$model->fulltext   = '';
			}
			
			if(isset($_POST['Contents']['sectionid']) AND $_POST['Contents']['sectionid']!='')
			{
				$model_categories = Categories::model()->findByAttributes(array('section'=>$model->sectionid));
				if(isset($model_categories) AND $model_categories!=''){
	   				$model->catid = $model_categories->id;
					$model->save();
				}
			}
			if($model->save()){
				$model_frontpage = new Frontpage;
				if($_POST['Frontpage']['content_id']==1)
				{
					$cid = Frontpage::model()->findByAttributes(array('content_id'=>$model->id));
					if(empty($cid) AND $cid==''){
						$model_frontpage->content_id = $model->id;
						$model_frontpage->save();
					}
				}else{
					$cid = Frontpage::model()->findByAttributes(array('content_id'=>$model->id));
					if(isset($cid) AND $cid!=''){
						$cid->delete();
					}
				}
				
				Yii::app()->user->setFlash('success', '<i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i><strong>&nbsp; Success!</strong> Your Article updated successfully.');
				$pre_url_sep = explode('?', $_POST['Contents']['last_url']);
				/*$this->redirect(array('/contents?'.$pre_url_sep[1]));*/
				
				if(isset($_REQUEST['front']) && $_REQUEST['front'] == 1)
					$this->redirect(array('/contents/front?menu_id='.$_REQUEST["menu_id"]));
				else
					$this->redirect(array('/contents?'.$pre_url_sep[1]));
				
				
				
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
		        Yii::app()->user->setFlash('success','<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your article deleted successfully.');
		    else
		        echo '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your article deleted successfully.';
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
		/*$dataProvider=new CActiveDataProvider('Contents');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));*/
		

		$model=new Contents('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Contents']))
			$model->attributes=$_GET['Contents'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
	
	public function actionFront()
	{
		# CODE FOR SET PAGE SIZE START
		if ( isset( $_GET[ 'pageSize' ] ) )
		{
			Yii::app()->user->setState( 'pageSize', (int) $_GET[ 'pageSize' ] );
			unset( $_GET[ 'pageSize' ] );
		}
		# CODE FOR SET PAGE SIZE END

		$model=new Contents('searchFront');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Contents']))
			$model->attributes=$_GET['Contents'];

		$this->render('front',array(
			'model'=>$model,
		));
	}

	public function actionArticlecat()
	{
		$model=new Contents('searchFront');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Contents']))
			$model->attributes=$_GET['Contents'];

		$this->render('articlecat',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->redirect(array('index'));
		/*$model=new Contents('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Contents']))
			$model->attributes=$_GET['Contents'];

		$this->render('admin',array(
			'model'=>$model,
		));*/
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
	 * Performs the AJAX validation.
	 * @param Contents $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='contents-form')
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
        $model = Contents::model()->findByPk($id);
        $model->state = $newStatus;
        $model->save();
		$this->redirect(array('/contents?'.$_REQUEST["query_url"]));
    }
	
	public function actionFrontupdatestatus($id) {
		$newStatus = ($_REQUEST['status'] == 1)?0:1;
        $model = Contents::model()->findByPk($id);
        $model->state = $newStatus;
        $model->save();
        $this->redirect(array('/contents/front?'.$_REQUEST["query_url"]));
		//$this->redirect(array('contents/front'));
    }
	
	public function actionFrontstatus($id) {
		$model_frontpage = new Frontpage;
		if($_REQUEST['status'] == 1)
        {
			$cid = Frontpage::model()->findByAttributes(array('content_id'=>$id));
			$cid->delete();
		}else{
			$model_frontpage->content_id = $id;
        	$model_frontpage->save();
		}
		$this->redirect(array('/contents?'.$_REQUEST["query_url"]));
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
		        foreach($sortOrderAll as $id=>$ordering){
		            $model=$this->loadModel($id);
		            $model->ordering = $ordering;
		            $model->save();
					$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> New order set successfully.';
		        }
		    }
		}else if($act=='doSortOrderfront'){
		    $sortOrderAll = $_POST['ordering'];
		    if(count($sortOrderAll)>0){
		        foreach($sortOrderAll as $id=>$ordering){
					$front_order = Frontpage::model()->findByAttributes(array('content_id'=>$id));
		           	$front_order->ordering = $ordering;
					$front_order->save();
				   	$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> New order set successfully.';
		        }
		    }
		}else{           
		    $autoIdAll = $_POST['autoId'];
		    if(count($autoIdAll)>0){
		        foreach($autoIdAll as $autoId){
		            $model=$this->loadModel($autoId);
		            if($act=='doDelete'){
						$model->delete();
						$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your article deleted successfully.';
					}
					if($act=='doDeletefront')
					{
						$cid = Frontpage::model()->findByAttributes(array('content_id'=>$autoId));
						$cid->delete();
						$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your article deleted successfully.';
					}
		            if($act=='doActive'){
		                $model->state = '1';
						$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your article published successfully.';
					}
		            if($act=='doInactive'){
						$model->state = '0'; 
						$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your article unpublished successfully.';
					}
		                                   
		            if($model->save())
		                echo '';
		            else
		                throw new Exception("Sorry",500);
		        }
				
		    }
		}
		echo $msg;
	} // Ending Function
	

}