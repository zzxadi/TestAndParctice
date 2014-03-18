<?php
	require_once("../utils/include.php");
	require_once('../action/InterceptAction.php');
	require_once("../dao/WorkOrderDao.php");
	require_once("../class/VacationRecord.php");
	require_once("../class/ForgetCard.php");
	require_once("../dao/ApproveOrderDao.php");
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
		//发邮件所用参数
		$stList = array();
		$stList['currentUserId'] = getParam('auditId','0');
		$stList['userId'] = getUserId();
		$stList['type'] = getParam('type','0');
		$stList['leaveType'] = getParam('reason','0');
		
		$workOrderDao = new WorkOrderDao();
		global $stPrint;
		$result = $workOrderDao->createWorkOrder($vacationRecord,$operateFlag);
		
		if($result['result'] === false){
			$stPrint['msg'] = '新增工单失败';
			dataPrint($stPrint);	
		}else{
			$sArr = array();
			$sArr=$workOrderDao->getWorkOrderListByCreateTime(1,$result['createTime']);
			$stList['vacationId'] = $sArr[0]['ID'];
			$stPrint['entity'] = $result; 
			$stPrint['msgCode'] = 1;
			$stPrint['msg'] = '新增工单成功';
			sendEmail($stList);//发送邮件通知审批人
			dataPrint($stPrint);
			
		}
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
		
		//发邮件所用参数
		$stList = array();
		$stList['currentUserId'] = getParam('auditId','0');
		$stList['userId'] = getUserId();
		$stList['type'] = getParam('type','0')+2;
		$stList['leaveType'] = '';
	 	
	 	$workOrderDao = new WorkOrderDao();
		global $stPrint;
		$result = $workOrderDao->createForgetCard($forgetCard);
		
		if($result['result'] === false){
			$stPrint['msg'] = '新增工单失败';
			dataPrint($stPrint);	
		}else{
			$sArr = array();
			$sArr=$workOrderDao->getWorkOrderListByCreateTime(2,$result['createTime']);
			$stList['vacationId'] = $sArr[0]['ID'];
			$stPrint['entity'] = $result; 
			$stPrint['msgCode'] = 1;
			$stPrint['msg'] = '新增工单成功';
			sendEmail($stList);//发送邮件通知审批人
			dataPrint($stPrint);
		}	 
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
	 /** 发送邮件 **/
	 function sendEmail($stList){
	 	
		header("content-type:text/html;charset=utf-8");
		ini_set("magic_quotes_runtime",0);//不过滤一些特殊字符
		$nList=array();
		$nList=pingEmail($stList);
		require_once('class.phpmailer.php');
		try {
			$mail = new PHPMailer(true);
			$mail->IsSMTP();
			$mail->CharSet='UTF-8'; //设置邮件的字符编码，这很重要，不然中文乱码
			$mail->SMTPAuth = true; //开启认证
			$mail->Port = 25;
			$mail->Host = "smtp.digione.cn";
			$mail->Username = "wangjc@digione.cn";
			$mail->Password = "236155";
			//$mail->IsSendmail(); //如果没有sendmail组件就注释掉，否则出现“Could not execute: /var/qmail/bin/sendmail ”的错误提示
			//$mail->AddReplyTo("phpddt1990@163.com","mckee");//回复地址
			$mail->From = "wangjc@digione.cn";
			$mail->FromName = "DIGIONE_OA";
			$to = $nList['to'];
			$mail->addAddress($to);
			$mail->Subject = "digioneOA系统邮件通知";
			$mail->Body = "<h1>digioneOA系统邮件</h1><p>".$nList['txt']."</p>";
			$mail->AltBody = "--------------digioneOA----------------"; //当邮件不支持html时备用显示，可以省略
			$mail->WordWrap = 80; // 设置每行字符串的长度
			//$mail->AddAttachment("f:/test.png"); //可以添加附件
			$mail->IsHTML(true);
			$mail->Send();
			return true;
		} catch (phpmailerException $e) {
			//$e->errorMessage();
			return false;
		}
	}
	function pingEmail($stList){
		$app=new ApproveOrderDao();
		
		$pArr= array();
		$pArr=$app->getOnePersonDetail($stList['currentUserId']);
		$currentUserName=$pArr[0]['USER_NAME'];
		$currentEmail=$pArr[0]['EMAIL'];
		
		$sArr= array();
		$sArr=$app->getOnePersonDetail($stList['userId']);
		$loginUserName=$sArr[0]['USER_NAME'];
		
		$type=$stList['type'];
		if($type==1){
			$type="加班";	
		}else if($type==2){
			$type="请假";	
		}else if($type==3){
			$type="上班忘打卡";
		}else if($type==4){
			$type="下班忘打卡";
		}
		$leaveType='';
		if($stList['leaveType'])$leaveType='( '.leaveTypeName($stList['leaveType']).' )';	
		$VacationId=$stList['vacationId'];//工单号

		$cTxt = $currentUserName."您好！您有新的来自于 ".$loginUserName." 提交的 ".$type;
		if($leaveType) $cTxt .= $leaveType;
		$cTxt .= " 工单申请（工单号:".$VacationId."）等待您的审批 ！";
		  
		$list= array();
		//$list['to']=$currentEmail;
		$list['to']='kuangj@digione.cn';
		$list['txt']=$cTxt;
		
		return $list;	
	}
	
	function leaveTypeName($leaveType){
		$record_leaveType = '';
		switch($leaveType){
			case 1: $record_leaveType ='事假';break;
			case 2: $record_leaveType ='病假';break;
			case 3: $record_leaveType ='调休';break;
			case 4: $record_leaveType ='婚假';break;
			case 5: $record_leaveType ='产假';break;
			case 6: $record_leaveType ='计生假';break;
			case 7: $record_leaveType ='年休假';break;
			case 8: $record_leaveType ='丧假';break;
			case 9: $record_leaveType ='工伤假';break;
			case 10: $record_leaveType ='出差';break;
			case 11: $record_leaveType ='其他假';break;
			default :$record_leaveType ='';
		}
		return $record_leaveType;
	}
	
?>