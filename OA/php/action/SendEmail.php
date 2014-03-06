<?php
require_once("../dao/ApproveOrderDao.php");
class SendEmail{
	function sendMail($arr){
		$app=new ApproveOrderDao();
		$pArr= array();
		$pArr=$app->getOnePersonDetail($arr['previousUserId']);
		$sArr= array();
		$sArr=$app->getOnePersonDetail($arr['userId']);
		$uUserName=$sArr[0]['USER_NAME'];
		$type=$arr['type'];
		if($type==1){
			$type="加班";	
		}else if($type==2){
			$type="请假";	
		}
		$VacationId=$arr['vacationId'];
		$pName=$pArr[0]['USER_NAME'];
		$status=$arr['status'];
		if($status!=3){
			$status="通过";	
		}else if($type==2){
			$status="驳回";	
		}
		$uEmail=$sArr[0]['EMAIL'];
		if($arr['currentUserId']!=''){
			$cArr= array();
			$cArr=$app->getOnePersonDetail($arr['currentUserId']);
			$cEmail=$cArr[0]['EMAIL'];
			$currentUserName=$cArr[0]['USER_NAME'];
			$to=$cEmail;
			$subject = "My subject";
			$txt = $currentUserName." 您有新的来自于".$uUserName."提交的".$type." 工单申请（".$VacationId.'工单号）等待您的审批';
			$headers = "From: " . "\r\n" ;
			mail($to,$subject,$txt);
		}
		//给申请人发邮件
		$to=$uEmail;
		$subject = "My subject";
		$txt = $uUserName." 您的".$type." 工单申请（".$VacationId.'工单号）被 '.$pName." ".$status;
		$headers = "From: " . "\r\n" ."CC: ";
		mail($to,$subject,$txt);
		/*$to = "somebody@example.com";
		$subject = "My subject";
		$txt = "Hello world!";
		$headers = "From: webmaster@example.com" . "\r\n" .
		"CC: somebodyelse@example.com";
		mail($to,$subject,$txt,$headers);
*/	}
}
?>