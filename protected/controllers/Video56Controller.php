<?php
/**
 * video56 控制器
 */
class Video56Controller extends xzController
{
    // 实例化的对象
    protected $video56;
    // api返回的数据
    protected $api_data;
    // 缓存名
    protected $cacheName;
    // 动作是不是refresh
    protected $action;
    // 视图名
    protected $view_name;

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
                'actions'=>array('parse','addSearch','delSearch'),
                'users'=>array('@'),
            ),
            array('deny',  
                'users'=>array('*'),
            ),
        );
    }

    // 初始化加载
    public function init()
    {
        parent::init();

        $this->video56 = new api_video56(VIDEO56_API_KEY, VIDEO56_API_SECRET);
        $this->video56->api_redirect_uri = VIDEO56_REDIRECT_URI;
        $this->video56->page = isset($_POST['page']) ? $_POST['page'] : 1;

        $this->action = isset($_POST['action']) ? $_POST['action'] : '';
    }

    /**
     * 删除指定的历史记录
     * @return [type] [description]
     */
    public function actionDelSearch()
    {
        if(isset($_POST['id']))
        {
            $id = $_POST['id'];
            $flag = SocialVideo56::model()->findByPk($id)->deleteData();
            xz::outputJson(array('success'=>$flag));
        }
    }

    /**
     * 用户新搜索
     * @return [type] [description]
     */
    public function actionAddSearch()
    {
        if(isset($_POST['keywords']))
        {
            $inputArray = array(
                'user_id' => Yii::app()->user->id,
                'video56_search_keywords' => $_POST['keywords'],
                'video56_type' => 'search',
            );

            $model = new SocialVideo56;
            $model->attributes = $inputArray;
            if( $model->save() )
                echo $model->id;
            else
                xz::dump($model->getErrors());
        }
    }

    /**
     * 解析instagram数据
     * @return [type] [description]
     */
    public function actionParse()
    {
        if(isset($_POST['id']))
        {
            $data = SocialVideo56::model()->findByPk($_POST['id']);
            $this->video56->type_id = $data->video56_id;

            // 根据类型获得缓存名和视图名
            switch ($data->video56_type) 
            {
                case 'hot':
                    $this->view_name = 'hot_video';
                    $this->cacheName = 'video56_hot_'.$_POST['id'].'_'.$this->video56->page;
                break;

                case 'opera':
                    $this->view_name = 'opera_video';
                    $this->cacheName = 'video56_opera_'.$_POST['id'].'_'.$this->video56->page;
                break;
                
                case 'search':
                    $this->view_name = 'search_video';
                    $this->cacheName = 'video56_search_'.$_POST['id'].'_'.$this->video56->page;
                break;
            }
             
            // 检查cache是否存在
            $this->checkCache(); 

            // 根据类型执行对应的api
            switch ($data->video56_type) 
            {
                case 'hot':
                    $this->api_data = $this->video56->hot();
                break;

                case 'opera':
                    $this->api_data = $this->video56->opera();
                break;
                
                case 'search':
                    $this->video56->keywords = $data->video56_search_keywords;
                    $this->api_data = $this->video56->search();
                break;
            }
               
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
        $result = $this->renderPartial($this->view_name,array(
            'data' => $this->api_data,
            'page' => ++$this->video56->page,
        ),true);  

        Yii::app()->cache->set($this->cacheName, $result, CACHE_TIME_VIDEO56);

        echo $result;
    }
}