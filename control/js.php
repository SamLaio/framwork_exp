<?php
class js {
	function getJs($obj = false) {
		$arr = array(
			'Jquery' => 'lib/js/jquery.min.js',
			'JqueryUI' => 'lib/js/jquery-ui.js',
			'JqueryDataTables' => 'lib/js/jquery.dataTables.js'/*,
			'Lang' => 'lib/js/Lang.js'*/
		);
		if($obj and in_array($obj, array_keys($arr))){
			include $arr[$obj];
		}else{
			include $arr['Jquery'];
		}
	}
}