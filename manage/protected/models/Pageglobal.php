<?php

/**
 * This is the model class for table "jos_pageglobal".
 *
 * The followings are the available columns in table 'jos_pageglobal':
 * @property integer $id
 * @property string $site_name
 * @property string $email
 * @property string $googgle_map_api_keys
 * @property string $location_code
 * @property string $beach
 * @property string $photo_mini_slider_cat
 * @property string $photo_upload_cat
 * @property string $facebook
 * @property string $iphone
 * @property string $android
 * @property string $Header_color
 * @property string $Footer_Menu_Link
 * @property string $distance_unit
 * @property string $weather_unit
 * @property string $twitter
 * @property string $youtube
 * @property string $time_zone
 * @property string $date_format
 * @property string $time_format
 * @property integer $homeslidercat
 */
class Pageglobal extends CActiveRecord
{
	public $logo;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jos_pageglobal';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('site_name, email,beach,location_code,photo_upload_cat,homeslidercat', 'required'),
			array('homeslidercat', 'numerical', 'integerOnly'=>true),
			array('site_name, email, location_code, beach,googgle_map_api_keys, photo_mini_slider_cat, photo_upload_cat, facebook, iphone, android, Header_color, Footer_Menu_Link, distance_unit, weather_unit, twitter, youtube, date_format, time_format', 'length', 'max'=>255),
			array('time_zone', 'length', 'max'=>50),
			array('logo', 'file','types'=>'jpg,jpeg,gif,png',
			'maxSize'=>1024 * 1024 * 50, // 50 MB
	        'allowEmpty'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, site_name, email, googgle_map_api_keys, location_code, beach, photo_mini_slider_cat, photo_upload_cat, facebook, iphone, android, Header_color, Footer_Menu_Link, distance_unit, weather_unit, twitter, youtube, time_zone, date_format, time_format, homeslidercat', 'safe', 'on'=>'search'),
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
		//'EventsCat' => array(self::BELONGS_TO,'Categories','catid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'site_name' => 'Site Name',
			'email' => 'Email',
			'googgle_map_api_keys' => 'Google Analytics Code',
			'location_code' => 'Location Code',
			'beach' => 'City Name',
			'photo_mini_slider_cat' => 'Photo Mini Slider Category',
			'photo_upload_cat' => 'Photo Upload Category From Site',
			'facebook' => 'Facebook Link',
			'iphone' => 'Iphone App Download Link',
			'android' => 'Android App Download Link',
			'Header_color' => 'Header Color',
			'Footer_Menu_Link' => 'Footer Menu Link',
			'distance_unit' => 'Distance Unit',
			'weather_unit' => 'Weather Unit',
			'twitter' => 'Twitter Follow up',
			'youtube' => 'Youtube Follow up',
			'time_zone' => 'Time Zone',
			'date_format' => 'Date Format',
			'time_format' => 'Time Format',
			'homeslidercat' => 'Homepage Slider Events Category',
			'logo'=>'Site Logo (Dimensions : 196px &times; 120px)'
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('site_name',$this->site_name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('googgle_map_api_keys',$this->googgle_map_api_keys,true);
		$criteria->compare('location_code',$this->location_code,true);
		$criteria->compare('beach',$this->beach,true);
		$criteria->compare('photo_mini_slider_cat',$this->photo_mini_slider_cat,true);
		$criteria->compare('photo_upload_cat',$this->photo_upload_cat,true);
		$criteria->compare('facebook',$this->facebook,true);
		$criteria->compare('iphone',$this->iphone,true);
		$criteria->compare('android',$this->android,true);
		$criteria->compare('Header_color',$this->Header_color,true);
		$criteria->compare('Footer_Menu_Link',$this->Footer_Menu_Link,true);
		$criteria->compare('distance_unit',$this->distance_unit,true);
		$criteria->compare('weather_unit',$this->weather_unit,true);
		$criteria->compare('twitter',$this->twitter,true);
		$criteria->compare('youtube',$this->youtube,true);
		$criteria->compare('time_zone',$this->time_zone,true);
		$criteria->compare('date_format',$this->date_format,true);
		$criteria->compare('time_format',$this->time_format,true);
		$criteria->compare('homeslidercat',$this->homeslidercat);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Pageglobal the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
