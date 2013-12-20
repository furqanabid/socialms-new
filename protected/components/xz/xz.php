<?php  
/**
 * 这个类里面全部定义静态方法，用来定义一些常在应用里面使用的方法
 */
class xz
{
	public static function dump($str,$strLen = false)
	{
		if($strLen)
		{
			echo '<pre>';
			var_dump($str);
			echo '</pre>';
		}
		else
		{	
			echo '<pre>';
			print_r($str);
			echo '</pre>';
		}
		
	}


	/**
	 * 字符串截取，支持中文和其他编码
	 * @static
	 * @access public
	 * @param string $str 需要转换的字符串
	 * @param string $start 开始位置
	 * @param string $length 截取长度
	 * @param string $charset 编码格式
	 * @param string $suffix 截断显示字符
	 * @return string
	 */
	public static function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true)
	{
	    if(function_exists("mb_substr"))
	        return mb_substr($str, $start, $length, $charset);
	    elseif(function_exists('iconv_substr')) {
	        return iconv_substr($str,$start,$length,$charset);
	    }
	    $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
	    $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
	    $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
	    $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
	    preg_match_all($re[$charset], $str, $match);
	    $slice = join("",array_slice($match[0], $start, $length));
	    if($suffix) return $slice."…";
	    return $slice;
	}


	/**
	 * Get either a Gravatar URL or complete image tag for a specified email address.
	 *
	 * @param string $email The email address
	 * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
	 * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
	 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
	 * @param boole $img True to return a complete IMG tag False for just the URL
	 * @param array $atts Optional, additional key/value attributes to include in the IMG tag
	 * @return String containing either just a URL or a complete image tag
	 * @source http://gravatar.com/site/implement/images/php/
	 */
	public static function get_gravatar( $email, $s = 48, $d = 'monsterid', $r = 'g', $img = false, $atts = array() ) {
	    $url = 'http://www.gravatar.com/avatar/';
	    $url .= md5( strtolower( trim( $email ) ) );
	    $url .= "?s=$s&d=$d&r=$r";
	    if ( $img ) 
	    {
	        $url = '<img src="' . $url . '"';
	        foreach ( $atts as $key => $val )
	            $url .= ' ' . $key . '="' . $val . '"';
	        $url .= ' />';
	    }
	    return $url;
	}

	/**
	 * 格式化时间，如果在一天内，w我们可以显示x分钟之前或x小时之前，否则就直接显示日期
	 * @return [type] [description]
	 */
	public static function format_time($timestamp)
	{	
		$current_timestamp = time();
		$timeCalc = $current_timestamp - $timestamp;
		if($timeCalc < 60*60)
			return round($timeCalc/60)." 分钟前";
		else if($timeCalc < 3600*24)
			return round($timeCalc/3600)." 小时前";
		else
			return date('Y-m-d H:i:s',$timestamp);

	}

	/**
	 * 将一些数据格式化成json类型
	 * @return [type] [description]
	 */
	public static function outputJson($arr)
	{
		header('Content-type : application/json');
		echo CJavaScript::jsonEncode($arr);
		Yii::app()->end();
	}
}
?>