<?php
/**
 * 用户的视图controller
 */
class UserViewController extends xzController
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
                    'actions'=>array('del','add','change','viewType'),
                    'users'=>array('@'),
            ),
            array('deny',  
                    'users'=>array('*'),
            ),
        );
    }


    /**
     * 删除一个视图
     * @return [type] [description]
     */
    public function actionDel()
    {
        $data = array();
        $data['success'] = false;
        $data['msg'] = '您没有选择需要删除的视图';

        if(isset($_POST['id']))
        {   
            $session_view_id = Yii::app()->session['user_view'];
            if($_POST['id'] == $session_view_id)
            {
                $data['success'] = false;
                $data['msg'] = '您不能删除当前使用的视图';
            }
            else
            {   
                UserView::model()->findByPk($_POST['id'])->deleteData();
                $data['success'] = true;
                $data['msg'] = '恭喜您，删除成功';
            }
        }

        xz::outputJson($data);
    }

    /**
     * 添加一个新的视图
     * @return [type] [description]
     */
    public function actionAdd()
    {
        if(isset($_POST['name']))
        {
            $inputArray = array(
                'user_id' => Yii::app()->user->id,
                'name' => $_POST['name'],
            );

            $model = new UserView;
            $model->attributes = $inputArray;

            if ( $model->save() )
                xz::outputJson(array( 'success' => true, 'id' => $model->id) );
        }
    }

    /**
     * 切换视图
     * @return [type] [description]
     */
    public function actionChange()
    {
        if(isset($_POST['id']))
        {
            $id = $_POST['id'];
            Yii::app()->session['user_view'] = $id;

            // 更新active
            UserView::updateActive();

            $model = UserView::model()->findByPk($id);
            $model->is_active = 1;
            $model->save();

            Yii::app()->session['view_type'] = $model->view_type;
        }
    }

    /**
     * 改变视图的查看类型
     */
    public function actionViewType()
    {
        if(isset($_POST['id']))
        {
            if($_POST['id'] != Yii::app()->session['user_view'])
            {
                // 更新active
                UserView::updateActive();
            }
           

            $model = UserView::model()->findByPk($_POST['id']);
            $model->view_type = $_POST['view_type']; 
            $model->is_active = 1;
            $model->save();

            Yii::app()->session['view_type'] = $_POST['view_type'];
            Yii::app()->session['user_view'] = $_POST['id'];

            $data = array('success' => true);
        }
        else
        {
            $data = array('success' => false);
        }

        echo json_encode($data);
    }
}