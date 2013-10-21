$(function (){
	$(".quick-menu .tab-items").tab_child();
	$(".qm-allcategory").tab_hide();
	//left-menu
	$(".mall-mlcategroy").scrollMenu();
	$(".search-input").on("focus",function(){
		var curValue = this.value;
		var defValue = $(this).attr("defValue");
		if($.trim(curValue) == defValue){
			this.value = "";
		}
	}).on("blur",function(){
		var curValue = this.value;
		var defValue = $(this).attr("defValue");
		if($.trim(curValue).length == 0){
			this.value = defValue;
		}
	});
});

(function ($){
	$.fn.extend({
		tab_child:function (opt){
			var defaults = {
				tabHideMenu:"div.qmhd-menu",
				tabEvent:"hover"
			}
			var options = $.extend({},defaults,opt);
			var tabHideMenu = options.tabHideMenu;
			var tabEvent = options.tabEvent;
			function showCnt($this){
				var hdmenu = $this.find(tabHideMenu);
				if(hdmenu){
					$this.addClass("current");
					hdmenu.show();
				}
			}
			function hideCnt($this){
				var hdmenu = $this.find(tabHideMenu);
				if($this.hasClass("current")){
					$this.removeClass("current");
					hdmenu.hide();
				}
			}
			if(tabEvent == "hover"){
				$(this).hover(function(){
					var $this = $(this);
					showCnt($this);
				},function(){
					var $this = $(this);
					hideCnt($this);
				});
			}
		},
		tab_hide:function (opt){
			defaults = {
				tabEvent:"hover"
			}
			var options = $.extend({},defaults,opt);
			var tabEvent = options.tabEvent;
			var tabTimer = "";
			var $this = $(this);
			var tabId = $(this).attr("id");
			var tabHide = $("."+tabId+"-hide");
			if(tabEvent == "hover"){
				$(this).hover(function (){
					clearTimeout(tabTimer);
					$(this).addClass("current");
					tabHide.show();
				},function (){
					hideCnt();
				});
				function hideCnt(){
					tabTimer = setTimeout(function(){
						$this.removeClass("current");
						tabHide.hide();
					},100);
				}
				tabHide.mouseover(function (){
					clearTimeout(tabTimer);
				}).mouseout(function (){
					hideCnt();
				});
			}
		}
	});
})(jQuery);