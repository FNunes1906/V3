<?php

/**
 * This is the model class for table "jos_components".
 *
 * The followings are the available columns in table 'jos_components':
 * @property integer $id
 * @property string $name
 * @property string $link
 * @property string $menuid
 * @property string $parent
 * @property string $admin_menu_link
 * @property string $admin_menu_alt
 * @property string $option
 * @property integer $ordering
 * @property string $admin_menu_img
 * @property integer $iscore
 * @property string $params
 * @property integer $enabled
 */
class Components extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jos_components';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('params', 'required'),
			array('ordering, iscore, enabled', 'numerical', 'integerOnly'=>true),
			array('name, option', 'length', 'max'=>50),
			array('link, admin_menu_link, admin_menu_alt, admin_menu_img', 'length', 'max'=>255),
			array('menuid, parent', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, link, menuid, parent, admin_menu_link, admin_menu_alt, option, ordering, admin_menu_img, iscore, params, enabled', 'safe', 'on'=>'search'),
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
			'link' => 'Link',
			'menuid' => 'Menuid',
			'parent' => 'Parent',
			'admin_menu_link' => 'Admin Menu Link',
			'admin_menu_alt' => 'Admin Menu Alt',
			'option' => 'Option',
			'ordering' => 'Ordering',
			'admin_menu_img' => 'Admin Menu Img',
			'iscore' => 'Iscore',
			'params' => 'Params',
			'enabled' => 'Enabled',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('menuid',$this->menuid,true);
		$criteria->compare('parent',$this->parent,true);
		$criteria->compare('admin_menu_link',$this->admin_menu_link,true);
		$criteria->compare('admin_menu_alt',$this->admin_menu_alt,true);
		$criteria->compare('option',$this->option,true);
		$criteria->compare('ordering',$this->ordering);
		$criteria->compare('admin_menu_img',$this->admin_menu_img,true);
		$criteria->compare('iscore',$this->iscore);
		$criteria->compare('params',$this->params,true);
		$criteria->compare('enabled',$this->enabled);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Components the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
