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
	$vacationType = getParam("vacationType", "");
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
	
	$vacationInfo = array();
	$vacationInfo['userId'] = getParam("userId", "");
	$vacationInfo['vacationType'] = getParam("vacationType", "");
	$vacationInfo['remain'] = getParam("remain", "");

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
		case 'getUserByLoginname':
			getUserByLoginname($stLoginname);  
			break;
		case 'updateVacation':
			updateVacation($vacationInfo);
			break;
		case 'getVacationById':
			getVacationById($id);
			break;  
		case 'getVacationByIdTYPE':
			getVacationByIdTYPE($id,$vacationType);
			break;  
		case 'ModifyVacation':
			ModifyVacation($vacationInfo);
			break;			
	}

	function updateVacation($vacationInfo){
		$user = new UserInfoDAO();
		$stData = $user->updateVacation($vacationInfo);
		if($stData){
			$stPrint["entity"] = $stData; 
			$stPrint["msgCode"] = 1;
			$stPrint["msg"] = "添加假期记录成功";
			dataPrint($stPrint);
		}
		else{
			$stPrint['entity'] = '';
			$stPrint['msgCode'] = 2;
			$stPrint['msg'] = '添加假期记录失败';
			dataPrint($stPrint);	
		}
	}
	
	function ModifyVacation($vacationInfo){
		$user = new UserInfoDAO();
		$stData = $user->ModifyVacation($vacationInfo);
		if($stData){
			$stPrint["entity"] = $stData; 
			$stPrint["msgCode"] = 1;
			$stPrint["msg"] = "修改假期记录成功";
			dataPrint($stPrint);
		}
		else{
			$stPrint['entity'] = '';
			$stPrint['msgCode'] = 2;
			$stPrint['msg'] = '修改假期记录失败';
			dataPrint($stPrint);	
		}
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
	
	function getVacationById($id){
		$user = new UserInfoDAO();
		$stData = $user->getVacationById($id);
		if($stData){
			$stPrint["entity"] = $stData; 
			$stPrint["msgCode"] = 1;
			$stPrint["msg"] = "查询成功";
			dataPrint($stPrint);
		}
		else{
			$stPrint['entity'] = '';
			$stPrint['msgCode'] = 2;
			$stPrint['msg'] = '查询失败';
			dataPrint($stPrint);	
		}
	}
	
	function getVacationByIdTYPE($id,$vacationType){
		$user = new UserInfoDAO();
		$stData = $user->getVacationByIdTYPE($id,$vacationType);
		if($stData){
			$stPrint["entity"] = $stData; 
			$stPrint["msgCode"] = 1;
			$stPrint["msg"] = "查询成功";
			dataPrint($stPrint);
		}
		else{
			$stPrint['entity'] = '';
			$stPrint['msgCode'] = 2;
			$stPrint['msg'] = '查询失败';
			dataPrint($stPrint);	
		}
	}
	
	function getUserByLoginname($stLoginname){
		$user = new UserInfoDAO();
		$stData = $user->getUserByLoginname($stLoginname);
		if($stData){
			$stPrint["entity"] = $stData; 
			$stPrint["msgCode"] = 1;
			$stPrint["msg"] = "查询成功";
			dataPrint($stPrint);
		}
		else{
			$stPrint['entity'] = '';
			$stPrint['msgCode'] = 2;
			$stPrint['msg'] = '查询失败';
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