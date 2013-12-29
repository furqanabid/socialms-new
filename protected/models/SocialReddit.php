<?php

/**
 * This is the model class for table "xz_social_reddit".
 *
 * The followings are the available columns in table 'xz_social_reddit':
 * @property string $id
 * @property string $user_id
 * @property string $reddit_userid
 * @property string $reddit_access_token
 * @property string $reddit_refresh_token
 * @property string $reddit_name
 * @property string $create_time
 * @property string $update_time
 * @property string $is_deleted
 */
class SocialReddit extends xzModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'xz_social_reddit';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, reddit_userid, reddit_access_token, reddit_refresh_token, reddit_name, create_time, update_time', 'required'),
			array('user_id', 'length', 'max'=>10),
			array('reddit_userid', 'length', 'max'=>15),
			array('reddit_access_token, reddit_refresh_token', 'length', 'max'=>50),
			array('reddit_name', 'length', 'max'=>30),
			array('is_deleted', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, reddit_userid, reddit_access_token, reddit_refresh_token, reddit_name, create_time, update_time, is_deleted', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'reddit_userid' => 'Reddit Userid',
			'reddit_access_token' => 'Reddit Access Token',
			'reddit_refresh_token' => 'Reddit Refresh Token',
			'reddit_name' => 'Reddit Name',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'is_deleted' => 'Is Deleted',
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
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('reddit_userid',$this->reddit_userid,true);
		$criteria->compare('reddit_access_token',$this->reddit_access_token,true);
		$criteria->compare('reddit_refresh_token',$this->reddit_refresh_token,true);
		$criteria->compare('reddit_name',$this->reddit_name,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('is_deleted',$this->is_deleted,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SocialReddit the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
