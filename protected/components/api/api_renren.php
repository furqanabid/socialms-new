<?php  
/**
* 人人网的API处理类
*/
class api_renren extends api_common
{
    // API 主机
    private $api_host = 'https://api.renren.com/v2';
    // 分页
    public $page;
    // 每页显示数
    public $count = 20;
    // 人人网用户id
    public $renren_uid;
    // 实体Id
    public $entryId;
    // 实体类型
    public $entryType;
    // 实体所属者ID
    public $entryOwnerId;
    // 留言内容
    public $comment_text;

    // 写评论的时候需要的评论类型
    private $CommentType = array(
        'SHARE', 'ALBUM', 'BLOG', 'STATUS', 'PHOTO'
    );

    /**
     * 认证用户
     * @return [type] [description]
     */
    public function authorize()
    {
        $params = array(
            'grant_type' => 'authorization_code',
            'client_id' => $this->api_key,
            'redirect_uri' => $this->api_redirect_uri,
            'client_secret' => $this->api_secret,
            'code' => $this->code
        );
        // 获取access token的连接
        $url = 'https://graph.renren.com/oauth/token?'.http_build_query($params);
        
        return $this->exec($url);
    }

    /**
     * 获取新鲜事列表
     * @return [type] [description]
     */
    public function getRecent()
    {
        $params = array(
            'access_token' => $this->api_access_token,
            'feedType' => 'ALL',
            'pageSize' => $this->count,
            'pageNumber' => $this->page,
        );
        $url = $this->api_host.'/feed/list?'.http_build_query($params);

        return $this->exec($url);
    }

     /**
      * 获得我发布的一些心情状态
      * @param  [type] $uid  [人人网uid]
      * @param  [type] $page [第几页]
      * @return [type]       [description]
      */
     public function getStatus()
     {
        $params = array(
            'access_token' => $this->api_access_token,
            'ownerId' => $this->renren_uid,
            'pageSize' => $this->count,
            'pageNumber' => $this->page
        );  
        $url = $this->api_host.'/status/list?'.http_build_query($params);

        return $this->exec($url);       
     }

    /**
     * 以分页的方式获取某个用户的分享列表
     * @param  [type] $ownerId    [用户ID]
     * @param  [type] $page [分页数]
     * @return [type]             [description]
     */
     public function getShare()
     {
        $params = array(
            'access_token' => $this->api_access_token,
            'ownerId' => $this->renren_uid,
            'pageSize' => $this->count,
            'pageNumber' => $this->page
        );  
        $url = $this->api_host.'/share/list?'.http_build_query($params);

        return $this->exec($url); 
     }

    /**
     * 发送一个comment
     * @param  [type] $inputArray [必须传入的参数]
     * @return [type]             [description]
     */
    public function comment()
    {
        // 过滤评论类型
        if(strpos($this->entryType, 'SHARE') !== false)
            $this->entryType = 'SHARE';
        else if(strpos($this->entryType, 'PHOTO') !== false)
            $this->entryType = 'PHOTO';
        else if(strpos($this->entryType, 'STATUS') !== false)
            $this->entryType = 'STATUS';
        else if(strpos($this->entryType, 'BLOG') !== false)
            $this->entryType = 'BLOG';
        else
            $this->entryType = 'ALBUM';
        
        $params = array(
            'content' => $this->comment_text,
            'commentType' => $this->entryType,
            'entryOwnerId' => $this->entryOwnerId,
            'entryId' => $this->entryId,
            'access_token' => $this->api_access_token
        );

        $url = $this->api_host.'/comment/put';

        return $this->exec($url, $params);
    }  

    /**
     * 发送一个赞到人人
     * @param  [type] $inputArray [必须传入的参数]
     * @return [type]             [description]
     */
    public function like()
    {
        // 过滤类型
        if(strstr($this->entryType, 'SHARE'))
            $this->entryType = 'TYPE_SHARE';
        else if(strstr($this->entryType, 'VIDEO'))
            $this->entryType = 'TYPE_VIDEO';
        else if(strstr($this->entryType, 'BLOG'))
            $this->entryType = 'TYPE_BLOG';
        else if(strstr($this->entryType, 'PHOTO'))
            $this->entryType = 'TYPE_PHOTO';
        else if(strstr($this->entryType, 'STATUS'))
            $this->entryType = 'TYPE_STATUS';
        else
            $this->entryType = 'TYPE_ALBUM';

        $params = array(
            'ugcOwnerId' => $this->entryOwnerId,
            'likeUGCType' => $this->entryType,
            'ugcId' => $this->entryId,
            'access_token' => $this->api_access_token
        );

        $url = $this->api_host.'/like/ugc/put';

        return $this->exec($url, $params);
    } 

    /**
     * 分享人人网内部UGC资源，例如：日志、照片、相册、分享(基于已有分享再次进行分享）
     * @param  [type] $inputArray [必须传入的参数]
     * @return [type]             [description]
     */
    public function share()
    {      
        // 过滤类型
        if(strstr($this->entryType, 'SHARE') === false)
        {
            return array(
                'error' => true,
                'error' => array(
                    'message' => '操作失败,您只能操作分享的内容...'
                ),
            );
        }  

        $url = $this->api_host.'/share/ugc/put';
        $params = array(
           'ugcOwnerId' => $this->entryOwnerId,
           'ugcType' => 'TYPE_SHARE',
           'ugcId' => $this->entryId,
           'access_token' => $this->api_access_token
        );  

        return $this->exec($url, $params);      
    }

    /**
     * 发送自定义新鲜事。新鲜事会发布用户的个人动态信息到用户人人网主页，
     * 同时会出现在好友的新鲜事中。
     * @return [type] [description]
     */ 
    public function feed_put($inputArray)
    {
        $url = $this->api_host.'/feed/put';
        $inputArray['access_token'] = $this->api_access_token;   

        return $this->exec($url, $inputArray);
    }

    /**
     * 执行api
     * @return [type] [description]
     */ 
    public function exec($url, $data=array())
    {
        if(count($data) > 0)
            $res = $this->curl_post($url, $data);
        else
            $res = $this->curl_get($url);

        return json_decode($res);
    }
}
?>
