<?php if(count($data->favorites)>0){?>
    <?php foreach ($data->favorites as $key => $weibo) {?>
        <div class="post-column-info social_wrap weibo_wrap clearfix">
            <div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" src="<?=$weibo->status->user->profile_image_url?>" alt="">
                </a>
                <div class="media-body">
                    <span class="media-heading">
                        <a href="http://www.weibo.com/<?=$weibo->status->user->profile_url?>" target="_blank" class="post-column-title">
                            <?=$weibo->status->user->screen_name?>
                        </a>
                    </span>
                    <div class="text post-column-description">
                        <?=$weibo->status->text?>
                    </div>
                    <?php if(isset($weibo->status->original_pic)){?>
                        <a href="<?=$weibo->status->original_pic?>" target="_blank">
                            <img src="<?=$weibo->status->thumbnail_pic?>" class="post-column-image"/>
                        </a>
                    <?php }?>
                    <div class="clearfix"></div>
                    <time class="pull-right">
                      <?=date('Y-m-d H:i:s', strtotime($weibo->status->created_at))?>
                    </time>
                    <div class="clearfix"></div>
                    <?php if(isset($weibo->status->retweeted_status->id)){ ?>
                        <div class="retweeted_wrap">
                            <a href="http://www.weibo.com/<?=$weibo->status->retweeted_status->user->profile_url?>" target="_blank">
                                @<?=$weibo->status->retweeted_status->user->screen_name?>
                            </a>
                            <div class="retweeted_text">
                                <?=$weibo->status->retweeted_status->text?>
                            </div>
                            <?php if(isset($weibo->status->retweeted_status->original_pic)){?>
                                <a href="<?=$weibo->status->retweeted_status->original_pic?>" target="_blank">
                                    <img src="<?=$weibo->status->retweeted_status->thumbnail_pic?>" class="post-column-image"/>
                                </a>
                            <?php }?>
                            <div class="clearfix"></div>
                            <time class="pull-left">
                              <?=date('Y-m-d H:i:s', strtotime($weibo->status->retweeted_status->created_at))?>
                            </time>
                            <div class="clearfix"></div>
                        </div>
                    <?php }?>
                </div>

                <!-- 评论界面 -->
                <textarea class="form-control write_weibo_comment" rows="3" placeholder='输入你的评论，按Enter键提交' style="display:none;"></textarea>
                <!-- 一些操作如评论等 -->
                <div class="pull-right social_action weibo_action" data-idstr="<?=$weibo->status->idstr?>" data-uidstr="<?=$weibo->status->user->idstr?>">
                    <a href="javascript:void(0);" data-type='comment' title="评论">
                        <span class="glyphicon glyphicon-comment"></span>
                    </a>
                    <a href="javascript:void(0);" data-type='unfavorite' title="取消收藏">
                        <span class="glyphicon glyphicon-star"></span>
                    </a>
                    <a href="javascript:void(0);" data-type='unfollow' title="取消关注">
                        <span class="glyphicon glyphicon-eye-close"></span>
                    </a>
                </div>

                <div class="clearfix"></div>
                <div class='pull-right social_action_msg'>操作处理中......</div>
                <div class='pull-right action_info'></div>
                <div class="clearfix"></div>

                <span class="label label-success pull-right post-column" data-type='weibo'>
                    <span class="glyphicon glyphicon-arrow-left"></span> 发布
                </span>
            </div>           
       </div>
       <hr>
    <?php }?>
    
    <div class="more_data">
        <button class="btn btn-default weibo_more" data-page="<?=$page?>">加载更多内容...</button>
    </div>
    
<?php }else{ ?>
没有更多可以显示的数据.
<?php }?>