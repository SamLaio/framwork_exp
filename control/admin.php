<?php
class admin {
	private $db;
	function __construct(){
		include 'model/admin.php';
		$this->db = new ModelAdmin;
	}

	public function index(){
		$this->UrlReLoad();
	}
	public function Login($arr = false){
		if(isset($_SESSION['Admin'])){
			header('Location:'.$_SESSION['SiteUrl'].'admin');
		}
		if(isset($arr['post'])){
			$re = $this->db->UserCheck($arr['post']);
			if(isset($re['seq'])){
				$_SESSION['Admin']['seq'] = $re['seq'];
				$_SESSION['Admin']['account'] = $re['account'];
				$_SESSION['Admin']['name'] = $re['name'];
				echo 1;
			}else{
				echo -1;
			}
		}
	}

	public function LogOut(){
		unset($_SESSION['Admin']);
		header('Location:'.$_SESSION['SiteUrl']);
	}
	private function UrlReLoad(){
		if(!isset($_SESSION['Admin'])){
			header('Location:'.$_SESSION['SiteUrl'].'admin/Login');
		}
	}
}