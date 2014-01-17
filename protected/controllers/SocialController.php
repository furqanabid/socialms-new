<?php

class SocialController extends xzController
{
	/**
	* @return array action filters
	*/
	public function filters()
	{
		return array(
			// perform access control for CRUD operations
			'accessControl',
			// we only allow deletion via POST request
			'postOnly + publish',
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	*/
	public function accessRules()
	{
		return array(
			array('allow', 
				'actions'=>array('index','publish'),
				'users'=>array('@'),
			),
			array('deny',  
				'users'=>array('*'),
			),
		);
		}

	/**
	 * Social的页面
	 * @return [type] [description]
	 */
	public function actionIndex()
	{
		$userColumns = array();
		$userViews = array();

		$UserViews = UserView::getUserView();
		$userColumns = UserColumn::getColumns();
		$renrenAccount = SocialRenren::getAccount();

		$this->render('index', array(
			'userViews' => $UserViews,
			'userColumns' => $userColumns,
			'renrenAccount' => $renrenAccount
		));
	}

	/**
	 * 发送数据
	 * @return [type] [description]
	 */
	public function actionPublish()
	{
		$data = $_POST['socialPost'];

		// 循环数据并发送
		foreach ($data as $key => $val) 
		{
			$type = $val['type'];
			$inputArray = array();
			switch ($type) 
			{
				// 如果是人人网的数据
				case xzModel::SOCIAL_RENREN :
					$renrenAccount = SocialRenren::model()->findByPk($val['id']);
					$api_renren = new api_renren(RENREN_API_KEY, RENREN_API_SECRET);
					$api_renren->api_access_token = $renrenAccount->renren_access_token;

					$inputArray['message'] = $val['text'];
					$inputArray['title'] = isset($val['title']) ? $val['title'] : '';

					// 如果不存在新鲜事title,则说明是直接更新人人状态
					if(empty($inputArray['title']))
					{

					}
					// 发布人人网新鲜事
					else
					{
						$inputArray['targetUrl'] = $val['link'];
						$inputArray['description'] = $val['description'];
						$inputArray['imageUrl'] = $val['image'];
						// 发送数据
						$res = $api_renren->feed_put($inputArray);
						xz::dump($res);
					}
				break;			
			}	
		}
	}
}