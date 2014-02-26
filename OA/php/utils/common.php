<?php
function getParamByName($ParamName){
	if (isset($_POST[$ParamName]))
		return $_POST[$ParamName];
	else if (isset($_GET[$ParamName]))
		return $_GET[$ParamName];
	else return false;
}
function getParamByNameWithDefaultValue($ParamName, $DefaultValue){
		$result = getParamByName($ParamName);
		if ($result == NULL)
			$result = $DefaultValue;

		return $result;
}
function getParam($ParamName, $DefaultValue){
	$result = getParamByNameWithDefaultValue($ParamName, $DefaultValue);
	if(is_int($DefaultValue))$result = (int)$result;
	else if(is_array($DefaultValue));
	else mysql_escape_string(htmlspecialchars(trim($result)));
	return $result;
}
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0){
		$ckey_length = 4;
		//$key = md5($key ? $key : $GLOBALS['discuz_auth_key']);
		$key = md5($key);
		$keya = md5(substr($key, 0, 16));
		$keyb = md5(substr($key, 16, 16));
		$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

		$cryptkey = $keya.md5($keya.$keyc);
		$key_length = strlen($cryptkey);

		$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
		$string_length = strlen($string);

		$result = '';
		$box = range(0, 255);

		$rndkey = array();
		for($i = 0; $i <= 255; $i++) {
			$rndkey[$i] = ord($cryptkey[$i % $key_length]);
		}

		for($j = $i = 0; $i < 256; $i++) {
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}

		for($a = $j = $i = 0; $i < $string_length; $i++) {
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}

		if($operation == 'DECODE') {
			if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
				return substr($result, 26);
			} else {
				return '';
			}
		} else {
			return $keyc.str_replace('=', '', base64_encode($result));
		}

}
function isIDArray($stID){
	if(!is_array($stID))$stID = explode(",",$stID);
	if(!is_array($stID) || count($stID) <= 0)return false;
	$stID = array_unique($stID);
	for($i = 0, $length = count($stID); $i < $length; $i++){
		$iID = (int)$stID[$i];
		if($iID <=0)return false;
	}
	return true;
}
function jsonMake($stArray){
	$iStatus = isArray($stArray);
	if($iStatus == 0)return '"'.$stArray.'"';
	else if($iStatus == 1)return jsonMakeIndexArray($stArray);
	else if($iStatus == 2)return jsonMakeKeyArray($stArray);
}
function jsonMakeIndexArray($stArray){
	$stContent = array();
	$sJson = "[";
	for($i = 0, $length = count($stArray); $i < $length; $i++){
		$sStr = "";
		if(isArray($stArray[$i]) == 1)$sStr = jsonMakeIndexArray($stArray[$i]);
		else if(isArray($stArray[$i]) == 2)$sStr = jsonMakeKeyArray($stArray[$i]);
		else {
			if(is_integer($stArray[$i]))$sStr = $stArray[$i];
			else $sStr = '"'.mysql_escape_string($stArray[$i]).'"';
		}	
		$stContent[] = $sStr;
	}
	$sJson .= implode(",",$stContent);
	$sJson .= "]";
	return $sJson;	
}
function jsonMakeKeyArray($stArray){
	$stContent = array();
	$sJson = "{";
	foreach ($stArray as $name => $value){
		$sStr = '"'.dataChangeName($name).'":';
		if(isArray($value) == 1)$sStr .= jsonMakeIndexArray($value);
		else if(isArray($value) == 2)$sStr .= jsonMakeKeyArray($value);
		else {
			if(is_integer($value))$sStr .= $value;
			else $sStr .= '"'.mysql_escape_string($value).'"';
		}	
		$stContent[] = $sStr;	
	}
	$sJson .= implode(",",$stContent);
	$sJson .= "}";
	return $sJson;
}

function xmlMake($stArray){
	$iStatus = isArray($stArray);
	if($iStatus == 0)return $stArray;
	else if($iStatus == 1)return xmlMakeIndexArray($stArray);
	else if($iStatus == 2)return xmlMakeKeyArray($stArray);
}
function xmlMakeIndexArray($stArray){
	$stContent = array();
	$sXml = "<XmlList>";
	for($i = 0, $length = count($stArray); $i < $length; $i++){
		$sStr = "";
		if(isArray($stArray[$i]) == 1)$sStr = xmlMakeIndexArray($stArray[$i]);
		else if(isArray($stArray[$i]) == 2)$sStr = xmlMakeKeyArray($stArray[$i]);
		else {
			$sStr = '<XmlItem><![CDATA['.mysql_escape_string($stArray[$i]).']]></XmlItem>';
		}	
		$stContent[] = $sStr;
	}
	$sXml .= implode("",$stContent);
	$sXml .= "</XmlList>";
	return $sXml;	
}
function xmlMakeKeyArray($stArray){
	$stContent = array();
	$sXml = "<XmlItem>";
	foreach ($stArray as $name => $value){
		$sStr = '<'.dataChangeName($name).'>';
		if(isArray($value) == 1)$sStr .= xmlMakeIndexArray($value);
		else if(isArray($value) == 2)$sStr .= xmlMakeKeyArray($value);
		else {
			$sStr .= '<![CDATA['.mysql_escape_string($value).']]>';
		}	
		$sStr .= '</'.dataChangeName($name).'>';
		$stContent[] = $sStr;	
	}
	$sXml .= implode("",$stContent);
	$sXml .= "</XmlItem>";
	return $sXml;
}
//判断是否是键值数组,1=键值数组，2=普通数组
function isArray($array){
	if(!is_array($array))return 0;
	else if(count($array) == 0 || array_keys($array) === range(0, count($array) - 1))return 1;
	else return 2;
}
//名称改成驼峰写法
function dataChangeName($sName){
	$stNewName = array();
	$stName = explode("_",$sName);
	for($i = 0, $length = count($stName); $i < $length; $i++){
		$stName[$i] = strtolower(trim($stName[$i]));
		if($i != 0)$stName[$i] = ucwords($stName[$i]);
		$stNewName[] = $stName[$i]; 		
	}
	return implode("",$stNewName);
}
function dataPrint($stInfo){
	if(!isset($stInfo['dataType']))$stInfo['dataType'] = 0;
	if(!isset($stInfo['fieldArray']))$stInfo['fieldArray'] = array();
	$iDataType = (int)$stInfo['dataType'];
	$stEntity = $stInfo['entity'];
	$iMsgCode = (int)$stInfo['msgCode'];
	$sMsg = $stInfo['msg'];
	$stFieldArray = $stInfo["fieldArray"];
	$sContent = "null";
	if($iDataType == 0){
		if($stEntity !== false){
			$sContent = jsonMake($stEntity);	
		}
		echo '{"entity":'.$sContent.',"msgCode":'.$iMsgCode.',"msg":"'.$sMsg.'"}';
	}else if($iDataType == 1){
		if($stEntity !== false){
			$sContent = xmlMake($stEntity);
		}
		header("Content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?><root><entity>'.$sContent.'</entity><msgCode>'.$iMsgCode.'</msgCode><msg><![CDATA['.$sMsg.']]></msg></root>';		
	}
	exit;
}
?>
