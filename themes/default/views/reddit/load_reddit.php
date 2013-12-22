<?php if(count($reddit->data->children)>0){?>
	<?php foreach ($reddit->data->children as $key => $reddit_data) {?>
		<div class="social_wrap reddit_wrap clearfix">
			<?php if(!empty($reddit_data->data->thumbnail) && $reddit_data->data->thumbnail!='self' && $reddit_data->data->thumbnail !='default'){?>
			<div class="img">
				<img src="<?=$reddit_data->data->thumbnail?>" />
			</div>
			<?php }?>
			<span class='content clearfix'>
				<a href="<?=$reddit_data->data->url?>" target="_blank">
					<?=$reddit_data->data->title?>
				</a>
				<span class='reddit_domain'>
					<a href="http://<?=$reddit_data->data->domain?>" target="_blank">( <?=$reddit_data->data->domain?> )</a>
				</span>
			</span>
			<time class="pull-right"><?=date('Y-m-d H:i:s', $reddit_data->data->created)?></time>
			<div class="clearfix"></div>

			<textarea class="form-control write_reddit_comments" rows="3" placeholder='输入你的评论，按Enter键提交' style="display:none;"></textarea>

			<!-- 一些操作 -->
			<div class="pull-right social_action reddit_action" data-id="<?=$reddit_data->kind.'_'.$reddit_data->data->id?>" data-modhash="<?=$reddit->data->modhash?>">
				<a href="javascript:void(0);" data-type='comment' title="评论">
					<span class="glyphicon glyphicon-comment"></span>
				</a>
				<a href="javascript:void(0);" data-type='save' title="保存">
					<span class="glyphicon glyphicon-heart<?=($reddit_data->data->saved==1) ? '' : '-empty';?>"></span>
				</a>
				<a href="javascript:void(0);" data-type='vote' title="顶">
					<span class="glyphicon glyphicon-chevron-up"></span>
				</a>
			</div>
			
			<div class="clearfix"></div>
           	<div class='pull-right social_action_msg'>操作处理中......</div>
           	<div class='pull-right action_info'></div>
           	<div class="clearfix"></div>

		</div>
		<hr>
	<?php } ?>

	<div class="more_data">
		<button class="btn btn-default reddit_more" data-after="<?=$reddit->data->after?>">加载更多内容...</button>
	</div>

<?php  }else { ?>
	没有更多可以加载的内容...
<?php } ?>