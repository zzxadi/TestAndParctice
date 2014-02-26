<?php
class SystemMenuDao{
	private $systemMenu;
	private $smConn;
	public function __construct(){
		require_once('MysqlConn.php');
		$this->smConn = new MysqlConn();
	}
	public function setSystemMenu($systemMenu){
		$this->systemMenu = $systemMenu;
	}
	public function getSystemMenu(){
		return $this->systemMenu;
	}
	public function addRecord(){
		$smArr = array('menu_name' => $this->systemMenu->getMenuName(),
						'menu_level' => $this->systemMenu->getMenuLevel(),
						'menu_supper' => $this->systemMenu->getMenuSupper(),
						'menu_url' => $this->systemMenu->getMenuUrl(),
						'menu_def' => $this->systemMenu->getMenuDef(),
						'menu_reg' => $this->systemMenu->getMenuReg(),
						'menu_index' => $this->systemMenu->getMenuIndex(),
						'menu_remark' => $this->systemMenu->getMenuRemark());
		return $this->smConn->insert('SYSTEM_MENU',$smArr);
	}
	public function updateRecord(){
		$smArr = array(	'menu_name' => $this->systemMenu->getMenuName(),
						'menu_level' => $this->systemMenu->getMenuLevel(),
						'menu_supper' => $this->systemMenu->getMenuSupper(),
						'menu_url' => $this->systemMenu->getMenuUrl(),
						'menu_def' => $this->systemMenu->getMenuDef(),
						'menu_reg' => $this->systemMenu->getMenuReg(),
						'menu_index' => $this->systemMenu->getMenuIndex(),
						'menu_remark' => $this->systemMenu->getMenuRemark());
		return $this->smConn->update('SYSTEM_MENU',$smArr,'id = '.$this->systemMenu->getId());
	}
	public function getLevelRecord(){
		$smSql = 'select * from SYSTEM_MENU ';
		if($this->systemMenu->getMenuLevel() != '' || $this->systemMenu->getMenuSupper() != ''){
			$smSql .= 'where 1=1 and menu_level = ';
			$smSql .= "'".$this->systemMenu->getMenuLevel()."'";
			$smSql .= ' and menu_supper = ';
			$smSql .= "'".$this->systemMenu->getMenuSupper()."'";
		}
		$smSql .= 'order by menu_index';
		$smQuery = $this->smConn->query($smSql);
		$i = 0;
		$sr = array();
		while($row = $this->smConn->fetch_array($smQuery)) {
			$sr[$i]=$row;
			$i++;
		}
		return $sr;
	}
	public function getSingleRecord($param,$paramValue){
		$smSql = "select * from SYSTEM_MENU where $param = $paramValue";
		$smQuery = $this->smConn->query($smSql);
		$i = 0;
		$sr = array();
		while($row = $this->smConn->fetch_array($smQuery)) {
			$sr[$i]=$row;
			$i++;
		}
		return $sr;
	}
}
?>