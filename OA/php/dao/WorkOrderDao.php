<?php
require_once("MysqlConn.php");
class WorkOrderDao{
	var $lastError = "";
	function add($obj){
		echo $obj->getType();
		$param = array();
		$param['CURRENT_USERID'] = $obj->getCurrentUserid();
		$param['BEGIN_TIME'] = $obj->getBeginTime();
		$param['END_TIME'] = $obj->getEndTime();
		$param['REMART'] = $obj->getRemark();
		$param['LEAVE_TYPE'] = $obj->getLevelType();
		$param['CREATE_TIME'] = date("Y-m-d H:i:s");
		
		$conn = new MysqlConn();
		return $conn->insert('VACATION_RECORD',$param);
	}
}
?>