<?php
if(!isset($_SESSION))
	session_start();
$UrlBase = explode('load.php',$_SERVER['PHP_SELF']);
if(!isset($_SESSION['SiteUrl'])){
	$port = ($_SERVER['SERVER_PORT'] == 80)?'http://':'https://';
	$_SESSION['SiteUrl'] = $port . $_SERVER['HTTP_HOST'] . $UrlBase[0];
}
$url = array();
if(isset($UrlBase[1])){
	if(trim($UrlBase[1],'/') != ''){
		$url = explode('/',trim($UrlBase[1],'/'));
	}
}
/*set data base info*/
$MeHend = array(
	'DbType' => 'mysql',
	'DbHost' => '127.0.0.1',
	'DbUser' => 'root',
	'DbPw' => '',
	'DbName' => 'framwork_exp'
);
foreach($MeHend as $key => $val){
	if(!defined ($key))
		define($key, $val);
}
/*set data base info*/

include 'lib/LibDataBase.php';
include 'lib/LibBoot.php';
$boot = new LibBoot($url);
