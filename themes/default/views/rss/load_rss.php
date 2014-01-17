<?php foreach ($data['items'] as $key => $val) {?>
	<div class="post-column-info site_rss_info clearfix">
		<h5>
			<a href="<?=$val->link->__toString()?>" target="_blank" class="post-column-title">
				<?=$val->title->__toString();?>
			</a>
		</h5>
		<div class="rss_content post-column-description">
			<?=$val->description->__toString();?>
		</div>
		<time class="pull-right">
			<?=date('Y-m-d H:i:s', strtotime($val->pubDate->__toString()) );?>
		</time>
		<div class="clearfix"></div>
		
		<span class="label label-success pull-right post-column" data-type='rss'>
		    <span class="glyphicon glyphicon-arrow-left"></span> 发布
		</span>
	</div>
	<hr>
<?php } ?>	
