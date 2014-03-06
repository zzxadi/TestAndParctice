<?php
	require_once("../utils/include.php");
	require_once('../action/InterceptAction.php');
	require_once("../dao/WorkOrderDao.php");
	require_once("../class/VacationRecord.php");
	require_once("../class/ForgetCard.php");
	$requestMethod = getParam('method','0');
	
	/**
	 * 操作选择
	 */
	if($requestMethod == 'addLeaveTrip' || $requestMethod == 'addOvertimeRequest'){
		addWorkOrder($requestMethod);
	}else if($requestMethod == 'addForgetCard'){
		addForgetCard();
	}else if($requestMethod == 'vacationList' || $requestMethod == 'forgetCardList'){
		getWordOrderList($requestMethod);
	}else if($requestMethod == 'detail'){
		$operateStr = getParam('operateStr','0');
		getWorkOrderDetail($operateStr);
	}
	
	/**
	 * 新增请假/出差单、加班申请单
	 */
	function addWorkOrder($operateFlag){
		$vacationRecord = new VacationRecord();
		
		$vacationRecord->setUserId(getUserId());
		$vacationRecord->setType(getParam('type','0'));	//类型1：加班  2：请假/出差
		$vacationRecord->setCurrentUserid(getParam('auditId','0'));
		$vacationRecord->setBeginTime(getParam('timeBegin','0'));
		$vacationRecord->setEndTime(getParam('timeEnd','0'));
		$vacationRecord->setTotalTime(getParam('totalTime','0'));
		$vacationRecord->setRemark(getParam('remark','0'));
		$vacationRecord->setLeaveType(getParam('reason','0'));
		$vacationRecord->setLeaveName(getParam('otherReason','0'));
		$vacationRecord->setAuditStatus(0);
		
		$workOrderDao = new WorkOrderDao();
		global $stPrint;
		$result = $workOrderDao->createWorkOrder($vacationRecord,$operateFlag);
		
		if($result === false){
			$stPrint['msg'] = '新增工单失败';
			dataPrint($stPrint);	
		}
		$stPrint['entity'] = $result; 
		$stPrint['msgCode'] = 1;
		$stPrint['msg'] = '新增工单成功';
		dataPrint($stPrint);
	}
	/**
	 * 新增忘打卡记录
	 */
	 function addForgetCard(){
	 	$forgetCard = new ForgetCard();
	 	
	 	$forgetCard->setUserId(getUserId());
	 	$forgetCard->setType(getParam('type','0'));	//忘记类型1：上班 2：下班
	 	$forgetCard->setCurrentUserid(getParam('auditId','0'));
	 	$forgetCard->setForgetTime(getParam('forgetTime','0'));
	 	$forgetCard->setInTime(getParam('inTime','0'));
	 	$forgetCard->setRemark(getParam('remark','0'));
	 	$forgetCard->setAuditStatus(0);
	 	
	 	$workOrderDao = new WorkOrderDao();
		global $stPrint;
		$result = $workOrderDao->createForgetCard($forgetCard);
		
		if($result === false){
			$stPrint['msg'] = '新增工单失败';
			dataPrint($stPrint);	
		}
		$stPrint['entity'] = $result; 
		$stPrint['msgCode'] = 1;
		$stPrint['msg'] = '新增工单成功';
		dataPrint($stPrint);
	 }
	
	/**
	 * 获取工单记录
	 */
	function getWordOrderList($flag){
		$workOrderDao = new WorkOrderDao();
		global $stPrint;
		
		$searchParam = array();
		$pageSize = getParam("pageSize", "20");
		$currentPage = getParam("currentPage", "1");
		$searchParam['userId'] = getUserId();
		$searchParam['pageSize'] = $pageSize;
		$searchParam['currentPage'] = $currentPage;
		
		$result = $workOrderDao->getWorkOrderList($searchParam,$flag);
		
		if($result === false){
			$stPrint['msg'] = '获取工单信息失败';
			dataPrint($stPrint);	
		}
		$stPrint['entity'] = $result; 
		$stPrint['msgCode'] = 1;
		$stPrint['msg'] = '获取工单信息成功';
		dataPrint($stPrint);
	}
	
	/**
	 * 通过ID获取工单信息
	 */
	 function getWorkOrderDetail($flag){
	 	$workOrderDao = new WorkOrderDao();
		global $stPrint;
		
	 	$id = getParam('id', '');
	 	$result = $workOrderDao->getWorkOrderById($id,$flag);
	 	
	 	if($result === false){
			$stPrint['msg'] = '获取工单信息失败';
			dataPrint($stPrint);	
		}
		$stPrint['entity'] = $result; 
		$stPrint['msgCode'] = 1;
		$stPrint['msg'] = '获取工单信息成功';
		dataPrint($stPrint);
	 }
?>