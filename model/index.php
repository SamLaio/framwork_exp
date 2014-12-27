<?php
class ModelIndex extends LibDataBase {
	private $Table;
	private $row = 50;
	function __construct() {
		parent::__construct();
		$this->Table = 'flow';
	}

	public function GetFlow($arr=false){
		$toDb['R'] = array();
		$toDb['F'] = (isset($arr['F']) and $arr['F'] != '')?$arr['F']:'*';
		if(isset($arr['R'])){
			foreach($this->ValAddTip($arr['R']) as $kay => $val){
				$toDb[] = "$key = $val";
			}
		}
		$toDb['limit']='';
		if(isset($arr['page'])){
			$toDb['limit'] = ($arr['page']==0)?0: ($arr['page']*$this->row+1);
			$toDb['limit'] = $arr['page'].','.$this->row;
		}
		$toDb['R'] = implode(' and ', $toDb['R']);
		$re['page']['count'] = count($this->Assoc($this->Table, $toDb['F'], $toDb['R']));
		$re['page']['row'] = $this->row;
		$re['page']['page']= (isset($arr['page']))?$arr['page']+1:1;
		$re['data'] = $this->Assoc($this->Table, $toDb['F'], $toDb['R'], array('limit'=>$toDb['limit']));
		return $re;
	}
}