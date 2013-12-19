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
                        <img src="<?=$this->assets_img?>/social-icons/Instagram.png" />
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
            </div>
        </section>
        <span id="main_div_for_inserting_columns">
            
        </span>
    </div>
</div>

