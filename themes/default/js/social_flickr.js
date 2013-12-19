$(function(){
	// 添加一个flickr 帐号到column
	$('.flickr_add_to_column').click(function(){
		var id = $("#flickr_drop_down").val();
		if(id == -1)
		{
			alert("请选择一个Flickr帐号");
			return;
		}
		$('.flickr_ajax_loader').show();

		var data = {
			id:id,
			flickrName:$.trim($('#flickr_drop_down option:selected').text()),
		}

		$.ajax({
			type: "POST",
			url: social_module_link+"/flickr/addColumn", 
			data: data,
		}).done(function(result){
			if(parseInt(result))
			{
				var columnId = parseInt(result);
				// 添加列
                addNewColumnToPage(columnId, 'flickr', data.id, data.flickrName); 
				$('.flickr_ajax_loader').hide();
			}
		});	
	})


	// flickr Tab的点击
	$(document).on('click','.flickrTab',function(){
		// 高亮tab
		$(this).siblings().removeClass('currentTabSelected').end().addClass('currentTabSelected');

		var id = $(this).closest('.insert_columns').find('.flickr_id').val();
		var access_token = $(this).closest('.insert_columns').find('.flickr_a_t').val();
		var data = {
			id : id,
			a_t : access_token
		}
		var that = $(this);
		that.closest('.insert_columns').find('.holder_content').html("<img class='ajax_loader' src='"+statics_assets+"/images/ajax-loader.gif' />");

		// 获取到的是用户的feed数据
		if($(this).hasClass('flickr_most_recent'))
		{
			$.ajax({
				type: "POST",
				url: social_module_link+"/flickr/recent", 
				dataType : 'html',
				data: data,
			}).done(function(result){
				that.closest('.insert_columns').find('.holder_content').html(result);
			});	
		}
		// 获取到的最近上传到flickr的一些比较有兴趣的图片
		else if($(this).hasClass('flickr_most_interestingness'))
		{
			$.ajax({
				type: "POST",
				url: social_module_link+"/flickr/getInterestingness", 
				dataType : 'html',
				data: data,
			}).done(function(result){
				that.closest('.insert_columns').find('.holder_content').html(result);
			});	
		}
		// 获取到的是自己发布的图片
		else
		{
			$.ajax({
				type: "POST",
				url: social_module_link+"/flickr/getMyPost", 
				dataType : 'html',
				data: data,
			}).done(function(result){
				that.closest('.insert_columns').find('.holder_content').html(result);
			});	
		}
	})

	// 删除flickr帐号
	$('.flickr_account_del').click(function(){
		var id = $('#flickr_drop_down').val();
		if(id == -1)
		{
			alert('请选择一个需要删除的Flickr帐号');
			return;
		}

		if(!confirm('您真的要删除这个flickr帐号吗？'))
			return;

		$('.flickr_ajax_loader').show();
		$.ajax({
			type : 'POST',
			data : {id : id},
			url : social_module_link+"/flickr/delAccount"
		}).done(function(result){
			if(result == 1)
			{
				$('#flickr_drop_down option:selected').remove();
				$('.flickr_ajax_loader').hide();

                // 删除已经存在的Column
                var sectionId = $('.flickr_'+id).attr('id') || '';
                if(sectionId != '')
                {
                    var columnId = sectionId.replace('column_','');
                    $('.delete_column_'+columnId).trigger('click', [true]);
                }
			}	
			else
				alert('Flickr帐号删除失败，请联系管理员');
		});
	})

	// flickr photo的一些处理比如comment,like,unfollow等
	$(document).on('click', '.flickr_action a', function(){
		var type = $(this).attr('data-type');
		var data = {
			id : $(this).closest('.insert_columns').find('.flickr_id').val(),
			a_t : $(this).closest('.insert_columns').find('.flickr_a_t').val(),
            photoid : $(this).closest('.flickr_wrap').find('.flickr_action').attr('data-photoid'),
			type : type
		}
		var that = $(this);

		switch(type)
		{
            // 如果是comment
			case 'comment':
				that.closest('.flickr_wrap').find('.write_flickr_comment').toggle();
			break;

            // 如果是like
            case 'like':
                that.closest('.flickr_wrap').find('.social_action_ajax_loader').show();
                $.ajax({
                    type : 'POST',
                    data : data,
                    dataType : 'json',
                    url  : social_module_link+'/flickr/photoOperate',
                }).done(function(result){
                    that.closest('.flickr_wrap').find('.social_action_ajax_loader').hide();
                    if(result.success == true)
                        that.closest('.flickr_wrap').find('.social_action_msg').slideDown().delay(5000).slideUp();
                    else 
                        alert(result.msg);             
                })
            break;

            // 如果是unfollow
            case 'unfollow':
                alert('对不起，此API在Flickr上暂未开放,敬请期待!');
            break;
		}
	})

	// flickr处理留言动作
	$(document).on('keypress','.write_flickr_comment', function(e){
		var code = e.keyCode || e.which;
		// 如果按了是enter键
		if(code == 13)
       	{
       		var comment = $.trim($(this).val());
       		if(comment == '')
       		{
       			alert('留言内容不能为空！');
       			return;
       		}

       		$(this).attr('disabled',true);
        	var data = {
                comment : comment,
                photoid : $(this).closest('.flickr_wrap').find('.flickr_action').attr('data-photoid'),
                a_t : $(this).closest('.insert_columns').find('.flickr_a_t').val(),
                type : 'comment'
        	}

        	var that = $(this);
        	$.ajax({
                type : 'POST',
                data : data,
                dataType : 'json',
                url  : social_module_link+'/flickr/photoOperate',
       	 	}).done(function(result){
       	 		if(result.success == true)
       	 		{
       	 			that.closest('.flickr_wrap').find('.social_action_msg').slideDown().delay(5000).slideUp();
       	 			that.attr('disabled',false).val('');    	 		
       	 		}
       	 		else 
       	 		{
       	 			alert(result.msg);
       	 		}      	 		
       	 			
        	})
       	} 
	})

    // 获取更多的Flickr内容，相当于分页
    $(document).on('click','.flickr_more',function(){
        var data = {
            id : $(this).closest('.insert_columns').find('.flickr_id').val(),
            a_t : $(this).closest('.insert_columns').find('.flickr_a_t').val(),
            page : $(this).attr('data-page'),
            pages : $(this).attr('data-pages'),
        }

        var that = $(this);
        that.html("<img class='ajax_loader' src='"+statics_assets+"/images/ajax-loader.gif' />");
        // 首页图片分页
        if(that.closest('.insert_columns').find('.currentTabSelected').hasClass('flickr_most_recent'))
        {
            $.ajax({
                type : 'POST',
                data : data,
                dataType : 'html',
                url  : social_module_link+'/flickr/recent',
            }).done(function(result){
                that.hide();
                that.closest('.holder_content').append(result);
            })
        }
        // 发掘图片的分页
        else if(that.closest('.insert_columns').find('.currentTabSelected').hasClass('flickr_most_interestingness'))
        {
            $.ajax({
                type : 'POST',
                data : data,
                dataType : 'html',
                url  : social_module_link+'/flickr/getInterestingness',
            }).done(function(result){
                that.hide();
                that.closest('.holder_content').append(result);
            })
        }
        else
        {
            $.ajax({
                type : 'POST',
                data : data,
                dataType : 'html',
                url  : social_module_link+'/flickr/getMyPost',
            }).done(function(result){
                that.hide();
                that.closest('.holder_content').append(result);
            })
        }
    })


})