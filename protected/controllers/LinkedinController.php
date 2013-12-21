<?php
/**
 * Linkedin 控制器
 */
class LinkedinController extends xzController
{
    // 实例化的对象
    protected $linkedin;
    // api返回的数据
    protected $api_data;
    // 缓存名
    protected $cacheName;
    // 动作是不是refresh
    protected $action;
    // type是哪种tab类型
    protected $tab;
    // 视图名
    protected $view_name;
    // 页数
    protected $page;


    // 初始化加载
    public function init()
    {
        parent::init();

        $this->linkedin = new api_linkedin(LINKEDIN_API_KEY, LINKEDIN_API_SECRET);
        $this->linkedin->api_redirect_uri = LINKEDIN_REDIRECT_URI;

        $this->action = isset($_POST['action']) ? $_POST['action'] : '';
        $this->tab = isset($_GET['tab']) ? $_GET['tab'] : 'company';
        $this->page = isset($_POST['page']) ? $_POST['page'] : 1;

        $this->linkedin->page = $this->page;
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
     * 获取linkedin帐号
     * @return [type] [description]
     */
    public function actionDel()
    {
        if(isset($_POST['id']))
        {
            $id = $_POST['id'];
            $flag = SocialLinkedin::model()->findByPk($id)->deleteData();
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
            $this->linkedin->code = $_GET['code'];
            $data = $this->linkedin->authorize();

            // 插入的数据
            $inputArray = array(
                'user_id' => Yii::app()->user->id,
                'linkedin_access_token' => $data->access_token,
                'linkedin_userid' => $data->id,
                'linkedin_username' => $data->firstName.' '.$data->lastName,
            );  
           
            $model = new SocialLinkedin;
            $model->attributes = $inputArray;
            if( $model->save() )
                $this->redirect($this->createUrl('/social'));
            else
                xz::dump($model->getErrors());
        }
    }

    /**
     * 解析linkedin数据
     * @return [type] [description]
     */
    public function actionParse()
    {
        if(isset($_POST['id']))
        {
            $data = SocialLinkedin::model()->findByPk($_POST['id']);
            // 赋值
            $this->social_id = $_POST['id'];
            $this->linkedin->api_access_token = $data->linkedin_access_token;

            // 根据tab决定缓存名和视图名
            switch ($this->tab) 
            {
                case 'company':
                    $this->cacheName = 'linkedin_company_data_'.$data->linkedin_userid.'_'.$this->page;
                    $this->view_name = 'load_linkedin_company';
                break;

                case 'myupdate':
                    $this->cacheName = 'linkedin_myupdate_data_'.$data->linkedin_userid.'_'.$this->page;
                    $this->view_name = 'load_linkedin_user';
                break;
            }

            // 检查cache是否存在
            $this->checkCache();  

            // 根据tab决定执行的方法
            switch ($this->tab) 
            {
                case 'company':
                    $this->api_data = $this->linkedin->companyUpdate();
                break;

                case 'myupdate':
                    $this->api_data = $this->linkedin->myUpdate();
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
        $result = $this->renderPartial($this->view_name, array(
            'data' => $this->api_data,
            'page' => ++$this->page,
        ),true);  

        Yii::app()->cache->set($this->cacheName, $result, CACHE_TIME_LINKEDIN);

        echo $result;
    }
}