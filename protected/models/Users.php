<?php
/**
 * This is the model class for table "xz_users".
 *
 * The followings are the available columns in table 'xz_users':
 * @property string $id
 * @property string $email
 * @property string $username
 * @property string $password
 * @property string $create_time
 * @property string $update_time
 * @property string $last_login_time
 * @property string $is_deleted
 */
class Users extends xzModel
{
	public $password_repeat;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'xz_users';
	}

	/**
	 * 在保存前给密码md5
	 * @return [type] [description]
	 */
    public function beforeSave()
    {
        $this->password = md5($this->password);
        return true;
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, username, password, create_time, update_time', 'required'),
			array('email, username', 'length', 'max'=>50),
			array('email', 'email'), 
			//确认用户确认密码，需要新建一个属性$password_repeat , 对比任意值需要新加一个*_repeat
           	array('password','compare', 'on'=>'register'),
           	//确保新增加的属性被认可为安全属性
          	array('password_repeat','safe', 'on'=>'register'),
          	// 对用户名和电子邮件进行唯一性认证
          	array('username, email', 'validate_info', 'on'=>'register'),
			array('password', 'length', 'max'=>32),
			array('is_deleted', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, email, username, password, create_time, update_time, last_login_time, is_deleted', 'safe', 'on'=>'search'),
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
			'email' => '电子邮件',
			'username' => '用户名',
			'password' => '密码',
			'password_repeat' => '确认密码',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'last_login_time' => 'Last Login Time',
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
		$criteria->compare('email',$this->email,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('last_login_time',$this->last_login_time,true);
		$criteria->compare('is_deleted',$this->is_deleted,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
     * 当用户注册的时候，调用这个方法来验证email和username是否存在
     */
   	public function validate_info($attribute,$params)
   	{
        if(!$this->hasErrors())
        {
            // 先检查email是否存在
            $users = self::model()->findByAttributes(array('email'=>$this->email));
           	if($users !== null)
           	{
                $this->addError('email','您输入的电子邮件已经被注册！');
           	}
            else
            {
                $users = self::model()->findByAttributes(array('username'=>$this->username));
                if($users !== null)
               	{
                	$this->addError('username','您输入的用户名已经被注册！');
               	}
           	}

        }
   	}
}
