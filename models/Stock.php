<?php

/**
 * This is the model class for table "stock".
 *
 * The followings are the available columns in table 'stock':
 * @property string $id
 * @property string $cargo_id
 * @property string $cargo_name
 * @property string $amount
 * @property string $price
 * @property string $gmt_create
 * @property string $gmt_year
 * @property string $gmt_month
 * @property string $gmt_day
 * @property string $comment
 * @property string $operator
 */
class Stock extends RedActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'stock';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cargo_id, cargo_name, amount, price, gmt_create, gmt_year, gmt_month, gmt_day, operator', 'required'),
            array('cargo_id, amount, price, gmt_create', 'length', 'max' => 10),
            array('cargo_name, operator', 'length', 'max' => 255),
            array('gmt_year', 'length', 'max' => 6),
            array('gmt_month, gmt_day', 'length', 'max' => 2),
            array('comment', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, cargo_id, cargo_name, amount, price, gmt_create, gmt_year, gmt_month, gmt_day, comment, operator', 'safe', 'on' => 'search'),
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
            'cargo_id' => 'Cargo',
            'cargo_name' => 'Cargo Name',
            'amount' => 'Amount',
            'price' => 'Price',
            'gmt_create' => 'Gmt Create',
            'gmt_year' => 'Gmt Year',
            'gmt_month' => 'Gmt Month',
            'gmt_day' => 'Gmt Day',
            'comment' => 'Comment',
            'operator' => 'Operator',
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
        $criteria->compare('cargo_id', $this->cargo_id, true);
        $criteria->compare('cargo_name', $this->cargo_name, true);
        $criteria->compare('amount', $this->amount, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('gmt_create', $this->gmt_create, true);
        $criteria->compare('gmt_year', $this->gmt_year, true);
        $criteria->compare('gmt_month', $this->gmt_month, true);
        $criteria->compare('gmt_day', $this->gmt_day, true);
        $criteria->compare('comment', $this->comment, true);
        $criteria->compare('operator', $this->operator, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Stock the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
