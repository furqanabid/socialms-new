<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                    <h3 class="panel-title">
                        <span class="glyphicon glyphicon-plus"></span> 
                        添加新的Rss
                    </h3>
            </div>
            <div class="panel-body">
                <?php if(Yii::app()->user->hasFlash('rss-create')):?>
                    <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?=Yii::app()->user->getFlash('rss-create'); ?>
                    </div>
                <?php endif; ?>

                <?php $form=$this->beginWidget('CActiveForm',array(
                    'htmlOptions'=>array(
                        'class'=>'form-horizontal',
                        'role'=>'form'
                    ),
                ));?>

                    <div class="form-group">
                        <label for="rss_url" class="col-sm-2 control-label">Rss地址</label>
                        <div class="col-sm-6">
                            <?=$form->textField($model, 'url', array('class'=>'form-control', 'placeholder'=>'Rss地址'))?>
                            <?=$form->error($model, 'url')?>
                        </div>
                        <button type="button" class="btn btn-success check_rss">检查Rss</button>
                        <img class='ajax_loader' src='<?=$this->admin_assets?>/images/ajax-loader.gif' />
                        <span class="text-info rss-msg"></span>
                    </div>

                    <div class="form-group">
                        <label for="rss_name" class="col-sm-2 control-label">Rss标题</label>
                        <div class="col-sm-6">
                            <?=$form->textField($model, 'name', array('class'=>'form-control', 'placeholder'=>'Rss标题'))?>
                            <?=$form->error($model, 'name')?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Rss分类
                        </label>
                        <div class="col-sm-6">
                            <?php echo $form->checkBoxList(SocialRssCategory::Model(), 'name',  CHtml::listData(SocialRssCategory::Model()->findAll( array('condition'=>'user_id=0') ), 'id', 'name'), array(
                                    'template' => '<label class="checkbox-inline">{input}{label}</label>',
                                    'separator'=>'',
                            )); ?>        
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">提交</button>
                        </div>
                    </div>
                    
                <?php $this->endWidget();?>     
            </div>
        </div>
    </div>
</div>