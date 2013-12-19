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
		$UserViews = UserView::getUserView();
		$this->render('index', array(
			'userViews' => $UserViews
		));
	}
}