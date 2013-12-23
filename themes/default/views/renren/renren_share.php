<?php if(count($data)>0){?>
    <?php foreach ($data as $key => $renren) {?>
       <div class="renren_wrap clearfix">    
            <a href="<?=$renren->url?>" target="_blank">
                <?=$renren->title?>
            </a>
            <div class="thumburl">
                <img src="<?=$renren->thumbUrl?>">
            </div>
            <div class="clearfix"></div>  
            <time class="pull-right">
                <?=$renren->shareTime?>
            </time>
       </div>
       <hr>
    <?php }?>
    
    <div class="more_data">
        <button class="btn btn-default renren_more" data-page="<?=$page?>">加载更多内容...</button>
    </div>
    
<?php }else{ ?>
没有可以显示的数据.
<?php }?>