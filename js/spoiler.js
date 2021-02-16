jQuery(document).ready(function(){
	jQuery('.spoiler-head').click(function(){
		$(this).parents('.spoiler-wrap').toggleClass("active").find('.spoiler-body').slideToggle();
	})
})