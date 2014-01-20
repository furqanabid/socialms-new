// 发布数据的js
$(function(){
	// 点击显示人人的发布表单
	$('.post-renren').toggle(
		function(){
			var id = $(this).attr('data-id');
			$('.post-renren-'+id).slideDown();
			$(this).addClass('post-type-clicked');
		},
		function(){
			var id = $(this).attr('data-id');
			$('.post-renren-'+id).slideUp();
			$(this).removeClass('post-type-clicked');
		}
	)

	// 点击column里面的发布获取数据
	$(document).on('click', '.post-column', function(){
		var type = $(this).attr('data-type');
		var $parent = $(this).closest('.post-column-info');

		// 点击column里面的发布，我们就让所有的feed显示出来
		$('.post-body').find('.post-feed').removeClass('removed-post-feed');

		var title = $parent.find('.post-column-title').text().substr(0,29) || type;
		var link = $parent.find('.post-column-title').attr('href');
		var description = $parent.find('.post-column-description').text().substr(0,199);
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
		

		$('.post-renren-title').text(title);
		$('.post-renren-title').attr('href', link);
		$('.post-renren-description').text(description);
		$('.post-renren-image').attr('src', image);		
	})

	// 发布
	$('.publish-post').click(function(){
		var data = {};
		var error = '';

		if($('.post-type-clicked').length > 0)
		{
			$(this).closest('#post').find('.ajax_loader').show();
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
							data["socialPost["+i+"][title]"] = $.trim( $('.post-renren-'+id).find('.post-renren-title').text() );
							data["socialPost["+i+"][link]"] = $('.post-renren-'+id).find('.post-renren-title').attr('href');
							data["socialPost["+i+"][description]"] = $.trim( $('.post-renren-'+id).find('.post-renren-description').text() );
							data["socialPost["+i+"][image]"] = $('.post-renren-'+id).find('.post-renren-image').attr('src');
						}
						

						if(data["socialPost["+i+"][text]"] == '')
						{
							error = '请输入需要发送的人人状态...';
						}
					break;
				}
			});

			// 如果存在error,则执行error
			if(error)
			{
				alert(error);
				$(this).closest('#post').find('.ajax_loader').hide();
				return false;
			}

			var that = $(this);
			// 发送数据
			$.ajax({
				type : 'POST',
				url: root_url+"/social/publish", 
				dataType: "json",
				data: data,
			}).done(function(res){
				that.closest('#post').find('.ajax_loader').hide();
			})
		}
	})

	// 移除post-feed
	$('.remove-post-feed').click(function(){
		$(this).closest('.post-feed').addClass('removed-post-feed');
	})
})