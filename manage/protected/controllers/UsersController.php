<?php

class UsersController extends Controller
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
				'actions'=>array('index','view','updatestatus','ajaxupdate'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('@'),
				//'users'=>array('admin'),
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
	 * Creates a new model. Below function will create a user
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model			 = new Users;
		$model->scenario = 'createuser';

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);
		
		if(isset($_POST['Users'])){
		
			# Password Encryption process started
			if($_POST['Users']['password'] && $_POST['Users']['password'] != ''){
					# Password Encryption process by Yogi START
					$salt  = $this->genRandomPassword(32);
					
					// Get password crypt
					$crypt = $this->getCryptedPassword($_POST['Users']['password'], $salt);
					$_POST['Users']['password'] = $crypt.':'.$salt;
					
					// Get verify password crypt
					$cryptverifypass = $this->getCryptedPassword($_POST['Users']['verifyPassword'], $salt);
					$_POST['Users']['verifyPassword'] = $cryptverifypass.':'.$salt;
					# Password Encryption process by Yogi End
			}
		
			# Code to get User Group ID
			//$gid = Usergroups::model()->findByAttributes(array('name'=>$_POST['Users']['usertype']));
			//$_POST['Users']['gid']	= $gid['id'];
			$_POST['Users']['gid']	= 31; // Assigning TW_Admin user type by default TW_Admin
			$_POST['Users']['usertype'] = 'TW_Admin';
			
			$model->attributes	= $_POST['Users'];
			$model->params		= 'admin_language=en-GB
language=
editor=jce
helpsite=
timezone=0';
			
			if($_POST['Users']['password'] == $_POST['Users']['verifyPassword']){
				
				if($model->save()){
					# Get Current inserted USer ID
					$userID = $model->findByAttributes(array('username'=>$_POST['Users']['username']));
					$userInsertId = $userID['id'];
					
					//Inserting data in  jos_core_acl_aro table
					$model_coreaclaro = new CoreAclAro;
	   				$model_coreaclaro->section_value	= 'users';
	   				$model_coreaclaro->value 			= $userInsertId;
	   				$model_coreaclaro->order_value 		= 0;
	   				$model_coreaclaro->name 			= $_POST['Users']['name'];
	   				$model_coreaclaro->hidden 			= 0;
					$model_coreaclaro->save();

					# Get Current inserted ID from jos_core_acl_aro to be insert in jos_core_acl_groups_aro_map table
					$core_acl_aro = $model_coreaclaro->findByAttributes(array('value'=>$userInsertId));
					$core_acl_aro_id = $core_acl_aro['id'];
					
					//Inserting data in  jos_core_acl_groups_aro_map table
					$model_coreAclGroupsAroMap = new CoreAclGroupsAroMap;
	   				$model_coreAclGroupsAroMap->group_id = $_POST['Users']['gid'];
	   				$model_coreAclGroupsAroMap->aro_id = $core_acl_aro_id;
					$model_coreAclGroupsAroMap->save();
					
					Yii::app()->user->setFlash('success', '<i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i><strong>&nbsp; Success!</strong> User created successfully!');
					$this->redirect(array('index'));
				} // Model save condition ends
			} // Verify password condition ends
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
		$model			 = $this->loadModel($id);
		$model->scenario = 'createuser';

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['Users'])){
			
			if(isset($_POST['Users']['password']) && $_POST['Users']['password'] != ''){
				
				if($_POST['Users']['password'] != $_POST['Users']['hdnPassword']){
					
					# Password Encryption process by Yogi START
					$salt  = $this->genRandomPassword(32);
					
					// Get password crypt
					$crypt = $this->getCryptedPassword($_POST['Users']['password'], $salt);
					$_POST['Users']['password'] = $crypt.':'.$salt;
					
					// Get verify password crypt
					$cryptverifypass = $this->getCryptedPassword($_POST['Users']['verifyPassword'], $salt);
					$_POST['Users']['verifyPassword'] = $cryptverifypass.':'.$salt;
					# Password Encryption process by Yogi End
				}
			}else{
				$_POST['Users']['password']		  = $_POST['Users']['hdnPassword'];
				$_POST['Users']['verifyPassword'] = $_POST['Users']['hdnPassword'];
			}
			
			//$gid = Usergroups::model()->findByAttributes(array('name'=>$_POST['Users']['usertype']));
			//$_POST['Users']['gid']	= $gid['id'];
			$model->attributes		= $_POST['Users'];
			
			if($model->save()){
				Yii::app()->user->setFlash('success', '<i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i><strong>&nbsp; Success!</strong> User updated successfully!');
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
		
		# Fetch Current login user's information
		$currentLoginUser = CommonController::userinfo(Yii::app()->user->id);
		if($id == $currentLoginUser->id){
			echo '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-circle-exclamation-mark" style="color:#d9534f;font-size: 16px;"></i><span style="color:#d9534f;"><strong> Sorry!! </strong> You can not delete currently logged in User.</span>';
		}else{
			# Delete user for that get ID from jos_core_acl_aro table 
			$CoreAclAro_delete = CoreAclAro::model()->findByAttributes(array('value'=>$id));
			
			# Delete user detail from jos_core_acl_groups_aro_map table 
			$CoreAclGroupsAroMap_delete = CoreAclGroupsAroMap::model()->findByAttributes(array('aro_id'=>$CoreAclAro_delete['id']));
			if(isset($CoreAclGroupsAroMap_delete) AND $CoreAclGroupsAroMap_delete != ''){
					$CoreAclGroupsAroMap_delete->delete();
			}
			
			# Delete user detail from jos_core_acl_aro table 
			if(isset($CoreAclAro_delete) AND $CoreAclAro_delete != ''){
					$CoreAclAro_delete->delete();
			}
			
			try{
			    $this->loadModel($id)->delete();
			    if(!isset($_GET['ajax']))
			        Yii::app()->user->setFlash('success','<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your User deleted successfully.');
			    else
			        echo '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your User deleted successfully.';
			}catch(CDbException $e){
				    if(!isset($_GET['ajax']))
				        Yii::app()->user->setFlash('error','Normal - error message');
				    else
				        echo "<div class='flash-error'>Ajax - error message</div>"; //for ajax
			}

		} // if statement
			
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new Users('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Users']))
			$model->attributes=$_GET['Users'];

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
	 * @return Users the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Users::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Users $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='users-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	/**
	* Function to change User status from Active to Inactive and Vice versa
	* Developer: rinkal 
	*/	
	public function actionUpdatestatus($id) {
		# Fetch Current login user's information
		$currentLoginUser = CommonController::userinfo(Yii::app()->user->id);
		
		if($id == $currentLoginUser->id && $_REQUEST['status'] != 1){
			Yii::app()->user->setFlash('fail', '<i class="glyphicon glyphicon-circle-exclamation-mark" style="color:#d9534f;font-size: 16px;"></i><strong> Sorry!! </strong> You can not unpublished logged in user');
		}else{
			$newStatus = ($_REQUEST['status'] == 1)?0:1;
			$model = Users::model()->findByPk($id);
			$model->block = $newStatus;
			$model->save();
			Yii::app()->user->setFlash('success', '<i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i><strong>&nbsp; Success!</strong> User status updated successfully!');
		}
		$this->redirect(array('users/index'));
    }
	
	public function actionAjaxupdate(){
		# Fetch Current login user's information
		$currentLoginUser = CommonController::userinfo(Yii::app()->user->id);
		
		$act = $_GET['act'];
	    $autoIdAll = $_POST['autoId'];
	    if(count($autoIdAll)>0){
	        foreach($autoIdAll as $autoId){
	            $model = $this->loadModel($autoId);
	            if($act == 'doDelete'){
	            	if($autoId == $currentLoginUser->id){
		            	$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-circle-exclamation-mark" style="color:#d9534f;font-size: 16px;"></i><span style="color:#d9534f;"><strong> Sorry!! </strong> You can not delete currently logged in User.</span>';
	            	}else{
						$model->delete();
						$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> User deleted successfully.';
					}
				}
	            if($act == 'doActive'){
	                $model->block = '0';
					$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your user published successfully.';				
				}
	            if($act == 'doInactive'){
	            	
	            	if($autoId == $currentLoginUser->id){
		            	$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-circle-exclamation-mark" style="color:#d9534f;font-size: 16px;"></i><span style="color:#d9534f;"><strong> Sorry!! </strong> You can not unpublish currently logged in User.</span>';
	            	}else{
		                $model->block = '1';                     
						$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your user unpublished successfully.';						
					}
				}
	            if($model->save())
	                echo '';
	            else
	                throw new Exception("Sorry",500);

	        }
			echo $msg;
	    }
	} // Ending Function
	
	// Function to get crypted password from plain text password and Salt by YOGI
	public function getCryptedPassword($plaintext, $salt = '', $encryption = 'md5-hex', $show_encrypt = false){
		$encrypted = ($salt) ? md5($plaintext.$salt) : md5($plaintext);
		return ($show_encrypt) ? '{MD5}'.$encrypted : $encrypted;	
	}

	// Function to generate random 32 character SALT string by YOGI
	public function genRandomPassword($length = 8){
		$salt = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$len = strlen($salt);
		$makepass = '';

		for($i = 0; $i < $length; $i ++){
			$makepass .= $salt[mt_rand(0, $len -1)];
		}
		return $makepass;
	}
	
}