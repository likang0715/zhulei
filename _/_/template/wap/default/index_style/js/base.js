var motify = {
	timer:null,
	log:function(msg,time){
		$('.motify').hide();
		if(motify.timer) clearTimeout(motify.timer);
		if($('.motify').size() > 0){
			$('.motify').show().find('.motify-inner').html(msg);
		}else{
			$('body').append('<div class="motify" style="display:block;"><div class="motify-inner">'+msg+'</div></div>');
		}
		if(!time && time != 0) time=3000;
		if(time > 0){
			motify.timer = setTimeout(function(){
				$('.motify').hide();
			},3000);
		}
	},
	checkMobile:function(){
		if(/(iphone|ipad|ipod|android|windows phone)/.test(navigator.userAgent.toLowerCase())){
			return true;
		}else{
			return false;
		}
	}
};


var obj2String = function(_obj) {
	var t = typeof(_obj);
	if (t != 'object' || _obj === null) {
		// simple data type
		if (t == 'string') {
			_obj = '"' + _obj + '"';
		}
		return String(_obj);
	} else {
		if (_obj instanceof Date) {
			return _obj.toLocaleString();
		}
		// recurse array or object
		var n, v, json = [],
			arr = (_obj && _obj.constructor == Array);
		for (n in _obj) {
			v = _obj[n];
			t = typeof(v);
			if (t == 'string') {
				v = '"' + v + '"';
			} else if (t == "object" && v !== null) {
				v = this.obj2String(v);
			}
			json.push((arr ? '': '"' + n + '":') + String(v));
		}
		return (arr ? '[': '{') + String(json) + (arr ? ']': '}');
	}
};