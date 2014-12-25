<?php
if(!isset($_SESSION))
	session_start();
$UrlBase = explode('load.php',$_SERVER['PHP_SELF']);
if(!isset($_SESSION['SiteUrl'])){
	$port = ($_SERVER['SERVER_PORT'] == 80)?'http://':'https://';
	$_SESSION['SiteUrl'] = $port . $_SERVER['HTTP_HOST'] . $UrlBase[0];
}
$url = explode('/',$UrlBase[1]);

/*set data base info*/
$DbHost = '127.0.0.1';
$DbUser = 'root';
$DbPw = '';
$DbName = 'framwork_exp';

define('DbHost', $DbHost);
define('DbUser', $DbUser);
define('DbPw', $DbPw);
define('DbName', $DbName);
/*set data base info*/

include 'lib/LibBoot.php';
$boot = new LibBoot($url);