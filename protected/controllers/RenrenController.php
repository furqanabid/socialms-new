<?php
/**
 * Renren 控制器
 */
class RenrenController extends xzController
{
    // 实例化的对象
    protected $renren;
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

        $this->renren = new api_renren(RENREN_API_KEY, RENREN_API_SECRET);
        $this->renren->api_redirect_uri = RENREN_REDIRECT_URI;
        $this->renren->page = isset($_POST['page']) ? $_POST['page'] : 1;

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
     * 因为renren的access token每隔一个小时就过期，我们需要使用refresh token
     * 获取最新的access token,所以我们就来检查
     * @return [type] [description]
    */
    private function checkTokenExpired()
    {
        $current = time();
        $update = strtotime($this->update_time);
        // 如果当前时间减去最后更新时间大于这个时间，则获取最新的access token
        if( ($current - $update) > 2593074 )
        {
            echo '您帐号的API有效期已经到期，请重新添加!';
            exit();
        }
    }

    /**
     * 获取renren帐号
     * @return [type] [description]
     */
    public function actionDel()
    {
        if(isset($_POST['id']))
        {
            $id = $_POST['id'];
            $flag = SocialRenren::model()->findByPk($id)->deleteData();
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
            $this->renren->code = $_GET['code'];
            $data = $this->renren->authorize();

            // 将用户的信息插入数据库
            $inputArray = array(
                'user_id' => Yii::app()->user->id,
                'renren_uid' => $data->user->id,
                'renren_access_token' => $data->access_token,
                'renren_refresh_token' => $data->refresh_token,
                'renren_username' => $data->user->name
            );
           
            $model = new SocialRenren;
            $model->attributes = $inputArray;
            if( $model->save() )
                $this->redirect($this->createUrl('/social'));
            else
                xz::dump($model->getErrors());
        }
    }

    /**
     * 解析renren数据
     * @return [type] [description]
     */
    public function actionParse()
    {
        if(isset($_POST['id']))
        {
            $data = SocialRenren::model()->findByPk($_POST['id']);
            // 赋值
            $this->social_id = $_POST['id'];
            $this->update_time = $data->update_time;
            $this->renren->api_access_token = $data->renren_access_token;
            $this->renren->api_refresh_token = $data->renren_refresh_token;

            // 检查token是否过期
            $this->checkTokenExpired();

            // 根据tab决定缓存名和视图名
            switch ($this->tab) 
            {
                case 'recent':
                    $this->cacheName = 'renren_recent_data_'.$data->renren_uid.'_'.$this->renren->page;
                    $this->view_name = 'renren_feed_list';
                break;

                case 'status':
                    $this->renren->renren_uid = $data->renren_uid;
                    $this->cacheName = 'renren_status_data_'.$data->renren_uid.'_'.$this->renren->page;
                    $this->view_name = 'renren_status';
                break;
                
                case 'share':
                    $this->renren->renren_uid = $data->renren_uid;
                    $this->cacheName = 'renren_share_data_'.$data->renren_uid.'_'.$this->renren->page;
                    $this->view_name = 'renren_share';
                break;
            }

            // 检查cache是否存在
            $this->checkCache();  

            // 根据tab决定执行的方法
            switch ($this->tab) 
            {
                case 'recent':
                    $this->api_data = $this->renren->getRecent();
                break;

                case 'status':
                    $this->api_data = $this->renren->getStatus();
                break;
                
                case 'share':
                    $this->api_data = $this->renren->getShare();
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
            $data = SocialRenren::model()->findByPk($_POST['id']);
            // 赋值
            $this->renren->api_access_token = $data->renren_access_token;
            $this->renren->entryId = $_POST['entryId'];
            $this->renren->entryType = $_POST['entryType'];
            $this->renren->entryOwnerId = $_POST['entryOwnerId'];


            // 根据tab决定执行的操作
            switch ($this->tab) 
            {
                case 'like':
                    $data = $this->renren->like();
                break;

                case 'share':
                    $data = $this->renren->share();
                break;

                case 'comment':
                    $this->renren->comment_text = $_POST['content'];
                    $data = $this->renren->comment();
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
        $result = $this->renderPartial($this->view_name,array(
            'data' => $this->api_data->response,
            'page' => ++$this->renren->page,
        ),true);  

        Yii::app()->cache->set($this->cacheName, $result, CACHE_TIME_RENREN);

        echo $result;
    }
}