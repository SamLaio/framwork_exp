jQuery.fn.extend({
    Captcha : function () {
		var CaptchaObj = $(this);
		$(window).ready(function(){
			CaptchaObj.html("<img id = 'captchaImg' src = '<?php echo $_SESSION['SiteUrl']?>cgi/captcha/ImgPut?"+Math.random()+"' /><input id = 'captcha' maxlength = '6' size = '6' />[<span id = 'ReLoadCapthcha' class = 'link'>ReLoadCapthcha</span>]");
			$('#ReLoadCapthcha').on('click',function(){
				document.getElementById('captchaImg').setAttribute('src','<?php echo $_SESSION['SiteUrl']; ?>cgi/captcha/ImgPut?'+Math.random());document.getElementById('captchaImg').value='';
				$('#captcha').val('');
			});
		});

	}
});
jQuery.fn.extend({
	CaptchaCheck : function () {
		var ret;
		if($('#captcha').length > 0 && $('#captcha').val() != ''){
			ret = $.post('<?php echo $_SESSION['SiteUrl'];?>cgi/captcha/ImgCheck',
				{'captcha':$('#captcha').val()},
				function ( r ){
					if(r == 1){
						return true;
					}else{
						return false;
					}
			});
		}else{
			ret = false;
		}
		return ret;
	}
});