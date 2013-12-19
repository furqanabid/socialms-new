$(function(){
    // 添加帐号到column
    $('.weibo_add_to_column').click(function(){
        var id = $("#weibo_drop_down").val();
        if(id == -1)
        {
            alert("请选择一个需要添加的新浪微博帐号");
            return;
        }
        $('.weibo_ajax_loader').show();

        var data = {
            id : id,
            name : $.trim($('#weibo_drop_down option:selected').html()),
        }

        $.ajax({
            type: "POST",
            url: social_module_link+"/weibo/addColumn", 
            data: data,
        }).done(function(result){
            if(parseInt(result))
            {
                var columnId = parseInt(result);
                // 添加列
                addNewColumnToPage(columnId, 'weibo', data.id, data.name);
                $('.weibo_ajax_loader').hide();
            }
        }); 
    })

    // 删除用户
    $('.weibo_account_del').click(function(){
        var id = $('#weibo_drop_down').val();
        if(id == -1)
        {
            alert('请选择一个需要删除的帐号!!');
            return;
        }   

        if(!confirm('您真的要删除这个帐号吗？'))
            return;

        $('.weibo_ajax_loader').show();

        $.ajax({
            type : 'post',
            data : {id : id},
            url : social_module_link+'/weibo/delAccount'
        }).done(function(result){
            if(result == 1)
            {
                $("#weibo_drop_down option:selected").remove();
                $('.weibo_ajax_loader').hide();

                // 删除已经存在的Column
                var sectionId = $('.weibo_'+id).attr('id') || '';
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
    $(document).on('click','.weiboTab',function(){
        var url;
        var data = {
            id : $(this).closest('.insert_columns').find('.weibo_id').val(),
            a_t : $(this).closest('.insert_columns').find('.weibo_a_t').val()
        }

        // 高亮tab
        $(this).siblings().removeClass('currentTabSelected').end().addClass('currentTabSelected');
      
        // 首页动态
        if($(this).hasClass('weibo_home_timeline'))
            url = social_module_link+'/weibo/home';
        else if($(this).hasClass('weibo_user_timeline'))
            url = social_module_link+'/weibo/user';
        else if($(this).hasClass('weibo_favorites'))
            url = social_module_link+'/weibo/favorites';

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
    $(document).on('click','.weibo_more',function(){
        var url;
        var data = {
            id : $(this).closest('.insert_columns').find('.weibo_id').val(),
            page : $(this).attr('data-page')
        }

        var that = $(this);
        that.html("<img class='ajax_loader' src='"+statics_assets+"/images/ajax-loader.gif' />");
    
        if(that.closest('.insert_columns').find('.currentTabSelected').hasClass('weibo_home_timeline'))
            url  = social_module_link+'/weibo/home';   
        else if(that.closest('.insert_columns').find('.currentTabSelected').hasClass('weibo_user_timeline')) 
            url  = social_module_link+'/weibo/user'; 
        else if(that.closest('.insert_columns').find('.currentTabSelected').hasClass('weibo_favorites')) 
            url  = social_module_link+'/weibo/favorites'; 

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
    $(document).on('click', '.weibo_action a', function(){
        var type = $(this).attr('data-type');
        var data = {
            id : $(this).closest('.insert_columns').find('.weibo_id').val(),
            a_t : $(this).closest('.insert_columns').find('.weibo_a_t').val(),
            idstr : $(this).closest('.social_action').attr('data-idstr'),
            uidstr : $(this).closest('.social_action').attr('data-uidstr'),
            type : type,
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
                that.closest('.weibo_wrap').find('.social_action_ajax_loader').show();
                $.ajax({
                    type : 'POST',
                    data : data,
                    dataType : 'json',
                    url  : social_module_link+'/weibo/operate',
                }).done(function(result){
                    that.closest('.weibo_wrap').find('.social_action_ajax_loader').hide();
                    if(result.success == true)
                        that.closest('.weibo_wrap').find('.social_action_msg').slideDown().delay(5000).slideUp();
                    else 
                        alert(result.msg);             
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
                a_t : $(this).closest('.insert_columns').find('.weibo_a_t').val(),
                idstr : $(this).closest('.weibo_wrap').find('.social_action').attr('data-idstr'),
                type : 'comment'
            }

            var that = $(this);
            $.ajax({
                type : 'POST',
                data : data,
                dataType : 'json',
                url  : social_module_link+'/weibo/operate',
            }).done(function(result){
                if(result.success == true)
                {
                    that.closest('.weibo_wrap').find('.social_action_msg').slideDown().delay(5000).slideUp();
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