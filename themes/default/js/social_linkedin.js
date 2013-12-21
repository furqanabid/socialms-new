$(function(){
    // 添加一个linkedin帐号到column
    $('.linkedin_add_to_column').click(function(){
        var id = $("#linkedin_drop_down").val();
        var that = $(this);
        if(id == -1)
        {
            alert("请选择一个Linkedin帐号");
            return;
        }
        that.closest('.tab-pane').find('.ajax_loader').show();

        // SocialType的值具体查看xzModel文件
        var data = {
            id : id,
            key : 'linkedin_id',
            social_type : 5,
            Name : $.trim($('#linkedin_drop_down option:selected').text()),
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
                addNewColumnToPage(columnId, 'linkedin', data.id, data.Name);
                that.closest('.tab-pane').find('.ajax_loader').hide();
            }
        }); 
    })

    // 删除一个linkedin帐号
    $('.linkedin_account_del').click(function(){
        var id = $('#linkedin_drop_down').val();
        var that = $(this);
        if(id == -1)
        {
            alert('请选择一个需要删除的Linkedin帐号');
            return;
        }

        if(!confirm('您真的要删除这个Linkedin帐号吗？'))
            return;

        that.closest('.tab-pane').find('.ajax_loader').show();
        $.ajax({
            type : 'POST',
            data : {id : id},
            dataType : 'json',
            url : root_url+"/linkedin/del"
        }).done(function(result){
            if(result.success === true)
            {
                $('#linkedin_drop_down option:selected').remove();
                that.closest('.tab-pane').find('.ajax_loader').hide();

                // 如果帐号已经被添加到Column,则删除已经存在的Column
                if($('.linkedin_'+id).length > 0)
                {
                    $('.linkedin_'+id).each(function(){
                        var sectionId = $(this).attr('id');
                        var columnId = sectionId.replace('column_','');
                        $('.delete_column_'+columnId).trigger('click', [true]);
                    });
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

        var url;
        var id = $(this).closest('.insert_columns').attr('data-social-account');
        var data = {id : id};

        var that = $(this);
        that.closest('.insert_columns').find('.column_container').html("加载中，请稍后......");

        // 获取到的是linkedin关注的公司动态
        if($(this).hasClass('company'))
        {
            url = root_url+'/linkedin/parse/tab/company';
        }
        // 获取到的是我的linkedin帐号的最近动态
        else if($(this).hasClass('myupdate'))
        {
            url = root_url+'/linkedin/parse/tab/myupdate';
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

    // 获取更多的Flickr内容，相当于分页
    $(document).on('click','.linkedin_more',function(){
        var url;
        var data = {
            id : $(this).closest('.insert_columns').attr('data-social-account'),
            page : $(this).attr('data-page'),
        }

        var that = $(this);
        that.html("加载中......");

        // 公司动态
        if(that.closest('.insert_columns').find('.currentTabSelected').hasClass('company'))
        {
            url = root_url+'/linkedin/parse/tab/company';
        }
        else
        {
            url = root_url+'/linkedin/parse/tab/myupdate';
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