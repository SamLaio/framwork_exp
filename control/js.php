<?php
class js {
	function getJs($obj) {
		echo $obj;
		if($obj){
			$arr = array(
				'Jquery' => 'lib/js/jquery.min.js',
				'JqueryUI' => 'lib/js/jquery-ui.js',
				'JqueryDataTables' => 'lib/js/jquery.dataTables.js',
				'ckeditor'=>'lib/js/ckeditor/ckeditor.js',
				'ckfinder'=>"lib/js/ckfinder/ckfinder.js"
			);
			if(in_array($obj, array_keys($arr)))
				include $arr[$obj];
		}else{
			echo 'error';
		}
	}
}