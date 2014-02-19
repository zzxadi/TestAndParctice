<?php
class RoleMenu{
	private $id;
	private $role_id;
	private $menu_id;
	public function setRoleId($role_id){
		$this->role_id = $role_id;
	}
	public function setMenuId($menu_id){
		$this->menu_id = $menu_id;
	}
	public function getId(){
		return $this->id;
	}
	public function getRoleId(){
		return $this->role_id;
	}
	public function getMenuId(){
		return $this->menu_id;
	}
}
?>