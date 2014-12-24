<?php
class LibBoot {
	function __construct($url) {
		//檢查是否不用載入view
		$cgi = (isset($url[0]))?in_array($url[0],array('cgi','js')):false;
		$view = false;
		if(!$cgi){
			//設定url[0]和url[1]
			$url[0] = (!isset($url[0]) or $url[0] == '')?'index':$url[0];
			$url[1] = (!isset($url[1]) or $url[1] == '')?'index':$url[1];
		}else{
			//是cgi就把url[0]之後的向前搬
			if($url[0] == 'cgi'){
				$url[0] = $url[1];
				if(isset($url[2]))
					$url[1] = $url[2];
				$url[0] = (!isset($url[0]) or $url[0] == '')?'index':$url[0];
				$url[1] = (!isset($url[1]) or $url[1] == '')?'index':$url[1];
			}
			//是js，就建立url[1](如果url[2]存在就搬進去，沒有就用Jquery)
			if($url[0] == 'js'){
				$url[1] = (!isset($url[1]) or $url[1] == '')?'Jquery':$url[1];
			}
		}
		//檢查control的class是不是存在
		$control = $this->FileCk(SCANDIR('control'), $url[0]);

		if(!$cgi){
			//檢查view的資料夾是不是存在
			$view = $this->FileCk(SCANDIR('view'), $url[0],false);
			//檢查view的檔案是不是存在
			$view = $this->FileCk(SCANDIR("view/$view"), $url[1]);
			if($control == 'error' or $view == 'error'){
				$view = '404';
				$control = 'error';
			}
		}
		/*control start*/
		include "control/$control.php";
		$ControlObj = new $control;

		//接control吐出來的資料
		$ControlRet = array();
		//資料替代
		$data['get'] = $this->InDataCk($_GET);
		$data['post'] = $this->InDataCk($_POST);
		//include js
		if($url[0] == 'js'){
			$data = $url[1];
			$url[1] = 'getJs';
		}
		//檢查function是否在coltrol中
		if (method_exists($ControlObj, $url[1])) {
			if(
				(isset($data['get']) and count($data['get']) != 0) or
				(isset($data['post']) and count($data['post']) != 0) or
				$url[1] == 'getJs'
			){
				$ControlRet = $ControlObj->{$url[1]}($data);
			}else{
				$ControlRet = $ControlObj->{$url[1]}();
			}
		}


		/*control end*/

		/*view start*/
		if($view){
			include "view/View.php";
			$ViewObj = new View($url[0] .'/'.$view,$ControlRet);
		}
		/*view end*/
	}

	private function FileCk($arr, $file_name, $isFile = true) {
		$ret = 'error';
		foreach ($arr as $value) {
			if (substr($value, 0, strrpos($value, ".")) == $file_name and $isFile)
				$ret = $file_name;
			if($value == $file_name and !$isFile)
				$ret = $file_name;
		}
		return $ret;
	}

	private function InDataCk($arr) {
		$data = array();
		foreach ($arr as $key => $value) {
			$data[$key] = $this->CheckInput($value);
		}
		return $data;
	}

	private function CheckInput($value) {
		if (is_array($value)) {
			foreach ($value as $key2 => $value2)
				$value[$key2] = $this->CheckInput($value2);
		} else {
			$value = str_replace(array("&", "'", '"', "<", ">"), array('@&5', '@&1', '@&2', '@&3', '@&4'), $value);
		}
		return $value;
	}
}