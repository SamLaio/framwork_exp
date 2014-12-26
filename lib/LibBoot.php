<?php
class LibBoot {
	function __construct($url) {
		/*檢查是否不用載入view*/
		$cgi = (isset($url[0]))?in_array($url[0],array('cgi','js')):false;
		$view = false;
		if(!$cgi){
			/*設定url[0]和url[1]*/
			$url[0] = (!isset($url[0]) or $url[0] == '')?'index':$url[0];
			$url[1] = (!isset($url[1]) or $url[1] == '')?'index':$url[1];
		}else{
			/*是cgi就把url[0]之後的向前搬*/
			if($url[0] == 'cgi'){
				$url[0] = $url[1];
				if(isset($url[2]))
					$url[1] = $url[2];
				$url[0] = (!isset($url[0]) or $url[0] == '')?'index':$url[0];
				$url[1] = (!isset($url[1]) or $url[1] == '')?'index':$url[1];
			}
			/*是js，就建立url[1](如果url[1]存在就搬進去，沒有就用Jquery)*/
			if($url[0] == 'js'){
				$url[1] = (!isset($url[1]) or $url[1] == '')?'Jquery':$url[1];
			}
		}
		/*檢查control的class是不是存在*/
		$control = $this->FileCk(SCANDIR('control'), $url[0]);
		if(!$cgi){
			/*檢查view的資料夾是不是存在*/
			$view = $this->FileCk(SCANDIR('view'), $url[0],false);
			/*檢查view的檔案是不是存在*/
			$view = $this->FileCk(SCANDIR("view/$view"), $url[1]);
			if($control == 'error' or $view == 'error'){
				$view = '404';
				$control = 'error';
			}
		}
		/*control start*/
		include "control/$control.php";
		$ControlObj = new $control;
		/*接control吐出來的資料*/
		$ControlRet = array();
		/*傳入的資料替代*/
		if(isset($_GET) and count($_GET) != 0)
			$data['get'] = $this->InDataCk($_GET);
		if(isset($_POST) and count($_POST) != 0)
			$data['post'] = $this->InDataCk($_POST);
		/*include js*/
		if($url[0] == 'js'){
			$data = $url[1];
			$url[1] = 'getJs';
		}
		/*檢查function是否在coltrol中*/
		if (method_exists($ControlObj, $url[1])) {
			if(isset($data)){
				$ControlRet = $ControlObj->{$url[1]}($data);
			}else{
				$ControlRet = $ControlObj->{$url[1]}();
			}
		}
		/*control end*/

		/*view start*/
		if($view){
			include "view/View.php";
			$ViewObj = new View($control .'/'.$view,$ControlRet);
		}
		/*view end*/
	}

	/*尋找檔案是否在資料夾中($isFile是指是不是單純只有指檔案)*/
	private function FileCk($FileArr, $FeileName, $isFile = true) {
		$ret = 'error';
		foreach ($FileArr as $value) {
			if (substr($value, 0, strrpos($value, ".")) == $FeileName and $isFile)
				$ret = $FeileName;
			if($value == $FeileName and !$isFile)
				$ret = $FeileName;
		}
		return $ret;
	}

	private function InDataCk($Indata = -1) {
		if($Indata != -1){
			$data = array();
			foreach ($Indata as $key => $value) {
				if(isset($_SESSION['PwHand']) and stristr($value,$_SESSION['PwHand']))
					$value = $this->PwDeCode(str_replace($_SESSION['PwHand'],'',$value));
				$data[$key] = $this->CheckInput($value);
			}
			return $data;
		}else{
			return false;
		}
	}

	private function CheckInput($Indata) {
		if (is_array($Indata)) {
			foreach ($Indata as $key => $value)
				$Indata[$key] = $this->CheckInput($value);
		} else {
			$Indata = str_replace(array("&", "'", '"', "<", ">"), array('@&5', '@&1', '@&2', '@&3', '@&4'), $Indata);
		}
		return $Indata;
	}

	private function PwDeCode($str){
		$tmp = '';
		$arr = $_SESSION['PwEnCode'];
		$str = explode('*|*', $str);
		foreach($str as $val){
			foreach($arr as $arr_v){
				if(urldecode($arr_v['val']) == urldecode($val)){
					$tmp .= urldecode($arr_v['id']);
				}
			}
		}
		return $tmp;
	}
}