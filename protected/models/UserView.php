<?php

/**
 * This is the model class for table "xz_user_view".
 *
 * The followings are the available columns in table 'xz_user_view':
 * @property string $id
 * @property string $user_id
 * @property string $name
 * @property string $create_time
 * @property string $update_time
 * @property string $is_active
 * @property string $is_deleted
 */
class UserView extends xzModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'xz_user_view';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, name, create_time, update_time', 'required'),
			array('user_id', 'length', 'max'=>10),
			array('name', 'length', 'max'=>25),
			array('is_active, is_deleted', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, name, create_time, update_time, is_active, is_deleted', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'is_active' => 'Is Active',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('is_active',$this->is_active,true);
		$criteria->compare('is_deleted',$this->is_deleted,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserView the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * 每个新用户创建一个默认的视图
	 * @return [type] [description]
	 */
	public static function createDefaultView()
	{
		$inputArray = array(
			'user_id' => Yii::app()->user->id,
			'name' => '默认',
			'is_active' => 1
		);

		self::model()->attributes = $inputArray;
		self::model()->isNewRecord = true;
		self::model()->validate();
		if(! self::model()->save())
		{
			var_dump(self::model()->attributes);
		}
		else
		{
			Yii::app()->session['user_view'] = self::model()->id;
		}
	} 

	/**
     * 得到用户的所有视图
     * @param  [type] $inputArray [description]
     * @return [type]             [description]
     */
    public static function getUserView()
    {
    	$user_id = Yii::app()->user->id;
        $cacheName = 'user_view_'.$user_id;
        $result = Yii::app()->cache->get($cacheName);
        if($result === false)
        {
            $result = Yii::app()->db->createCommand()
                                    ->select('id,name,view_type,is_active')
                                    ->from('xz_user_view')
                                    ->where('is_deleted=0 AND user_id='.$user_id)
                                    ->queryAll();        

            //设置一个缓存依赖，当SQL的查询结果变化时，重新缓存
            $dependency = new CDbCacheDependency("SELECT max(update_time) FROM xz_user_view WHERE user_id=".$user_id);
            Yii::app()->cache->set($cacheName, $result, 30*24*60*60, $dependency);         
        }
        return $result;        
    }

    /**
     * 获取用户当前的激活视图
     */
    public static function activeView()
    {
    	$user_id = Yii::app()->user->id;
    	$result = Yii::app()->db->createCommand()
    	                        ->select('id,view_type')
    	                        ->from('xz_user_view')
    	                        ->where('is_deleted=0 AND is_active=1 AND user_id='.$user_id)
    	                        ->queryRow();  

    	Yii::app()->session['user_view'] = $result['id'];
    	Yii::app()->session['view_type'] = $result['view_type'];
    }

    /**
     * 更新用户当前激活的视图
     */
    public static function updateActive()
    {
        // 将以前的view视图is_active设为0
        $model = self::model()->find(array('condition'=>'user_id='.Yii::app()->user->id.' AND is_deleted=0 AND is_active=1'));
        $model->is_active = 0;
        $model->save();
    }
}
