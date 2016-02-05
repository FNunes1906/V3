<?php

/**
 * This is the model class for table "jos_jevents_vevdetail".
 *
 * The followings are the available columns in table 'jos_jevents_vevdetail':
 * @property integer $evdet_id
 * @property string $rawdata
 * @property integer $dtstart
 * @property string $dtstartraw
 * @property integer $duration
 * @property string $durationraw
 * @property integer $dtend
 * @property string $dtendraw
 * @property string $dtstamp
 * @property string $class
 * @property string $categories
 * @property string $color
 * @property string $description
 * @property double $geolon
 * @property double $geolat
 * @property string $location
 * @property integer $priority
 * @property string $status
 * @property string $summary
 * @property string $contact
 * @property string $organizer
 * @property string $url
 * @property string $extra_info
 * @property string $created
 * @property integer $sequence
 * @property integer $state
 * @property integer $multiday
 * @property integer $hits
 * @property integer $noendtime
 * @property string $modified
 */
class EventsDetail extends CActiveRecord
{
	public $last_url;	
	public $catid;
	public $collapseWeekly;
	public $collapseMonthly;
	public $collapseYearly;
	public $collapseDaily;
	public $repeatUntil;
	public $rdodaily;
	public $rdoweekly;
	public $rdomonthly;
	public $rdoyearly;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jos_jevents_vevdetail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dtstart,dtend,summary,location,catid', 'required'),
			
			array('dtend','compare','compareAttribute'=>'dtstart','operator'=>'>=', 'message'=>'{attribute} must be greater than or equal to Start Date'),
			
			
			array('duration, priority, sequence, state, multiday, hits, noendtime', 'numerical', 'integerOnly'=>true),
			array('geolon, geolat', 'numerical'),
			array('dtstartraw, durationraw, dtendraw, dtstamp, created', 'length', 'max'=>30),
			array('class', 'length', 'max'=>10),
			array('categories, location, contact, organizer', 'length', 'max'=>120),
			array('color, status', 'length', 'max'=>20),
			array('extra_info', 'length', 'max'=>240),
			array('modified', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('evdet_id, rawdata, dtstart, dtstartraw, duration, durationraw, dtend, dtendraw, dtstamp, class, categories, color, description, geolon, geolat, location, priority, status, summary, contact, organizer, url, extra_info, created, sequence, state, multiday, hits, noendtime, modified', 'safe', 'on'=>'search'),
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
			'event_data' => array(self::BELONGS_TO,'Events','evdet_id'),
			'event_featured' => array(self::BELONGS_TO,'Eventcustomfields','evdet_id'),
			'location_data' => array(self::BELONGS_TO,'Locations','location'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'evdet_id' => 'Evdet',
			'rawdata' => 'Rawdata',
			'dtstart' => 'Start Date',
			'dtstartraw' => 'Dtstartraw',
			'duration' => 'Duration',
			'durationraw' => 'Durationraw',
			'dtend' => 'End Date',
			'dtendraw' => 'Dtendraw',
			'dtstamp' => 'Dtstamp',
			'class' => 'Class',
			'categories' => 'Categories',
			'color' => 'Color',
			'description' => 'Description',
			'geolon' => 'Geolon',
			'geolat' => 'Geolat',
			'location' => 'Location',
			'priority' => 'Priority',
			'status' => 'Status',
			'summary' => 'Event Name',
			'contact' => 'Contact',
			'organizer' => 'Organizer',
			'url' => 'Url',
			'extra_info' => 'Extra Info',
			'created' => 'Created',
			'sequence' => 'Sequence',
			'state' => 'Published',
			'multiday' => 'Multiday',
			'hits' => 'Hits',
			'noendtime' => 'All Day Event',
			'modified' => 'Modified',
			'catid'=>'Category',
			'collapseWeekly'=>'Weekly',
			'collapseMonthly'=>'Month Days',
			'collapseYearly'=>'Yearly',
			'collapseDaily'=>'Daily',
			'repeatUntil'=>'Repeat Until',
			'rdonorepeat'=>'No Repeat',
			'rdodaily'=>'Daily',
			'rdoweekly'=>'Weekly',
			'rdomonthly'=>'Monthly',
			'rdoyearly'=>'Yearly',
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
		$criteria->with=array('event_data');
		$criteria->addCondition('event_data.detail_id',$this->evdet_id, TRUE );
		$criteria->compare('evdet_id',$this->evdet_id);
		$criteria->compare('rawdata',$this->rawdata,true);
		$criteria->compare('dtstart',$this->dtstart);
		$criteria->compare('dtstartraw',$this->dtstartraw,true);
		$criteria->compare('duration',$this->duration);
		$criteria->compare('durationraw',$this->durationraw,true);
		$criteria->compare('dtend',$this->dtend);
		$criteria->compare('dtendraw',$this->dtendraw,true);
		$criteria->compare('dtstamp',$this->dtstamp,true);
		$criteria->compare('class',$this->class,true);
		$criteria->compare('categories',$this->categories,true);
		$criteria->compare('color',$this->color,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('geolon',$this->geolon);
		$criteria->compare('geolat',$this->geolat);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('priority',$this->priority);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('summary',$this->summary,true);
		$criteria->compare('contact',$this->contact,true);
		$criteria->compare('organizer',$this->organizer,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('extra_info',$this->extra_info,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('sequence',$this->sequence);
		$criteria->compare('state',$this->state);
		$criteria->compare('multiday',$this->multiday);
		$criteria->compare('hits',$this->hits);
		$criteria->compare('noendtime',$this->noendtime);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EventsDetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
