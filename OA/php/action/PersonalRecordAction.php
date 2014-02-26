<?php
	require_once("../utils/include.php");
	require_once("../dao/PersonalRecordDao.php");
	$iDataType = getParam("DataType","0");
	$Id = getUserId();
	$Type = getParam("Type", "");	
	$iPageSize = getParam("pageSize", "20");
	$iPage = getParam("currentPage", "1");
	
	$stPrint = array();
	$stPrint["fieldArray"] = array();
	$stPrint["dataType"] = $iDataType;
	$stPrint["entity"] = false;
	$stPrint["msgCode"] = 2;
	$stPrint["msg"] = '访问异常';	
	//权限判断
	if(!isLogin()){
		$stPrint["msgCode"] = 3;
		$stPrint["msg"] = '您尚未登录';
		dataPrint($stPrint);
	}
	$stInfo = array();
	$stInfo['Id'] = $Id;
	$stInfo['count'] = $iPageSize;
	$stInfo['page'] = $iPage;
	$stInfo['type'] = $Type;

	$user = new PersonRecordDao();
	$stData = $user->getList($stInfo);
	if($stData === false){
		$stPrint["msg"] = "获取数据失败";
		dataPrint($stPrint);
	}
	$stPrint["entity"] = $stData; 
	$stPrint["msgCode"] = 1;
	$stPrint["msg"] = "成功";

	dataPrint($stPrint);
?>