<?php
	$LangArr = array(
		/*hend*/
		array('id'=>'#Lang_index','lang'=>'首頁'),
		array('id'=>'#Lang_admin','lang'=>'管理'),
		array('id'=>'#Lang_logout','lang'=>'登出'),
		/*login page*/
		array('id'=>'#Lang_account','lang'=>'帳號:'),
		array('id'=>'#Lang_password','lang'=>'密碼:'),
		/*foot*/
		array('id'=>'#Lang_foot','lang'=>'This FramWrok by SamLaio'),
		/*index*/
		array('id'=>'#Lang_unfind','lang'=>'目前無留言'),
		array('id'=>'.Lang_add','lang'=>'新增'),
		array('id'=>'.Lang_rback','lang'=>'回覆'),
		/*reback from*/
		array('id'=>'.Lang_name','lang'=>'姓名:'),
		array('id'=>'.Lang_content','lang'=>'內容:'),
		array('id'=>'.Lang_submit','lang'=>'送出'),
		array('id'=>'.Lang_close','lang'=>'取消'),
		array('id'=>'.Lang_reloadcaptcha','lang'=>'重載Captcha')
	);
	echo 'var LangObj = '.json_encode($LangArr).";\n";

	$LangVal = array(
		'LoginError'=>'登入失敗',
		'FoldNull'=>'有欄位空白',
		'CaptchaError'=>'Captcha錯誤',
		'CaptchaNull'=>'Captcha空白'
	);
	echo "var LangVal = ".json_encode($LangVal).";\n";
?>
function LangLoad(){
	for(var i = 0; i < LangObj.length; i++){
		if($(LangObj[i].id).length > 0){
			$(LangObj[i].id).html(LangObj[i].lang);
		}
	}
}