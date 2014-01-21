<?php  
/**
* 所有的api 继承的父类
*/
class api_common 
{
    /**
     * boundary of multipart
     * @ignore
     */
    public $boundary = '';

    /**
     * 需要发送的headers
     */
    public $headers = array();

	public $api_key;
	public $api_secret;
	public $api_access_token;
    public $api_redirect_uri;
    public $code;

    // 返回的数据的数量
    public $limit = 20;

	/**
	 * 构造函数
	 * @param [type] $api_key    [description]
	 * @param [type] $api_secret [description]
	 */
	public function __construct($api_key,$api_secret)
	{
		$this->api_key = $api_key;
		$this->api_secret = $api_secret;
	}

	/**
	 * 使用curl的post方法
	 * @return [type]      [description]
	 */
	public function curl_post($url, $data, $curl_extra = array(), $multi = false)
	{   

      	$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:24.0) Gecko/20100101 Firefox/24.0'); 
        curl_setopt($ch, CURLOPT_POST,true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 200); 
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION , true);
        curl_setopt($ch, CURLOPT_MAXREDIRS      , 5);
        curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE );

        if($multi)
        {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers );
        }

        // 如果存在额外参数
        if(count($curl_extra) > 0)
        {
            foreach ($curl_extra as $key => $val) 
                curl_setopt($ch, $key, $val); 
        }

        // 执行
        if( ! $result  = curl_exec($ch) )
        {
            echo curl_error($ch);
            exit();
        }
        curl_close($ch);
        return $result;
	}

	/**
	 * 使用curl的get方法
	 * @return [type] [description]
	 */
	public function curl_get($url, $curl_extra = array())
	{
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:24.0) Gecko/20100101 Firefox/24.0'); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 200); 
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION , true);
        curl_setopt($ch, CURLOPT_MAXREDIRS      , 5);
        // 如果存在额外参数
        if(count($curl_extra) > 0)
        {
            foreach ($curl_extra as $key => $val) 
                curl_setopt($ch, $key, $val); 
        }

        if( ! $result  = curl_exec($ch) )
        {
           echo curl_error($ch);
           exit();
        }

        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if($http_status != 200 )
        {
            xz::dump($http_status);
            xz::dump($result);
            exit();
        }

        curl_close($ch);
        return $result;
	}
}
?>