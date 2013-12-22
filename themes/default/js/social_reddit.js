$(function(){
	// 添加一个reddit 帐号到column
	$('.reddit_add_to_column').click(function(){
		var id = $("#reddit_drop_down").val();
		var that = $(this);
		if(id == -1)
		{
			alert("请选择一个Reddit帐号");
			return;
		}
		that.closest('.tab-pane').find('.ajax_loader').show();

		// SocialType的值具体查看xzModel文件
		var data = {
			id : id,
			key : 'reddit_id',
			social_type : 6,
			name:$.trim($('#reddit_drop_down option:selected').html()),
		}

		$.ajax({
			type: "POST",
			url: root_url+"/userColumn/addColumn", 
			data: data,
		}).done(function(result){
			if(parseInt(result))
			{
				var columnId = parseInt(result);
				// 添加列
				addNewColumnToPage(columnId, 'reddit', data.id, data.name);
				that.closest('.tab-pane').find('.ajax_loader').hide();
			}
		});	
	})

	// Reddit Tab的切换
	$(document).on('click','.redditTab',function(){
		// 高亮tab
		$(this).siblings().removeClass('currentTabSelected').end().addClass('currentTabSelected ');

		var url;
		var id = $(this).closest('.insert_columns').attr('data-social-account');
		var data = {id : id};

		var that = $(this);
		that.closest('.insert_columns').find('.column_container').html("加载中，请稍后......");

		// 最新新闻
		if($(this).hasClass('new'))
		{
			url = root_url+'/reddit/parse/tab/new';
		}
		// 最热新闻
		else if($(this).hasClass('hot'))
		{
			url = root_url+'/reddit/parse/tab/hot';
		}
		// 热议新闻
		else if($(this).hasClass('controversial'))
		{
			url = root_url+'/reddit/parse/tab/controversial';
		}
		// 用户已经保存的新闻
		else if($(this).hasClass('saved'))
		{
			url = root_url+'/reddit/parse/tab/saved';
		}

		$.ajax({
			type: "POST",
			url: url,
			dataType : 'html',
			data: data,
		}).done(function(result){
			that.closest('.insert_columns').find('.column_container').html(result);
		});	
	})

	// 显示更多的内容
	$(document).on('click','.reddit_more',function(){
	    var data = {
	        id : $(this).closest('.insert_columns').attr('data-social-account'),
	        after : $(this).attr('data-after'),
	    }

	   var that = $(this);
	   	that.html("加载中......");
	    // 首页图片分页
	    if(that.closest('.insert_columns').find('.currentTabSelected').hasClass('new'))
	    {
	        url = root_url+'/reddit/parse/tab/new';
	    }
	    // 发掘图片的分页
	    else if(that.closest('.insert_columns').find('.currentTabSelected').hasClass('hot'))
	    {
	       url = root_url+'/reddit/parse/tab/hot';
	    }
	    else if(that.closest('.insert_columns').find('.currentTabSelected').hasClass('controversial'))
	    {
	        url = root_url+'/reddit/parse/tab/controversial';
	    }
	    else if(that.closest('.insert_columns').find('.currentTabSelected').hasClass('saved'))
	    {
	    	url = root_url+'/reddit/parse/tab/saved';
	    }

	    $.ajax({
	        type : 'POST',
	        data : data,
	        dataType : 'html',
	        url  : url
	    }).done(function(result){
	        that.hide();
	      	that.closest('.column_container').append(result);
	    })
	})

	// 删除帐号
	$('.reddit_account_del').click(function(){
		var id = $('#reddit_drop_down').val();
		var that = $(this);
		if(id == -1)
		{
			alert('请选择一个需要删除的Reddit帐号');
			return;
		}

		if(!confirm('您真的要删除这个Reddit帐号吗？'))
			return;

		that.closest('.tab-pane').find('.ajax_loader').show();
		$.ajax({
			type : 'POST',
			data : {id : id},
			dataType : 'json',
			url : root_url+"/reddit/del"
		}).done(function(result){
			$('#reddit_drop_down option:selected').remove();
			if(result.success === true)
			{
				that.closest('.tab-pane').find('.ajax_loader').hide();

				// 如果帐号已经被添加到Column,则删除已经存在的Column
				if($('.reddit_'+id).length > 0)
				{
					$('.reddit_'+id).each(function(){
						var sectionId = $(this).attr('id');
						var columnId = sectionId.replace('column_','');
						$('.delete_column_'+columnId).trigger('click', [true]);
					});
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
			id : $(this).closest('.insert_columns').attr('data-social-account'),
			modhash : $(this).closest('.social_action').attr('data-modhash'),
			media_id : $(this).closest('.social_action').attr('data-id'),
		}

		if(type == 'comment')
		{
			that.closest('.reddit_wrap').find('.write_reddit_comments').toggle();
		}
		else if(type == 'vote')
		{
			that.closest('.social_wrap').find('.social_action_msg').show();
			$.ajax({
				type : 'POST',
				data : data,
				dataType : 'json',
				url : root_url+"/reddit/operate/tab/vote"
			}).done(function(){
				that.closest('.social_wrap').find('.social_action_msg').hide();
				that.find('.glyphicon').removeClass('glyphicon-heart-empty').addClass('glyphicon-heart');
				that.closest('.social_wrap').find('.action_info').html('您的操作处理成功!').slideDown().delay(5000).slideUp();
				
			});
		}
		else
		{
			that.closest('.social_wrap').find('.social_action_msg').show();
			$.ajax({
				type : 'POST',
				data : data,
				dataType : 'json',
				url : root_url+"/reddit/operate/tab/saved"
			}).done(function(){
				that.closest('.social_wrap').find('.social_action_msg').hide();
				that.find('.glyphicon').removeClass('glyphicon-heart-empty').addClass('glyphicon-heart');
				that.closest('.social_wrap').find('.action_info').html('您的操作处理成功!').slideDown().delay(5000).slideUp();
				
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
               	id : $(this).closest('.insert_columns').attr('data-social-account'),
               	media_id : $(this).closest('.social_wrap').find('.social_action').attr('data-id'),
				modhash : $(this).closest('.insert_columns').find('.reddit_action').attr('data-modhash'),
        	}

        	var that = $(this);
        	$.ajax({
                type : 'POST',
                data : data,
                dataType : 'json',
                url  : root_url+'/reddit/operate/tab/comment'
       	 	}).done(function(res){
       	 		that.attr('disabled',false).val('');
               	if(res.json.errors == '')	
               	{
               		that.closest('.social_wrap').find('.action_info').html('您的操作处理成功!').slideDown().delay(5000).slideUp();
               	}
               	else
               	{
               		that.closest('.social_wrap').find('.action_info').html(res.json.errors).slideDown().delay(5000).slideUp();
               	}
        	})
       	} 
	})
	
})