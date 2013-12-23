<?php

/**
 * This is the model class for table "xz_social_renren".
 *
 * The followings are the available columns in table 'xz_social_renren':
 * @property string $id
 * @property string $user_id
 * @property string $renren_uid
 * @property string $renren_access_token
 * @property string $renren_refresh_token
 * @property string $renren_username
 * @property string $create_time
 * @property string $update_time
 * @property string $is_deleted
 */
class SocialRenren extends xzModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'xz_social_renren';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, renren_uid, renren_access_token, renren_refresh_token, renren_username, create_time, update_time', 'required'),
			array('user_id, renren_uid', 'length', 'max'=>10),
			array('renren_access_token, renren_refresh_token', 'length', 'max'=>100),
			array('renren_username', 'length', 'max'=>50),
			array('is_deleted', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, renren_uid, renren_access_token, renren_refresh_token, renren_username, create_time, update_time, is_deleted', 'safe', 'on'=>'search'),
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
			'renren_uid' => 'Renren Uid',
			'renren_access_token' => 'Renren Access Token',
			'renren_refresh_token' => 'Renren Refresh Token',
			'renren_username' => 'Renren Username',
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
		$criteria->compare('renren_uid',$this->renren_uid,true);
		$criteria->compare('renren_access_token',$this->renren_access_token,true);
		$criteria->compare('renren_refresh_token',$this->renren_refresh_token,true);
		$criteria->compare('renren_username',$this->renren_username,true);
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
	 * @return SocialRenren the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
