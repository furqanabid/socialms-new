// 发布数据的js
$(function(){
	// 点击显示人人的发布表单
	$('.post-renren').toggle(
		function(){
			var id = $(this).attr('data-id');
			$('.post-renren-'+id).slideDown();
			$(this).addClass('post-type-clicked');
		},
		function(){
			var id = $(this).attr('data-id');
			$('.post-renren-'+id).slideUp();
			$(this).removeClass('post-type-clicked');
		}
	)

	// 点击column里面的发布获取数据
	$(document).on('click', '.post-column', function(){
		var type = $(this).attr('data-type');
		var $parent = $(this).closest('.post-column-info');

		var title = $parent.find('.post-column-title').text().substr(0,140) || type;
		var link = $parent.find('.post-column-title').attr('href');
		var description = $parent.find('.post-column-description').text().substr(0,250);
		var image;

		if(type == 'instagram')
		{
			image = $parent.find('.post-column-image').attr('src');
		}
		else if(type == 'weibo')
		{
			image = $parent.find('.post-column-image').attr('src') || $parent.find('img').attr('src');
		}
		else
		{
			image = $parent.find('img').attr('src') || root_img +'/image-holder.png';
		}
		

		$('.renren-post-title').text(title);
		$('.renren-post-title').attr('href', link);
		$('.renren-post-description').text(description);
		$('.renren-post-image').attr('src', image);
		
	})
})