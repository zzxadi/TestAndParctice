<?php
	require_once("../utils/include.php");
	require_once("../dao/UserInfoDAO.php");
	require_once('../action/InterceptAction.php');

	$type = getParamByName('method');
	$iDataType = getParam("DataType","0");
	$id = getParam("id", getUserId());
	$stUsername = getParam("username","");
	$stLoginname = getParam("loginname", "");
	$stMobile = getParam("mobile", "");
	$stEmail = getParam("email", "");
	$iSex = getParam("sex", "0");
	$iDept = getParam("dept", "1");
	$stPosition = getParam("position", "");
	$stIndTime = getParam("indTime", "");
	$iRoleId = getParam("roleId", "0");
	$iPageSize = getParam("pageSize", "20");
	$iPage = getParam("currentPage", "1");
	$stPrint = array();
	$stPrint["fieldArray"] = array();
	$stPrint["dataType"] = $iDataType;
	$stPrint["entity"] = false;
	$stPrint["msgCode"] = 2;
	$stPrint["msg"] = '访问异常';

	$stInfo = array();
	$stInfo['username'] = $stUsername;
	$stInfo['loginname'] = $stLoginname;
	$stInfo['mobile'] = $stMobile;
	$stInfo['email'] = $stEmail;
	$stInfo['sex'] = $iSex;
	$stInfo['dept'] = $iDept;
	$stInfo['position'] = $stPosition;
	$stInfo['indTime'] = $stIndTime;
	$stInfo['roleId'] = $iRoleId;
	$stInfo['id'] = $id;
	$stInfo['count'] = $iPageSize;
	$stInfo['page'] = $iPage;

	switch($type){
		case 'doAdd':
			doAdd($stInfo);
			break;
		case 'getUserById':
			getUserById($id);
			break;
		case 'doModify':
			doModify($stInfo);
			break;
		case 'doFreeze':
			doFreeze($id);
			break;
		case 'getUserList':
			getUserList($stInfo);
			break;
	}
	

	function doAdd($stInfo){
		$user = new UserInfoDAO();
		$stData = $user->doAdd($stInfo);
		if($stData){
			$stPrint["entity"] = $stData; 
			$stPrint["msgCode"] = 1;
			$stPrint["msg"] = "添加用户成功";
			dataPrint($stPrint);
		}
		else{
			$stPrint['entity'] = '';
			$stPrint['msgCode'] = 2;
			$stPrint['msg'] = '删除失败';
			dataPrint($stPrint);	
		}
	}

	function doModify($stInfo){
		$user = new UserInfoDAO();
		$stData = $user->doModify($stInfo);
		if($stData){
			$stPrint["entity"] = $stData; 
			$stPrint["msgCode"] = 1;
			$stPrint["msg"] = "添加用户成功";
			dataPrint($stPrint);
		}
		else{
			$stPrint['entity'] = '';
			$stPrint['msgCode'] = 2;
			$stPrint['msg'] = '删除失败';
			dataPrint($stPrint);	
		}
	}

	function getUserById($id){
		$user = new UserInfoDAO();
		$stData = $user->getUserById($id);
		if($stData){
			$stPrint["entity"] = $stData; 
			$stPrint["msgCode"] = 1;
			$stPrint["msg"] = "添加用户成功";
			dataPrint($stPrint);
		}
		else{
			$stPrint['entity'] = '';
			$stPrint['msgCode'] = 2;
			$stPrint['msg'] = '删除失败';
			dataPrint($stPrint);	
		}
	}

	function getUserList($stInfo){
		$user = new UserInfoDAO();
		$stData = $user->getUserList($stInfo);
		if($stData){
			$stPrint["entity"] = $stData; 
			$stPrint["msgCode"] = 1;
			$stPrint["msg"] = "添加用户成功";
			dataPrint($stPrint);
		}
		else{
			$stPrint['entity'] = '';
			$stPrint['msgCode'] = 2;
			$stPrint['msg'] = '删除失败';
			dataPrint($stPrint);	
		}		
	}

	function doFreeze($id){
		$user = new UserInfoDAO();
		$stData = $user->doFreeze($id);
		if($stData){
			$stPrint["entity"] = $stData; 
			$stPrint["msgCode"] = 1;
			$stPrint["msg"] = "添加用户成功";
			dataPrint($stPrint);
		}
		else{
			$stPrint['entity'] = '';
			$stPrint['msgCode'] = 2;
			$stPrint['msg'] = '删除失败';
			dataPrint($stPrint);	
		}	
	}
?>