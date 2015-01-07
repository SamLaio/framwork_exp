<?php
class LibCaptchaMove {
	private $QArr;

	function __construct(){
		$this->QArr = array(
			array('0+0','0'),
			array('1+1','2'),
			array('2+2','4'),
			array('3+3','6'),
			array('4+4','8'),
			array('5+5','10'),
			array('6+6','12'),
			array('7+7','14'),
			array('8+8','16'),
			array('9+9','18'),
			array('10+10','20'),

			array('0x0','0'),
			array('1x1','1'),
			array('2x2','4'),
			array('3x3','9'),
			array('4x4','16'),
			array('5x5','25'),
			array('6x6','36'),
			array('7x7','49'),
			array('8x8','64'),
			array('9x9','81'),
			array('10x10','100'),
		);
	}

	public function SetCaptcha(){
		$this->CreateImg($this->QArr[array_rand($this->QArr)]);
	}
	public function CreateImg($num){
		/*產生圖檔, 及定義顏色*/
		$img_x = 100;
		$img_y = 30;
		$im = imageCreate($img_x, $img_y);
		/*ImageColorAllocate 分配圖形的顏色*/
		$back = ImageColorAllocate($im, rand(200,255), rand(200,255), rand(200,255));

		$authText=$num[0];
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
		for($i = 1; $i<=rand(2,3); $i++){
			$point = ImageColorAllocate($im, rand(0,255), rand(0,255), rand(0,255));
			imageline($im, rand(0,$img_x), rand(0,$img_y), rand(0,$img_x), rand(0,$img_y) ,$point);
		}
		header("Content-type: image/PNG");
		ImagePNG($im);
		ImageDestroy($im);
	}
}
?>