// short feed left click
function left_clicked(obj, clicktype) {
	// if the right column had clicked
	if(obj.siblings('.add_column_right').hasClass('right-clicked') && typeof clicktype == 'undefined')
	{		
		$('.left-clicked').siblings('.add_column_right').trigger('click','auto');				
	}

    $('.add_column_left').removeClass('left-clicked');
    obj.addClass('left-clicked'); 

    var columnId = obj.closest('.short-feed-wrap').attr('id').replace('short-feed-', '');
    $('#short-feed-left').append( $('#column_'+columnId) );
	$('#short-feed-left').find('section').hide();
	$('#column_'+columnId).show();
}

// short feed right click
function right_clicked(obj, clicktype) {
	// if the right column had clicked
	if(obj.siblings('.add_column_left').hasClass('left-clicked') && typeof clicktype == 'undefined')
	{		
		$('.right-clicked').siblings('.add_column_left').trigger('click','auto');				
	}

    $('.add_column_right').removeClass('right-clicked');
    obj.addClass('right-clicked'); 

    var columnId = obj.closest('.short-feed-wrap').attr('id').replace('short-feed-', '');
    $('#short-feed-right').append( $('#column_'+columnId) );
	$('#short-feed-right').find('section').hide();
	$('#column_'+columnId).show();
}

// 生成short feed的函数
function build_short_feed(columnId, title)
{
	return "<div id='short-feed-"+columnId+"' class='short-feed-wrap'>"+
				"<div class='feed-top'>"+
					"<span class='feed-icon'></span>"+
					"<span class='feed-title'>"+title+"</span>"+
				"</div>"+
				"<span class='pull-left action-feed-icon add_column_left'></span>"+
				"<span class='pull-right action-feed-icon add_column_right'></span>"+
			"</div>";
}

// All js for social
$(function(){
	// 得到页面存在的column信息,并且生成column
	$('.loaded_column').each(function(){
		var socialType = $(this).attr('data-type');
		var width_size = $(this).attr('data-width-size');
		var columnId = $(this).val();

		switch(socialType)
		{
			// 如果页面存在rss
			case 'rss':		
				var socialAccountId = $('.rss_master_id_'+columnId).val();	
				var title = $('.rss_name_'+columnId).val();
			break;

			// 如果页面存在instagram
			case 'instagram':
				var socialAccountId = $('.instagram_id_'+columnId).val();
				var title = $('#instagram_drop_down option[value="'+socialAccountId+'"]').text();
			break;

			// 如果页面存在pinterest
			case 'pinterest':
				var socialAccountId = $('.pinterest_id_'+columnId).val();
				var title = $('#pinterest_drop_down option[value="'+socialAccountId+'"]').text();
			break;

			// 如果页面存在flickr
			case 'flickr':
				var socialAccountId = $('.flickr_id_'+columnId).val();
				var title = $('#flickr_drop_down option[value="'+socialAccountId+'"]').text();
			break;

			// 如果页面存在linkedin
			case 'linkedin':
				var socialAccountId = $('.linkedin_id_'+columnId).val();
				var title = $('#linkedin_drop_down option[value="'+socialAccountId+'"]').text();
			break;

			// 如果页面存在reddit
			case 'reddit':
				var socialAccountId = $('.reddit_id_'+columnId).val();
				var title = $('#reddit_drop_down option[value="'+socialAccountId+'"]').text();
			break;

			// 如果页面存在人人column
			case 'renren':
				var socialAccountId = $('.renren_id_'+columnId).val();
				var title = $('#renren_drop_down option[value="'+socialAccountId+'"]').text();
			break;

			// 如果页面存在微博column
			case 'weibo':
				var socialAccountId = $('.weibo_id_'+columnId).val();
				var title = $('#weibo_drop_down option[value="'+socialAccountId+'"]').text();
			break;

			// 如果页面存在56视频
			case 'video56':
				var socialAccountId = $('.video56_id_'+columnId).val();
				var title = $('.video56_drop_down option[value="'+socialAccountId+'"]').text();
			break;

			// 如果页面存在优酷视频
			case 'youku':
				var socialAccountId = $('.youku_id_'+columnId).val();
				var title = $('#youku_drop_down option[value="'+socialAccountId+'"]').text();
			break;
		}

		// 调用函数添加列到页面
		addNewColumnToPage(columnId, socialType, socialAccountId, title, width_size);
	});


	// 如果view_type=1即紧凑，则调用执行
	if(view_type == 1)
	{
		var short_feed_title = '';
		$('.insert_columns').each(function(){
			var columnId = $(this).attr('id').replace('column_','');
			var title = $.trim( $(this).find('.column_title_tab_name').text() );

			short_feed_title += build_short_feed(columnId, title);
		})

		$('#short-feed-title').find('.column_container').html(short_feed_title);


		// 点击left或者right按钮
		$(document).on('click', '.add_column_left', function(event, type){
			left_clicked($(this), type);
		})

		$(document).on('click', '.add_column_right', function(event, type){
			right_clicked($(this), type);
		})

		$('.add_column_left').eq(0).trigger('click');
		$('.add_column_right').eq(1).trigger('click');
	}


	// add view div
	$('.add_view').click(function(){
		$('.view_container').toggle();
	});

	$('.add_new_view').click(function(){
		$('.new_view_input').toggle();
	})

	// 改变视图
	$(document).on('click','.change_view_button',function(){
		$(this).html('加载中...');
		var data = {
			id : $(this).attr('data-id')
		};

		$.ajax({
			type : 'POST',
			data : data,
			url :  root_url+'/userView/change',
		}).done(function(){
			window.location.reload();	
		});	
	});

	// 新建视图
	$('.save_view_name').click(function(){
		var name = $('.add_view_name').val();
		if(name == '')
		{	
			alert('请输入正确的视图名');
			return;
		}

		var data = {
			name : name
		};

		$.ajax({
			type : 'POST',
			data : data,
			dataType : 'json',
			url :  root_url+'/userView/add',
		}).done(function(result){
			if(result.success === true)
			{
				var str1 = '<a href="#" class="change_view_button view_btn_'+result.id+'" data-id="'+result.id+'">'+name+'</a>';
				var str2 = '<option value="'+result.id+'" selected="selected">'+name+'</option>';
				$('.myview').append(str1);
				$('.select_view').append(str2);
			}
			else
			{
				alert('创建视图失败，请联系管理员');
			}
		});	
	});

	// 删除视图
	$('.del_view').click(function(){
		var data = {id : $('.select_view').val()};

		$.ajax({
			type : 'POST',
			data : data,
			dataType : 'json',
			url :  root_url+'/userView/del',
		}).done(function(res){
			if(res.success == true)
			{
				$('.view_btn_'+data['id']).remove();
				$('.select_view option[value="'+data['id']+'"]').remove();
			}
			else
			 	alert(res.msg);
		});	
	});

	// 改变视图的查看类型
	$('.view_type input').click(function(){
		var data = {
			id : $('.select_view').val(),
			view_type : $(this).val()
		}
		
		$.ajax({
			type : 'POST',
			data : data,
			dataType : 'json',
			url :  root_url+'/userView/viewType',
		}).done(function(res){
			if(res.success)
			{
				window.location.reload();
			}
		});	
	})
})