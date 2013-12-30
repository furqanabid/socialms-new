<?php foreach ($data['items'] as $key => $val) {?>
	<div class="site_rss_info clearfix">
		<h5>
			<a href="<?=$val->link->__toString()?>" target="_blank"><?=$val->title->__toString();?></a>
		</h5>
		<div class="rss_content">
			<?=$val->description->__toString();?>
		</div>
		<time class="pull-right">
			<?=date('Y-m-d H:i:s', strtotime($val->pubDate->__toString()) );?>
		</time>
		<div class="clearfix"></div>
	</div>
	<hr>
<?php } ?>	
