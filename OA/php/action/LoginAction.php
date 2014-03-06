<?php
	require_once("../utils/include.php");
	require_once("../dao/LoginDAO.php");

	$iDataType = getParam("dataType","0");
	$email = getParam("email","");
	$passwd = getParam("passwd","");
	$loginname = getParam("loginname","");
	$method = getParam("method","");
	$stPrint = array();
	$stPrint["fieldArray"] = array();
	$stPrint["dataType"] = $iDataType;
	$stPrint["entity"] = false;
	$stPrint["msgCode"] = 2;
	$stPrint["msg"] = '访问异常';

	$dao = new LoginDAO();
	if($method == 'logout'){
		$stData = $dao->logout();
		if($stData){
			$stPrint["entity"] = $stData;
			$stPrint["msgCode"] = 1;
			$stPrint["msg"] = "退出登录成功";
			dataPrint($stPrint);
		}else{
			$stPrint["msgCode"] = 5;
			$stPrint["msg"] = "退出登录失败";
			dataPrint($stPrint);
		}
	}
	else if($method == 'checkLoginnameMul'){
		$stData = $dao->checkLoginnameMul($loginname);
		if($stData){
			$stPrint["entity"] = $stData;
			$stPrint["msgCode"] = 1;
			$stPrint["msg"] = "登录名不重复";
			dataPrint($stPrint);
		}else{
			$stPrint["msgCode"] = 2;
			$stPrint["msg"] = "登录名重复";
			dataPrint($stPrint);
		}		
	}
	else{
		if(empty($email)){
			$stPrint["msgCode"] = 3;
			$stPrint["msg"] = '邮箱不能为空';
			dataPrint($stPrint);	
		}
		if(empty($passwd)){
			$stPrint["msgCode"] = 4;
			$stPrint["msg"] = '密码不能为空';
			dataPrint($stPrint);
		}
		$stData = $dao->login($email, $passwd);
		if($stData && $stData['status'] == 0){
			$stPrint["entity"] = $stData;
			$stPrint["msgCode"] = 1;
			$stPrint["msg"] = "登录成功";
			dataPrint($stPrint);			
		}
		else if($stData && $stData['status'] == 1){
			$stPrint["msgCode"] = 6;
			$stPrint["msg"] = "该用户已经被冻结，登录失败";
			dataPrint($stPrint);			
		}
		else{
			$stPrint["msgCode"] = 5;
			$stPrint["msg"] = "邮箱或用户名不正确，登录失败";
			dataPrint($stPrint);			
		}
	}
?>