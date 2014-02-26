<?php
class SystemMenu{
	private $id;
	private $menu_name;
	private $menu_level;
	private $menu_supper;
	private $menu_url;
	private $menu_def;
	private $menu_reg;
	private $menu_index;
	private $menu_remark;
	public function setId($id){
		$this->id = $id;
	}
	public function setMenuName($menu_name){
		$this->menu_name = $menu_name;
	}
	public function setMenuLevel($menu_level){
		$this->menu_level = $menu_level;
	}
	public function setMenuSupper($menu_supper){
		$this->menu_supper = $menu_supper;
	}
	public function setMenuUrl($menu_url){
		$this->menu_url = $menu_url;
	}
	public function setMenuDef($menu_def){
		$this->menu_def = $menu_def;
	}
	public function setMenuReg($menu_reg){
		$this->menu_reg = $menu_reg;
	}
	public function setMenuIndex($menu_index){
		$this->menu_index = $menu_index;
	}
	public function setMenuRemark($menu_remark){
		$this->menu_remark = $menu_remark;
	}
	public function getId(){
		return $this->id;
	}
	public function getMenuName(){
		return $this->menu_name;
	}
	public function getMenuLevel(){
		return $this->menu_level;
	}
	public function getMenuSupper(){
		return $this->menu_supper;
	}
	public function getMenuUrl(){
		return $this->menu_url;
	}
	public function getMenuDef(){
		return $this->menu_def;
	}
	public function getMenuReg(){
		return $this->menu_reg;
	}
	public function getMenuIndex(){
		return $this->menu_index;
	}
	public function getMenuRemark(){
		return $this->menu_remark;
	}
}
?>