<?php
if(!isset($_SESSION))
	session_start();
echo $_SERVER['PHP_SELF'];
$UrlBase = explode('load.php',$_SERVER['PHP_SELF']);
if(!isset($_SESSION['SiteUrl'])){
	$port = ($_SERVER['SERVER_PORT'] == 80)?'http://':'https://';
	$_SESSION['SiteUrl'] = $port . $_SERVER['HTTP_HOST'] . $UrlBase[0];
}
$url = explode('/',$UrlBase[1]);

include 'lib/LibBoot.php';
$boot = new LibBoot($url);
?>