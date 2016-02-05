<?php

/**
 * This is the model class for table "jos_phocagallery_categories".
 *
 * The followings are the available columns in table 'jos_phocagallery_categories':
 * @property integer $id
 * @property integer $parent_id
 * @property integer $owner_id
 * @property string $title
 * @property string $name
 * @property string $alias
 * @property string $image
 * @property string $section
 * @property string $image_position
 * @property string $description
 * @property string $date
 * @property integer $published
 * @property integer $approved
 * @property string $checked_out
 * @property string $checked_out_time
 * @property string $editor
 * @property integer $ordering
 * @property integer $access
 * @property integer $count
 * @property integer $hits
 * @property string $accessuserid
 * @property string $uploaduserid
 * @property string $deleteuserid
 * @property string $userfolder
 * @property string $latitude
 * @property string $longitude
 * @property integer $zoom
 * @property string $geotitle
 * @property string $extid
 * @property string $exta
 * @property string $extu
 * @property string $params
 * @property string $metakey
 * @property string $metadesc
 */
class PhocaCategories extends CActiveRecord
{
	public $last_url;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jos_phocagallery_categories';
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
			array('parent_id, owner_id, published, approved, ordering, access, count, hits, zoom', 'numerical', 'integerOnly'=>true),
			array('title, name, alias, image, geotitle, extid, exta, extu', 'length', 'max'=>255),
			array('section, editor', 'length', 'max'=>50),
			array('image_position', 'length', 'max'=>30),
			array('checked_out', 'length', 'max'=>11),
			array('latitude, longitude', 'length', 'max'=>20),
			array('description, date, checked_out_time, accessuserid, uploaduserid, deleteuserid, userfolder, params, metakey, metadesc', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parent_id, owner_id, title, name, alias, image, section, image_position, description, date, published, approved, checked_out, checked_out_time, editor, ordering, access, count, hits, accessuserid, uploaduserid, deleteuserid, userfolder, latitude, longitude, zoom, geotitle, extid, exta, extu, params, metakey, metadesc', 'safe', 'on'=>'search'),
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
		'Parenttitle' => array(self::BELONGS_TO,'PhocaCategories','parent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'parent_id' => 'Parent',
			'owner_id' => 'Owner',
			'title' => 'Title',
			'name' => 'Name',
			'alias' => 'Alias',
			'image' => 'Image',
			'section' => 'Section',
			'image_position' => 'Image Position',
			'description' => 'Description',
			'date' => 'Date',
			'published' => 'Published',
			'approved' => 'Approved',
			'checked_out' => 'Checked Out',
			'checked_out_time' => 'Checked Out Time',
			'editor' => 'Editor',
			'ordering' => 'Ordering',
			'access' => 'Access',
			'count' => 'Count',
			'hits' => 'Hits',
			'accessuserid' => 'Accessuserid',
			'uploaduserid' => 'Uploaduserid',
			'deleteuserid' => 'Deleteuserid',
			'userfolder' => 'Userfolder',
			'latitude' => 'Latitude',
			'longitude' => 'Longitude',
			'zoom' => 'Zoom',
			'geotitle' => 'Geotitle',
			'extid' => 'Extid',
			'exta' => 'Exta',
			'extu' => 'Extu',
			'params' => 'Params',
			'metakey' => 'Metakey',
			'metadesc' => 'Metadesc',
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

		//$criteria->compare('id',$this->id);
		if(isset($_REQUEST['PhocaCategories']['parent_id']) && $_REQUEST['PhocaCategories']['parent_id']!=''){
			$gallery_cat_ids = $_REQUEST['PhocaCategories']['parent_id'];
		}else if(isset($_REQUEST['cat_id']) && isset($_REQUEST['cat_name']) && $_REQUEST['cat_name'] == 'videos'){
			$gallery_cat_ids = $_REQUEST['cat_id'];
		}else if(isset($_REQUEST['cat_id']) && $_REQUEST['cat_id']!=''){
			$gallery_cat_ids = CommonController::explode_catids(";",$_REQUEST['cat_id']);
		}else{
			$gallery_cat_ids = '';
		}
		if(is_array($gallery_cat_ids)){
			$criteria->addNotInCondition('id',$gallery_cat_ids,true);
		}else{
			$criteria->addCondition('id = '.$gallery_cat_ids.' OR parent_id = '.$gallery_cat_ids);
		}
		
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('owner_id',$this->owner_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('section',$this->section,true);
		$criteria->compare('image_position',$this->image_position,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('published',$this->published);
		$criteria->compare('approved',$this->approved);
		$criteria->compare('checked_out',$this->checked_out,true);
		$criteria->compare('checked_out_time',$this->checked_out_time,true);
		$criteria->compare('editor',$this->editor,true);
		$criteria->compare('ordering',$this->ordering);
		$criteria->compare('access',$this->access);
		$criteria->compare('count',$this->count);
		$criteria->compare('hits',$this->hits);
		$criteria->compare('accessuserid',$this->accessuserid,true);
		$criteria->compare('uploaduserid',$this->uploaduserid,true);
		$criteria->compare('deleteuserid',$this->deleteuserid,true);
		$criteria->compare('userfolder',$this->userfolder,true);
		$criteria->compare('latitude',$this->latitude,true);
		$criteria->compare('longitude',$this->longitude,true);
		$criteria->compare('zoom',$this->zoom);
		$criteria->compare('geotitle',$this->geotitle,true);
		$criteria->compare('extid',$this->extid,true);
		$criteria->compare('exta',$this->exta,true);
		$criteria->compare('extu',$this->extu,true);
		$criteria->compare('params',$this->params,true);
		$criteria->compare('metakey',$this->metakey,true);
		$criteria->compare('metadesc',$this->metadesc,true);

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
	 * @return PhocaCategories the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
