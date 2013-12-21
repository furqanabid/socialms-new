<?php if(count($data->values)>0) {?>
    <?php foreach ($data->values as $key => $linkedin) { ?>
        <div class="linkedin_wrap clearfix">
            <div class="linkedin_content">      
                <a class='title' href="<?=@$linkedin->updateContent->person->siteStandardProfileRequest->url?>" target="_blank">
                    <?=$linkedin->updateContent->person->firstName?>
                    <?=$linkedin->updateContent->person->lastName?>
                </a>      

                <!-- 如果存在邀请用户 -->
                <?php if(isset($linkedin->updateContent->person->connections)){ ?>
                    邀请
                    <a class='title' href="<?=@$linkedin->updateContent->person->connections->values[0]->siteStandardProfileRequest->url?>" target="_blank">
                        <?=$linkedin->updateContent->person->connections->values[0]->firstName?>
                        <?=$linkedin->updateContent->person->connections->values[0]->lastName?>
                    </a>
                <?php } ?>

                <!-- 是否存在发布心情 -->
                <?=isset($linkedin->updateContent->person->currentStatus)?$linkedin->updateContent->person->currentStatus : '加入了Linkedin';?>
                  
            </div>
            <time class="pull-right"><?=date("Y-m-d H:i:s",$linkedin->timestamp/1000)?></time>
            <div class="clearfix"></div>
        </div>
        <hr>
    <?php }?>
    
    <div class="more_data">
        <button class="btn btn-default linkedin_more" data-page="<?=$page?>" data-total="<?=$data->_total?>">加载更多内容...</button>
    </div>

<?php }else{ ?>
    没有更多可以加载的内容...
<?php }?>
