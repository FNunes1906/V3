<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
	
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		if(!Yii::app()->user->isGuest){
				$this->render('index');
		}else{
			$this->redirect(array('login'));
		}
		
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model = new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()){
				//$this->redirect(Yii::app()->user->returnUrl);
				Yii::app()->user->returnUrl = 'site/index';
				$this->redirect(array('/site/index'));
			}
				
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	/**
	* Action Forgot Password 
	* 
	*/
	public function actionForgot() {
        $this->layout = '//layouts/ajax';
		$model = new Users;
		$model->scenario = 'forgotpassword';
		
        if(isset($_POST['ajax']) && $_POST['ajax'] === 'tw-forgot-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

		if(isset($_POST['Users'])){
			
			$model->attributes = $_POST['Users'];

			if($model->validate()) {
				// form inputs are valid, do something here
				$newUser = Users::model()->findByAttributes(array('email' => $_POST['Users']['email']));

				if(!isset($newUser->id) || $newUser->id == ""){
					//Yii::app()->user->setFlash('error', "Sorry, the email address is not exist in our system.");
					echo 2;
				}else{
					/*$password = $this->generatepassword();
					// Send Email - Password Recovery
					$dataArray = array(
						'user_id' => $newUser->id,
						'newpassword' => $password,
						'user_email' => $newUser->email,
						'user_real_name' => $newUser->username,
					);*/
					
					
					# Procedure for Creating Token
					
					$getToken 			= rand(0, 99999);
					$getTime 			= date("H:i:s");
					$newUser->token 	= md5($getToken.$getTime);
					$resetPassLink		= "<a href=http://".$_SERVER['SERVER_NAME']."/manage/site/VerToken?token=".$newUser->token.">Click here to set your new password </a>";
					$dataArray = array(
						'user_id' => $newUser->id,
						'user_email' => $newUser->email,
						'user_real_name' => $newUser->username,
						'reset_pass_link' => $resetPassLink,
						'email_subject' => 'Please reset your password',
					);
					$newUser->save();
					$status = CommonController::sendEmailViaTemplate($dataArray);
					echo $status;   
				}
				Yii::app()->end();
			}
		}

		$this->render('forgot', array('model' => $model));
	}
	
	
	public function getToken($token){
		$model = Users::model()->findByAttributes(array('token'=>$token));
		if($model === null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function actionVerToken(){
		$this->layout	= '//layouts/ajax';
		$model = $this->getToken($_GET['token']);
		//$model = Users::model()->findByAttributes(array('token'=>$_GET['token']));
		$model->scenario = 'changepassword';
		
		# Ajax validation
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'tw-chpass-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
		
		if(isset($_POST['Users'])){
			if($model->token == $_POST['Users']['tokenhid']){
				
				/** Password ENCRYPTION process START by YOGI **/
					$salt  = $this->genRandomPassword(32);
					
					// Get password crypt
					$crypt = $this->getCryptedPassword($_POST['Users']['password'], $salt);
					$_POST['Users']['password'] = $crypt.':'.$salt;
					
					// Get verify password crypt
					$cryptverifypass = $this->getCryptedPassword($_POST['Users']['verifyPassword'], $salt);
					$_POST['Users']['verifyPassword'] = $cryptverifypass.':'.$salt;
				/** Password ENCRYPTION process END by YOGI **/
				
				# IF New Password and Confirm password are matched
				if($_POST['Users']['password'] == $_POST['Users']['verifyPassword']){
					$model->attributes = $_POST['Users'];
					$model->password	= $_POST['Users']['password'];
					$model->token 		= "null";
					
					if($model->save()){
						Yii::app()->user->setFlash('success', "<i class='glyphicon glyphicon-ok-sign' style='font-size: 16px;'> </i> Password has been successfully changed! <a href=".Yii::app()->createAbsoluteUrl('site/login')."> Please Login</a>");
					}else{
						Yii::app()->user->setFlash('fail', "<i class='glyphicon glyphicon-ok-sign' style='font-size: 16px;'> </i> Failed to change your password! Please contact: <a href=mailto:support@townwizard.com><b style='color:#a94442 !important'>support@townwizard.com</b></a>");
					} // if model save or not
				} // password equal to varify password
			} // if tolen equal to hidden token
		} // if post users
		$this->render('changepass', array('model' => $model));
	} // function end
	
	
	# Function to get crypted password from plain text password and Salt by YOGI
	public function getCryptedPassword($plaintext, $salt = '', $encryption = 'md5-hex', $show_encrypt = false){
		$encrypted = ($salt) ? md5($plaintext.$salt) : md5($plaintext);
		return ($show_encrypt) ? '{MD5}'.$encrypted : $encrypted;	
	}

	# Function to generate random 32 character SALT string by YOGI
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