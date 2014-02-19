<?php
class VacationRecord{
	private $id;
	private $user_id;	//用户ID
	private $type;	//类型1：加班  2：请假/出差
	private $create_time;	//创建时间
	private $begin_time;	//开始时间
	private $end_time;	//结束时间
	private $total_time;	//总时间
	private $leave_type;	//请假类型：1：事假，2：病假，3：调休，4：婚嫁，5：产假，6：计生假，7：年休假，8：丧假，9：工伤假，10：出差，11：其他假
	private $leave_name;	//选择其他：填写请假类型，别的无需填写
	private $remark;	//备注、加班原因
	private $audit_status;	//审核状态1：未审核，2：审核通过，3：审核不通过
	private $current_userid;	//当前审核人ID
	private $previous_userid;	//前一审核人ID
	private $audit_time;	//审核时间
	private $audit_remark;	//审核备注
	public function setUserId($user_id){
		$this->user_id = $user_id;
	}
	public function setType($type){
		$this->type = $type;
	}
	public function setCreateTime($create_time){
		$this->create_time = $create_time;
	}
	public function setBeginTime($begin_time){
		$this->begin_time = $begin_time;
	}
	public function setEndTime($end_time){
		$this->end_time = $end_time;
	}
	public function setTotalTime($total_time){
		$this->total_time = $total_time;
	}
	public function setLeaveType($leave_type){
		$this->leave_type = $leave_type;
	}
	public function setLeaveName($leave_name){
		$this->leave_name = $leave_name;
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
	public function getBeginTime(){
		return $this->begin_time;
	}
	public function getEndTime(){
		return $this->end_time;
	}
	public function getTotalTime(){
		return $this->total_time;
	}
	public function getLeaveType(){
		return $this->leave_type;
	}
	public function getLeaveName(){
		return $this->leave_name;
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