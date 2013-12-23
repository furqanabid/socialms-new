<?php 
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/prototype_column.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/social_function.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/social.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/social_rss.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/social_instagram.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/social_pinterest.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/social_flickr.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/social_linkedin.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/social_reddit.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/social_renren.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/social_weibo.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/social_video56.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/social_youku.js', CClientScript::POS_END);
?>


<!-- 用户的视图 -->
<header id="tabview">
    <!-- 我的视图 -->
    <span class="myview">
        <?php foreach ($userViews as $key => $user_view) { ?>
            <a href="#" class="change_view_button view_btn_<?=$user_view['id']?> <?=($user_view['is_active']==1)?'view_active':'';?>" data-id="<?=$user_view['id']?>"><?=$user_view['name']?></a>
        <?php }?>
    </span>
    <!-- 视图的操作 -->
    <span class="dropdown view_operate">
        <a href="javascript:void(0);" class="add_view">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
        <div class="dropdown-menu view_container">        
            <div>您所有的视图：</div>
            <select name="view_id" class="form-control select_view" >
                <?php foreach ($userViews as $key => $val) {?>
                    <option value="<?=$val['id']?>"><?=$val['name']?></option>
                <?php } ?>
            </select>                
            <div style="margin-top:5px;">                                                            
                <button type="button" class="btn btn-sm btn-primary add_new_view">新增</button>
                <button type="button" class="btn btn-sm btn-danger del_view">删除</button>
            </div>           
            <div style="display:none;margin-top:5px;" class="new_view_input">          
                <input type="text" class="add_view_name">
                <button type="button" class="btn btn-sm btn-success save_view_name">保存</button>
            </div>   
        </div>
    </span>
</header>

