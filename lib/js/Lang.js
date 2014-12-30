function LangLoad(){
	var Lang = [{'id':'index','Lang':'首頁'}];
	for(var i = 0; i < Lang.length; i++){
		$('#'+Lang[i].id).html(Lang[i].Lang);
	}
}