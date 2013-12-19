<?php  
/**
* Instagram API处理类
*/
class api_instagram extends api_common
{
	// api url
	private $api_host = 'https://api.instagram.com/v1';

	/**
	 * 用户授权
	 * @param  [type] $code        [description]
	 * @param  [type] $redirectUrl [description]
	 * @return [type]              [description]
	 */
	public function authorize()
	{
		$url = "https://api.instagram.com/oauth/access_token";
        $data = array(
	       'client_id'       =>     $this->api_key,
	       'client_secret'   =>     $this->api_secret,
	       'grant_type'      =>     'authorization_code',
	       'redirect_uri'    =>     $this->api_redirect_uri,
	       'code'            =>     $this->code
        );

        $res = $this->curl_post($url, $data);
        return json_decode($res);
	}

	/**
	 * 获取用户当前的数据
	 * @return [type] [description]
	 */
	public function getRecent()
	{
		$url = $this->api_host."/users/self/feed?access_token=".$this->api_access_token;
		$res = $this->curl_get($url);	
		return  json_decode($res);
	}

	/**
	 * 获取当前popular的数据
	 * @return [type] [description]
	 */
	public function getPopular($access_token)
	{
		$url = $this->api_host."/media/popular?access_token=".$access_token;
		$res = $this->curl_get($url);		
		return  json_decode($res,true);
	}

	/**
	 * 获取用户的发布照片
	 * @param  [type] $userid       [description]
	 * @param  [type] $access_token [description]
	 * @return [type]               [description]
	 */
	public function getMypost($userid,$access_token)
	{
		$url = $this->api_host."/users/".$userid."/media/recent/?access_token=".$access_token;
		$res = $this->curl_get($url);		
		return  json_decode($res,true);
	}

	/**
	 * 发布一个评论
	 * @return [type] [description]
	 */
	public function postComment($text,$access_token,$media_id)
	{
		$postData = array(
			'text' => $text,
			'access_token' => $access_token
		);
		$url = $this->api_host."/media/".$media_id."/comments";

		$res = $this->curl_post($url, $postData);
		return  json_decode($res);
	}

	/**
	 * like一张图片
	 * @param  [type] $media_id [description]
	 * @return [type]           [description]
	 */
	public function postLike($media_id,$access_token)
	{
		$url = $this->api_host."/media/".$media_id."/likes";
		$postData = array(
			'access_token' => $access_token
		);

		$res = $this->curl_post($url, $postData);
		return  json_decode($res);
	}

	/**
	 * unfollow一个用户
	 * @return [type] [description]
	 */
	public function unfollow($userid,$access_token)
	{
		$url = $this->api_host."/users/".$userid."/relationship?access_token=".$access_token;
		$postData = array(
			'action' => 'unfollow'
		);

		$res = $this->curl_post($url, $postData);
		return  json_decode($res);
	}
}
?>