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
							<li class='social_menu_tabs instagramTab currentTabSelected instagram_most_recent'>我的首页</div> \
							<li class='social_menu_tabs instagramTab instagram_most_popular'>最近流行</div> \
							<li class='social_menu_tabs instagramTab instagram_my_post'>我的发布</div> \
						</ul>";
		break;

        // Pinterest
        case "pinterest":
            icon = "<img src='"+root_img +"/social-icons/Pinterest.png' />";
        break;

        // Flickr
        case "flickr":
            icon = "<img src='"+root_img +"/social-icons/Flickr.png' />";
            socialTab = "<ul  class='social_feeds_tabs clearfix'> \
                            <li class='social_menu_tabs flickrTab currentTabSelected flickr_most_recent'>首页图片</div> \
                            <li class='social_menu_tabs flickrTab flickr_most_interestingness'>发掘图片</div> \
                            <li class='social_menu_tabs flickrTab flickr_my_post'>我的图片</div> \
                        </ul>";
        break;

        // Linkedin
        case "linkedin":
            icon = "<img src='"+root_img +"/social-icons/LinkedIn.png' />";
            socialTab = "<ul  class='social_feeds_tabs clearfix'> \
                            <li class='social_menu_tabs linkedinTab currentTabSelected linkedin_company_update'>公司动态</div> \
                            <li class='social_menu_tabs linkedinTab linkedin_my_update'>我的动态</div> \
                        </ul>";
        break;

         // Reddit
        case "reddit":
            icon = "<img src='"+root_img +"/social-icons/Reddit.png' />";
            socialTab = "<ul  class='social_feeds_tabs clearfix'> \
                            <li class='social_menu_tabs redditTab currentTabSelected reddit_new'>最新新闻</div> \
                            <li class='social_menu_tabs redditTab reddit_hot'>热门新闻</div> \
                            <li class='social_menu_tabs redditTab reddit_controversial'>热议新闻</div> \
                            <li class='social_menu_tabs redditTab reddit_saved'>已保存</div> \
                        </ul>";
        break;

         // 人人网
        case "renren":
            icon = "<img src='"+root_img +"/social-icons/renren.png' />";
            socialTab = "<ul  class='social_feeds_tabs clearfix'> \
                            <li class='social_menu_tabs renrenTab currentTabSelected renren_home'>首页动态</div> \
                            <li class='social_menu_tabs renrenTab renren_status'>我的状态</div> \
                            <li class='social_menu_tabs renrenTab renren_share'>我的分享</div> \
                        </ul>";
        break;

         // 新浪微博
        case "weibo":
            icon = "<img src='"+root_img +"/social-icons/weibo.png' />";
            socialTab = "<ul  class='social_feeds_tabs clearfix'> \
                            <li class='social_menu_tabs weiboTab currentTabSelected weibo_home_timeline'>首页动态</div> \
                            <li class='social_menu_tabs weiboTab weibo_user_timeline'>个人主页</div> \
                            <li class='social_menu_tabs weiboTab weibo_favorites'>我的收藏</div> \
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

	var columnHtml = "<section class='insert_columns "+socialType+"_"+socialAccountId+"' id='column_"+columnId+"'>"+
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
							      	"<li class='delete_column_"+columnId+"'>"+ 
							      		"<a href='javascript:void(0)'><span class='glyphicon glyphicon-remove'></span> 删除</a>"+
							      	"</li>"+
							    "</ul>"+
							"</div>"+
						"</div>"+
						socialTab + 
						"<div class='column_container_wrap "+holderTop+"'>"+	 
							"<div class='column_container holder_column_"+columnId+"'>"+							
								"<img src='"+root_img +"/ajax-loader.gif' />"+						
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
function addNewColumnToPage(columnId, socialType, socialAccountId, title)
{
    if(columnId == undefined || columnId == "")
    {
        alert("Column的Id值不存在");
        return;
    }

    if(title ==  undefined || title == "")
    {
        alert("Column的名字不存在");
        return;
    }

    var bulidHtml = buildColumn(columnId, socialAccountId, socialType, title);
    $('#main_div_for_inserting_columns').prepend(bulidHtml);

    // 获取column的内容
    var columnObj = new socialColumnAccount(columnId, socialType, title);
    columnObj.id = socialAccountId;
    columnObj.display();  

    // 绑定refresh和delete
    $('.refresh_column_'+columnId).on('click',function(){
        columnObj.refresh();
    });
    $('.delete_column_'+columnId).on('click',function(event, noComfirm){
        columnObj.delete(noComfirm);
    });
}