<?php
if(!isset($_SESSION))
	session_start();
$ck = false;
$url = array();
foreach(explode('/',$_SERVER['PHP_SELF']) as $baseV){
	if($ck)
		$url[] = $baseV;
	if($baseV == 'load.php')
		$ck = true;
}
print_r($url);
?>