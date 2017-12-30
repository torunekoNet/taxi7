<?php

/**
 * This is the model class for table "driver_vehicle".
 *
 * The followings are the available columns in table 'driver_vehicle':
 * @property string $id
 * @property string $driver
 * @property string $license
 * @property string $begin_time
 * @property string $end_time
 * @property integer $type
 * @property integer $rent
 */
class DriverVehicle extends RedActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'driver_vehicle';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('driver, license, begin_time, type, rent', 'required'),
			array('type, rent', 'numerical', 'integerOnly'=>true),
			array('driver', 'length', 'max'=>50),
			array('license', 'length', 'max'=>25),
			array('end_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, driver, license, begin_time, end_time, type, rent', 'safe', 'on'=>'search'),
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
			'driver' => 'Driver',
			'license' => 'License',
			'begin_time' => 'Begin Time',
			'end_time' => 'End Time',
			'type' => 'Type',
			'rent' => 'Rent',
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
		$criteria->compare('driver',$this->driver,true);
		$criteria->compare('license',$this->license,true);
		$criteria->compare('begin_time',$this->begin_time,true);
		$criteria->compare('end_time',$this->end_time,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('rent',$this->rent);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DriverVehicle the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
