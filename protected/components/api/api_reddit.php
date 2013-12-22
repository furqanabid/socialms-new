<?php  
/**
* reddit api的处理类
*/
class api_reddit extends api_common
{
	// api url
	private $api_host = 'https://oauth.reddit.com';
	// 刷新token
	public $api_refresh_token;
	// 用户认证的code
	public $code;
	// 每页显示数
	public $count = 20;
	// 用户在reddit的用户名
	public $reddit_username;
	// reddit的下一个ID
	public $reddit_after;
	// reddit modhash
	public $modhash;
	// reddit media id
	public $media_id;
	// 留言内容
	public $comment_text;

	/**
	 * 用户认证授权
	 * @return [type] [description]
	 */
	public function authorize()
	{
		// 认证的路径
		$url = "https://ssl.reddit.com/api/v1/access_token";
		$postData = array(
			'code' => $this->code, 
			'redirect_uri' => $this->api_redirect_uri,
			'client_id' => $this->api_key, 
			'grant_type' => 'authorization_code',
		);

		// reddit需要额外的auth 认证
		$auth_value = 'Basic ' . base64_encode($this->api_key .  ':' . $this->api_secret);
		$curl_extra = array(
			CURLOPT_HTTPHEADER => array("Authorization: ".$auth_value),
		);

		$res = $this->curl_post($url, $postData, $curl_extra);
		$data = json_decode($res);
		$this->api_access_token = $data->access_token;
		$this->api_refresh_token = $data->refresh_token;

		return $this->userInfo();
	}

	/**
	 * [getNewToken description]
	 * @param  [type] $refresh_token [需要的refresh token]
	 * @param  [type] $redirectUrl   [跳转路径]
	 * @return [type]                [description]
	 */
	public function newToken()
	{
		$url = "https://ssl.reddit.com/api/v1/access_token";
		$postData = array(
			'redirect_uri' => $this->api_redirect_uri,
			'client_id' => $this->api_key, 
			'grant_type' => 'refresh_token',
			'refresh_token' => $this->api_refresh_token
		);

		// reddit需要额外的auth 认证
		$auth_value = 'Basic ' . base64_encode($this->api_key .  ':' . $this->api_secret);
		$curl_extra = array(
			CURLOPT_HTTPHEADER => array("Authorization: ".$auth_value),
		);
		$res = $this->curl_post($url, $postData, $curl_extra);
		return json_decode($res);
	}


	/**
	 * 获取用户的信息
	 * @return [type] [description]
	 */
	public function userInfo()
	{
		// 获取用户的信息
		$url = $this->api_host."/api/v1/me";
		// 执行
		$data = $this->exec($url);
		// 返回的数据加上token参数
		$data->access_token = $this->api_access_token;
		$data->refresh_token = $this->api_refresh_token;

		return $data;
	}


	/**
	 * 获取reddit最新新闻
	 * @param  [type] $after [description]
	 * @return [type]        [description]
	 */
	public function getNew()
	{
		if(empty($this->reddit_after))
			$url = $this->api_host."/new?limit=".$this->count;
		else
			$url = $this->api_host."/new?limit=".$this->count.'&after='.$this->reddit_after;

		// 执行
		return $this->exec($url);
	}

	/**
	 * 获取reddit最热新闻
	 * @param  [type] $after [description]
	 * @return [type]        [description]
	 */
	public function getHot()
	{
		if(empty($this->reddit_after))
			$url = $this->api_host."/hot?limit=".$this->count;
		else
			$url = $this->api_host."/hot?limit=".$this->count.'&after='.$this->reddit_after;

		// 执行
		return $this->exec($url);
	}

	/**
	 * 获取reddit热议新闻
	 * @param  [type] $after [description]
	 * @return [type]        [description]
	 */
	public function getControversial()
	{
		if(empty($this->reddit_after))
			$url = $this->api_host."/controversial?limit=".$this->count;
		else
			$url = $this->api_host."/controversial?limit=".$this->count.'&after='.$this->reddit_after;

		// 执行
		return $this->exec($url);
	}

	/**
	 * 获取reddit用户已经saved的新闻
	 * @param  [type] $after [description]
	 * @return [type]        [description]
	 */
	public function getSaved()
	{
		if(empty($this->reddit_after))
			$url = $this->api_host."/user/".$this->reddit_username."/saved?limit=".$this->count;
		else
			$url = $this->api_host."/user/".$this->reddit_username."/saved?limit=".$this->count.'&after='.$this->reddit_after;

		// 执行
		return $this->exec($url);
	}

	/**
	 * 保存一个新闻
	 * @return [type] [description]
	 */
	public function saved()
	{
		// 需要post的数据
		$postData = array(
			'id' => $this->media_id,
			'modhash' => $this->modhash
		);
		$url = $this->api_host."/api/save";

		return $this->exec($url, $postData);
	}

	/**
	 * vote一个新闻
	 * @return [type] [description]
	 */
	public function vote()
	{
		// 需要post的数据
		$postData = array(
			'id' => $this->media_id,
			'uh' => $this->modhash,
			'dir' => 1
		);
		$url = $this->api_host."/api/vote";

		return $this->exec($url, $postData);
	}

	/**
	 * comment一个新闻
	 * @return [type] [description]
	 */
	public function comment()
	{
		// 需要post的数据
		$postData = array(
			'api_type' => 'json',
           	'text' => $this->comment_text,
           	'thing_id' => $this->media_id,
           	'uh' => $this->modhash
		);

		$url = $this->api_host."/api/comment";

		return $this->exec($url, $postData);
	}

	/**
	 * 执行api
	 * @return [type] [description]
	 */
	public function exec($url, $data=array())
	{
		// reddit需要额外的auth 认证
		$curl_extra = array(
			CURLOPT_HTTPHEADER => array("Authorization: bearer ".$this->api_access_token),
		);

		if( count($data) > 0 )
			$res = $this->curl_post($url, $data, $curl_extra);
		else
			$res = $this->curl_get($url, $curl_extra);

		return json_decode($res);
	}
}
?>
