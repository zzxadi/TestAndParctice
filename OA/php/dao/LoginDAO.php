<?php
	class LoginDAO {
		function login($email, $passwd){
			$sSql = "select id from USER_INFO where 0=0 ";
			$sCondition = " and email = '" . $email . "@digione.cn' and password = '" . sha1($passwd) ."' limit 1 ";
			$stConn = new MysqlConn();
			$stResult = $stConn->query($sSql . $sCondition);
			$isExist = (int)mysql_num_rows($stResult);
			$result = false;
			if($isExist == 1){
				$stInfo = mysql_fetch_assoc($stResult);
				$userId = (int)$stInfo['id'];
				$result = loginCookie($userId);
			}
			mysql_free_result($stResult);
			return $result;
		}

		function logout(){
			return exitLogin();
		}

		function updatePwd($oldPwd,$newPwd){
			$stConn = new MysqlConn();
			$smArr = array('password' => sha1($newPwd));
			return $stConn->update('USER_INFO',$smArr,'id = '.getUserId().' and password = "'.sha1($oldPwd).'"');
		}
	}
?>