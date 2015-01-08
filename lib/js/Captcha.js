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
$.JQPost = function (settings){
	var Setting = {'url':'','type':'POST','dataType':'text','async':false,'data':{}};
	var ret = false;
	if ( settings ){$.extend(Setting, settings);}
	if(Setting.url != ''){
		$.ajax({
			type:Setting.type,
			url:Setting.url,
			data:Setting.data,
			async:Setting.async,
			dataType:Setting.dataType,
			success:function(msg){
				ret = msg;
			},
			error:function(){
				ret = false;
			}
		});
	}
	return ret;
}