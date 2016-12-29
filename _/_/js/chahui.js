/**
 * Created by pigcms_21 on 2015/2/6.
 */
$(function(){
	$(".js-page-list a").live("click", function () {
		var page = $(this).data("page-num");
		location_page(window.location.hash, page);
	});
	
	//开始时间
	$('#js-start-time').live('focus', function() {
		var options = {
			numberOfMonths: 2,
			dateFormat: "yy-mm-dd",
			timeFormat: "HH:mm",
			minDate: "0",
			showSecond: false,
			onSelect: function() {
				if ($('#js-start-time').val() != '') {
					$('#js-end-time').datepicker('option', 'minDate', new Date());
				}
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
			numberOfMonths: 2,
			dateFormat: "yy-mm-dd",
			minDate: "0",
			timeFormat: "HH:mm",
			showSecond: false,
			onSelect: function() {
				if ($('#js-end-time').val() != '') {
					$('#js-start-time').datepicker('option', 'maxDate', new Date($('#js-end-time').val()));
				}
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
	

	// 取消
	$(".js-btn-quit").live("click", function () {
		location_page('');
	})
	
	// 添加茶会
	$(".js-add-present").live("click", function () {
		$(".js-select-goods-list").show();
		loadProduct();
	});
	
	// 类型切换
	$(".js-search-type").live('change', function () {
		$(".js-title").attr("placeholder", $(".js-title").attr("data-goods-" + $(this).val()));
	})
	
	// 搜索添加茶会
	$(".js-search").live('click', function () {
		var group_id = $(".js-goods-group").val();
		var type = $(".js-search-type").val();
		var title = $(".js-title").val();
		loadProduct(group_id, type, title, 1);
	})
	
	// 搜索商品切换
	$(".js-product_list_page a").live('click', function () {
		var page = $(this).attr("data-page-num");
		var group_id = $(".js-goods-group").val();
		var type = $(".js-search-type").val();
		var title = $(".js-title").val();
		loadProduct(group_id, type, title, page);
	});
	
	
	
	// 分页
	$(".js-present_list_page a").live("click", function () {
		var p = $(this).data("page-num");
		var keyword = $('.js-present-keyword').val();
		var type = window.location.hash.substring(1);
		
		$('.app__content').load(load_url, {page : page_content, 'keyword' : keyword, 'type' : type, 'p' : p}, function(){
		});
	})


	// 删除茶会
	$('.js-delete').live("click", function(e){
		var pigcms_id = $(this).attr('data-id');
        button_box($(this), e, 'left', 'confirm', '确定删除？', function(){
            $.post(store_physical_del_url, {'pigcms_id': pigcms_id}, function(data){
                if (!data.err_code) {
                    $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                    window.location.reload();
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                }
                t = setTimeout('msg_hide()', 3000);
                close_button_box();
            });
        });
	
	});

	//回车提交搜索
	$(window).keydown(function(event){
		if (event.keyCode == 13 && $('.js-present-keyword').is(':focus')) {
			var keyword = $('.js-present-keyword').val();
			var type = window.location.hash.substring(1);
			
			$('.app__content').load(load_url, {page : page_content, 'keyword' : keyword, 'type' : type}, function(){
			});
		}
	})
})

function presentList() {
	location.href = "user.php?c=appmarket&a=present";
}

function loadProduct(group_id, type, title, page) {
	load_page(".js_select_goods_loading", load_url, {"page" : page_product_list, "group_id" : group_id, "type" : type, "title" : title, "p" : page}, '', function() {
		checkProductStatus();
	});
}

// 检查已经设置为茶会，更改状态
function checkProductStatus() {
	var product_id = '';
	$(".js-show-present").find(".current-present").each(function () {
		product_id = $(this).data('product_id');
		try {
			$("#js-add-reward-" + product_id).html("已设为茶会");
			$("#js-add-reward-" + product_id).removeClass("btn-primary");
		} catch (e) {
			
		}
	});
}

// 
function msg_hide() {
	$('.notifications').html('');
	clearTimeout(t);
}