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
			$arr['R'] = $this->ValAddTip($arr['R']);
			foreach($arr['R'] as $key => $val){
				$toDb['R'][] = "$key = $val";
			}
		}

		$toDb['R'][] = "(rebk is null or rebk ='')";
		$toDb['R'] = implode(' and ', $toDb['R']);

		$tmp = $this->Assoc($this->Table, '*',$toDb['R'], array('order_by'=>'seq desc'));
		if(count($tmp)!=0){
			$re['page']['count'] = count($tmp);
			$re['page']['row'] = $this->row;
			$re['page']['page']= (isset($arr['page']))?$arr['page']+1:1;
			$i = 1;
			foreach($tmp as $val){
				$val['content']=nl2br(str_replace(array('<','>'),array('&lt;','&gt;'),$val['content']));
				$re['data'][$i][] = $val;
				if(count($re['data'][$i]) % $this->row == 0){
					$i++;
				}
			}
			if(isset($re['data'][$re['page']['page']])){
				$re['data'] = $re['data'][$re['page']['page']];

				$tmp ='';
				foreach($re['data'] as $val){
					$tmp .= ($tmp != '')?','.$val['seq']:$val['seq'];
				}
				$tmp = $this->Assoc($this->Table, $toDb['F'], "rebk in ($tmp)", array('order_by'=>'seq desc'));
				foreach($tmp as $key =>$val)
					$tmp[$key]['content']=nl2br(str_replace(array('<','>'),array('&lt;','&gt;'),$tmp[$key]['content']));
				$re['data'] = array_merge($re['data'], $tmp);
				return $re;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	public function SaveFlow($arr = false){
		if($arr){
			//$arr['content'] = $this->ValEncode(nl2br(urlencode($arr['content'])));
			$arr['date'] = date('Y-m-d H:i:s');
			if($arr['id'] != 0)
				$arr['rebk'] = $arr['id'];
			unset($arr['id']);
			$sql=$this->In($this->Table,$arr);
			$this->Query($sql);
			return true;
		}else{
			return false;
		}
	}
}