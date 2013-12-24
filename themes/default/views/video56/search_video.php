<?php if(count($data)>0){ ?>
    <?php 
    foreach ($data as $key => $video56) 
    { 
        if($key == 'total')
            continue;
    ?>
        <div class="social_wrap video56_wrap clearfix">
            <h5 class="title">
                <a href="http://player.56.com/<?=VIDEO56_API_KEY.'/open_'.$video56->id.'.swf'?>" target="_blank">
                    <?=$video56->title?>
                </a> 
            </h5> 
            <div class="video">
                <embed src="http://player.56.com/<?=VIDEO56_API_KEY.'/open_'.$video56->id.'.swf'?>" type="application/x-shockwave-flash" allowFullScreen="true" width="100%" height="100%" allowNetworking="all" wmode="opaque" allowScriptAccess="always"></embed>
            </div>
        </div>
        <hr>
    <?php
     }
     ?>
    <div class="more_data">
        <button class="btn btn-default video56_more" data-page="<?=$page?>">加载更多内容...</button>
    </div>
    <input type="hidden" value="<?=$id?>" class='video56_id' />
<?php }else{ ?>
没有更多可以显示的数据.
<?php }?>