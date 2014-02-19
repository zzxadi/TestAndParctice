<?php
class Vacation{
	private $id;
	private $user_id;
	private $vacation_type;
	private $remain;
	public function setUserId($user_id){
		$this->user_id = $user_id;
	}
	public function setVacationType($vacation_type){
		$this->vacation_type = $vacation_type;
	}
	public function setRemain($remain){
		$this->remain = $remain;
	}
	public function getId(){
		return $this->id;
	}
	public function getUserId(){
		return $this->user_id;
	}
	public function getVacationType(){
		return $this->vacation_type;
	}
	public function getRemain(){
		return $this->remain;
	}
}
?>