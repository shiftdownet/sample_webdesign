function CookieLoad(arg){
	var0 = $.cookie(arg);
	if(var0 == null){
		return 0;
	}
	return var0;
};