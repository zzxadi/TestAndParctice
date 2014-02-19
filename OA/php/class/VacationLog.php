<?php
class VacationLog{
	private $id;
	private $user_id;
	private $type;
	private $bill_id;
	private $content;
	private $create_time;
	public function setUserId($user_id){
		$this->user_id = $user_id;
	}
	public function setType($type){
		$this->type = $type;
	}
	public function setBillId($bill_id){
		$this->bill_id = $bill_id;
	}
	public function setContent($content){
		$this->content = $content;
	}
	public function setCreateTime($create_time){
		$this->create_time = $create_time;
	}
	public function getId(){
		return $this->id;
	}
	public function getUserId(){
		return $this->user_id;
	}
	public function getType(){
		return $this->type;
	}
	public function getBillId(){
		return $this->bill_id;
	}
	public function getContent(){
		return $this->content;
	}
	public function getCreateTime(){
		return $this->create_time;
	}
}
?>