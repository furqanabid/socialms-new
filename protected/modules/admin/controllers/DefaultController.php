<?php

class DefaultController extends xz1Controller
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
	       'postOnly + ',
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
	    	    'actions'=>array('index'),
	    	    'users'=>array('*'),
	    	),
	        array('allow', 
	            'actions'=>array('dashboard','logout'),
	            'users'=>array('@'),
	        ),
	        array('deny',  
	            'users'=>array('*'),
	        ),
	    );
	}

	// 管理员登录
	public function actionIndex()
	{
		$model=new AdminLoginForm;

		// collect user input data
		if(isset($_POST['AdminLoginForm']))
		{
			$model->attributes=$_POST['AdminLoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
            {
				$this->redirect($this->createUrl('dashboard'));
            }
		}

		// display the login form
		$this->renderPartial('index',array(
			'model'=>$model
		));
	}

	// 显示dashboard
	public function actionDashboard()
	{
		// display the login form
		$this->render('dashboard');
	}

	// 登出
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->createUrl('/admin'));
	}
}