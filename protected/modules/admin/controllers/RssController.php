<?php
class RssController extends xz1Controller
{
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
	            'actions'=>array('index','check'),
	            'expression'=>"Yii::app()->user->getState('is_admin')==1",
	        ),
	        array('deny',  
	            'users'=>array('*'),
	        ),
	    );
	}

	/**
	 * Rss首页
	 * @return [type] [description]
	 */
	public function actionIndex()
	{
		$model = new SocialRss('create');
        // rss数据的插入
        if(isset($_POST['SocialRss']))
        {
            // Rss的插入
            $model->attributes = $_POST['SocialRss'];
            $model->save();

            $inputArray = array(                
                'rss_master_id' => $model->rss_master_id
            );

            // 将数据插入xref category表                                                        
            $inputArray['category_id'] = isset($_POST['SocialRssCategory']['name']) ? $_POST['SocialRssCategory']['name'] : '';
            SocialRssXrefCategory::insertMultipleRows($inputArray);


            Yii::app()->user->setFlash('rss-create','<strong>恭喜您！</strong> 你已经成功的添加了这个rss.');
        }                

        // clear any default values
        $model->unsetAttributes(); 

		$this->render('index', array(
			'model' => $model
		));
	}

	/**
	 * 检查rss的正确性
	 * @return [type] [description]
	 */
	public function actionCheck()
	{
		// 如果这个rss已经在rss master表存在，则获取此数据
        $rss = $_POST['rss'];
        $rssMaster = SocialRssMaster::checkRssMasterExist($rss);
        if(isset($rssMaster['id']))
        {
            // 如果是一个已经存在rss master表中的rss，则取出所有表的数据
            $data = array();
            $data['success'] = 'exist';
            $data['SocialRss']['name'] = $rssMaster['name'];

            // 获取对应xref表中的数据
            $data['xref']['SocialRssCategory[name][]'] = SocialRssXrefCategory::model()->getColumn('rss_category_id', 'rss_master_id='.$rssMaster['id']);
        }
        else
        {
            // 如果是个新的rss，则验证并获取数据
            $title = Yii::app()->parseRss->load($rss)->validate();
            if($title)
            {
                $data['success'] = true;
                $data['title'] = $title;
            }
            else
            {
                $data['success'] = false;
            }
        }   

        xz::outputJson($data);      
	}
}