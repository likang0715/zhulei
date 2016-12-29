$(function() {
	liveAjax ();
	setInterval(function () {
		liveAjax ()
	}, 60000);
});

function liveAjax () {
	var ajaxUrl = "user.php?c=order&a=allorder_ajax";
	var seatUrl = "user.php?c=meal&a=order#list/";
	var shop_Id = shop_Id?shop_Id:""
	$.post(ajaxUrl, {shopid: shop_Id}, function(data) {
		var datas = $.parseJSON(data);
		if (datas.err_code==0) {
			var num_send = String(datas.send);
			var num_refund = String(datas.refund);
			var num_seat = String(datas.seat);
			var num_meeting = String(datas.meeting);
			var physical_id = String(datas.physical_id);
			var physical_name = String(datas.physical_name);
			var new_time = String(datas.time);
			var num_all = Number(datas.send)+Number(datas.refund)+Number(datas.seat)+Number(datas.meeting);
			$('.js-live-send').html(num_send);
			$('.js-live-refund').html(num_refund);
			$('.js-live-seat').html(num_seat);
			$('.js-live-meeting').html(num_meeting);
			$('.js-live-time').html(format(new_time));
			$('.js-store-name').html(physical_name);
			$('.js-store-name').attr('data-id', physical_id);
			$('.js-seat').attr('href', seatUrl+physical_id+'&status=1');
			$('.js-live-all').html(String(num_all));
			if (String(num_all)==0) {
				$('#js-system-num').html('').hide();
			} else{
				$('#js-system-num').html(String(num_all)).show();
			};
		} else{
			teaAlert('登录超时')
		};
	});
}
