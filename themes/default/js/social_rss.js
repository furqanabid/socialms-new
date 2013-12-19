$(function(){
	// rss菜单点击类别获得它下面的rss
	$('#rss_category_drop_down').change(function(){
		var id = $(this).val();
		if(id == -1)
		{
			alert('请选择一个Rss分类');
			return;
		}
		$('.rss_ajax_loader').show();
		var that = $(this);

		$.when(
			// 获取此分类下面用户添加的rss
			$.ajax({
				type : 'POST',
				data : {id : id},
				dataType : 'html',
				url :  social_module_link+'/rss/getUserRssFeeds'
			}),
			// 获取推荐的rss
			$.ajax({
				type : 'POST',
				data : {id : id},
				dataType : 'html',
				url :  social_module_link+'/rss/getRssFeeds'
			})
		).done(function(a1,a2){
			// 分类下面用户返回数据处理
			$('.rss_feeds_drop_down_div').html(a1[0]);

			// 获取推荐的rss的返回数据处理
			$('.rss_recommend_wrap').show();
			$('.rss_recommend_content').html(a2[0]);
			
			$('.rss_ajax_loader').hide();
		});
	});


	// 点击rss，生成column
	$(document).on('click','.rss_add_to_column',function(){
		if($(this).attr('data-type') == 'from_select')
		{
			var rssId = $('#rss_feeds_drop_down').val();
			var data = {
				rss_master_id : $('.rss_master_id_'+rssId).val(),
				rss_name : $('#rss_feeds_drop_down option:selected').text(),
			};
		}
		else
		{
			var data = {
				rss_master_id : $(this).closest('.rss_feed_wrap').find('.feed_rss_masterid').val(),
				rss_name : $(this).text(),
			};
		}
		

		$('.rss_ajax_loader').show();
		$.ajax({
			type : 'POST',
			data : data,
			async : 'false',
			url :  social_module_link+'/rss/addColumn',
		}).done(function(result){
			if(parseInt(result))
			{
				var columnId = parseInt(result);
				// 添加列
				addNewColumnToPage(columnId, 'rss', data.rss_master_id, data.rss_name);
				$('.rss_ajax_loader').hide();
			}
		});	
	});

	// 添加新rss的输入区域
	$('.rss_feed_new').click(function(){
		var categoryId = $('#rss_category_drop_down').val();
		if(categoryId == -1)
		{
			alert('请先选择一个Rss分类，然后添加新的rss到此分类中！');
			return;
		}
		$('.rss_user_add_div').toggle();
	})

	// 提交添加新rss表单
	$('.rss_feed_submit').click(function(){
		var categoryId = $('#rss_category_drop_down').val();
		var rssName = $.trim($('.rss_feed_name').val());
		var rssUrl = $.trim($('.rss_feed_url').val());

		if(rssName == '' || rssUrl == '')
		{
			alert('请输入正确的rss地址和名字！');
			return;
		}
		var data = {
			categoryId : categoryId,
			rssName : rssName,
			rssUrl : rssUrl
		}

		$('.rss_ajax_loader').show();
		$.ajax({
			type : 'post',
			data : data,
			dataType : 'json',
			url : social_module_link+'/rss/addNewRss'
		}).done(function(result){
			if(result.success == true)
			{
				var str = "<option selected='selected' value='"+result.data.id+"'>"+result.data.name+"</option>";
				var	hiddenString ="<input type='hidden' class='rss_master_id_"+result.data.id+"' value='"+result.data.rss_master_id+"' />";

				$('#rss_feeds_drop_down').append(str);
				$('.rss_feeds_drop_down_div').append(hiddenString);
				$('.rss_user_add_div').hide();
				$('.rss_ajax_loader').hide();

			}
			else
				alert(result.msg);
		});
	})

	// 用户删除自己分类里面的rss feed
	$('.rss_feed_del').click(function(){
		var rssId = $('#rss_feeds_drop_down').val();

		if(rssId == '-1')
		{
			alert('请选择一个您需要删除的rss');
			return;
		}

		if(!confirm('您真的要删除这个Rss吗？'))
		    return;

		$('.rss_ajax_loader').show();
		$.ajax({
			type : 'post',
			data : {id : rssId},
			url : social_module_link+'/rss/delRss'
		}).done(function(result){
			if(result == 1)
			{	
				$('#rss_feeds_drop_down option:selected').remove();
				$('.rss_ajax_loader').hide();

				// 删除已经存在的Column
				var rss_master_id = $('.rss_master_id_'+rssId).val();
				var sectionId = $('.rss_'+rss_master_id).attr('id') || '';
				if(sectionId != '')
				{
					var columnId = sectionId.replace('column_','');
					$('.delete_column_'+columnId).trigger('click', [true]);
				}
			}
		});
	})

});




