$(function(){
	$(".js-code").focus();
	$('.js-modal iframe',parent.document).height($('body').height());
	$('.modal-header .close').live('click',function(){
		parent.login_box_close();
	});
	
	$('button.js-choose').live('click',function(){
		if ($(this).hasClass("btn-primary")) {
			$(this).removeClass("btn-primary");
			$(this).html("选取");
		} else {
			$(this).addClass("btn-primary");
			$(this).html("取消");
		}

		if ($("button.btn-primary").size() > 0) {
			$(".js-confirm-choose").show();
		} else {
			$(".js-confirm-choose").hide();
		}
	});
	
	// 提交
	$(".js-confirm-choose .btn").live("click", function () {
		var data = [];
		$("button.btn-primary").each(function (i) {
			var product_data = {};
			product_data.number = $(this).closest("tr").find(".js-number").val();
			product_data.quantity = $(this).closest("tr").find(".js-number").attr("max-value");
			product_data.product_id = $(this).data("id");
			product_data.image = $(this).data("image");
			product_data.title = $(this).data("title");
			product_data.sku_id = $(this).data("sku_id");
			product_data.sku_data = $(this).data("sku_data");
			product_data.url = $(this).data("url");
			product_data.price = $(this).closest("tr").find(".js-price").val();
			
			data[i] = product_data;
		});
		parent.widget_box_after(number, data);
	});
	
	// 分页
	$('.js-page-list a').live('click',function(e){
		if(!$(this).hasClass('active')){
			var input_val = $('.js-modal-search-input').val();
			$('body').html('<div class="loading-more"><span></span></div>');
			$('body').load(goods_by_sku_url, {p : $(this).data('page-num'), 'keyword' : input_val, 'is_ajax' : true, 'uid' : uid}, function(){
				$('.js-modal iframe',parent.document).height($('body').height());
			});
		}
	});
	
	// 搜索
	$('.js-modal-search').live('click',function(e){
		var input_val = $('.js-modal-search-input').val();
		$('body').html('<div class="loading-more"><span></span></div>');
		$('body').load(goods_by_sku_url, {'keyword' : input_val, 'is_ajax' : true, 'uid' : uid},function(){
			$('.js-modal iframe',parent.document).height($('body').height());
		});
		return false;
	});

	//回车提交搜索
	$(window).keydown(function(event){
		if (event.keyCode == 13 && $('.js-modal-search-input').is(':focus')) {
			var input_val = $('.js-modal-search-input').val();
			$('body').html('<div class="loading-more"><span></span></div>');
			$('body').load(goods_by_sku_url, {'keyword' : input_val, 'is_ajax' : true, 'uid' : uid},function(){
				$('.js-modal iframe',parent.document).height($('body').height());
			});
			return false;
		}
		
		if (event.keyCode == 13 && $('.js-code').is(':focus')) {
			var code = $('.js-code').val();
			$(".js-code").attr("placeholder", code);
			$('.js-code').val("");
			var post_data = {uid : uid, code : code};
			
			$.post("", post_data, function (result) {
				try {
					var product_list = result.product_list;
					var vid_list = result.vid_list;
					var pid_list = result.pid_list;
					var product_list_html = "";
					for (var i in product_list) {
						var product = product_list[i];
						
						// 判断是否存在
						var product_obj = $("#js-product-" + product.product_id);
						if (product_obj.size() > 0) {
							if (product.sku_list) {
								for (var j in product.sku_list) {
									var product_sku = product.sku_list[j];
									var product_sku_obj = $(".js-product-sku-" + product.product_id + "-" + product_sku.sku_id);
									
									if (product_sku_obj.size() > 0) {
										if (parseInt(product_sku_obj.find(".js-number").val()) + 1 > parseInt(product_sku_obj.find(".js-number").attr("max-value"))) {
											product_sku_obj.find(".js-number").css("border-color", "#b94a48");
											product_sku_obj.find(".js-number").animate({"border-color" : "#cccccc"}, 2000, function () {
												$(this).css("border-color", "#cccccc");
											});
										} else {
											product_sku_obj.find(".js-number").val(parseInt(product_sku_obj.find(".js-number").val()) + 1);
										}
									} else {
										// 添加新库存信息
										var sku_arr = product_sku.properties.split(';');
										var product_sku_html= "";
										
										product_sku_html += '	<tr class="js-product-sku-' + product.product_id + ' js-product-sku-' + product.product_id + '-' + product_sku.sku_id + '">';
										product_sku_html += '		<td class="title" style="max-width:300px;">';
										product_sku_html += '			&#12288;&#12288;规格：';
										
										var sku_str = '';
										for (var k in sku_arr) {
											var pid_vid = sku_arr[k].split(':');
											product_sku_html += '			&#12288;' + pid_list[pid_vid[0]].name + ':' + vid_list[pid_vid[1]].value;
											sku_str = '			&#12288;' + pid_list[pid_vid[0]].name + ':' + vid_list[pid_vid[1]].value;
										}
										product_sku_html += '	</td>';
										product_sku_html += '	<td>';
										product_sku_html += '		<input type="text" class="js-price" value="' + product_sku.price + '" old-value="' + product_sku.price + '" style="width:50px;" title="原价：' + product_sku.origin_price + '" />';
										product_sku_html += '	</td>';
										product_sku_html += '	<td class="time">';
										product_sku_html += '		<input type="text" name="number" class="js-number" value="1" style="width:50px;" old-value="1" max-value="' + product_sku.quantity + '" />';
										product_sku_html += '		库存：' + product_sku.quantity;
										product_sku_html += '	</td>';
										product_sku_html += '	<td class="opts">';
										product_sku_html += '		<div class="td-cont">';
										product_sku_html += '			<button class="btn btn-primary" style="display:none;" data-id="' + product.product_id + '" data-image="' + product.image + '" data-title="' + product.name + '" data-sku_id="' + product_sku.sku_id + '" data-sku_data="' + sku_str + '" data-url="' + product.link + '" data-price="' + product_sku.price + '">选取</button>';
										product_sku_html += '			<button class="btn js-delete" data-type="product_sku" data-id="' + product.product_id + '" data-image="' + product.image + '" data-title="' + product.name + '" data-sku_id="' + product_sku.sku_id + '" data-sku_data="' + sku_str + '" data-url="' + product.link + '" data-price="' + product_sku.price + '">删除</button>';
										product_sku_html += '		</div>';
										product_sku_html += '	</td>';
										product_sku_html += '</tr>';
										
										$(".js-product-sku-" + product.product_id + ":last-child").after(product_sku_html);
									}
								}
							} else {
								if (parseInt(product_obj.find(".js-number").val()) + 1 > parseInt(product_obj.find(".js-number").attr("max-value"))) {
									product_obj.find(".js-number").css("border-color", "#b94a48");
									product_obj.find(".js-number").animate({"border-color" : "#cccccc"}, 2000, function () {
										$(this).css("border-color", "#cccccc");
									});
								} else {
									product_obj.find(".js-number").val(parseInt(product_obj.find(".js-number").val()) + 1);
								}
							}
							
							continue;
						}
						
						product_list_html += '<tr id="js-product-' + product.product_id + '" class="js-product-detail">';
						product_list_html += '	<td class="title" style="max-width:300px;">';
						product_list_html += '		<div class="td-cont">';
						product_list_html += '			<a target="_blank" class="new_window" href="' + product.link + '">' + product.name + '</a>';
						product_list_html += '		</div>';
						product_list_html += '	</td>';
						product_list_html += '	<td class="time">';
						product_list_html += '		<div class="td-cont">';
						
						if (typeof product.sku_list == "undefined" || product.sku_list == "") {
							var origin_price = product.price;
							if (typeof product.origin_price != "undefined") {
								origin_price = product.origin_price;
							}
							product_list_html += '			<input type="text" class="js-price" value="' + product.price + '" old-value="' + product.price + '" style="width:50px;" title="原价：' + origin_price + '" />';
						} else {
							product_list_html += product.price;
						}
						product_list_html += '		</div>';
						product_list_html += '	</td>';
						product_list_html += '	<td class="time">';
						product_list_html += '		<div class="td-cont">';
						
						if (typeof product.sku_list == "undefined" || product.sku_list.length == 0) {
							product_list_html += '			<input type="text" name="number" class="js-number" value="1" style="width:50px;" old-value="1" max-value="' + product.quantity + '" />库存：' + product.quantity;
						}
						product_list_html += '		</div>';
						product_list_html += '	</td>';
						product_list_html += '	<td class="opts">';
						product_list_html += '		<div class="td-cont">';
						
						if (typeof product.sku_list != "undefined") {
							product_list_html += '		<button class="js-open" data-id="' + product.product_id + '">闭合</button>';
						} else {
							product_list_html += '		<button class="btn btn-primary" style="display:none;" data-id="' + product.product_id + '" data-image="' + product.image + '" data-title="' + product.name + '" data-sku_id="" data-sku_data="" data-url="' + product.link + '" data-price="' + product.price + '">选取</button>';
							product_list_html += '		<button class="btn js-delete" data-type="product" data-id="' + product.product_id + '" data-image="' + product.image + '" data-title="' + product.name + '" data-sku_id="" data-sku_data="" data-url="' + product.link + '" data-price="' + product.price + '">删除</button>';
						}
						product_list_html += '		</div>';
						product_list_html += '	</td>';
						product_list_html += '</tr>';
						
						// 查看是否有库存
						if (product.sku_list) {
							for(var j in product.sku_list) {
								var product_sku = product.sku_list[j];
								var sku_arr = product_sku.properties.split(';');
								
								product_list_html += '	<tr class="js-product-sku-' + product.product_id + ' js-product-sku-' + product.product_id + '-' + product_sku.sku_id + '">';
								product_list_html += '		<td class="title" style="max-width:300px;">';
								product_list_html += '			&#12288;&#12288;规格：';
								
								var sku_str = '';
								for (var k in sku_arr) {
									var pid_vid = sku_arr[k].split(':');
									product_list_html += '			&#12288;' + pid_list[pid_vid[0]].name + ':' + vid_list[pid_vid[1]].value;
									sku_str += '			&#12288;' + pid_list[pid_vid[0]].name + ':' + vid_list[pid_vid[1]].value;
								}
								product_list_html += '	</td>';
								product_list_html += '	<td>';
								product_list_html += '		<input type="text" class="js-price" value="' + product_sku.price + '" old-value="' + product_sku.price + '" style="width:50px;" title="原价：' + product_sku.origin_price + '" />';
								product_list_html += '	</td>';
								product_list_html += '	<td class="time">';
								product_list_html += '		<input type="text" name="number" class="js-number" value="1" style="width:50px;" old-value="1" max-value="' + product_sku.quantity + '" />';
								product_list_html += '		库存：' + product_sku.quantity;
								product_list_html += '	</td>';
								product_list_html += '	<td class="opts">';
								product_list_html += '		<div class="td-cont">';
								product_list_html += '			<button class="btn btn-primary" style="display:none;" data-id="' + product.product_id + '" data-image="' + product.image + '" data-title="' + product.name + '" data-sku_id="' + product_sku.sku_id + '" data-sku_data="' + sku_str + '" data-url="' + product.link + '" data-price="' + product_sku.price + '">选取</button>';
								product_list_html += '			<button class="btn js-delete" data-type="product_sku" data-id="' + product.product_id + '" data-image="' + product.image + '" data-title="' + product.name + '" data-sku_id="' + product_sku.sku_id + '" data-sku_data="' + sku_str + '" data-url="' + product.link + '" data-price="' + product_sku.price + '">删除</button>';
								product_list_html += '		</div>';
								product_list_html += '	</td>';
								product_list_html += '</tr>';
									
							}
						}
					}
					
					if (product_list_html.length > 0) {
						$('#js-module-feature table').append(product_list_html);
						$(".js-confirm-choose").show();
						$('.js-modal iframe',parent.document).height($('body').height());
					}
				} catch (e) {
					
				}
			}, "json");
		}
	});
	
	// 展开、关闭
	$(".js-open").live("click", function () {
		var product_id = $(this).data("id");
		if ($(".js-product-sku-" + product_id).eq(0).is(":visible")) {
			$(".js-product-sku-" + product_id).hide();
			$(this).html("展开");
		} else {
			$(".js-product-sku-" + product_id).show();
			$(this).html("闭合");
		}
		$('.js-modal iframe',parent.document).height($('body').height());
	});
	
	// 删除
	$(".js-delete").live("click", function () {
		var product_id = $(this).data("id");
		var type = $(this).data("type");
		
		$(this).closest("tr").remove();
		if (type == "product_sku") {
			if ($(".js-product-sku-" + product_id).size() == 0) {
				$(".js-product-sku-" + product_id).remove();
				$("#js-product-" + product_id).remove();
			}
		}
		$('.js-modal iframe',parent.document).height($('body').height());
		if ($(".js-product-detail").size() == 0) {
			$(".js-confirm-choose").hide();
		}
	});
	
	// 更改数量
	$(".js-number").live("blur", function () {
		var number = $(this).val();
		var num_reg = /^[0-9]*$/
		
		if (!num_reg.test(number)) {
			$(this).val($(this).attr("old-value"));
			return;
		}
		number = parseInt(number) + 0;
		if (number > parseInt($(this).attr("max-value"))) {
			$(this).val($(this).attr("max-value"));
			return;
		}
		
		$(this).val(number);
		$(this).attr("old-value", number);
	});
	
	// 更改价格
	$(".js-price").live("blur", function () {
		var number = $(this).val();
		var num_reg = /^[0-9]+.?[0-9]*$/;
		
		if (!num_reg.test(number)) {
			$(this).val($(this).attr("old-value"));
			return;
		}
		number = parseFloat(number).toFixed(2);
		
		$(this).val(number);
		$(this).attr("old-value", number);
	});
});