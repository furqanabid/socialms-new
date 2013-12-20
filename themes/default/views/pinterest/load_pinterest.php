<?php foreach ($data['items'] as $key => $val) {?>
    <div class="pinterest_info clearfix">
        <h4>
            <a href="<?=$val->link->__toString()?>" target="_blank"><?=$val->title->__toString();?></a>
        </h4>
        <div class="description">
            <?=strip_tags($val->description->__toString(),'<p><img>');?>
        </div>
        <time class="pull-right">
            <?=date('Y-m-d H:i:s',strtotime($val->pubDate->__toString()) );?>
        </time>
        <div class="clearfix"></div>
    </div>
    <hr>
<?php } ?>  