<?php
require_once("../utils/include.php");
require_once('../action/InterceptAction.php');
require_once("../class/SystemMenu.php");
require_once("../class/RoleMenu.php");
require_once("../dao/UserMenuDao.php");
//获取参数
$type = getParamByName('method');
switch($type){
	case 'getUserMenu':
		getUserMenu();
		break;
	case 'getPartMenu':
		getPartMenu();
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
	$user->setId(getUserId());
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
//获取部分菜单记录
function getPartMenu(){
	$menu_level = getParam('menu_level','');
	$menu_supper = getParam('menu_supper','');
	$smMenu = new SystemMenu();
	$smMenuDao = new UserMenuDao();
	$smMenuDao->setSystemMenu($smMenu);
	$smMenu->setMenuLevel(getParam('menu_level',''));
	$smMenu->setMenuSupper(getParam('menu_supper',''));
	$smMenu->setMenuDef('1');
	$menuList = $smMenuDao->getLevelRecord();
	if($menuList != NULL && !is_array($menuList)){
		$stPrint['msg'] = $menuList;
		$stPrint['entity'] = '';
		$stPrint['msgCode'] = 2;
		dataPrint($stPrint);
	}else{
		$stPrint['entity'] = $menuList;
		$stPrint['msg'] = '获取成功';
		$stPrint['msgCode'] = 1;
		dataPrint($stPrint);
	}
}
?>