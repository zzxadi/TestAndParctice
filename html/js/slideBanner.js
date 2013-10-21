(function($) {
	$.fn.slideBanner = function(opts) {
		var options = $.extend({}, $.fn.slideBanner.defaults, opts);
		var autoTime = options.autoTime;
		var bgWrapper = options.bgWrapper;
		var self = this;
		var slideList = $(this).find(".slide-list");
		var slideLi = $(slideList).find("li");
		var slideNavLi = '';
		var nIndex = 0;
		var autoShow = null;
		for (var i = 0; i < slideLi.length; i++) {
			slideNavLi += '<li><span></span></li>'
		}
		var slideNav = "<ul class='slide-nav'>" + slideNavLi + "</ul>";
		slideList.after(slideNav);
		var sNArray = $(".slide-nav li");
		$(".slide-nav li").on("mouseenter", function() {
			nIndex = $.inArray(this, sNArray);
			showPic(nIndex)
		});
		showPic(nIndex);
		autoShowFn();
		function autoShowFn (){
			autoShow = setInterval(function (){
				showPic(nIndex);
				nIndex ++;
				if(nIndex == sNArray.length){
					nIndex = 0;
				}
			},autoTime);
		}
		$(self).hover(function (){
			clearInterval(autoShow);
		},function (){
			autoShowFn();
		});

		function showPic(index) {
			sNArray.removeClass("selected").eq(index).addClass("selected");
			slideLi.addClass("hide").eq(index).removeClass("hide");
			var slideBg = slideLi.eq(index).find("img").attr("src");
			$("." + bgWrapper).css({
				"background-image": 'url(' + slideBg + ')'
			});
		}
	}
	$.fn.slideBanner.defaults = {
		autoTime: "3000",
		bgWrapper: "mall-back"
	}
})(jQuery);