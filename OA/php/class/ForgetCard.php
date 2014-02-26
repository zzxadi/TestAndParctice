<?php
class ForgetCard{
	private $id;	//ID
	private $user_id;	//用户ID
	private $type;	//忘记类型1：上班 2：下班
	private $create_time;	//创建时间
	private $forget_time;	//忘记时间
	private $in_time;	//到/离岗时间
	private $remark;	//备注
	private $audit_status;	//审核状态0：未审核，1：审核中，2：审核通过，3：审核不通过
	private $current_userid;	//当前审核人ID
	private $previous_userid;	//前一审核人ID
	private $audit_time;	//审核时间
	private $audit_remark;	//审核备注
	
	public function setId($id){
		$this->id = $id;
	}
	public function setUserId($user_id){
		$this->user_id = $user_id;
	}
	public function setType($type){
		$this->type = $type;
	}
	public function setCreateTime($create_time){
		$this->create_time = $create_time;
	}
	public function setForgetTime($forget_time){
		$this->forget_time = $forget_time;
	}
	public function setInTime($in_time){
		$this->in_time = $in_time;
	}
	public function setRemark($remark){
		$this->remark = $remark;
	}
	public function setAuditStatus($audit_status){
		$this->audit_status = $audit_status;
	}
	public function setCurrentUserid($current_userid){
		$this->current_userid = $current_userid;
	}
	public function setPreviousUserid($previous_userid){
		$this->previous_userid = $previous_userid;
	}
	public function setAuditTime($audit_time){
		$this->audit_time = $audit_time;
	}
	public function setAuditRemark($audit_remark){
		$this->audit_remark = $audit_remark;
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
	public function getCreateTime(){
		return $this->create_time;
	}
	public function getForgetTime(){
		return $this->forget_time;
	}
	public function getInTime(){
		return $this->in_time;
	}
	public function getRemark(){
		return $this->remark;
	}
	public function getAuditStatus(){
		return $this->audit_status;
	}
	public function getCurrentUserid(){
		return $this->current_userid;
	}
	public function getPreviousUserid(){
		return $this->previous_userid;
	}
	public function getAuditTime(){
		return $this->audit_time;
	}
	public function getAuditRemark(){
		return $this->audit_remark;
	}
}
?>