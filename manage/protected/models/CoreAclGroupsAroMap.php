<?php

/**
 * This is the model class for table "jos_core_acl_groups_aro_map".
 *
 * The followings are the available columns in table 'jos_core_acl_groups_aro_map':
 * @property integer $group_id
 * @property string $section_value
 * @property integer $aro_id
 */
class CoreAclGroupsAroMap extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jos_core_acl_groups_aro_map';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('group_id, aro_id', 'numerical', 'integerOnly'=>true),
			array('section_value', 'length', 'max'=>240),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('group_id, section_value, aro_id', 'safe', 'on'=>'search'),
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
			'group_id' => 'Group',
			'section_value' => 'Section Value',
			'aro_id' => 'Aro',
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

		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('section_value',$this->section_value,true);
		$criteria->compare('aro_id',$this->aro_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CoreAclGroupsAroMap the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
