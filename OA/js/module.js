function loadHtml(headerId,sUrl,async){
	if(!async)async=false;
	ajax({
		url:sUrl,
		type:"get",
		dateType:"html",
		async:async,
		success:function(html){
			$("#"+headerId).html(html);
		}
	});
};
//判断是否是IE
function isIE(){
	var arVersion = navigator.appVersion.split("MSIE");
    var version = parseFloat(arVersion[1]);
    if ((version > 5.5))return version;
	else return false;
}
//得到元素实际坐标
function getElementPosition(OB)
{	var posX=OB.offsetLeft;
	var posY=OB.offsetTop;
	var aBox=OB;//需要获得位置的对象
	while(aBox.tagName.toLowerCase()!="body")
	{	aBox=aBox.offsetParent;
		if(!aBox)break;
		posX+=aBox.offsetLeft;
		posY+=aBox.offsetTop;
	}
	return {left:posX,top:posY};
}
//获取url参数
function getUrlParam(sName)
{	
	if(sName)
	{
		var sValue='';
		var re= new RegExp("\\b"+sName+"\\b=([^&=]+)");
		var st=null;
		st=window.location.search.match(re);
		if(st&&st.length==2)
		{	
			st[1]=st[1].replace(/^\s*|\s*$/g,'');
			sValue=st[1];
		}
		return sValue;
	}
	else
	{
		alert("参数不能为空");
		return false;
	}
}
function locationHref(url,target){
	//可以支持多种跳转方式，而且document.referrer做记录
	var fun=function(){
		target=target?target:'_self';
		var a=document.createElement("a");
		a.style.display='none';
		a.href=url;
		a.target=target;
		a.innerHTML='&nbsp;';
		document.body.appendChild(a);
		a.click();
		if(target!='_self')document.body.removeChild(a);
	};
	//解决IE6超链接javascript:void(0)不跳转
	if(isIE()&&isIE()<7.0)setTimeout(fun,1);
	else fun();
}
function locationHash(fragment){
	location.hash = fragment;
}
//清除文本框提示信息
function inputOnFocus(ob){
	var sib=ob.previousSibling;
	if(!sib||sib.nodeName.toLowerCase()!='label')return;
	$(sib).hide();
}
function inputOnBlur(ob){
	var sib=ob.previousSibling;
	if(!sib||sib.nodeName.toLowerCase()!='label')return;
	var val=$.trim(ob.value);
	if(val=='')$(sib).show();
	else $(sib).hide();
}
/**************************************************** 设置cookie **********************************************/
function getCookie(name){
	var start=document.cookie.indexOf(name+"=");
	if(start==-1) return null;
	var len=start + name.length + 1;
	var end = document.cookie.indexOf(';',len);
	if (end==-1) end=document.cookie.length;
	return decodeURIComponent(document.cookie.substring(len, end));
}
function setCookie(name,value,expires){
	if(expires){
		expires=expires*1000*60*60*24;
		var today = new Date();
		expires = new Date(today.getTime()+(expires));
		expires = 'expires='+expires.toGMTString();
	}else expires = '';
	value = encodeURIComponent(value);
	//sBaseAreaName来自common.js
	document.cookie = name+'='+value+';path=/;'+expires;
}
function deleteCookie(name){
	//sBaseAreaName来自common.js
	document.cookie = name+'=;path=/;domain='+sBaseAreaName+';expires=Thu, 01-Jan-1970 00:00:01 GMT'; 
}
function checkUserType(){
	if(!globalUserInfo||!globalUserInfo.userType||!globalUserInfo.userType==2){
		if(window.location.href.toLowerCase().indexOf('/seller/')!=-1){
			checkJsonRight({"msgCode":3},'_top');
		}
	}
}
//判断用户是否登录
function isUserLogin(){
	var _usergd=getCookie('100gong_user');
	if(_usergd==null)_usergd='';
	_usergd=$.trim(_usergd);
	if(_usergd=='')return false;
	else return true;	
}
/*//检查json是否有权限,然后跳转到相关页面(默认跳回登录页面)
checkJsonRight(data);在本页打开:登录页面?tourl=window.location.href;
checkJsonRight(data,target);在自定义target打开:登录页面?tourl=window.location.href;
checkJsonRight(data,goUrl);在本页打开:登录页面?tourl=goUrl;
checkJsonRight(data,goUrl,target);在自定义target打开:登录页面?tourl=goUrl;
checkJsonRight(data,url,goUrl);在本页打开:url?tourl=goUrl;
checkJsonRight(data,url,goUrl,target);在自定义target打开:url?tourl=goUrl;*/
function checkJsonRight(data){
	//如果登录拦截器发现登录问题会返回 msgCode=3，再看failureCode
	//failureCode= 1 --没有登录
	//failureCode= 2 -- 登录信息异常，如登录COOKIE在浏览器端被认为篡改
	//failureCode= 3-- 登录超时
	var length=arguments.length;
	var href='';
	var url1='/login.html';
	var url2=top.location.href;
	var target='_top';
	if(!data||!data.msgCode){
		throw 'json format error';			
	}else if(data.msgCode==4){
		top.showBox('提示信息','没有该操作权限','alert');
		return;	
	}else if(data.msgCode!=3){
		return;	
	}
	if(length==2){
		arguments[1]=trim(arguments[1]);
		//只有window对象才有alert方法
		if(window[arguments[1]]&&window[arguments[1]].alert)target=arguments[1];
		else if(/^_blank|_parent|_self|_top$/i.test(arguments[1]))target=arguments[1];
		else url2=arguments[1];
	}else if(length==3){
		url2=trim(arguments[1]);
		arguments[2]=trim(arguments[2]);
		//只有window对象才有alert方法
		if(window[arguments[2]]&&window[arguments[2]].alert)target=arguments[2];
		else if(/^_blank|_parent|_self|_top$/i.test(arguments[2]))target=arguments[2];
		else{
			url1=trim(arguments[1]);
			url2=trim(arguments[2]);
		}
	}else if(length==4){
		url1=trim(arguments[1]);
		url2=trim(arguments[2]);
		target=trim(arguments[3]);
	}
	url1=trim(url1);
	url2=trim(url2);
	url2=encodeURIComponent(url2);
	if(url1.indexOf('?')==-1)href=url1+'?tourl='+url2;
	else href=url1+'&tourl='+url2;
	if(data.failureCode==5){
		alert('你的账号已在其他地方登录，你被迫下线，如非你本人操作，请立即重新登录并修改密码');
	}
	locationHref(href,target);
}
function cleanLoginCookie(){
	deleteCookie('100gong_user');
}
//得到当前时间,stDate是日期对象，iDay当前日期对象偏移的天数，long是否显示小时，分钟,秒
function GetTime(stDate,iDay,long)
{	var alldate="";
	var dt=null;
	if(stDate)dt=stDate;
	else dt=new Date();
	dt.setDate(dt.getDate()+iDay);
	var sYear=dt.getFullYear();
	var sMonth=dt.getMonth();
	sMonth++;
	if(sMonth<=9)sMonth="0"+sMonth;
	var sDay=dt.getDate();
	if(sDay<=9)sDay="0"+sDay;
	if(!long)
	{
		alldate=sYear+"-"+sMonth+"-"+sDay;
	}
	else
	{
		var sHours=dt.getHours();
		if(sHours<=9)sHours="0"+sHours;
		var sMinutes=dt.getMinutes();
		if(sMinutes<=9)sMinutes="0"+sMinutes;
		var sSeconds=dt.getSeconds();
		if(sSeconds<=9)sSeconds="0"+sSeconds;
		alldate=sYear+"-"+sMonth+"-"+sDay+' '+sHours+':'+sMinutes+':'+sSeconds;
	}
	return alldate;
}
//select按键快速定位
function selectCNSort(html){
	//判断是否是数组,你可以添加option字符串数组，也可以添加option字符串集合
	if(html.join)html=html.join('');
	var option=html.match(/<option[^<>]*?>.*?<\/option>/gi);
	if(!option)return html;
	//拼音排列的最小中文
	var stTemp='吖[a]|八[b]|嚓[c]|咑[d]|妸[e]|发[f]|噶[g]|哈[h]|丌[j]|咔[k]|垃[l]|嘸[m]|拏[n]|噢[o]|妑[p]|七[q]|亽[r]|仨[s]|他[t]|屲[w]|夕[x]|丫[y]|帀[z]'.split('|');
	for(var i=0,length=stTemp.length;i<length;i++){
		option.push('<option>'+stTemp[i]+'</option>');		
	}
	//首次按拼音排列
	option.sort(function(x,y){
		var str1=x.replace(/<.*?>/g,'');
		var str2=y.replace(/<.*?>/g,'');
		return str1.localeCompare(str2);
	});
	//给首字符为中文的option加上拼音的第一个字符(便于按键快速定位)
	var stNew=[];
	var tag='';
	for(var i=0,length=option.length;i<length;i++){
		option[i]=option[i].replace(/(^\s*)|(\s*$)/g,'');
		var stTag=option[i].match(/\[([a-z])]/);
		if(stTag){
			tag=stTag[1];
			continue;
		}
		var newStr=option[i].replace(/(<option[^<>]*?>)(.*?)(<\/option>)/gi,function(a,b,c,d){
			return 	b+tag+c+d;
		});	
		stNew.push(newStr);		
	}
	//再次按拼音排列
	stNew.sort(function(x,y){
		var str1=x.replace(/<.*?>/g,'');
		var str2=y.replace(/<.*?>/g,'');
		return str1.localeCompare(str2);
	});
	html=stNew.join('');
	return html;
}
function HTMLEncode(html)
{
	var temp = document.createElement("div");
	(temp.textContent != null) ? (temp.textContent = html) : (temp.innerText = html);
	var output = temp.innerHTML;
	temp = null;
	return output;
}
function HTMLDecode(text)
{
	var temp = document.createElement("div");
	temp.innerHTML = text;
	var output = temp.innerText || temp.textContent;
	temp = null;
	return output;
}
/******************************************************* 购物车 ********************************************************/
var card_cookie = 'cn.digione.cart'; // 存储的cookie的 key
// 添加产品到购物车
function addCartCookie(productId, quantity, priceId, priceType,productRelation,withProductActivityId) {
	if (getCookie(card_cookie) == null)setCookie(card_cookie,'[]',30);
	var cart = JSON.parse(getCookie(card_cookie));
	var flag = false;
	for (var i = 0, length=cart.length; i < length; i++) {
		if (cart[i].productId == productId && cart[i].priceId == priceId) {
			var total = parseInt(cart[i].quantity) + parseInt(quantity);
			if (total < 0) {
				alert('您输入的数字已经超出最小值');
				return;
			}
			cart[i].quantity = total;
			if(productRelation == 2){
				cart[i].productRelation = productRelation;
				cart[i].withProductActivityId = withProductActivityId;
			}
			flag = true;
			break;
		}
	}
	// 如果购物车中没有此产品，则添加到购物车
	if (!flag) {
		cart[cart.length] = {
				"productId" : productId,
				"quantity" : quantity,
				"priceId" : priceId,
				"priceType" : priceType,
				"productRelation" : productRelation,
				"withProductActivityId" : withProductActivityId
		};// 增加isafterser属性：售后由公司承担，默认为否：0表示,afterserPrice属性：费用
	}
	setCookie(card_cookie,JSON.stringify(cart),30);
	return true;
}
//删除购物车中的产品
function removeCardCookie(productId) {
	var cart = JSON.parse(getCookie(card_cookie));
	if(!cart||!cart.push)return;
	for (var i = 0, length=cart.length; i < length; i++) {
		if (cart[i].priceId == parseInt(productId)) {
			cart.splice(i, 1);
			setCookie(card_cookie,JSON.stringify(cart),30);
			break;
		}
	}
}
//得到购物车的产品数量
function getCardCookieQuantity(){
	var quantity = 0;
	if (getCookie(card_cookie) != null) {
		var cart = JSON.parse(getCookie(card_cookie));
		for (var i = 0, length=cart.length; i < length; i++) {
			quantity += parseInt(cart[i].quantity);
		}
	}
	return quantity;
}
//得到购物车的产品ID
function getCardCookieProductId(){
	var productIdList = [];
	if (getCookie(card_cookie) != null) {
		var cart = JSON.parse(getCookie(card_cookie));
		for (var i = 0, length=cart.length; i < length; i++) {
			productIdList.push(parseInt(cart[i].productId));
		}
	}
	return productIdList;
}
//处理购物车中已下架的产品
function arrDive(aArr,bArr){
    if(bArr.length==0){ return; }
    var current = [];
    var str = bArr.join(",");
    for(var e in aArr){
        if(str.indexOf(aArr[e])==-1){ current.push(aArr[e]); }
    }
    if(current.length > 0){	//cookie中存在已下架产品
    	for(var j=0,len=current.length; j<len; j++){ removeCardCookie(current[j]); }
    }
}
// 清空购物车
function cleanCartCookie() {
	deleteCookie(card_cookie);
}
/************************************************************* 修正浏览器JSON对象 *******************************************************/
//JSON其实就是高级浏览器的一个window.JSON,低于IE8是没有JSON对象的,大家注意啦不要乱使用
if(typeof(JSON)=='undefined')JSON={};
if(!JSON.parse)JSON.parse=function(str){
	var json = (new Function("return " + str))();
	return json;	
};
if(!JSON.stringify)JSON.stringify=function(obj){
	switch(typeof(obj)){
		case 'string':
			return '"' + obj.replace(/(["\\])/g, '\\$1') + '"';
		case 'array':
			return '[' + obj.map(arguments.callee).join(',') + ']';
		case 'object':
			 if(obj instanceof Array){
				var strArr = [];
				var len = obj.length;
				for(var i=0; i<len; i++){
					strArr.push(arguments.callee(obj[i]));
				}
				return '[' + strArr.join(',') + ']';
			}else if(obj==null){
				return 'null';

			}else{
				var string = [];
				for (var property in obj) string.push(arguments.callee(property) + ':' + arguments.callee(obj[property]));
				return '{' + string.join(',') + '}';
			}
		case 'number':
			return obj;
		case false:
			return obj;
	}
};
/************************************************************** 自定义弹框 *************************************************************/
/*
showBox('内标签','footerId')
showBox('内标签',dom对象)
showBox('自定义文本','你好我是自定义文本')
showBox('显示Iframe','/index.html?width=500&height=300')
showBox('显示AjaxHTML','/include/header.html?ajax')
showBox('alert框','用户不存在','alert',function(){alert('执行自定义函数')})
showBox('confirm框','用户不存在','confirm',function(){alert('执行自定义函数')})
showBox('tip提示','提示内容','tip',{'tagId':'xxx','left':0,'top':0,'time':500})//time是毫秒
*/
function showBox(title,param,winType,callBack){
	if(typeof(winType)=='undefined')winType='';
	winType=trim(winType.toLowerCase());
	title=trim(title);
	param=trim(param);
	var id=(new Date()).getTime();
	var html=[];
	html.push('<table cellpadding="0" cellspacing="0" ');
	var boxStyle='z-index:'+id+';';
	if(winType!='tip')html.push(' width="100%" height="100%" ');
	else{
		boxStyle+='display:none;border:1px solid #CCCCCC;';
		if(callBack&&callBack.tagId){
			var dom=document.getElementById(callBack.tagId);
			if(dom){
				var ps=getElementPosition(dom);
				var letf=ps.left;
				var top=ps.top;
				if(callBack.left)letf+=parseInt(callBack.left);
				if(callBack.top)top+=parseInt(callBack.top);
				boxStyle+='position:absolute;left:'+letf+'px;top:'+top+'px;';	
			}
		}
	}
	html.push(' class="showBox" id="showBox');
	html.push(id);
	html.push('" style="');
	html.push(boxStyle);
	html.push('"><tr><td align="center" valign="middle"  style="width:100%;height:100%">');
	/************************* 添加css Begin *************************/
	html.push('<!--[if IE 6]><style type="text/css">');
	html.push('html{height:100%;overflow:hidden;}');
	html.push('body{height:100%;overflow:auto;margin:0;}');
	html.push('.showBox,.box_overlay{position:absolute;}');
	html.push('</style><![endif]-->');
	html.push('<style type="text/css">');
	html.push('.showBox{position:fixed;top:0px;left:0px}.box_overlay{position:fixed;top:0;left:0;width:100%;height:100%;background:#000;filter:alpha(opacity=50);-moz-opacity:0.50;opacity:0.50;}');
	html.push('.box_main{text-align:left;background-color:#fff;position:relative;top:0;left:0}');
	html.push('.box_title{font-size:14px;font-weight:700;overflow:hidden;background-color:#63ADEE;border:1px solid #63ADEE}');
	html.push('.box_title .text{padding-left:10px;height:30px;line-height:30px;color:#fff}');
	html.push('.box_title .close_box{ text-align:right;padding-right:10px;}');
	html.push('.box_title .close{display:inline-block;width:14px;height:30px;background:url(../images/base/icon_close.gif) no-repeat 0 center;overflow:hidden;cursor:pointer;}');
	html.push('.box_txt{padding:10px;}');
	html.push('.box_btn{padding:0 0 6px;text-align:center;}');
	html.push('.box_btn button{padding:0 15px;height:24px;border:0;cursor:pointer;font-weight:700;color:#fff;margin:0 3px}');
	html.push('.box_btn button.yes{background-color:#63ADEE}');
	html.push('.box_btn button.no{background-color:#949494}');
	html.push('.box_ie6_html{height:100%;_overflow:hidden}');
	html.push('.box_ie6_body{height:100%;_overflow:auto;margin:0}');
	html.push('</style>');
	/************************* 添加css End *************************/
	if(winType!='tip')html.push('<div class="box_overlay"></div>');
	html.push('<table id="box_main');
	html.push(id);
	html.push('" class="box_main">');
	if(winType!='tip'){
		html.push('<tr class="box_title"><td class="text">');
		html.push(title);
		html.push('</td><td class="close_box">');
		var isAddCloseButton=true;
		if(winType=='alert'||winType=='confirm')isAddCloseButton=false;
		if(isAddCloseButton){
			html.push('<span class="close" onclick="closeBox(');
			html.push(id);
			html.push(');"></span>');
		}
		html.push('</td></tr>');		
	}
	html.push('<tr><td id="box_content');
	html.push(id);
	html.push('" colspan="2" class="box_content">');
	var isAjaxHTML=false;
	var isInnerHTML=false;
	var isIframeHTML=false;
	var innerHTML='';
	var element=null;
	if(param&&param.nodeType==1)element=param;
	else element=document.getElementById(param);
	if(element){
		isInnerHTML=true;
		innerHTML=element.innerHTML;
		element.innerHTML='';
		html.push(innerHTML);	
	}
	else if(/^[^<>]*?\.(html|htm|jsp)[^<>]*$/i.test(param)){
		//xxxxx.html?width=xxx&height=xxx
		if(/\?[^&=\?]*?ajax/i.test(param)){
			isAjaxHTML=true;	
		}else{
			isIframeHTML=true;
			var width='';
			var height='';
			var stWidth=param.match(/width=([0-9%]+)/i);
			if(stWidth&&stWidth.length)width=stWidth[1];
			var stHeight=param.match(/height=([0-9%]+)/i);
			if(stHeight&&stHeight.length)height=stHeight[1];
			if(param.indexOf('?')==-1)param+='?boxId='+id;
			else param+='&boxId='+id;
			html.push('<iframe id="contentIframe'+id+'" name="contentIframe" onload="this.contentWindow.document.body.style.background=\'#fff\'" frameborder="0" marginheight="0" marginwidth="0" ');
			if(width!='') {html.push('width="'+width+'"');}
			if(height!='') {html.push(' height="'+height+'"');}
			html.push(' src="'+param+'"></iframe>');
		}
	}
	else{
		html.push('<div class="box_txt">'+param+'</div>');	
	}
	html.push('</td></tr><tr style="display:none"><td colspan="2" class="box_btn" id="box_btn');
	html.push(id);
	html.push('"></td></tr></table></td></tr></table>');
	var div=document.createElement('div');
	div.innerHTML=html.join('');
	document.body.appendChild(div.firstChild);
	if(isIE()&&isIE()<7.0&&isIframeHTML){
		//IE6 iframe空白 bug
		document.getElementById("contentIframe"+id).contentWindow.location.reload();
	}
	//插入内标签缓存内容
	if(isInnerHTML){
		var input=document.createElement('input');
		input.innerDom=element;
		input.id="box_InnerTag"+id;
		input.type='hidden';
		input.value=innerHTML;
		document.getElementById("box_content"+id).appendChild(input);
	}
	if(isAjaxHTML&&loadHtml)loadHtml('box_content'+id,param);
	if(winType=='alert'||winType=='confirm'){
		var oBtn1=document.createElement('button');
		oBtn1.className="yes"; 
		oBtn1.innerHTML='确定';
		oBtn1.onclick=function(){
			closeBox(id);
			if(typeof(callBack)!="undefined"){callBack();};
		};
		var buttonBox=document.getElementById("box_btn"+id);
		buttonBox.parentNode.style.display="";
		buttonBox.appendChild(oBtn1);
		oBtn1.focus();
		if(winType=='confirm'){
			var oBtn2=document.createElement('button');
			oBtn2.className="no";
			oBtn2.innerHTML='取消';
			oBtn2.onclick=function(){
				closeBox(id);
			};
			buttonBox.appendChild(oBtn2);
		}
	}	
	if(winType!='tip'){	
		var main=document.getElementById('box_main'+id);
		var width=main.offsetWidth;
		var height=main.offsetHeight;
		if(width<250)main.style.width='250px';
		if(height<100)main.style.height='100px';
	}else{
		$('#showBox'+id).fadeIn('slow',function(){
			if(typeof(callBack.time)!='undefined'){								
				setTimeout(function(){
					$('#showBox'+id).fadeOut('slow',function(){
						closeBox(id,'flag');
					});
				},callBack.time);
			}
		});
	}
	return id;
}
function closeBox(id){
	//如果没有传id,关闭的将是最近的打开的showBox
	if(typeof(id)=='undefined'){
		var stTable=document.getElementsByTagName('table');
		for(var i=0,length=stTable.length;i<length;i++){
			if(stTable[i].className=='showBox'){
				id=stTable[i].id.replace(/\D/g,'');
			}
		}	
	}
	if(typeof(id)=='undefined')return;
	//还原内标签
	var input=document.getElementById("box_InnerTag"+id);
	if(input){
		var innerTag=input.innerDom;
		if(innerTag)innerTag.innerHTML=input.value;
	}
	var domContent=document.getElementById('box_content'+id);
	var domIframe=domContent?domContent.firstChild:null;
	var dombox=document.getElementById('showBox'+id);
	//防止IE下Iframe失去焦点
	if(domContent&&domIframe)domContent.removeChild(domIframe);
	if(dombox)document.body.removeChild(dombox);
}

//window.location.href="/upgrade.html";
