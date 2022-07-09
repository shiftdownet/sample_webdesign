var qsParm = new Array();

function retrieveGETqs() {
	var query = window.location.search.substring(1);
	var parms = query.split('&');
	for (var i=0; i<parms.length; i++) {
		var pos = parms[i].indexOf('=');
		if (pos > 0) {
			var key = parms[i].substring(0,pos);
			var val = parms[i].substring(pos+1);
			qsParm[key] = val;
		}
	}
	if(qsParm['style'] == undefined){
		qsParm['style'] = 1;
	}
	if(qsParm['style'] != -1){
		document.write("<link rel=\"stylesheet\" href=\"./css/style"+qsParm['style']+".css\" type=\"text/css\" >");
		document.write("<link rel=\"stylesheet\" href=\"./css/base_layout"+qsParm['style']+".css\" type=\"text/css\" >");
	}
}

