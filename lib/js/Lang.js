<?php
	$LangArr = array(
		array('id'=>'#Lang_index','lang'=>'首頁'),
		array('id'=>'#Lang_admin','lang'=>'管理'),
		array('id'=>'#Lang_logout','lang'=>'登出'),

		array('id'=>'#Lang_foot','lang'=>'This FramWrok by SamLaio'),

		array('id'=>'#Lang_unfind','lang'=>'目前無留言'),

		array('id'=>'.Lang_add','lang'=>'新增'),
		array('id'=>'.Lang_rback','lang'=>'回覆'),

		array('id'=>'.Lang_name','lang'=>'姓名:'),
		array('id'=>'.Lang_content','lang'=>'內容:'),
		array('id'=>'.Lang_submit','lang'=>'送出'),
		array('id'=>'.Lang_close','lang'=>'取消'),
		array('id'=>'.Lang_reloadcaptcha','lang'=>'重載Captcha')
	);
	echo 'var LangObj = '.json_encode($LangArr).';';
?>
function LangLoad(){
	for(var i = 0; i < LangObj.length; i++){
		if($(LangObj[i].id).length > 0){
			$(LangObj[i].id).html(LangObj[i].lang);
		}
	}
}