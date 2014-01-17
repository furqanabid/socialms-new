<?php foreach ($data['items'] as $key => $val) {?>
    <div class="post-column-info pinterest_info clearfix">
        <h4>
            <a href="<?=$val->link->__toString()?>" target="_blank" class="post-column-title">
                <?=$val->title->__toString();?>
            </a>
        </h4>
        <div class="description post-column-description">
            <?=strip_tags($val->description->__toString(),'<p><img>');?>
        </div>
        <time class="pull-right">
            <?=date('Y-m-d H:i:s',strtotime($val->pubDate->__toString()) );?>
        </time>
        <div class="clearfix"></div>
        <span class="label label-success pull-right post-column" data-type='pinterest'>
            <span class="glyphicon glyphicon-arrow-left"></span> 发布
        </span>
    </div>
    <hr>
<?php } ?>  