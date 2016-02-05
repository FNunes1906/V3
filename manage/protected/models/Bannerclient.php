<?php

/**
 * This is the model class for table "jos_bannerclient".
 *
 * The followings are the available columns in table 'jos_bannerclient':
 * @property integer $cid
 * @property string $name
 * @property string $contact
 * @property string $email
 * @property string $extrainfo
 * @property integer $checked_out
 * @property string $checked_out_time
 * @property string $editor
 */
class Bannerclient extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jos_bannerclient';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('extrainfo', 'required'),
			array('checked_out', 'numerical', 'integerOnly'=>true),
			array('name, contact, email', 'length', 'max'=>255),
			array('editor', 'length', 'max'=>50),
			array('checked_out_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('cid, name, contact, email, extrainfo, checked_out, checked_out_time, editor', 'safe', 'on'=>'search'),
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
			'cid' => 'Cid',
			'name' => 'Name',
			'contact' => 'Contact',
			'email' => 'Email',
			'extrainfo' => 'Extrainfo',
			'checked_out' => 'Checked Out',
			'checked_out_time' => 'Checked Out Time',
			'editor' => 'Editor',
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

		$criteria->compare('cid',$this->cid);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('contact',$this->contact,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('extrainfo',$this->extrainfo,true);
		$criteria->compare('checked_out',$this->checked_out);
		$criteria->compare('checked_out_time',$this->checked_out_time,true);
		$criteria->compare('editor',$this->editor,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Bannerclient the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
