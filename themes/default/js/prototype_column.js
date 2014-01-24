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

	if(data.name == '已被删除帐号的列')
	{
		$('.holder_column_'+data.columnId).html('已被删除帐号的列，请删除！');
		return;
	}	

	// 如果视图类型是紧凑
	if(view_type == 1)
	{
		var short_feed_str = build_short_feed(data.columnId, data.name);
		$('#short-feed-title').find('.column_container').prepend(short_feed_str);
	}

	switch(socialType)
	{
		// Rss
		case 'rss':
			url = root_url+'/rss/parse';
		break;

		// Instagram
		case 'instagram':
			url = root_url+'/instagram/parse';
		break;

		// Pinterest
		case 'pinterest':
			url = root_url+'/pinterest/parse';
		break;

		// Flickr
		case 'flickr':
			url = root_url+'/flickr/parse';
		break;

		// Linkedin
		case 'linkedin':
			url = root_url+'/linkedin/parse';
		break;

		// Reddit
		case 'reddit':
			url = root_url+'/reddit/parse';
		break;

		// 人人网
		case 'renren':
			url = root_url+'/renren/parse';
		break;

		// 新浪微博
		case 'weibo':
			url = root_url+'/weibo/parse';
		break;

		// 56视频
		case 'video56':
			url = root_url+'/video56/parse';
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
	$('.holder_column_'+columnId).html("加载中，请稍后......");
	// 默认的post参数
	var data = {
		id : this.id,
		action : 'refresh'
	};

	switch(socialType)
	{
		// 刷新Rss
		case 'rss':
			url = root_url+'/rss/parse';			
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
			data['name'] = this.title;
			url = root_url+'/pinterest/parse';		
		break;

		// 刷新Flickr
		case 'flickr':
			// 判断当前是哪个是活动tab
			if($('.flickrTab.currentTabSelected').hasClass('recent'))	
				url = root_url+'/flickr/parse/tab/recent';
			else if($('.flickrTab.currentTabSelected').hasClass('interest'))
				url = root_url+'/flickr/parse/tab/interest';
			else if($('.flickrTab.currentTabSelected').hasClass('mypost'))
				url = root_url+'/flickr/parse/tab/mypost';
		break;

		// 刷新Linkedin
		case 'linkedin':
			// 判断当前是哪个是活动tab
			if($('.linkedinTab.currentTabSelected').hasClass('company'))	
				url = root_url+'/linkedin/parse/tab/company';
			else if($('.linkedinTab.currentTabSelected').hasClass('myupdate'))
				url = root_url+'/linkedin/parse/tab/myupdate';
		break;

		// 刷新Reddit
		case 'reddit':			
			// 判断当前是哪个是活动tab
			if($('.redditTab.currentTabSelected').hasClass('new'))	
				url = root_url+'/reddit/parse/tab/new';
			else if($('.redditTab.currentTabSelected').hasClass('hot'))
				url = root_url+'/reddit/parse/tab/hot';
			else if($('.redditTab.currentTabSelected').hasClass('controversial'))
				url = root_url+'/reddit/parse/tab/controversial';
			else if($('.redditTab.currentTabSelected').hasClass('saved'))
				url = root_url+'/reddit/parse/tab/saved';			
		break;

		// 刷新人人网数据
		case 'renren':
			// 判断当前是哪个是活动tab
			if($('.renrenTab.currentTabSelected').hasClass('recent'))	
				url = root_url+'/renren/parse/tab/recent';
			else if($('.renrenTab.currentTabSelected').hasClass('status'))
				url = root_url+'/renren/parse/tab/status';
			else if($('.renrenTab.currentTabSelected').hasClass('share'))
				url = root_url+'/renren/parse/tab/share';
		break;

		// 刷新新浪微博
		case 'weibo':
			// 判断当前是哪个是活动tab
			if($('.weiboTab.currentTabSelected').hasClass('home'))	
				url = root_url+'/weibo/parse/tab/home';
			else if($('.weiboTab.currentTabSelected').hasClass('user'))
				url = root_url+'/weibo/parse/tab/user';
			else if($('.weiboTab.currentTabSelected').hasClass('favorite'))
				url = root_url+'/weibo/parse/tab/favorite';
		break;

		// 刷新56视频
		case 'video56':
			url = root_url+'/video56/parse';
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
};

/**
 * 扩大一个列
 * @return {[type]} [description]
 */
socialColumnAccount.prototype.expand = function(){
	var default_width = 320;
	var new_expand_width = default_width*0.5;
	var that = this;

	// 判断当前宽度是否为默认宽度的2倍
	if(parseInt( $('#column_'+this.columnId).css('width') ) ==  default_width*2)
	{
		alert('列的宽度不能大于默认宽度的两倍');
		return;
	}

	$('#column_'+this.columnId).animate({
		width : '+='+new_expand_width
	}, 1000, function(){
		// 保存新的宽度到数据库，数据库保存的是 总宽度/默认宽度 .
		var size = parseInt( $('#column_'+that.columnId).css('width') )/default_width ;
		that.saveWidth(size);
	});
};

/**
 * 缩小一个列
 * @return {[type]} [description]
 */
socialColumnAccount.prototype.reduce = function(){
	var default_width = 320;
	var new_reduce_width = default_width*0.5;
	var that = this;

	// 判断当前宽度是否为默认宽度
	if(parseInt( $('#column_'+this.columnId).css('width') ) ==  default_width)
	{
		alert('列的宽度不能小于默认宽度');
		return;
	}

	$('#column_'+this.columnId).animate({
		width : '-='+new_reduce_width
	}, 1000, function(){
		// 保存新的宽度到数据库，数据库保存的是 总宽度/默认宽度 .
		var size = parseInt( $('#column_'+that.columnId).css('width') )/default_width ;
		that.saveWidth(size);
	});
};

/**
 * 保存列的width
 * @param  {[type]} size [description]
 * @return {[type]}      [description]
 */
socialColumnAccount.prototype.saveWidth = function(size){
	var data = {
		columnId : this.columnId,
		column_width_size : size
	};

	$.ajax({
	  	type : 'POST',
	  	data : data,
	  	url : root_url+'/userColumn/updWidth'
	});
}