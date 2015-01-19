<?php
class ModelAdmin extends LibDataBase{
	private $Table;
	private $FlowTable;
	function __construct(){
		parent::__construct();
		$this->Table = 'user';
		$this->FlowTable = 'flow';
	}

	public function UserCheck($arr){
		$re = $this->Assoc($this->Table,'*',"account='".$arr['acc']."' and pswd = '".md5($arr['pswd'])."'");
		if(count($re) == 1){
			return $re[0];
		}else{
			return false;
		}
	}

	public function GetFlow($arr = false){
		$fold = '*';
		$where = '';
		if($arr){
			if(isset($arr['fold'])){
				$fold = implode(',', $fold);
			}
			if(isset($arr['where'])){
				foreach($arr['where'] as $key => $value){
					$where[] = "$key = '$value'";
				}
				$where = implode(' and ', $where);
			}
		}
		return $this->Assoc($this->FlowTable,$fold,$where);
	}
}