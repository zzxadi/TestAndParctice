<?php
class SystemRoleDao{
	private $systemRole;
	private $srConn;
	public function __construct(){
		require_once('MysqlConn.php');
		$this->srConn = new MysqlConn();
	}
	public function setSystemRole($systemRole){
		$this->systemRole = $systemRole;
	}
	public function getSystemRole(){
		return $this->systemRole;
	}
	public function getAllRecord(){
		$srSql = 'select * from SYSTEM_ROLE';
		$srQuery = $this->srConn->query($srSql);
		$i = 0;
		$sr = array();
		while($row = $this->srConn->fetch_array($srQuery)) {
			$sr[$i]=$row;
			$i++;
		}
		return $sr;
	}
	public function addRecord(){
		$srArr = array('role_name'=>$this->systemRole->getRoleName(),'role_des'=>$this->systemRole->getRoleDes(),'role_key'=>$this->systemRole->getRoleKey());
		return $this->srConn->insert('SYSTEM_ROLE',$srArr);
	}
	public function getSingleRecord($param,$paramValue){
		$srSql = "select * from SYSTEM_ROLE where $param = $paramValue";
		$srQuery = $this->srConn->query($srSql);
		$i = 0;
		$sr = array();
		while($row = $this->srConn->fetch_array($srQuery)) {
			$sr[$i]=$row;
			$i++;
		}
		return $sr;
	}
	public function updateRecord(){
		$srArr = array('role_name'=>$this->systemRole->getRoleName(),'role_des'=>$this->systemRole->getRoleDes(),'role_key'=>$this->systemRole->getRoleKey());
		return $this->srConn->update('SYSTEM_ROLE',$srArr,'id = '.$this->systemRole->getId());
	}
	public function delRecord($param,$paramValue){
		$srCondition = $param . '=' .$paramValue;
		return $this->srConn->delete('SYSTEM_ROLE',$srCondition);
	}
}
?>