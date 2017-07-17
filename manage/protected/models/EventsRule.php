<?php

/**
 * This is the model class for table "jos_jevents_rrule".
 *
 * The followings are the available columns in table 'jos_jevents_rrule':
 * @property integer $rr_id
 * @property integer $eventid
 * @property string $freq
 * @property integer $until
 * @property string $untilraw
 * @property integer $count
 * @property integer $rinterval
 * @property string $bysecond
 * @property string $byminute
 * @property string $byhour
 * @property string $byday
 * @property string $bymonthday
 * @property string $byyearday
 * @property string $byweekno
 * @property string $bymonth
 * @property string $bysetpos
 * @property string $wkst
 */
class EventsRule extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jos_jevents_rrule';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('eventid, until, count, rinterval', 'numerical', 'integerOnly'=>true),
			array('freq, untilraw', 'length', 'max'=>30),
			array('bysecond, byminute, byhour, byday, bymonthday, byyearday, byweekno, bymonth, bysetpos, wkst', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('rr_id, eventid, freq, until, untilraw, count, rinterval, bysecond, byminute, byhour, byday, bymonthday, byyearday, byweekno, bymonth, bysetpos, wkst', 'safe', 'on'=>'search'),
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
			'eventData'	=>	array(self::BELONGS_TO,'Events','eventid')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rr_id' => 'Rr',
			'eventid' => 'Eventid',
			'freq' => 'Freq',
			'until' => 'Until',
			'untilraw' => 'Untilraw',
			'count' => 'Count',
			'rinterval' => 'Rinterval',
			'bysecond' => 'Bysecond',
			'byminute' => 'Byminute',
			'byhour' => 'Byhour',
			'byday' => 'Byday',
			'bymonthday' => 'Bymonthday',
			'byyearday' => 'Byyearday',
			'byweekno' => 'Byweekno',
			'bymonth' => 'Bymonth',
			'bysetpos' => 'Bysetpos',
			'wkst' => 'Wkst',
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

		$criteria->compare('rr_id',$this->rr_id);
		$criteria->compare('eventid',$this->eventid);
		$criteria->compare('freq',$this->freq,true);
		$criteria->compare('until',$this->until);
		$criteria->compare('untilraw',$this->untilraw,true);
		$criteria->compare('count',$this->count);
		$criteria->compare('rinterval',$this->rinterval);
		$criteria->compare('bysecond',$this->bysecond,true);
		$criteria->compare('byminute',$this->byminute,true);
		$criteria->compare('byhour',$this->byhour,true);
		$criteria->compare('byday',$this->byday,true);
		$criteria->compare('bymonthday',$this->bymonthday,true);
		$criteria->compare('byyearday',$this->byyearday,true);
		$criteria->compare('byweekno',$this->byweekno,true);
		$criteria->compare('bymonth',$this->bymonth,true);
		$criteria->compare('bysetpos',$this->bysetpos,true);
		$criteria->compare('wkst',$this->wkst,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EventsRule the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
