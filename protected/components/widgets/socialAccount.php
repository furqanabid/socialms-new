<?php  
/**
 * 通过用户的user_id获取他下面的options
 * 
 * 用来显示Social Account Select Options
*/
class socialAccount extends CWidget
{
    public $table;
    public $name;

    public function run() 
    {
        $user_id = Yii::app()->user->id;
        $cacheName = $this->table.'_'.$user_id;

        $result = Yii::app()->cache->get($cacheName);
        if($result === false)
        {
            $data = Yii::app()->db->createCommand()
                                    ->select('*')
                                    ->from($this->table)
                                    ->where('is_deleted=0 AND user_id='.$user_id)
                                    ->queryAll();   

            if(count($data) > 0)
            {
                $result = '';
                foreach ($data as $key => $val) 
                {
                    $result .= "<option value=".$val['id'].">".$val[$this->name]."</option>";
                }                
            }

            //设置一个缓存依赖，当SQL的查询结果变化时，重新缓存
            $dependency = new CDbCacheDependency("SELECT max(update_time) FROM $this->table WHERE user_id=".$user_id);
            Yii::app()->cache->set($cacheName, $result, 30*24*60*60, $dependency);         
        }
        echo $result;
    }       
    
}
?>