<?php
require_once('../class/SystemMenu.php');
require_once('../dao/SystemMenuDao.php');
require_once('../utils/common.php');
require_once('../utils/module.php');
$error = '';
$type = getParamByName('type');
switch($type){
	case 'addMenu':
		addMenu();
		break;
	case 'updateMenu':
		updateMenu();
		break;
	case 'getPartMenu':
		getPartMenu();
		break;
	case 'getSingleMenu':
		getSingleMenu();
		break;
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
		echo '{"entity":"","msgCode":"1","msg":"数据添加成功"}';
	}else{
		echo '{"entity":"","msgCode":"2","msg":"数据添加失败"}';
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
		echo '{"entity":"","msgCode":"1","msg":"编辑成功"}';
	}else{
		echo '{"entity":"","msgCode":"2","msg":"编辑失败"}';
	}
}
//获取一条记录
function getSingleMenu(){
	$param = getParam('paramName','');
	$paramValue = getParam('paramValue','');
	$smMenuDao = new SystemMenuDao();
	$menuRecord = $smMenuDao->getSingleRecord($param,$paramValue);
	if($menuRecord != NULL && !is_array($menuRecord)){
		$error = $menuRecord;
		$smData = jsonFrame(array(),2,$error);
	}else{
		$smData = jsonFrame($menuRecord,1,'');
	}
	return dataPrint($smData);
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
		$error = $menuList;
		$smData = jsonFrame(array(),2,$error);
	}else{
		$smData = jsonFrame($menuList,1,'');
	}
	return dataPrint($smData);
}
function jsonFrame($arr,$msgCode=0,$msg=''){
	$data = array('entity'=>NULL,'msgCode'=>NULL,'msg'=>NULL);
	$data['entity'] = $arr;
	$data['msgCode'] = $msgCode;
	$data['msg'] = $msg;
	return $data;
}
?>