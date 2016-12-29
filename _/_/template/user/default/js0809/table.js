function loadChart (data_7,data_7_order,data_7_shop) {
	require.config({
		paths: {
			echarts: './static/js/echart'
		}
	});
	require(
		[
		'echarts',
		'echarts/chart/line',
		],
		function (ec) {
			var myChart = ec.init(document.getElementById('chart-body'));
			myChart.setOption({
				title: {
					text: '近7日订座到店情况'
				},
				tooltip : {
					trigger: 'axis',
					backgroundColor : 'white',
					borderColor : 'black',
					borderWidth : 2,
					borderRadius : 5,
					textStyle : {color : 'black'},
					axisPointer : {
						type: 'line',
						lineStyle: {
							color: '#8FD1FA',
							width: 1,
							type: 'dotted'
						}
					}
				},
				legend: {
					data:['成功预订订单','实际到店订单']
				},
				grid: {
					x: 80,
					y: 60,
					x2: 80,
					y2: 60,
					width : '700px',
					backgroundColor: 'rgba(0,0,0,0)',
					borderWidth: 0,
					borderColor: '#ccc'
				},
				calculable : true,
				xAxis : [
				{
					type : 'category',
					boundaryGap : false,
					axisLine : {show : false},
					axisTick : {show : false},
					splitLine : {show : false},
					data : data_7
				}
				],
				yAxis : [
				{
					type : 'value',
					axisLine : {show : false},
					splitArea : {show : false},
					splitLine : {
						show : true,
						lineStyle : {
							color: ['#ccc'],
							width: 1,
							type: 'dotted'
						}
					}
				}
				],
				series : [
				{
					name:'成功预订订单',
					type:'line',
					smooth:true,
					data:data_7_order
				},
				{
					name:'实际到店订单',
					type:'line',
					smooth:true,
					data:data_7_shop
				}
				]
			});
}
);
}
var t= '';
$(function(){
	location_page (location.hash)
	teaAlert("更新中",'loading');
	$('.js-help-notes').hover(function(){
		$('.popover-help-notes').remove();
		var html = '<div class="js-intro-popover popover popover-help-notes bottom" style="display: none; top: ' + ($(this).offset().top + 12) + 'px; left: ' + ($(this).offset().left - 60) + 'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content"><p><p><strong>即将到店：</strong>预约24小时以内到店的订单数量。</p><p><strong>待确认预订：</strong>需要确认是否订座成功的订单数量。</p><p><strong>待确认到店：</strong>需要确认是否到店的订单数量。</p><p><strong>近7日到店：</strong>近7日到店消费的订单数量。</p></div></div></div>';
		$('body').append(html);
		$('.popover-help-notes').show();
	}, function(){
		t = setTimeout('hide()', 200);
	})

	$('.popover-help-notes').live('mouseleave', function(){
		clearTimeout(t);
		hide();
	})

	$('.popover-help-notes').live('mouseover', function(){
		clearTimeout(t);
	})
	$('.js-meal-nav li').click(function() {
		var myid = $(this).attr('data-id');
		if (!$(this).hasClass('active')) {
			teaAlert("更新中",'loading');
			$(this).addClass('active').siblings('li').removeClass('active');
			indexDataAjax(String(myid))
			indexChartAjax(String(myid))
		};
	});

})
function hide() {
	$('.popover-help-notes').remove();
}
function location_page(mark) {
	var mark_arr = mark.split('#');
	if (mark_arr[1]) {
		$('.js-meal-nav li.store_'+mark_arr[1]+'').addClass('active').siblings('li').removeClass('active');
		indexDataAjax(String(mark_arr[1]))
		indexChartAjax(String(mark_arr[1]))
	} else{
		var myid = $('.js-meal-nav li').first().attr('data-id');
		$('.js-meal-nav li').first().addClass('active').siblings('li').removeClass('active');
		indexDataAjax(String(myid))
		indexChartAjax(String(myid))
	};
}
function indexDataAjax (shopid) {
	var cur_store = store_id?store_id:($('.js-meal-nav li').first().attr('data-id'))
	var shopid = shopid?shopid:cur_store;
	$.post('user.php?c=meal&a=order_ajax', {'shopid': shopid}, function(data) {
		var datas = $.parseJSON(data);
		if (datas.err_code==0) {
			$('.coming .num a').html(datas.today)
			$('.order .num a').html(datas.wait)
			$('.actual .num a').html(datas.waitmoney)
			$('.data_7 .num a').html(datas.sevendays)
			$('.updata-time').html('(更新时间：'+format(datas.time)+')')
		} else{
			window.location.reload();
		};
	});
}
function indexChartAjax (shopid) {
	var cur_store = store_id?store_id:($('.js-meal-nav li').first().attr('data-id'))
	var shopid = shopid?shopid:cur_store;
	$.post('user.php?c=meal&a=sevenorder_ajax', {'shopid': shopid}, function(data) {
		var datas = $.parseJSON(data);
		if (datas.err_code==0) {
			loadChart (datas.err_msg.day,datas.err_msg.waitmoney,datas.err_msg.sucess)
			teaAlert("更新成功",'complete');
		} else{
			window.location.reload();
		};
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