<?php
	require_once("../utils/include.php");
	require_once("../dao/UserInfoDAO.php");
	$iDataType = getParam("DataType","0");
	$Id = getParam("Id", "");
	$stUsername = getParam("username","");
	$stEmail = getParam("email", "");
	$iRoleId = getParam("roleId", "0");
	$iPageSize = getParam("pageSize", "20");
	$iPage = getParam("currentPage", "1");
	$stPrint = array();
	$stPrint["FieldArray"] = array();
	$stPrint["DataType"] = $iDataType;
	$stPrint["Entity"] = false;
	$stPrint["MsgCode"] = 2;
	$stPrint["Msg"] = '访问异常';
	//权限判断
	/*$iLoginUserID = (int)getUserID();
	if($iLoginUserID <= 0){
		$stPrint["MsgCode"] = 3;
		$stPrint["Msg"] = '没有登录';
		dataPrint($stPrint);	
	}*/
	$stInfo = array();
	$stInfo['username'] = $stUsername;
	$stInfo['email'] = $stEmail;
	$stInfo['roleId'] = $iRoleId;
	$stInfo['Id'] = $Id;
	$stInfo['count'] = $iPageSize;
	$stInfo['page'] = $iPage;

	$user = new UserInfoDAO();
	$stData = $user->getUserList($stInfo);
	if($stData === false){
		$stPrint["Msg"] = "获取数据失败";
		dataPrint($stPrint);
	}
	$stPrint["Entity"] = $stData; 
	$stPrint["MsgCode"] = 1;
	$stPrint["Msg"] = "成功";

	dataPrint($stPrint);
?>