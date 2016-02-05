<?php

/**
 * This is the model class for table "jos_pagemeta".
 *
 * The followings are the available columns in table 'jos_pagemeta':
 * @property integer $id
 * @property string $uri
 * @property string $title
 * @property string $metadesc
 * @property string $keywords
 * @property string $extra_meta
 */
class Pagemeta extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jos_pagemeta';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uri, title', 'required'),
			array('uri, title,metadesc, keywords, extra_meta', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, uri, title, metadesc, keywords, extra_meta', 'safe', 'on'=>'search'),
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
			'uri' => 'URL',
			'title' => 'Title',
			'metadesc' => 'Meta Description',
			'keywords' => 'Meta Keywords',
			'extra_meta' => 'Extra Meta',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('uri',$this->uri,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('metadesc',$this->metadesc,true);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('extra_meta',$this->extra_meta,true);

		/*return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));*/
		$pageSize = Yii::app()->request->getParam('pageSize');
        if(!$pageSize)
            $pageSize = Yii::app()->params['pagesize'];

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination' => array(
				'pageSize' => $pageSize,
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Pagemeta the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
