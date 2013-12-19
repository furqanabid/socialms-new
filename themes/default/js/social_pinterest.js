$(function(){
	$('.pinterest_new_account').click(function(){
		$('.pinterest_account_div').toggle();
	})

	// 将一个pinterest添加到column
	$('.pinterest_add_to_column').click(function(){
		var id = $('#pinterest_drop_down').val();
		if(id == -1)
		{
			alert('请选择一个需要使用的帐号!!');
			return;
		}	
		$('.pinterest_ajax_loader').show();
		
		var name = $('#pinterest_drop_down option:selected').text();
		var data = {
			id : id,
			name : name
		}

		$.ajax({
			type : 'post',
			data : data,
			url : social_module_link+'/pinterest/addColumn'
		}).done(function(result){
			if(parseInt(result))
			{
				var columnId = parseInt(result);
				// 添加列
				addNewColumnToPage(columnId, 'pinterest', data.id, data.name);
				$('.pinterest_ajax_loader').hide();
			}
		})
	})

	// 添加新用户
	$('.pinterest_account_add').click(function(){
		var name = $.trim($('.pinterest_username').val());
		if(name == '')
		{
			alert('请填写正确的Pinterest用户名');
			return;
		}
		$('.pinterest_ajax_loader').show();

		$.ajax({
			type : 'post',
			data : {name : name},
			url : social_module_link+'/pinterest/addAccount'
		}).done(function(result){
			if(parseInt(result))
			{
				var id = parseInt(result);
				var str = "<option value='"+id+"' selected='selected'>"+name+"</option>";
				$("#pinterest_drop_down").append(str);
				$('.pinterest_ajax_loader').hide();
				$('.pinterest_account_div').hide();
				alert('恭喜您，帐号创建成功！')
			}
			else
				alert('哎呀，帐号创建失败了!')
		})
	})

	// 删除用户
	$('.pinterest_account_del').click(function(){
		var id = $('#pinterest_drop_down').val();
		if(id == -1)
		{
			alert('请选择一个需要删除的帐号!!');
			return;
		}	

		if(!confirm('您真的要删除这个Pinterest帐号吗？'))
			return;

		$('.pinterest_ajax_loader').show();

		$.ajax({
			type : 'post',
			data : {id : id},
			url : social_module_link+'/pinterest/delAccount'
		}).done(function(result){
			if(result == 1)
			{
				$("#pinterest_drop_down option:selected").remove();
				$('.pinterest_ajax_loader').hide();

				// 删除已经存在的Column
				var sectionId = $('.pinterest_'+id).attr('id') || '';
				if(sectionId != '')
				{
				    var columnId = sectionId.replace('column_','');
				    $('.delete_column_'+columnId).trigger('click', [true]);
				}
			}
			else
				alert('哎呀，帐号删除失败了!');
		})
	})
})