<!-- 内容区域 -->
<div id="scrollable_columns" class="clearfix">
    <div id="page_wrap">
        <section id="vertical_sidebar">
            <!-- Social Icon Navigation -->
            <nav class="siderbar_nav">
                <ul class="nav nav-tabs" id="navigation_tab">
                   <!--  <li class="active rss">
                        <a href="#rss" class="social_icons" data-toggle="tab"></a>
                    </li> -->
                    <li class="instagram active">
                        <a href="#instagram" class="social_icons" data-toggle="tab"></a>
                    </li>
                    <li class="pinterest">
                        <a href="#pinterest" class="social_icons" data-toggle="tab"></a>
                    </li>
                    <li class="flickr">
                        <a href="#flickr" class="social_icons" data-toggle="tab"></a>
                    </li>
                    <li class="linkedin">
                        <a href="#linkedin" class="social_icons" data-toggle="tab"></a>
                    </li>
                    <li class="reddit">
                        <a href="#reddit" class="social_icons" data-toggle="tab"></a>
                    </li>
                    <li class="renren">
                        <a href="#renren" class="social_icons" data-toggle="tab"></a>
                    </li>
                    <li class="weibo">
                        <a href="#weibo" class="social_icons" data-toggle="tab"></a>
                    </li>
                    <li class="video56">
                        <a href="#video56" class="social_icons" data-toggle="tab"></a>
                    </li>
                    <li class="youku">
                        <a href="#youku" class="social_icons" data-toggle="tab"></a>
                    </li>
                </ul>
            </nav>
            <div class="tab-content siderbar_content">

                <!-- Instagram -->
                <div class="tab-pane active" id="instagram">
                    <div class="column_title">
                        <img src="<?=$this->assets_img?>/social-icons/instagram.png" />
                        Instagram
                    </div>
                    <div class="social_wrap_div">
                        <img class='ajax_loader' src='<?=$this->assets_img?>/ajax-loader.gif' />
                        <div class="select_div">
                            <select class="form-control social_select" id="instagram_drop_down">
                                <option value="-1">请选择您的Instagram帐号</option>
                                <!-- 调用widget显示Instagram帐号 -->
                                <?php $this->widget('socialAccount', array(
                                    'table'=>'xz_social_instagram',
                                    'name' => 'instagram_username'
                                ));?>
                            </select>
                        </div>
                        <div class="button_div">
                            <a type="button" href="<?=INSTAGRAM_AUTH_URI?>" class="btn btn-sm btn-primary">新增账号</a>
                            <a type="button" class="btn btn-sm btn-success instagram_add_to_column">添加到浏览列</a>
                            <a type="button" class="btn btn-sm btn-danger instagram_account_del">删除账号</a>
                        </div>
                    </div>
                </div>

                <!-- Pinterest -->
                <div class="tab-pane" id="pinterest">
                   <div class="column_title">
                        <img src="<?=$this->assets_img?>/social-icons/pinterest.png" />
                           Pinterest
                   </div>
                   <div class="social_wrap_div">
                        <img class='ajax_loader' src='<?=$this->assets_img?>/ajax-loader.gif' />
                        <div class="select_div">
                            <select class="form-control social_select" id="pinterest_drop_down">
                                <option value='-1'>请选择您的Pinterest帐号</option>
                                <!-- 调用widget显示Pinterest帐号 -->
                                <?php $this->widget('socialAccount', array(
                                    'table'=>'xz_social_pinterest',
                                    'name' => 'name'
                                ));?>
                            </select>
                        </div>
                        <div class="button_div">
                            <a type="button" class="btn btn-sm btn-primary pinterest_new_account">新增账号</a>
                            <a type="button" class="btn btn-sm btn-success pinterest_add_to_column">添加到浏览列</a>
                            <a type="button" class="btn btn-sm btn-danger pinterest_account_del">删除账号</a>
                        </div>
                        <div class="pinterest_account_div" style="display:none;">
                            <hr>
                            <h5>添加新Pinterest用户</h5>
                            <input type="text" class="form-control pinterest_username" placeholder="Pinterest用户名">
                            <a type="button" class="btn btn-primary pinterest_account_add">提交</a>
                        </div>
                    </div>
                </div>

                <!-- Flickr -->
                <div class="tab-pane" id="flickr">
                   <div class="column_title">
                        <img src="<?=$this->assets_img?>/social-icons/flickr.png" />
                           Flickr
                   </div>
                   <div class="social_wrap_div">
                        <img class='ajax_loader' src='<?=$this->assets_img?>/ajax-loader.gif' />
                        <div class="select_div">
                            <select class="form-control social_select" id="flickr_drop_down">
                                <option value='-1'>请选择您的Flickr帐号</option>
                                <!-- 调用widget显示Flickr帐号 -->
                                <?php $this->widget('socialAccount', array(
                                    'table'=>'xz_social_flickr',
                                    'name' => 'flickr_username'
                                ));?>
                            </select>
                        </div>
                        <div class="button_div">
                            <a type="button" class="btn btn-sm btn-primary" href="<?=FLICKR_AUTH_URI?>">新增账号</a>
                            <a type="button" class="btn btn-sm btn-success flickr_add_to_column">添加到浏览列</a>
                            <a type="button" class="btn btn-sm btn-danger flickr_account_del">删除账号</a>
                        </div>
                    </div>
                </div>

                <!-- Linkedin -->
                <div class="tab-pane" id="linkedin">
                   <div class="column_title">
                        <img src="<?=$this->assets_img?>/social-icons/linkedin.png" />
                           Linkedin
                   </div>
                   <div class="social_wrap_div">
                        <img class='ajax_loader' src='<?=$this->assets_img?>/ajax-loader.gif' />
                        <div class="select_div">
                            <select class="form-control social_select" id="linkedin_drop_down">
                                <option value='-1'>请选择您的Linkedin帐号</option>
                                <!-- 调用widget显示帐号 -->
                                <?php $this->widget('socialAccount', array(
                                    'table'=>'xz_social_linkedin',
                                    'name' => 'linkedin_username'
                                ));?>
                            </select>
                        </div>
                        <div class="button_div">
                            <a type="button" class="btn btn-sm btn-primary" href="<?=LINKEDIN_AUTH_URI?>">新增账号</a>
                            <a type="button" class="btn btn-sm btn-success linkedin_add_to_column">添加到浏览列</a>
                            <a type="button" class="btn btn-sm btn-danger linkedin_account_del">删除账号</a>
                        </div>
                    </div>
                </div>

                <!-- Reddit -->
                <div class="tab-pane" id="reddit">
                   <div class="column_title">
                        <img src="<?=$this->assets_img?>/social-icons/reddit.png" />
                           Reddit
                   </div>
                   <div class="social_wrap_div">
                        <img class='ajax_loader' src='<?=$this->assets_img?>/ajax-loader.gif' />
                        <div class="select_div">
                            <select class="form-control social_select" id="reddit_drop_down">
                                <option value='-1'>请选择您的Reddit帐号</option>
                                <!-- 调用widget显示帐号 -->
                                <?php $this->widget('socialAccount', array(
                                    'table'=>'xz_social_reddit',
                                    'name' => 'reddit_name'
                                ));?>
                            </select>
                        </div>
                        <div class="button_div">
                            <a type="button" class="btn btn-sm btn-primary" href="<?=REDDIT_AUTH_URI?>">新增账号</a>
                            <a type="button" class="btn btn-sm btn-success reddit_add_to_column">添加到浏览列</a>
                            <a type="button" class="btn btn-sm btn-danger reddit_account_del">删除账号</a>
                        </div>
                    </div>
                </div>

                <!-- renren -->
                <div class="tab-pane" id="renren">
                   <div class="column_title">
                        <img src="<?=$this->assets_img?>/social-icons/renren.png" />
                           人人网
                   </div>
                   <div class="social_wrap_div">
                        <img class='ajax_loader' src='<?=$this->assets_img?>/ajax-loader.gif' />
                        <div class="select_div">
                            <select class="form-control social_select" id="renren_drop_down">
                                <option value='-1'>请选择您的renren帐号</option>
                                <!-- 调用widget显示帐号 -->
                                <?php $this->widget('socialAccount', array(
                                    'table'=>'xz_social_renren',
                                    'name' => 'renren_username'
                                ));?>
                            </select>
                        </div>
                        <div class="button_div">
                            <a type="button" class="btn btn-sm btn-primary" href="<?=RENREN_AUTH_URI?>">新增账号</a>
                            <a type="button" class="btn btn-sm btn-success renren_add_to_column">添加到浏览列</a>
                            <a type="button" class="btn btn-sm btn-danger renren_account_del">删除账号</a>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <span id="main_div_for_inserting_columns">
            
        </span>
    </div>
