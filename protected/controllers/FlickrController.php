<?php
/**
 * Flickr 控制器
 */
class FlickrController extends xzController
{
    // 实例化的对象
    protected $flickr;
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

        $this->flickr = new api_flickr(FLICKR_API_KEY, FLICKR_API_SECRET);
        $this->flickr->api_redirect_uri = FLICKR_REDIRECT_URI;

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
     * 删除帐号
     * @return [type] [description]
     */
    public function actionDel()
    {
        if(isset($_POST['id']))
        {
            $id = $_POST['id'];
            $flag = SocialFlickr::model()->findByPk($id)->deleteData();
            xz::outputJson(array('success'=>$flag));
        }
    }

    /**
     * 用户认证
     * @return [type] [description]
     */
    public function actionAuthorize()
    {
        if(isset($_GET['frob']))
        {
            $this->flickr->frob = $_GET['frob'];
            $data = $this->flickr->authorize();

            // 插入的数据
            $inputArray = array(
                'user_id' => Yii::app()->user->id,
                'flickr_token' => $data->auth->token->_content,
                'flickr_nsid' => $data->auth->user->nsid,
                'flickr_username' => $data->auth->user->username,
                'flickr_fullname' => $data->auth->user->fullname,
            );
           
            $model = new SocialFlickr;
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
            $data = SocialFlickr::model()->findByPk($_POST['id']);
            // 赋值
            $this->social_id = $_POST['id'];
            $this->flickr->api_access_token = $data->flickr_token;

            // 根据tab决定缓存名
            switch ($this->tab) 
            {
                case 'recent':
                    $this->cacheName = 'flickr_recent_data_'.$data->flickr_nsid;
                break;

                case 'interest':
                    $this->cacheName = 'flickr_interest_data_'.$data->flickr_nsid;
                break;
                
                case 'mypost':
                    $this->cacheName = 'flickr_mypost_data_'.$data->flickr_nsid;
                break;
            }

            // 检查cache是否存在
            $this->checkCache();  

            // 根据tab决定执行的方法
            switch ($this->tab) 
            {
                case 'recent':
                    $this->api_data = $this->flickr->getRecent();
                break;

                case 'interest':
                    $this->api_data = $this->flickr->getInterest();
                break;
                
                case 'mypost':
                    $this->flickr->flickr_uid = $data->flickr_nsid;
                    $this->api_data = $this->flickr->getMypost();
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
            $data = SocialFlickr::model()->findByPk($_POST['id']);
            // 赋值
            $this->flickr->api_access_token = $data->flickr_token;

            // 根据tab决定执行的操作
            switch ($this->tab) 
            {
                case 'like':
                    $this->flickr->flickr_photoid = $_POST['photoid'];
                    $data = $this->flickr->like();
                break;

                case 'comment':
                    $this->flickr->flickr_photoid = $_POST['photoid'];
                    $this->flickr->flickr_comment = $_POST['comment'];
                    $data = $this->flickr->comment();
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
        $result = $this->renderPartial('load_flickr',array(
            'flickr' => $this->api_data->photos,
        ),true);  

        Yii::app()->cache->set($this->cacheName, $result, CACHE_TIME_FLICKR);

        echo $result;
    }
}