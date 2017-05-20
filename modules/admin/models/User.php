<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $username
 * @property string $nickname
 * @property string $realname
 * @property string $email
 * @property string $password
 * @property string $uuid
 * @property integer $sign_up_time
 * @property string $sign_up_ip
 * @property integer $last_login_time
 * @property string $last_login_ip
 * @property integer $state
 * @property integer $approved
 */
class User extends RedActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username, nickname, realname, email, password, sign_up_time, sign_up_ip', 'required'),
            array('sign_up_time, last_login_time, state, approved', 'numerical', 'integerOnly' => true),
            array('username, nickname, realname', 'length', 'max' => 20),
            array('email', 'length', 'max' => 50),
            array('password', 'length', 'max' => 100),
            array('uuid', 'length', 'max' => 36),
            array('sign_up_ip, last_login_ip', 'length', 'max' => 15),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, username, nickname, realname, email, password, uuid, sign_up_time, sign_up_ip, last_login_time, last_login_ip, state, approved', 'safe', 'on' => 'search'),
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
            'userRoles' => array(self::HAS_MANY, 'UserRole', 'user_id', 'with' => array(
                'role' => array(self::BELONGS_TO, 'Role', 'role_id')
            )),
            'userGroups' => array(self::HAS_MANY, 'UserGroup', 'user_id', 'with' => array(
                'group' => array(self::BELONGS_TO, 'Group', 'group_id')
            )),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'username' => 'Username',
            'nickname' => 'Nickname',
            'realname' => 'Realname',
            'email' => 'Email',
            'password' => 'Password',
            'uuid' => 'Uuid',
            'sign_up_time' => 'Sign Up Time',
            'sign_up_ip' => 'Sign Up Ip',
            'last_login_time' => 'Last Login Time',
            'last_login_ip' => 'Last Login Ip',
            'state' => 'State',
            'approved' => 'Approved',
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
        $criteria->compare('username', $this->username, true);
        $criteria->compare('nickname', $this->nickname, true);
        $criteria->compare('realname', $this->realname, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('uuid', $this->uuid, true);
        $criteria->compare('sign_up_time', $this->sign_up_time);
        $criteria->compare('sign_up_ip', $this->sign_up_ip, true);
        $criteria->compare('last_login_time', $this->last_login_time);
        $criteria->compare('last_login_ip', $this->last_login_ip, true);
        $criteria->compare('state', $this->state);
        $criteria->compare('approved', $this->approved);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
