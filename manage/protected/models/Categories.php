<?php

/**
 * This is the model class for table "jos_categories".
 *
 * The followings are the available columns in table 'jos_categories':
 * @property integer $id
 * @property integer $parent_id
 * @property string $title
 * @property string $name
 * @property string $alias
 * @property string $image
 * @property string $section
 * @property string $image_position
 * @property string $description
 * @property integer $published
 * @property string $checked_out
 * @property string $checked_out_time
 * @property string $editor
 * @property integer $ordering
 * @property integer $access
 * @property integer $count
 * @property string $params
 */
class Categories extends CActiveRecord
{
	public $last_url;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jos_categories';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title','required'),
			array('parent_id, published, ordering, access, count', 'numerical', 'integerOnly'=>true),
			array('title, name, alias, image,last_url', 'length', 'max'=>255),
			array('section, editor', 'length', 'max'=>50),
			array('image_position', 'length', 'max'=>30),
			array('checked_out', 'length', 'max'=>11),
			array('checked_out_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parent_id, title, name, alias, image, section, image_position, description, published, checked_out, checked_out_time, editor, ordering, access, count, params', 'safe', 'on'=>'search'),
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
		'sectiontitle' => array(self::BELONGS_TO,'Sections','section'),
		'Parenttitle' => array(self::BELONGS_TO,'Categories','parent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'parent_id' => 'Parent Category',
			'title' => 'Title',
			'name' => 'Name',
			'alias' => 'Alias :',
			'image' => 'Image',
			'section' => 'Section :',
			'sectiontitle.title'=>'Section',
			'image_position' => 'Image Position',
			'description' => 'Description',
			'published' => 'Status',
			'checked_out' => 'Checked Out',
			'checked_out_time' => 'Checked Out Time',
			'editor' => 'Editor',
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
		if($_REQUEST['type']=='com_content'){
			$criteria1 = new CDbCriteria;
			$criteria1->addSearchCondition('scope','content', true);
			$secData = Sections::model()->findAll($criteria1);
			$criteria2 = new CDbCriteria;
			if(count($secData)>0)
			{	
				foreach($secData as $id=>$value){
					$cat_sec[$id]= $value['id'];
				}
			}
		}else if($_REQUEST['type']=='com_banner'){
			$cat_sec = 'com_banner';
			$criteria->compare('id',$this->id);
		}else if($_REQUEST['type']=='com_jevlocations2'){
			$cat_sec = 'com_jevlocations2';
			/*if(isset($_REQUEST['cat_id']) && $_REQUEST['cat_id'] != ''){
				$lc_cat = explode('|',$_REQUEST['cat_id']);
				$cat_condition = '';
				foreach($lc_cat as $key=>$value){
					$cat_condition .= ' (id ='.$value.' OR parent_id ='.$value.') ';
					if($key < count($lc_cat)-1 ){
						$cat_condition .=' OR';
					}
				}
			}else{
				$cat_condition = '';
			}*/
			//$criteria->addCondition($cat_condition);
		}else if($_REQUEST['type']=='com_jevents'){
			$cat_sec = 'com_jevents';
			/*if(isset($_REQUEST['cat_id']) && $_REQUEST['cat_id']!=''){
				$criteria->addCondition('id ='.$_REQUEST["cat_id"].' OR parent_id ='. $_REQUEST["cat_id"]);
			}*/
		}
		
		$criteria->compare('parent_id',$this->parent_id);
		//$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('section',$cat_sec,true);
		$criteria->compare('image_position',$this->image_position,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('published',$this->published);
		$criteria->compare('checked_out',$this->checked_out,true);
		$criteria->compare('checked_out_time',$this->checked_out_time,true);
		$criteria->compare('editor',$this->editor,true);
		$criteria->compare('ordering',$this->ordering);
		$criteria->compare('access',$this->access);
		$criteria->compare('count',$this->count);
		$criteria->compare('params',$this->params,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array( # CODE FOR SET PAGE SIZE START
				'pageSize' => Yii::app()->user->getState( 'pageSizeEventsCat', Yii::app()->params[ 'defaultPageSize' ] ),
			), # CODE FOR SET PAGE SIZE END 
			'sort'=>array(
		         'defaultOrder'=>'t.ordering ASC',
		    ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Categories the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
