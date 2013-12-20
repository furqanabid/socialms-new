<?php 
// ==================================================================
//
// 使用simplexml来解析Rss Feed
//
// ------------------------------------------------------------------
class parseRss extends CApplicationComponent
{
	private $_rss;
	private $_sources;
	private $_data = array();


	/**
	 * 加载rss
	 */
	public function load($rss)
	{
		$this->_rss = $rss;

		$this->formatRss();
		$this->sources();

		return $this;
	}

	/**
	 * 格式化rss
	 * @return [type] [description]
	 */
	private function formatRss()
	{
		if(strpos($this->_rss, 'http') === false)
			$this->_rss = 'http://'.$this->_rss;
	}	

	/**
	 * 获取指定rss的源码
	 * @param  [type] $rss [description]
	 * @return [type]      [description]
	 */
	private function sources()
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->_rss);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:24.0) Gecko/20100101 Firefox/24.0'); 
		curl_setopt($ch, CURLOPT_ENCODING , 'gzip' );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); 
      	curl_setopt($ch, CURLOPT_TIMEOUT, 100); 
      	curl_setopt($ch, CURLOPT_FOLLOWLOCATION , true);
     	curl_setopt($ch, CURLOPT_MAXREDIRS      , 5);

     	$this->_sources  = curl_exec($ch);
	}

	/**
	 * 解析获得的xml源码
	 * @return [type] [description]
	 */
	public function parse()
	{
		$xml = new SimpleXMLElement($this->_sources);
		foreach ($xml->channel->children() as $key=>$val) 
		{
			if($key != 'item')
				$this->_data[$key] = $val->__toString();
			else
				$this->_data['items'][] = $val;
		}

		return $this->_data;
	}

	/**
	 * 验证一个rss是否可以被解析
	 * @return [type] [description]
	 */
	public function validate()
	{
		$xml = @simplexml_load_string($this->_sources);
		if($xml)
			return $xml->channel->title->__toString();

		return $xml;
	}
}
?>