<?php
/**
 * User Column 控制器
 */
class UserColumnController extends xzController
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
                'actions'=>array('index','addColumn'),
                'users'=>array('@'),
            ),
            array('deny',  
                'users'=>array('*'),
            ),
        );
    }

    /**
     * 获取所有的column
     */
    public function actionIndex()
    {
    	$data = UserColumn::getColumns();
    	xz::outputJson($data);
    }

    /**
     * 添加到column
     */
    public function actionAddColumn()
    {
        if(isset($_POST['id']))
        {
            $inputArray = array(
                'user_id' => Yii::app()->user->id,
                'view_id' => Yii::app()->session['user_view'],
                $_POST['key'] => $_POST['id'],
                'social_type' => $_POST['social_type'],
            );
            
            $model = new UserColumn;
            $model->attributes = $inputArray;
            if($model->save())
                xz::outputJson($model->attributes);
            else
                xz::dump($model->getErrors());

        }
    }

}