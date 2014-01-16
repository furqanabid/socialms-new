// 发布数据的js
$(function(){
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
})