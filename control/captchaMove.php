<?php
class captchaMove {
	public function test(){
		include 'lib/LibCaptchaMove.php';
		$obj = new LibCaptchaMove;
		$obj->SetCaptcha();
	}
}
