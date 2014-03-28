<?php
/**
 * Rss 控制器
 */
class RssController extends xzController
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
                'actions'=>array('userRss','recommendRss','del','parse','newRss'),
                'users'=>array('@'),
            ),
            array('deny',  
                'users'=>array('*'),
            ),
        );
    }

    /**
     * 添加一个新的rss
     * @return [type] [description]
     */
    public function actionNewRss()
    {
        if(isset($_POST['categoryId']))
        {
            $data = array();
            $inputArray = array(
                'rss_category_id' => $_POST['categoryId'],
                'name' => $_POST['rssName'],
                'url' => $_POST['rssUrl'],
            );
            
            // 检查这个rss是否是能够被解析的地址
            $checkRes = Yii::app()->parseRss->load($inputArray['url'])->validate();
            if(empty($checkRes))
            {
                $data['success'] = false;
                $data['msg'] = '您输入的rss地址不能被解析!';
            }
            else
            {                        
                $model = new SocialRss('create');                                
                $model->attributes = $inputArray;
                if( $model->save() )
                {
                    $data['success'] = true;
                    $data['data'] = $model->attributes;
                }
            }

           xz::outputJson($data);
        }
    }

    /**
     * 获取用户自己添加的rss
     * @return [type] [description]
     */
    public function actionUserRss()
    {
        if(isset($_POST['category_id']))
        {
            $categoryId = $_POST['category_id'];
            $user_id = Yii::app()->user->id;

            $cacheName = 'rss_user_category_feeds_'.$user_id.'_'.$categoryId;
            $results = Yii::app()->cache->get($cacheName);
            if ($results === false)
            {
                $data =  Yii::app()->db->createCommand()
                                        ->select('*')
                                        ->from('xz_social_rss')
                                        ->where('user_id='.$user_id.' AND rss_category_id='.$categoryId.' AND is_deleted=0')
                                        ->order('name asc')
                                        ->queryAll();

                // 加载视图获取rss的列表
                $results = $this->renderPartial('user_rss_feeds_list', array(
                    'data'=>$data
                ), true);

                //设置一个缓存依赖，当SQL的查询结果变化时，重新缓存
                $dependency = new CDbCacheDependency("SELECT max(update_time) FROM xz_social_rss WHERE user_id=".$user_id." AND rss_category_id=".$categoryId);
                Yii::app()->cache->set($cacheName, $results, 30*24*60*60, $dependency);                           
            }

            echo $results;
        }
    }

    /**
     * 获取推荐给用户的rss
     * @return [type] [description]
     */
    public function actionRecommendRss()
    {
        if(isset($_POST['category_id']))
        {
            $category_id = $_POST['category_id'];
            $cacheName = 'rss_category_feeds_'.$category_id;
            $results = Yii::app()->cache->get($cacheName);
            if ($results === false)
            {
                $data =  Yii::app()->db->createCommand()
                                        ->select('xz_social_rss_master.*')
                                        ->from('xz_social_rss_xref_category')
                                        ->leftJoin('xz_social_rss_master', 'xz_social_rss_master.id=xz_social_rss_xref_category.rss_master_id')
                                        ->where('xz_social_rss_xref_category.rss_category_id='.$category_id.' AND xz_social_rss_master.is_deleted=0')
                                        ->order('xz_social_rss_master.name asc')
                                        ->queryAll();

                // 加载视图获取rss的列表
                $results = $this->renderPartial('rss_feeds_list', array(
                    'data'=>$data
                ), true);

                //设置一个缓存依赖，当SQL的查询结果变化时，重新缓存
                $dependency = new CDbCacheDependency("SELECT id FROM xz_social_rss_xref_category ORDER BY id DESC LIMIT 1");
                Yii::app()->cache->set($cacheName, $results, 30*24*60*60, $dependency);                          
            }

            echo $results;
        }
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
            $flag = SocialRss::model()->findByPk($id)->deleteData();
            xz::outputJson(array('success'=>$flag));
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
            $data = SocialRssMaster::model()->findByPk($_POST['id']);
            // refresh的数据
            $this->action = isset($_POST['action']) ? $_POST['action'] : '';
            // 缓存名
            $this->cacheName = 'rss_data_'.$_POST['id'];
 
            // 检查cache是否存在
            $this->checkCache(); 

            $this->api_data = Yii::app()->parseRss->load($data->url)->parse();
               
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
        $result = $this->renderPartial('load_rss',array(
            'data' => $this->api_data,
        ),true);  

        Yii::app()->cache->set($this->cacheName, $result, CACHE_TIME_RSS);

        echo $result;
    }
}