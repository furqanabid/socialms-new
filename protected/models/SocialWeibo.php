<?php

/**
 * This is the model class for table "xz_social_weibo".
 *
 * The followings are the available columns in table 'xz_social_weibo':
 * @property string $id
 * @property string $user_id
 * @property string $weibo_uid
 * @property string $weibo_access_token
 * @property string $weibo_username
 * @property string $create_time
 * @property string $update_time
 * @property string $is_deleted
 */
class SocialWeibo extends xzModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'xz_social_weibo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, weibo_uid, weibo_access_token, weibo_username, create_time, update_time', 'required'),
			array('user_id, weibo_uid', 'length', 'max'=>10),
			array('weibo_access_token', 'length', 'max'=>50),
			array('weibo_username', 'length', 'max'=>30),
			array('is_deleted', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, weibo_uid, weibo_access_token, weibo_username, create_time, update_time, is_deleted', 'safe', 'on'=>'search'),
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
			'weibo_uid' => 'Weibo Uid',
			'weibo_access_token' => 'Weibo Access Token',
			'weibo_username' => 'Weibo Username',
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
		$criteria->compare('weibo_uid',$this->weibo_uid,true);
		$criteria->compare('weibo_access_token',$this->weibo_access_token,true);
		$criteria->compare('weibo_username',$this->weibo_username,true);
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
	 * @return SocialWeibo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * 获取微博的帐号
	 * @return [type] [description]
	 */
	public static function getAccount()
	{
		$user_id = Yii::app()->user->id;
		$cacheName = 'weibo-account-'.$user_id;

		$result = Yii::app()->cache->get($cacheName);
		if($result === false)
		{
			$result = Yii::app()->db->createCommand()
	                                ->select('*')
	                                ->from('xz_social_weibo')
	                                ->where('is_deleted=0 AND user_id='.$user_id)
	                                ->queryAll();

			//设置一个缓存依赖，当SQL的查询结果变化时，重新缓存
			$dependency = new CDbCacheDependency("SELECT max(update_time) FROM xz_social_weibo WHERE user_id=".$user_id);
			Yii::app()->cache->set($cacheName, $result, 30*24*60*60, $dependency);    
		}

		return $result;		
	}
}
