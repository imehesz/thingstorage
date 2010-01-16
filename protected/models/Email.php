<?php

class Email extends CFormModel
{

	/**
	 *
	 */
	public $email_address;

	/**
	 *
	 */
	public $subject;

	/**
	 *
	 */
	public $body;

	/**
	 *
	 */
	public $remember_me;

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
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
}
