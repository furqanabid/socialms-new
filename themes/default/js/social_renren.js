$(function(){
    // 添加一个人人帐号到column
    $('.renren_add_to_column').click(function(){
        var id = $("#renren_drop_down").val();
        if(id == -1)
        {
            alert("请选择一个需要添加的人人帐号");
            return;
        }
        $('.renren_ajax_loader').show();

        var data = {
            id : id,
            name : $.trim($('#renren_drop_down option:selected').html()),
        }

        $.ajax({
            type: "POST",
            url: social_module_link+"/renren/addColumn", 
            data: data,
        }).done(function(result){
            if(parseInt(result))
            {
                var columnId = parseInt(result);
                // 添加列
                addNewColumnToPage(columnId, 'renren', data.id, data.name);
                $('.renren_ajax_loader').hide();
            }
        }); 
    })

    // 删除用户
    $('.renren_account_del').click(function(){
        var id = $('#renren_drop_down').val();
        if(id == -1)
        {
            alert('请选择一个需要删除的帐号!!');
            return;
        }   

        if(!confirm('您真的要删除这个帐号吗？'))
            return;

        $('.renren_ajax_loader').show();

        $.ajax({
            type : 'post',
            data : {id : id},
            url : social_module_link+'/renren/delAccount'
        }).done(function(result){
            if(result == 1)
            {
                $("#renren_drop_down option:selected").remove();
                $('.renren_ajax_loader').hide();

                // 删除已经存在的Column
                var sectionId = $('.renren_'+id).attr('id') || '';
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

    // Tab切换
    $(document).on('click','.renrenTab',function(){
        var url;
        var data = {
            id : $(this).closest('.insert_columns').find('.renren_id').val(),
            a_t : $(this).closest('.insert_columns').find('.renren_a_t').val()
        }

        // 高亮tab
        $(this).siblings().removeClass('currentTabSelected').end().addClass('currentTabSelected');
      
        // 人人的首页动态
        if($(this).hasClass('renren_home'))
        {
           url = social_module_link+'/renren/home';
        }
        // 我的心情
        else if($(this).hasClass('renren_status'))
        {
           url = social_module_link+'/renren/status';
        }
        // 我的分享
        else if($(this).hasClass('renren_share'))
        {
           url = social_module_link+'/renren/share';
        }
      
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
    $(document).on('click','.renren_more',function(){
        var url;
        var data = {
            id : $(this).closest('.insert_columns').find('.renren_id').val(),
            page : $(this).attr('data-page'),
            action : $(this).attr('data-action'),
        }

        var that = $(this);
        that.html("<img class='ajax_loader' src='"+statics_assets+"/images/ajax-loader.gif' />");
        // 首页图片分页
        if(that.closest('.insert_columns').find('.currentTabSelected').hasClass('renren_home'))
            url  = social_module_link+'/renren/home';
        else if(that.closest('.insert_columns').find('.currentTabSelected').hasClass('renren_status'))
            url  = social_module_link+'/renren/status';
        else if(that.closest('.insert_columns').find('.currentTabSelected').hasClass('renren_share'))
            url  = social_module_link+'/renren/share';

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

    //  一些处理动作比如comment,like,share
    $(document).on('click', '.renren_action a', function(){
        var type = $(this).attr('data-type');
        var data = {
            id : $(this).closest('.insert_columns').find('.renren_id').val(),
            a_t : $(this).closest('.insert_columns').find('.renren_a_t').val(),
            type : type,
            entryType : $(this).closest('.renren_wrap').find('.renren_action').attr('data-type'),
            entryOwnerId : $(this).closest('.renren_wrap').find('.renren_action').attr('data-entry-ownerid'),
            entryId : $(this).closest('.renren_wrap').find('.renren_action').attr('data-entryid'),
        }
        var that = $(this);

        switch(type)
        {
            // 如果是comment
            case 'comment':
                that.closest('.renren_wrap').find('.write_renren_comment').toggle();
            break;

            // 如果是like
            case 'like':
            case 'share':
                that.closest('.renren_wrap').find('.social_action_ajax_loader').show();
                $.ajax({
                    type : 'POST',
                    data : data,
                    dataType : 'json',
                    url  : social_module_link+'/renren/operate',
                }).done(function(result){
                    that.closest('.renren_wrap').find('.social_action_ajax_loader').hide();
                    if(result.success == true)
                        that.closest('.renren_wrap').find('.social_action_msg').slideDown().delay(5000).slideUp();
                    else 
                        alert(result.msg);             
                })
            break;
        }
    })

    // flickr处理留言动作
    $(document).on('keypress','.write_renren_comment', function(e){
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
                content : comment,
                commentType : $(this).closest('.renren_wrap').find('.renren_action').attr('data-type'),
                entryOwnerId : $(this).closest('.renren_wrap').find('.renren_action').attr('data-entry-ownerid'),
                entryId : $(this).closest('.renren_wrap').find('.renren_action').attr('data-entryid'),
                a_t : $(this).closest('.insert_columns').find('.renren_a_t').val(),
                type : 'comment'
            }

            var that = $(this);
            $.ajax({
                type : 'POST',
                data : data,
                dataType : 'json',
                url  : social_module_link+'/renren/operate',
            }).done(function(result){
                if(result.success == true)
                {
                    that.closest('.renren_wrap').find('.social_action_msg').slideDown().delay(5000).slideUp();
                    that.attr('disabled',false).val('');                
                }
                else 
                {
                    alert(result.msg);
                }               
                    
            })
        } 
    })
})