<?php
require_once('../class/RoleMenu.php');
require_once('../dao/RoleMenuDao.php');
require_once('../utils/common.php');
require_once('../utils/module.php');
$error = '';
/*------------
这里放用户登录验证。
-------------*/
$type = getParamByName('type');
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
		$error = $rmList;
		$rmData = jsonFrame(array(),2,$error);
	}else{
		$rmData = jsonFrame($rmList,1,'');
	}
	return dataPrint($rmData);	
}
//添加、更新数据
function updateRecord(){
	$rmMenu = new RoleMenu();
	$rmMenuDao = new RoleMenuDao();
	$rmMenuDao->setRoleMenu($rmMenu);
	$role_id = $rmMenu->setRoleId(getParam('role_id',''));
	$menuStr = getParam('menu_id','');
	$menu_id =  preg_split('/_/',$menuStr);
	if($rmMenuDao->updateRecord($menu_id)){
		echo '{"entity":"","msgCode":"1","msg":"编辑成功"}';
	}else{
		echo '{"entity":"","msgCode":"2","msg":"编辑失败"}';
	}
}
function jsonFrame($arr,$msgCode=0,$msg=''){
	$data = array('entity'=>NULL,'msgCode'=>NULL,'msg'=>NULL);
	$data['entity'] = $arr;
	$data['msgCode'] = $msgCode;
	$data['msg'] = $msg;
	return $data;
}
?>