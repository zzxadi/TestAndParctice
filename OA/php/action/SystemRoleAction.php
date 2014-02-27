<?php
require_once('../class/SystemRole.php');
require_once('../dao/SystemRoleDao.php');
require_once('../utils/common.php');
require_once('../utils/module.php');
$stPrint = array();
$stPrint['entity'] = false;
$stPrint['msgCode'] = 2;
$stPrint['msg'] = '访问异常';
$type = getParamByName('method');
switch($type){
	case 'getRoleList':
		getRoleList();
		break;
	case 'addRecord':
		addRecord();
		break;
	case 'updateRecord':
		updateRecord();
		break;
	case 'getSingleRecord':
		getSingleRecord();
		break;
	case 'delRecord':
		delRecord();
		break;
}
//获取角色列表
function getRoleList(){
	$srRoleDao = new SystemRoleDao();
	$roleList = $srRoleDao->getAllRecord();
	if($roleList != NULL && !is_array($roleList)){
		$stPrint['msgCode'] = 2;
		$stPrint['msg'] = $roleList;
		dataPrint($stPrint);
	}else{
		$stPrint['entity'] = $roleList;
		$stPrint['msgCode'] = 1;
		$stPrint['msg'] = '';
		dataPrint($stPrint);
	}
}
//添加记录
function addRecord(){
	$srRole = new SystemRole();
	$srRoleDao = new SystemRoleDao();
	$srRoleDao->setSystemRole($srRole);
	$srRole->setId(getParam('role_id',''));
	$srRole->setRoleName(getParam('role_name',''));
	$srRole->setRoleKey(getParam('role_key',''));
	$srRole->setRoleDes(getParam('role_des',''));
	if($srRoleDao->addRecord()){
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
//获取单条记录
function getSingleRecord(){
	$param = getParam('paramName','');
	$paramValue = getParam('paramValue','');
	$srRoleDao = new SystemRoleDao();
	$roleRecord = $srRoleDao->getSingleRecord($param,$paramValue);
	if($roleRecord != NULL && !is_array($roleRecord)){
		$stPrint['msgCode'] = 2;
		$stPrint['msg'] = $roleRecord;
		dataPrint($stPrint);
	}else{
		$stPrint['entity'] = $roleRecord;
		$stPrint['msgCode'] = 1;
		$stPrint['msg'] = '';
		dataPrint($stPrint);
	}
}
//更新一条记录
function updateRecord(){
	$srRole = new SystemRole();
	$srRoleDao = new SystemRoleDao();
	$srRoleDao->setSystemRole($srRole);
	$srRole->setId(getParam('role_id',''));
	$srRole->setRoleName(getParam('role_name',''));
	$srRole->setRoleKey(getParam('role_key',''));
	$srRole->setRoleDes(getParam('role_des',''));
	if($srRoleDao->updateRecord()){
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
//删除一条记录
function delRecord(){
	$param = getParam('paramName','');
	$paramValue = getParam('paramValue','');
	$srRoleDao = new SystemRoleDao();
	$roleRecord = $srRoleDao->delRecord($param,$paramValue);
	if($roleRecord){
		$stPrint['entity'] = '';
		$stPrint['msgCode'] = 1;
		$stPrint['msg'] = '删除成功';
		dataPrint($stPrint);	
	}else{
		$stPrint['entity'] = '';
		$stPrint['msgCode'] = 2;
		$stPrint['msg'] = '删除失败';
		dataPrint($stPrint);	
	}
}
?>