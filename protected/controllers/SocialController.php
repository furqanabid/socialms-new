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

		$userViews = UserView::getUserView();
		$userColumns = UserColumn::getColumns();
		$renrenAccount = SocialRenren::getAccount();
		$weiboAccount = SocialWeibo::getAccount();

		$this->render('index', array(
			'userViews' => $userViews,
			'view_type' => Yii::app()->session['view_type'],
			'userColumns' => $userColumns,
			'renrenAccount' => $renrenAccount,
			'weiboAccount' => $weiboAccount
		));
	}

	/**
	 * 发送数据
	 * @return [type] [description]
	 */
	public function actionPublish()
	{
		$data = $_POST['socialPost'];
		// API返回的数据保存到此数组中，然后以json形式返回
		$res_code = array();

		// 循环数据并发送
		foreach ($data as $key => $val) 
		{
			$type = $val['type'];
			$inputArray = array();
			switch ($type) 
			{
				// 如果是人人网的数据
				case xzModel::SOCIAL_RENREN :
					// 实例化API
					$renrenAccount = SocialRenren::model()->findByPk($val['id']);
					$api_renren = new api_renren(RENREN_API_KEY, RENREN_API_SECRET);
					$api_renren->api_access_token = $renrenAccount->renren_access_token;

					$inputArray['message'] = $val['text'];
					$inputArray['title'] = isset($val['title']) ? $val['title'] : '';

					// 如果不存在新鲜事title,则说明是直接更新人人状态
					if(empty($inputArray['title']))
					{
						$inputArray['content'] = $inputArray['message'];
						// 发送数据
						$res_code[] = $api_renren->status_put($inputArray);
					}
					// 发布人人网新鲜事
					else
					{
						$inputArray['targetUrl'] = $val['link'];
						$inputArray['description'] = $val['description'];
						// 判断是否存在图片,如果不存在本地的holder图片，才给此参数
						if( !strstr($val['image'], 'image-holder') )
						{
							$inputArray['imageUrl'] = $val['image'];
						}
						
						// 发送数据
						$res_code[] = $api_renren->feed_put($inputArray);
					}
				break;	

				// 如果是新浪微博的数据
				case xzModel::SOCIAL_WEIBO :
					// 实例化API
					$weiboAccount = SocialWeibo::model()->findByPk($val['id']);
					$api_weibo = new api_weibo(WEIBO_API_KEY, WEIBO_API_SECRET);
					$api_weibo->api_access_token = $weiboAccount->weibo_access_token;

					$inputArray['status'] = $val['text'];
					$image = isset($val['image']) ? $val['image'] : '';

					// 如果不存在image,则说明是直接发送微博
					if( empty($image) || strstr($image, 'image-holder') )
					{
						$res_code[] = $api_weibo->statuses_update($inputArray);
					}
					// 否则就是发送一条带图片的微博
					else
					{
						$inputArray['pic'] = '@'.$image;
						$res_code[] = $api_weibo->statuses_upload($inputArray);
					}
					
				break;		
			}	
		}

		xz::outputJson($res_code);
	}
}