<?php

/**
 * This is the model class for table "cargo".
 *
 * The followings are the available columns in table 'cargo':
 * @property string $id
 * @property string $number
 * @property string $name
 * @property string $price
 * @property string $store
 * @property string $sales
 * @property string $last_stor_number
 * @property string $last_stor_time
 * @property string $comment
 * @property string $gmt_create
 */
class Cargo extends RedActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'cargo';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('number, name, price, store, sales, last_stor_number, last_stor_time, gmt_create', 'required'),
            array('number, name', 'length', 'max' => 255),
            array('price, store, sales, last_stor_number, last_stor_time, gmt_create', 'length', 'max' => 10),
            array('comment', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, number, name, price, store, sales, last_stor_number, last_stor_time, comment, gmt_create', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'number' => 'Number',
            'name' => 'Name',
            'price' => 'Price',
            'store' => 'Store',
            'sales' => 'Sales',
            'last_stor_number' => 'Last Stor Number',
            'last_stor_time' => 'Last Stor Time',
            'comment' => 'Comment',
            'gmt_create' => 'Gmt Create',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('number', $this->number, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('store', $this->store, true);
        $criteria->compare('sales', $this->sales, true);
        $criteria->compare('last_stor_number', $this->last_stor_number, true);
        $criteria->compare('last_stor_time', $this->last_stor_time, true);
        $criteria->compare('comment', $this->comment, true);
        $criteria->compare('gmt_create', $this->gmt_create, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Cargo the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
