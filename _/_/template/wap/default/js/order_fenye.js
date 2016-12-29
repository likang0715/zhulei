var orderPage = 1;
var orderIsAjax = false;
var orderSort = 'default';
var orderShowRows = false;
var max_page;


$(function(){
	var top_heights = $(".container .tabber-n2").height();
	$(".content #order-list-container .b-list").css({"padding-top":top_heights});
	
	if($('li.block-order').size() == 0) {
	//	$('.empty-list').show();
	}
	$('.js-cancel-order').live("click", function(){
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
	
	$(".js-delivery").live("click", function () {
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
		if(orderPage > 1 && $(window).scrollTop()/($('body').height() -$(window).height())>=0.95){
			if(orderIsAjax == false){
				if(typeof(max_page) != 'undefined'){
					if(orderPage <= max_page) {
						if($('.wx_loading2').is(":hidden")) {
							getOrders();
						}	
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
	

	
	//二次支付
	$(".go_presave_order").live("click",function(){
		var order_id=$(this).data("order_id");
		$.post(
			"./presale_saveorder.php?action=endpay",
			{"order_id":order_id},
			function (result) {
				//console.log(result);return;
				if(result.err_code == '9999') {
					window.location.href= "pay.php?id="+result.err_msg;
				} else if(result.err_code){
					
					motify.log(result.err_msg);
					return false;
				}  else{
					window.location.href= "pay.php?id="+result.err_msg;
				}
				
				
				
			}
		)
	})

	getOrders();
	
	function getOrders(){
		$('.wx_loading2').show();
		
		$.ajax({
			type:"POST",
			url: page_url,
			data:'page='+orderPage,	
			dataType:'json',
			success:function(result){
				try {
					$('.wx_loading2').hide();
					if(result.err_code){
						motify.log(result.err_msg);
					}else{
						if(result.err_msg.list.length > 0){

							if(result.err_msg.count){
								$('#sFound').removeClass('hide').find('#totResult').html(result.err_msg.count);
							}

							var str = '';

							for(var i in result.err_msg.list){

								var order = result.err_msg.list[i];
								var physical_list = result.err_msg.physical_list;
								var store_contact_list = result.err_msg.store_contact_list;
								var url_arr = result.err_msg.url;
								///////////////////////////////////////////
								 str+='<li class="block block-order animated"><div class="header"><span class="font-size-12">订单号：'+order.order_no_txt+'</span>';
								if (order.type == "6") {
									str += '<span class="c-orange">团购订单</span>';
								} else if (order.type == "7") {
									var type = '';
									if (order.order_id == order.presale_order_id) {
										type = '(尾款)';
									}
									str += '<span class="c-orange">预售订单' + type + '</span>';
								}

								if (order.is_offline == "1") {
									str += '&nbsp;<span class="c-orange">线下手工做单</span>';
								}

								if(order.status<2) {
									str+= '<a class="js-cancel-order pull-right font-size-12 c-blue" href="javascript:;" data-id="'+order.order_id+'">取消</a>';
								}
								str+='</div>';
								str+='<hr class="margin-0 left-10"/>';

								for(var ii in order.order_product_list) {
									var order_product = order.order_product_list[ii];
									var product_url = "#";
									if (order_product.product_id > 0) {
										product_url = "good.php?id=" + order_product.product_id;
									}

									if (order.type == "6") {
										product_url = order.product_url;
									}
									if(order.type == '7') {
										product_url = "./presale.php?id=" + order.data_id;
									}


									str+='<div class="block block-list block-border-top-none block-border-bottom-none">';
									str+='	<div class="block-item name-card name-card-3col clearfix">';
									str+='		<a href="' + product_url + '" class="thumb">';
									str+='			<img src="'+order_product.image+'"/>';
									str+='		</a>';
									str+='		<div class="detail">';
									str+='			<a href="' + product_url + '"><h3 style="margin-bottom:6px;">'+order_product.name+'</h3></a>';
									if(order_product.sku_data_arr) {
										for(var iii in order_product.sku_data_arr) {
											var v = order_product.sku_data_arr[iii];
											str+='	<p class="c-gray ellipsis">'+v.name+'：'+v.value+'</p>';
										}
									}

									if (order.type != '53' && order.type != "7") {
										if(order.is_point_order != 1 && order.is_offline != 1) {
											if (order_product.return_status != "0") {
												str += '<a class="link pull-right return_btn" href="return_detail.php?order_no=' + order.order_no_txt + '&pigcms_id=' + order_product.pigcms_id + '">查看退货</a>';
											}

											if ((order.type != 6 && order.is_return && order_product.return_status != "2" && order_product.is_present == "0") || (order.is_return && order.type == 6 && order.status == 7)) {
												str += '<a class="link pull-right return_btn" href="return_apply.php?order_id=' + order.order_no_txt + '&pigcms_id=' + order_product.pigcms_id + '">退货</a>';
											}

											if (order.is_rights && order_product.rights_status != "2" && order_product.is_present == "0") {
												str += '<a class="link pull-right return_btn" href="rights_apply.php?order_id=' + order.order_no_txt + '&pigcms_id=' + order_product.pigcms_id + '">维权</a>';
											}

											if (order_product.rights_status != "0") {
												str += '<a class="link pull-right return_btn" href="rights_detail.php?order_no=' + order.order_no_txt + '&pigcms_id=' + order_product.pigcms_id + '">查看维权</a>';
											}
										}
									}
									str+='		</div>';
									str+='		<div class="right-col">';
									if(order.is_point_order == 1) {
										str+='			<div class="price"><span class="point_ico"></span> <span>'+parseInt(order_product.pro_price)+'</span></div>';
									} else {
										str+='			<div class="price">¥ <span>'+order_product.pro_price+'</span></div>';
									}
									str+='			<div class="num">×<span class="num-txt">'+order_product.pro_num+'</span></div>';
									str+='		</div>';
									str+='	</div>';
									str+='</div>';
								}

								if(order.shipping_method == 'selffetch') {
									str+='<hr class="margin-0 left-10"/>';
									str+='<div class="bottom">';
									if(order.address['physical_id']) {
										str+= "<span style='width:70%;display:inline-block'>"+physical_list[order.address['physical_id']].buyer_selffetch_name+' ('+physical_list[order.address['physical_id']].name+')'+"</span>";
										str+='<div class="opt-btn">';
										str+='<a class="btn btn-in-order-list" href="./physical_detail.php?id='+order.address['physical_id']+'">查看</a>';
										str+='</div>';

									} else if(order.address['store_id']){

										if(typeof(store_contact_list[order.address['store_id']]) != 'undefined') {
											str+= "<span style='width:70%;display:inline-block'>"+store_contact_list[order.address['store_id']].buyer_selffetch_name +' ('+store_contact_list[order.address['store_id']].name+')'+"</span>";
											str+='<div class="opt-btn">';
											str+='<a class="btn btn-in-order-list" href="./physical_detail.php?store_id='+order.address['store_id']+'">查看</a>';
											str+='</div>';
										}


									}
								}
								///////////////////

								///////////////////////////////
								str+='<hr class="margin-0 left-10"/>';
								str+='<div class="bottom" style="padding-right:0px;">';

								if(order.total) {
									if(order.float_amount <0){
										orderFloat_amount = Math.abs(order.float_amount);
										str+="减免："+'<span class="c-red">￥'+orderFloat_amount.toFixed(2)+'</span><br/>';
									}
									if(order.is_point_order == 1) {
										str+='总价：'+'<span class="c-orange"><span class="point_ico"></span>'+order.order_pay_point+'</span>';
									} else {
										str+='总价：'+'<span class="c-orange">￥'+order.total+'</span>';

										if (order.type == 6 && order.data_money > 0) {
											str += ', 退：<span class="c-orange">￥' + order.data_money + '</span>';
										}
									}
								} else {
									str+='商品价格：'+'<span class="c-orange">￥'+order.sub_total+'</span>';
								}

								str+='<div class="opt-btn">';

								if(order.type == 7) {
										if(order.status=='3') {
											str+='<a class="btn btn-green btn-in-order-list js-delivery" href="javascript:" data-order_no="'+orderid_prefix+order.order_no+'" style="width:auto;">确认收货</a>';
										}
										if(order.status > 2 && order.has_physical_send == 1) {
											str+='<a class="btn btn-green btn-in-order-list" href="./my_package.php?order_id='+order.order_id+' style="width: 5em;">配送详情</a>';
										}
										if(order.status<2) {
											str+='<a class="btn btn-orange btn-in-order-list" href="'+order.url+'">付款</a>';
										} else {
											//if(order.status == 7) {
											if(order.show_pay_button == 'yes') {
												str+='<a class="btn btn-orange btn-in-order-list go_presave_order"  data-order_id="'+order.order_id+'" hrefs="./presale_saveorder.php?action=endpay&order_id='+order.order_id+'" href="javascript:void(0)">付尾款</a>';

											}
											//	if(order.presale_order_id==0) {
														//	}
											//}

											if(order.status == 4)  str+='<a class="btn btn-in-order-list" href="'+url_arr.comment_url+"&oid="+order.order_id+"&order_no="+order.order_no+'">评论</a>';
											str+='<a class="btn btn-in-order-list" href="'+order.url+'">详情</a>';
										}

									} else {
									if(order.status=='3') {
										str+='<a class="btn btn-green btn-in-order-list js-delivery" href="javascript:" data-order_no="'+orderid_prefix+order.order_no+'" style="width:auto;">确认收货</a>';
									}
									if(order.status > 2 && order.has_physical_send == 1) {
										str+='<a class="btn btn-green btn-in-order-list" href="./my_package.php?order_id='+order.order_id+' style="width: 5em;">配送详情</a>';
									}
									if(order.status<2) {
										str+='<a class="btn btn-orange btn-in-order-list" href="'+order.url+'">付款</a>';
									} else {
										if((order.status == 4 || order.status == 7) && order.is_offline == "0")  str+='<a class="btn btn-in-order-list" href="'+url_arr.comment_url+"&oid="+order.order_id+"&order_no="+order.order_no+'">评论</a>';
										str+='<a class="btn btn-in-order-list" href="'+order.url+'">详情</a>';
										if (order.status == 7 && order.returning == false) {
											str+='<a href="javascript:void(0);" class="btn btn-in-order-list btn-orange btn-complate" data-url="'+url_arr.complate_url+'&order_no=' + order.order_no + '">交易完成</a>';
										}
									}
								}

								str+='	</div>';
								str+='</div>';
								str+='</li>';
								//////////////////////////////////////////
							}


							$('.b-list').append(str).removeClass('hide');

							if(typeof(result.err_msg.noNextPage) == 'undefined'){
								orderIsAjax = false;
							}else if(result.err_msg.noNextPage) {
								orderIsAjax = true;
								var	str1 = '<div style="width: 100%; height: 20px;"></div>';
								$('.b-list').append(str1)
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
					}
				} catch (e) {
					
				}
			},
			error:function(){
				$('.wx_loading2').hide();
				motify.log('订单读取失败，<br/>请刷新页面重试',0);
			}
		});
	}

	$('.btn-complate').live('click', function(e) {
		var complate_url = $(this).data('url');
		$.get(complate_url, "", function(data){
			if (data.err_code != 0) {
				motify.log(data.err_msg, 0);
			} else {
				motify.log(data.err_msg, 0);
				window.location.reload();
			}
		});
	});
	
});