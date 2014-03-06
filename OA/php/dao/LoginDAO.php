<?php
	class LoginDAO {
		function login($email, $passwd){
			$sSql = "select id, user_name, position_name, status from USER_INFO where 0=0 ";
			$sCondition = " and email = '" . $email . "@digione.cn' and password = '" . sha1($passwd) ."' limit 1 ";
			$stConn = new MysqlConn();
			$stResult = $stConn->query($sSql . $sCondition);
			$isExist = (int)mysql_num_rows($stResult);
			$result = false;
			$stInfo = '';
			if($isExist == 1){
				$stInfo = mysql_fetch_assoc($stResult);
				$userId = (int)$stInfo['id'];
				$result = loginCookie($userId);
			}
			mysql_free_result($stResult);
			return $stInfo;
		}

		function logout(){
			return exitLogin();
		}

		function updatePwd($oldPwd,$newPwd){
			$stConn = new MysqlConn();
			$smArr = array('password' => sha1($newPwd));
			return $stConn->update('USER_INFO',$smArr,'id = '.getUserId().' and password = "'.sha1($oldPwd).'"');
		}

		function checkLoginnameMul($loginname){
			$sSql = "select id from USER_INFO where 0=0 ";
			$sCondition = " and login_name = '" . $loginname ."' limit 1 ";
			$stConn = new MysqlConn();
			$stResult = $stConn->query($sSql . $sCondition);
			$isExist = (int)mysql_num_rows($stResult);
			$result = true;
			$stInfo = '';
			if($isExist == 1){
				$stInfo = mysql_fetch_assoc($stResult);
				$result = false;
			}
			mysql_free_result($stResult);
			return $result;			
		}
	}
?>