<?php

/**
 * This is the model class for table "jos_jevents_icsfile".
 *
 * The followings are the available columns in table 'jos_jevents_icsfile':
 * @property integer $ics_id
 * @property string $srcURL
 * @property string $label
 * @property string $filename
 * @property integer $icaltype
 * @property integer $isdefault
 * @property integer $ignoreembedcat
 * @property integer $state
 * @property string $access
 * @property integer $catid
 * @property string $created
 * @property string $created_by
 * @property string $created_by_alias
 * @property string $modified_by
 * @property string $refreshed
 * @property integer $autorefresh
 */
class EventsIcsfile extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jos_jevents_icsfile';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('icaltype, isdefault, ignoreembedcat, state, catid, autorefresh', 'numerical', 'integerOnly'=>true),
			array('srcURL', 'length', 'max'=>255),
			array('label', 'length', 'max'=>30),
			array('filename', 'length', 'max'=>120),
			array('access, created_by, modified_by', 'length', 'max'=>11),
			array('created_by_alias', 'length', 'max'=>100),
			array('created, refreshed', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ics_id, srcURL, label, filename, icaltype, isdefault, ignoreembedcat, state, access, catid, created, created_by, created_by_alias, modified_by, refreshed, autorefresh', 'safe', 'on'=>'search'),
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
			'ics_id' => 'Ics',
			'srcURL' => 'Src Url',
			'label' => 'Label',
			'filename' => 'Filename',
			'icaltype' => 'Icaltype',
			'isdefault' => 'Isdefault',
			'ignoreembedcat' => 'Ignoreembedcat',
			'state' => 'State',
			'access' => 'Access',
			'catid' => 'Catid',
			'created' => 'Created',
			'created_by' => 'Created By',
			'created_by_alias' => 'Created By Alias',
			'modified_by' => 'Modified By',
			'refreshed' => 'Refreshed',
			'autorefresh' => 'Autorefresh',
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

		$criteria->compare('ics_id',$this->ics_id);
		$criteria->compare('srcURL',$this->srcURL,true);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('icaltype',$this->icaltype);
		$criteria->compare('isdefault',$this->isdefault);
		$criteria->compare('ignoreembedcat',$this->ignoreembedcat);
		$criteria->compare('state',$this->state);
		$criteria->compare('access',$this->access,true);
		$criteria->compare('catid',$this->catid);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('created_by_alias',$this->created_by_alias,true);
		$criteria->compare('modified_by',$this->modified_by,true);
		$criteria->compare('refreshed',$this->refreshed,true);
		$criteria->compare('autorefresh',$this->autorefresh);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EventsIcsfile the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
