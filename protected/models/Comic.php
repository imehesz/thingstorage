<?php

/**
 * This is the model class for table "comics".
 *
 * The followings are the available columns in table 'comics':
 * @property integer $created
 * @property string $cvID
 * @property integer $id
 * @property string $name
 * @property string $url
 *
 * The followings are the available model relations:
 */
class Comic extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Comic the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'comics';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('created,year,issue', 'numerical', 'integerOnly'=>true),
			array('cvID', 'length', 'max'=>50),
			array('name,volume', 'length', 'max'=>100),
			array('url,image', 'length', 'max'=>250),
			array('description', 'length', 'max' => 2000 ),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('issue,year,description,created,cvID,id, name, url', 'safe', 'on'=>'search'),
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
			'created' => 'Created',
			'cvID' => 'Cv',
			'id' => 'ID',
			'name' => 'Name',
			'url' => 'Url',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('created',$this->created);
		$criteria->compare('cvID',$this->cvID,true);
		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('url',$this->url,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	public function getComics( $name )
	{
		$comics = array();
		// http://api.comicvine.com/characters/?api_key=ABCDEF123456&gender=M&sort=birth_date&format=xml
		$search_url = 'http://api.comicvine.com/search/?api_key=' . COMICVINE_API_KEY . '&query=' . urlencode( $name ) . '&format=json';
		// $search_url = 'http://storedbyu.acer.local/comics.json';
		$stream=fopen( $search_url, 'r' );

		if( $stream )
		{
			$json_raw = stream_get_contents( $stream );
			// $json_raw = preg_replace('/.+?({.+}).+/','$1',$json_raw);
			// $json_raw = '{"a":"&nbsp<strong>aaa</strong> <a href=\"http://google.com\">google.com</a>"}';
			$json_obj = json_decode( $json_raw );
			if( $json_obj && $json_obj->status_code == 1 )
			{
				$results = $json_obj->results;
				foreach ( $results as $row ) 
				{
					$cvID			= isset( $row->id )					? $row->id					: 0;
					$url 			= isset( $row->site_detail_url ) 	? $row->site_detail_url 	: '';
					$description 	= isset( $row->description )		? 
										html_entity_decode(strip_tags($row->description) )			: '';
					$image			= isset( $row->image )				? $row->image->thumb_url	: '';
					$volume			= isset( $row->volume )				? $row->volume->name		: '';
					$issue_nr		= isset( $row->issue_number )		? (int)$row->issue_number	: 0;
					$year 			= isset( $row->publish_year )		? (int)$row->publish_year	: 0;
					$name			= isset( $row->name )				? $row->name				: '';
			
					// if there is no ComicVine  ID (cvID) we don't do anything ...
					if( $cvID )
					{
						$comic = Comic::model()->findByAttributes( array( 'cvID' => $cvID ) );
		
						// if we don't have it, we'll create it ... 
						if( ! $comic )
						{
							$comic = new Comic();
							$comic->setAttributes(
								array(
									'cvID'			=> $cvID,
									'url'			=> $url,
									'description'	=> $description,
									'image'			=> $image,
									'volume'		=> $volume,
									'issue'			=> $issue_nr,
									'year'			=> $year,
									'name'			=> $name,
									'created'		=> time(),
								)
							);
							
							$comic->save();
						}

						$comics[] = $comic;
					}
					// let's check if we already have this comic in our DB
				}
			}
		}
		return $comics;
	}
}
