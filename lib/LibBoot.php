<?php
class LibBoot {
	function __construct($url) {
		$cgi = false;
		if(isset($url[0]))
			$cgi = in_array($url[0],array('cgi','js'));
		$view = false;
		if(!$cgi){
			$url[0] = (!isset($url[0]) or $url[0] == '')?'index':$url[0];
			$url[1] = (!isset($url[1]) or $url[1] == '')?'index':$url[1];
		}else{
			if($url[0] == 'cgi'){
				$url[0] = $url[1];
				if(isset($url[2]))
					$url[1] = $url[2];
				$url[0] = (!isset($url[0]) or $url[0] == '')?'index':$url[0];
				$url[1] = (!isset($url[1]) or $url[1] == '')?'index':$url[1];
			}
			if($url[0] == 'js'){
				$url[1] = (!isset($url[2]) or $url[2] == '')?'index':$url[2];
			}
		}
		$control = $this->FileCk(SCANDIR('control'), $url[0]);

		if(!$cgi){
			$view = $this->FileCk(SCANDIR('view'), $url[0],false);
			$view = $this->FileCk(SCANDIR("view/$view"), $url[1]);
			if($control == 'error' or $view == 'error'){
				$view = '404';
				$control = 'error';
			}
		}
		/*control start*/
		//檢查檔案是否存在
		include "control/$control.php";
		$ControlObj = new $control;

		//接control吐出來的資料
		$ControlRet = array();
		//資料替代
		$data['get'] = $this->InDataCk($_GET);
		$data['post'] = $this->InDataCk($_POST);
		//檢查function是否在coltrol中
		if (method_exists($ControlObj, $url[1])) {
			$ControlRet = (count($data['get']) != 0 or count($data['post']) != 0)? $ControlObj->{$url[1]}($data): $ControlObj->{$url[1]}();
		}

		//include js
		if($url[0]=='js'){
			$url[1] = (!isset($url[1]) or $url[1] == 'index')?'Jquery':$url[1];
			$ControlObj->getJs($url[1]);
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