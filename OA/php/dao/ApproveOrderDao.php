<?php
	class ApproveOrderDao{
		var $lastError = "";
		private $vacationRecord;
		private $forgetCard;
		private $vacationLog;
		private $vacation;
		
		public function setVacation($vacation){
			$this->vacation = $vacation;
		}
		public function getVacation(){
			return $this->vacation;	
		}
		
		public function setVacationRecord($vacationRecord){
			$this->vacationRecord = $vacationRecord;
		}
		public function getVacationRecord(){
			return $this->vacationRecord;	
		}
		
		public function setForgetCard($forgetCard){
			$this->forgetCard = $forgetCard;
		}
		public function geForgetCard(){
			return $this->forgetCard;	
		}
		
		public function setVacationLog($vacationLog){
			$this->vacationLog = $vacationLog;
		}
		public function getVacationLog(){
			return $this->vacationLog;	
		}
		function getList($stInfo){
			$iCount=$stInfo['pageSize'];
			$sCondition=' where 0=0';
			if($stInfo['status'] != '4'){
				$sCondition.=" AND (audit_status = 0 OR audit_status=1)";
				if(!empty($stInfo['userId'])){
				$sCondition .=" and VACATION_RECORD.CURRENT_USERID = ".$stInfo['userId'];	
				}
			}
			
			if(!empty($stInfo['pageSize'])){
				if($stInfo['pageSize']>50) {
					$stInfo['pageSize']=50;
				}else if($stInfo['pageSize']<0){
					$stInfo['pageSize']=5;
				}
			}else if(!$stInfo['pageSize']){
				$stInfo['pageSize']=5;
			}
			if($stInfo['pageNo']<1){
				$stInfo['pageNo']=1;	
			}
			$sCondition.=" and VACATION_RECORD.user_id = USER_INFO.id";
			$sql=" select VACATION_RECORD.id ,
			VACATION_RECORD.type,
			VACATION_RECORD.CURRENT_USERID,
			USER_INFO.user_name ,
			USER_INFO.department_type ,
			VACATION_RECORD.leave_type ,
			VACATION_RECORD.create_time , 
			VACATION_RECORD.audit_status
			from VACATION_RECORD , USER_INFO".$sCondition ."
			ORDER BY VACATION_RECORD.create_time desc 
			limit " .($stInfo['pageNo']-1)*$stInfo['pageSize']." , ".$stInfo['pageSize'];
			$sql2=" select * from VACATION_RECORD , USER_INFO" .$sCondition ;	
			$stConn = new MysqlConn();
			$stResult = $stConn->query($sql);
			$stResult2 = $stConn->query($sql2);
			$iNumRows = (int)mysql_num_rows($stResult);
			$iNumRows2=(int)mysql_num_rows($stResult2);
			$currentPage = $stInfo['pageNo'];
			$stList = array();
			while($stInfo = mysql_fetch_assoc($stResult)){
				$stList[] = $stInfo;	
			}
			$stConn->free_result();//释放结果内存
			$stReturn = array();
			$stReturn['Total'] = $iNumRows2;
			$stReturn['CurrentPage'] = $currentPage;
			$stReturn['PageTotal'] = (int)ceil($iNumRows2/$iCount);
			$stReturn['List'] = $stList;
			return $stReturn;
		}	
		
		function getForgetOrderListDao($stInfo){
			$iCount=$stInfo['pageSize'];
			$sCondition=' where 0=0';
			if($stInfo['status'] != '4'){
				$sCondition.=" AND (audit_status = 0 OR audit_status=1)";
				if(!empty($stInfo['userId'])){
				$sCondition .=" and FORGET_CARD.CURRENT_USERID = ".$stInfo['userId'];	
			}
			}
			
			if(!empty($stInfo['pageSize'])){
				if($stInfo['pageSize']>50) {
					$stInfo['pageSize']=50;
				}else if($stInfo['pageSize']<0){
					$stInfo['pageSize']=5;
				}
			}else if(!$stInfo['pageSize']){
				$stInfo['pageSize']=15;
			}
			if($stInfo['pageNo']<1){
				$stInfo['pageNo']=1;	
			}
			$sCondition.=" and FORGET_CARD.user_id = USER_INFO.id";
			$sql="select FORGET_CARD.id ,
				USER_INFO.user_name ,
				FORGET_CARD.CURRENT_USERID,
				USER_INFO.department_type ,
				FORGET_CARD.create_time ,
				FORGET_CARD.audit_status
				from FORGET_CARD , USER_INFO" .$sCondition .
				" ORDER BY FORGET_CARD.create_time desc limit "
			.($stInfo['pageNo']-1)*$stInfo['pageSize']." , 
			".$stInfo['pageSize'];
			$sql2=" select * from FORGET_CARD , USER_INFO" .$sCondition ;	
			$stConn = new MysqlConn();
			$stResult = $stConn->query($sql);
			$stResult2 = $stConn->query($sql2);
			$iNumRows = (int)mysql_num_rows($stResult);
			$iNumRows2=(int)mysql_num_rows($stResult2);
			$currentPage = $stInfo['pageNo'];
			$stList = array();
			while($stInfo = mysql_fetch_assoc($stResult)){
				$stList[] = $stInfo;	
			}
			$stConn->free_result();//释放结果内存
			$stReturn = array();
			$stReturn['Total'] = $iNumRows2;
			$stReturn['CurrentPage'] = $currentPage;
			$stReturn['PageTotal'] = (int)ceil($iNumRows2/$iCount);
			$stReturn['List'] = $stList;
			return $stReturn;
		}	
		
		function getApproveDetail($stInfo){//获得某条记录的详细信息
			$sCondition=' where 0=0';
			if($stInfo['approveType']==1){//请假
				if(!empty($stInfo['id'])){
					$sCondition .=" and VR.id = ".$stInfo['id'];	
				}
				$sql="SELECT
				 u3.department_type ,
				VR.REMARK ,
				VR.CURRENT_USERID,
				VR.BEGIN_TIME,
				VR.TOTAL_TIME,
				VR.END_TIME, 
				VR.USER_ID,
				u1.POSITION_NAME ,
				VR.ID ,
				VR.CREATE_TIME , 
				VR.TYPE ,
				VR.AUDIT_STATUS ,
				VR.leave_type ,
				u1.USER_NAME AS CURRENT_USER_NAME,
				u2.USER_NAME AS PRIVIOUS_USER_NAME ,
				u3.USER_NAME AS USER_NAME
				FROM VACATION_RECORD VR LEFT JOIN USER_INFO u1 
				ON VR.CURRENT_USERID=u1.ID
				LEFT JOIN USER_INFO u2 
				ON VR.PREVIOUS_USERID=u2.ID 
				LEFT JOIN USER_INFO u3 
				ON VR.USER_ID = u3.ID ".$sCondition;
				
			}else if($stInfo['approveType']==2){//忘打卡
				if(!empty($stInfo['id'])){
					$sCondition .=" and VR.id = ".$stInfo['id'];	
				}
				$sql="SELECT u3.department_type,
				VR.CURRENT_USERID,
				VR.FORGET_TIME,VR.REMARK , 
				u1.POSITION_NAME ,
				VR.USER_ID, 
				VR.ID , 
				VR.CREATE_TIME , 
				VR.TYPE ,
				VR.AUDIT_STATUS , 
				VR.type ,
				u1.USER_NAME AS CURRENT_USER_NAME,
				u2.USER_NAME AS PRIVIOUS_USER_NAME,
				u3.USER_NAME AS USER_NAME 
				FROM FORGET_CARD VR 
				LEFT JOIN USER_INFO u1 
				ON VR.CURRENT_USERID=u1.ID 
				LEFT JOIN USER_INFO u2 
				ON VR.PREVIOUS_USERID=u2.ID 
				LEFT JOIN USER_INFO u3 
				ON VR.USER_ID = u3.ID ".$sCondition;
			}
			$stConn = new MysqlConn();
			$stResult = $stConn->query($sql);
			$stList = array();
			while($stInfo = mysql_fetch_assoc($stResult)){
				$stList[] = $stInfo;	
			}
			$stConn->free_result();//释放结果内存
			$stReturn = array();
			$stReturn['List'] = $stList;
			return $stReturn;
		}
		
		function getAllManger(){//获得所有管理人员
			$sCondition=' where 0=0';
			$sql2="select USER_INFO.id , 
			user_name,
			ROLE_KEY from USER_INFO , 
			SYSTEM_ROLE 
			where 0=0 
			AND (SYSTEM_ROLE.ROLE_KEY = 'GLZ' OR ROLE_KEY='FEND') 
			AND SYSTEM_ROLE.ID = USER_INFO.ROLE_ID  
			AND USER_INFO.STATUS = 0
			AND USER_INFO.ID <> ".getUserId();		
			$stConn = new MysqlConn();
			$stResult2 = $stConn->query($sql2);
			$stList2 = array();
			while($stInfo = mysql_fetch_assoc($stResult2)){
				$stList2[] = $stInfo;	
			}
			mysql_free_result($stResult2);//释放结果内存
			$stReturn = array();
			$stReturn['list']=$stList2;
			return $stReturn;
		}
		
		function updateApproveDao(){
			$stConn = new MysqlConn();
			$smArr = array(	'audit_remark' => $this->vacationRecord->getAuditRemark(),
							'audit_status' => $this->vacationRecord->getAuditStatus(),
							'audit_time' => $this->vacationRecord->getAuditTime(),
							'current_userid' => $this->vacationRecord->getCurrentUserid(),
							'previous_userid' => $this->vacationRecord->getPreviousUserid());
			$result= $stConn->update('VACATION_RECORD',$smArr,'id = '.$this->vacationRecord->getId());
			/*$stConn->free_result();
			return $result;*/
			if(mysql_affected_rows()>0){
			$stConn->free_result();;//释放结果内存
				return true;	
			}else{ 
			$stConn->free_result();;//释放结果内存
			return false;
			}
		}
		
		function updateForgetDao(){
			$stConn = new MysqlConn();
			$smArr = array(	'AUDIT_REMARK' => $this->forgetCard->getAuditRemark(),
							'AUDIT_STATUS' => $this->forgetCard->getAuditStatus(),
							'CURRENT_USERID' => $this->forgetCard->getCurrentUserid(),
							'PREVIOUS_USERID' => $this->forgetCard->getPreviousUserid());
			$result= $stConn->update('FORGET_CARD',$smArr,'id = '.$this->forgetCard->getId());
			
			/*$stConn->free_result();
			return $result;*/
			if(mysql_affected_rows()>0){
			$stConn->free_result();;//释放结果内存
				return true;	
			}else{ 
			$stConn->free_result();;//释放结果内存
			return false;
			}
			
		}
		
		function updateVaction($key){//更新剩余记录表
			$stConn = new MysqlConn();
			if($key==1){
				$sql = "update VACATION SET REMAIN = remain + ".$this->vacation->getRemain()
					." where user_id = ".$this->vacation->getUserId()
					." and VACATION_TYPE = ".$this->vacation->getVacationType();
			}else if($key==2){
				$sql = "update VACATION SET REMAIN = remain - ".$this->vacation->getRemain()
						." where user_id = ".$this->vacation->getUserId()
						." and VACATION_TYPE = ".$this->vacation->getVacationType();
			}
			$stResult = $stConn->query($sql);
			/*$stList= array();
			while($stInfo = mysql_fetch_assoc($stResult)){
				$stList[] = $stInfo;	
			}
			$stConn->free_result();//释放结果内存
			if(count($stList)>0) {
				return true;}
			else {return false;}*/
			if(mysql_affected_rows()>0){
			$stConn->free_result();;//释放结果内存
				return true;	
			}else{ 
			$stConn->free_result();;//释放结果内存
			return false;
			}
		}
		function selectVacation(){
			$stConn = new MysqlConn();
			$sql = "select * from VACATION where  user_id = ".$this->vacation->getUserId()
			." and vacation_type = ".$this->vacation->getVacationType();
			$stResult = $stConn->query($sql);
			
			$stList= array();
			while($stInfo = mysql_fetch_assoc($stResult)){
				$stList[] = $stInfo;	
			}
			$stConn->free_result();//释放结果内存
			if(count($stList)>0) {
				return true;}
			else {return false;}
		}
		function insertVacation($key){
			$stConn = new MysqlConn();
			if($key==1){
				$smArr = array('remain'=>$this->vacation->getRemain(),
							'vacation_type'=>$this->vacation->getVacationType(),
							'user_id'=>$this->vacation->getUserId());
				
			}else if($key==2){
				$smArr = array('remain'=>-($this->vacation->getRemain()),
							'vacation_type'=>$this->vacation->getVacationType(),
							'user_id'=>$this->vacation->getUserId());
			}
			$result= $stConn->insert('VACATION',$smArr);
			if(mysql_affected_rows()>0){
				$stConn->free_result();//释放结果内存
				return true;	
			}else{ 
				$stConn->free_result();//释放结果内存
			return false;
			}
		}
		
		function insertVactionLog(){
			$stConn = new MysqlConn();
			$smArr = array(	'USER_ID' => $this->vacationLog->getUserId(),
							'TYPE' => $this->vacationLog->getType(),
							'BILL_ID' => $this->vacationLog->getBillId(),
							'CONTENT' => $this->vacationLog->getContent(),
							'CREATE_TIME' => $this->vacationLog->getCreateTime());
			$result= $stConn->insert('VACATION_LOG',$smArr);
			/*$stList= array();
			while($stInfo = mysql_fetch_assoc($stResult)){
				$stList[] = $stInfo;	
			}
			$stConn->free_result();//释放结果内存
			if(count($stList)>0) {
				return true;}
			else {return false;}*/
			if(mysql_affected_rows()>0){
				$stConn->free_result();//释放结果内存
				return true;	
			}else{ 
				$stConn->free_result();//释放结果内存
			return false;
			}
		}
		
		function getCurrentRoleKey($stInfo){
			$sql='SELECT SYSTEM_ROLE.ROLE_KEY ,
			USER_INFO.ID ,
			 USER_INFO.USER_NAME FROM SYSTEM_ROLE ,
			 USER_INFO where 0=0 
			 AND  SYSTEM_ROLE.ID = USER_INFO.ROLE_ID  
			 and USER_INFO.ID = ' . $stInfo;
			$stConn = new MysqlConn();
			$stResult = $stConn->query($sql);
			$stList = array();
			while($stInfo = mysql_fetch_assoc($stResult)){
				$stList[] = $stInfo;	
			}
			
			$stConn->free_result();//释放结果内存
			$stReturn = array();
			$stReturn['List'] = $stList;
			return $stReturn;
		}
		
		function getOnePersonDetail($id){
			$sql='select * from USER_INFO WHERE 1 = 1 and ID =
			' . $id;
			$stConn = new MysqlConn();
			$stResult = $stConn->query($sql);
			$stList = array();
			$i=0;
			while($stInfo = mysql_fetch_array($stResult)){
				$stList[$i] = $stInfo;	
				$i++;
			}
			$stConn->free_result();//释放结果内存
			return  $stList;
		}
	}
?>
