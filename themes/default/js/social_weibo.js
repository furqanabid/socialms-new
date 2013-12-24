$(function(){
    // 添加帐号到column
    $('.weibo_add_to_column').click(function(){
        var id = $("#weibo_drop_down").val();
        var that = $(this);
        if(id == -1)
        {
            alert("请选择一个需要添加的新浪微博帐号");
            return;
        }
        $('.weibo_ajax_loader').show();

        // SocialType的值具体查看xzModel文件
        var data = {
            id : id,
            key : 'weibo_id',
            social_type : 8,
            name:$.trim($('#weibo_drop_down option:selected').html()),
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
                addNewColumnToPage(columnId, 'weibo', data.id, data.name);
                that.closest('.tab-pane').find('.ajax_loader').hide();
            }
        }); 
    })

    // 删除用户
    $('.weibo_account_del').click(function(){
        var id = $('#weibo_drop_down').val();
        var that = $(this);
        if(id == -1)
        {
            alert('请选择一个需要删除的帐号!!');
            return;
        }   

        if(!confirm('您真的要删除这个帐号吗？'))
            return;

        that.closest('.tab-pane').find('.ajax_loader').show();

        $.ajax({
            type : 'post',
            data : {id : id},
            dataType : 'json',
            url : root_url+'/weibo/del'
        }).done(function(result){
            if(result.success === true)
            {
                $("#weibo_drop_down option:selected").remove();
                that.closest('.tab-pane').find('.ajax_loader').hide();

                // 如果帐号已经被添加到Column,则删除已经存在的Column
                if($('.weibo_'+id).length > 0)
                {
                    $('.weibo_'+id).each(function(){
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
    $(document).on('click','.weiboTab',function(){
        var url;
        var id = $(this).closest('.insert_columns').attr('data-social-account');
        var data = {id : id};

        // 高亮tab
        $(this).siblings().removeClass('currentTabSelected').end().addClass('currentTabSelected');

        var that = $(this);
        that.closest('.insert_columns').find('.column_container').html("加载中，请稍后......");
        
        // 首页动态
        if($(this).hasClass('home'))
            url = root_url+'/weibo/parse/tab/home';
        else if($(this).hasClass('user'))
            url = root_url+'/weibo/parse/tab/user';
        else if($(this).hasClass('favorite'))
            url = root_url+'/weibo/parse/tab/favorite';
       
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
    $(document).on('click','.weibo_more',function(){
        var url;
        var data = {
            id :  $(this).closest('.insert_columns').attr('data-social-account'),
            page : $(this).attr('data-page')
        }

        var that = $(this);
        that.html("加载中......");
    
        if(that.closest('.insert_columns').find('.currentTabSelected').hasClass('home'))
            url  = root_url+'/weibo/parse/tab/home';   
        else if(that.closest('.insert_columns').find('.currentTabSelected').hasClass('user')) 
            url  = root_url+'/weibo/parse/tab/user'; 
        else if(that.closest('.insert_columns').find('.currentTabSelected').hasClass('favorite')) 
            url  = root_url+'/weibo/parse/tab/favorite'; 

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
    $(document).on('click', '.weibo_action a', function(){
        var type = $(this).attr('data-type');
        var data = {
            id : $(this).closest('.insert_columns').attr('data-social-account'),
            weibo_idstr : $(this).closest('.weibo_wrap').find('.social_action').attr('data-idstr'),
            weibo_uidstr : $(this).closest('.weibo_wrap').find('.social_action').attr('data-uidstr'),
        }
        var that = $(this);

        switch(type)
        {
            // 如果是comment
            case 'comment':
                that.closest('.weibo_wrap').find('.write_weibo_comment').toggle();
            break;

            // 如果是favorite和unfollow
            case 'favorite':
            case 'unfavorite':
            case 'unfollow':
            case 'top':
                that.closest('.social_wrap').find('.social_action_msg').show();
                $.ajax({
                    type : 'POST',
                    data : data,
                    dataType : 'json',
                    url  : root_url+'/weibo/operate/tab/'+type,
                }).done(function(res){
                    that.closest('.social_wrap').find('.social_action_msg').hide();
                    if(!res.error)    
                    {
                        that.closest('.social_wrap').find('.action_info').html('您的操作处理成功!').slideDown().delay(5000).slideUp();
                    }               
                    else
                    {
                        that.closest('.social_wrap').find('.action_info').html(res.error).slideDown().delay(5000).slideUp();
                    }            
                })
            break;
        }
    })

    // flickr处理留言动作
    $(document).on('keypress','.write_weibo_comment', function(e){
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
                id : $(this).closest('.insert_columns').attr('data-social-account'),
                weibo_idstr : $(this).closest('.weibo_wrap').find('.social_action').attr('data-idstr'),
                weibo_uidstr : $(this).closest('.weibo_wrap').find('.social_action').attr('data-uidstr'),
            }

            var that = $(this);
            $.ajax({
                type : 'POST',
                data : data,
                dataType : 'json',
                url  : root_url+'/weibo/operate/tab/comment',
            }).done(function(res){
                that.attr('disabled',false).val('');
                if(!res.error) 
                {
                    that.closest('.social_wrap').find('.action_info').html('您的操作处理成功!').slideDown().delay(5000).slideUp();
                }
                else
                {
                    that.closest('.social_wrap').find('.action_info').html(res.error).slideDown().delay(5000).slideUp();
                }         
            })
        } 
    })
})