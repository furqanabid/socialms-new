$(function(){
	$('.pinterest_new_account').click(function(){
		$(this).closest('.tab-pane').find('.pinterest_account_div').toggle();
	})

	// 添加新用户
	$('.pinterest_account_add').click(function(){
		var name = $.trim( $(this).closest('.tab-pane').find('.pinterest_username').val() );
		var that = $(this);
		if(name == '')
		{
			alert('请填写正确的Pinterest用户名');
			return;
		}
		that.closest('.tab-pane').find('.ajax_loader').show();

		$.ajax({
			type : 'post',
			data : {name : name},
			url : root_url+'/pinterest/add'
		}).done(function(result){
			if(parseInt(result))
			{
				var id = parseInt(result);
				var str = "<option value='"+id+"' selected='selected'>"+name+"</option>";
				$("#pinterest_drop_down").append(str);
				that.closest('.tab-pane').find('.ajax_loader').hide();
				that.closest('.tab-pane').find('.pinterest_account_div').hide();
			}
			else
				alert('哎呀，帐号创建失败了!')
		})
	})

	// 将一个pinterest添加到column
	$('.pinterest_add_to_column').click(function(){
		var id = $('#pinterest_drop_down').val();
		var that = $(this);
		if(id == -1)
		{
			alert('请选择一个需要使用的帐号!!');
			return;
		}	
		that.closest('.tab-pane').find('.ajax_loader').show();
		
		var name = $('#pinterest_drop_down option:selected').text();
		// SocialType的值具体查看xzModel文件
		var data = {
			id : id,
			name : name,
			key : 'pinterest_id',
			social_type : 3,
		}

		$.ajax({
			type : 'post',
			data : data,
			url : root_url+'/userColumn/addColumn'
		}).done(function(result){
			if(parseInt(result))
			{
				var columnId = parseInt(result);
				// 添加列
				addNewColumnToPage(columnId, 'pinterest', data.id, data.name);
				that.closest('.tab-pane').find('.ajax_loader').hide();
			}
		})
	})


	// 删除用户
	$('.pinterest_account_del').click(function(){
		var id = $('#pinterest_drop_down').val();
		var that = $(this);
		if(id == -1)
		{
			alert('请选择一个需要删除的帐号!!');
			return;
		}	

		if(!confirm('您真的要删除这个Pinterest帐号吗？'))
			return;

		that.closest('.tab-pane').find('.ajax_loader').show();

		$.ajax({
			type : 'post',
			data : {id : id},
			dataType : 'json',
			url : root_url+'/pinterest/del'
		}).done(function(result){
			if(result.success === true)
			{
				$("#pinterest_drop_down option:selected").remove();
				that.closest('.tab-pane').find('.ajax_loader').hide();

				// 如果帐号已经被添加到Column,则删除已经存在的Column
				if($('.pinterest_'+id).length > 0)
				{
					$('.pinterest_'+id).each(function(){
						var sectionId = $(this).attr('id');
						var columnId = sectionId.replace('column_','');
						$('.delete_column_'+columnId).trigger('click', [true]);
					});
				}
			}
			else
				alert('哎呀，帐号删除失败了!');
		})
	})
})