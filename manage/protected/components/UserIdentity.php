<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate(){
		/*	$users=array(
			// username => password
			'demo'=>'demo',
			'admin'=>'admin',
		);*/
		
		$username = $this->username;
		$password = $this->password;
		
		//$user = Users::model()->find(array('condition'=>"email = '$username'"));
		
		$user = Users::model()->find('email=:email And block=:block',array(':email'=>$username,':block'=>0));

		
		if(!empty($user) && ($username == $user->email)){

			# Password decryption process by Yogi START
			$credentials['password'] = $password;

			$parts	= explode( ':', $user->password);
			$crypt	= $parts[0];
			$salt	= @$parts[1];

			$testcrypt = $this->getCryptedPassword($credentials['password'], $salt);

			/*if ($crypt == $testcrypt) {
				echo "Valid password";
			} else {
				echo 'Invalid password';
			}*/
			# Password decryption process by Yogi END

			//if($password == $user->password){
			if($crypt == $testcrypt){
				// Authentication is success	

				$this->errorCode = self::ERROR_NONE;
				$user->lastvisitDate = date("Y-m-d h:i:s");
				$user->save();
				
			}else{
				$this->errorCode = self::ERROR_PASSWORD_INVALID;
			}		
		}else{
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		}
		
		return !$this->errorCode;
	}
	
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