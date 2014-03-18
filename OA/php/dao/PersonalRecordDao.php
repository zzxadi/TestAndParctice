<?php
	class PersonRecordDao {
		function getList($stInfo){	
			$iPage = (int)$stInfo['page'];
			$iCount = (int)$stInfo['count'];
			$Id = (int)$stInfo['Id'];
			$Type= (int)$stInfo['type'];			
			if($iPage <= 0)$iPage = 1;
			if($iCount <= 0)$iCount = 30;
			else if($iCount > 50)$iCount = 50;
			$sPageCondition = "  limit ".(($iPage-1)*$iCount).",".$iCount;
			$sSql ="SELECT VR.*,u1.USER_NAME AS CURRENT_USER_NAME,u2.USER_NAME AS PRIVIOUS_USER_NAME,u3.USER_NAME AS USER_NAME FROM ";
			$sSqlById = "select USER_ID from ";
			if($Type==1){
				$sSql .=" VACATION_RECORD ";
				$sSqlById .=" VACATION_RECORD ";
			} 
			if($Type==2){
				$sSql .=" FORGET_CARD ";
				$sSqlById .=" FORGET_CARD ";
			}
			if($Type==3){
				$sSql .=" VACATION_RECORD ";
				$sSqlById .=" VACATION_RECORD ";
			}
			if($Type==4){
				$sSql .=" FORGET_CARD ";
				$sSqlById .=" FORGET_CARD ";
			}
			
			$sSql .=" VR LEFT JOIN USER_INFO u1 ON VR.CURRENT_USERID=u1.ID LEFT JOIN USER_INFO u2 ON VR.PREVIOUS_USERID=u2.ID LEFT JOIN USER_INFO u3 ON VR.USER_ID=u3.ID where 1=1";
			$sSqlById .= " where 1=1 ";
			$sCondition = " and USER_ID = '" .$Id. "' ORDER BY CREATE_TIME DESC ";  
			
			if($Type==3||$Type==4){
				$sSql .=" and (AUDIT_STATUS=1 or AUDIT_STATUS=0) ";
				$sSqlById .= " and (AUDIT_STATUS=1 or AUDIT_STATUS=0) ";
			}
			if($Type==5){
				$sSql = "select * from VACATION  where 1=1 ";
 				$sSqlById = "select USER_ID from VACATION  where 1=1 ";
				$sCondition = " and USER_ID = '" .$Id. "' ORDER BY VACATION_TYPE ";  
			}
			$stConn = new MysqlConn();
			$sSqlById .= $sCondition;
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
	}
?>