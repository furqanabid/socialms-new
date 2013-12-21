<?php  
/**
* linkedin api的操作
*/
class api_linkedin extends api_common
{
	// api url
	private $api_host = 'https://api.linkedin.com/v1/people';
	// 用户认证码
	public $code;
	// 每页显示数
	public $count = 20;
	// 页数
	public $page;

	/**
	 * 用户认证授权
	 * @return [type] [description]
	 */
	public function authorize()
	{
		$params = array(
			'grant_type' => 'authorization_code',
			'code' => $this->code,
			'redirect_uri' => $this->api_redirect_uri,
			'client_id' => $this->api_key,
			'client_secret' => $this->api_secret
		);	

		$url = 'https://www.linkedin.com/uas/oauth2/accessToken?'.http_build_query($params);
        $res = $this->curl_get($url);
        $data = json_decode($res);

        $this->api_access_token = $data->access_token;

        // 获取用户的数据
        return $this->userInfo();
	}

	/**
	 * 获取用户的信息
	 * @return [type] [description]
	 */
	public function userInfo()
	{
		if(!isset($this->api_access_token))
			throw new Exception("Access Token不存在");
			
    	$url = $this->api_host."/~:(id,first-name,last-name)?format=json&oauth2_access_token=".$this->api_access_token;
        $res = $this->curl_get($url);
        $data = json_decode($res);
        $data->access_token = $this->api_access_token;
       
        return $data;
	}

	/**
	 * 分页每次显示20条公司的更新记录
	 * @param  [type] $start [description]
	 * @return [type]        [description]
	 */
	public function companyUpdate()
	{
		$params = array(
			'type' => 'CMPY',
			'count' => $this->count,
			'start' => $this->page*$this->count,
			'format' => 'json',
			'oauth2_access_token' => $this->api_access_token
		);

		$url = $this->api_host.'/~/network/updates:(timestamp,updateContent:(company,companyStatusUpdate,companyJobUpdate))?'.http_build_query($params);

		$res = $this->curl_get($url);

		return json_decode($res);
	}

	/**
	 * 分页每次显示20条我的的更新记录
	 * @param  [type] $start [description]
	 * @return [type]        [description]
	 */
	public function myUpdate()
	{
		$params = array(
			'count' => $this->count,
			'start' => $this->page*$this->count,
			'format' => 'json',
			'oauth2_access_token' => $this->api_access_token
		);

		$url = $this->api_host.'/~/network/updates?'.http_build_query($params);

		$res = $this->curl_get($url);
		return json_decode($res);
	}
}
?>
