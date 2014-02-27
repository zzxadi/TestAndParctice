<?php
class UserMenuDao{
	private $user;
	private $systemMenu;
	private $roleMenu;
	private $sqlConn;
	public function __construct(){
		$this->sqlConn = new MysqlConn();
	}
	public function setUser($user){
		$this->user = $user;
	}
	public function setSystemMenu($systemMenu){
		$this->systemMenu = $systemMenu;
	}
	public function setRoleMenu($roleMenu){
		$this->roleMenu = $roleMenu;
	}
	public function getUserRole(){
		$umSql = 'select role_id from USER_INFO ';
		if($this->user->getId()!= ''){
			$umSql .= 'where id = ';
			$umSql .= "'".$this->user->getId()."'";
		}
		$umQuery = $this->sqlConn->query($umSql);
		$i = 0;
		$um = array();
		while($row = $this->sqlConn->fetch_array($umQuery)) {
			$um[$i]=$row;
			$i++;
		}
		return $um;
	}
	public function getMenuIdList(){
		if($this->roleMenu->getRoleId() != ''){
			$umSql = 'select menu_id from ROLE_MENU where role_id = '.$this->roleMenu->getRoleId();
			$umQuery = $this->sqlConn->query($umSql);
			$i = 0;
			$um = array();
			while($row = $this->sqlConn->fetch_array($umQuery)) {
				$um[$i]=$row;
				$i++;
			}
			return $um;
		}else{
			return false;
		}
	}
	public function getUserMenuList($arr){
		if(count($arr) == 0){
			return '';
		}
		$i=0;
		$umSql = 'select * from SYSTEM_MENU where menu_def=1 and id in (';
		for($i=0;$i<count($arr);$i++){
			if($i != 0){ $umSql .= ',';}
			$umSql .= "'".$arr[$i]['menu_id']."'";
		}
		$umSql .= ')';
		$umQuery = $this->sqlConn->query($umSql);
		$i = 0;
		$um = array();
		while($row = $this->sqlConn->fetch_array($umQuery)) {
			$um[$i]=$row;
			$i++;
		}
		return $um;
	}
	public function getLevelRecord(){
		$smSql = 'select * from SYSTEM_MENU ';
		if($this->systemMenu->getMenuLevel() != '' || $this->systemMenu->getMenuSupper() != ''){
			$smSql .= 'where 1=1 and menu_level = ';
			$smSql .= "'".$this->systemMenu->getMenuLevel()."'";
			$smSql .= ' and menu_supper = ';
			$smSql .= "'".$this->systemMenu->getMenuSupper()."'";
			$smSql .= 'and menu_def = ';
			$smSql .= "'".$this->systemMenu->getMenuDef()."'";
		}
		$smSql .= 'order by menu_index';
		$smQuery = $this->sqlConn->query($smSql);
		$i = 0;
		$sr = array();
		while($row = $this->sqlConn->fetch_array($smQuery)) {
			$sr[$i]=$row;
			$i++;
		}
		return $sr;
	}
}
?>