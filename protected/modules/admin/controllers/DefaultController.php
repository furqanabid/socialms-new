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
	            'actions'=>array('dashboard','logout'),
	            'users'=>array('@'),
	        ),
	        array('deny',  
	            'users'=>array('*'),
	        ),
	    );
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
		$this->redirect(Yii::app()->homeUrl);
	}
}