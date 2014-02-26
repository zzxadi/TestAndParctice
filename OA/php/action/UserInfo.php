<?php
	require_once("../utils/include.php");
	require_once("../dao/UserInfoDAO.php");
	$iDataType = getParam("DataType","0");
	$stMethod = getParam("method", "");
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
	//权限判断
	/*$iLoginUserID = (int)getUserID();
	if($iLoginUserID <= 0){
		$stPrint["msgCode"] = 3;
		$stPrint["msg"] = '没有登录';
		dataPrint($stPrint);	
	}*/
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
	$user = new UserInfoDAO();
	if($stMethod == 'doAdd'){
		$stData = $user->doAdd($stInfo);
		$stPrint["msg"] = "添加用户成功";
	}
	else if($stMethod == 'getUserById'){
		$stData = $user->getUserById($id);
		$stPrint["msg"] = "查询用户成功";
	}
	else if($stMethod == 'doModify'){
		$stData = $user->doModify($stInfo);
	}
	else if($stMethod == 'freezeUser'){
		$stData = $user->doFreeze($id);
		$stPrint["msg"] = "操作用户成功";
	}
	else{
		$stData = $user->getUserList($stInfo);		
		$stPrint["msg"] = "查询用户成功";
	}
	if($stData === false){
		$stPrint["msg"] = "获取数据失败";
		dataPrint($stPrint);
	}
	$stPrint["entity"] = $stData; 
	$stPrint["msgCode"] = 1;

	dataPrint($stPrint);
?>