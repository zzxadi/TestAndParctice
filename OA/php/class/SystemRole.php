<?php
class SystemRole{
	private $id;
	private $role_name;
	private $role_des;
	private $role_key;
	public function setId($id){
		$this->id = $id;
	}
	public function setRoleName($role_name){
		$this->role_name = $role_name;
	}
	public function setRoleDes($role_des){
		$this->role_des = $role_des;
	}
	public function setRoleKey($role_key){
		$this->role_key = $role_key;
	}
	public function getId(){
		return $this->id;
	}
	public function getRoleName(){
		return $this->role_name;
	}
	public function getRoleDes(){
		return $this->role_des;
	}
	public function getRoleKey(){
		return $this->role_key;
	}
}
?>