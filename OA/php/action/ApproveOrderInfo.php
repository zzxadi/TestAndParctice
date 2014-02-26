<?php
	require_once("../utils/include.php");
	require_once("../class/VacationRecord.php");
	require_once("../class/VacationLog.php");
	require_once("../class/ForgetCard.php");
	require_once("../dao/ApproveOrderDao.php");
	$currentPage=getParam('currentPage','1');
	$pageSize = $_POST['pageSize'];
	$userId=$_POST['userId'];
	$status=$_POST['status'];//代表 审核状态
	$method=$_POST['method'];
	$pageNo=$_POST['pageNo'];
	$pageType=(int)$_POST['pageType'];//用来判断是忘打卡，还是普通请假类
	$approveType=(int)$_POST['approveType'];
	$approveId=(int)$_POST['approveId'];
	$approveRadioStatus=(int)$_POST['approveRadioStatus'];
	$approveOpinion=$_POST['approveOpinion'];
	$approveMangerId=(int)$_POST['approveMangerId'];
	$approveCurrentTime=$_POST['updateTime'];

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

	$VacationInfo=array();
	$VacationInfo['userId']=$userId;
	$VacationInfo['status']= $status;
	$VacationInfo['pageNo']= $pageNo;
	$VacationInfo['pageSize']= $pageSize;
	$VacationInfo['id']= $approveId;	
	$VacationInfo['pageType']= $pageType;
			   			
	$VacationInfo['approveType']= $approveType;
	$VacationInfo['approveRadioStatus']= $approveRadioStatus;
	$VacationInfo['approveOpinion']= $approveOpinion;
	$VacationInfo['approveMangerId']= $approveMangerId;
	$VacationInfo['approveCurrentTime']= $approveCurrentTime;

	//$VacationInfo['CurrentPage']= $CurrentPage;
	
	switch($method){
		case 'appOrderList':getOrderList($VacationInfo);break;
		case 'forOrderList' :getForgetOrderList($VacationInfo);break;
		case 'dateDetail' :getApproveDetail($VacationInfo);;break;
		case 'managerList': getApproveMangerList();break;
		case 'updateAPP' :updateApprove($VacationInfo);
							//insertVacationLog();
							break;
		case 'userRoleKey' :getCurrentRoleKey($VacationInfo);break;	
		case 'updatefor': updateForgetCard();
							//insertVacationLog();
							break;
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
		$VacaBean->setPreviousUserid( getParam('userId',' '));
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
		$forBean->setPreviousUserid( getParam('userId',' '));
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
		 $LogBean->setUserId((int)getParam('userId',' '));
		 if($AppDao->insertVactionLog()){
			echo '{"entity":"","msgCode":"1","msg":"编辑成功"}';
		}else{
			echo '{"entity":"","msgCode":"2","msg":"编辑失败"}';
		}
	 }
	
	//查询工单
	function getOrderList($kk){
		$AppDao=new ApproveOrderDao();
		$stData=$AppDao->getList($kk);	
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
	function getForgetOrderList($kk){
		$AppDao=new ApproveOrderDao();
		$stData=$AppDao->getForgetOrderListDao($kk);	
		if($stData === false){
			$stPrint["msg"] = $AppDao->lastError;
			dataPrint($stPrint);	
		}
		$stPrint["entity"] = $stData; 
		$stPrint["msgCode"] = 1;
		$stPrint["msg"] = "成功";
		dataPrint($stPrint);
	}
	//获得工单详情
	function getApproveDetail($kk){
		$AppDao=new ApproveOrderDao();
		$stData=$AppDao->getApproveDetail($kk);	
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
	function getCurrentRoleKey($kk){
		$AppDao = new ApproveOrderDao();
		$stData = $AppDao->getCurrentRoleKey($kk);
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