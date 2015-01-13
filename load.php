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
if(!isset(DbType) or !isset(DbHost) or !isset(DbUser) or !isset(DbPw) or !isset(DbName)){
	$DbType = 'mysql';
	$DbHost = '127.0.0.1';
	$DbUser = 'root';
	$DbPw = '';
	$DbName = 'framwork_exp';
	if(!isset(DbType))
		define('DbType', $DbType);
	if(!isset(DbHost))
		define('DbHost', $DbHost);
	if(!isset(DbUser))
		define('DbUser', $DbUser);
	if(!isset(DbPw))
		define('DbPw', $DbPw);
	if(!isset(DbName))
		define('DbName', $DbName);
}
/*set data base info*/

include 'lib/LibDataBase.php';
include 'lib/LibBoot.php';
$boot = new LibBoot($url);