$(function(){
	// 添加一个reddit 帐号到column
	$('.reddit_add_to_column').click(function(){
		var id = $("#reddit_drop_down").val();
		if(id == -1)
		{
			alert("请选择一个Reddit帐号");
			return;
		}
		$('.reddit_ajax_loader').show();

		var data = {
			id : id,
			name : $.trim($('#reddit_drop_down option:selected').html()),
		}

		$.ajax({
			type: "POST",
			url: social_module_link+"/reddit/addColumn", 
			data: data,
		}).done(function(result){
			if(parseInt(result))
			{
				var columnId = parseInt(result);
				// 添加列
				addNewColumnToPage(columnId, 'reddit', data.id, data.name);
				$('.reddit_ajax_loader').hide();
			}
		});	
	})

	// Reddit Tab的切换
	$(document).on('click','.redditTab',function(){
		// 高亮tab
		$(this).siblings().removeClass('currentTabSelected').end().addClass('currentTabSelected ');

		var id = $(this).closest('.insert_columns').find('.reddit_id').val();
		var data = {
			id : id,
		}
		var that = $(this);
		that.closest('.insert_columns').find('.holder_content').html("<img class='ajax_loader' src='"+statics_assets+"/images/ajax-loader.gif' />");

		// 最新新闻
		if($(this).hasClass('reddit_new'))
		{
			$.ajax({
				type: "POST",
				url: social_module_link+"/reddit/parseNew", 
				dataType : 'html',
				data: data,
			}).done(function(result){
				that.closest('.insert_columns').find('.holder_content').html(result);
			});	
		}
		// 最热新闻
		else if($(this).hasClass('reddit_hot'))
		{
			$.ajax({
				type: "POST",
				url: social_module_link+"/reddit/parseHot", 
				dataType : 'html',
				data: data,
			}).done(function(result){
				that.closest('.insert_columns').find('.holder_content').html(result);
			});	
		}
		// 热议新闻
		else if($(this).hasClass('reddit_controversial'))
		{
			$.ajax({
				type: "POST",
				url: social_module_link+"/reddit/parseControversial", 
				dataType : 'html',
				data: data,
			}).done(function(result){
				that.closest('.insert_columns').find('.holder_content').html(result);
			});	
		}
		// 用户已经保存的新闻
		else if($(this).hasClass('reddit_saved'))
		{
			$.ajax({
				type: "POST",
				url: social_module_link+"/reddit/parseSaved", 
				dataType : 'html',
				data: data,
			}).done(function(result){
				that.closest('.insert_columns').find('.holder_content').html(result);
			});	
		}
	})

	// 显示更多的内容
	$(document).on('click','.reddit_more',function(){
	    var data = {
	        id : $(this).closest('.insert_columns').find('.reddit_id').val(),
	        after : $(this).attr('data-after'),
	    }

	    var that = $(this);
	    that.html("<img class='ajax_loader' src='"+statics_assets+"/images/ajax-loader.gif' />");
	    // 首页图片分页
	    if(that.closest('.insert_columns').find('.currentTabSelected').hasClass('reddit_new'))
	    {
	        $.ajax({
	            type : 'POST',
	            data : data,
	            dataType : 'html',
	            url  : social_module_link+'/reddit/parseNew',
	        }).done(function(result){
	            that.hide();
	            that.closest('.holder_content').append(result);
	        })
	    }
	    // 发掘图片的分页
	    else if(that.closest('.insert_columns').find('.currentTabSelected').hasClass('reddit_hot'))
	    {
	        $.ajax({
	            type : 'POST',
	            data : data,
	            dataType : 'html',
	            url  : social_module_link+'/reddit/parseHot',
	        }).done(function(result){
	            that.hide();
	            that.closest('.holder_content').append(result);
	        })
	    }
	    else if(that.closest('.insert_columns').find('.currentTabSelected').hasClass('reddit_controversial'))
	    {
	        $.ajax({
	            type : 'POST',
	            data : data,
	            dataType : 'html',
	            url  : social_module_link+'/reddit/parseControversial',
	        }).done(function(result){
	            that.hide();
	            that.closest('.holder_content').append(result);
	        })
	    }
	    else if(that.closest('.insert_columns').find('.currentTabSelected').hasClass('reddit_saved'))
	    {
	        $.ajax({
	            type : 'POST',
	            data : data,
	            dataType : 'html',
	            url  : social_module_link+'/reddit/parseSaved',
	        }).done(function(result){
	            that.hide();
	            that.closest('.holder_content').append(result);
	        })
	    }
	})

	// 删除帐号
	$('.reddit_account_del').click(function(){
		var id = $('#reddit_drop_down').val();
		if(id == -1)
		{
			alert('请选择一个需要删除的Reddit帐号');
			return;
		}

		if(!confirm('您真的要删除这个Reddit帐号吗？'))
			return;

		$('.reddit_ajax_loader').show();
		$.ajax({
			type : 'POST',
			data : {id : id},
			url : social_module_link+"/reddit/delAccount"
		}).done(function(result){
			if(result == 1)
			{
				$('#reddit_drop_down option:selected').remove();
				$('.reddit_ajax_loader').hide();

				// 删除已经存在的Column
				var sectionId = $('.reddit_'+id).attr('id') || '';
				if(sectionId != '')
				{
				    var columnId = sectionId.replace('column_','');
				    $('.delete_column_'+columnId).trigger('click', [true]);
				}
			}	
			else
				alert('Reddit帐号删除失败，请联系管理员');
		});
	})

	// 对文本的一些操作
	$(document).on('click', '.reddit_action a', function(){
		var type = $(this).attr('data-type');
		var that = $(this);
		var data = {
			type : type,
			id : $(this).closest('.social_action').attr('data-id'),
			modhash : $(this).closest('.social_action').attr('data-modhash'),
			a_t :  $(this).closest('.insert_columns').find('.reddit_a_t').val(),
		}

		if(type == 'comment')
		{
			that.closest('.reddit_wrap').find('.write_reddit_comments').toggle();
		}
		else
		{
			that.closest('.reddit_wrap').find('.social_action_ajax_loader').show();
			$.ajax({
				type : 'POST',
				data : data,
				dataType : 'json',
				url : social_module_link+"/reddit/operation"
			}).done(function(result){
				if(result.success == true)
				{
					that.closest('.reddit_wrap').find('.social_action_ajax_loader').hide();
					that.find('.glyphicon').removeClass('glyphicon-heart-empty').addClass('glyphicon-heart');
					that.closest('.reddit_wrap').find('.social_action_msg').slideDown().delay(5000).slideUp();
				}
			});
		}
	})

	// reddit处理留言动作
	$(document).on('keypress','.write_reddit_comments', function(e){
		var code = e.keyCode || e.which;
		// 如果按了是enter键
		if(code == 13)
       	{
       		var comment = $(this).val();
       		if(comment == '')
       		{
       			alert('内容不能为空！');
       			return;
       		}

       		$(this).attr('disabled',true);
        	var data = {
                comment : comment,
               	id : $(this).closest('.insert_columns').find('.reddit_action').attr('data-id'),
				modhash : $(this).closest('.insert_columns').find('.reddit_action').attr('data-modhash'),
                type : 'comment',
                a_t :  $(this).closest('.insert_columns').find('.reddit_a_t').val(),
        	}

        	var that = $(this);
        	$.ajax({
                type : 'POST',
                data : data,
                url  : social_module_link+'/reddit/operation'
       	 	}).done(function(res){
       	 		that.closest('.reddit_wrap').find('.social_action_msg').slideDown().delay(5000).slideUp();
                that.attr('disabled',false).val('');
        	})
       	} 
	})
	
})