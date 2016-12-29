var orderPage = 1;
var orderIsAjax = false;
var orderSort = 'default';
var orderShowRows = false;
var max_page;
var points_type_index = 0;

$(function(){
	if($('li.block-order').size() == 0){
		//$('.empty-list').show();
	}
	$('.js-cancel-order').click(function(){
		var nowDom = $(this);
		$.post('./order.php?del_id='+$(this).data('id'),function(result){
			motify.log(result.err_msg);
			if(result.err_code == 0){
				nowDom.closest('li').remove();
				if($('li.block-order').size() == 0){
					$('.empty-list').show();
				}
			}
		});
	});
	
	$(".js-delivery").click(function () {
		var delivery_obj = $(this);
		if (delivery_obj.attr("disabled") == "disabled") {
			return;
		}
		
		if (!confirm("确认已经收到货了？")) {
			return;
		}
		
		var order_no = delivery_obj.data("order_no");
		delivery_obj.attr("disabled", "disabled");
		var url = "order_delivery.php?order_no=" + order_no;
		$.getJSON(url, function (result) {
			try {
				motify.log(result.err_msg);
				if (result.err_code == "0") {
					location.reload();
				} else {
					delivery_obj.removeAttr("disabled");
				}
			} catch(e) {
				motify.log("网络错误");
				delivery_obj.removeAttr("disabled");
			}
		});
	});
});



$(function(){
	FastClick.attach(document.body);
	$(window).scroll(function(){
		//var ss= $(".flex").find("li.on");
		//var points_type_index = $(".flex li").index(ss);
		//orderPage = $(".flex li").eq(points_type_index).attr("page");
		if(orderPage > 1 && $(window).scrollTop()/($('body').height() -$(window).height())>=0.95){
			if(orderIsAjax == false){
				if(typeof(max_page) != 'undefined'){
					if(orderPage <= max_page) {
						if($('.wx_loading2').is(":hidden")) {
							getOrders();
						}	
					} else {
						$('#noMoreTips').removeClass("hide").show();
					}
				}
			}
		}
		if($(document).scrollTop() > 50){
			$('.mod_filter').css('top',0);
		}else{
			$('.mod_filter').css('top',45);
		}
	});	
	if($(window).width() < 400){
		orderShowRows = true;
	}

	getOrders();
	
	$(".flex li").live("click",function(){
		//alert(345)
	})
	function getOrders(){

		$.ajax({
			type:"POST",
			url: page_url,
			data:'page='+orderPage,	
			dataType:'json',
			success:function(result){

				$('.wx_loading2').hide();
				if(result.err_code){
					motify.log(result.err_msg);
				}else{
					if(result.err_msg.list.length > 0) {
						
						if(result.err_msg.count){
							$('#sFound').removeClass('hide').find('#totResult').html(result.err_msg.count);
						}
						
						if(page_type == 'tuiguang') {
							var str = '';
							for(var i in result.err_msg.list){
								var list_info = result.err_msg.list[i];
								var add_time =  new Date((list_info.add_time)*1000);
								var str;
								str += '<li>';
								str += '	<div class="rightInfo">';
								if(list_info.point_type == 3) {
									str += '		<p>-'+list_info.point+' 积分</p>';
								} else {
									str += '		<p>+'+list_info.point+' 积分</p>';
								}
								str += '	</div>';
								str += '	<div class="leftInfo">';
								if(list_info.point_type == 3) {
									str += '		<p>积分商城兑换消耗</p>';
								} else if(list_info.point_type == 2){
									str += '		<p>分享平台二维码得积分</p>';
								} else {
									str += '		<p>关注公众号送积分</p>';
								}
								str += '		<p>时间：'+formatDate(add_time,1)+'</p>';
								str += '	</div>';
								str += '</li>';
							}
						} else {
							var str = '';
							for(var i in result.err_msg.list){

								var order_info = result.err_msg.list[i];
								var str;
								var add_time =  new Date((order_info.add_time)*1000);
								str += '<li>';
								str	+= '	<div class="leftInfo" style="float: left;width: 60%">';
								str += '		<p style="font-size: 12px;">订单：'+ order_info.order_no +'</p>';
								str	+= '		<p>时间：'+formatDate(add_time,1)+'</p>';
								str += '	</div>';
								str += '	<div class="leftInfo" style="float:left;width: 10%;margin-top: 15px;">';
								if(order_info.channel == 0) {
									str += '<span>线上</span>';
								} else {
									str += '<span>线下</span>';
								}
								str += '	</div>';
								str += '	<div class="rightInfo" style="float: left;width: 30%;">';
								str += '		<span>'+order_info.bak+'</span>';
								if(order_info.point) {
								if(parseFloat(order_info.point) > 0) {
									str	+= '	<p>+'+ order_info.point + platform_credit_name + '</p>';
								} else {
									str	+= '	<p>'+ order_info.point + platform_credit_name + ' </p>';
								}
								} else {
									str +='<p></p>';
								}
								str	+= '	</div>';
								str += '</li>';
							}
						}
						
						
						
						
						
						
						
						

						
						$(".secttion2").find("ul").append(str);
					
						if(typeof(result.err_msg.noNextPage) == 'undefined'){
							orderIsAjax = false;
						}else if(result.err_msg.noNextPage) {
							orderIsAjax = true;
							$('#noMoreTips').removeClass('hide');
						}
						max_page = result.err_msg.max_page;
					}else{
						$('.empty-list').show();
						if(orderPage == 1){
							$('#sNull01').removeClass('hide');
						}else{
							$('#noMoreTips').removeClass('hide');
						}
					}
					orderPage ++;

					
					//$(".flex li").attr("page",points_type_index);
					
				}
				//} catch (e) {
					
				//}
			},
			error:function(){
				$('.wx_loading2').hide();
				motify.log('商品分类读取失败，<br/>请刷新页面重试',0);
			}
		});
	}
	
	
	function   formatDate(now,is_show_all)   {
		var   year=now.getFullYear();
		var   month=now.getMonth()+1;
		var   date=now.getDate();
		var   hour=now.getHours();
		var   minute=now.getMinutes();
		var   second=now.getSeconds();
		
		hour = (hour>9) ? hour:'0'+hour;
		minute = (minute>9) ? minute:'0'+minute;
		second = (second>9) ? second:'0'+second;
		
		if(is_show_all) {
			return   year+"-"+month+"-"+date+" "+hour+":"+minute+":"+second;
		} else {
			return   year+"-"+month+"-"+date;
		}
	}	
	
});