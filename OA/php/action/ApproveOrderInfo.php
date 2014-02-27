<?php
	
	require_once("../utils/include.php");
	require_once( "../action/InterceptAction.php");
	require_once("../class/VacationRecord.php");
	require_once("../class/VacationLog.php");
	require_once("../class/ForgetCard.php");
	require_once("../dao/ApproveOrderDao.php");
	$currentPage=getParam('currentPage','1');
	$method=getParam('method','');
	switch($method){
		case 'appOrderList':getOrderList();break;
		case 'forOrderList' :getForgetOrderList();break;
		case 'dateDetail' :getApproveDetail();break;
		case 'managerList': getApproveMangerList();break;
		case 'updateAPP' :updateApprove();		break;
		case 'userRoleKey' :getCurrentRoleKey();break;	
		case 'updatefor': updateForgetCard();break;
		case 'insert': insertVacationLog();break;
	}
	//更新工单 
	function updateApprove(){
		$AppDao=new ApproveOrderDao();
		$VacaBean=new VacationRecord();	
		$VacaBean->setAuditRemark(getParam('approveOpinion',' '));
		$VacaBean->setAuditStatus( getParam('approveRadioStatus',' '));
		$VacaBean->setAuditTime( getParam('updateTime',' '));
		$VacaBean->setCurrentUserid( getParam('approveMangerId',' '));
		$VacaBean->setPreviousUserid((int)getUserId());
		$VacaBean->setId( getParam('approveId',' '));
		$AppDao->setVacationRecord($VacaBean);
		if($AppDao->updateApproveDao()){
			echo '{"entity":"","msgCode":"1","msg":"编辑成功"}';
		}else{
			echo '{"entity":"","msgCode":"2","msg":"编辑失败"}';
		}
	}
	//更新忘打卡
	 function updateForgetCard(){
		$AppDao=new ApproveOrderDao();
		$forBean=new ForgetCard();
		$forBean->setAuditRemark(getParam('approveOpinion',' '));
		$forBean->setAuditStatus(getParam('approveRadioStatus',' '));
		$forBean->setAuditTime(getParam('updateTime',' '));
		$forBean->setCurrentUserid(getParam('approveMangerId',' '));
		$forBean->setPreviousUserid((int)getUserId());
		$forBean->setId( getParam('approveId',' '));
		$AppDao->setVacationRecord($VacaBean);
		if($AppDao->updateApproveDao()){
			echo '{"entity":"","msgCode":"1","msg":"编辑成功"}';
		}else{
			echo '{"entity":"","msgCode":"2","msg":"编辑失败"}';
		}
	 }
	 //插入操作日志
	 function insertVacationLog(){
		 $AppDao=new ApproveOrderDao();
		 $LogBean=new VacationLog();
		 $AppDao->setVacationLog($LogBean);
		 $approveRadioStatus=(int)getParam('approveRadioStatus','0');
		 if($approveRadioStatus==1||$approveRadioStatus==2){
			$approveRadioStatus='允许操作';
		 }else{
			 $approveRadioStatus='驳回操作';
		 }
		 $LogBean->setBillId( (int)getParam('approveId',' '));
		 $LogBean->setContent("操作人：".getParam('currentName','')." 对工单号：".getParam('approveId',' ')." 进行了：".$approveRadioStatus,'');
		 $LogBean->setCreateTime(getParam('updateTime',' '));
		 $LogBean->setType((int)getParam('approveType',' '));
		 $LogBean->setUserId((int)getUserId());
		 if($AppDao->insertVactionLog()){
			echo '{"entity":"","msgCode":"1","msg":"编辑成功"}';
		}else{
			echo '{"entity":"","msgCode":"2","msg":"编辑失败"}';
		}
	 }
	
	//查询工单
	function getOrderList(){
		$VacationInfo=array();
		$VacationInfo['userId']=(int)getUserId();
		$VacationInfo['status']= getParam('status','');
		$VacationInfo['pageNo']= getParam('pageNo','');
		$VacationInfo['pageSize']= getParam('pageSize','');
		$VacationInfo['pageType']= (int)getParam('pageType','');		   			
		$AppDao=new ApproveOrderDao();
		$stData=$AppDao->getList($VacationInfo);	
		if($stData === false){
			$stPrint["msg"] = $AppDao->lastError;
			dataPrint($stPrint);	
		}
		$stPrint["entity"] = $stData; 
		$stPrint["msgCode"] = 1;
		$stPrint["msg"] = "成功";
		dataPrint($stPrint);
	}
	
	//查询忘打卡记录
	function getForgetOrderList(){
		$VacationInfo=array();
		$VacationInfo['userId']=(int)getUserId();
		$VacationInfo['status']= getParam('status','');
		$VacationInfo['pageNo']= getParam('pageNo','');
		$VacationInfo['pageSize']= getParam('pageSize','');
		$VacationInfo['pageType']= (int)getParam('pageType','');		   			
		$AppDao=new ApproveOrderDao();
		$stData=$AppDao->getForgetOrderListDao($VacationInfo);
		if($stData === false ){
			$stPrint["msg"] = $AppDao->lastError;
			dataPrint($stPrint);	
		}
		$stPrint["entity"] = $stData; 
		$stPrint["msgCode"] = 1;
		$stPrint["msg"] = "成功";
		dataPrint($stPrint);
	}
	//获得工单详情
	function getApproveDetail(){
		$AppDao=new ApproveOrderDao();
		$VacationInfo=array();
		$VacationInfo['id']= (int)getParam('approveId','');	
		$VacationInfo['approveType']= (int)getParam('approveType','');	
		$stData=$AppDao->getApproveDetail($VacationInfo);	
		if($stData === false){
			$stPrint["msg"] = $AppDao->lastError;
			dataPrint($stPrint);	
		}
		$stPrint["entity"] = $stData; 
		$stPrint["msgCode"] = 1;
		$stPrint["msg"] = "成功";
		dataPrint($stPrint);
	}
	//查询所有工单审批人
	function getApproveMangerList(){
		$AppDao = new ApproveOrderDao();
		$stData = $AppDao->getAllManger();
		if($stData === false){
			$stPrint["msg"] = $AppDao->lastError;
			dataPrint($stPrint);	
		}
		$stPrint["entity"] = $stData; 
		$stPrint["msgCode"] = 1;
		$stPrint["msg"] = "成功";
		dataPrint($stPrint);
	}
	//查询当前用户key值
	function getCurrentRoleKey(){
		$AppDao = new ApproveOrderDao();
		$stData = $AppDao->getCurrentRoleKey(getUserId());
		if($stData === false){
			$stPrint["msg"] = $AppDao->lastError;
			dataPrint($stPrint);	
		}
		$stPrint["entity"] = $stData; 
		$stPrint["msgCode"] = 1;
		$stPrint["msg"] = "成功";
		dataPrint($stPrint);
	}
?>