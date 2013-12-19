<?php
class SiteController extends xzController
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
                'actions'=>array('index','logout','register'),
                'users'=>array('*'),
            ),
            array('deny',  
                'users'=>array('*'),
            ),
        );
    }

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$model=new LoginForm;

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
            {
                UserView::activeView();
				$this->redirect($this->createUrl('/social'));
            }
		}
		// display the login form
		$this->renderPartial('index',array('model'=>$model));
	}

    /**
     * 用户注册
     * @return [type] [description]
     */
    public function actionRegister()
    {
        $model = new Users('register');
        if(isset($_POST['Users']))
        {
            $model->attributes = $_POST['Users'];
            if($model->save())
            {
                $identity = new UserIdentity($model->email,$_POST['Users']['password']);
                $identity->authenticate();
                Yii::app()->user->login($identity, 0);

                // 给新增用户添加默认视图
                UserView::createDefaultView();

                //redirect the user to page he/she came from
                $this->redirect($this->createUrl('/site/social'));
            }
        }

        $this->renderPartial('register', array(
            'model'=>$model
        ));
    }

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}