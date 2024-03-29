// All js is for social type function

/**
 * 生成每一个column的界面
 * @param  {[type]} columnId        [Column的id]
 * @param  {[type]} socialAccountId [每一种社交类型的id]
 * @param  {[type]} socialType      [社交类型]
 * @param  {[type]} title           [标题]
 * @return {[type]}                 [description]
 */
function buildColumn(columnId, socialAccountId, socialType, title)
{
	var icon, socialTab='', holderTop='';
    var showOrHide='';
    if(view_type == 1)
    {
        showOrHide = "style='display:none;'";
    }

	switch(socialType)
	{
        // Rss
		case "rss":
			icon = "<img src='"+root_img +"/social-icons/rss.png' />";
		break;

        // Instagram
		case "instagram":
			icon = "<img src='"+root_img +"/social-icons/instagram.png' />";
			socialTab = "<ul  class='social_feeds_tabs clearfix'> \
							<li class='social_menu_tabs instagramTab currentTabSelected recent'>我的首页</div> \
							<li class='social_menu_tabs instagramTab popular'>最近流行</div> \
							<li class='social_menu_tabs instagramTab mypost'>我的发布</div> \
						</ul>";
		break;

        // Pinterest
        case "pinterest":
            icon = "<img src='"+root_img +"/social-icons/pinterest.png' />";
        break;

        // Flickr
        case "flickr":
            icon = "<img src='"+root_img +"/social-icons/flickr.png' />";
            socialTab = "<ul  class='social_feeds_tabs clearfix'> \
                            <li class='social_menu_tabs flickrTab currentTabSelected recent'>首页图片</div> \
                            <li class='social_menu_tabs flickrTab interest'>发掘图片</div> \
                            <li class='social_menu_tabs flickrTab mypost'>我的图片</div> \
                        </ul>";
        break;

        // Linkedin
        case "linkedin":
            icon = "<img src='"+root_img +"/social-icons/linkedIn.png' />";
            socialTab = "<ul  class='social_feeds_tabs clearfix'> \
                            <li class='social_menu_tabs linkedinTab currentTabSelected company'>公司动态</div> \
                            <li class='social_menu_tabs linkedinTab myupdate'>我的动态</div> \
                        </ul>";
        break;

         // Reddit
        case "reddit":
            icon = "<img src='"+root_img +"/social-icons/reddit.png' />";
            socialTab = "<ul  class='social_feeds_tabs clearfix'> \
                            <li class='social_menu_tabs redditTab currentTabSelected new'>最新新闻</div> \
                            <li class='social_menu_tabs redditTab hot'>热门新闻</div> \
                            <li class='social_menu_tabs redditTab controversial'>热议新闻</div> \
                            <li class='social_menu_tabs redditTab saved'>已保存</div> \
                        </ul>";
        break;

         // 人人网
        case "renren":
            icon = "<img src='"+root_img +"/social-icons/renren.png' />";
            socialTab = "<ul  class='social_feeds_tabs clearfix'> \
                            <li class='social_menu_tabs renrenTab currentTabSelected recent'>首页动态</div> \
                            <li class='social_menu_tabs renrenTab status'>我的状态</div> \
                            <li class='social_menu_tabs renrenTab share'>我的分享</div> \
                        </ul>";
        break;

         // 新浪微博
        case "weibo":
            icon = "<img src='"+root_img +"/social-icons/weibo.png' />";
            socialTab = "<ul  class='social_feeds_tabs clearfix'> \
                            <li class='social_menu_tabs weiboTab currentTabSelected home'>首页动态</div> \
                            <li class='social_menu_tabs weiboTab user'>个人主页</div> \
                            <li class='social_menu_tabs weiboTab favorite'>我的收藏</div> \
                        </ul>";
        break;

        // 56视频
        case "video56":
            icon = "<img src='"+root_img +"/social-icons/video56.png' />";
        break;

        // 优酷视频
        case "youku":
            icon = "<img src='"+root_img +"/social-icons/youku.png' />";
            socialTab = "<ul class='social_feeds_tabs clearfix'> \
                            <li class='social_menu_tabs youkuTab currentTabSelected youku_category'>最新热门</div> \
                            <li class='social_menu_tabs youkuTab youku_show'>热门电视剧</div> \
                            <li class='social_menu_tabs youkuTab youku_favorite'>我的收藏</div> \
                        </ul>";
        break;
	}

	// 如果存在tab,则新增加一个类holdertop
	if(socialTab != '')
		holderTop = 'holdertop';

	var columnHtml = "<section "+showOrHide+" class='insert_columns "+socialType+"_"+socialAccountId+"' id='column_"+columnId+"' data-social-account='"+socialAccountId+"'>"+
						"<div class='column_title'>"+
							"<span class='column_title_tab_name'>"+icon+" "+title+"</span>"+
							"<div class='dropdown pull-right column_configuration_dropdown'>"+
								"<a href='#' class='dropdown-toggle column_configuration_a' data-toggle='dropdown' >"+
									"<span class='glyphicon glyphicon-cog'></span>"+
								"</a>"+
								"<ul class='dropdown-menu'>"+
							      	"<li class='refresh_column_"+columnId+"'>"+ 
							      		"<a href='javascript:void(0)'><span class='glyphicon glyphicon-refresh'></span> 刷新</a>"+
							      	"</li>"+
                                    "<li class='expand_column_"+columnId+"'>"+ 
                                        "<a href='javascript:void(0)'><span class='glyphicon glyphicon-arrow-right'></span> 扩大</a>"+
                                    "</li>"+
                                    "<li class='reduce_column_"+columnId+"'>"+ 
                                        "<a href='javascript:void(0)'><span class='glyphicon glyphicon-arrow-left'></span> 缩小</a>"+
                                    "</li>"+
							      	"<li class='delete_column_"+columnId+"'>"+ 
							      		"<a href='javascript:void(0)'><span class='glyphicon glyphicon-remove'></span> 删除</a>"+
							      	"</li>"+
							    "</ul>"+
							"</div>"+
						"</div>"+
						socialTab + 
						"<div class='column_container_wrap "+holderTop+"'>"+	 
							"<div class='column_container holder_column_"+columnId+"'>"+							
								"加载中，请稍后......"+						
							"</div>"+
					    "</div>"+
					"</section>";

	return columnHtml;
}

