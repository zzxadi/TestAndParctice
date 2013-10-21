(function ($){
	$.fn.scrollMenu = function (opt){
		var options = $.extend({},$.fn.scrollMenu.defaults,opt);
		var self = this;
		var isDetail = false;
		var isList = true;
		var menuList = $(self).find("li.item");
		var menuTimer = null;
		var scrollTimer = null;
		var fTop = options.fTop;
		var cTop = options.cTop;
		var subMenuWp = options.subMenuWp;
		var unitHeight = options.unitHeight;
		var sIndex = 0;
		var subMemuPos = 0;
		$(self).find("i.expand-cat").click(function (){
			if(!isDetail){
				$(this).addClass("selected-cat").siblings("i").removeClass("selected-cat");
				menuList.css({"height":"auto"});
				menuList.find("p").stop(true,true).show();
				isDetail = true;
				isList = false;
			}
		});
		$(self).find("i.simple-cat").click(function (){
			if(!isList){
				$(this).addClass("selected-cat").siblings("i").removeClass("selected-cat");
				menuList.find("p").stop(true,true).hide();
				isDetail = false;
				isList = true;
			}
		});
		menuList.hover(function (){
			sIndex = $.inArray(this,menuList);
			showItem(sIndex);	
		},function (){
			hideItem(sIndex);
		});
		function showItem(index){
			var currMenuLi = menuList.eq(index);
			currMenuLi.addClass("selected")
			menuList.css({"height":"auto"});
			if(isList){
				currMenuLi.find("p").stop(true,true).show();
				subMemuPos = parseInt($("."+subMenuWp).css("top"));
			}
			$("."+subMenuWp).css({
				"top":subMemuPos
			}).show().end().find(".sub-mlcview").eq(index).show();
		}
		function hideItem(index){
			var currMenuLi = menuList.eq(index);
			currMenuLi.removeClass("selected");
			if(isList){
				currMenuLi.find("p").stop(true,true).hide();
			}
			$("."+subMenuWp).show().end().find(".sub-mlcview").eq(index).hide();
		}
		function scrollMenu (idx){
			for(var i = 0; i< idx;i++){
				if(i < menuList.length){
					var srcollLi = menuList[i];
					$(srcollLi).find("p").stop(true,true).slideUp(1000);
				}
			}
			for(var i = menuList.length - 1; i >= idx; i--){
				if(i>=0){
					var srcollLi = menuList[i];
					$(srcollLi).find("p").stop(true,true).slideDown(1000);
				}
			}
		}
		$(window).scroll(function (){
			var sTop = $(window).scrollTop();
			var mTop = $(self).css("top");
			// if (sTop > mTop){
			// 	alert(1);
			// 	$(self).css({
			// 		"top":"0",
			// 		"position":"relative"
			// 	});
			// }else {
			// 	$(self).css({
			// 		"top":"30px",
			// 		"position":"fixed"
			// 	});
			// }
			if(isDetail){
				if(sTop > cTop){
					var idxTop = parseInt((sTop - fTop - cTop)/unitHeight);
					scrollTimer = setTimeout(function (){
						scrollMenu(idxTop);
					},200)
				}else {
					scrollMenu(0);
				}
				
			}
		});
	}
	$.fn.scrollMenu.defaults = {
		fTop:60,//距离顶部的距离
		cTop:80,//滚动条滚动多少像素后开始折叠
		unitHeight:100,//每滚动多少距离折叠一次
		subMenuWp:"sub-mlcmenu"
	}
})(jQuery)