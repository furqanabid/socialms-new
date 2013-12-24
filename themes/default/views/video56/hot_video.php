<?php if(count($data->list)>0){?>
    <?php foreach ($data->list as $key => $video56) { ?>
        <div class="social_wrap video56_wrap clearfix">
            <h5 class="title">
                <a href="<?=$video56->swf?>" target="_blank">
                    <?=$video56->title?>
                </a>
            </h5> 
            <div class="video">
                <embed src="<?=$video56->swf?>" type="application/x-shockwave-flash" allowFullScreen="true" width="100%" height="100%" allowNetworking="all" wmode="opaque" allowScriptAccess="always"></embed>
            </div>
            <div class="tag">
                标签：<?=$video56->tag?>
            </div>
        </div>
        <hr>
    <?php }?>
    <div class="more_data">
        <button class="btn btn-default video56_more" data-page="<?=$page?>">加载更多内容...</button>
    </div>
    <input type="hidden" value="<?=$id?>" class='video56_id' />
<?php }else{ ?>
没有更多可以显示的数据.
<?php }?>