/**
 * 
 * 这是一个基类函数
 * 里面完成了column的显示，刷新，删除功能
 * 
 */
var socialColumnAccount = function(columnId,socialType,title){
	 this.columnId = columnId;
	 this.socialType = socialType;
	 this.title = title;
}

/**
 * 显示column里面的内容
 * @return {[type]} [description]
 */
socialColumnAccount.prototype.display = function() {
	var socialType = this.socialType;
	var data = {
		id : this.id,
		columnId : this.columnId,
		name : this.title,
	};
	var url;

	switch(socialType)
	{
		// Rss
		case 'rss':
			data['rss_master_id'] = this.id;
			url = root_url+'/rss/parseRss';
		break;

		// Instagram
		case 'instagram':
			url = root_url+'/instagram/parse';
		break;

		// Pinterest
		case 'pinterest':
			url = root_url+'/pinterest/parsePinterest';
		break;

		// Flickr
		case 'flickr':
			url = root_url+'/flickr/recent';
		break;

		// Linkedin
		case 'linkedin':
			url = root_url+'/linkedin/parseLinkedin';
		break;

		// Reddit
		case 'reddit':
			url = root_url+'/reddit/parseNew';
		break;

		// 人人网
		case 'renren':
			url = root_url+'/renren/home';
		break;

		// 新浪微博
		case 'weibo':
			url = root_url+'/weibo/home';
		break;

		// 56视频
		case 'video56':
			url = root_url+'/video56/video';
		break;

		// 优酷视频
		case 'youku':
			url = root_url+'/youku/index?type=category';
		break;
	}

	// 发送数据
	$.ajax({
		type : 'POST',
		data : data,
		dataType : 'html',
		url : url
	}).done(function(result){
		$('.holder_column_'+data.columnId).html(result);
	})	
};


/**
 * 刷新一个column
 * @return {[type]} [description]
 */
socialColumnAccount.prototype.refresh = function() {
	var columnId = this.columnId;
	var url;
	var socialType = this.socialType;
	$('.holder_column_'+columnId).html("<img src='"+root_img+"/ajax-loader.gif' />");
	// 默认的post参数
	var data = {
		id : this.id,
		action : 'refresh'
	};

	switch(socialType)
	{
		// 刷新Rss
		case 'rss':
			var data = {
				rss_url : this.rss_url,
				rss_master_id : this.rss_master_id,
				columnId : this.columnId
			};
			url = root_url+'/rss/refreshColumn';			
		break;

		// 刷新Instagram
		case 'instagram':
			// 判断当前是哪个是活动tab
			if($('.instagramTab.currentTabSelected').hasClass('recent'))	
				url = root_url+'/instagram/parse/tab/recent';				
			else if($('.instagramTab.currentTabSelected').hasClass('popular'))
				url = root_url+'/instagram/parse/tab/popular';
			else if($('.instagramTab.currentTabSelected').hasClass('mypost'))
				url = root_url+'/instagram/parse/tab/mypost';			
		break;

		// 刷新Pinterest
		case 'pinterest':
			var data = {
				id : this.id,
				name : this.title,
				columnId : this.columnId
			};
			url = root_url+'/pinterest/refreshColumn';		
		break;

		// 刷新Flickr
		case 'flickr':
			// 判断当前是哪个是活动tab
			if($('.flickrTab.currentTabSelected').hasClass('flickr_most_recent'))	
				url = root_url+'/flickr/recent';
			else if($('.flickrTab.currentTabSelected').hasClass('flickr_most_interestingness'))
				url = root_url+'/flickr/getInterestingness';
			else if($('.flickrTab.currentTabSelected').hasClass('flickr_my_post'))
				url = root_url+'/flickr/getMyPost';
		break;

		// 刷新Linkedin
		case 'linkedin':
			// 判断当前是哪个是活动tab
			if($('.linkedinTab.currentTabSelected').hasClass('linkedin_company_update'))	
				url = root_url+'/linkedin/parseLinkedin';
			else if($('.linkedinTab.currentTabSelected').hasClass('linkedin_my_update'))
				url = root_url+'/linkedin/myUpdates';
		break;

		// 刷新Reddit
		case 'reddit':			
			// 判断当前是哪个是活动tab
			if($('.redditTab.currentTabSelected').hasClass('reddit_new'))	
				url = root_url+'/reddit/parseNew';
			else if($('.redditTab.currentTabSelected').hasClass('reddit_hot'))
				url = root_url+'/reddit/parseHot';
			else if($('.redditTab.currentTabSelected').hasClass('reddit_controversial'))
				url = root_url+'/reddit/parseControversial';
			else if($('.redditTab.currentTabSelected').hasClass('reddit_saved'))
				url = root_url+'/reddit/parseSaved';			
		break;

		// 刷新人人网数据
		case 'renren':
			// 判断当前是哪个是活动tab
			if($('.renrenTab.currentTabSelected').hasClass('renren_home'))	
				url = root_url+'/renren/home';
			else if($('.renrenTab.currentTabSelected').hasClass('renren_status'))
				url = root_url+'/renren/status';
			else if($('.renrenTab.currentTabSelected').hasClass('renren_share'))
				url = root_url+'/renren/share';
		break;

		// 刷新新浪微博
		case 'weibo':
			// 判断当前是哪个是活动tab
			if($('.weiboTab.currentTabSelected').hasClass('weibo_home_timeline'))	
				url = root_url+'/weibo/home';
			else if($('.weiboTab.currentTabSelected').hasClass('weibo_user_timeline'))
				url = root_url+'/weibo/user';
			else if($('.weiboTab.currentTabSelected').hasClass('weibo_favorites'))
				url = root_url+'/weibo/favorites';
		break;

		// 刷新56视频
		case 'video56':
			url = root_url+'/video56/video';
		break;

		// 刷新优酷视频
		case 'youku':
			// 判断当前是哪个是活动tab
			if($('.youkuTab.currentTabSelected').hasClass('youku_favorite'))	
				url = root_url+'/youku/index?type=favorite';
			else if($('.youkuTab.currentTabSelected').hasClass('youku_category'))
				url = root_url+'/youku/index?type=category';
			else if($('.youkuTab.currentTabSelected').hasClass('youku_show'))
				url = root_url+'/youku/index?type=show';
		break;
	}

	// 发送数据
	$.ajax({
		type : 'POST',
		data : data,
		dataType : 'html',
		url : url
	}).done(function(result){
		$('.holder_column_'+columnId).html(result);
	})	
};


/**
 * 删除一个column
 * @return {[type]} [description]
 */
socialColumnAccount.prototype.delete = function(noComfirm) {
	var columnId = this.columnId;
	var socialType = this.socialType;
	var title = $.trim(this.title);

	// 有时候触发delete事件我们不想要confirm.
	// 只有当noConfirm为空的时候，我们才会执行confirm
	var noComfirm = noComfirm || '';
	if(noComfirm == '')
	{
		if(!confirm('您真的想删除 '+title+' 吗？'))
			return;
	}	

    // 删除column
    $('#column_'+columnId).remove();

    // 删除数据库的数据
	var data = {
		column_id : columnId,
	};
	$.ajax({
	  	type : 'POST',
	  	data : data,
	  	url : root_url+'/userColumn/del'
	});
}