<?php
class RoleMenuDao{
	private $roleMenu;
	private $systemMenu;
	private $rmConn;
	public function __construct(){
		require_once('MysqlConn.php');
		$this->rmConn = new MysqlConn();
	}
	public function setSystemMenu($systemMenu){
		$this->systemMenu = $systemMenu;
	}
	public function setRoleMenu($roleMenu){
		$this->roleMenu = $roleMenu;
	}
	public function getRoleMenu(){
		return $this->roleMenu;
	}
	public function getSystemMenu(){
		return $this->systemMenu;
	}
	public function getRecord(){
		$rmSql = 'select * from ROLE_MENU where role_id = ';
		$rmSql .= "'".$this->roleMenu->getRoleId()."'";
		$rmQuery = $this->rmConn->query($rmSql);
		$i=0;
		$rm = array();
		while($row = $this->rmConn->fetch_array($rmQuery)){
			$rm[$i] = $row;
			$i++;
		}
		return $rm;
	}
	public function updateRecord($arr){
		$rmCondition = 'role_id = '.$this->roleMenu->getRoleId();
		$rmCondition .= ' and EXISTS (select 1 from SYSTEM_MENU where id=menu_id and menu_def='.$this->systemMenu->getMenuDef().')';
		if($this->rmConn->delete('ROLE_MENU',$rmCondition)){
			$rmSql = 'insert into ROLE_MENU ( role_id , menu_id) values ';
			$i=0;
			for($i=0;$i<count($arr);$i++){
				if($i != 0){
					$rmSql .= ',';
				}
				$rmSql .= "('" .$this->roleMenu->getRoleId()."','".$arr[$i]."')" ;
			}
			$rmQuery = $this->rmConn->query($rmSql);
			if(!$rmQuery) return false;
			return true;
		}
	}
}
?>