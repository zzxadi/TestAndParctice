<?php
	require_once("../utils/include.php");
	require_once('../action/InterceptAction.php');
	require_once("../dao/PersonalRecordDao.php");
	$method = getParamByName('method');
	if($method == 'getData'){
		getData();
	}
	function getData(){
		$iDataType = getParam("DataType","0");
		$Id = getUserId();
		$Type = getParam("Type", "");	
		$iPageSize = getParam("pageSize", "20");
		$iPage = getParam("currentPage", "1");

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
	}
	
?>