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