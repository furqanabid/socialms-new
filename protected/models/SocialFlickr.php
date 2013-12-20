<?php

/**
 * This is the model class for table "xz_social_flickr".
 *
 * The followings are the available columns in table 'xz_social_flickr':
 * @property string $id
 * @property string $user_id
 * @property string $flickr_nsid
 * @property string $flickr_token
 * @property string $flickr_username
 * @property string $flickr_fullname
 * @property string $create_time
 * @property string $update_time
 * @property string $is_deleted
 */
class SocialFlickr extends xzModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'xz_social_flickr';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, flickr_nsid, flickr_token, flickr_username, flickr_fullname, create_time, update_time', 'required'),
			array('user_id', 'length', 'max'=>10),
			array('flickr_nsid', 'length', 'max'=>20),
			array('flickr_token', 'length', 'max'=>50),
			array('flickr_username', 'length', 'max'=>100),
			array('flickr_fullname', 'length', 'max'=>150),
			array('is_deleted', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, flickr_nsid, flickr_token, flickr_username, flickr_fullname, create_time, update_time, is_deleted', 'safe', 'on'=>'search'),
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
			'flickr_nsid' => 'Flickr Nsid',
			'flickr_token' => 'Flickr Token',
			'flickr_username' => 'Flickr Username',
			'flickr_fullname' => 'Flickr Fullname',
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
		$criteria->compare('flickr_nsid',$this->flickr_nsid,true);
		$criteria->compare('flickr_token',$this->flickr_token,true);
		$criteria->compare('flickr_username',$this->flickr_username,true);
		$criteria->compare('flickr_fullname',$this->flickr_fullname,true);
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
	 * @return SocialFlickr the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
