var now_page = 1;
var is_ajax = false;
var max_page;

$(function(){
	FastClick.attach(document.body);

	$(window).scroll(function(){
		if(now_page > 1 && $(window).scrollTop() / ($('body').height() - $(window).height()) >= 0.95){
			if(is_ajax == true){
				if(typeof(max_page) != 'undefined'){
					if(now_page <= max_page) {
						if($('.wx_loading2').is(":hidden")) {
							getPoints();
						}
					}
				}
			}
		}
	});

	getPoints();

	function getPoints(){
		$('.wx_loading2').show();
		var param = 'page=' + now_page;
		if (type != undefined) {
			param += '&type=' + type;
		}
		if (target != undefined) {
			param += '&target=' + target;
		}
		$.ajax({
			type: "POST",
			url: page_url,
			data: param,
			dataType:'json',
			success:function(result){

				if(result.err_code){
					motify.log(result.err_msg);
				}else{
					if(result.err_msg.list.length > 0) {

						var str = '';
						for(var i in result.err_msg.list){

							var point_log = result.err_msg.list[i];
							str += '<li>';
							str += '	<div class="rightInfo">';
							str += '		<span>' + point_log.bak + '</span>';
							if(point_log.point) {
								if(parseFloat(point_log.point) > 0) {
									str	+= '<p style="color: green">+' + point_log.point + point_alias + '</p>';
								} else {
									str	+= '<p style="color: red">-' + Math.abs(parseFloat(point_log.point)).toFixed(2) + point_alias +' </p>';
								}
							} else {
								str += '	<p></p>';
							}

							if(point_log.status == 2){
								str += '<p>状态：已处理</p>';
							}else if(point_log.status == 1){
								str += '<p>状态：未处理</p>';
							}else{
								str += '<p>状态：未支付</p>';
							}
							
							if (type == 2) {
								str += '	<p>服务费：' + point_log.service_fee_rate + '%</p>';
							}
							str	+= '	</div>';
							str	+= '	<div class="leftInfo">';
							str += '		<p>编号：' + point_log.pigcms_id + '</p>';
							str += '		<p>流水：' + point_log.order_no + '</p>';
							str	+= '		<p>时间：' + point_log.add_time + '</p>';
							str += '	</div>';
							str += '</li>';
						}
						
						$(".secttion2").find("ul").append(str);
					
						if(typeof(result.err_msg.noNextPage) == 'undefined'){
							is_ajax = false;
						}else if(result.err_msg.noNextPage) {
							is_ajax = true;
						}
						max_page = result.err_msg.max_page;
					}else{
						$('.empty-list').show();
					}
					now_page ++;
				}

				$('.wx_loading2').hide();
			},
			error:function(){
				$('.wx_loading2').hide();
				motify.log(label + point_alias + '流水读取失败，<br/>请刷新页面重试',0);
			}
		});
	}
});