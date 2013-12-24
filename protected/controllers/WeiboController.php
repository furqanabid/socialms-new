<?php
/**
 * weibo 控制器
 */
class weiboController extends xzController
{
    // 实例化的对象
    protected $weibo;
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
    // 视图名
    protected $view_name;


    // 初始化加载
    public function init()
    {
        parent::init();

        $this->weibo = new api_weibo(WEIBO_API_KEY, WEIBO_API_SECRET);
        $this->weibo->api_redirect_uri = WEIBO_REDIRECT_URI;
        $this->weibo->page = isset($_POST['page']) ? $_POST['page'] : 1;

        $this->action = isset($_POST['action']) ? $_POST['action'] : '';
        $this->tab = isset($_GET['tab']) ? $_GET['tab'] : 'home';
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
     * 因为renren的access token会过期
     * 所以我们就来检查
     * @return [type] [description]
    */
    private function checkTokenExpired()
    {
        $current = time();
        $update = strtotime($this->update_time);
        // 如果当前时间减去最后更新时间大于这个时间，则获取最新的access token
        if( ($current - $update) > 157679999 )
        {
            echo '您帐号的API有效期已经到期，请重新添加!';
            exit();
        }
    }

    /**
     * 获取weibo帐号
     * @return [type] [description]
     */
    public function actionDel()
    {
        if(isset($_POST['id']))
        {
            $id = $_POST['id'];
            $flag = SocialWeibo::model()->findByPk($id)->deleteData();
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
            $this->weibo->code = $_GET['code'];
            $data = $this->weibo->authorize();

            // 插入的数据
            $inputArray = array(
               'user_id' => Yii::app()->user->id,
               'weibo_uid' => $data->uid,
               'weibo_access_token' => $data->access_token,
               'weibo_username' => $data->screen_name
            );
           
            $model = new SocialWeibo;
            $model->attributes = $inputArray;
            if( $model->save() )
                $this->redirect($this->createUrl('/social'));
            else
                xz::dump($model->getErrors());
        }
    }

    /**
     * 解析weibo数据
     * @return [type] [description]
     */
    public function actionParse()
    {
        if(isset($_POST['id']))
        {
            $data = SocialWeibo::model()->findByPk($_POST['id']);
            // 赋值
            $this->social_id = $_POST['id'];
            $this->weibo->api_access_token = $data->weibo_access_token;
            $this->update_time = $data->update_time;

            // 检查token是否过期
            $this->checkTokenExpired();

            // 根据tab决定缓存名和视图名
            switch ($this->tab) 
            {
                case 'home':
                    $this->view_name = 'home_timeline_list';
                    $this->cacheName = 'weibo_home_'.$data->weibo_uid.'_'.$this->weibo->page;
                break;

                case 'user':
                    $this->view_name = 'user_timeline_list';
                    $this->cacheName = 'weibo_user_'.$data->weibo_uid.'_'.$this->weibo->page;
                break;

                case 'favorite':
                    $this->view_name = 'favorites_list';
                    $this->cacheName = 'weibo_favorites_'.$data->weibo_uid.'_'.$this->weibo->page;
                break;
            }

            // 检查cache是否存在
            $this->checkCache();  

            // 根据tab决定执行的方法
            switch ($this->tab) 
            {
                case 'home':
                    $this->api_data = $this->weibo->home_timeline();
                break;

                case 'user':
                    $this->api_data = $this->weibo->user_timeline();
                break;

                case 'favorite':
                    $this->api_data = $this->weibo->getFavorites();
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
            $data = SocialWeibo::model()->findByPk($_POST['id']);
            // 赋值
            $this->weibo->api_access_token = $data->weibo_access_token;
            $this->weibo->weibo_id = $_POST['weibo_idstr'];
            $this->weibo->weibo_uid = $_POST['weibo_uidstr'];

            // 根据tab决定执行的操作
            switch ($this->tab) 
            {
                case 'comment':
                    $this->weibo->comment_text = $_POST['content'];
                    $data = $this->weibo->comment();
                break;

                case 'favorite':
                    $data = $this->weibo->favorite_create();
                break;

                case 'unfavorite':
                    $data = $this->weibo->favorite_cancel();
                break;

                case 'unfollow':
                    $data = $this->weibo->unfollow();
                break;

                case 'top':
                    $data = $this->weibo->setTop();
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
        $result = $this->renderPartial($this->view_name, array(
            'data' => $this->api_data,
            'page' => ++$this->weibo->page,
        ),true);  

        Yii::app()->cache->set($this->cacheName, $result, CACHE_TIME_WEIBO);

        echo $result;
    }
}