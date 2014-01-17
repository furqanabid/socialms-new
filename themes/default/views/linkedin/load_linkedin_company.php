<?php if(count($data->values)>0) {?>
    <?php foreach ($data->values as $key => $linkedin) { ?>
        <div class="post-column-info linkedin_wrap clearfix">
            <h4 class="linkedin_company_name">
                <?=$linkedin->updateContent->company->name?>
            </h4>
            <div class="linkedin_content">
                <!-- 如果是更新新闻 -->
                <?php if(isset($linkedin->updateContent->companyStatusUpdate)){?>
                    <div>
                        <?=$linkedin->updateContent->companyStatusUpdate->share->comment?>
                    </div>
                    <?php if(isset($linkedin->updateContent->companyStatusUpdate->share->content)){?>
                        <a class='title post-column-title' href="<?=$linkedin->updateContent->companyStatusUpdate->share->content->shortenedUrl?>" target="_blank">
                            <?=$linkedin->updateContent->companyStatusUpdate->share->content->title?>
                        </a>
                        <div class="description post-column-description">
                            <img class="img-responsive" src="<?=$linkedin->updateContent->companyStatusUpdate->share->content->submittedImageUrl?>" />
                            <?=@$linkedin->updateContent->companyStatusUpdate->share->content->description?>
                        </div>
                    <?php }?>
                <!-- 否则就是更新是工作信息 -->
                <?php }else if(isset($linkedin->updateContent->companyJobUpdate)){?>
                    <div class='title'>
                        <b>职位:</b>
                        <a href="<?=$linkedin->updateContent->companyJobUpdate->job->siteJobRequest->url?>" target="_blank" class="post-column-title">
                            <?=$linkedin->updateContent->companyJobUpdate->job->position->title?>
                        </a>
                    </div>
                    <div class="description post-column-description">
                        <b>描述:</b>
                        <?=$linkedin->updateContent->companyJobUpdate->job->description?>
                    </div>
                    <div class="position">
                        <b>工作地址:</b>
                        <?=$linkedin->updateContent->companyJobUpdate->job->locationDescription?>
                    </div>
                <?php }?>
            </div>
            <time class="pull-right"><?=date("Y-m-d H:i:s",$linkedin->timestamp/1000)?></time>
            <div class="clearfix"></div>

            <span class="label label-success pull-right post-column" data-type='linkedin'>
                <span class="glyphicon glyphicon-arrow-left"></span> 发布
            </span>
        </div>
        <hr>
    <?php }?>

    <div class="more_data">
        <button class="btn btn-default linkedin_more" data-page="<?=$page?>" data-total="<?=$data->_total?>">加载更多内容...</button>
    </div>

<?php }else{ ?>
    没有更多可以加载的内容...
<?php }?>

