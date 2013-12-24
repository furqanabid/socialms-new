<?php if(count($data->statuses)>0){?>
    <?php foreach ($data->statuses as $key => $weibo) {?>
        <div class="social_wrap weibo_wrap clearfix">
            <div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" src="<?=$weibo->user->profile_image_url?>" alt="">
                </a>
                <div class="media-body">
                    <span class="media-heading">
                        <a href="http://www.weibo.com/<?=$weibo->user->profile_url?>" target="_blank">
                            <?=$weibo->user->screen_name?>
                        </a>
                    </span>
                    <div class="text">
                        <?=preg_replace("/(http:\/\/t\.cn\/.{7})/i", "<a href='$1' target='_blank'>$1</a>", $weibo->text)?>
                    </div>
                    <?php if(isset($weibo->original_pic)){?>
                    <a href="<?=$weibo->original_pic?>" target="_blank">
                        <img src="<?=$weibo->thumbnail_pic?>" />
                    </a>
                    <?php }?>
                    <div class="clearfix"></div>
                    <time class="pull-right">
                      <?=date('Y-m-d H:i:s', strtotime($weibo->created_at))?>
                    </time>
                    <div class="clearfix"></div>
                    <?php if(isset($weibo->retweeted_status->id)){ ?>
                        <div class="retweeted_wrap">
                            <a href="http://www.weibo.com/<?=$weibo->retweeted_status->user->profile_url?>" target="_blank">
                                @<?=$weibo->retweeted_status->user->screen_name?>
                            </a>
                            <div class="retweeted_text">
                                <?=preg_replace("/(http:\/\/t\.cn\/.{7})/i", "<a href='$1' target='_blank'>$1</a>", $weibo->retweeted_status->text)?>
                            </div>
                            <?php if(isset($weibo->retweeted_status->original_pic)){?>
                            <a href="<?=$weibo->retweeted_status->original_pic?>" target="_blank">
                                <img src="<?=$weibo->retweeted_status->thumbnail_pic?>" />
                            </a>
                            <?php }?>
                            <div class="clearfix"></div>
                            <time class="pull-left">
                              <?=date('Y-m-d H:i:s', strtotime($weibo->retweeted_status->created_at))?>
                            </time>
                            <div class="clearfix"></div>
                        </div>
                    <?php }?>
                </div>

                <!-- 评论界面 -->
                <textarea class="form-control write_weibo_comment" rows="3" placeholder='输入你的评论，按Enter键提交' style="display:none;"></textarea>
                <!-- 一些操作如评论等 -->
                <div class="pull-right social_action weibo_action" data-idstr="<?=$weibo->idstr?>" data-uidstr="<?=$weibo->user->idstr?>">
                    <a href="javascript:void(0);" data-type='comment' title="评论">
                        <span class="glyphicon glyphicon-comment"></span>
                    </a>
                    <a href="javascript:void(0);" data-type='favorite' title="收藏">
                        <span class="glyphicon glyphicon-star-empty"></span>
                    </a>
                    <a href="javascript:void(0);" data-type='top' title="置顶">
                        <span class="glyphicon glyphicon-open"></span>
                    </a>
                </div>

                <div class="clearfix"></div>
                <div class='pull-right social_action_msg'>操作处理中......</div>
                <div class='pull-right action_info'></div>
                <div class="clearfix"></div>
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