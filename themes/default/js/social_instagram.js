$(function(){
	// 添加一个instagram 帐号到column
	$('.instagram_add_to_column').click(function(){
		var id = $("#instagram_drop_down").val();
		var that = $(this);
		if(id == -1)
		{
			alert("请选择一个Instagram帐号");
			return;
		}
		that.closest('.tab-pane').find('.ajax_loader').show();

		// SocialType的值具体查看xzModel文件
		var data = {
			id : id,
			key : 'instagram_id',
			social_type : 2,
			instagramName:$.trim($('#instagram_drop_down option:selected').html()),
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
				addNewColumnToPage(columnId, 'instagram', data.id, data.instagramName);
				that.closest('.tab-pane').find('.ajax_loader').hide();
			}
		});	
	})

	// Instagram Tab的点击
	$(document).on('click','.instagramTab',function(){
		// 高亮tab
		$(this).siblings().removeClass('currentTabSelected').end().addClass('currentTabSelected ');

		var id = $(this).closest('.insert_columns').find('.instagram_id').val();
		var a_t =  $(this).closest('.insert_columns').find('.instagram_a_t').val();
		var data = {
			id : id,
			a_t : a_t
		}
		var that = $(this);
		that.closest('.insert_columns').find('.holder_content').html("<img class='ajax_loader' src='"+statics_assets+"/images/ajax-loader.gif' />");

		// 获取到的是用户的feed数据
		if($(this).hasClass('instagram_most_recent'))
		{
			$.ajax({
				type: "POST",
				url: root_url+"/instagram/recent", 
				dataType : 'html',
				data: data,
			}).done(function(result){
				that.closest('.insert_columns').find('.holder_content').html(result);
			});	
		}
		// 获取到的是用户post的数据
		else if($(this).hasClass('instagram_my_post'))
		{
			$.ajax({
				type: "POST",
				url: root_url+"/instagram/mypost", 
				dataType : 'html',
				data: data,
			}).done(function(result){
				that.closest('.insert_columns').find('.holder_content').html(result);
			});	
		}
		// 获取到的是最近流行的一些图片
		else
		{
			$.ajax({
				type: "POST",
				url: root_url+"/instagram/popular", 
				dataType : 'html',
				data: data,
			}).done(function(result){
				that.closest('.insert_columns').find('.holder_content').html(result);
			});	
		}
	})

	// 删除一个instagram账号
	$('.instagram_account_del').click(function(){
		var id = $('#instagram_drop_down').val();
		var that = $(this);
		if(id == -1)
		{
			alert('请选择一个Instagram帐号');
			return;
		}

		if(confirm('您确认删除这个Instagram账号吗？'))
		{
			that.closest('.tab-pane').find('.ajax_loader').show();
			$.ajax({
				type: "POST",
				url: root_url+"/instagram/del", 
				data: {id : id},
				dataType : 'json',
			}).done(function(result){
				if(result.success === true)
				{
					$('#instagram_drop_down option:selected').remove();
					that.closest('.tab-pane').find('.ajax_loader').hide();

					// 如果帐号已经被添加到Column,则删除已经存在的Column
					if($('.instagram_'+id).length > 0)
					{
						$('.instagram_'+id).each(function(){
							var sectionId = $(this).attr('id');
							var columnId = sectionId.replace('column_','');
							$('.delete_column_'+columnId).trigger('click', [true]);
						});
					}
				}
			});	
		}
	})

	// media的一些处理操作比如like,comment等
	$(document).on('click', '.instagram_action a', function(){
		var type = $(this).attr('data-type');
		var data = {
			type : type,
			mediaid : $(this).closest('.instagram_action').attr('data-mediaid'),
			a_t : $(this).closest('.insert_columns').find('.instagram_a_t').val(),
		}
		var that = $(this);
		switch(type)
		{
			// 如果是comment media
			case 'comment':
				that.closest('.instagram_wrap').find('.write_instagram_comments').toggle();
			break;

			// 如果是like media
			case 'like':
				that.closest('.instagram_wrap').find('.social_action_ajax_loader').show();
				$.ajax({
					type : 'POST',
					url : root_url+'/instagram/mediaOperate',
					data : data,
					dataType : 'json'
				}).done(function(result){
					that.closest('.instagram_wrap').find('.social_action_ajax_loader').hide();
					if(result.success == true)	
					{
						that.find('.glyphicon').removeClass('glyphicon-heart-empty').addClass('glyphicon-heart');
						that.closest('.instagram_wrap').find('.social_action_msg').slideDown().delay(5000).slideUp();
					}				
					else
					{
						alert('like失败，请联系管理员');
					}
					
				});
			break;

			// 如果是unfollow
			case 'unfollow':
				that.closest('.instagram_wrap').find('.social_action_ajax_loader').show();
				data['userid'] = that.attr('data-userid');
				$.ajax({
					type : 'POST',
					url : root_url+'/instagram/mediaOperate',
					data : data,
					dataType : 'json'
				}).done(function(result){
					that.closest('.instagram_wrap').find('.social_action_ajax_loader').hide();
					if(result.success == true)	
						that.closest('.instagram_wrap').find('.social_action_msg').slideDown().delay(5000).slideUp();
					else
						alert('请求处理失败，请联系管理员');
				});
			break;

		}
	})

	// instagram处理留言动作
	$(document).on('keypress','.write_instagram_comments', function(e){
		var code = e.keyCode || e.which;
		// 如果按了是enter键
		if(code == 13)
       	{
       		var comment = $(this).val();
       		if(comment == '')
       		{
       			alert('留言内容不能为空！');
       			return;
       		}

       		$(this).attr('disabled',true);
        	var data = {
                comment : comment,
                mediaid : $(this).closest('.instagram_wrap').find('.instagram_action').attr('data-mediaid'),
                a_t : $(this).closest('.insert_columns').find('.instagram_a_t').val(),
                type : 'comment'
        	}

        	var that = $(this);
        	$.ajax({
                type : 'POST',
                data : data,
                url  : root_url+'/instagram/mediaOperate',
       	 	}).done(function(res){
       	 		that.closest('.instagram_wrap').find('.social_action_msg').slideDown().delay(5000).slideUp();
                that.attr('disabled',false).val('');
        	})
       	} 
	})

	// 获取更多的instagram内容，相当于分页
	$(document).on('click','.instagram_more',function(){
		var data = {
			id : $(this).closest('.insert_columns').find('.instagram_id').val(),
			a_t : $(this).closest('.insert_columns').find('.instagram_a_t').val(),
			nexturl : $(this).attr('data-nexturl'),
			nextid : $(this).attr('data-nextid'),
		}

		var that = $(this);
		that.html("<img class='ajax_loader' src='"+statics_assets+"/images/ajax-loader.gif' />");
    	$.ajax({
            type : 'POST',
            data : data,
            dataType : 'html',
            url  : root_url+'/instagram/nextPage',
   	 	}).done(function(result){
   	 		that.hide();
   	 		that.closest('.holder_content').append(result);
    	})
	})
	
})