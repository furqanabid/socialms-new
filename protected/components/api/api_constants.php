<?php
// 定义Social Type的Cache时间
define('CACHE_TIME_RSS',7200);
define('CACHE_TIME_INSTAGRAM',7200);
define('CACHE_TIME_PINTEREST',7200);
define('CACHE_TIME_FLICKR',7200);
define('CACHE_TIME_LINKEDIN',7200);
define('CACHE_TIME_REDDIT',7200);
define('CACHE_TIME_RENREN',7200);
define('CACHE_TIME_WEIBO',2400);
define('CACHE_TIME_QQ',1200);
define('CACHE_TIME_VIDEO56',7200);
define('CACHE_TIME_YOUKU',7200);

// Instagram API 常量
define('INSTAGRAM_API_KEY','3bd4a779086f467da618c95fe4e54cb7');
define('INSTAGRAM_API_SECRET','b3589f1b833445ba927058e3de9f8dd8');
define('INSTAGRAM_REDIRECT_URI','http://'.$_SERVER['SERVER_NAME'].'/index.php/instagram/authorize');
define('INSTAGRAM_AUTH_URI','https://api.instagram.com/oauth/authorize/?client_id='.INSTAGRAM_API_KEY.'&redirect_uri='.INSTAGRAM_REDIRECT_URI.'&response_type=code&scope=basic+comments+relationships+likes');

// FLICKR API 常量
define('FLICKR_API_KEY','a51b5e20c6dba771d18c62036f466360');
define('FLICKR_API_SECRET','dc7f29a36850e797');
define('FLICKR_REDIRECT_URI','http://'.$_SERVER['SERVER_NAME'].'/index.php/flickr/authorize');
define('FLICKR_AUTH_URI','http://flickr.com/services/auth/?api_key='.FLICKR_API_KEY.'&perms=delete&api_sig='.md5(FLICKR_API_SECRET.'api_key'.FLICKR_API_KEY.'permsdelete'));


?>