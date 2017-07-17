<?php

/**
 * This is the model class for table "jos_jevents_vevent".
 *
 * The followings are the available columns in table 'jos_jevents_vevent':
 * @property integer $ev_id
 * @property integer $icsid
 * @property integer $catid
 * @property string $uid
 * @property string $refreshed
 * @property string $created
 * @property string $created_by
 * @property string $created_by_alias
 * @property string $modified_by
 * @property string $rawdata
 * @property string $recurrence_id
 * @property integer $detail_id
 * @property integer $state
 * @property string $access
 * @property integer $lockevent
 * @property integer $author_notified
 */
class Events extends CActiveRecord
{
	public $event_search;
	public $event_rule;
	public $event_feature;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jos_jevents_vevent';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('catid', 'required'),
			array('icsid, catid, detail_id, state, lockevent, author_notified', 'numerical', 'integerOnly'=>true),
			array('uid', 'length', 'max'=>255),
			array('created_by, modified_by, access', 'length', 'max'=>11),
			array('created_by_alias', 'length', 'max'=>100),
			array('recurrence_id', 'length', 'max'=>30),
			array('refreshed, created', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ev_id, icsid, catid, uid, refreshed, created, created_by, created_by_alias, modified_by, rawdata, recurrence_id, detail_id, state, access, lockevent, author_notified,event_feature,event_search,event_rule', 'safe', 'on'=>'search'),
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
		'categoriesCat' => array(self::BELONGS_TO,'Categories','catid'),
		'eventsDetaildata' => array(self::BELONGS_TO,'EventsDetail','detail_id'),
		'eventsRuledata' => array(self::BELONGS_TO,'EventsRule','ev_id'),
		'eventsrepeatdata' => array(self::BELONGS_TO,'Eventsrepetition','ev_id'),
		'eventfeatured' => array(self::BELONGS_TO,'Eventcustomfields',array('detail_id'=>'evdet_id')),
		'usersData' => array(self::BELONGS_TO,'Users','created_by'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ev_id' => 'ID',
			'icsid' => 'Icsid',
			'catid' => 'Events Category',
			'uid' => 'Uid',
			'refreshed' => 'Refreshed',
			'created' => 'Created By',
			'created_by' => 'Created By',
			'created_by_alias' => 'Created By Alias',
			'modified_by' => 'Modified By',
			'rawdata' => 'Rawdata',
			'recurrence_id' => 'Recurrence',
			'detail_id' => 'Detail',
			'state' => 'Status',
			'access' => 'Access',
			'lockevent' => 'Lockevent',
			'author_notified' => 'Author Notified',
			'eventsDetaildata.summary' => 'Event Summary',
			'eventsRuledata' => 'Event Rule Summary',
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
	
		$criteria->with = array('eventsDetaildata','eventfeatured');
		$criteria->compare('eventsDetaildata.summary',$this->event_search, TRUE );
		$criteria->with = array('eventsRuledata','eventsRuledata');
		$criteria->compare('eventsRuledata',$this->event_rule, TRUE );
		
		# Yogi: Code to hide or show past event START ****************
		if(!isset($_REQUEST['past']) || $_REQUEST['past'] == 0){
			$eventID = array();
			$currentDate = date('Y-m-d H:i:s');
			//$criteria->addCondition("FROM_UNIXTIME(eventsDetaildata.dtend) >= NOW()");
			//$criteria->addCondition("FROM_UNIXTIME(eventsDetaildata.dtend) >= '$currentDate' ");
			
			
			# Yogi: Fetch Event Detail ID's from jos_jevents_rrule table for repeat untill date
			$getRepeatUntilData = EventsRule::model()->findAll("FROM_UNIXTIME(UNTIL) >= '$currentDate' ");
			if(isset($getRepeatUntilData) && $getRepeatUntilData > 0){
				foreach($getRepeatUntilData as $key => $value){ 
					$eventID[] = $value['eventid'];
				}
			}
			
			# Yogi: Fetch Event Detail ID's from jos_jevents_vevdetail table for end date
			$getendDate = EventsDetail::model()->findAll("FROM_UNIXTIME(dtend) >= '$currentDate' ");
			if(isset($getendDate) && count($getendDate) > 0){
				foreach($getendDate as $key => $value){ 
					$eventDetailIDarr[] = $value['evdet_id'];
				}
			}
				
			# Yogi: Comma seprated event detail ID
			if(isset($eventDetailIDarr) && count($eventDetailIDarr) > 0){
				$eventDetailIDs = implode(',',$eventDetailIDarr);
				# Fetch Event Detail ID's from jos_jevents_vevent for 
				$getEventArray = Events::model()->findAll("detail_id IN ($eventDetailIDs)");
				foreach($getEventArray as $key => $value){ 
					$eventID[] = $value['ev_id'];
				}	
			}
			$criteria->compare('ev_id',$eventID);
		}else{
			$criteria->compare('ev_id',$this->ev_id);
		}
		
		# Yogi: Code to hide or show past event END ****************
		
		//$criteria->addCondition("eventsDetaildata.dtend<='".strtotime(date('Y-m-d H:i:s'))."'");
		$criteria->compare('eventfeatured.value',$this->event_feature, TRUE );
		$criteria->compare('icsid',$this->icsid);
		
		if((isset($_REQUEST['Events']['catid']) && $_REQUEST['Events']['catid']!='')){
			$cat_ids = $_REQUEST['Events']['catid'];
		}elseif(isset($_REQUEST['cat_id']) && $_REQUEST['cat_id'] != ''){
			$get_cat = Categories::model()->findAll('section="com_jevents" and published=1 and id in('.$_REQUEST["cat_id"].') or parent_id in('.$_REQUEST["cat_id"].') ORDER BY title ASC');
			foreach($get_cat as $key=>$value){
				$cat_ids[] = $value['id'];
			}
		}else{
			$cat_ids = '';
		}
		
		
		$criteria->compare('catid',$cat_ids);
		//$criteria->compare('catid',$this->catid);
		$criteria->compare('uid',$this->uid,true);
		$criteria->compare('refreshed',$this->refreshed,true);
		$criteria->compare('t.created',$this->created,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('created_by_alias',$this->created_by_alias,true);
		$criteria->compare('modified_by',$this->modified_by,true);
		$criteria->compare('rawdata',$this->rawdata,true);
		$criteria->compare('recurrence_id',$this->recurrence_id,true);
		$criteria->compare('detail_id',$this->detail_id);
		$criteria->compare('t.state',$this->state);
		$criteria->compare('access',$this->access,true);
		$criteria->compare('lockevent',$this->lockevent);
		$criteria->compare('author_notified',$this->author_notified);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array( # CODE FOR SET PAGE SIZE START
				'pageSize' => Yii::app()->user->getState( 'pageSizeEvents', Yii::app()->params[ 'defaultPageSize' ] ),
			), # CODE FOR SET PAGE SIZE END 
			'sort'=>array(
		        'defaultOrder'=>'t.ev_id DESC',
				'attributes'=>array(
					'ev_id'=>array(
						'desc'=>'t.ev_id DESC',
				        'asc'=>'t.ev_id ASC',
 				    ),
					'event_search'=>array(
				        'asc'=>'eventsDetaildata.summary ASC',
				        'desc'=>'eventsDetaildata.summary DESC',
				    ),
					'eventsDetaildata.dtstart'=>array(
				        'asc'=>'eventsDetaildata.dtstart ASC',
				        'desc'=>'eventsDetaildata.dtstart DESC',
				    ),
					'event_feature'=>array(
				        'asc'=>'eventfeatured.value ASC',
				        'desc'=>'eventfeatured.value DESC',
				    ),
					'state'=>array(
				        'asc'=>'t.state ASC',
				        'desc'=>'t.state DESC',
				    ),
	            ),
		    ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Events the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
