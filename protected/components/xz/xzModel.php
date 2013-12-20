<?php
/**
 * 自定义model，然后所有的表model如果有需要，可以继承这个model
 */
class xzModel extends CActiveRecord
{
	// 定义social type
	const SOCIAL_RSS = 1;
	const SOCIAL_INSTAGRAM = 2;
	const SOCIAL_PINTEREST = 3;
	const SOCIAL_FLICKR = 4;
	const SOCIAL_LINKEDIN = 5;
	const SOCIAL_REDDIT = 6;
	const SOCIAL_RENREN = 7;
	const SOCIAL_WEIBO = 8;
    const SOCIAL_VIDEO56 = 9;
    const SOCIAL_YOUKU = 10;
	

	/**
	 * 命名范围多用作 find 方法调用的修改器。 
	 * 几个命名范围可以链到一起形成一个更有约束性的查询结果集。
	 * 例如， 要找到最近发布的帖子， 我们可以使用如下代码：$posts=Post::model()->published()->recently()->findAll();
	 * @return [type] [description]
	 */
	public function scopes()
   	{
       	return array(
           	'able'=>array(
               'condition'=>'is_deleted = 0',
          	 ),
       	);
   	}


	/**
	 * 添加自定义的delete behavior
	 */
	public function behaviors()
	{
		return array(
			'xzDeleteBehavior'=>array(
				'class' => 'xzModelBehavior'
			),
		);
	}

	/**
	* Prepares create_time, create_user_id, update_time and
	* update_user_ id attributes before performing validation.
	*/
	protected function beforeValidate() 
	{
		if ($this->isNewRecord) 
		{
			// set the create date, last updated date
			$this->create_time= $this->update_time= date('Y-m-d H:i:s');
		} 
		else 
		{
			//not a new record, so just set the last updated time
			$this->update_time=date('Y-m-d H:i:s');
		}
		return parent::beforeValidate();
	}
}
?>