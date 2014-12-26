<?php
class ModelIndex extends LibDataBase {
	private $Table;
	function __construct() {
		parent::__construct();
		$this->Table = 'user';
	}

	/*public function CheckUser($arr){
		if(isset($arr['post'])){
			$arr = $arr['post'];
			$arr = array('account'=>$arr['acc'],'pswd'=>$arr['pswd']);
			$re = $this->Assoc($this->Table,'*',$arr);
			print_r($arr);
		}
	}*/

	public function GetFlow($arr=-1){
		if(isset($arr['post'])){
			$arr = $arr['post'];
		}
	}
}