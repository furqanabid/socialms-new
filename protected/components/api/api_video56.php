<?php  
/**
* 56视频的API处理类
*/
class api_video56 extends api_common
{
    // API 主机
    private $api_host = 'http://oapi.56.com/video';

    // 限制每页显示数量
    public $count = 5;
    // 分页数
    public $page;
    // 热门视频的类型id
    public $type_id;
    // 搜索的关键字
    public $keywords;

    /**
    * 获取首页热门的视频信息
    * param  [type] $id [视频类型标识值]
    * @return [type]              [description]
    */
    public function hot()
    {
        $params = array(       
            'cid' => $this->type_id,
            'num' => $this->count,
            'page' => $this->page,
        );

        $url = $this->api_host.'/hot.json?';

        return $this->exec($url, $params);
    }


    /**
     * 56自制剧集
     * @return [type] [description]
     */
    public function opera()
    {
        $params = array(
            'mid' => $this->type_id,
        );

        $url = $this->api_host.'/opera.json?';
        
        return $this->exec($url, $params);
    }

    /**
     * search视频
     * @return [type] [description]
     */
    public function search()
    {
        $params = array(
            'keyword' => $this->keywords,
            'rows' => $this->count,
            'page' => $this->page,
        );

        $url = $this->api_host.'/search.json?';
        
        return $this->exec($url, $params);
    }


    /**
    * @description 签名方法实现，并构造一个参数串
    * 
    * @access private
    * @param mixed $params
    * @return void
    */
    private function signRequest($params)
    {
        $keys   = self::urlencodeRfc3986(array_keys($params));
        $values = self::urlencodeRfc3986(array_values($params));
        if($keys and $values)
        {
            $params = array_combine($keys,$values);
        }
        else
        {
            try 
            {
                throw new Exception("signRequest need params exits!");
            } catch(Exception $e) {
                echo $e->getMessage();
            }
        }
    
        // 按字母顺序排序
        ksort($params);
        /**
        * 第一轮md5字符串
        * */    
        $sign_1   =  md5(http_build_query($params));
        $ts    =  time();

        /**第二轮md5字符串,得到最后的签名变量,注意里面的顺序不可以改变否则结果错误!**/
        $params['sign'] = md5($sign_1.'#'.$this->api_key.'#'.$this->api_secret.'#'.$ts);
        $params['appkey']=$this->api_key;
        $params['ts']=$ts;

        return http_build_query($params);
    }

    /**
    * @description 转码异常字符
    * 
    * @access public
    * @param mixed $input
    * @return void
    */
    public static function urlencodeRfc3986($input)
    { 
        if (is_array($input))
        {
            return array_map( array('self', 'urlencodeRfc3986') , $input );
        }
        else if( is_scalar($input))
        {
            return str_replace( '+' , ' ' , str_replace( '%7E' , '~' , rawurlencode($input)));
        }
        else
        {
            return '';
        }
    }

    /**
     * 执行api
     * @return [type] [description]
     */
    public function exec($url, $data)
    {
        $params = $this->signRequest($data);

        // 给url加上参数
        $url = $url.$params;
        // 执行
        $res = $this->curl_get($url);
        
        return json_decode($res);
    }
}
?>
