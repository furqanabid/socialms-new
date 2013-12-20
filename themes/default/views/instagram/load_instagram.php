<?php if(count($instagram->data)>0) {?>
	<?php foreach ($instagram->data as $key => $instagram_data) { ?>
		<div class="social_wrap instagram_wrap clearfix">
			<div class="author">
				<img src="<?=$instagram_data->user->profile_picture?>" width=60 height=60>
				<a class="instagram_username" href="<?=$instagram_data->link?>" target="_blank"><?=$instagram_data->user->username?></a>
			</div>
			<div class="img">
				<img src="<?=$instagram_data->images->low_resolution->url?>" class='img-responsive instagram_img' />
			</div>
			<div class="caption">
				<div class="instagram_caption">
					<?=@$instagram_data->caption->text?>
				</div>
				<time><?=date('Y-m-d H:i:s',$instagram_data->created_time)?></time>
				<div class="clearfix"></div>
			</div>
			<div class="instagram_likes">
				<?php if($instagram_data->likes->count > 0){?>
					<?=$instagram_data->user_has_liked ? '你和' : '';?><?=number_format($instagram_data->likes->count)?>用户喜欢这张图片.
				<?php } ?>
			</div>
			<div class="instagram_comments">
				<?php if($instagram_data->comments->count > 0){?>
					<?php foreach ($instagram_data->comments->data as $key => $comment) { ?>
						<div class="comment_wrap">
							<img src="<?=$comment->from->profile_picture?>" width=25 height=25/>
							<a href="http://instagram.com/<?=$comment->from->username?>" target="_blank"><?=$comment->from->username?></a>
							<?=$comment->text?>
						</div>
					<?php }?>
				<?php }?>
			</div>

			<textarea class="form-control write_instagram_comments" rows="3" placeholder='输入你的留言，按Enter键提交'></textarea>

			<div class="pull-right social_action instagram_action" data-mediaid=<?=$instagram_data->id?> >
				<a href="javascript:void(0);" data-type='comment'  title="给图片留言">
					<span class="glyphicon glyphicon-comment"></span>
				</a>
				<a href="javascript:void(0);" data-type='like'  title="赞这张图片">
					<span class="glyphicon <?=$instagram_data->user_has_liked?'glyphicon-heart':'glyphicon-heart-empty';?>" ></span>
				</a>
				<a href="javascript:void(0);" data-type='unfollow' data-userid="<?=$instagram_data->user->id?>" title="取消关注">
					<span class="glyphicon glyphicon-eye-close"></span>
				</a>
			</div>

			<div class="clearfix"></div>
           	<div class='pull-right social_action_msg'>操作处理中......</div>
           	<div class='pull-right action_info'></div>
           	<div class="clearfix"></div>
		</div>
		<hr>
	<?php }?>
	<?php if( isset($instagram->pagination->next_url) ){?>
	    <div class="more_data">
	        <button class="btn btn-default instagram_more" data-next-page="<?=$instagram->pagination->next_url?>" data-next-pageid="<?=$instagram->pagination->next_max_id?>">加载更多内容...</button>
	    </div>
    <?php }?>
<?php }?>
