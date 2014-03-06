<?php
	
	require_once("../utils/include.php");
	require_once( "../action/InterceptAction.php");
	require_once("../class/VacationRecord.php");
	require_once("../class/VacationLog.php");
	require_once("../class/ForgetCard.php");
	require_once("../dao/ApproveOrderDao.php");
	require_once("../class/Vacation.php");
	require_once( "../action/sendEmail.php");
	$currentPage=getParam('currentPage','1');
	$method=getParam('method','');
	switch($method){
		case 'appOrderList':getOrderList();break;
		case 'forOrderList' :getForgetOrderList();break;
		case 'dateDetail' :getApproveDetail();break;
		case 'managerList': getApproveMangerList();break;
		case 'updateAPP' :updateApprove(); break;
		case 'userRoleKey' :getCurrentRoleKey();break;	
		case 'updatefor': updateForgetCard(); break;
		case 'insert': insertVacationLog();break;
	}
	//更新工单 
	function updateApprove(){
		
		$cId=getParam('approveMangerId',' ');
		if($cId=="undefined"){
			$cId='';
		}
		$aId=getParam('approveId',' ');
		$stList=array();
		$stList['currentUserId']=$cId;
		$stList['userId']=getParam('tiJiaoUserId',' ');
		$stList['previousUserId']=getUserId();
		$stList['vacationId']=getParam('approveId',' ');
		$stList['status']=getParam('approveRadioStatus',' ');
		$stList['type']=getParam('holidayType',' ');
		
		
		$AppDao=new ApproveOrderDao();
		$VacaBean=new VacationRecord();	
		$VacaBean->setAuditRemark(getParam('approveOpinion',' '));
		$VacaBean->setAuditStatus( getParam('approveRadioStatus',' '));
		$VacaBean->setAuditTime( getParam('updateTime',' '));
		$VacaBean->setCurrentUserid( getParam('approveMangerId',' '));
		$VacaBean->setPreviousUserid((int)getUserId());
		$VacaBean->setId( getParam('approveId',' '));
		$AppDao->setVacationRecord($VacaBean);
		
		$vacationBean = new Vacation();
		$vacationBean->setUserId((int)getParam('tiJiaoUserId',' '));
		$leaveType=(int)getParam('leaveType',' ');
		$holiday=(int)getParam('holidayType',' ');// 1:加班 2：请假
		
		if((int)getParam('approveRadioStatus',' ')!=3){//如果非驳回
			if(getParam('roleKey',' ')=='FEND'){//如果是工单终结者
				fendAction($holiday,$leaveType,$vacationBean,$AppDao);
			}else{
				if($AppDao->updateApproveDao()){
					 $key=1;//发邮件给提交申请人
					sendEmail($key,$stList);
					$key=2;//发给next
					sendEmail($key,$stList);
					echo '{"entity":"","msgCode":"1","msg":"编辑成功"}';
				}else{
					echo '{"entity":"","msgCode":"2","msg":"编辑失败"}';
				}
			}
		}
	}
	//工单终结者 操作方法集合
	function fendAction($holiday,$leaveType,$vacationBean,$AppDao){echo "jinlaile";
		$vacationBean->setRemain((int)getParam('totalTime',' '));
		$flag=false;//用来判断更新vacation表的成功与否
		if($holiday == 2){//如果是请假 
			if($leaveType==1||$leaveType==3||$leaveType==7||$leaveType==11){ //1：事假，2：病假，3：调休，4：婚嫁，5：产假，6：计生假，7：年休假，8：丧假，9：工伤假，10：出差，11：其他假',
				if($leaveType==3||$leaveType==1||$leaveType==11){	
					$vacationBean->setVacationType(1);	
					$AppDao->setVacation($vacationBean);
					if($AppDao->selectVacation()){
						$AppDao->updateVaction(2);		
					}else{	
						$flag=$AppDao->insertVacation(2);	
					}
				}else if($leaveType==7){
					$vacationBean->setVacationType(2);
					$AppDao->setVacation($vacationBean);
					if($AppDao->selectVacation()){
						$AppDao->updateVaction(2);		
					}else{
						$flag=$AppDao->insertVacation(2);	
					}
				}
				else if($leaveType==10||$leaveType==2||$leaveType==4||$leaveType==5||$leaveType==6||$leaveType==8||$leaveType==9){
					$flag=true;//暂无操作
				}
				$AppDao->setVacation($vacationBean);
				if($AppDao->updateApproveDao()&&$flag){
					$key=1;
					sendEmail($key,$stList);
					//$key=2;
					//sendEmail($key,$stList);
					echo '{"entity":"","msgCode":"1","msg":"编辑成功"}';
				}else{
					echo '{"entity":"","msgCode":"2","msg":"编辑失败"}';
				}
			}
		}else if($holiday == 1){//如果是加班
				$vacationBean->setVacationType(1);
				$AppDao->setVacation($vacationBean);
				$AppDao->setVacation($vacationBean);
			if($AppDao->selectVacation()){
				$flag=$AppDao->updateVaction(1);		
			}else{
				$flag=$AppDao->insertVacation(1);	
			}
		}	
	}
		//更新忘打卡
	function updateForgetCard(){
		$cId=getParam('approveMangerId',' ');
		if($cId=="undefined"){
			$cId='';
		}
		$aId=getParam('approveId',' ');
		$stList=array();
		$stList['currentUserId']=$cId;
		$stList['userId']=getParam('tiJiaoUserId',' ');
		$stList['previousUserId']=getUserId();
		$stList['vacationId']=getParam('approveId',' ');
		$stList['status']=getParam('approveRadioStatus',' ');
		$stList['type']=getParam('holidayType',' ');
		
		$AppDao=new ApproveOrderDao();
		$forBean=new ForgetCard();
		$forBean->setAuditRemark(getParam('approveOpinion',' '));
		$forBean->setAuditStatus(getParam('approveRadioStatus',' '));
		$forBean->setForgetTime(getParam('updateTime',' '));
		$forBean->setCurrentUserid(getParam('approveMangerId',' '));
		$forBean->setPreviousUserid((int)getUserId());
		$forBean->setId( getParam('approveId',' '));
		$AppDao->setForgetCard($forBean);
		if($AppDao->updateForgetDao()){
			$key=1;
			sendEmail($key,$stList);
			$key=2;
			sendEmail($key,$stList);
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
	function sendEmail($key,$stList){
		header("content-type:text/html;charset=utf-8");
		ini_set("magic_quotes_runtime",0);
		$nList=array();
		$nList=pingEmail($key,$stList);
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
			echo '邮件已发送';
		} catch (phpmailerException $e) {
			echo "邮件发送失败：".$e->errorMessage();
		}
	}
	function pingEmail($key,$stList){//1:向工单提交人发邮件 2：向next工单审批人发邮件		
		$app=new ApproveOrderDao();
		$pArr= array();
		$pArr=$app->getOnePersonDetail($stList['previousUserId']);
		$sArr= array();
		$sArr=$app->getOnePersonDetail($stList['userId']);
		$uUserName=$sArr[0]['USER_NAME'];
		$type=$stList['type'];
		if($type==1){
			$type="加班";	
		}else if($type==2){
			$type="请假";	
		}
		$VacationId=$stList['vacationId'];
		$pName=$pArr[0]['USER_NAME'];
		$status=$stList['status'];
		if($status!=3){
			$status="通过";	
		}else if($type==2){
			$status="驳回";	
		}
		$uEmail=$sArr[0]['EMAIL'];
		if($stList['currentUserId']!=''){
			$cArr= array();
			$cArr=$app->getOnePersonDetail($stList['currentUserId']);
			$cEmail=$cArr[0]['EMAIL'];
			$currentUserName=$cArr[0]['USER_NAME'];
			$cto=$cEmail;
			$cTxt = $currentUserName." 您有新的来自于 ".$uUserName." 提交的 ".$type." 工单申请（工单号".$VacationId.'）等待您的审批';
		}
		//给申请人发邮件
		$uto=$uEmail;
		$subject = "My subject";
		
		  $uTxt = $uUserName." 您的".$type." 工单申请（".$VacationId.'工单号）被 '.$pName." ".$status;
		  
		$list= array();
		if($key==1){
			$list['to']=$uto;
			$list['txt']=$uTxt;	
		}else if($key==2){
			$list['to']=$uto;
			$list['txt']=$cTxt;
		}
		return $list;
			
		}
		
	

?>