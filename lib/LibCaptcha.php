<?php
	class LibCaptcha{
		function __construct() {
			if(!isset($_SESSION['CaptchaArr'])){
				$_SESSION['CaptchaArr'] = $this->SetArr();
			}
		}
		public function num2adb($num){
			$text="";
			for($i=0;$i<strlen($num);$i++){
				$shift = substr($num, $i, 1)+substr($num, $i - strlen($num), 2);
				$text .= $_SESSION['CaptchaArr'][$shift];
			}
			return $text;
		}
		public function CreateImg($authText){
			/*產生圖檔, 及定義顏色*/
			$img_x = 120;
			$img_y = 30;
			$im = imageCreate($img_x, $img_y);
			/*ImageColorAllocate 分配圖形的顏色*/
			$back = ImageColorAllocate($im, rand(200,255), rand(200,255), rand(200,255));

			// $authText=$this->num2adb($num);
			imageFill($im, 0, 0, $back);
			/*imageString($im, 5, rand(0,55), rand(0,40), $authText, $font);//把字放上圖片*/
			$str_x = 0;
			$str_y = 0;
			for($i = 0; $i < strlen($authText); $i++){
				$str_x += rand(10,20);
				$str_y = rand(0,$img_y/2);
				$font = ImageColorAllocate($im, rand(0,100), rand(0,100), rand(0,100));
				imageString($im, 5, $str_x, $str_y, $authText[$i], $font);
			}

			/*插入圖形干擾點共 50~200 點*/
			for($i = 0; $i < rand(50,200); $i++) {
				$point = ImageColorAllocate($im, rand(0,255), rand(0,255), rand(0,255));
				imagesetpixel($im, rand(0,$img_x)  , rand(0,$img_y) , $point);
			}
			/*插入圖形干擾線共2~5條*/
			for($i = 1; $i<=rand(2,5); $i++){
				$point = ImageColorAllocate($im, rand(0,255), rand(0,255), rand(0,255));
				imageline($im, rand(0,$img_x), rand(0,$img_y), rand(0,$img_x), rand(0,$img_y) ,$point);
			}
			header("Content-type: image/PNG");
			ImagePNG($im);
			ImageDestroy($im);
		}
		public function CheckImg($source,$input_code){
			// echo $this->num2adb($source).'=='.$input_code;
			return ($this->num2adb($source)==$input_code);
		}
		private function SetArr(){
			$tmp = array();
			for($i = 1; $i<199; $i++){
				$val = (rand(0,1) == 0)? rand(48,56):rand(65,90);
				$tmp[$i] = chr($val);
			}
			return $tmp;
		}
	}