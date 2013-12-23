$(function(){
    // 添加一个人人帐号到column
    $('.renren_add_to_column').click(function(){
        var id = $("#renren_drop_down").val();
        var that = $(this);
        if(id == -1)
        {
            alert("请选择一个需要添加的人人帐号");
            return;
        }
        that.closest('.tab-pane').find('.ajax_loader').show();

        // SocialType的值具体查看xzModel文件
        var data = {
            id : id,
            key : 'renren_id',
            social_type : 7,
            name:$.trim($('#renren_drop_down option:selected').html()),
        }

        $.ajax({
            type: "POST",
            url: root_url+"/userColumn/addColumn", 
            data: data,
        }).done(function(result){
            that.closest('.tab-pane').find('.ajax_loader').hide();
            if(parseInt(result))
            {
                var columnId = parseInt(result);
                // 添加列
                addNewColumnToPage(columnId, 'renren', data.id, data.name);
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

        var that = $(this);
        that.closest('.tab-pane').find('.ajax_loader').show();

        $.ajax({
            type : 'post',
            data : {id : id},
            dataType : 'json',
            url : root_url+'/renren/del'
        }).done(function(result){
            if(result.success === true)
            {
                $("#renren_drop_down option:selected").remove();
                that.closest('.tab-pane').find('.ajax_loader').hide();

                // 如果帐号已经被添加到Column,则删除已经存在的Column
                if($('.renren_'+id).length > 0)
                {
                    $('.renren_'+id).each(function(){
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

    // Tab切换
    $(document).on('click','.renrenTab',function(){
        var url;
        var id = $(this).closest('.insert_columns').attr('data-social-account');
        var data = {id : id};

        // 高亮tab
        $(this).siblings().removeClass('currentTabSelected').end().addClass('currentTabSelected');
      
        var that = $(this);
        that.closest('.insert_columns').find('.column_container').html("加载中，请稍后......");

        // 人人的首页动态
        if($(this).hasClass('recent'))
        {
           url = root_url+'/renren/parse/tab/recent';
        }
        // 我的心情
        else if($(this).hasClass('status'))
        {
           url = root_url+'/renren/parse/tab/status';
        }
        // 我的分享
        else if($(this).hasClass('share'))
        {
           url = root_url+'/renren/parse/tab/share';
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

    // 获取更多的内容，相当于分页
    $(document).on('click','.renren_more',function(){
        var url;
        var data = {
            id : $(this).closest('.insert_columns').attr('data-social-account'),
            page : $(this).attr('data-page'),
        }

        var that = $(this);
        that.html("加载中......");

        // 首页图片分页
        if(that.closest('.insert_columns').find('.currentTabSelected').hasClass('recent'))
            url  = root_url+'/renren/parse/tab/recent';
        else if(that.closest('.insert_columns').find('.currentTabSelected').hasClass('status'))
            url  = root_url+'/renren/parse/tab/status';
        else if(that.closest('.insert_columns').find('.currentTabSelected').hasClass('share'))
            url  = root_url+'/renren/parse/tab/share';

        // 发送数据
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

    //  一些处理动作比如comment,like,share
    $(document).on('click', '.renren_action a', function(){
        var type = $(this).attr('data-type');
        var data = {
            id : $(this).closest('.insert_columns').attr('data-social-account'),
            entryType : $(this).closest('.renren_wrap').find('.renren_action').attr('data-type'),
            entryOwnerId : $(this).closest('.renren_wrap').find('.renren_action').attr('data-entry-ownerid'),
            entryId : $(this).closest('.renren_wrap').find('.renren_action').attr('data-entryid'),
        }
        var that = $(this);

        switch(type)
        {
            // 如果是comment
            case 'comment':
                that.closest('.social_wrap').find('.write_renren_comment').toggle();
                return;
            break;

            // 如果是like
            case 'like':
            case 'share':
                that.closest('.social_wrap').find('.social_action_msg').show()
                $.ajax({
                    type : 'POST',
                    data : data,
                    dataType : 'json',
                    url  : root_url+'/renren/operate/tab/'+type,
                }).done(function(result){
                    that.closest('.social_wrap').find('.social_action_msg').hide();
                    if(!result.error)    
                    {
                        that.closest('.social_wrap').find('.action_info').html('您的操作处理成功!').slideDown().delay(5000).slideUp();
                    }               
                    else
                    {
                        that.closest('.social_wrap').find('.action_info').html(result.error.message).slideDown().delay(5000).slideUp();
                    }             
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
                id : $(this).closest('.insert_columns').attr('data-social-account'),
                content : comment,
                entryType : $(this).closest('.renren_wrap').find('.renren_action').attr('data-type'),
                entryOwnerId : $(this).closest('.renren_wrap').find('.renren_action').attr('data-entry-ownerid'),
                entryId : $(this).closest('.renren_wrap').find('.renren_action').attr('data-entryid'),
            }

            var that = $(this);
            $.ajax({
                type : 'POST',
                data : data,
                dataType : 'json',
                url  : root_url+'/renren/operate/tab/comment',
            }).done(function(res){
                that.attr('disabled',false).val('');
                if(!res.error)    
                {
                    that.closest('.social_wrap').find('.action_info').html('您的操作处理成功!').slideDown().delay(5000).slideUp();
                }
                else
                {
                    that.closest('.social_wrap').find('.action_info').html(res.error.message).slideDown().delay(5000).slideUp();
                } 
            })
        } 
    })
})