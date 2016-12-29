/**
 * Created by ediancha on 2016/8/9.
 */
function location_page(mark, page){
	var mark_arr = mark.split('/');
	
	switch(mark_arr[0]){
		case '#create': // 添加
			load_page('.app__content', load_url, {page : "create"}, '', function(){
				// init_create();
			});
			break;
		case "#edit": 	// 编辑
			if(mark_arr[1]){
				load_page('.app__content', load_url, {page:'edit', id : mark_arr[1]},'',function(){
					// init_create();
				});
			}else{
				layer.alert('非法访问！');
				location.hash = '#list';
				location_page('');
			}
			break;
		case "#record" : 		// 参与记录列表
			if(mark_arr[1]){
				load_page('.app__content', load_url,{page:'record', id : mark_arr[1], "p" : page},'');
			}else{
				layer.alert('非法访问！');
				location.hash = '#record';
				location_page('');
			}
			break;
			
		case "#future" : 	// 未开始
			action = "future";
			load_page('.app__content', load_url, {page : "list", "type" : action, "p" : page}, '');
			break;
		case "#on" : 	// 进行中
			action = "on";
			load_page('.app__content', load_url, {page : "list", "type" : action, "p" : page}, '');
			break;
		case "#end" : 	// 已结束
			action = "end";
			load_page('.app__content', load_url, {page : "list", "type" : action, "p" : page}, '');
			break;
		default :
			action = "all"; 	// 所有
			load_page('.app__content', load_url, {page : "list", "type" : action, "p" : page}, '');
	}
}
$(function(){

	var action;
	var page;

	load_page('.app__content', load_url, {page:'list'}, '');
	
	// 活动分类切换
	$(".js-list-filter-region a").live('click', function () {
		var action = $(this).attr("href");
		location_page(action, 1)
	});

	// 返回优惠接力活动列表
	$(".js-back-btn").live('click', function(){
		load_page('.app__content', load_url, {page : "list", "type" : action}, '');
	});
	


	$(window).keydown(function(event){
		if (event.keyCode == 13 && $('.ui-search-box .txt').is(':focus')) {
			var keyword = $(".js-keyword").val();
			var type = $(".js-list-search").data("type");
			
			load_page('.app__content', load_url, {page : 'list', type : type, keyword : keyword}, '', function() {
			});
		}
	})

	// 取消
	$(".js-btn-quit").live("click", function () {
		location.href = yousetdiscount_index_url;
	});

	// 编辑
	$(".js-edit").live("click", function(){
		if($(this).attr('href') && $(this).attr('href').substr(0, 1) == '#') {
			location_page($(this).attr('href'));
		}
	});

	// 复制链接
	$(".js-copy-link").live("click", function (e) {
		var id = $(this).data("id");
		var url = $(this).data("url");
		button_box($(this),e,'left','copy', url, function(){
			layer_tips(0,'复制成功');
		});
	});

	// 操作状态 使失效
	$(".js-disabled").live("click", function(e){
		var self = $(this);
		var yid = self.closest("td").data("id");
		button_box($(this), e, 'left', 'confirm', '使失效后将不会在手机上显示<br />确定失效吗？', function(){
			$.post(yousetdiscount_operate_url, { type:"stop", yid:yid }, function (result) {
				close_button_box();
				if (result.err_code == 0) {
					layer_tips(0, "操作完成");
					load_page('.app__content', load_url, {page : "list", "type" : action, "p" : page}, '');
				} else {
					layer_tips(1, result.err_msg);
				}
			});
		});

	});

	// 操作状态 开启
	$(".js-start").live("click", function(e){
		var self = $(this);
		var yid = self.closest("td").data("id");

		button_box($(this), e, 'left', 'confirm', '开始活动后无法编辑<br />确定开始吗？', function(){
			$.post(yousetdiscount_operate_url, { type:"start", yid:yid }, function (result) {
				close_button_box();
				if (result.err_code == 0) {
					layer_tips(0, "操作完成");
					load_page('.app__content', load_url, {page : "list", "type" : action, "p" : page}, '');
				} else {
					layer_tips(1, result.err_msg);
				}
			});
		});

	});

	// 操作状态 删除
	$(".js-delete").live("click", function(e){
		var self = $(this);
		var yid = self.closest("td").data("id");

		button_box($(this), e, 'left', 'confirm', '删除之后无法恢复<br />确认删除该优惠接力活动吗？', function(){
			$.post(yousetdiscount_operate_url, { type:"del", yid:yid }, function (result) {
				close_button_box();
				if (result.err_code == 0) {
					layer_tips(0, "操作完成");
					load_page('.app__content', load_url, {page : "list", "type" : action, "p" : page}, '');
				} else {
					layer_tips(1, result.err_msg);
				}
			});
		});

	});

	// 预览浮层
	$(".js_show_ewm").live("click",function(e) {
		event.stopPropagation();
		var dom = $(this);
		var dom_offset = dom.offset();
		
		var id = dom.data("id");
		var store_id = dom.data("store_id");
		var qrcode_url = yousetdiscount_qrcode_url + "&id=" + id + "&store_id=" + store_id;
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

});