/**
 * [addNewColumnToPage 添加一个column到页面上]
 * @param {[type]} columnId        [description]
 * @param {[type]} socialType      [description]
 * @param {[type]} socialAccountId [description]
 * @param {[type]} title           [description]
 */
function addNewColumnToPage(columnId, socialType, socialAccountId, title, widthSize)
{
    if(columnId == undefined || columnId == "")
    {
        alert("Column的Id值不存在");
        return;
    }

    if(title ==  undefined || title == "")
    {
       title = '已被删除帐号的列';
    }

    var bulidHtml = buildColumn(columnId, socialAccountId, socialType, title);
    $('#main_div_for_inserting_columns').prepend(bulidHtml);

    // 更新column的宽度
    var widthSize = widthSize || 1;
    $('#column_'+columnId).css({width : 320*widthSize});

    // 获取column的内容
    var columnObj = new socialColumnAccount(columnId, socialType, title);
    columnObj.id = socialAccountId;
    columnObj.display();  


    // 绑定刷新事件
    $('.refresh_column_'+columnId).on('click',function(){
        columnObj.refresh();
    });
    // 绑定删除事件
    $('.delete_column_'+columnId).on('click',function(event, noComfirm){
        columnObj.delete(noComfirm);
    });
    // 绑定column的扩大事件
    $('.expand_column_'+columnId).on('click',function(){
        columnObj.expand();
    });  
    // 绑定column的缩小事件
    $('.reduce_column_'+columnId).on('click',function(){
        columnObj.reduce();
    });
}