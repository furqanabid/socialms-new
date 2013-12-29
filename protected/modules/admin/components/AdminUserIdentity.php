<?php
/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class AdminUserIdentity extends CUserIdentity
{
	private $_id;
	public 	$email;
	public 	$password;

	public function __construct($email,$password)
	{
		$this->email=$email;
		$this->password=$password;
	}

	/**
	 * Authenticates a user.
	 */
	public function authenticate()
	{
		$admin = Administrator::model()->findByAttributes(array('email'=>$this->email));
		if($admin === null)
		{
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		}
		else
		{
			if( $admin->password !== md5($this->password) )
			{
				$this->errorCode = self::ERROR_PASSWORD_INVALID; //值是2
			}
			else
			{
				$this->_id = $admin->id;

				$this->setState('admin_email', $this->email);
				$this->setState('admin_username', $admin->username);

				$this->errorCode = self::ERROR_NONE; //值是0

				//更新用户最后登陆时间
				Administrator::model()->updateByPk($this->_id, array('last_login_time' => date('Y-m-d H:i:s')));			
			}
		}

		return !$this->errorCode;
	}

	/**
	 * 重写方法，因为此方法默认是返回username
	 * 现在我们返回用户的id
	 * @return [type] [description]
	 */
	function getId()
	{
		return $this->_id;
	}
}