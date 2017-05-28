<?php

/**
 * This is the model class for table "jos_menu".
 *
 * The followings are the available columns in table 'jos_menu':
 * @property integer $id
 * @property string $menutype
 * @property string $name
 * @property string $alias
 * @property string $link
 * @property string $type
 * @property integer $published
 * @property string $parent
 * @property string $componentid
 * @property integer $sublevel
 * @property integer $ordering
 * @property string $checked_out
 * @property string $checked_out_time
 * @property integer $pollid
 * @property integer $browserNav
 * @property integer $access
 * @property integer $utaccess
 * @property string $params
 * @property string $lft
 * @property string $rgt
 * @property string $home
 *
 */
class Menu extends CActiveRecord
{
	public $max_order;
	public $pagedescription;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jos_menu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('section,article,phota category,location category','checkEmpty'),
			array('name,params,link', 'required'),
			array('published,home,sublevel, ordering, pollid, browserNav, access, utaccess', 'numerical', 'integerOnly'=>true),
			array('menutype', 'length', 'max'=>75),
			array('name, alias,', 'length', 'max'=>255),
			array('type', 'length', 'max'=>50),
			array('parent, componentid, checked_out, lft, rgt', 'length', 'max'=>11),
			//array('home', 'length', 'max'=>1),
			array('link, checked_out_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, menutype, name, alias, link, type, published, parent, componentid, sublevel, ordering, checked_out, checked_out_time, pollid, browserNav, access, utaccess, params, lft, rgt, home', 'safe', 'on'=>'search'),
		);
	}
	/*public function checkEmpty($attribute_name,$params)
    {
        // if(empty($this->category) || empty($this->article)){
         if(empty($this->$attribute_name)){
				 $this->addError($attribute_name, ucfirst($attribute_name.' can not be blank'));
				  return false;
		 }
		
        return true;
     }*/

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		'MenuParent' => array(self::BELONGS_TO,'Menu','parent'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'menutype' => 'Menutype',
			'name' => 'Menu Name',
			'alias' => 'Alias',
			'link' => 'Link',
			'type' => 'Type',
			'published' => 'Published',
			'parent' => 'Parent Menu',
			'componentid' => 'Componentid',
			'sublevel' => 'Sublevel',
			'ordering' => 'Ordering',
			'checked_out' => 'Checked Out',
			'checked_out_time' => 'Checked Out Time',
			'pollid' => 'Pollid',
			'browserNav' => 'Browser Navigation',
			'access' => 'Access',
			'utaccess' => 'Utaccess',
			'params' => 'Params',
			'lft' => 'Lft',
			'rgt' => 'Rgt',
			'home' => 'Default',
			'article'=>'Select Article',
			'location category'=>'Select Category',
			'phota category'=>'Select Category',
			'section'=>'Select Category',
			'pagedescription'=>'Description',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('menutype','leftmenu',true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('published',$this->published);
		$criteria->compare('parent',$this->parent,true);
		$criteria->compare('componentid',$this->componentid,true);
		$criteria->compare('sublevel',$this->sublevel);
		$criteria->compare('ordering',$this->ordering);
		$criteria->compare('checked_out',$this->checked_out,true);
		$criteria->compare('checked_out_time',$this->checked_out_time,true);
		$criteria->compare('pollid',$this->pollid);
		$criteria->compare('browserNav',$this->browserNav);
		$criteria->compare('access',$this->access);
		$criteria->compare('utaccess',$this->utaccess);
		$criteria->compare('params',$this->params,true);
		$criteria->compare('lft',$this->lft,true);
		$criteria->compare('rgt',$this->rgt,true);
		$criteria->compare('home',$this->home,true);
		
		// Condition to check that Trashed or Deleted menu should not display
		$criteria->addCondition("published <> -2");
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array( # CODE FOR SET PAGE SIZE START
				'pageSize' => Yii::app()->user->getState( 'pageSizeMenu', Yii::app()->params[ 'defaultPageSize' ] ),
			), # CODE FOR SET PAGE SIZE END 
			
			/*'pagination'=>array(
    				'pageSize'=>500,
   			 ),*/
			'sort'=>array(
		        'defaultOrder'=>'t.ordering ASC,t.id ASC',
				),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Menu the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
