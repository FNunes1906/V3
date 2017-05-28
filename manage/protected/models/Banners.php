<?php
 
/**
 * This is the model class for table "jos_banner".
 *
 * The followings are the available columns in table 'jos_banner':
 * @property integer $bid
 * @property integer $cid
 * @property string $type
 * @property string $name
 * @property string $alias
 * @property integer $imptotal
 * @property integer $impmade
 * @property integer $clicks
 * @property string $imageurl
 * @property string $clickurl
 * @property string $date
 * @property integer $showBanner
 * @property integer $checked_out
 * @property string $checked_out_time
 * @property string $editor
 * @property string $custombannercode
 * @property string $catid
 * @property string $description
 * @property integer $sticky
 * @property integer $ordering
 * @property string $publish_up
 * @property string $publish_down
 * @property string $tags
 * @property string $params
 */
class Banners extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jos_banner';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name,catid', 'required'),
			array('cid, imptotal, impmade, clicks, showBanner, checked_out, sticky, ordering', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>30),
			array('name, alias', 'length', 'max'=>255),
			array('imageurl', 'length', 'max'=>100),
			array('clickurl', 'length', 'max'=>200),
			array('editor', 'length', 'max'=>50),
			array('catid', 'length', 'max'=>10),
			array('date, checked_out_time, custombannercode, publish_up, publish_down', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('bid, cid, type, name, alias, imptotal, impmade, clicks, imageurl, clickurl, date, showBanner, checked_out, checked_out_time, editor, custombannercode, catid, description, sticky, ordering, publish_up, publish_down, tags, params', 'safe', 'on'=>'search'),
			array('imageurl', 'file', 'allowEmpty'=>true, 'types'=>'jpg,jpeg,gif,png'),
			array('imageurl', 'safe', 'on'=>''),
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
		'bannersCat' => array(self::BELONGS_TO,'Categories','catid'),
		'clients' => array(self::BELONGS_TO,'Bannerclient','cid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'bid' => 'ID',
			'cid' => 'Client Name',
			'type' => 'Type',
			'name' => 'Banner Name',
			'alias' => 'Alias',
			'imptotal' => 'Imptotal',
			'impmade' => 'Impressions',
			'clicks' => 'Clicks',
			'imageurl' => 'Banner Image',
			'clickurl' => 'Click URL',
			'date' => 'Date',
			'showBanner' => 'Publish',
			'checked_out' => 'Checked Out',
			'checked_out_time' => 'Checked Out Time',
			'editor' => 'Editor',
			'custombannercode' => 'Custom Banner Code',
			'catid' => 'Banner Category',
			'description' => 'Description',
			'sticky' => 'Sticky',
			'ordering' => 'Ordering',
			'publish_up' => 'Publish Up',
			'publish_down' => 'Publish Down',
			'tags' => 'Tags',
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

		$criteria=new CDbCriteria;
		
		$criteria->compare('bid',$this->bid);
		$criteria->compare('cid',$this->cid);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('imptotal',$this->imptotal);
		$criteria->compare('impmade',$this->impmade);
		$criteria->compare('clicks',$this->clicks);
		$criteria->compare('imageurl',$this->imageurl,true);
		$criteria->compare('clickurl',$this->clickurl,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('showBanner',$this->showBanner);
		$criteria->compare('checked_out',$this->checked_out);
		$criteria->compare('checked_out_time',$this->checked_out_time,true);
		$criteria->compare('editor',$this->editor,true);
		$criteria->compare('custombannercode',$this->custombannercode,true);
		$criteria->compare('catid',$this->catid,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('sticky',$this->sticky);
		$criteria->compare('ordering',$this->ordering);
		$criteria->compare('publish_up',$this->publish_up,true);
		$criteria->compare('publish_down',$this->publish_down,true);
		$criteria->compare('tags',$this->tags,true);
		$criteria->compare('params',$this->params,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array( # CODE FOR SET PAGE SIZE START
				'pageSize' => Yii::app()->user->getState( 'pageSizeBanner', Yii::app()->params[ 'defaultPageSize' ] ),
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
	 * @return Banners the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
