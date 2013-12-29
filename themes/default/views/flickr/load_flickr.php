<?php if(count($flickr->photo)>0) {?>
    <?php foreach ($flickr->photo as $key => $data) { ?>
        <div class="social_wrap flickr_wrap clearfix">
            <a href="http://www.flickr.com/photos/<?=$data->owner?>/<?=$data->id?>" target="_blank">
                <img src="http://farm<?=$data->farm?>.staticflickr.com/<?=$data->server?>/<?=$data->id?>_<?=$data->secret?>.jpg" class="img-responsive flickr_img"/>
            </a>

            <div class="photo_name">
                <?=$data->title?>
            </div>


            <textarea class="form-control write_flickr_comment" rows="3" placeholder="请写入你的留言，按Enter键提交"></textarea>
           

            <div class="pull-right social_action flickr_action" data-photoid="<?=$data->id?>">
                <a href="javascript:void(0);" data-type='comment' title="留言">
                    <span class="glyphicon glyphicon-comment"></span>
                </a>
                <a href="javascript:void(0);" data-type='like' title="喜欢">
                    <span class="glyphicon glyphicon-star-empty"></span>
                </a>
                <a href="javascript:void(0);" data-type='unfollow' title="取消关注">
                    <span class="glyphicon glyphicon-eye-close"></span>
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
        <button class="btn btn-default flickr_more" data-page="<?=$page?>" data-pages="<?=$flickr->pages?>">加载更多内容...</button>
    </div>
    
<?php }else{?>
    没有更多可以显示的内容.
<?php }?>