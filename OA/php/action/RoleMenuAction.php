<?php
require_once("../utils/include.php");
//require_once('../action/InterceptAction.php');
require_once('../class/RoleMenu.php');
require_once('../class/SystemMenu.php');
require_once('../dao/RoleMenuDao.php');
$stPrint = array();
$stPrint['entity'] = false;
$stPrint['msgCode'] = 2;
$stPrint['msg'] = '访问异常';
$type = getParamByName('method');
switch($type){
	case 'getRecord':
		getRecord();
		break;
	case 'updateRecord':
		updateRecord();
		break;
	case 'getUserRecord':
		getUserRecord();
		break;
}
//获取数据
function getRecord(){
	$rmMenu = new RoleMenu();
	$rmMenuDao = new RoleMenuDao();
	$rmMenuDao->setRoleMenu($rmMenu);
	$role_id = $rmMenu->setRoleId(getParam('role_id',''));
	$rmList = $rmMenuDao->getRecord();
	if($rmList != NULL && !is_array($rmList)){
		$stPrint['msgCode'] = 2;
		$stPrint['msg'] = $rmList;
		dataPrint($stPrint);	
	}else{
		$stPrint['entity'] = $rmList;
		$stPrint['msgCode'] = 1;
		$stPrint['msg'] = '';
		dataPrint($stPrint);	
	}
}
//添加、更新数据
function updateRecord(){
	$rmMenu = new RoleMenu();
	$rmSystemMenu = new SystemMenu();
	$rmMenuDao = new RoleMenuDao();
	$rmMenuDao->setRoleMenu($rmMenu);
	$rmMenuDao->setSystemMenu($rmSystemMenu);
	$rmMenu->setRoleId(getParam('role_id',''));
	$rmSystemMenu->setMenuDef(getParam('menu_def',''));
	$menuStr = getParam('menu_id','');
	$menu_id =  preg_split('/_/',$menuStr);
	if($rmMenuDao->updateRecord($menu_id)){
		$stPrint['entity'] = '';
		$stPrint['msgCode'] = 1;
		$stPrint['msg'] = '编辑成功';
		dataPrint($stPrint);	
	}else{
		$stPrint['entity'] = '';
		$stPrint['msgCode'] = 2;
		$stPrint['msg'] = '编辑失败';
		dataPrint($stPrint);	
	}
}
?>