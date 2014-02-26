<?php
require_once('../class/SystemRole.php');
require_once('../dao/SystemRoleDao.php');
require_once('../utils/common.php');
require_once('../utils/module.php');
$error = '';
$type = getParamByName('type');
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
		$error = $roleList;
		$srData = jsonFrame(array(),2,$error);
	}else{
		$srData = jsonFrame($roleList,1,'');
	}
	return dataPrint($srData);
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
		echo '{"entity":"","msgCode":"1","msg":"数据添加成功"}';
	}else{
		echo '{"entity":"","msgCode":"2","msg":"数据添加失败"}';
	}
}
//获取单条记录
function getSingleRecord(){
	$param = getParam('paramName','');
	$paramValue = getParam('paramValue','');
	$srRoleDao = new SystemRoleDao();
	$roleRecord = $srRoleDao->getSingleRecord($param,$paramValue);
	if($roleRecord != NULL && !is_array($roleRecord)){
		$error = $roleRecord;
		$srData = jsonFrame(array(),2,$error);
	}else{
		$srData = jsonFrame($roleRecord,1,'');
	}
	return dataPrint($srData);
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
		echo '{"entity":"","msgCode":"1","msg":"编辑成功"}';
	}else{
		echo '{"entity":"","msgCode":"2","msg":"编辑失败"}';
	}
}
//删除一条记录
function delRecord(){
	$param = getParam('paramName','');
	$paramValue = getParam('paramValue','');
	$srRoleDao = new SystemRoleDao();
	$roleRecord = $srRoleDao->delRecord($param,$paramValue);
	if($roleRecord){
		echo '{"entity":"","msgCode":"1","msg":"删除成功"}';
	}else{
		echo '{"entity":"","msgCode":"2","msg":"删除失败"}';
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