/*var alertBox = function(option){
	var options = {
		w: '',
		title: '提示',
		msg: '',
		msgExt: '',
		msgArr: [],
		yes_btn: '确定',
		no_btn: '取消',
		yesBool: true,
		noBool: true,
		ok_Fun: null,
		backgroundColor: '#dc0100',
		autoFun: null
	}

	option = $.extend({}, options, option || {});
	var obj_msgprint = 'msgprint' + parseInt(Math.random() * 1000);

	option.yes_btn = option.yesBool ? '<a id="a_activateYes" style="background-color:"'+ option.backgroundColor + 
	' href="javascript:void(0);">' + option.yes_btn + '</a>' : '';

	option.no_btn = option.noBool ? '<a id="a_activateNo" class="cancel" href="javascript:void(0)";>' + option.no_btn + '</a>' : '';

	if(option.no_btn){
		option.no_btn = "";
	} 

	var allMsgArr = [];
	if(option.msgArr.length > 0){
		for(var item in option.msgArr){
			allMsgArr.push('<p class="big">' + option.msgArr[item] + '</p>');
		}
	}
	if(option.msg != ''){
		allMsgArr.push('<p class="big">' + option.msg + "</p>");
	}
	var boxContentArr = [];
	boxContentArr.push('<div id="' + obj_msgprint + '" class="albox" style="position:absolute;z-index:1002;display:block;width:' + option.w || 200 + '">');
	boxContentArr.push('<div class="headbox" style="background-color: ' + option.backgroundColor + '"><p>'+option.title+'</p></div>');
	boxContentArr.push('<div class="conbox" style="border-color: ' + option.backgroundColor + '"><div class="txt">' + allMsgArr.join('') + '</div>');
	boxContentArr.push('<div class="btnbox">'+option.yes_btn+option.no_btn+'</div></div></div>');

	$('body').append(boxContentArr.join(''));

	$('#a_activateNo, #a_closeActivate, #a_activateYes').click(function(){
		$('#' + obj_msgprint).hide();
		mask.hide();
		$('#' + obj_msgprint).remove();
		mask.remove();
		if(option.ok_Fun && (typeof(option.ok_Fun) === 'function') && $(this).is('#a_activateYes')){
			option.ok_Fun.apply();
		}
	})

	$(document).keypress(function(e){
		var ev = e || window.event;
		if(e.keyCode == 13){
			$('#a_activateYes').trigger('click');
		}
	})

	var mask = $('<div id="maskOfDiv"></div>');
	$('body').append(mask);
	var sh = document.documentElement.scrollHeight,
	    ch = document.documentElement.clientHeight,
	    height = sh > ch ? sh : ch;
	    mask.css({
	    	'position': 'absolute',
	    	'top': '0',
	    	'right': '0',
	    	'bottom': '0',
	    	'left': '0',
	    	'z-index': '1000',
	    	'background-color': '#000',
	    	'display': 'none',
	    	'height': height
	    })
	    mask.show().css('opacity', '0.3');
	    $('#' + obj_msgprint).show();

	    var dom_obj = document.getElementById(obj_msgprint);
	    dom_obj.style.top = ((document.documentElement.clientHeight - $('#' + obj_msgprint).height()) / 2) + 'px';
	    dom_obj.style.left = (document.documentElement.scrollLeft +  (document.documentElement.clientWidth - $("#" + obj_msgprint).width()) / 2) + 'px';

	    if(option.autoFun && typeof(option.autoFun) === 'function'){
	    	option.autoFun.apply();
	    }
}

window.alertBox = alertBox;*/
var alertBox = function (option) {
    //扩展区域
    var options = {
        w: '',
        title: '提示:',
        msg: '',
        msgExt: '',
        MsgArr: [],
        yes_btn: "确定",
        no_btn: "取消",
        yesBool: true,
        noBool: true,
        ok_Fun: null,
        backgroundColor: '#DC0100',
        AutoFun: null //----自执行函数----
    }
    //---继承合并，形成组合的options参数----
    option = $.extend({}, options, option || {});
    //--随机生成一个ID--
    var obj_msgprint = "msgprint_" + parseInt(Math.random() * 1000);
    //--确定--
    option.yes_btn = option.yesBool ? 

     "<a id='a_activateYes' style= background-color:" + option.backgroundColor + " href='javascript:;'>" + option.yes_btn + '</a>' : "";
    //--取消--
    option.no_btn = option.noBool ? '<a id="a_activateNo" class="cancel" href="javascript:;">' + option.no_btn + '</a>' : "";
    if (option.noBool) {
        noBtn = "";
    }

    var allMsgArr = [];
    if (option.MsgArr.length > 0) {
        for (var item in option.MsgArr) {
            allMsgArr.push("<p class='big'>" + option.MsgArr[item] + "</p>");
        };
    }
    if (option.msg != '') {
        allMsgArr.push("<p class='big'>" + option.msg + "</p>");
    }
    if (option.msgExt != '') {
        allMsgArr.push("<p style='text-align:center;'>" + option.msgExt + "</p>");
    }

    var boxContentArr = ["<div id='" + obj_msgprint + "' class='albox' style='position:absolute;z-index:1002;display:block;width:" + option.w + "'>
                          <div class='headbox' style='background-color: " + option.backgroundColor + "'>", "<p>" + option.title + "</p>", "</div>
                          <div class='conbox' style='border-color: " + option.backgroundColor + "'><div class='txt'>" + allMsgArr.join('') + "</div>
                          <div class='btnbox'>", option.yes_btn, option.no_btn, "</div></div></div>"];

    $("body").append(boxContentArr.join(''));
    $("#a_activateNo,#a_closeActivate,#a_activateYes").click(function () {
        $("#" + obj_msgprint).hide();
        mask.hide();
        $("#" + obj_msgprint).remove();
        mask.remove();
        if (option.ok_Fun && (typeof (option.ok_Fun) === 'function') && $(this).is("#a_activateYes")) {
            option.ok_Fun.apply();
        }
    });
    //按下回车键
    $(document).keypress(function (e) {
        var ev = e || event;
        if (ev.keyCode == 13) {
            $("#a_activateYes").trigger("click");
        }
    });
    //***************创建遮罩效果*****************/
    var mask = $("<div id=\"maskOfDiv\"></div>"); //--Div遮罩----
    $("body").append(mask);
    var sh = document.documentElement.scrollHeight,
    ch = document.documentElement.clientHeight,
    height = sh > ch ? sh : ch;
    mask.css({
        "position": "absolute",
        "top": "0",
        "right": "0",
        "bottom": "0",
        "left": "0",
        "z-index": "1000",
        "background-color": "#000000",
        "display": "none",
        "height": height
    });
    mask.show().css("opacity", "0.3");
    $("#" + obj_msgprint).show();
    //***************创建遮罩效果******************/
    //-------居中提示类型---------
    var dom_obj = document.getElementById(obj_msgprint);
    dom_obj.style.top = ((document.documentElement.clientHeight - $("#" + obj_msgprint).height()) / 2) + "px";
    dom_obj.style.left = (document.documentElement.scrollLeft + (document.documentElement.clientWidth - $("#" + obj_msgprint).width()) / 2) + "px";
    //------自动执行函数--------
    if (option.AutoFun && (typeof (option.AutoFun) === 'function')) {
        option.AutoFun.apply();
    }
}
window.alertBox = alertBox;