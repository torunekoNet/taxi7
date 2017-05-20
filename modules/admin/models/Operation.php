<?php

/**
 * This is the model class for table "operation".
 *
 * The followings are the available columns in table 'operation':
 * @property integer $id
 * @property integer $fid
 * @property integer $level
 * @property integer $lft
 * @property integer $rgt
 * @property string $name
 * @property string $description
 * @property string $module
 * @property string $controller
 * @property string $action
 * @property integer $status
 * @property integer $sort
 */
class Operation extends RedActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'operation';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('fid, level, lft, rgt, name, module, controller, action', 'required'),
            array('fid, level, lft, rgt, status, sort', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 20),
            array('module, controller, action', 'length', 'max' => 50),
            array('description', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, fid, level, lft, rgt, name, description, module, controller, action, status, sort', 'safe', 'on' => 'search'),
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
            'fid' => 'Fid',
            'level' => 'Level',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'name' => 'Name',
            'description' => 'Description',
            'module' => 'Module',
            'controller' => 'Controller',
            'action' => 'Action',
            'status' => 'Status',
            'sort' => 'Sort',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('fid', $this->fid);
        $criteria->compare('level', $this->level);
        $criteria->compare('lft', $this->lft);
        $criteria->compare('rgt', $this->rgt);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('module', $this->module, true);
        $criteria->compare('controller', $this->controller, true);
        $criteria->compare('action', $this->action, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('sort', $this->sort);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Operation the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
