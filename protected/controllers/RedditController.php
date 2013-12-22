<?php
/**
 * Reddit 控制器
 */
class RedditController extends xzController
{
    // 实例化的对象
    protected $reddit;
    // api返回的数据
    protected $api_data;
    // 缓存名
    protected $cacheName;
    // 动作是不是refresh
    protected $action;
    // type是哪种tab类型
    protected $tab;
    // 保存帐号最后的更新时间
    protected $update_time;

    // 初始化加载
    public function init()
    {
        parent::init();

        $this->reddit = new api_reddit(REDDIT_API_KEY, REDDIT_API_SECRET);
        $this->reddit->api_redirect_uri = REDDIT_REDIRECT_URI;
        $this->reddit->reddit_after = isset($_POST['after']) ? $_POST['after'] : '';

        $this->action = isset($_POST['action']) ? $_POST['action'] : '';
        $this->tab = isset($_GET['tab']) ? $_GET['tab'] : 'new';
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
     * 因为reddit的access token每隔一个小时就过期，我们需要使用refresh token
     * 获取最新的access token,所以我们就来检查
     * @return [type] [description]
    */
    private function checkTokenExpired()
    {
       $current = time();
       $update = strtotime($this->update_time);
       // 如果当前时间减去最后更新时间大于一小时，则获取最新的access token
       if( ($current - $update) > 3600 )
       {
            $data = $this->reddit->newToken();
            $model = new SocialReddit;
            $model->reddit_access_token = $data->access_token;
            $model->save();
            // 更新类的access token
            $this->reddit->api_access_token = $data->access_token;
       }
    }

    /**
     * 获取reddit帐号
     * @return [type] [description]
     */
    public function actionDel()
    {
        if(isset($_POST['id']))
        {
            $id = $_POST['id'];
            $flag = SocialReddit::model()->findByPk($id)->deleteData();
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
            $this->reddit->code = $_GET['code'];
            $data = $this->reddit->authorize();

            // 将用户的信息插入数据库
            $inputArray = array(
                'user_id' => Yii::app()->user->id,
                'reddit_userid' => $data->id,
                'reddit_access_token' => $data->access_token,
                'reddit_refresh_token' => $data->refresh_token,
                'reddit_name' => $data->name,
            );
           
            $model = new SocialReddit;
            $model->attributes = $inputArray;
            if( $model->save() )
                $this->redirect($this->createUrl('/social'));
            else
                xz::dump($model->getErrors());
        }
    }

    /**
     * 解析reddit数据
     * @return [type] [description]
     */
    public function actionParse()
    {
        if(isset($_POST['id']))
        {
            $data = SocialReddit::model()->findByPk($_POST['id']);
            // 赋值
            $this->social_id = $_POST['id'];
            $this->update_time = $data->update_time;
            $this->reddit->api_access_token = $data->reddit_access_token;
            $this->reddit->api_refresh_token = $data->reddit_refresh_token;

            // 检查token是否过期
            $this->checkTokenExpired();

            // 根据tab决定缓存名
            switch ($this->tab) 
            {
                case 'new':
                    $this->cacheName = 'reddit_new_data_'.$data->reddit_userid.'_'.$this->reddit->reddit_after;
                break;

                case 'hot':
                    $this->cacheName = 'reddit_hot_data_'.$data->reddit_userid.'_'.$this->reddit->reddit_after;
                break;
                
                case 'controversial':
                    $this->cacheName = 'reddit_controversial_data_'.$data->reddit_userid.'_'.$this->reddit->reddit_after;
                break;

                case 'saved':
                    $this->cacheName = 'reddit_saved_data_'.$data->reddit_userid.'_'.$this->reddit->reddit_after;
                break;
            }

            // 检查cache是否存在
            $this->checkCache();  

            // 根据tab决定执行的方法
            switch ($this->tab) 
            {
                case 'new':
                    $this->api_data = $this->reddit->getNew();
                break;

                case 'hot':
                    $this->api_data = $this->reddit->getHot();
                break;
                
                case 'controversial':
                    $this->api_data = $this->reddit->getControversial();
                break;

                case 'saved':
                    $this->reddit->reddit_username = $data->reddit_name;
                    $this->api_data = $this->reddit->getSaved();
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
            $data = SocialReddit::model()->findByPk($_POST['id']);
            // 赋值
            $this->reddit->api_access_token = $data->reddit_access_token;
            $this->reddit->modhash = $_POST['modhash'];
            $this->reddit->media_id = $_POST['media_id'];

            // 根据tab决定执行的操作
            switch ($this->tab) 
            {
                case 'saved':
                    $data = $this->reddit->saved();
                break;

                case 'vote':
                    $data = $this->reddit->vote();
                break;

                case 'comment':
                    $this->reddit->comment_text = $_POST['comment'];
                    $data = $this->reddit->comment();
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
        $result = $this->renderPartial('load_reddit',array(
            'reddit' => $this->api_data,
        ),true);  

        Yii::app()->cache->set($this->cacheName, $result, CACHE_TIME_REDDIT);

        echo $result;
    }
}