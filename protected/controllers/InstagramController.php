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


    // 初始化加载
    public function init()
    {
        parent::init();

        $this->instagram = new api_instagram(INSTAGRAM_API_KEY, INSTAGRAM_API_SECRET);
        $this->instagram->api_redirect_uri = INSTAGRAM_REDIRECT_URI;
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
                'actions'=>array('del','parse','authorize'),
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
            $this->id = $_POST['id'];
            $data = SocialInstagram::model()->findByPk($this->id);
            $this->return_data['title'] = $data->instagram_username;
            $this->instagram->api_access_token = $data->instagram_access_token;
            $this->cacheName = 'instagram_recent_data_'.$data->instagram_userid;

            // 检查cache是否存在
            $this->checkCache();  

            // 获取recent数据
            $this->api_data = $this->instagram->getRecent();
            // 在视图里面解析数据
            $this->show();
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
                    ),true);  

        $this->return_data['content'] = $result; 
        Yii::app()->cache->set($this->cacheName, $this->return_data, CACHE_TIME_INSTAGRAM);
        // 返回数据
        $this->output();
    }

    /**
     * 检查是否需要重新缓存
     * @return [type] [description]
     */
    public function checkCache()
    {
        $result = Yii::app()->cache->get($this->cacheName);
        // 如果存在缓存，则获取缓存值
        if($result !== false)
        {                
            $this->return_data = $result;
            $this->return_data['from_cache'] = true;
            // 返回数据
            $this->output();
            // 结束
            Yii::app()->end();
        }
    }

}