<?php  
/**
* 这个widget用来显示某个大分类下面的小分类，比如：
* 我们存在一个按类别的大类，所以就可以通过这个得到这个大类下面的小类比如（体育，新闻，科技，财经等。。）
*
* $tableName 可以为xz_rss_category或者xz_rss_website等。。
*/
class displayRss extends CWidget
{
	public $tableName = '';

 	public function run() 
 	{
 		if(empty($this->tableName))
 			throw new CException("必须要指定需要处理的表");

        $results = "";
        $user_id = Yii::app()->user->id;
	    $cacheName = $this->tableName.'_results_'.$user_id;
        // 获得此表是否缓存过，如果缓存过，则获取数据
        $results = Yii::app()->cache->get($cacheName);
        if ($results === false)
        {
            $data =  Yii::app()->db->createCommand()
                                        ->select('id,user_id,name')
                                        ->from($this->tableName)
                                        ->where('(user_id='.$user_id.' OR user_id=0) AND is_deleted=0')
                                        ->order('name asc')
                                        ->queryAll();

            // 输出数据
            foreach ($data as $val) 
            {
                $results .="<option value='".$val['id']."'>".$val['name']."</option>";
            }

            //设置一个缓存依赖，当SQL的查询结果变化时，重新缓存
            $dependency = new CDbCacheDependency("SELECT MAX(update_time) FROM $this->tableName WHERE user_id=".$user_id);
            Yii::app()->cache->set($cacheName, $results, 30*24*60*60, $dependency);                             
        }
    	echo $results;
  	}
}
?>