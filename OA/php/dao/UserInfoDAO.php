<?php
	class UserInfoDAO {
		function getUserList($stInfo){	
			$iPage = (int)$stInfo['page'];
			$iCount = (int)$stInfo['count'];
			$stUsername = $stInfo['username'];
			$stEmail = $stInfo['email'];
			$iRoleId = (int)$stInfo['roleId'];
			$Id = (int)$stInfo['Id'];
			if($iPage <= 0)$iPage = 1;
			if($iCount <= 0)$iCount = 30;
			else if($iCount > 50)$iCount = 50;
			$sPageCondition = " limit ".(($iPage-1)*$iCount).",".$iCount;
			$sSql = "select id, Role_ID, User_Name, Login_Name, Mobile, Email, Sex, Department_Type, Position_Name, Induction_Time from USER_INFO";
			$sCondition = " where 0=0 ";
			if(!empty($Id)){
				$sCondition .= " and ID = '" .$Id. "' ";
			}
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

		/*function doAdd($stInfo){
			$stUsername = $stInfo['username'];
			$stEmail = $stInfo['email'];
			$iRoleId = (int)$stInfo['roleId'];
			$sSql = "INSERT INTO USER_INFO(Role_ID, User_Name, Login_Name, Mobile, Email, Sex, Department_Type, Position_Name, Induction_Time, CREATE_TIME) VALUES (";
			$sSql .= $iRoleId + ', ' + $stUsername + ', ' + ', ' + $stLoginname + ', ' + $stMobile + ', ' + $stEmail + ', ' + $iSex + ', ' + $iDeptType + ', ' + $stPos + ', ' + $dInd + ', ' + date(‘Y-m-d H:i:s’) + ')';  
			

			$stConn = new MysqlConn();
			$stResult = $stConn->query($sSql);
			$stList = array();
			while($stInfo = mysql_fetch_assoc($stResult)){
				$stList[] = $stInfo;	
			}
			mysql_free_result($stResult);
			return $stList;	
		}*/
	}
?>