<?php

/**
 * This is the model class for table "jos_sections".
 *
 * The followings are the available columns in table 'jos_sections':
 * @property integer $id
 * @property string $title
 * @property string $name
 * @property string $alias
 * @property string $image
 * @property string $scope
 * @property string $image_position
 * @property string $description
 * @property integer $published
 * @property string $checked_out
 * @property string $checked_out_time
 * @property integer $ordering
 * @property integer $access
 * @property integer $count
 * @property string $params
 */
class Sections extends CActiveRecord
{
	public $last_url;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jos_sections';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('published, ordering, access, count', 'numerical', 'integerOnly'=>true),
			array('title, name, alias,image, description, params,last_url', 'length', 'max'=>255),
			array('scope', 'length', 'max'=>50),
			array('image_position', 'length', 'max'=>30),
			array('checked_out', 'length', 'max'=>11),
			array('checked_out_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, name, alias, image, scope, image_position, description, published, checked_out, checked_out_time, ordering, access, count, params', 'safe', 'on'=>'search'),
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
			'title' => 'Title',
			'name' => 'Name',
			'alias' => 'Alias',
			'image' => 'Image',
			'scope' => 'Scope',
			'image_position' => 'Image Position',
			'description' => 'Description',
			'published' => 'Published',
			'checked_out' => 'Checked Out',
			'checked_out_time' => 'Checked Out Time',
			'ordering' => 'Ordering',
			'access' => 'Access',
			'count' => 'Count',
			'params' => 'Params',
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

		//fetch section id from category id which is in URL
		/*$section_id = Categories::model()->findAll("id=".$_REQUEST['cat_id']." OR parent_id=".$_REQUEST['cat_id'],"section");

		for($i = 0; $i < count($section_id); ++$i){
			$sectionIds[] = $section_id[$i]->section;
		}*/
		
		//$criteria->addInCondition('id', $sectionIds);
		//$criteria->compare('id',$section_id[0]->section);
		//$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('scope',$this->scope,true);
		$criteria->compare('image_position',$this->image_position,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('published',$this->published);
		$criteria->compare('checked_out',$this->checked_out,true);
		$criteria->compare('checked_out_time',$this->checked_out_time,true);
		$criteria->compare('ordering',$this->ordering);
		$criteria->compare('access',$this->access);
		$criteria->compare('count',$this->count);
		$criteria->compare('params',$this->params,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
		        'defaultOrder'=>'ordering ASC',
		    ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Sections the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
