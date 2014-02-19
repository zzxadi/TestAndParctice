<?php
class SystemRole{
	private $id;
	private $role_name;
	private $role_del;
	public function setRoleName($role_name){
		$this->role_name = $role_name;
	}
	public function setRoleDel($role_del){
		$this->role_del = $role_del;
	}
	public function getId(){
		return $this->id;
	}
	public function getRoleName(){
		return $this->role_name;
	}
	public function getRoleDel(){
		return $this->role_del;
	}
}
?>