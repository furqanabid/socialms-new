$(function(){
	// 添加一个flickr 帐号到column
	$('.flickr_add_to_column').click(function(){
		var id = $("#flickr_drop_down").val();
        var that = $(this);
		if(id == -1)
		{
			alert("请选择一个Flickr帐号");
			return;
		}
		that.closest('.tab-pane').find('.ajax_loader').show();

        // SocialType的值具体查看xzModel文件
		var data = {
			id : id,
            key : 'flickr_id',
            social_type : 4,
			flickrName : $.trim($('#flickr_drop_down option:selected').text()),
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
                addNewColumnToPage(columnId, 'flickr', data.id, data.flickrName); 
				that.closest('.tab-pane').find('.ajax_loader').hide();
			}
		});	
	})


	// flickr Tab的点击
	$(document).on('click','.flickrTab',function(){
		// 高亮tab
		$(this).siblings().removeClass('currentTabSelected').end().addClass('currentTabSelected');

		var url;
        var id = $(this).closest('.insert_columns').attr('data-social-account');
        var data = {id : id};

		var that = $(this);
		that.closest('.insert_columns').find('.column_container').html("加载中，请稍后......");

		// recent tab
		if($(this).hasClass('recent'))
		{
            url = root_url+"/flickr/parse/tab/recent";
		}
		// 获取到的最近上传到flickr的一些比较有兴趣的图片
		else if($(this).hasClass('interest'))
		{
			url = root_url+"/flickr/parse/tab/interest";
		}
		// 获取到的是自己发布的图片
		else
		{
			url = root_url+"/flickr/parse/tab/mypost";
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

	// 删除flickr帐号
	$('.flickr_account_del').click(function(){
		var id = $('#flickr_drop_down').val();
        var that = $(this);
		if(id == -1)
		{
			alert('请选择一个需要删除的Flickr帐号');
			return;
		}

		if(!confirm('您真的要删除这个flickr帐号吗？'))
			return;

		that.closest('.tab-pane').find('.ajax_loader').show();

		$.ajax({
			type : 'POST',
			data : {id : id},
            dataType : 'json',
			url : root_url+"/flickr/del"
		}).done(function(result){
			if(result.success === true)
			{
				$('#flickr_drop_down option:selected').remove();
				that.closest('.tab-pane').find('.ajax_loader').hide();

                // 如果帐号已经被添加到Column,则删除已经存在的Column
                if($('.flickr_'+id).length > 0)
                {
                    $('.flickr_'+id).each(function(){
                        var sectionId = $(this).attr('id');
                        var columnId = sectionId.replace('column_','');
                        $('.delete_column_'+columnId).trigger('click', [true]);
                    });
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
			id : $(this).closest('.insert_columns').attr('data-social-account'),
            photoid : $(this).closest('.flickr_wrap').find('.flickr_action').attr('data-photoid'),
			type : type
		}
		var that = $(this);

		switch(type)
		{
            // 如果是comment
			case 'comment':
				that.closest('.social_wrap').find('.write_flickr_comment').toggle();
			break;

            // 如果是like
            case 'like':
                that.closest('.social_wrap').find('.social_action_msg').show();
                $.ajax({
                    type : 'POST',
                    data : data,
                    dataType : 'json',
                    url  : root_url+'/flickr/operate/tab/like',
                }).done(function(res){
                    that.closest('.social_wrap').find('.social_action_msg').hide();
                    if(res.stat == 'ok')    
                    {
                        that.find('.glyphicon').removeClass('glyphicon-star-empty').addClass('glyphicon-star');
                        that.closest('.social_wrap').find('.action_info').html('您的操作处理成功!').slideDown().delay(5000).slideUp();
                    }               
                    else
                    {
                        that.closest('.social_wrap').find('.action_info').html(res.message).slideDown().delay(5000).slideUp();
                    }           
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
                id : $(this).closest('.insert_columns').attr('data-social-account'),
                type : 'comment'
        	}

        	var that = $(this);
        	$.ajax({
                type : 'POST',
                data : data,
                dataType : 'json',
                url  : root_url+'/flickr/operate/tab/comment',
       	 	}).done(function(res){
       	 		if(res.stat == 'ok')
       	 		{
       	 			that.attr('disabled',false).val('');    
                    that.closest('.social_wrap').find('.action_info').html('您的操作处理成功!').slideDown().delay(5000).slideUp();	 		
       	 		}
       	 		else 
       	 		{
       	 			that.closest('.social_wrap').find('.action_info').html(res.message).slideDown().delay(5000).slideUp();
       	 		}      	 		
       	 			
        	})
       	} 
	})

    // 获取更多的Flickr内容，相当于分页
    $(document).on('click','.flickr_more',function(){
        var url;
        var data = {
            id : $(this).closest('.insert_columns').attr('data-social-account'),
            page : $(this).attr('data-page'),
            pages : $(this).attr('data-pages'),
        }

        var that = $(this);
        that.html("加载中......");
        // 首页图片分页
        if(that.closest('.insert_columns').find('.currentTabSelected').hasClass('recent'))
        {
            url = root_url+'/flickr/parse/tab/recent';
        }
        // 发掘图片的分页
        else if(that.closest('.insert_columns').find('.currentTabSelected').hasClass('interest'))
        {
            url = root_url+'/flickr/parse/tab/interest';
        }
        else
        {
            url = root_url+'/flickr/parse/tab/mypost';
        }

        $.ajax({
            type : 'POST',
            data : data,
            dataType : 'html',
            url  : url,
        }).done(function(result){
            that.hide();
            that.closest('.column_container').append(result);
        })
    })


})