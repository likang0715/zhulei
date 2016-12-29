/**
 * Created by ediancha on 2016/8/17.
 */
var orderParams = {};
function location_page(mark,dom) {
	try{
		var mark_arr = mark.split('/');
		try{
			var id_arr = mark_arr[1].split('&');
			var id_shop = id_arr[0];
		}catch(err){
			var id_arr;
			var id_shop = mark_arr[1];
		}
	}catch(err){
		var mark_arr = [mark];
	}
	switch (mark_arr[0]) {
		case '#list':
			var id_shop = id_shop?id_shop:$('.js-shop-order li').eq(0).attr('data-id');
			$('.js-shop-order li[data-id="'+id_shop+'"]').addClass('active').siblings('li').removeClass('active');
			orderSearch(id_shop,getUrlParam('search_type'),getUrlParam('keywords'),getUrlParam('stime'),getUrlParam('etime'),getUrlParam('source'),getUrlParam('status'),getUrlParam('pages'))
			break;
		default:
			// var id_shop = id_shop?id_shop:$('.js-shop-order li').eq(0).attr('data-id');
			// $('.js-shop-order li[data-id="'+id_shop+'"]').addClass('active').siblings('li').removeClass('active');
			// orderSearch(id_shop,getUrlParam('search_type'),getUrlParam('keywords'),getUrlParam('stime'),getUrlParam('etime'),getUrlParam('source'),getUrlParam('status'),getUrlParam('pages'))
			break;
	}
}
/** 搜索订单
 *@search_type  搜索类型   1=>姓名,2=>电话
 *@keywords     搜索关键词 string
 *@stime        开始时间   stime 10位时间戳
 *@etime        结束时间   etime 10位时间戳
 *@source       预约渠道   0 全部  1 微信  2 电话 
 *@status       预约状态   0=>全部,1=>待审核,2=>待消费,3=>已完成,4=>已取消
 */
function orderSearch (shopid,search_type,keywords,stime,etime,source,status,pages) {
	var params = {};
	params['search_type'] = search_type?search_type:1;
	params['keywords'] = keywords?keywords:'';
	params['stime'] = stime?stime:'';
	params['etime'] = etime?etime:'';
	params['source'] = source?source:'0';
	params['status'] = status?status:'0';
	params['pages'] = pages?pages:'1';
	orderParams = params;
	$('.js-order-status li').eq(Number(params['status'])).addClass('active').siblings('li').removeClass('active');
	replaceParamVal(params);
	params['page'] = 'order_list_content';
	params['shopid'] = shopid?shopid:$('.js-shop-order li').eq(0).attr('data-id');
	$('.js-order-add').attr('href', order_add_url+'&physical_id='+params['shopid']);
	load_page('.js-search-result', load_url, params, '', function() {
		$('[name="search_type"]').val(params['search_type']);
		$('[name="keywords"]').val(params['keywords']);
		var stime = params['stime']?format(params['stime']):'';
		var etime = params['etime']?format(params['etime']):'';
		$('[name="stime"]').val(stime);
		$('[name="etime"]').val(etime);
		$('[name="source"]').val(params['source']);
		$('[name="status"]').val(params['status']);
	});
}
$(document).ready(function() {
	location_page(location.hash);
	$('.js-filter').live('click', function(event) {
		var form = $('.js-search-form').serializeArray();
		var formObj = {};
		$.each(form, function(i, field) {
			formObj[field.name] = field.value;
		});
		formObj['stime'] = returnformat(formObj['stime']);
		formObj['etime'] = returnformat(formObj['etime']);
		replaceParamVal(formObj,true);
	});
	$('.js-order-status a').live('click', function(event) {
		var status = $(this).attr('data-status');
		var formObj = {'status':status};
		replaceParamVal(formObj,true);
	});
	// 分页
	$('.js-present_list_page a').live('click', function(event) {
		var pages = $(this).attr('data-page-num');
		var formObj = {'pages':pages};
		replaceParamVal(formObj,true);
	});
	//开始时间
	$('#js-start-time').live('focus', function() {
		var options = {
			numberOfMonths: 1,
			dateFormat: "yy-mm-dd",
			timeFormat: "HH:mm:ss",
			showSecond: true,
			beforeShow: function() {
				if ($('#js-end-time').val() != '') {
					$(this).datepicker('option', 'maxDate', new Date($('#js-end-time').val()));
				}
			},
			onSelect: function() {
				if ($('#js-start-time').val() != '') {
					$('#js-end-time').datepicker('option', 'minDate', new Date($('#js-start-time').val()));
				}
				// $.datepicker._hideDatepicker();
			},
			onClose: function() {
				var flag = options._afterClose($(this).datepicker('getDate'), $('#js-end-time').datepicker('getDate'));
				if (!flag) {
					$(this).datepicker('setDate', $('#js-end-time').datepicker('getDate'));
				}
			},
			_afterClose: function(date1, date2) {
				var starttime = 0;
				if (date1 != '' && date1 != undefined) {
					starttime = new Date(date1).getTime();
				}
				var endtime = 0;
				if (date2 != '' && date2 != undefined) {
					endtime = new Date(date2).getTime();
				}
				if (endtime > 0 && endtime < starttime) {
					alert('无效的时间段');
					return false;
				}
				return true;
			}
		};
		$('#js-start-time').datetimepicker(options);
	})

	//结束时间
	$('#js-end-time').live('focus', function(){
		var options = {
			numberOfMonths: 1,
			dateFormat: "yy-mm-dd",
			timeFormat: "HH:mm:ss",
			showSecond: true,
			beforeShow: function() {
				if ($('#js-start-time').val() != '') {
					$(this).datepicker('option', 'minDate', new Date($('#js-start-time').val()));
				}
			},
			onSelect: function() {
				if ($('#js-end-time').val() != '') {
					$('#js-start-time').datepicker('option', 'maxDate', new Date($('#js-end-time').val()));
				}
				// $.datepicker._hideDatepicker();
			},
			onClose: function() {
				var flag = options._afterClose($('#js-start-time').datepicker('getDate'), $(this).datepicker('getDate'));
				if (!flag) {
					$(this).datepicker('setDate', $('#js-start-time').datepicker('getDate'));
				}
			},
			_afterClose: function(date1, date2) {
				var starttime = 0;
				if (date1 != '' && date1 != undefined) {
					starttime = new Date(date1).getTime();
				}
				var endtime = 0;
				if (date2 != '' && date2 != undefined) {
					endtime = new Date(date2).getTime();
				}
				if (starttime > 0 && endtime < starttime) {
					alert('无效的时间段');
					return false;
				}
				return true;
			}
		};
		$('#js-end-time').datetimepicker(options);
	})
	//最近N天
	$('.date-quick-pick').live('click', function(){
		$(this).siblings('.date-quick-pick').removeClass('current');
		$(this).addClass('current');
		var tmp_days = $(this).attr('data-days');
		$('.js-start-time').val(changeDate(tmp_days).begin);
		$('.js-end-time').val(changeDate(tmp_days).end);
	})
});
