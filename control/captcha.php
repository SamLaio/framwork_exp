<?php
class captcha {
	private $LibCaptcha;
	function __construct() {
		include 'lib/LibCaptcha.php';
		$this->LibCaptcha = new LibCaptcha;
	}
	public function ImgPut(){
		unset($_SESSION['CatptchaError']);
		$_SESSION['CaptchaPw'] = rand(50,500000);
		$this->LibCaptcha->CreateImg($this->LibCaptcha->num2adb($_SESSION['CaptchaPw']));
	}
	public function ImgCheck($key){
		if(isset($_SESSION['CatptchaError'])){
			if($_SESSION['CatptchaError'] >= 3){
				echo 0;
				exit;
			}
		}
		$key = $key['post']['captcha'];
		if(isset($_SESSION['CaptchaPw'])){
			// echo $_SESSION['CaptchaPw'].'---'.strtoupper($key);
			if($this->LibCaptcha->CheckImg($_SESSION['CaptchaPw'],strtoupper($key))){
				echo 1;
			}else{
				echo 0;
				if(isset($_SESSION['CatptchaError'])){
					$_SESSION['CatptchaError']++;
				}else{
					$_SESSION['CatptchaError'] = 1;
				}
			}
		}else
			echo 0;
	}
}
?>