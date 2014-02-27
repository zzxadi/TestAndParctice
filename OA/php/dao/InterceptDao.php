<?php
class InterceptDao{
	private $user;
	private $sqlConn;
	public function __construct(){
		$this->sqlConn = new MysqlConn();
	}
	public function setUser($user){
		$this->user = $user;
	}
	public function isUserQualified($str){
		$ia = $this->getRoleId();
		$this->user->setRoleId($ia[0]['role_id']);
		$ia = $this->getMenuId();
		$iaSql = 'select menu_url from SYSTEM_MENU where menu_def = 0 and id in (';
		$i=0;
		$j=count($ia);
		for($i=0;$i<$j;$i++){
			if($i != 0){
				$iaSql .= ' , ';
			}
			$iaSql .= "'".$ia[$i]['menu_id']."'";
		}
		$iaSql .= ')';
		$iaQuery = $this->sqlConn->query($iaSql);
		while($row = $this->sqlConn->fetch_array($iaQuery)) {
			if($row['menu_url'] == $str){
				return true;
			}
		}
		return false;
	}
	public function getRoleId(){
		$iaSql = 'select role_id from USER_INFO where id = '.$this->user->getId();
		$iaQuery = $this->sqlConn->query($iaSql);
		$i = 0;
		$ia = array();
		while($row = $this->sqlConn->fetch_array($iaQuery)) {
			$ia[$i]=$row;
			$i++;
		}
		return $ia;
	}
	public function getMenuId(){
		$iaSql = 'select menu_id from ROLE_MENU where role_id = '.$this->user->getRoleId();
		$iaQuery = $this->sqlConn->query($iaSql);
		$i = 0;
		$ia = array();
		while($row = $this->sqlConn->fetch_array($iaQuery)) {
			$ia[$i]=$row;
			$i++;
		}
		return $ia;
	}
}
?>