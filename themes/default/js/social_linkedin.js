$(function(){
    // 添加一个linkedin帐号到column
    $('.linkedin_add_to_column').click(function(){
        var id = $("#linkedin_drop_down").val();
        if(id == -1)
        {
            alert("请选择一个Linkedin帐号");
            return;
        }
        $('.linkedin_ajax_loader').show();

        var data = {
            id : id,
            Name : $.trim($('#linkedin_drop_down option:selected').text()),
        }

        $.ajax({
            type: "POST",
            url: social_module_link+"/linkedin/addColumn", 
            data: data,
        }).done(function(result){
            if(parseInt(result))
            {
                var columnId = parseInt(result);
                // 添加列
                addNewColumnToPage(columnId, 'linkedin', data.id, data.Name);
                $('.linkedin_ajax_loader').hide();
            }
        }); 
    })

    // 删除一个linkedin帐号
    $('.linkedin_account_del').click(function(){
        var id = $('#linkedin_drop_down').val();
        if(id == -1)
        {
            alert('请选择一个需要删除的Linkedin帐号');
            return;
        }

        if(!confirm('您真的要删除这个Linkedin帐号吗？'))
            return;

        $('.linkedin_ajax_loader').show();
        $.ajax({
            type : 'POST',
            data : {id : id},
            url : social_module_link+"/linkedin/delAccount"
        }).done(function(result){
            if(result == 1)
            {
                $('#linkedin_drop_down option:selected').remove();
                $('.linkedin_ajax_loader').hide();

                 // 删除已经存在的Column
                var sectionId = $('.linkedin_'+id).attr('id') || '';
                if(sectionId != '')
                {
                    var columnId = sectionId.replace('column_','');
                    $('.delete_column_'+columnId).trigger('click', [true]);
                }
            }   
            else
                alert('Linkedin帐号删除失败，请联系管理员');
        });
    })

    // linkedin Tab的点击
    $(document).on('click','.linkedinTab',function(){
        // 高亮tab
        $(this).siblings().removeClass('currentTabSelected').end().addClass('currentTabSelected');

        var id = $(this).closest('.insert_columns').find('.linkedin_id').val();
        var access_token = $(this).closest('.insert_columns').find('.linkedin_a_t').val();
        var data = {
            id : id,
            a_t : access_token
        }
        var that = $(this);
        that.closest('.insert_columns').find('.holder_content').html("<img class='ajax_loader' src='"+statics_assets+"/images/ajax-loader.gif' />");

        // 获取到的是linkedin关注的公司动态
        if($(this).hasClass('linkedin_company_update'))
        {
            $.ajax({
                type: "POST",
                url: social_module_link+"/linkedin/parseLinkedin", 
                dataType : 'html',
                data: data,
            }).done(function(result){
                that.closest('.insert_columns').find('.holder_content').html(result);
            }); 
        }
        // 获取到的是我的linkedin帐号的最近动态
        else if($(this).hasClass('linkedin_my_update'))
        {
            $.ajax({
                type: "POST",
                url: social_module_link+"/linkedin/myUpdates", 
                dataType : 'html',
                data: data,
            }).done(function(result){
                that.closest('.insert_columns').find('.holder_content').html(result);
            }); 
        }
    })

    // 获取更多的Flickr内容，相当于分页
    $(document).on('click','.linkedin_more',function(){
        var data = {
            id : $(this).closest('.insert_columns').find('.linkedin_id').val(),
            a_t : $(this).closest('.insert_columns').find('.linkedin_a_t').val(),
            page : $(this).attr('data-page'),
            total : $(this).attr('data-total'),
        }

        var that = $(this);
        that.html("<img class='ajax_loader' src='"+statics_assets+"/images/ajax-loader.gif' />");
        // 公司动态
        if(that.closest('.insert_columns').find('.currentTabSelected').hasClass('linkedin_company_update'))
        {
            $.ajax({
                type : 'POST',
                data : data,
                dataType : 'html',
                url  : social_module_link+'/linkedin/parseLinkedin',
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
                url  : social_module_link+'/linkedin/myUpdates',
            }).done(function(result){
                that.hide();
                that.closest('.holder_content').append(result);
            })
        }
    })

})