<?php  
/**
 *用来获取56视频的数据
*/
class displayVideo56 extends CWidget
{
    public $type;
    public $name;

    public function run() 
    {
        if(!Yii::app()->user->isGuest)
        {
            $user_id = Yii::app()->user->id;
            $cacheName = 'video56_'.$user_id.'_'.$this->type;

            $result = Yii::app()->cache->get($cacheName);
            if($result === false)
            {
                if($this->type == 'hot' || $this->type == 'opera')
                {
                    $data = Yii::app()->db->createCommand()
                                            ->select('*')
                                            ->from('xz_social_video56')
                                            ->where('is_deleted=0 AND user_id=0 AND video56_type="'.$this->type.'"')
                                            ->queryAll();  
                }
                else
                {
                    $data = Yii::app()->db->createCommand()
                                            ->select('*')
                                            ->from('xz_social_video56')
                                            ->where('is_deleted=0 AND user_id='.$user_id.' AND video56_type="'.$this->type.'"')
                                            ->order('id desc')
                                            ->limit(10)
                                            ->queryAll();  
                }
                

                if(count($data) > 0)
                {
                    $result = '';
                    foreach ($data as $key => $val) 
                    {
                        $result .= "<option value=".$val['id'].">".$val[$this->name]."</option>";
                    }
                      
                }

                //设置一个缓存依赖，当SQL的查询结果变化时，重新缓存
                $dependency = new CDbCacheDependency("SELECT max(update_time) FROM xz_social_video56 WHERE user_id=".$user_id);
                Yii::app()->cache->set($cacheName, $result, 30*24*60*60, $dependency);         
            }

            echo $result;
        }       
    }

    
}
?>