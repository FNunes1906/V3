<?php

/**
 * This is the model class for table "jos_jevents_vevent".
 *
 * The followings are the available columns in table 'jos_jevents_vevent':
 * @property integer $ev_id
 * @property integer $icsid
 * @property integer $catid
 * @property string $uid
 * @property string $refreshed
 * @property string $created
 * @property string $created_by
 * @property string $created_by_alias
 * @property string $modified_by
 * @property string $rawdata
 * @property string $recurrence_id
 * @property integer $detail_id
 * @property integer $state
 * @property string $access
 * @property integer $lockevent
 * @property integer $author_notified
 */
class Events extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jos_jevents_vevent';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('catid', 'required'),
			array('icsid, catid, detail_id, state, lockevent, author_notified', 'numerical', 'integerOnly'=>true),
			array('uid', 'length', 'max'=>255),
			array('created_by, modified_by, access', 'length', 'max'=>11),
			array('created_by_alias', 'length', 'max'=>100),
			array('recurrence_id', 'length', 'max'=>30),
			array('refreshed, created', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ev_id, icsid, catid, uid, refreshed, created, created_by, created_by_alias, modified_by, rawdata, recurrence_id, detail_id, state, access, lockevent, author_notified', 'safe', 'on'=>'search'),
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
			'ev_id' => 'ID',
			'icsid' => 'Icsid',
			'catid' => 'Events Category',
			'uid' => 'Uid',
			'refreshed' => 'Refreshed',
			'created' => 'Created By',
			'created_by' => 'Created By',
			'created_by_alias' => 'Created By Alias',
			'modified_by' => 'Modified By',
			'rawdata' => 'Rawdata',
			'recurrence_id' => 'Recurrence',
			'detail_id' => 'Detail',
			'state' => 'Status',
			'access' => 'Access',
			'lockevent' => 'Lockevent',
			'author_notified' => 'Author Notified',
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

		$criteria->compare('ev_id',$this->ev_id);
		$criteria->compare('icsid',$this->icsid);
		$criteria->compare('catid',$this->catid);
		$criteria->compare('uid',$this->uid,true);
		$criteria->compare('refreshed',$this->refreshed,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('created_by_alias',$this->created_by_alias,true);
		$criteria->compare('modified_by',$this->modified_by,true);
		$criteria->compare('rawdata',$this->rawdata,true);
		$criteria->compare('recurrence_id',$this->recurrence_id,true);
		$criteria->compare('detail_id',$this->detail_id);
		$criteria->compare('state',$this->state);
		$criteria->compare('access',$this->access,true);
		$criteria->compare('lockevent',$this->lockevent);
		$criteria->compare('author_notified',$this->author_notified);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Events the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
