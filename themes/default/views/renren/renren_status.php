<?php if(count($data)>0){?>
    <?php foreach ($data as $key => $renren) {?>
       <div class="renren_wrap clearfix">    
            <?=$renren->content?>  
            <div class="clearfix"></div>  
            <time class="pull-right">
                <?=$renren->createTime?>
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