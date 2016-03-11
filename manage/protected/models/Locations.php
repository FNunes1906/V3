<?php

/**
 * This is the model class for table "jos_jev_locations".
 *
 * The followings are the available columns in table 'jos_jev_locations':
 * @property integer $loc_id
 * @property string $title
 * @property string $alias
 * @property string $street
 * @property string $postcode
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string $description
 * @property double $geolon
 * @property double $geolat
 * @property integer $geozoom
 * @property integer $pcode_id
 * @property string $image
 * @property string $phone
 * @property string $url
 * @property integer $loccat
 * @property string $catid_list
 * @property integer $catid
 * @property integer $global
 * @property integer $priority
 * @property integer $ordering
 * @property string $access
 * @property integer $published
 * @property string $created
 * @property string $created_by
 * @property string $created_by_alias
 * @property string $modified_by
 * @property string $checked_out
 * @property string $checked_out_time
 * @property string $params
 * @property string $anonname
 * @property string $anonemail
 * @property string $imagetitle
 */
class Locations extends CActiveRecord
{
	public $location_feature;
	public $last_url;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jos_jev_locations';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title,catid_list,street,city,state,country,postcode','required'),
			array('geozoom, pcode_id, loccat, catid, global, priority, ordering, published', 'numerical', 'integerOnly'=>true),
			array('geolon, geolat,', 'numerical'),
			array('title, alias, street, postcode, city, state, country, image, url, anonname, anonemail, imagetitle,phone', 'length', 'max'=>255),
			array('description,last_url','length', 'max'=>5000),
			array('access, created_by, modified_by, checked_out', 'length', 'max'=>11),
			array('created_by_alias', 'length', 'max'=>100),
			array('created, checked_out_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('loc_id, title, alias, street, postcode, city, state, country, description, geolon, geolat, geozoom, pcode_id, image, phone, url, loccat, catid_list, catid, global, priority, ordering, access, published, created, created_by, created_by_alias, modified_by, checked_out, checked_out_time, params, anonname, anonemail, imagetitle,location_feature', 'safe', 'on'=>'search'),
			array('image', 'file', 'allowEmpty'=>true, 'types'=>'jpg,jpeg,gif,png'),
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
		'categoriesCat' => array(self::BELONGS_TO,'Categories','catid_list'),
		'locationfeatured' => array(self::BELONGS_TO,'LocationCustomfields',array('loc_id'=>'target_id')),
		);
	}

    public function CatName($catid_list)
    {
        if($catid_list != "") {
            $criteria = new CDbCriteria();
            $criteria->select = 'GROUP_CONCAT(CONCAT_WS(" ",t.title) SEPARATOR ", ") as title';
            $criteria->condition = 'id IN('.$catid_list.')';

            $data = Categories::model()->find($criteria);
            return $data->title;
        }
    }



	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'loc_id' => 'ID',
			'title' => 'Location Name',
			'alias' => 'Alias',
			'street' => 'Street',
			'postcode' => 'Postcode',
			'city' => 'City',
			'state' => 'State',
			'country' => 'Country',
			'description' => 'Description',
			'geolon' => 'Geolon',
			'geolat' => 'Geolat',
			'geozoom' => 'Geozoom',
			'pcode_id' => 'Pcode',
			'image' => 'Image',
			'phone' => 'Phone',
			'url' => 'Url',
			'loccat' => 'Loccat',
			'catid_list' => 'Category',
			'catid' => 'Catid',
			'global' => 'Global',
			'priority' => 'Priority',
			'ordering' => 'Ordering',
			'access' => 'Access',
			'published' => 'Published',
			'created' => 'Created',
			'created_by' => 'Created By',
			'created_by_alias' => 'Created By Alias',
			'modified_by' => 'Modified By',
			'checked_out' => 'Checked Out',
			'checked_out_time' => 'Checked Out Time',
			'params' => 'Params',
			'anonname' => 'Anonname',
			'anonemail' => 'Anonemail',
			'imagetitle' => 'Imagetitle',
			//'categoriesCat.title' => 'Category',
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
		
		$criteria->with=array('locationfeatured');
		$criteria->compare('locationfeatured.value',$this->location_feature, TRUE );
		$criteria->compare('loc_id',$this->loc_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('street',$this->street,true);
		$criteria->compare('postcode',$this->postcode,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('geolon',$this->geolon);
		$criteria->compare('geolat',$this->geolat);
		$criteria->compare('geozoom',$this->geozoom);
		$criteria->compare('pcode_id',$this->pcode_id);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('loccat',$this->loccat);
		/* Get location category ids from url and create array to find in dB start*/
		if(isset($_REQUEST['Locations']['catid_list']) && $_REQUEST['Locations']['catid_list']!=''){
			$location_cat = $_REQUEST['Locations']['catid_list'];
		}else if(isset($_REQUEST['cat_id']) && $_REQUEST['cat_id']!=''){
			$location_cat = CommonController::explode_catids("|",$_REQUEST['cat_id']);
		}
		$location_cat_concat = CommonController::find_catids_in_set($location_cat);
		$criteria->addCondition($location_cat_concat);
		/* Get location category ids from url and create array to find in dB END */
		
		//$criteria->compare('catid_list',$this->catid_list,true);
		//$criteria->compare('catid',$this->catid);
		$criteria->compare('global',$this->global);
		$criteria->compare('priority',$this->priority);
		$criteria->compare('ordering',$this->ordering);
		$criteria->compare('access',$this->access,true);
		$criteria->compare('published',$this->published);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('created_by_alias',$this->created_by_alias,true);
		$criteria->compare('modified_by',$this->modified_by,true);
		$criteria->compare('checked_out',$this->checked_out,true);
		$criteria->compare('checked_out_time',$this->checked_out_time,true);
		$criteria->compare('params',$this->params,true);
		$criteria->compare('anonname',$this->anonname,true);
		$criteria->compare('anonemail',$this->anonemail,true);
		$criteria->compare('imagetitle',$this->imagetitle,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
		        'defaultOrder'=>'loc_id DESC',
				),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Locations the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
