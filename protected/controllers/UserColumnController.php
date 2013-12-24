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
                'actions'=>array('addColumn','del','updWidth'),
                'users'=>array('@'),
            ),
            array('deny',  
                'users'=>array('*'),
            ),
        );
    }

    /**
     * 删除column
     */
    public function actionDel()
    {
    	if(isset($_POST['column_id']))
        {
            UserColumn::model()->findByPk($_POST['column_id'])->deleteData();
        }
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
                echo $model->id;
            else
                xz::dump($model->getErrors());

        }
    }

    /**
     * 更新列的宽度
     * @return [type] [description]
     */
    public function actionUpdWidth()
    {
        if(isset($_POST['columnId']))
        {
            $model = UserColumn::model()->findByPk($_POST['columnId']);
            $model->column_width_size = $_POST['column_width_size'];
            if( !$model->save() )
                xz::dump($model->getErrors());
        }
    }

}