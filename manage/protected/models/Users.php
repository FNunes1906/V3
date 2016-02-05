<?php

/**
 * This is the model class for table "jos_users".
 *
 * The followings are the available columns in table 'jos_users':
 * @property integer $id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $usertype
 * @property integer $block
 * @property integer $sendEmail
 * @property integer $gid
 * @property string $registerDate
 * @property string $lastvisitDate
 * @property string $activation
 * @property string $params
 */
class Users extends CActiveRecord
{
	public $verifyPassword;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jos_users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email', 'required', 'on'=>'forgotpassword'),
			array('password', 'required', 'on'=>'changepassword'),
			array('verifyPassword','required', 'on'=>'changepassword'),
            array('email', 'email', 'on'=>'forgotpassword','message'=>'Wrong e-mail format'),
			
			array('name,username,email,password', 'required', 'on'=>'createuser'),
			// Compare password code
			array('verifyPassword','required', 'on'=>'createuser'),
			array('block, sendEmail, gid', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			
			array('username', 'length', 'max'=>150,'min'=>2),
			array('email,activation', 'length', 'max'=>100),
			array('password', 'length', 'min'=>6),
			array('usertype', 'length', 'max'=>25),
			// Compare password code
			array('verifyPassword', 'length', 'max'=>100),
			array('username, email','unique', 'on'=>'createuser'),
			// Compare password code
			array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'on'=>'createuser'),
			array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'on'=>'changepassword'),
			array('registerDate, lastvisitDate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, username, email, password, usertype, block,token, sendEmail, gid, registerDate, lastvisitDate, activation, params', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'username' => 'User Name',
			'email' => 'Email',
			'password' => 'New Password',
			'usertype' => 'User Type',
			'block' => 'Publish',
			'sendEmail' => 'Send Email',
			'gid' => 'Gid',
			'registerDate' => 'Register Date',
			'lastvisitDate' => 'Last visit Date',
			'activation' => 'Activation',
			'params' => 'Params',
			'token' => 'token',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;
		
		
		# Fetch Current login user's information
		$currentLoginUser = CommonController::userinfo(Yii::app()->user->id);
		
		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('usertype',$this->usertype,true);
		
		# If user is not super Administrator then do not show super admin user in listing
		if($currentLoginUser->usertype != 'Super Administrator'){
			$user_type_condition = 'usertype NOT LIKE "Super Administrator"';
			$criteria->addCondition($user_type_condition);
		}

		$criteria->compare('block',$this->block);
		$criteria->compare('sendEmail',$this->sendEmail);
		$criteria->compare('gid',$this->gid);
		$criteria->compare('registerDate',$this->registerDate,true);
		$criteria->compare('lastvisitDate',$this->lastvisitDate,true);
		$criteria->compare('activation',$this->activation,true);
		$criteria->compare('params',$this->params,true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
