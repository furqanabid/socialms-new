<?php

/**
 * This is the model class for table "xz_user_column".
 *
 * The followings are the available columns in table 'xz_user_column':
 * @property string $id
 * @property string $user_id
 * @property string $view_id
 * @property integer $social_type
 * @property string $instagram_id
 * @property string $pinterest_id
 * @property string $flickr_id
 * @property string $linkedin_id
 * @property string $reddit_id
 * @property string $renren_id
 * @property string $weibo_id
 * @property string $video56_id
 * @property string $youku_id
 * @property string $create_time
 * @property string $update_time
 * @property string $is_deleted
 */
class UserColumn extends xzModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'xz_user_column';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, view_id, social_type, create_time, update_time', 'required'),
			array('social_type', 'numerical', 'integerOnly'=>true),
			array('user_id, view_id, rss_master_id, instagram_id, pinterest_id, flickr_id, linkedin_id, reddit_id, renren_id, weibo_id, video56_id, youku_id', 'length', 'max'=>10),
			array('rss_name', 'length', 'max'=>40),
			array('is_deleted', 'length', 'max'=>1),
			array('column_width_size', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, view_id, social_type, instagram_id, pinterest_id, flickr_id, linkedin_id, reddit_id, renren_id, weibo_id, video56_id, youku_id, create_time, update_time, is_deleted', 'safe', 'on'=>'search'),
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
			'view_id' => 'View',
			'social_type' => 'Social Type',
			'instagram_id' => 'Instagram',
			'pinterest_id' => 'Pinterest',
			'flickr_id' => 'Flickr',
			'linkedin_id' => 'Linkedin',
			'reddit_id' => 'Reddit',
			'renren_id' => 'Renren',
			'weibo_id' => 'Weibo',
			'video56_id' => 'Video56',
			'youku_id' => 'Youku',
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
		$criteria->compare('view_id',$this->view_id,true);
		$criteria->compare('social_type',$this->social_type);
		$criteria->compare('instagram_id',$this->instagram_id,true);
		$criteria->compare('pinterest_id',$this->pinterest_id,true);
		$criteria->compare('flickr_id',$this->flickr_id,true);
		$criteria->compare('linkedin_id',$this->linkedin_id,true);
		$criteria->compare('reddit_id',$this->reddit_id,true);
		$criteria->compare('renren_id',$this->renren_id,true);
		$criteria->compare('weibo_id',$this->weibo_id,true);
		$criteria->compare('video56_id',$this->video56_id,true);
		$criteria->compare('youku_id',$this->youku_id,true);
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
	 * @return UserColumn the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * 获取用户的Column
	 * @return [type] [description]
	 */
	public static function getColumns()
	{
		$user_id = Yii::app()->user->id;
		$view_id = Yii::app()->session['user_view'];

	    $cacheName = 'user_column_'.$user_id.'_'.$view_id;
	    $result = Yii::app()->cache->get($cacheName);
	    if($result === false)
	    {
	        $result = Yii::app()->db->createCommand()
	                                ->select('*')
	                                ->from('xz_user_column')
	                                ->where('is_deleted=0 AND user_id='.$user_id.' AND view_id='.$view_id)
	                                ->queryAll();        

	        //设置一个缓存依赖，当SQL的查询结果变化时，重新缓存
	        $dependency = new CDbCacheDependency("SELECT max(update_time) FROM xz_user_column WHERE user_id=".$user_id.' AND view_id='.$view_id);
	        Yii::app()->cache->set($cacheName, $result, 30*24*60*60, $dependency);         
	    }
	    return $result; 
	}
}
