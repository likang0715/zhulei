/**
 * Created by pigcms_21 on 2015/2/5.
 */
var t = '';
$(function() {

    var tmp_status = '*';

    if (getQueryString('start_time')) {
        time_type = 'add_time';
        start_time = getQueryString('start_time').replace('+', ' ');
    }

    if (getQueryString('stop_time')) {
        time_type = 'add_time';
        stop_time = getQueryString('stop_time').replace('+', ' ');
    }

    if (getQueryString('status')) {
        tmp_status = getQueryString('status');
    }

    load_page('.app__content', load_url, {page: page_content, 'status': tmp_status, 'start_time': start_time, 'stop_time': stop_time, 'time_type': time_type}, '', function(){
        if (start_time) {
            $('#js-start-time').val(start_time);
        }
        if (stop_time) {
            $('#js-end-time').val(stop_time);
        }
        //状态
        if (tmp_status) {
            $("select[name='status']").find("option[value='" + tmp_status + "']").attr('selected', true);
            $('.ui-nav > ul > li').removeClass('active');
            if (tmp_status != '*') {
                $(".status-" + tmp_status).closest('li').addClass('active');
                return false;
            } else {
                $(".all").closest('li').addClass('active');
                return false;
            }
        }
        $('.all').parent('li').addClass('active').siblings('li').removeClass('active');
    });
	
	
	$('#order_download').live('click',function(){
		order_no = $("input[name='order_no']").val();
		trade_no = $("input[name='trade_no']").val();
		user = $("input[name='user']").val();
		tel = $("input[name='tel']").val();
		time_type = $("select[name='time_type']").val();
		start_time = $("input[name='start_time']").val();
		stop_time = $("input[name='end_time']").val();
		type = $("select[name='type']").val();
		status = $("select[name='status']").val();
		payment_method = $("select[name='payment_method']").val();
		shipping_method = $("select[name='shipping_method']").val();
		
		var url=order_download_url+'&order_no='+order_no+'&trade_no='+trade_no+'&user='+user+'&tel='+tel+'&time_type='+time_type+'&start_time='+start_time+'&stop_time='+stop_time+'&type='+type+'&status='+status+'&payment_method='+payment_method+'&shipping_method='+shipping_method;
				location.href=url;
	});
})
