<?php
class js {
	function getJs($obj) {
		if($obj){
			$arr = array(
				'Jquery' => 'lib/js/jquery.min.js',
				'JqueryUI' => 'lib/js/jquery-ui.js',
				'JqueryDataTables' => 'lib/js/jquery.dataTables.js'
			);
			if(in_array($obj, array_keys($arr)))
				include $arr[$obj];
			else
				include $arr['Jquery'];
		}else{
			echo 'error';
		}
	}
}