$(function(){
    // 添加帐号到column
    $('.video56_add_to_column').click(function(){
        var type = $(this).attr('data-type') || '';
        var that = $(this);
        // 是直接添加video还是从search添加video
        if(type == 'search')
        {
            // 是否存在id,存在说明是从search历史记录中获取的
            var id = $(this).attr('data-id') || '';
            var keywords = $.trim($('.search_video56').val());
            if(keywords == '')
            {
                alert("请输入需要查找视频的关键字");
                return;
            }

            that.closest('.tab-pane').find('.ajax_loader').show();
            var data = {
                keywords : keywords,
                key : 'video56_id',
                social_type : 9,
            }
            
            if(id == '')
            {
                $.ajax({
                    type: "POST",
                    url: root_url+"/video56/addSearch", 
                    data: data,
                    async : false,
                }).done(function(result){
                   if(parseInt(result))
                   {
                        data['id'] = result;
                        data['name'] = data['keywords'];
                   }
                }); 
            }
            else
            {
                data['id'] = id;
                data['name'] = data['keywords'];
            }
        }
        // 从下拉框选择的video类型
        else
        {
            var id = $(this).closest('.video56_wrap').find(".video56_drop_down").val();
            if(id == -1)
            {
                alert("请选择一个需要添加的视频类型");
                return;
            }

            that.closest('.tab-pane').find('.ajax_loader').show();
            var data = {
                id : id,
                key : 'video56_id',
                social_type : 9,
                name : $.trim($(this).closest('.video56_wrap').find('.video56_drop_down option:selected').html()),
            }
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
                addNewColumnToPage(columnId, 'video56', data.id, data.name);
                that.closest('.tab-pane').find('.ajax_loader').hide();
            }
        }); 
    })

    // 获取更多的内容，相当于分页
    $(document).on('click','.video56_more',function(){
        var url;
        var data = {
            id : $(this).closest('.insert_columns').attr('data-social-account'),
            page : $(this).attr('data-page')
        }

        var that = $(this);
        that.html("加载中，请稍后......");
  
        // 发送数据
        $.ajax({
            type : 'POST',
            data : data,
            dataType : 'html',
            url  : root_url+'/video56/parse'
        }).done(function(result){
            that.hide();
            that.closest('.column_container').append(result);
        })
    })

    /**
     * 删除相应的搜索历史
     * @return {[type]} [description]
     */
    $('.video56_search_del').click(function(){
        var id = $(this).closest('.video56_wrap').find(".video56_drop_down").val();
        var that = $(this);
        if(id == -1)
        {
            alert("请选择需要删除的历史记录");
            return;
        }

        that.closest('.tab-pane').find('.ajax_loader').show();
        $.ajax({
            type : 'post',
            data : {id : id},
            dataType : 'json',
            url : root_url+'/video56/delSearch',
        }).done(function(result){
            that.closest('.tab-pane').find('.ajax_loader').hide();
            if(result.success === true)
            {
                that.closest('.video56_wrap').find(".video56_drop_down option:selected").remove();

                // 如果帐号已经被添加到Column,则删除已经存在的Column
                if($('.video56_'+id).length > 0)
                {
                    $('.video56_'+id).each(function(){
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

    // 搜索历史的选取
    $('.video56_search_drop_down').change(function(){
        var keywords = $.trim($('.video56_search_drop_down option:selected').text());
        $('.search_video56').val(keywords);

        var id = $(this).val();
        $(this).closest('.video56_wrap').find('.video56_add_to_column').attr('data-id',id);
    })

    $('.search_video56').keypress(function(){
         $(this).closest('.video56_wrap').find('.video56_add_to_column').removeAttr('data-id');
    })
})