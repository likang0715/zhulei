/**
 * Created by pigcms_21 on 2015/2/6.
 */
$(function(){

	var action;
	var page;

	function init_create () {

		// 选取商品
		widget_link_box($(".js-add-picture"), "store_goods_by_sku", function (result) {

			var  good_data = pic_list;
			$('.js-goods-list .sort').remove();
			for (var i in result) {
				item = result[i];
				var pic_list = "";
				var list_size = $('.js-product .sort').size();
				if(list_size > 0){
					layer_tips(1, '夺宝活动只能添加一件商品！');
					return false;
				}
				
				$(".js-product").prepend('<li class="sort" data-pid="' + item.product_id + '" data-skuid="' + item.sku_id + '"><a href="' + item.url + '" target="_blank"><img data-pid="' + item.product_id + '" alt="' + item.title + '" title="' + item.title + '" src="' + item.image + '"></a><a class="js-delete-picture close-modal small hide">×</a></li>');
				$(".js-product").data("product_id", item.product_id);

				$("input[name=price]").val(item.price);
				$("input[name=product_id]").val(item.product_id);
				$("input[name=sku_id]").val(item.sku_id);
				$(".js-add-picture").parent().hide();
			}
		});

		var priceObj = $("input[name=price]");
		var itemPriceObj = $("input[name=item_price]");
		var totalNumObj = $(".total_num");
		var warnObj = $(".total_num_warn");

		// 价格/数量计算
		$("input[name=price],input[name=item_price]").blur(function(){

			var price = parseInt(priceObj.val());
			var itemPrice = parseInt(itemPriceObj.val());

			if (price < 1 || itemPrice < 1) {
				warnObj.text('价格与夺宝价格至少为1元');
				return false;
			}

			if (price < itemPrice) {
				warnObj.text('夺宝价格不能大于商品价格');
				return false;
			}

			warnObj.text('');

			var total = price/itemPrice;

			total = Math.ceil(total);
			totalNumObj.text(total);

		});
	}



	load_page('.app__content', load_url, {page:'unitary_list'}, '');
	
	$(".js-list-filter-region a").live('click', function () {
		var action = $(this).attr("href");
		location_page(action, 1)
	});
	
	// 活动分页
	$(".js-list_page a").live("click", function () {
		var page = $(this).data("page-num");
		var keyword = $(".js-list-search").data("keyword");
		var type = $(".js-list-search").data("type");

		load_page('.app__content', load_url, {page : "unitary_list", "type" : type, "p" : page, "keyword" : keyword}, '');
	});

	$(window).keydown(function(event){
		if (event.keyCode == 13 && $('.ui-search-box .txt').is(':focus')) {
			var keyword = $(".js-unitary-keyword").val();
			var type = $(".js-list-search").data("type");
			
			load_page('.app__content', load_url, {page : 'unitary_list', type : type, keyword : keyword}, '', function() {
			});
		}
	})

	// // 活动订单分页
	$(".js-order_page a").live("click", function () {
		var page = $(this).data("page-num");
		location_page(window.location.hash, page);
	});

	function location_page(mark, page){
		var mark_arr = mark.split('/');
		
		switch(mark_arr[0]){
			case '#create': // 添加
				load_page('.app__content', load_url, {page : "create"}, '', function(){
					init_create();
				});
				break;
			case "#edit": 	// 编辑
				if(mark_arr[1]){
					load_page('.app__content', load_url,{page:'edit', id : mark_arr[1]},'',function(){
						init_create();
					});
				}else{
					layer.alert('非法访问！');
					location.hash = '#list';
					location_page('');
				}
				break;
			case "#order" : 		// 订单列表
				if(mark_arr[1]){
					load_page('.app__content', load_url,{page:'order', id : mark_arr[1], "p" : page},'');
				}else{
					layer.alert('非法访问！');
					location.hash = '#order';
					location_page('');
				}
				break;
			case "#future" : 	// 未开始
				action = "future";
				load_page('.app__content', load_url, {page : "unitary_list", "type" : action, "p" : page}, '');
				break;
			case "#on" : 	// 进行中
				action = "on";
				load_page('.app__content', load_url, {page : "unitary_list", "type" : action, "p" : page}, '');
				break;
			case "#end" : 	// 已结束
				action = "end";
				load_page('.app__content', load_url, {page : "unitary_list", "type" : action, "p" : page}, '');
				break;
			default :
				action = "all"; 	// 所有
				load_page('.app__content', load_url, {page : "unitary_list", "type" : action, "p" : page}, '');
		}
	}

	// 预定时间
	$('#enable-time').live('focus', function() {
		var options = {
			numberOfMonths: 2,
			dateFormat: "yy-mm-dd",
			timeFormat: "HH:mm:ss",
			showSecond: true
		};

		$('#enable-time').datetimepicker(options);
	});

	// 取消
	$(".js-btn-quit").live("click", function () {
		location.href = index_url;
	});

	// 添加/修改
	$(".js-create-save").live("click", function () {

		var name = $("input[name=name]").val();
		var price = parseInt($("input[name=price]").val());
		var product_id = $("input[name=product_id]").val();
		var sku_id = $("input[name=sku_id]").val();
		var opentime = $("input[name=opentime]").val();
		var item_price = parseInt($("input[name=item_price]").val());
		var logopic = $("input[name=logopic]").val();

		var descript = $(".descript").val();

		if (!logopic) {
			layer_tips(1, "请上传夺宝logo");
			return;
		}

		if (name.length == 0) {
			layer_tips(1, "请填写夺宝名称");
			$("input[name=name]").focus();
			return;
		}
		
		if (product_id == "0") {
			layer_tips(1, "请选择夺宝商品");
			return;
		}

		if (price < 1 || item_price < 1) {
			layer_tips(1, '价格与夺宝价格需要为正整数');
			return;
		}

		if (price < item_price) {
			layer_tips(1, '夺宝价格不能大于商品价格');
			return;
		}

		var data = { name:name, logopic:logopic, product_id:product_id, sku_id:sku_id, price:price, item_price:item_price, opentime:opentime, descript:descript };
		if ($("#unitary_id").size() > 0) {		// 修改
			var post_url = unitary_edit_url;
			data.id = $("#unitary_id").val();
		} else {	// 添加
			var post_url = unitary_create_url;
		}
		
		$.post(post_url, data, function (result) {
			if (result.err_code == 0) {
				layer_tips(0, "操作完成");
				window.location.href = result.err_msg;
			} else {
				layer_tips(1, result.err_msg);
			}
		});
	});

	// 操作状态 开始
	$(".js-start").live("click", function(e){
		var self = $(this);
		var unitary_id = self.closest("td").data("unitary_id");

		button_box($(this), e, 'left', 'confirm', '开始以后将不能修改价格<br />确定开始吗？', function(){
			$.post(unitary_operate_url, { type:"start", unitary_id:unitary_id }, function (result) {
				close_button_box();
				if (result.err_code == 0) {
					layer_tips(0, "操作完成");
					load_page('.app__content', load_url, {page : "unitary_list", "type" : action, "p" : page}, '');
				} else {
					layer_tips(1, result.err_msg);
				}
			});
		});
	});

	// 操作状态 使失效
	$(".js-disabled").live("click", function(e){
		var self = $(this);
		var unitary_id = self.closest("td").data("unitary_id");
		button_box($(this), e, 'left', 'confirm', '使失效后将不会在手机上显示<br />确定失效吗？', function(){
			$.post(unitary_operate_url, { type:"stop", unitary_id:unitary_id }, function (result) {
				close_button_box();
				if (result.err_code == 0) {
					layer_tips(0, "操作完成");
					load_page('.app__content', load_url, {page : "unitary_list", "type" : action, "p" : page}, '');
				} else {
					layer_tips(1, result.err_msg);
				}
			});
		});

	});

	// 操作状态 删除
	$(".js-delete").live("click", function(e){
		var self = $(this);
		var unitary_id = self.closest("td").data("unitary_id");

		button_box($(this), e, 'left', 'confirm', '删除之后无法恢复<br />确认删除该夺宝活动吗？', function(){
			$.post(unitary_operate_url, { type:"del", unitary_id:unitary_id }, function (result) {
				close_button_box();
				if (result.err_code == 0) {
					layer_tips(0, "操作完成");
					load_page('.app__content', load_url, {page : "unitary_list", "type" : action, "p" : page}, '');
				} else {
					layer_tips(1, result.err_msg);
				}
			});
		});

	});

	// 复制链接
	$(".js-copy-link").live("click", function (e) {
		var unitary_id = $(this).closest("td").data("unitary_id");
		button_box($(this),e,'left','copy', unitary_wap_url + unitary_id, function(){
			layer_tips(0,'复制成功');
		});
	});

	// 预览浮层
	$(".js_show_ewm").live("click",function(e) {
		event.stopPropagation();
		var dom = $(this);
		var dom_offset = dom.offset();
		
		var id = dom.data("id");
		var qrcode_url = unitary_qrcode_url + "&id=" + id;
		var htmls = "";
			htmls += '<div class="popover bottom" style="">';
			htmls += '	<div class="arrow"></div>';
			htmls += '	<div style="width:120px;" class="popover-inner">';
			htmls += '		<div class="popover-content">';
			htmls += '			<div class="form-inline">';
			htmls += '				<div class="input-append"><img width="100" height="100" src="' + qrcode_url + '"></div>';
			htmls += '			</div>';
			htmls += '		</div>';
			htmls += '	</div>';
			htmls += '</div>';
		$('body').append(htmls);
		
		var popover_height = $('.popover').height();
		var popover_width = $('.popover').width();
		
		$('.popover').css({top: dom_offset.top + dom.height()-3, left: dom_offset.left - (popover_width/2) + (dom.width()/2)});
		
		$('.popover').click(function(e) {
			e.stopPropagation();
		});
		
		$('body').bind('click',function() {
			$(".popover").remove();
		});
	})

	// 编辑
	$(".js-edit").live("click", function () {
		if($(this).attr('href') && $(this).attr('href').substr(0, 1) == '#') {
			location_page($(this).attr('href'));
		}
	});

	// 删除选择的商品
	$(".js-delete-picture").live("click", function () {

		var self = $(this);
		var btn = self.parents("ul").find(".add-goods");

		// 显示 +图片 +产品 按钮
		self.closest("li").remove();
		btn.parent().show();

		$("input[name=product_id]").val(0);
		$("input[name=sku_id]").val(0);


	});

	// 添加商品logo图
	$('.js-add-logo').live('click', function(){

		var self = $(this);

		upload_pic_box(1,true,function(pic_list){

			if (pic_list.length == 0) {
				layer_tips(1, "请先上传图片");
				return false;
			}

			if (pic_list.length > 0) {
			    for (var i in pic_list) {
			        // $(".js-logo").find("img").attr("src", pic_list[i]);
			        self.parents("ul:first").prepend('<li class="sort"><a href="javascript:void(0)" target="_blank"><img src="'+pic_list[i]+'"></a><a class="js-delete-picture close-modal small hide">×</a></li>');
			        $("input[name=logopic]").val(pic_list[i]);
			        self.parent().hide();
			    }
			}

        },1);
    });

})