</div>


<!-- 如果用户添加过column,输出存在的column -->
<?php
if(count($userColumns)>0)
{
    $str = '';
    foreach ($userColumns as $key => $val) 
    {
        // Social 类型
        switch ($val['social_type']) 
        {
            // Rss
            case xzModel::SOCIAL_RSS:
                $str .= '<input type="hidden" class="loaded_column" value="'.$val['id'].'" data-type="rss"/>
                    <input type="hidden" class="rss_masterid_'.$val['id'].'" value="'.$val['rss_master_id'].'" />
                    <input type="hidden" class="rss_name_'.$val['id'].'" value="'.$val['rss_name'].'" />';
            break;
            
            // Instagram
            case xzModel::SOCIAL_INSTAGRAM:
                $str .= '<input type="hidden" class="loaded_column" value="'.$val['id'].'" data-type="instagram"/>
                        <input type="hidden" class="instagram_id_'.$val['id'].'" value="'.$val['instagram_id'].'" />'; 
            break;

            // Pinterest
            case xzModel::SOCIAL_PINTEREST:
                $str .= '<input type="hidden" class="loaded_column" value="'.$val['id'].'" data-type="pinterest"/>
                        <input type="hidden" class="pinterest_id_'.$val['id'].'" value="'.$val['pinterest_id'].'" /> ';
            break;

            // Flickr
            case xzModel::SOCIAL_FLICKR:
                $str .= '<input type="hidden" class="loaded_column" value="'.$val['id'].'" data-type="flickr"/>
                    <input type="hidden" class="flickr_id_'.$val['id'].'" value="'.$val['flickr_id'].'" />';
            break;

            // Linkedin
            case xzModel::SOCIAL_LINKEDIN:
                $str .= '<input type="hidden" class="loaded_column" value="'.$val['id'].'" data-type="linkedin"/>
                    <input type="hidden" class="linkedin_id_'.$val['id'].'" value="'.$val['linkedin_id'].'" />';
            break;

            // Reddit
            case xzModel::SOCIAL_REDDIT:
                $str .= '<input type="hidden" class="loaded_column" value="'.$val['id'].'" data-type="reddit"/>
                    <input type="hidden" class="reddit_id_'.$val['id'].'" value="'.$val['reddit_id'].'" />';
            break;

            // 人人网
            case xzModel::SOCIAL_RENREN:
                $str .= '<input type="hidden" class="loaded_column" value="'.$val['id'].'" data-type="renren"/>
                    <input type="hidden" class="renren_id_'.$val['id'].'" value="'.$val['renren_id'].'" />';
            break;

            // 新浪微博
            case xzModel::SOCIAL_WEIBO:
                $str .= '<input type="hidden" class="loaded_column" value="'.$val['id'].'" data-type="weibo"/>
                    <input type="hidden" class="weibo_id_'.$val['id'].'" value="'.$val['weibo_id'].'" />';
            break;

            // 56视频
            case xzModel::SOCIAL_VIDEO56:
                $str .= '<input type="hidden" class="loaded_column" value="'.$val['id'].'" data-type="video56"/>
                    <input type="hidden" class="video56_id_'.$val['id'].'" value="'.$val['video56_id'].'" />';
            break;

            // 优酷视频
            case xzModel::SOCIAL_YOUKU:
                $str .= '<input type="hidden" class="loaded_column" value="'.$val['id'].'" data-type="youku"/>
                    <input type="hidden" class="youku_id_'.$val['id'].'" value="'.$val['youku_id'].'" />';
            break;
        }
    }
    echo $str;
}
?>
