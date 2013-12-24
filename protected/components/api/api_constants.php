<?php
// 定义Social Type的Cache时间
define('CACHE_TIME_RSS',3600);
define('CACHE_TIME_INSTAGRAM',3600);
define('CACHE_TIME_PINTEREST',3600);
define('CACHE_TIME_FLICKR',3600);
define('CACHE_TIME_LINKEDIN',3600);
define('CACHE_TIME_REDDIT',3600);
define('CACHE_TIME_RENREN',3600);
define('CACHE_TIME_WEIBO',2400);
define('CACHE_TIME_QQ',1200);
define('CACHE_TIME_VIDEO56',3600);
define('CACHE_TIME_YOUKU',3600);

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


// 人人网 API 常量
define('RENREN_API_KEY','868d086072784f259a63c68f0e6feeb2');
define('RENREN_API_SECRET','dfae8da2263643dfa81c1efc70126105');
define('RENREN_REDIRECT_URI','http://'.$_SERVER['SERVER_NAME'].'/index.php/renren/authorize');
define('RENREN_AUTH_URI','https://graph.renren.com/oauth/authorize?client_id='.RENREN_API_KEY.'&redirect_uri='.RENREN_REDIRECT_URI.'&response_type=code&scope=read_user_feed,publish_comment,operate_like,publish_share,read_user_share');

// 新浪微博 API 常量
define('WEIBO_API_KEY','1542776171');
define('WEIBO_API_SECRET','4cdc5143a153750b582c7d2146c80f41');
define('WEIBO_REDIRECT_URI','http://'.$_SERVER['SERVER_NAME'].'/index.php/weibo/authorize');
define('WEIBO_AUTH_URI','https://api.weibo.com/oauth2/authorize?client_id='.WEIBO_API_KEY.'&response_type=code&redirect_uri='.WEIBO_REDIRECT_URI);

// 56视频 API 常量
define('VIDEO56_API_KEY','3000003388');
define('VIDEO56_API_SECRET','15cc456f2174008a');
define('VIDEO56_REDIRECT_URI','http://'.$_SERVER['SERVER_NAME'].'/index.php/video56/authorize');

?>