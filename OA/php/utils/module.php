<?php
function isLogin(){
	$iUserID = (int)getUserID();
	if($iUserID > 0)return true;
	else return false;
}
function login($XXX){
	if(!isLogin($sMobile))return false;
	$sCookie = authcode($XXX,'ENCODE','密钥');
	setcookie('hsq_auth',$sCookie, -86400,'/','XXXX.com');	
	return true;
}
function exitLogin(){
	setcookie('hsq_auth','', -86400,'/','XXXX.com');	
	return true;
}
function getUserID(){
	$iUserID = 0;
	if(isset($_COOKIE["hsquid_auth"])){
		$iUserID = (int)authcode($_COOKIE["hsquid_auth"],'DECODE','密钥');
	}
	return $iUserID;
}
?>
