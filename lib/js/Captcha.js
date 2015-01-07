(function($){
    $.extend($.fn, {
        Captcha : function () {
			var CaptchaObj = $(this);
			$(window).ready(function(){
				CaptchaObj.html("<img id = 'captchaImg' src = '<?php echo $_SESSION['SiteUrl']?>cgi/captcha/ImgPut?"+Math.random()+"' /><input id = 'captcha' maxlength = '6' size = '6' />[<span id = 'ReLoadCapthcha' class = 'link'>ReLoadCapthcha</span>]");
				$('#ReLoadCapthcha').on('click',function(){
					$('#captchaImg')[0].src='<?php echo $_SESSION['SiteUrl']; ?>cgi/captcha/ImgPut?'+Math.random();
					$('#captcha').val('');
				});
			});
		},
		CaptchaCheck : function () {
			var ret;
			if($('#captcha').length > 0 && $('#captcha').val() != ''){
				var tmp = false;
				$.ajax({
					type:"post",
					url:"<?php echo $_SESSION['SiteUrl'];?>cgi/captcha/ImgCheck",
					data:{'captcha':$('#captcha').val()},
					async:false,
					success:function(msg){
						if(msg == '1'){
							tmp = true;
						}
					}
				});
				return tmp;
			}else{
				return false;
			}
			return ret;
		}
    });
})( jQuery );
