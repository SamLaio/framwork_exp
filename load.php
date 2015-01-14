<?php
if(!isset($_SESSION))
	session_start();
$UrlBase = explode('load.php',$_SERVER['PHP_SELF']);
if(!isset($_SESSION['SiteUrl'])){
	$port = ($_SERVER['SERVER_PORT'] == 80)?'http://':'https://';
	$_SESSION['SiteUrl'] = $port . $_SERVER['HTTP_HOST'] . $UrlBase[0];
}
$url = array();
foreach(explode('/',$UrlBase[1]) as $val){
	if($val != '')
		$url[] = $val;
}
/*set data base info*/
if(!defined ('DbType') or !defined ('DbHost') or !defined ('DbUser') or !defined ('DbPw') or !defined ('DbName')){
	$DbType = 'mysql';
	$DbHost = '127.0.0.1';
	$DbUser = 'root';
	$DbPw = '';
	$DbName = 'framwork_exp';
	if(!defined ('DbType'))
		define('DbType', $DbType);
	if(!defined ('DbHost'))
		define('DbHost', $DbHost);
	if(!defined ('DbUser'))
		define('DbUser', $DbUser);
	if(!defined ('DbPw'))
		define('DbPw', $DbPw);
	if(!defined ('DbName'))
		define('DbName', $DbName);
}
/*set data base info*/

include 'lib/LibDataBase.php';
include 'lib/LibBoot.php';
$boot = new LibBoot($url);