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

// LINKEDIN API 常量
define('LINKEDIN_API_KEY','77q9yllqqv8l1q');
define('LINKEDIN_API_SECRET','HCAsVHqZ826jngX8');
define('LINKEDIN_REDIRECT_URI','http://'.$_SERVER['SERVER_NAME'].'/index.php/linkedin/authorize');
define('LINKEDIN_AUTH_URI','https://www.linkedin.com/uas/oauth2/authorization?response_type=code&client_id='.LINKEDIN_API_KEY.'&state='.uniqid().'&redirect_uri='.LINKEDIN_REDIRECT_URI);

// REDDIT API 常量
define('REDDIT_API_KEY','ZER_QVDnsUFplQ');
define('REDDIT_API_SECRET','VQ6fZMFHr6ec1TYOOAZb15gcSrw');
define('REDDIT_REDIRECT_URI','http://'.$_SERVER['SERVER_NAME'].'/index.php/reddit/authorize');
define('REDDIT_AUTH_URI','https://ssl.reddit.com/api/v1/authorize?response_type=code&client_id='.REDDIT_API_KEY.'&redirect_uri='.REDDIT_REDIRECT_URI.'&scope=identity,save,submit,vote,history,read&state='.uniqid().'&duration=permanent');




?>