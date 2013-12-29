<?php
/**
 * Pinterest 控制器
 */
class PinterestController extends xzController
{
    // api返回的数据
    protected $api_data;
    // 缓存名
    protected $cacheName;
    // 动作是不是refresh
    protected $action;

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
                'actions'=>array('add','del','parse'),
                'users'=>array('@'),
            ),
            array('deny',  
                'users'=>array('*'),
            ),
        );
    }

    /**
     * 新建一个帐号
     * @return [type] [description]
     */
    public function actionAdd()
    {
        if(isset($_POST['name']))
        {
            $name = $_POST['name'];
            $inputArray = array(
                'user_id' => Yii::app()->user->id,
                'name' => $name
            );

            $model = new SocialPinterest;
            $model->attributes = $inputArray;
            $model->save();
            echo $model->id;
        }
    }

    /**
     * 获取instagram帐号
     * @return [type] [description]
     */
    public function actionDel()
    {
        if(isset($_POST['id']))
        {
            $id = $_POST['id'];
            $flag = SocialPinterest::model()->findByPk($id)->deleteData();
            xz::outputJson(array('success'=>$flag));
        }
    }

    /**
     * 解析instagram数据
     * @return [type] [description]
     */
    public function actionParse()
    {
        if(isset($_POST['name']))
        {
            // refresh的数据
            $this->action = isset($_POST['action']) ? $_POST['action'] : '';
            // 缓存名
            $this->cacheName = 'pinterest_data_'.$_POST['name'];
 
            // 检查cache是否存在
            $this->checkCache(); 

            $url = 'http://www.pinterest.com/'.$_POST['name'].'/feed.rss';
            $this->api_data = Yii::app()->parseRss->load($url)->parse();
               
            // 在视图里面解析数据
            $this->show();
        }
    }

    /**
     * 检查是否需要重新缓存
     * @return [type] [description]
     */
    public function checkCache()
    {
        // 如果动作不是刷新，我们才获取缓存；是刷新，则重新获取数据
        if($this->action != 'refresh')
        {
            $result = Yii::app()->cache->get($this->cacheName);
            // 如果存在缓存，则获取缓存值
            if($result !== false)
            {                
                echo '<span style="display:none;">cache</span>'.$result;
                // 结束
                Yii::app()->end();
            }
        }
    }

    /**
     * 显示视图
     * @return [type] [description]
     */
    public function show()
    {
        $result = $this->renderPartial('load_pinterest',array(
            'data' => $this->api_data,
        ),true);  

        Yii::app()->cache->set($this->cacheName, $result, CACHE_TIME_PINTEREST);

        echo $result;
    }
}