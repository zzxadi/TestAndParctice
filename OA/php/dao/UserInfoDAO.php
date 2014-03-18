<?php
	class UserInfoDAO {
		function getUserById($id){
			$sSql = "select Role_ID, User_Name, Login_Name, Mobile, Email, Sex, Department_Type, Position_Name, Induction_Time from USER_INFO";
			$sCondition = " where 0=0 " . " and id = " . $id;
			$stConn = new MysqlConn();
			$stResult = $stConn->query($sSql . $sCondition);
			$stList = array();
			while($stInfo = mysql_fetch_assoc($stResult)){
				$stList[] = $stInfo;	
			}
			mysql_free_result($stResult);
			$stReturn['list'] = $stList;
			return $stReturn;	
		}
		
		function getVacationById($id){
			$sSql = "select * from VACATION ";
			$sCondition = " where 0=0 " . " and USER_ID = " . $id;
			$stConn = new MysqlConn();
			$stResult = $stConn->query($sSql . $sCondition);
			$stList = array();
			while($stInfo = mysql_fetch_assoc($stResult)){
				$stList[] = $stInfo;	
			}
			mysql_free_result($stResult);
			$stReturn['list'] = $stList;
			return $stReturn;	
		}
		
		function  getVacationByIdTYPE($id,$vacationType){
			$sSql = "select * from VACATION ";
			$sCondition = " where 0=0 " . " and USER_ID = " . $id." and VACATION_TYPE = ".$vacationType;
			$stConn = new MysqlConn();
			$stResult = $stConn->query($sSql . $sCondition);
			$stList = array();
			while($stInfo = mysql_fetch_assoc($stResult)){
				$stList[] = $stInfo;	
			}
			mysql_free_result($stResult);
			$stReturn['list'] = $stList;
			return $stReturn;	
		}
		
		function getUserByLoginname($stLoginname){
			$sSql = "select * from USER_INFO";
			$sCondition = " where 0=0 " . " and LOGIN_NAME = '" . $stLoginname."'";
			$stConn = new MysqlConn();
			$stResult = $stConn->query($sSql . $sCondition);
			$stList = array();
			while($stInfo = mysql_fetch_assoc($stResult)){
				$stList[] = $stInfo;	
			}
			mysql_free_result($stResult);
			$stReturn['list'] = $stList;
			return $stReturn;	
		}
		
		function getUserList($stInfo){	
			$iPage = (int)$stInfo['page'];
			$iCount = (int)$stInfo['count'];
			$stUsername = $stInfo['username'];
			$stEmail = $stInfo['email'];
			$iRoleId = (int)$stInfo['roleId'];
			if($iPage <= 0)$iPage = 1;
			if($iCount <= 0)$iCount = 30;
			else if($iCount > 50)$iCount = 50;
			$sPageCondition = " limit ".(($iPage-1)*$iCount).",".$iCount;
			$sSql = "select id, Role_ID, User_Name, Login_Name, Mobile, Email, Sex, Department_Type, Position_Name, Induction_Time, STATUS from USER_INFO";
			$sCondition = " where 0=0 ";
			if(!empty($stUsername)){
				$sCondition .= " and User_Name like '%" . $stUsername . "%' ";
			}
			if(!empty($stEmail)){
				$sCondition .= " and Email like '%" . $stEmail . "%' ";
			}
			if(!empty($iRoleId)){
				$sCondition .= " and Role_ID = '" . $iRoleId . "' ";
			}
			$stConn = new MysqlConn();
			$sSqlById = "select ID from USER_INFO " . $sCondition;
			$stResult = $stConn->query($sSqlById);
			$iNumRows = (int)mysql_num_rows($stResult);
			$sSql .=  $sCondition . $sPageCondition;
			$stResult = $stConn->query($sSql);
			$stList = array();
			while($stInfo = mysql_fetch_assoc($stResult)){
				$stList[] = $stInfo;	
			}
			mysql_free_result($stResult);
			$stReturn = array();
			$stReturn['total'] = $iNumRows;
			$stReturn['page'] = $iPage;
			$stReturn['pageTotal'] = (int)ceil($iNumRows/$iCount);
			$stReturn['list'] = $stList;
			return $stReturn;	
		}
		
		function updateVacation($vacationInfo){
			$userId = $vacationInfo['userId'];
			$vacationType = $vacationInfo['vacationType'];
			$remain = $vacationInfo['remain'];

			$sSql = "INSERT INTO VACATION(USER_ID, VACATION_TYPE, REMAIN) VALUES ( ";
			$sSql .= $userId . ', "' . $vacationType . '", "' . $remain . '")'; 			
			$stConn = new MysqlConn();
			$stResult = $stConn->query($sSql);
			return $stResult;	 
		}
		
		function ModifyVacation($vacationInfo){
			$userId = $vacationInfo['userId'];
			$vacationType = $vacationInfo['vacationType'];
			$remain = $vacationInfo['remain'];
			$sSql =	"Update VACATION Set  REMAIN ='".$remain."'  Where  USER_ID='".$userId."' AND VACATION_TYPE='".$vacationType."'";	
			$stConn = new MysqlConn();
			$stResult = $stConn->query($sSql);
			echo $stResult;
			return $stResult;	 
		}

		function doAdd($stInfo){
			$stUsername = $stInfo['username'];
			$stLoginname = $stInfo['loginname'];
			$stMobile = $stInfo['mobile'];
			$stEmail = $stInfo['email'];
			$iSex = (int)$stInfo['sex'];
			$iDeptType = (int)$stInfo['dept'];
			$stPosition = $stInfo['position'];
			$stIndTime = $stInfo['indTime'];
			$iRoleId = (int)$stInfo['roleId'];
			$stPassword = sha1('000000');
			$sSql = "INSERT INTO USER_INFO(ROLE_ID, USER_NAME, LOGIN_NAME, PASSWORD, MOBILE, EMAIL, SEX, DEPARTMENT_TYPE, POSITION_NAME, INDUCTION_TIME, CREATE_TIME, STATUS) VALUES ( ";
			$sSql .= $iRoleId . ', "' . $stUsername . '", "' . $stLoginname . '", "' . $stPassword . '", "' . $stMobile . '", "' . $stEmail . '", ' . $iSex . ', ' . $iDeptType . ', "' . $stPosition . '", "' . $stIndTime . '", "' . date('Y-m-d H:i:s') . '", 0)'; 			
			$stConn = new MysqlConn();
			$stResult = $stConn->query($sSql);
			return $stResult;	
		}

		function doModify($stInfo){
			$id = $stInfo['id'];
			$stUsername = $stInfo['username'];
			$stLoginname = $stInfo['loginname'];
			$stMobile = $stInfo['mobile'];
			$stEmail = $stInfo['email'];
			$iSex = (int)$stInfo['sex'];
			$iDeptType = (int)$stInfo['dept'];
			$stPosition = $stInfo['position'];
			$stIndTime = $stInfo['indTime'];
			$iRoleId = (int)$stInfo['roleId'];
			
			$sSql = "Update USER_INFO Set ROLE_ID=".$iRoleId.", USER_NAME='".$stUsername."', LOGIN_NAME='".$stLoginname."', ";
			$sSql .= "MOBILE='".$stMobile."', EMAIL='".$stEmail."', SEX=".$iSex.", DEPARTMENT_TYPE=".$iDeptType.", Position_Name='".$stPosition."', Induction_Time='".$stIndTime;
			$sSql .="' Where id=".$id;	
			$stConn = new MysqlConn();
			$stResult = $stConn->query($sSql);
			return $stResult;		
		}

		function doFreeze($id){
			$sql = "select status from USER_INFO where id = " . $id . " limit 1";
			$stConn = new MysqlConn();
			$stResult = $stConn->query($sql);
			$stInfo = mysql_fetch_assoc($stResult);
			$status = (int)$stInfo['status'];
			if($status==0){
				$status=1;
			}
			else{
				$status=0;
			}		
			$sql = "update USER_INFO set STATUS = ".$status." where 0=0 and id = " . $id;
			$stResult = $stConn->query($sql);
			return $stResult;	
		}

		function isMobileExist($mobile){
			$sSql = "select id from USER_INFO where 0=0 ";
			$sCondition = " and MOBILE = ''" . $mobile ."' limit 1 ";
			$stConn = new MysqlConn();
			$stResult = $stConn->query($sSql . $sCondition);
			$isExist = (int)mysql_num_rows($stResult);
			$result = false;
			if($isExist == 1){
				$result = true;
			}
			mysql_free_result($stResult);
			return $result;			
		}

		function isEmailExist($email){
			$sSql = "select id from USER_INFO where 0=0 ";
			$sCondition = " and EMAIL = ''" . $email ."' limit 1 ";
			$stConn = new MysqlConn();
			$stResult = $stConn->query($sSql . $sCondition);
			$isExist = (int)mysql_num_rows($stResult);
			$result = false;
			if($isExist == 1){
				$result = true;
			}
			mysql_free_result($stResult);
			return $result;	
		}		
	}
?>