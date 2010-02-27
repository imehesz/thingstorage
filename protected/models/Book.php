<?php

class Book extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'books':
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
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
		return 'books';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
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
		);
	}

	public function findBook( $isbn )
	{
        // let's see if we have this in our database
        $book = $this->findByAttributes(array('isbn'=>$isbn));
        
        if( ! $book )
        {
            $book = $this -> findByAttributes(array('isbn13'=>$isbn));
        }

        if( $book )
        {
            return $book;
        }

		// default XML after ISBN search
/*		$isbnsearch = <<<ISBN
<?xml version="1.0" encoding="UTF-8"?>

<ISBNdb server_time="2010-01-31T03:58:00Z">
<BookList total_results="1" page_size="10" page_number="1" shown_results="1">
<BookData book_id="harry_potter_and_the_prisoner_of_azkaban_a03" isbn="0439136350" isbn13="9780439136358">
<Title>Harry Potter and the prisoner of Azkaban</Title>
<TitleLong></TitleLong>
<AuthorsText>by J. K. Rowling</AuthorsText>
<PublisherText publisher_id="arthur_a_levine_books">New York : Arthur A. Levine Books, 1999.</PublisherText>
<Summary>During his third year at Hogwarts School for Witchcraft and Wizardry, Harry Potter must confront the devious and dangerous wizard responsible for his parents' deaths.</Summary>
<Notes>"Year 3"--Spine.

Sequel to: Harry Potter and the Chamber of Secrets.</Notes>
<UrlsText></UrlsText>

<AwardsText></AwardsText>
</BookData>
</BookList>
</ISBNdb>
ISBN; */
		// die( ISBN_SEARCH_URL . $isbn );
        $isbnsearch = @file_get_contents( ISBN_SEARCH_URL . $isbn );

        if(! $isbnsearch )
		{
			return false;
		}

		$xml_obj = @simplexml_load_string( $isbnsearch );
        // var_dump( $xml_obj );
        
		if( $xml_obj && (int)$xml_obj->BookList->attributes()->total_results[0] != 0 )
		{
			$book = new Book;
            
			$book -> isbn 		= (string)$xml_obj->BookList->BookData->attributes()->isbn;
			$book -> isbn13 	= (string)$xml_obj->BookList->BookData->attributes()->isbn13;
			$book -> title		= (string)$xml_obj->BookList->BookData->Title;
			$book -> author		= (string)$xml_obj->BookList->BookData->AuthorsText;
			$book -> publisher	= (string)$xml_obj->BookList->BookData->PublisherText;
			$book -> summary	= (string)$xml_obj->BookList->BookData->Summary;
			$book -> notes		= (string)$xml_obj->BookList->BookData->Notes;
			$book -> created	= time();

			$book->save();
			return $book;
		}

		return false;
	}	
}
