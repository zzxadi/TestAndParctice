<?php
	require_once("../utils/include.php");
	require_once("../dao/LoginDAO.php");

	$iDataType = getParam("dataType","0");
	$oldPwd = getParam("oldPwd","");
	$newPwd = getParam("newPwd","");
	$stPrint = array();
	$stPrint["fieldArray"] = array();
	$stPrint["dataType"] = $iDataType;
	$stPrint["entity"] = false;
	$stPrint["msgCode"] = 2;
	$stPrint["msg"] = '访问异常';

	if(empty($oldPwd)){
		$stPrint["msgCode"] = 3;
		$stPrint["msg"] = '旧密码不能为空';
		dataPrint($stPrint);	
	}
	if(empty($newPwd)){
		$stPrint["msgCode"] = 4;
		$stPrint["msg"] = '新密码不能为空';
		dataPrint($stPrint);
	}
	$dao = new LoginDAO();
	$stData = $dao->updatePwd($oldPwd, $newPwd);
	if($stData){
		$stPrint["entity"] = $stData;
		$stPrint["msgCode"] = 1;
		$stPrint["msg"] = "修改密码成功";
	}else{
		$stPrint["msgCode"] = 5;
		$stPrint["msg"] = "修改密码失败，请仔细核对旧密码是否正确";
	}
	dataPrint($stPrint);
?>