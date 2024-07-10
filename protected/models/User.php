<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $verification_token
 * @property integer $is_verified
 * @property string $created_at
 * @property string $updated_at
 *
 * 
 * The followings are the available model relations:
 * @property BlogPost[] $blogPosts
 * @property Comment[] $comments
 * @property Like[] $likes
 */
class User extends CActiveRecord
{
	public $password_repeat;

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
			array('email, password, created_at, updated_at', 'required'),
			array('is_verified', 'numerical', 'integerOnly'=>true),
			array('email, password, verification_token', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, email, password, verification_token, is_verified, created_at, updated_at', 'safe', 'on'=>'search'),

			//custom validation
			array('email', 'email'),
			array('email', 'unique'),
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
			'blogPosts' => array(self::HAS_MANY, 'BlogPost', 'author_id'),
			'comments' => array(self::HAS_MANY, 'Comment', 'author_id'),
			'likes' => array(self::HAS_MANY, 'Like', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email' => 'Email',
			'password' => 'Password',
			'verification_token' => 'Verification Token',
			'is_verified' => 'Is Verified',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('verification_token',$this->verification_token,true);
		$criteria->compare('is_verified',$this->is_verified);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	protected function beforeSave()
    {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->verification_token = md5(uniqid(rand(), true));
                $this->password = CPasswordHelper::hashPassword($this->password);
            }
            return true;
        } else {
            return false;
        }
    }
}
