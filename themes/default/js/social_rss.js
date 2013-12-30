$(function(){
	// rss菜单点击类别获得它下面的rss
	$('#rss_category_drop_down').change(function(){
		var id = $(this).val();
		if(id == -1)
		{
			alert('请选择一个Rss分类');
			return;
		}

		var that = $(this);
		that.closest('.tab-pane').find('.ajax_loader').show();

		$.when(
			// 获取此分类下面用户添加的rss
			$.ajax({
				type : 'POST',
				data : {category_id : id},
				dataType : 'html',
				url :  root_url+'/rss/userRss'
			}),
			// 获取推荐的rss
			$.ajax({
				type : 'POST',
				data : {category_id : id},
				dataType : 'html',
				url :  root_url+'/rss/recommendRss'
			})
		).done(function(a1,a2){
			// 分类下面用户返回数据处理
			$('.rss_feeds_drop_down_div').html(a1[0]);

			// 获取推荐的rss的返回数据处理
			$('.rss_recommend_wrap').show();
			$('.rss_recommend_content').html(a2[0]);
			
			that.closest('.tab-pane').find('.ajax_loader').hide();
		});
	});


	// 点击rss，生成column
	$(document).on('click','.rss_add_to_column',function(){
		if($(this).attr('data-type') == 'from_select')
		{
			var rssId = $('#rss_feeds_drop_down').val();
			var data = {
				id : $('.rss_master_id_'+rssId).val(),
				rss_name : $.trim( $('#rss_feeds_drop_down option:selected').text() ),
				key : 'rss_master_id',
				social_type : 1,
			};
		}
		else
		{
			var data = {
				id : $(this).closest('.rss_feed_wrap').find('.rss_master_id').val(),
				rss_name : $.trim( $(this).text() ),
				key : 'rss_master_id',
				social_type : 1,
			};
		}
		
		var that = $(this);
		that.closest('.tab-pane').find('.ajax_loader').show();

		$.ajax({
			type : 'POST',
			data : data,
			async : 'false',
			url :  root_url+'/userColumn/addColumn',
		}).done(function(result){
			that.closest('.tab-pane').find('.ajax_loader').hide();
			if(parseInt(result))
			{
				var columnId = parseInt(result);
				// 添加列
				addNewColumnToPage(columnId, 'rss', data.id, data.rss_name);
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

		var that = $(this);
		that.closest('.tab-pane').find('.ajax_loader').show();

		$.ajax({
			type : 'post',
			data : data,
			dataType : 'json',
			url : root_url+'/rss/newRss'
		}).done(function(result){
			that.closest('.tab-pane').find('.ajax_loader').hide();
			if(result.success == true)
			{
				var str = "<option selected='selected' value='"+result.data.id+"'>"+result.data.name+"</option>";
				var	hiddenString ="<input type='hidden' class='rss_master_id_"+result.data.id+"' value='"+result.data.rss_master_id+"' />";

				$('#rss_feeds_drop_down').append(str);
				$('.rss_feeds_drop_down_div').append(hiddenString);
				$('.rss_user_add_div').hide();
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

		var that = $(this);
		that.closest('.tab-pane').find('.ajax_loader').show();
		$.ajax({
			type : 'post',
			data : {id : rssId},
			dataType : 'json',
			url : root_url+'/rss/del'
		}).done(function(result){
			that.closest('.tab-pane').find('.ajax_loader').hide();
			if(result.success === true)
			{	
				$('#rss_feeds_drop_down option:selected').remove();

				// 删除已经存在的Column
				var rss_master_id = $('.rss_master_id_'+rssId).val();
				// 如果帐号已经被添加到Column,则删除已经存在的Column
				if($('.rss_'+rss_master_id).length > 0)
				{
					$('.rss_'+rss_master_id).each(function(){
						var sectionId = $(this).attr('id');
						var columnId = sectionId.replace('column_','');
						$('.delete_column_'+columnId).trigger('click', [true]);
					});
				}
			}
		});
	})

});




