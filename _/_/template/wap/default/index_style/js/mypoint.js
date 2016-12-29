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


var myFun = {
	//tab切换一个参数
	tab: function(obj) {
		var tabObj = $(obj);
		tabObj.each(function() {
			var len = tabObj.find('.hd ul li');
			var row = tabObj.find('.bd .row');
			len.bind("click", function() {
				var index = 0;
				$(this).addClass('on').siblings().removeClass('on');
				index = len.index(this);
				row.eq(index).show().siblings().hide();
				return false;
			}).eq(0).trigger("click");
		});
	},
};
