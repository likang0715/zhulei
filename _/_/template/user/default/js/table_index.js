/**
 * Created by ediancha on 2016/8/9.
 */
function location_page(mark) {
	try{
		var mark_arr = mark.split('/');
		var id_arr = mark_arr[1];
	}catch(err){
		var mark_arr = [mark];
	}
	switch (mark_arr[0]) {
		case '#index':
			var id_arr = id_arr?id_arr:$('.js-meal-nav li').eq(0).attr('data-id');
			$('.js-meal-nav li[data-id="'+id_arr+'"]').addClass('active').siblings('li').removeClass('active');
			if (!id_arr) {
				teaAlert('请先添加线下门店','complete',function () {
					window.location.href = "<?php echo dourl('setting:store'); ?>#physical_store"
				})
			return false;
			};
			window.location.hash = mark_arr[0] + '/' + id_arr;
			load_page('.app__content', load_url, {
				page: 'dashboard_content',
				shopid: id_arr
			}, '', function() {});
			break;
		default:
			var id_arr = id_arr?id_arr:$('.js-meal-nav li').eq(0).attr('data-id');
			$('.js-meal-nav li[data-id="'+id_arr+'"]').addClass('active').siblings('li').removeClass('active');
			if (!id_arr) {
				teaAlert('请先添加线下门店','complete',function () {
					window.location.href = "<?php echo dourl('setting:store'); ?>#physical_store"
				})
			return false;
			};
			window.location.hash = '#index/' + id_arr;
			load_page('.app__content', load_url, {
				page: 'dashboard_content',
				shopid: id_arr
			}, '', function() {});
			break;
	}
}

var t= '';
$(function(){
	location_page (location.hash);
	$('.js-help-notes').live('mousemove', function(event) {
		$('.popover-help-notes').remove();
		var html = $('<div class="js-intro-popover popover popover-help-notes left" style="display: none; top:0px; left: 0px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content"><p><p><strong>即将到店：</strong>预约24小时以内即将到店的订单数量。</p><p><strong>待确认预订：</strong>需要确认是否订座成功的订单数量。</p><p><strong>待确认到店：</strong>需要确认是否到店的订单数量。</p><p><strong>近7日到店：</strong>近7日到店消费的订单数量。</p></div></div></div>');
		$('body').append(html);
		var dom = $('.popover-help-notes');
		if ($(this).offset().left+dom.width()+20>$(window).width()) {
			dom.css({
				'top': $(this).offset().top-(dom.height()/2)+3,
				'left': $(this).offset().left-dom.width()-10
			}).show();
		} else{
			dom.css({
				'top': $(this).offset().top+12,
				'left': $(this).offset().left-dom.width()/2+3
			}).addClass('bottom').removeClass('left').show();
		};
	});
	$('.js-help-notes').live('mouseout', function(event) {
		event.preventDefault();
		t = setTimeout('hide()', 200);
	});

	$('.popover-help-notes').live('mouseleave', function(){
		clearTimeout(t);
		hide();
	})

	$('.popover-help-notes').live('mouseover', function(){
		clearTimeout(t);
	})

})
function hide() {
	$('.popover-help-notes').remove();
}
// function indexDataAjax (shopid) {
// 	var cur_store = store_id?store_id:($('.js-meal-nav li').first().attr('data-id'))
// 	var shopid = shopid?shopid:cur_store;
// 	$.post('user.php?c=meal&a=order_ajax', {'shopid': shopid}, function(data) {
// 		var datas = $.parseJSON(data);
// 		if (datas.err_code==0) {
// 			$('.coming .num a').html(datas.today);
// 			$('.order .num a').html(datas.wait);
// 			$('.actual .num a').html(datas.waitmoney);
// 			$('.data_7 .num a').html(datas.sevendays);
// 			$('.updata-time').html('(更新时间：'+format(datas.time)+')');
// 		} else{
// 			window.location.reload();
// 		};
// 	});
// }
// function indexChartAjax (shopid) {
// 	var cur_store = store_id?store_id:($('.js-meal-nav li').first().attr('data-id'))
// 	var shopid = shopid?shopid:cur_store;
// 	$.post('user.php?c=meal&a=sevenorder_ajax', {'shopid': shopid}, function(data) {
// 		var datas = $.parseJSON(data);
// 		if (datas.err_code==0) {
// 			loadChart (datas.err_msg.day,datas.err_msg.waitmoney,datas.err_msg.sucess)
// 			teaAlert("更新成功",'complete');
// 		} else{
// 			window.location.reload();
// 		};
// 	});
// }
