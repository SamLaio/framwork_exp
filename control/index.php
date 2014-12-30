<?php
class index {
	private $db;
	function __construct(){
		include 'model/index.php';
		$this->db = new ModelIndex;
	}

	public function index($arr = false){
		$re = false;
		if(isset($arr['post'])){
			$re = $arr['post'];
		}
		if(isset($arr['get']['page']))
			$re['page'] = $arr['get']['page']-1;
		$re = $this->db->GetFlow($re);
		if($re['data']==false)
			return false;
		$re['data'] = $this->ReWriteFlow($re['data']);
		return $re;
	}

	public function ReBkFn($arr){
		if(isset($arr['post'])){
			if($this->db->SaveFlow($arr['post'])){
				echo 1;
			}else{
				echo -1;
			}
		}
	}
	private function ReWriteFlow($arr){
		$re = array();
		foreach($arr as $key => $val){
			if($val['rebk'] != '' and isset($re[$val['rebk']])){
				$re[$val['rebk']][] = $val;
			}else{
				$re[$val['seq']][] = $val;
			}
		}
		return $re;
	}
}