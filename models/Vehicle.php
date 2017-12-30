<?php

/**
 * This is the model class for table "vehicle".
 *
 * The followings are the available columns in table 'vehicle':
 * @property string $id
 * @property string $license
 * @property string $day_begin_time
 * @property string $day_end_time
 * @property string $day_driver
 * @property string $day_identity
 * @property string $day_phone
 * @property integer $day_rent
 * @property string $night_begin_time
 * @property string $night_end_time
 * @property string $night_driver
 * @property string $night_identity
 * @property string $night_phone
 * @property integer $night_rent
 */
class Vehicle extends RedActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vehicle';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('license, day_rent, night_rent', 'required'),
			array('day_rent, night_rent', 'numerical', 'integerOnly'=>true),
			array('license', 'length', 'max'=>10),
			array('day_driver, night_driver', 'length', 'max'=>50),
			array('day_identity, day_phone, night_identity, night_phone', 'length', 'max'=>25),
			array('day_begin_time, day_end_time, night_begin_time, night_end_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, license, day_begin_time, day_end_time, day_driver, day_identity, day_phone, day_rent, night_begin_time, night_end_time, night_driver, night_identity, night_phone, night_rent', 'safe', 'on'=>'search'),
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
			'license' => 'License',
			'day_begin_time' => 'Day Begin Time',
			'day_end_time' => 'Day End Time',
			'day_driver' => 'Day Driver',
			'day_identity' => 'Day Identity',
			'day_phone' => 'Day Phone',
			'day_rent' => 'Day Rent',
			'night_begin_time' => 'Night Begin Time',
			'night_end_time' => 'Night End Time',
			'night_driver' => 'Night Driver',
			'night_identity' => 'Night Identity',
			'night_phone' => 'Night Phone',
			'night_rent' => 'Night Rent',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('license',$this->license,true);
		$criteria->compare('day_begin_time',$this->day_begin_time,true);
		$criteria->compare('day_end_time',$this->day_end_time,true);
		$criteria->compare('day_driver',$this->day_driver,true);
		$criteria->compare('day_identity',$this->day_identity,true);
		$criteria->compare('day_phone',$this->day_phone,true);
		$criteria->compare('day_rent',$this->day_rent);
		$criteria->compare('night_begin_time',$this->night_begin_time,true);
		$criteria->compare('night_end_time',$this->night_end_time,true);
		$criteria->compare('night_driver',$this->night_driver,true);
		$criteria->compare('night_identity',$this->night_identity,true);
		$criteria->compare('night_phone',$this->night_phone,true);
		$criteria->compare('night_rent',$this->night_rent);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Vehicle the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
