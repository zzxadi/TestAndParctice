<?php
function isLogin(){
	$iUserID = (int)getUserID();
	if($iUserID > 0)return true;
	else return false;
}
function loginCookie($userId){
	$userId = (int)($userId);
	if(empty($userId))return false;
	$sCookie = authcode($userId,'ENCODE','google');
	setcookie('login_id',$sCookie, 0,'/');
	return true;
}

function exitLogin(){
	setcookie('login_id','', -86400,'/');	
	return true;
}

function getUserId(){
	$iUserID = 0;
	if(isset($_COOKIE["login_id"])){
		$iUserID = (int)authcode($_COOKIE["login_id"],'DECODE','google');
	}
	return $iUserID;
}
?>
