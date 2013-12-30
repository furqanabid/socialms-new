<?php foreach ($data as $key => $val) { ?>
    <div class="rss_feed_wrap">
        <a type="button" class="btn btn-success rss_add_to_column">
            <?=$val['name']?>
        </a>
        <input type="hidden" value="<?=$val['id']?>" class='rss_master_id'>
    </div>
<?php }?>