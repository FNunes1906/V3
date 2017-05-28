<?php

/**
 * This is the model class for table "jos_phocagallery".
 *
 * The followings are the available columns in table 'jos_phocagallery':
 * @property string $id
 * @property integer $catid
 * @property integer $sid
 * @property string $title
 * @property string $alias
 * @property string $filename
 * @property string $description
 * @property string $date
 * @property integer $hits
 * @property string $latitude
 * @property string $longitude
 * @property integer $zoom
 * @property string $geotitle
 * @property string $videocode
 * @property integer $vmproductid
 * @property integer $imgorigsize
 * @property integer $published
 * @property integer $approved
 * @property integer $checked_out
 * @property string $checked_out_time
 * @property integer $ordering
 * @property string $params
 * @property string $metakey
 * @property string $metadesc
 * @property string $extlink1
 * @property string $extlink2
 * @property string $extid
 * @property string $extl
 * @property string $extm
 * @property string $exts
 * @property string $exto
 * @property string $extw
 * @property string $exth
 */
class Galleries extends CActiveRecord
{
	public $last_url;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jos_phocagallery';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('catid','required'),
			array('catid, sid, hits, zoom, vmproductid, imgorigsize, published, approved, checked_out, ordering', 'numerical', 'integerOnly'=>true),
			array('title, filename,last_url', 'length', 'max'=>250),
			array('alias, geotitle, extid, extl, extm, exts, exto, extw, exth', 'length', 'max'=>255),
			array('latitude, longitude', 'length', 'max'=>20),
			array('description, date, videocode, checked_out_time, params, metakey, metadesc, extlink1, extlink2', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, catid, sid, title, alias, filename, description, date, hits, latitude, longitude, zoom, geotitle, videocode, vmproductid, imgorigsize, published, approved, checked_out, checked_out_time, ordering, params, metakey, metadesc, extlink1, extlink2, extid, extl, extm, exts, exto, extw, exth', 'safe', 'on'=>'search'),
			array('filename', 'file', 'allowEmpty'=>true, 'types'=>'jpg,jpeg,gif,png'),
			array('filename', 'safe', 'on'=>''),
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
		'phocaCat' => array(self::BELONGS_TO,'PhocaCategories','catid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'catid' => 'Category',
			'sid' => 'Sid',
			'title' => 'Name',
			'alias' => 'Alias',
			'filename' => 'Image',
			'description' => 'Description',
			'date' => 'Date',
			'hits' => 'Hits',
			'latitude' => 'Latitude',
			'longitude' => 'Longitude',
			'zoom' => 'Zoom',
			'geotitle' => 'Geotitle',
			'videocode' => 'Video Code',
			'vmproductid' => 'Vmproductid',
			'imgorigsize' => 'Imgorigsize',
			'published' => 'Published',
			'approved' => 'Authorized',
			'checked_out' => 'Checked Out',
			'checked_out_time' => 'Checked Out Time',
			'ordering' => 'Ordering',
			'params' => 'Params',
			'metakey' => 'Metakey',
			'metadesc' => 'Metadesc',
			'extlink1' => 'Extlink1',
			'extlink2' => 'Extlink2',
			'extid' => 'Extid',
			'extl' => 'Extl',
			'extm' => 'Extm',
			'exts' => 'Exts',
			'exto' => 'Exto',
			'extw' => 'Extw',
			'exth' => 'Exth',
			'phocaCat.title' => 'Category',
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

		$criteria->compare('id',$this->id,true);
		if(isset($_REQUEST['Galleries']['catid']) && $_REQUEST['Galleries']['catid']!=''){
			$gallery_cat = $_REQUEST['Galleries']['catid'];
		}else if(isset($_REQUEST['cat_id']) && isset($_REQUEST['cat_name'])){
			$gallery_cat = $_REQUEST['cat_id'];
		}else if(isset($_REQUEST['cat_id']) && $_REQUEST['cat_id']!=''){
			$gallery_cat = CommonController::explode_catids(";",$_REQUEST['cat_id']);
		}else{
			$gallery_cat = '';
		}
		if(is_array($gallery_cat)){
			$criteria->addNotInCondition('catid',$gallery_cat,true);
		}else{
			$criteria->compare('catid',$gallery_cat);
		}
		$criteria->compare('sid',$this->sid);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('hits',$this->hits);
		$criteria->compare('latitude',$this->latitude,true);
		$criteria->compare('longitude',$this->longitude,true);
		$criteria->compare('zoom',$this->zoom);
		$criteria->compare('geotitle',$this->geotitle,true);
		$criteria->compare('videocode',$this->videocode,true);
		$criteria->compare('vmproductid',$this->vmproductid);
		$criteria->compare('imgorigsize',$this->imgorigsize);
		$criteria->compare('published',$this->published);
		$criteria->compare('approved',$this->approved);
		$criteria->compare('checked_out',$this->checked_out);
		$criteria->compare('checked_out_time',$this->checked_out_time,true);
		$criteria->compare('ordering',$this->ordering);
		$criteria->compare('params',$this->params,true);
		$criteria->compare('metakey',$this->metakey,true);
		$criteria->compare('metadesc',$this->metadesc,true);
		$criteria->compare('extlink1',$this->extlink1,true);
		$criteria->compare('extlink2',$this->extlink2,true);
		$criteria->compare('extid',$this->extid,true);
		$criteria->compare('extl',$this->extl,true);
		$criteria->compare('extm',$this->extm,true);
		$criteria->compare('exts',$this->exts,true);
		$criteria->compare('exto',$this->exto,true);
		$criteria->compare('extw',$this->extw,true);
		$criteria->compare('exth',$this->exth,true);
		
		$criteria->order='id DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array( # CODE FOR SET PAGE SIZE START
				'pageSize' => Yii::app()->user->getState( 'pageSizeGalleries', Yii::app()->params[ 'defaultPageSize' ] ),
			), # CODE FOR SET PAGE SIZE END 
			'sort'=>array( 
		        'defaultOrder'=>'ordering ASC',
		    ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Galleries the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
