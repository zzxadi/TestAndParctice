$(function (){
	$(".slide-wrapper").slideBanner();
	$(".sbanner-right .adv-wrapper").hover(function(){
		$(this).siblings().find(".adv-black").show();
	},function (){
		$(this).siblings().find(".adv-black").hide();
	});
});