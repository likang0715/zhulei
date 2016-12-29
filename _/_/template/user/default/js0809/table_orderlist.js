var t= '';
$(function(){
	location_page (location.hash)
	$('.js-meal-nav li').click(function() {
		var myid = $(this).attr('data-id');
		if (!$(this).hasClass('active')) {
			teaAlert('loading',"更新中");
			$(this).addClass('active').siblings('li').removeClass('active');
			indexDataAjax(String(myid))
		};
	});
})
function location_page(mark) {
	var mark_arr = mark.split('#');
	if (mark_arr[1]) {
		$('.js-meal-nav li.store_'+mark_arr[1]+'').addClass('active').siblings('li').removeClass('active');
		indexDataAjax(String(mark_arr[1]))
	} else{
		var myid = $('.js-meal-nav li').first().attr('data-id');
		$('.js-meal-nav li').first().addClass('active').siblings('li').removeClass('active');
		indexDataAjax(String(myid))
	};
}
function indexDataAjax (shopid) {
	var cur_store = store_id?store_id:($('.js-meal-nav li').first().attr('data-id'))
	var shopid = shopid?shopid:cur_store;
	$.post('user.php?c=meal&a=order_ajax', {'shopid': shopid}, function(data) {
		var datas = $.parseJSON(data);
		$('.coming .num a').html(datas.today)
		$('.order .num a').html(datas.wait)
		$('.actual .num a').html(datas.waitmoney)
		$('.data_7 .num a').html(datas.sevendays)
		$('.updata-time').html('(更新时间：'+format(datas.time)+')')
		teaAlert('complete',"更新成功");
	});
}
// day  获取day天后的日期
function getDateStr(day) {
	var day = Number(day);
	var dd = new Date(); 
	dd.setDate(dd.getDate()+day);
	var y = dd.getFullYear(); 
	var m = dd.getMonth()+1;
	var d = dd.getDate(); 
	var newtime = new Date(y+"/"+m+"/"+d+" 23:59:59").getTime();
	return cutTime(newtime);
} 

// time  13位 时间戳
function cutTime (time) {
	var time = time.toString();
	if (time.length==13) {
		time = Number(time.substring(0,10));
		return time;
	};
}