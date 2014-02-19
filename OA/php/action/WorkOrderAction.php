<?php
	require_once("../utils/common.php");
	require_once("../dao/WorkOrderDao.php");
	require_once("../class/VacationRecord.php");
	
	$iDataType = getParam("DataType","0");
	$stPrint = array();
	$stPrint["FieldArray"] = array();
	$stPrint["DataType"] = $iDataType;
	$stPrint["Entity"] = false;
	$stPrint["MsgCode"] = 2;
	$stPrint["Msg"] = '访问异常';
	
	$requestMethod = getParam('method','0');
	
	if($requestMethod == 'addLeaveTrip'){
		addLeaveTrip();
	}
	
	//新增请假/调休单
	function addLeaveTrip(){
		$vacationRecord = new VacationRecord();
		
		$vacationRecord->setType('1');	//类型：请假或出差
		$vacationRecord->setCurrentUserid(getParam('auditId','0'));
		$vacationRecord->setBeginTime(getParam('leaveTimeBegin','0'));
		$vacationRecord->setEndTime(getParam('leaveTimeEnd','0'));
		$vacationRecord->setRemark(getParam('remark','0'));
		$vacationRecord->setLevelType(getParam('reason','0'));
		
		$workOrderDao = new WorkOrderDao();
		global $stPrint;
		$result = $workOrderDao->add($vacationRecord);
		
		if($result === false){
			$stPrint["Msg"] = $workOrderDao->lastError;
			dataPrint($stPrint);	
		}
		$stPrint["Entity"] = $result; 
		$stPrint["MsgCode"] = 1;
		$stPrint["Msg"] = "成功";
		dataPrint($stPrint);
	}
	
	//获取工单记录
	function getWordOrderList(){
		
	}
	
?>