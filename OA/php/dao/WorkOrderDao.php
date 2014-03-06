<?php
class WorkOrderDao{
	/**
	 * 新增请假/出差、加班单
	 */
	function createWorkOrder($obj,$operateFlag){
		date_default_timezone_set("Asia/Shanghai");
		$param = array();
		$param['USER_ID'] = $obj->getUserId();
		$param['TYPE'] = $obj->getType();
		$param['CURRENT_USERID'] = $obj->getCurrentUserid();
		$param['BEGIN_TIME'] = $obj->getBeginTime();
		$param['END_TIME'] = $obj->getEndTime();
		$param['REMARK'] = $obj->getRemark();
		$param['AUDIT_STATUS'] = $obj->getAuditStatus();
		$param['TOTAL_TIME'] = $obj->getTotalTime();
		if($operateFlag == 'addLeaveTrip'){
			$param['LEAVE_TYPE'] = $obj->getLeaveType();
			if($obj->getLeaveType() == 11){
				$param['LEAVE_NAME'] = $obj->getLeaveName();
			}
		}
		$param['CREATE_TIME'] = date('Y-m-d H:i:s');
		
		$conn = new MysqlConn();
		return $conn->insert('VACATION_RECORD',$param);
	}
	
	/**
	 * 新增忘打卡记录
	 */
	function createForgetCard($obj){
		date_default_timezone_set("Asia/Shanghai");
		$param = array();
		$param['USER_ID'] = $obj->getUserId();
		$param['TYPE'] = $obj->getType();
		$param['CREATE_TIME'] = date('Y-m-d H:i:s');
		$param['FORGET_TIME'] = $obj->getForgetTime();
		$param['IN_TIME'] = $obj->getInTime();
		$param['REMARK'] = $obj->getRemark();
		$param['CURRENT_USERID'] = $obj->getCurrentUserid();
		$param['AUDIT_STATUS'] = $obj->getAuditStatus();
		
		$conn = new MysqlConn();
		return $conn->insert('FORGET_CARD',$param);
	}
	
	/**
	 * 获取请假/出差、加班、忘打卡记录
	 * 
	 */
	function getWorkOrderList($searchParam,$operateFlag){
		$currentPage = $searchParam['currentPage'];
		$pageSize = $searchParam['pageSize'];
		$userId = $searchParam['userId'];
		
		$currentPage = $currentPage <= 0 ? 1 : $currentPage;
		if($pageSize <= 0){ $pageSize = 20; }
		else if($pageSize > 50){ $pageSize = 50; }
		
		$sql = '';
		$sqlcount = '';
		$conditions = ' WHERE 1=1';
		$pagingSql = " limit ".(($currentPage-1)*$pageSize).",".$pageSize;
		$tableFlag = '';
		if($operateFlag == 'vacationList'){	//请假/出差、加班
			$sql .= 'SELECT VR.ID,VR.CREATE_TIME,VR.TYPE,VR.AUDIT_STATUS,u1.USER_NAME AS CURRENT_USER_NAME,u2.USER_NAME AS PRIVIOUS_USER_NAME ';
			$sql .= 'FROM VACATION_RECORD VR LEFT JOIN USER_INFO u1 ON VR.CURRENT_USERID=u1.ID LEFT JOIN USER_INFO u2 ON VR.PREVIOUS_USERID=u2.ID';
			$sqlcount .= 'SELECT ID FROM VACATION_RECORD WHERE 1=1 AND USER_ID=' . $userId;
			$tableFlag = ' ORDER BY VR.ID DESC';
		}else if($operateFlag == 'forgetCardList'){	//忘打卡
			$sql .= 'SELECT FC.ID,FC.TYPE,FC.CREATE_TIME,FC.FORGET_TIME,FC.IN_TIME,FC.AUDIT_STATUS,u1.USER_NAME AS CURRENT_USER_NAME,u2.USER_NAME AS PRIVIOUS_USER_NAME ';
			$sql .= 'FROM FORGET_CARD FC LEFT JOIN USER_INFO u1 ON FC.CURRENT_USERID=u1.ID LEFT JOIN USER_INFO u2 ON FC.PREVIOUS_USERID=u2.ID';
			$sqlcount .= 'SELECT ID FROM FORGET_CARD WHERE 1=1 AND USER_ID=' . $userId;
			$tableFlag = ' ORDER BY FC.ID DESC';
		}
		$conditions .= ' AND USER_ID=' . $userId;
		$conn = new MysqlConn();
		$countResult = $conn->query($sqlcount);	//查询记录总数
		$totalCounts = (int)mysql_num_rows($countResult);
		
		$sql .=  $conditions . $tableFlag . $pagingSql;
		$listResult = $conn->query($sql);	//查询记录
		
		$list = array();	//结果
		$tempList = array();
		while($tempList = mysql_fetch_assoc($listResult)){
			$list[] = $tempList;
		}
		mysql_free_result($listResult);
		$returnList = array();
		$returnList['totalCounts'] = $totalCounts;
		$returnList['currentPage'] = $currentPage;
		$returnList['pageTotal'] = (int)ceil($totalCounts/$pageSize);
		$returnList['list'] = $list;
		return $returnList;
	}
	
	/**
	 * 通过ID查找工单信息
	 */
	 function getWorkOrderById($id,$flag){
 		$sql = '';
 		if($flag == 'leaveTrip' || $flag == 'overtimeRequest'){
		 	$sql .= 'SELECT VR.TYPE,VR.CREATE_TIME,VR.BEGIN_TIME,VR.END_TIME,VR.TOTAL_TIME,VR.LEAVE_TYPE,VR.LEAVE_NAME,VR.REMARK,VR.AUDIT_STATUS,VR.AUDIT_TIME,VR.AUDIT_REMARK';
		 	$sql .= ',u1.USER_NAME AS CURRENT_USER_NAME,u2.USER_NAME AS PRIVIOUS_USER_NAME ';
		 	$sql .= 'FROM VACATION_RECORD VR LEFT JOIN USER_INFO u1 ON VR.CURRENT_USERID=u1.ID LEFT JOIN USER_INFO u2 ON VR.PREVIOUS_USERID=u2.ID WHERE VR.ID=' . $id;
 		}else{
 			$sql .= 'SELECT FC.TYPE,FC.CREATE_TIME,FC.FORGET_TIME,FC.IN_TIME,FC.REMARK,FC.AUDIT_STATUS,FC.AUDIT_TIME,FC.AUDIT_REMARK';
 			$sql .= ',u1.USER_NAME AS CURRENT_USER_NAME,u2.USER_NAME AS PRIVIOUS_USER_NAME ';
		 	$sql .= 'FROM FORGET_CARD FC LEFT JOIN USER_INFO u1 ON FC.CURRENT_USERID=u1.ID LEFT JOIN USER_INFO u2 ON FC.PREVIOUS_USERID=u2.ID WHERE FC.ID=' . $id;
 		}
	 	$conn = new MysqlConn();
		$listResult = $conn->query($sql);	//查询结果
		
		$list = array();
		$tempList = array();
		while($tempList = mysql_fetch_assoc($listResult)){
			$list[] = $tempList;	
		}
		mysql_free_result($listResult);
		$returnList = array();
		$returnList['list'] = $list;
		return $returnList;	
	 }
}
?>