<?php

/**
 * This is the model class for table "jos_content".
 *
 * The followings are the available columns in table 'jos_content':
 * @property string $id
 * @property string $title
 * @property string $alias
 * @property string $title_alias
 * @property string $introtext
 * @property string $fulltext
 * @property integer $state
 * @property string $sectionid
 * @property string $mask
 * @property string $catid
 * @property string $created
 * @property string $created_by
 * @property string $created_by_alias
 * @property string $modified
 * @property string $modified_by
 * @property string $checked_out
 * @property string $checked_out_time
 * @property string $publish_up
 * @property string $publish_down
 * @property string $images
 * @property string $urls
 * @property string $attribs
 * @property string $version
 * @property string $parentid
 * @property integer $ordering
 * @property string $metakey
 * @property string $metadesc
 * @property string $access
 * @property string $hits
 * @property string $metadata
 */
class Contents extends CActiveRecord
{
	public $last_url;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jos_content';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title,sectionid', 'required'),
			array('state, ordering', 'numerical', 'integerOnly'=>true),
			array('title, alias, title_alias,sectionid, mask, catid, created_by_alias', 'length', 'max'=>255),
			array('introtext,last_url', 'length', 'max'=>15000),
			array('created_by, modified_by, checked_out, version, parentid, access, hits', 'length', 'max'=>11),
			array('created, modified, checked_out_time, publish_up, publish_down', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, alias, title_alias, introtext, fulltext, state, sectionid, mask, catid, created, created_by, created_by_alias, modified, modified_by, checked_out, checked_out_time, publish_up, publish_down, images, urls, attribs, version, parentid, ordering, metakey, metadesc, access, hits, metadata', 'safe', 'on'=>'search'),
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
		'articleCat' => array(self::BELONGS_TO,'Categories','catid'),
		'sectiontitle' => array(self::BELONGS_TO,'Sections','sectionid'),
		'frontpage' => array(self::BELONGS_TO,'Frontpage','id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Article Name',
			'alias' => 'Alias',
			'title_alias' => 'Title Alias',
			'introtext' => 'Description',
			'fulltext' => 'Fulltext',
			'state' => 'Status',
			'sectionid' => 'Category',
			'sectiontitle.title'=>'Section',
			'articleCat.title'=>'Category',
			'frontpage.content_id'=>'Frontpage',
			'frontpage.ordering'=>'Ordering',
			'mask' => 'Frontpage',
			'catid' => 'Category',
			'created' => 'Date',
			'created_by' => 'Created By',
			'created_by_alias' => 'Created By Alias',
			'modified' => 'Modified',
			'modified_by' => 'Modified By',
			'checked_out' => 'Checked Out',
			'checked_out_time' => 'Checked Out Time',
			'publish_up' => 'Start Publishing',
			'publish_down' => 'Finish Publishing',
			'images' => 'Images',
			'urls' => 'Urls',
			'attribs' => 'Attribs',
			'version' => 'Version',
			'parentid' => 'Parentid',
			'ordering' => 'Ordering',
			'metakey' => 'Metakey',
			'metadesc' => 'Metadesc',
			'access' => 'Access',
			'hits' => 'Hits',
			'metadata' => 'Metadata',
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
		$criteria->with=array('frontpage');
		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('title_alias',$this->title_alias,true);
		$criteria->compare('introtext',$this->introtext,true);
		$criteria->compare('fulltext',$this->fulltext,true);
		$criteria->compare('state',$this->state);
		$criteria->compare('sectionid',$this->sectionid,true);
		$criteria->compare('mask',$this->mask,true);
		if(isset($_REQUEST['cat_id'])){
			$cat_id = $_REQUEST['cat_id'];
		}
		$criteria->compare('catid',$cat_id,true);
		//$criteria->compare('catid',$this->catid,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('created_by_alias',$this->created_by_alias,true);
		$criteria->compare('modified',$this->modified,true);
		$criteria->compare('modified_by',$this->modified_by,true);
		$criteria->compare('checked_out',$this->checked_out,true);
		$criteria->compare('checked_out_time',$this->checked_out_time,true);
		$criteria->compare('publish_up',$this->publish_up,true);
		$criteria->compare('publish_down',$this->publish_down,true);
		$criteria->compare('images',$this->images,true);
		$criteria->compare('urls',$this->urls,true);
		$criteria->compare('attribs',$this->attribs,true);
		$criteria->compare('version',$this->version,true);
		$criteria->compare('parentid',$this->parentid,true);
		$criteria->compare('ordering',$this->ordering);
		$criteria->compare('metakey',$this->metakey,true);
		$criteria->compare('metadesc',$this->metadesc,true);
		$criteria->compare('access',$this->access,true);
		$criteria->compare('hits',$this->hits,true);
		$criteria->compare('metadata',$this->metadata,true);

		// Condition to check that Trashed or Deleted menu should not display
		$criteria->addCondition("state <> -2");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array( # CODE FOR SET PAGE SIZE START
				'pageSize' => Yii::app()->user->getState( 'pageSize'.__CLASS__, Yii::app()->params[ 'defaultPageSize' ] ),
			), # CODE FOR SET PAGE SIZE END 
			
			'sort'=>array(
		        'defaultOrder'=>'t.ordering ASC, t.created DESC',
				'attributes'=>array(
	                'frontpage.content_id'=>array(
				        'asc'=>'frontpage.content_id ASC',
				        'desc'=>'frontpage.content_id DESC',
				    ),
					'id'=>array(
				        'asc'=>'id ASC',
				        'desc'=>'t.id DESC',
				    ),
					'title'=>array(
				        'asc'=>'title ASC',
				        'desc'=>'title DESC',
				    ),
					'state'=>array(
				        'asc'=>'state ASC',
				        'desc'=>'state DESC',
				    ),
					'ordering'=>array(
				        'asc'=>'t.ordering ASC',
				        'desc'=>'t.ordering DESC',
				    ),
					'hits'=>array(
				        'asc'=>'hits ASC',
				        'desc'=>'hits DESC',
				    ),
					'created'=>array(
				        'asc'=>'created ASC',
				        'desc'=>'created DESC',
				    ),
	            ),
		    ),
		));
	}
	
	public function searchFront()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with=array('frontpage'); 
		$criteria->addCondition('frontpage.content_id',$this->id);
		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('title_alias',$this->title_alias,true);
		$criteria->compare('introtext',$this->introtext,true);
		$criteria->compare('fulltext',$this->fulltext,true);
		$criteria->compare('state',$this->state);
		$criteria->compare('sectionid',$this->sectionid,true);
		$criteria->compare('mask',$this->mask,true);
		$criteria->compare('catid',$this->catid,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('created_by_alias',$this->created_by_alias,true);
		$criteria->compare('modified',$this->modified,true);
		$criteria->compare('modified_by',$this->modified_by,true);
		$criteria->compare('checked_out',$this->checked_out,true);
		$criteria->compare('checked_out_time',$this->checked_out_time,true);
		$criteria->compare('publish_up',$this->publish_up,true);
		$criteria->compare('publish_down',$this->publish_down,true);
		$criteria->compare('images',$this->images,true);
		$criteria->compare('urls',$this->urls,true);
		$criteria->compare('attribs',$this->attribs,true);
		$criteria->compare('version',$this->version,true);
		$criteria->compare('parentid',$this->parentid,true);
		$criteria->compare('ordering',$this->ordering);
		$criteria->compare('metakey',$this->metakey,true);
		$criteria->compare('metadesc',$this->metadesc,true);
		$criteria->compare('access',$this->access,true);
		$criteria->compare('hits',$this->hits,true);
		$criteria->compare('metadata',$this->metadata,true);
		
		$criteria->addCondition("state <> -2");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,			
			'pagination' => array( # CODE FOR SET PAGE SIZE START
				'pageSize' => Yii::app()->user->getState( 'pageSizeContents', Yii::app()->params[ 'defaultPageSize' ] ),
			), # CODE FOR SET PAGE SIZE END 
			'sort'=>array(
		        'defaultOrder'=>'frontpage.ordering ASC',
				'attributes'=>array(
	                'frontpage.ordering'=>array(
				        'asc'=>'frontpage.ordering ASC',
				        'desc'=>'frontpage.ordering DESC',
				    ),
					'id'=>array(
				        'asc'=>'id ASC',
				        'desc'=>'id DESC',
				    ),
					'title'=>array(
				        'asc'=>'title ASC',
				        'desc'=>'title DESC',
				    ),
	            ),
		    ),
			
		));
	}

	/*public function searchArticlecat()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		
		$model_cat = new Categories;
		$criteria1 = new CDbCriteria;
		$criteria1->addSearchCondition('scope','content', true);
		$secData = Sections::model()->findAll($criteria1);
		$criteria2 = new CDbCriteria;
		if(count($secData)>0)
		{	
			foreach($secData as $id=>$value){
				$criteria2->condition .= 'section='.$value['id'];
				if(count($secData)-1!=$id)
				{
					$criteria2->condition .= ' || ';
				}
			}
		}

		return new CActiveDataProvider($model_cat, array(
			'criteria'=>$criteria2,
			'sort'=>array(
		        'defaultOrder'=>'ordering ASC',
		    ),
		));
	}*/
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Contents the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
