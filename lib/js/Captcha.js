(function($){
	$.extend($.fn, {
		Captcha : function () {
			var CaptchaObj = $(this);
			$(window).ready(function(){
				CaptchaObj.html("<img id = 'captchaImg' src = '<?php echo $_SESSION['SiteUrl']?>cgi/captcha/ImgPut?"+Math.random()+"' /><input id = 'captcha' maxlength = '6' size = '6' />[<span id = 'ReLoadCapthcha' class = 'link Lang_reloadcaptcha'></span>]");
				$('#ReLoadCapthcha').on('click',function(){
					$('#captchaImg')[0].src='<?php echo $_SESSION['SiteUrl']; ?>cgi/captcha/ImgPut?'+Math.random();
					$('#captcha').val('');
				});
			});
		},
		CaptchaCheck : function () {
			var ret;
			if($('#captcha').length > 0 && $('#captcha').val() != ''){
				var toSer = {
					'url':"<?php echo $_SESSION['SiteUrl'];?>cgi/captcha/ImgCheck",
					'data':{'captcha':$('#captcha').val()}
				};
				return ($.JQPost(toSer) == 1);
			}else{
				return false;
			}
			return ret;
		}
	});
})( jQuery );