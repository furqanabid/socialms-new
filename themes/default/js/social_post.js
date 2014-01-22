// 发布数据的js
$(function(){
	// 点击显示人人的发布表单
	toggle_post_account('renren');
	// 点击显示微博的发布表单
	toggle_post_account('weibo');



	// 点击column里面的发布获取数据
	$(document).on('click', '.post-column', function(){
		var type = $(this).attr('data-type');
		var $parent = $(this).closest('.post-column-info');

		// 点击column里面的发布，我们就让所有的feed显示出来
		$('.post-body').find('.post-feed').removeClass('removed-post-feed');

		var title = $.trim( $parent.find('.post-column-title').text() ).substr(0,29) || type;
		var link = $parent.find('.post-column-title').attr('href');
		var description = $.trim( $parent.find('.post-column-description').text() ).substr(0,199);
		var image;

		if(type == 'instagram')
		{
			image = $parent.find('.post-column-image').attr('src');
		}
		else if(type == 'weibo')
		{
			image = $parent.find('.post-column-image').attr('src') || $parent.find('img').attr('src');
		}
		else
		{
			image = $parent.find('img').attr('src') || root_img +'/image-holder.png';
		}
		

		$('.post-feed-title').text(title);
		$('.post-feed-title').attr('href', link);
		$('.post-feed-description').text(description);
		$('.post-feed-image').attr('src', image);		
	})

	// 发布
	$('.publish-post').click(function(){
		var data = {};
		var error = '';

		if($('.post-type-clicked').length > 0)
		{
			$(this).closest('#post').find('.publish-post-info').html("内容处理中，请稍后......").show();
			// 得到被选定的类型
			$('.post-type-clicked').each(function(i){
				var type = $(this).attr('data-type');
				var id = $(this).attr('data-id');

				data["socialPost["+i+"][type]"] = type;
				data["socialPost["+i+"][id]"] = id;

				// 根据不同的类型获得需要发布的数据
				switch(type)
				{
					// 人人网的数据
					case '7':
						data["socialPost["+i+"][text]"] = $.trim( $('.post-renren-'+id).find('.post-renren-text').val() );

						// 如果没有删除新鲜事表单
						if( !$('.post-renren-'+id).find('.post-feed').hasClass('removed-post-feed') )
						{
							data["socialPost["+i+"][title]"] = $.trim( $('.post-renren-'+id).find('.post-feed-title').text() );
							data["socialPost["+i+"][link]"] = $('.post-renren-'+id).find('.post-feed-title').attr('href');
							data["socialPost["+i+"][description]"] = $.trim( $('.post-renren-'+id).find('.post-feed-description').text() );
							data["socialPost["+i+"][image]"] = $('.post-renren-'+id).find('.post-feed-image').attr('src');
						}
						

						if(data["socialPost["+i+"][text]"] == '')
						{
							error = '请输入需要发送的人人网数据！';
						}
					break;

					// 新浪微博的数据
					case '8':
						data["socialPost["+i+"][text]"] = $.trim( $('.post-weibo-'+id).find('.post-weibo-text').val() );

						// 如果没有删除新鲜事表单
						if( !$('.post-weibo-'+id).find('.post-feed').hasClass('removed-post-feed') )
						{
							data["socialPost["+i+"][title]"] = $.trim( $('.post-weibo-'+id).find('.post-feed-title').text() );
							data["socialPost["+i+"][link]"] = $('.post-weibo-'+id).find('.post-feed-title').attr('href');
							data["socialPost["+i+"][description]"] = $.trim( $('.post-weibo-'+id).find('.post-feed-description').text() );
							data["socialPost["+i+"][image]"] = $('.post-weibo-'+id).find('.post-feed-image').attr('src');
						}

						if(data["socialPost["+i+"][text]"] == '')
						{
							error = '请输入需要发送的新浪微博数据！';
						}
					break;
				}
			});

			// 如果存在error,则执行error
			if(error)
			{
				alert(error);
				$(this).closest('#post').find('.publish-post-info').hide();
				return false;
			}

			var that = $(this);
			var errors = '';
			// 发送数据
			$.ajax({
				type : 'POST',
				url: root_url+"/social/publish", 
				dataType: "json",
				data: data,
			}).done(function(res){
				// 循环获得所有存在的错误
				for (var i in res) 
				{
					if(typeof res[i].error != 'undefined')
					{
						if(res[i].error.message)
						{
							errors += '人人网错误：'+res[i].error.message + '<br>';
						}
						else if(res[i].error)
						{
							errors += '新浪微博错误：'+res[i].error + '<br>';
						}
					}
				}	

				// 处理错误数据
				if(errors)
				{
					$('#post').find('.publish-post-info').html(errors).fadeIn( 400 ).delay( 3000 ).fadeOut( 400 );;
				}
				else
				{
					$('#post').find('.publish-post-info').html('内容发送成功！').fadeIn( 400 ).delay( 3000 ).fadeOut( 400 );

					// 发送成功，清除已经存在的数据
					clear_publish_data();
				}
			})
		}
	})

	// 移除post-feed
	$('.remove-post-feed').click(function(){
		$(this).closest('.post-feed').addClass('removed-post-feed');
	})

	// 清空发布表单的内容
	$('.clear_data').click(function(){
		if(confirm('您确定清空发布表单里面的内容吗？'))
		{
			clear_publish_data();
		}
	})
})


/**
 * 点击需要发布信息的帐号函数
 * @param  {[type]} socialType [类似于renren,weibo等]
 * @return {[type]}            [description]
 */
function toggle_post_account(socialType)
{
	$('.post-'+socialType).toggle(
		function(){
			var id = $(this).attr('data-id');
			$('.post-'+socialType+'-'+id).slideDown();
			$(this).addClass('post-type-clicked');
		},
		function(){
			var id = $(this).attr('data-id');
			$('.post-'+socialType+'-'+id).slideUp();
			$(this).removeClass('post-type-clicked');
		}
	)
}

/**
 * 清空已经存在publish表单的数据
 * @return {[type]} [description]
 */
function clear_publish_data()
{
	$('.post-text').val('');
	$('.post-feed-title').html('新鲜事标题');
	$('.post-feed-description').html('新鲜事内容');
	$('.post-feed-image').attr('src', root_img+'/image-holder.png');
}