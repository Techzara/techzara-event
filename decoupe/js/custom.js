$(document).ready(function(){
	$('.kl-scroll-icon').click(function(){
		var theLink = $(this).attr('href');
		$("html, body").animate({ scrollTop: $(theLink).offset().top }, 1000);
		return false;
	});
});