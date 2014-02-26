<?php
class User{
	private $id;
	private $user_name;
	private $role_id;
	private $login_name;
	private $password;
	private $mobile;
	private $email;
	private $sex;
	private $department_type;
	private $position_name;
	private $induction_time;
	private $create_time;
	private $status;
	public function setId($id){
		$this->id = $id;
	}
	public function setUserName($user_name){
		$this->user_name = $user_name;
	}
	public function setRoleId($role_id){
		$this->role_id = $role_id;
	}
	public function setLoginName($login_name){
		$this->login_name = $login_name;
	}
	public function setPassword($password){
		$this->password = $password;
	}
	public function setMobile($mobile){
		$this->mobile = $mobile;
	}
	public function setEmail($email){
		$this->email = $email;
	}
	public function setSex($sex){
		$this->sex = $sex;
	}
	public function setDepartmentType($department_type){
		$this->department_type = $department_type;
	}
	public function setPositionName($position_name){
		$this->position_name = $position_name;
	}
	public function setInductionName($induction_time){
		$this->induction_time = $induction_time;
	}
	public function setCreateTime($create_time){
		$this->create_time = $create_time;
	}
	public function setStatus($status){
		$this->status = $status;
	}
	public function getId(){
		return $this->id;
	}
	public function getUserName(){
		return $this->user_name;
	}
	public function getRoleId(){
		return $this->role_id;
	}
	public function getLoginName(){
		return $this->login_name;
	}
	public function getPassword(){
		return $this->password;
	}
	public function getMobile(){
		return $this->mobile;
	}
	public function getEmail(){
		return $this->email;
	}
	public function getSex(){
		return $this->sex;
	}
	public function getDepartmentType(){
		return $this->department_type;
	}
	public function getPositionName(){
		return $this->position_name;
	}
	public function getInductionName(){
		return $this->induction_time;
	}
	public function getCreateTime(){
		return $this->create_time;
	}
	public function getStatus(){
		return $this->status;
	}
}
?>