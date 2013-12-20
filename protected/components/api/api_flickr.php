<?php  
/**
* Flickr的API处理类
*/
class api_flickr extends api_common
{
    // API的路径
    public $api_host = "http://api.flickr.com/services/rest";
    // 保存参数
    public $flick_params;
    // 用户在flickr里面的id
    public $flickr_uid;
    // 默认的显示数目
    public $count = 20;
    // 用户认证返回的数据
    public $frob;
    // 页数
    public $page = 1;
    // 图片的id
    public $flickr_photoid;
    // 留言的内容
    public $flickr_comment;

    /**
     * 认证用户
     * @return [type] [description]
     */
    public function authorize()
    {
        $params = array(
            'api_key' => $this->api_key,
            'frob' => $this->frob,
            'method' => 'flickr.auth.getToken',
            'format' => 'json',
            'nojsoncallback' => 1
        );

        // 返回数据
        return $this->exec($params);        
    }

    /**
     * 调用flickr的 [flickr.photos.getContactsPhotos] API
     * @return [type] [description]
     */
    public function getRecent()
    {
        $params = array(
            'method' => 'flickr.photos.getContactsPhotos',
            'api_key' => $this->api_key,
            'count' => $this->count,
            'page' => $this->page,
            'format' => 'json',
            'nojsoncallback' => 1,
            'auth_token' => $this->api_access_token
        );  
     
        // 返回数据
        return $this->exec($params);
    }

    /**
     * 调用flickr的[flickr.interestingness.getList]API
     * @return [type] [description]
     */
    public function getInterest()
    {      
        $params = array(
            'method' => 'flickr.interestingness.getList',
            'api_key' => $this->api_key,
            'per_page' => $this->count,
            'page' => $this->page,
            'format' => 'json',
            'nojsoncallback' => 1,
            'auth_token' => $this->api_access_token
        );  

        // 返回数据
        return $this->exec($params);
    }

    /**
     * 调用flickr的[flickr.people.getPhotos]API
     * @param  [type] $userid [用户在flickr的ID]
     * @param  [type] $page   [第几页的数据]
     * @return [type]         [description]
     */
    public function getMypost()
    {
        $params = array(
            'method' => 'flickr.people.getPhotos',
            'api_key' => $this->api_key,
            'per_page' => $this->count,
            'page' => $this->page,
            'format' => 'json',
            'nojsoncallback' => 1,
            'auth_token' => $this->api_access_token
        );  

        // 返回数据
        return $this->exec($params);
    }

    /**
     * 发送comment到flickr
     * @param  [type] $comment [内容]
     * @param  [type] $photoid [图片id]
     * @return [type]          [description]
     */
    public function comment()
    {
        $this->flickr_comment = str_replace(' ', '+', $this->flickr_comment);

        $params = array(
            'method' => 'flickr.photos.comments.addComment',
            'api_key' => $this->api_key,
            'comment_text' => $this->flickr_comment,
            'photo_id' => $this->flickr_photoid,
            'format' => 'json',
            'nojsoncallback' => 1,
            'auth_token' => $this->api_access_token
        );  

        // 返回数据
        return $this->exec($params);
    }

    /**
     * like到flickr
     * @param  [type] $photoid [图片ID]
     * @return [type]          [description]
     */
    public function like()
    {
        $params = array(
            'method' => 'flickr.favorites.add',
            'api_key' => $this->api_key,
            'photo_id' => $this->flickr_photoid,
            'format' => 'json',
            'nojsoncallback' => 1,
            'auth_token' => $this->api_access_token
        );  

        // 返回数据
        return $this->exec($params);      
    }

    /**
     * 执行获取数据
     * @return [type] [description]
     */
    private function exec($params)
    {
        // 获取签名
        $sig = $this->signRequest($params);
        // api 路径
        $url = $this->api_host."/?".$this->flick_params."&api_sig=".$sig;
        // 获取数据
        $res = $this->curl_get($url);

        return json_decode($res);
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

        // 按键排序
        ksort($params);
        // 保存参数
        $this->flick_params = http_build_query($params);
        // 因为flickr_uid里面的 @ 会被http_build_query转化，所以我们需要单独加进去
        if(isset($this->flickr_uid))
        {
            $this->flick_params .='&user_id='.$this->flickr_uid;
        }
        
        // 移除字符串里面的 = 和 &
        $md5_str = $this->api_secret.str_replace(array('=','&'), '', $this->flick_params);

        return md5($md5_str);
    }
}
?>