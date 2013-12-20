<?php
/**
 * Instagram 控制器
 */
class InstagramController extends xzController
{
    // 实例化的对象
    protected $instagram;
    // api返回的数据
    protected $api_data;
    // 缓存名
    protected $cacheName;
    // 动作是不是refresh
    protected $action;
    // type是哪种tab类型
    protected $tab;


    // 初始化加载
    public function init()
    {
        parent::init();

        $this->instagram = new api_instagram(INSTAGRAM_API_KEY, INSTAGRAM_API_SECRET);
        $this->instagram->api_redirect_uri = INSTAGRAM_REDIRECT_URI;

        $this->action = isset($_POST['action']) ? $_POST['action'] : '';
        $this->tab = isset($_GET['tab']) ? $_GET['tab'] : 'recent';
    }

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
                'actions'=>array('del','parse','authorize','operate'),
                'users'=>array('@'),
            ),
            array('deny',  
                'users'=>array('*'),
            ),
        );
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
            $flag = SocialInstagram::model()->findByPk($id)->deleteData();
            xz::outputJson(array('success'=>$flag));
        }
    }

    /**
     * 用户认证
     * @return [type] [description]
     */
    public function actionAuthorize()
    {
        if(isset($_GET['code']))
        {
            $this->instagram->code = $_GET['code'];
            $data = $this->instagram->authorize();

            // 插入的数据
            $inputArray = array(
                'user_id' => Yii::app()->user->id,
                'instagram_userid' => $data->user->id,
                'instagram_access_token' => $data->access_token,
                'instagram_username' => $data->user->username,
                'instagram_fullname' => $data->user->full_name
            );
           
            $model = new SocialInstagram;
            $model->attributes = $inputArray;
            if( $model->save() )
                $this->redirect($this->createUrl('/social'));
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
            $data = SocialInstagram::model()->findByPk($_POST['id']);
            // 赋值
            $this->social_id = $_POST['id'];
            $this->instagram->api_access_token = $data->instagram_access_token;

            // 根据tab决定缓存名
            switch ($this->tab) 
            {
                case 'recent':
                    $this->cacheName = 'instagram_recent_data_'.$data->instagram_userid;
                break;

                case 'popular':
                    $this->cacheName = 'instagram_popular_data_'.$data->instagram_userid;
                break;
                
                case 'mypost':
                    $this->cacheName = 'instagram_mypost_data_'.$data->instagram_userid;
                break;

                case 'nextpage':
                    $this->cacheName = 'instagram_next_data_'.$_POST['nextid'];
                break;
            }

            // 检查cache是否存在
            $this->checkCache();  

            // 根据tab决定执行的方法
            switch ($this->tab) 
            {
                case 'recent':
                    $this->api_data = $this->instagram->getRecent();
                break;

                case 'popular':
                    $this->api_data = $this->instagram->getPopular();
                break;
                
                case 'mypost':
                    $this->instagram->instagram_uid = $data->instagram_userid;
                    $this->api_data = $this->instagram->getMypost();
                break;

                case 'nextpage':
                    $nexturl = $_POST['nexturl'];
                    $data = $this->instagram->curl_get($nexturl);
                    $this->api_data = json_decode($data);
                break;
            }
            
            // 在视图里面解析数据
            $this->show();
        }
    }

    /**
     * 一些操作比如留言，喜欢，赞等
     * @return [type] [description]
     */
    public function actionOperate()
    {
        if(isset($_POST['id']))
        {
            $data = SocialInstagram::model()->findByPk($_POST['id']);
            // 赋值
            $this->instagram->api_access_token = $data->instagram_access_token;

            // 根据tab决定执行的操作
            switch ($this->tab) 
            {
                case 'like':
                    $this->instagram->media_id = $_POST['mediaid'];
                    $data = $this->instagram->like();
                break;

                case 'unfollow':
                    $this->instagram->follow_uid = $_POST['userid'];
                    $data = $this->instagram->unfollow();
                break;

                case 'comment':
                    $this->instagram->media_id = $_POST['mediaid'];
                    $this->instagram->comment_text = $_POST['comment'];
                    $data = $this->instagram->comment();
                break;
                
            }

            xz::outputJson($data);
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
        $result = $this->renderPartial('load_instagram',array(
            'instagram' => $this->api_data,
            'id' => $this->social_id,
        ),true);  

        Yii::app()->cache->set($this->cacheName, $result, CACHE_TIME_INSTAGRAM);

        echo $result;
    }
}