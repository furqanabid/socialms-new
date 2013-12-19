$(function(){
    // 添加一个帐号到column
    $('.youku_add_to_column').click(function(){
        var id = $("#youku_drop_down").val();
        if(id == -1)
        {
            alert("请选择一个优酷视频帐号");
            return;
        }
        $('.youku_ajax_loader').show();

        var data = {
            id : id,
            Name : $.trim($('#youku_drop_down option:selected').text()),
        }

        $.ajax({
            type: "POST",
            url: social_module_link+"/youku/addColumn", 
            data: data,
        }).done(function(result){
            if(parseInt(result))
            {
                var columnId = parseInt(result);
                // 添加列
                addNewColumnToPage(columnId, 'youku', data.id, data.Name); 
                $('.youku_ajax_loader').hide();
            }
        }); 
    })

    // Tab切换
    $(document).on('click','.youkuTab',function(){
        var url;
        var data = {
            id : $(this).closest('.insert_columns').find('.youku_id').val(),
        }

        // 高亮tab
        $(this).siblings().removeClass('currentTabSelected').end().addClass('currentTabSelected');
      
        // 我的收藏
        if($(this).hasClass('youku_favorite'))
            url = social_module_link+'/youku/index?type=favorite';
        else if($(this).hasClass('youku_category'))
            url = social_module_link+'/youku/index?type=category';
        else if($(this).hasClass('youku_show'))
            url = social_module_link+'/youku/index?type=show';

        var that = $(this);
        that.closest('.insert_columns').find('.holder_content').html("<img class='ajax_loader' src='"+statics_assets+"/images/ajax-loader.gif' />");
        // 发送数据
        $.ajax({
            type: "POST",
            url: url, 
            dataType : 'html',
            data: data,
        }).done(function(result){
            that.closest('.insert_columns').find('.holder_content').html(result);
        }); 
    })

    // 获取更多的内容，相当于分页
    $(document).on('click','.youku_more',function(){
        var url;
        var data = {
            id : $(this).closest('.insert_columns').find('.youku_id').val(),
            page : $(this).attr('data-page')
        }
        var that = $(this);
        that.html("<img class='ajax_loader' src='"+statics_assets+"/images/ajax-loader.gif' />");   

        if(that.closest('.insert_columns').find('.currentTabSelected').hasClass('youku_category'))
            url  = social_module_link+'/youku/index?type=category';
        else if(that.closest('.insert_columns').find('.currentTabSelected').hasClass('youku_favorite')) 
            url  = social_module_link+'/youku/index?type=favorite';  
        else if(that.closest('.insert_columns').find('.currentTabSelected').hasClass('youku_show')) 
            url  = social_module_link+'/youku/index?type=show'; 

        // 发送数据
        $.ajax({
            type : 'POST',
            data : data,
            dataType : 'html',
            url  : url,
        }).done(function(result){
            that.hide();
            that.closest('.holder_content').append(result);
        })
    })
})