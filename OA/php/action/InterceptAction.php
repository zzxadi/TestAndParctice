<?php
/*
msgCode 1:正常 2:其他异常 3:未登录 4:无权限
*/
require_once('../class/User.php');
require_once('../dao/InterceptDao.php');
$stPrint = array();
$stPrint['entity'] = false;
$stPrint['msgCode'] = 2;
$stPrint['msg'] = '访问异常';
$interceptDao = new InterceptDao();
if(!isLogin()){
	$stPrint['entity'] = '';
	$stPrint['msgCode'] = 3;
	$stPrint['msg'] = '用户未登录';
	dataPrint($stPrint);
	exit;
}
$user = new User();
$user->setId(getUserId());
$interceptDao->setUser($user);
$menu_def = $_SERVER['SCRIPT_NAME'].'|'.getParamByName('method');

if(!$interceptDao->isUserQualified($menu_def)){
	$stPrint['entity'] = '';
	$stPrint['msgCode'] = 4;
	$stPrint['msg'] = '无权限访问';
	dataPrint($stPrint);
	exit;
}
?>