<?php
class ModelAdmin extends LibDataBase{
	private $Table;
	function __construct(){
		parent::__construct();
		$this->Table = 'user';
	}

	public function UserCheck($arr){
		$re = $this->Assoc($this->Table,'*',"account='".$arr['acc']."' and pswd = '".md5($arr['pswd'])."'");
		if(count($re) == 1){
			return $re[0];
		}else{
			return false;
		}
	}
}