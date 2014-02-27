<?php
require_once("../utils/include.php");
require_once('../action/InterceptAction.php');
require_once('../class/SystemMenu.php');
require_once('../dao/SystemMenuDao.php');
$error = '';
$type = getParamByName('method');

switch($type){
	case 'addMenu':addMenu();break;
	case 'updateMenu':updateMenu();break;
	case 'getPartMenu':getPartMenu();break;
	case 'getSingleMenu':getSingleMenu();break;
}
//添加菜单
function addMenu(){
	$smMenu = new SystemMenu();
	$smMenuDao = new SystemMenuDao();
	$smMenuDao->setSystemMenu($smMenu);
	$smMenu->setMenuName(getParam('menu_name',''));
	$smMenu->setMenuLevel(getParam('menu_level',''));
	$smMenu->setMenuSupper(getParam('menu_supper',''));
	$smMenu->setMenuUrl(getParam('menu_url',''));
	$smMenu->setMenuDef(getParam('menu_def',''));
	$smMenu->setMenuReg(getParam('menu_reg',''));
	$smMenu->setMenuIndex(getParam('menu_index',''));
	$smMenu->setMenuRemark(getParam('menu_remark',''));
	if($smMenuDao->addRecord()){
		$stPrint['entity'] = '';
		$stPrint['msgCode'] = 1;
		$stPrint['msg'] = '数据添加成功';
		dataPrint($stPrint);
	}else{
		$stPrint['entity'] = '';
		$stPrint['msgCode'] = 2;
		$stPrint['msg'] = '数据添加失败';
		dataPrint($stPrint);
	}
}
//更新菜单
function updateMenu(){
	$smMenu = new SystemMenu();
	$smMenuDao = new SystemMenuDao();
	$smMenuDao->setSystemMenu($smMenu);
	$smMenu->setId(getParam('menu_id',''));
	$smMenu->setMenuName(getParam('menu_name',''));
	$smMenu->setMenuLevel(getParam('menu_level',''));
	$smMenu->setMenuSupper(getParam('menu_supper',''));
	$smMenu->setMenuUrl(getParam('menu_url',''));
	$smMenu->setMenuDef(getParam('menu_def',''));
	$smMenu->setMenuReg(getParam('menu_reg',''));
	$smMenu->setMenuIndex(getParam('menu_index',''));
	$smMenu->setMenuRemark(getParam('menu_remark',''));
	if($smMenuDao->updateRecord()){
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
//获取一条记录
function getSingleMenu(){
	$param = getParam('paramName','');
	$paramValue = getParam('paramValue','');
	$smMenuDao = new SystemMenuDao();
	$menuRecord = $smMenuDao->getSingleRecord($param,$paramValue);
	if($menuRecord != NULL && !is_array($menuRecord)){
		$stPrint['entity'] = '';
		$stPrint['msgCode'] = 2;
		$stPrint['msg'] = $menuRecord;
		dataPrint($stPrint);
	}else{
		$stPrint['entity'] = $menuRecord;
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
	$smMenuDao = new SystemMenuDao();
	$smMenuDao->setSystemMenu($smMenu);
	$smMenu->setMenuLevel(getParam('menu_level',''));
	$smMenu->setMenuSupper(getParam('menu_supper',''));
	$menuList = $smMenuDao->getLevelRecord();
	if($menuList != NULL && !is_array($menuList)){
		$stPrint['entity'] = '';
		$stPrint['msgCode'] = 2;
		$stPrint['msg'] = $menuList;
		dataPrint($stPrint);
	}else{
		$stPrint['entity'] = $menuList;
		$stPrint['msgCode'] = 1;
		$stPrint['msg'] = '获取成功';
		dataPrint($stPrint);
	}
}
?>