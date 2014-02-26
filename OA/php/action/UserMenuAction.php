<?php
require_once("../utils/common.php");
require_once("../utils/module.php");
require_once("../class/User.php");
require_once("../class/SystemMenu.php");
require_once("../class/RoleMenu.php");
require_once("../dao/UserMenuDao.php");
//输出信息
$stPrint = array();
$stPrint['fieldArray'] = array();
$stPrint['entity'] = false;
$stPrint['msgCode'] = 2;
$stPrint['msg'] = '访问异常';
//判断登录
/*
if(!isLogin()){
	$stPrint['entity'] = ''; 
	$stPrint['msgCode'] = 3;
	$stPrint['msg'] = '用户未登录';
	dataPrint($stPrint);
	return;
}
*/
//获取参数
$type = getParamByName('type');
switch($type){
	case 'getUserMenu':
		getUserMenu();
		break;
}
//获取用户菜单
function getUserMenu(){
	$user = new User();
	$systemMenu = new SystemMenu();
	$roleMenu = new RoleMenu();
	$userMenuDao = new UserMenuDao();
	$userMenuDao->setUser($user);
	$userMenuDao->setSystemMenu($systemMenu);
	$userMenuDao->setRoleMenu($roleMenu);
	$user->setId(12);					//此处需要实时获取
	$umData = $userMenuDao->getUserRole();
	$roleMenu->setRoleId($umData[0]['role_id']);
	$umData = $userMenuDao->getMenuIdList();
	$umMenuData = $userMenuDao->getUserMenuList($umData);
	if($umMenuData != NULL && !is_array($umMenuData)){
		$stPrint['msg'] = $umMenuData;
		$stPrint['msgCode'] = 2;
		dataPrint($stPrint);
	}else{
		$stPrint['entity'] = $umMenuData;
		$stPrint['msgCode'] = 1;
		$stPrint['msg'] = '获取成功';
		dataPrint($stPrint);
	}
}
?>