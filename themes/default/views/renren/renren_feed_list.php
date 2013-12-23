<?php if(count($data)>0){?>
    <?php foreach ($data as $key => $renren) {?>
       <div class="social_wrap renren_wrap clearfix">
            <div class="media">
                <a class="pull-left" href="#">
                    <img src="<?=$renren->sourceUser->avatar[0]->url?>" />
                </a>
                <div class="media-body">
                    <span class="media-heading">
                        <a href="http://www.renren.com/<?=$renren->sourceUser->id?>/profile" target="_blank">
                            <?=$renren->sourceUser->name?>
                        </a>: 
                        <?=$renren->message?>
                    </span>
                    <div class="media-body-content">
                        <!-- 下面人人有可能发布的一些状态 -->
                        <?php 
                            switch ($renren->type) {
                                case 'SHARE_LINK':
                                case 'SHARE_BLOG':
                                case 'PUBLISH_BLOG':
                                case 'SHARE_PHOTO':
                                case 'PUBLISH_MORE_PHOTO':
                                case 'SHARE_VIDEO':
                                case 'SHARE_ALBUM':
                        ?>
                                    <a href="<?=$renren->resource->url?>" target="_blank">
                                        <?=$renren->resource->title?>
                                    </a>
                                    <div class="c_body_caption">
                                        <?=$renren->resource->content?>
                                    </div>
                        <?php
                                break;
                                
                                case 'UPDATE_STATUS':
                        ?>
                                    更新状态：<?=$renren->resource->content?>
                        <?php
                                break;

                                case 'PUBLISH_ONE_PHOTO':
                        ?>
                                    <a href="<?=$renren->attachment[0]->url?>" target="_blank">
                                        <?=$renren->resource->title?>
                                    </a>
                        <?php
                                break;

                                // 默认
                                default:
                                    echo $renren->type;
                                break;
                            }
                        ?>
                    </div>
                    <time class="pull-right">
                        <?=$renren->time?>
                    </time>

                    <div class="clearfix"></div>  

                    <?php if(count($renren->comments)>0){?>
                        <div class="comment_wrap_div">
                        <?php foreach ($renren->comments as $key => $comment) {?>
                            <div class="comment_wrap">
                                <div class="media">
                                    <a class="pull-left" href="#">
                                        <img src="<?=$comment->author->avatar[0]->url?>">
                                    </a>
                                  <div class="media-body">
                                    <span class="media-heading">
                                        <a href="http://www.renren.com/<?=$comment->author->id?>/profile" target="_blank">
                                            <?=$comment->author->name?>
                                        </a>:
                                        <?=$comment->content?>
                                        <time>
                                            <?=$comment->time?>
                                        </time>
                                    </span>
                                  </div>
                                </div>                               
                            </div>
                        <?php }?>
                        </div>
                    <?php }?> 

                </div>
            </div>

            <textarea class="form-control write_renren_comment" rows="3" placeholder='输入你的评论，按Enter键提交' style="display:none;"></textarea>

            <!-- 一些操作 -->
            <div class="pull-right social_action renren_action" data-entry-ownerid="<?=$renren->sourceUser->id?>" data-entryid="<?=$renren->resource->id?>" data-type="<?=$renren->type?>">
                <a href="javascript:void(0);" data-type='comment' title="评论">
                    <span class="glyphicon glyphicon-comment"></span>
                </a>
                <a href="javascript:void(0);" data-type='like' title="赞">
                    <span class="glyphicon glyphicon-thumbs-up"></span>
                </a>
                <a href="javascript:void(0);" data-type='share' title="分享">
                    <span class="glyphicon glyphicon-share-alt"></span>
                </a>
            </div>

            <div class="clearfix"></div>
            <div class='pull-right social_action_msg'>操作处理中......</div>
            <div class='pull-right action_info'></div>
            <div class="clearfix"></div>
       </div>
       <hr>
    <?php }?>
    
    <div class="more_data">
        <button class="btn btn-default renren_more" data-page="<?=$page?>">加载更多内容...</button>
    </div>

<?php }else{ ?>
没有可以显示的数据.
<?php }?>