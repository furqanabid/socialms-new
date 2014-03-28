$(function(){
	// 检查rss
	$('.check_rss').click(function(){
		var rss_url = $.trim($("#SocialRss_url").val());
		if(rss_url == '')
		{
			return;
		}

		var that = $(this);
		that.closest('.form-group').find('.ajax_loader').show();

        // 取消所有的checkbox
        $('input[type="checkbox"]').attr("checked",false);

        $.ajax({
            type : "POST",
            data : {rss : rss_url},
            dataType : "JSON",
            url : admin_root+'/rss/check'
        }).done(function(result){
        	that.closest('.form-group').find('.ajax_loader').hide();
            if(result.success === false)
            {
                // 不合法的rss
                $("#SocialRss_name").val("");
                $('.rss-msg').html('不合法的RSS地址！');
            }
            else if(result.success == "exist")
            {
                // 已经存在的rss
                $("#SocialRss_name").val(result.SocialRss.name);
                $('.rss-msg').html('已经存在数据库的RSS地址！');

                if(result.xref != "")
                {
                    for (var xrefName in result.xref) 
                    { 
                        for (var i in result.xref[xrefName])
                        {
                            $("input[name=\""+xrefName+"\"][value=\""+result.xref[xrefName][i]+"\"]").attr("checked",true);
                        }
                    }
            	}
            }        
            else
            {
                // 新的rss
                $("#SocialRss_name").val(result.title);
                $('.rss-msg').html('可以使用的RSS地址！');
            }
        });
	})
})