<?php  
/**
* 新浪微博的API处理类
*/
class api_weibo extends api_common
{
    // API 主机
    private $api_host = 'https://api.weibo.com/2';

    // 认证code
    public $code;
    // 限制每页显示数量
    public $count = 30;
    // 用户在微博的id
    public $weibo_uid;
    // 页数
    public $page;
    // 微博的id
    public $weibo_id;
    // 微博评论内容
    public $comment_text;

    /**
     * 认证用户
     * @return [type] [description]
     */
    public function authorize()
    {
        $params = array(
            'client_id' => $this->api_key,
            'client_secret' => $this->api_secret,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $this->api_redirect_uri,
            'code' => $this->code
        );

        // 获取access token的连接
        $url = 'https://api.weibo.com/oauth2/access_token';
        
        $data = $this->exec($url, $params);
        $this->api_access_token = $data->access_token;
        $this->weibo_uid = $data->uid;

        // 获取用户的信息
        return $this->userInfo();
    }

    /**
     * 根据用户ID获取用户信息
     * @return [type] [description]
     */
    public function userInfo()
    {
        $params = array(
            'access_token' => $this->api_access_token,
            'uid' => $this->weibo_uid
        );

        $url = $this->api_host.'/users/show.json?';
        
        $data = $this->exec($url, $params, 'get');
        $data->access_token = $this->api_access_token;
        $data->uid = $this->weibo_uid;

        return $data;
    }

   /**
    * 获取当前登录用户及其所关注用户的最新微博
    * @param  [type] $page [返回结果的页码，默认为1。]
    * @return [type]              [description]
    */
    public function home_timeline()
    {
        $params = array(
            'access_token' => $this->api_access_token,
            'count' => $this->count,
            'page' => $this->page,
        );
        $url = $this->api_host.'/statuses/home_timeline.json?';
        
        return $this->exec($url, $params, 'get');
    }

    /**
    * 获取某个用户最新发表的微博列表
    * @param  [type] $page [返回结果的页码，默认为1。]
    * @return [type]              [description]
    */
    public function user_timeline()
    {
        $params = array(
            'access_token' => $this->api_access_token,
            'count' => $this->count,
            'page' => $this->page,
        );
        $url = $this->api_host.'/statuses/user_timeline.json?';
        
        return $this->exec($url, $params, 'get');
    }


    /**
    * 获取当前登录用户的收藏列表
    * @param  [type] $page [返回结果的页码，默认为1。]
    * @return [type]              [description]
    */
    public function getFavorites()
    {
        $params = array(
            'access_token' => $this->api_access_token,
            'count' => $this->count,
            'page' => $this->page,
        );
        $url = $this->api_host.'/favorites.json?';
        
        return $this->exec($url, $params, 'get');
    }

    /**
     * 添加一条微博到收藏里
     * @param  [type] $id [要收藏的微博ID]
     * @return [type]     [description]
     */
    public function favorite_create()
    {       
        $params = array(
            'access_token' => $this->api_access_token,
            'id' => $this->weibo_id,
        );    

        $url = $this->api_host.'/favorites/create.json';

        return $this->exec($url, $params);
    }

    /**
     * 取消收藏一条微博
     * @param  [type] $id [要收藏的微博ID]
     * @return [type]     [description]
     */
    public function favorite_cancel()
    {
        $params = array(
            'access_token' => $this->api_access_token,
            'id' => $this->weibo_id,
        );   

        $url = $this->api_host.'/favorites/destroy.json';

        return $this->exec($url, $params);
    }

    /**
     * 取消关注一个用户
     * @param  [type] $uid [需要取消关注的用户ID。]
     * @return [type]      [description]
     */
    public function unfollow()
    {   
        $params = array(
            'access_token' => $this->api_access_token,
            'uid' => $this->weibo_uid,
        );    

        $url = $this->api_host.'/friendships/destroy.json';

        return $this->exec($url, $params);
    }   

    /**
     * 对一条微博进行评论
     * @param  [type] $inputArray [comment 评论内容，必须做URLencode，内容不超过140个汉字]
     * @param  [type] $inputArray [id 需要评论的微博ID。]
     * @return [type]             [description]
     */
    public function comment()
    {
        $params = array(
            'id' => $this->weibo_id,
            'comment' => $this->comment_text,
            'access_token' => $this->api_access_token,
        );
  
        $url = $this->api_host.'/comments/create.json';
        return $this->exec($url, $params);
    }

    /**
     * 发布一条新微博
     * @return [type] [description]
     */
    public function statuses_update($inputArray)
    {
        $inputArray['access_token'] = $this->api_access_token;

        $url = $this->api_host.'/statuses/update.json';
        return $this->exec($url, $inputArray);
    }

     /**
     * 上传图片并发布一条新微博
     * @return [type] [description]
     */
    public function statuses_upload($inputArray)
    {
        $inputArray['access_token'] = $this->api_access_token;

        $url = $this->api_host.'/statuses/upload.json';
        return $this->exec($url, $inputArray, 'post', true);
    }

    /**
     * [设置当前用户主页置顶微博
     * @param [type] $id [description]
     */
    public function setTop()
    {   
        $params = array(
            'access_token' => $this->api_access_token,
            'id' => $this->weibo_id,
        );  
        
        $url = $this->api_host.'/users/set_top_status.json';

        return $this->exec($url, $params);
    }

    /**
     * 执行API
     * @return [type] [description]
     */
    public function exec($url, array $data, $method='post', $multi = false)
    {
        if($method == 'post')
        {
            if($multi)
            {
                $postData = $this->build_http_query_multi($data);

                // 需要发送的header
                $this->headers[] = "Content-Type: multipart/form-data; boundary=".$this->boundary;
                $this->headers[] = "Authorization: OAuth2 ".$this->api_access_token;
            }
            else
            {
                $postData = http_build_query($data);
            }

            $res = $this->curl_post($url, $postData, array(), $multi);
        }
        else
        {
            $url = $url.http_build_query($data);
            $res = $this->curl_get($url);
        }

        return json_decode($res);
    }
    

    /**
     * @ignore
     */
    public function build_http_query_multi($params) 
    {
        if (!$params) return '';

        uksort($params, 'strcmp');

        $pairs = array();

        $this->boundary = $boundary = uniqid('------------------');
        $MPboundary = '--'.$boundary;
        $endMPboundary = $MPboundary. '--';
        $multipartbody = '';

        foreach ($params as $parameter => $value) {

            if( in_array($parameter, array('pic', 'image')) && $value{0} == '@' ) {
                $url = ltrim( $value, '@' );
                $content = file_get_contents( $url );
                $array = explode( '?', basename( $url ) );
                $filename = $array[0];

                $multipartbody .= $MPboundary . "\r\n";
                $multipartbody .= 'Content-Disposition: form-data; name="' . $parameter . '"; filename="' . $filename . '"'. "\r\n";
                $multipartbody .= "Content-Type: image/unknown\r\n\r\n";
                $multipartbody .= $content. "\r\n";
            } else {
                $multipartbody .= $MPboundary . "\r\n";
                $multipartbody .= 'content-disposition: form-data; name="' . $parameter . "\"\r\n\r\n";
                $multipartbody .= $value."\r\n";
            }

        }

        $multipartbody .= $endMPboundary;
        return $multipartbody;
    }
}
?>
