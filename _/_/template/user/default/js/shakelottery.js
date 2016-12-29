/**
 * Created by ediancha on 2016/8/9.
 */
function location_page(mark, page){
	var mark_arr = mark.split('/');
	// console.log(mark_arr);
	switch(mark_arr[0]){
		case '#create': // 添加项目
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
				window.location='#lottery_list';
			}
			break;
		case "#lottery_list":
			load_page('.app__content', load_url,{page:'lottery_list', type:mark_arr[1],"p" : page},'');
			break;
		case "#recordlist":
			var length  = mark_arr.length;
			switch (length){
				case 1:
					layer.alert('非法访问！');
					window.location.hash = '#lottery_list';
					break;
				case 2:
					load_page('.app__content', load_url,{page:'recordlist', id : mark_arr[1], p : page},'');
					break;
				case 3:
					load_page('.app__content', load_url,{page:'recordlist', id : mark_arr[1],type:mark_arr[2], p : page},'');
					break;
			}
			break;
		case "#prizelist":
			if(mark_arr[1]){
				load_page('.app__content', load_url,{page:'prizelist', id : mark_arr[1], "p" : page},'');
			}else{
				layer.alert('非法访问！');
				window.location.hash = '#lottery_list';
			}
			break;
		case "#addprize_good":
			if(mark_arr[1]){
				load_page('.app__content', load_url,{page:'addprize_good', id : mark_arr[1], "p" : page},'',function(){
					init_create();
				});
			}else{
				layer.alert('非法访问！');
				window.location.hash = '#lottery_list';
			}
			break;
		case "#addprize_fictitiou":
			if(mark_arr[1]){
				load_page('.app__content', load_url,{page:'addprize_fictitiou', id : mark_arr[1], "p" : page},'',function(){
					init_create();
				});
			}else{
				layer.alert('非法访问！');
				window.location.hash = '#lottery_list';
			}
			break;
		case "#editprize_good":
			if(mark_arr[1]){
				load_page('.app__content', load_url,{page:'editprize_good', id : mark_arr[1], "p" : page},'',function(){
					init_create();
				});
			}else{
				layer.alert('非法访问！');
				window.location.hash = '#lottery_list';
			}
			break;
		case "#editprize_fictitiou":
			if(mark_arr[1]){
				load_page('.app__content', load_url,{page:'editprize_fictitiou', id : mark_arr[1], "p" : page},'',function(){
					init_create();
				});
			}else{
				layer.alert('非法访问！');
				window.location.hash = '#lottery_list';
			}
			break;
		case "#edit_record" : 	// 修改奖品记录
			if(mark_arr[1]){
				load_page('.app__content', load_url,{page:'edit_record', id : mark_arr[1], "p" : page},'',function(){
					init_create();
				});
			}else{
				layer.alert('非法访问！');
				window.location.hash = '#lottery_list';
			}
			break;
		case "#on" : 	// 进行中
			action = "on";
			load_page('.app__content', load_url, {page : "wzc_list", "type" : action, "p" : page}, '');
			break;
		case "#end" : 	// 已结束
			action = "end";
			load_page('.app__content', load_url, {page : "wzc_list", "type" : action, "p" : page}, '');
			break;
		case "#order_info" : 	// 订单信息
			if(mark_arr[1]){
				load_page('.app__content', load_url,{page:'order_info', id : mark_arr[1], "p" : page},'');
			}else{
				layer.alert('非法访问！');
				window.location.hash = '#lottery_list';
			}
			break;
		default :
			action = "all"; 	// 所有
			load_page('.app__content', load_url, {page : "wzc_list", "type" : action, "p" : page}, '');
	}
}


$(function(){
	var hash=window.location.hash;
	// console.log(hash);
	(hash!=null && hash!='')  ? location_page(location.hash) : load_page('.app__content', load_url, {page:'lottery_list'}, '');
	$(window).bind('hashchange', function() {
		(window.location.hash!=null && window.location.hash!='')  ? location_page(window.location.hash,1) : load_page('.app__content', load_url, {page:'lottery_list'}, '');
	})
	var action;
	var page;
	function init_create () {
		widget_link_box($(".js-add-picture"), "store_goods_by_sku", function (result) {
			var  good_data = pic_list;
			$('.js-goods-list .sort').remove();
			for (var i in result) {
				item = result[i];
				var pic_list = "";
				var list_size = $('.js-product .sort').size();
				if(list_size > 0){
					layer_tips(1, '只能添加一个产品！');
					return false;
				}

				$(".js-product").prepend('<li class="sort" data-pid="' + item.product_id + '" data-skuid="' + item.sku_id + '"><a href="' + item.url + '" target="_blank"><img data-pid="' + item.product_id + '" alt="' + item.title + '" title="' + item.title + '" src="' + item.image + '"></a><a class="js-delete-picture close-modal small hide">×</a></li>');
				$(".sku").show();
				$(".js-product").data("product_id", item.product_id);
				$("input[name=product_id]").val(item.product_id);
				$("input[name=prizename]").val(item.title);
				$("input[name=sku_id]").val(item.sku_id);
				$("input[name=skunub]").val(item.quantity);
				$("input[name=prizeimg]").val(item.image);
				$(".js-add-picture").parent().hide();
				// console.log(item);
			}
		});
	}

	$(".js-list-filter-region a").live('click', function () {
		var action = $(this).attr("href");
		window.location=action;
	});
	$(".js-edit-repay").live('click', function () {
		var action = $(this).attr("href");
		window.location=action;
	});
	// 摇一摇抽奖分页
	$(".js-list_page a").live("click", function () {
		var page = $(this).data("page-num");
		location_page('#lottery_list', page);
	});

	// 奖品列表分页
	$(".js-list_page_prize a").live("click", function () {
		var page = $(this).data("page-num");
		location_page(window.location.hash, page);
	});
	// 摇奖记录分页
	$(".js-list_page_record a").live("click", function () {
		var page = $(this).data("page-num");
		location_page(window.location.hash, page);
	});


	// 开始项目
	$(".js-start-link").live("click",function(){
		var product_id=$(this).attr("data-id");
		$.post(wzc_start_url,{product_id:product_id},function(sta){
			if(sta.err_code==0){
				window.location=index_url;
				layer_tips(0, sta.err_msg);
			}else{
				layer_tips(1, sta.err_msg);
			}
		})
	})
	// 店铺积分玩法
	$("input[name=integral_status]").live("click",function(){
		var value = $("input[name=integral_status]:checked").val();
		value=='1' ? $("#integral_use").show(400) : $("#integral_use").hide(400);
	})

	// 取消项目
	$(".js-btn-quit").live("click", function () {
		location.href = index_url;
	});
	// 取消奖品
	$(".js-btn-quit-prize").live("click", function () {
		var aid = $("input[name=aid]").val();
		window.location='#prizelist/'+aid;
	});
	// 返回记录列表页
	$(".js-btn-quit-record").live("click", function () {
		var aid = $("#aid").val();
		location.href = '#recordlist/'+aid;
	});
	// 活动 新增修改
	$(".js-create-save").live("click", function () {
		var to = $(this).attr("to");
		var post_url = pro_update_url;
		var product_id = $("#product_id").val();
		var action_name = $("#action_name").val();//活动名称
		var action_desc = uf.getContent();//活动简介
		var custom_sharetitle = $("#custom_sharetitle").val();  //自定义分享标题
		var custom_sharedsc = $("#custom_sharedsc").val();  //自定义分享描述
		var follow_msg = $("#follow_msg").val(); //未关注默认提示语
		var follow_btn_msg =$("#follow_btn_msg").val();//引导关注按钮提示语
		var custom_follow_url = $("#custom_follow_url").val();//快捷关注链接
		var register_msg = $.trim($("#register_msg").val());//需要粉丝手机号提示语
		var starttime = $.trim($("#starttime").val());
		var endtime = $.trim($("#endtime").val());
		var totaltimes = parseInt($("#totaltimes").val());//每人总摇奖次数
		var everydaytimes=parseInt($("#everydaytimes").val()); //每人每天摇奖次数
		var join_number = parseInt($("#join_number").val()); //预计参与人数
		var timespan  = $("#timespan").val(); //每人每次中奖时间间隔
		var record_nums = $("#record_nums").val();//获奖记录显示条数
		var is_limitwin = $("#is_limitwin").val();//限制每人每天中奖次数
		var remind_word = $("#remind_word").val();//广告提示语
		var remind_link=$("#remind_link").val();//广告链接
		var is_amount = $("input[name=is_amount]:checked").val(); //手机端是否显示奖品数量
		var status = $("input[name=status]:checked").val();  //活动状态
		var reply_pic = $("#reply_pic").val();//自定义分享图片
		var integral_status=$("input[name=integral_status]:checked").val();//是否开启店铺积分玩法
		var integral_nub = integral_status=='1' ? $("#integral_nub").val() : '0';
		if (action_name == '') {
			layer.msg("请填写活动名称");
			return false;
		}
		if (remind_word == '') {
			layer.msg("请填写广告提示语");
			return false;
		}
		if (remind_link == '') {
			layer.msg("请填写广告链接");
			return false;
		}
		if (totaltimes == '' || totaltimes<1) {
			layer.msg("请填写每人总摇奖次数,并且大于0");
			return false;
		}
		if (everydaytimes == '' || everydaytimes>=totaltimes) {
			layer.msg("请填写每人每天摇奖次数,并且小于总摇奖次数");
			return false;
		}
		if (join_number == '' || join_number<1) {
			layer.msg("请填写预计参与人数");
			return false;
		}
		if(starttime==''){
			layer.msg("请填写开始时间");
			return false;
		}
		if(endtime==''){
			layer.msg("请填写结束时间");
			return false;
		}
		var data = {
			product_id:product_id,
			action_name:action_name,
			action_desc:action_desc,
			custom_sharetitle:custom_sharetitle,
			custom_sharedsc:custom_sharedsc,
			follow_msg:follow_msg,
			follow_btn_msg:follow_btn_msg,
			custom_follow_url:custom_follow_url,
			register_msg:register_msg,
			starttime:starttime,
			endtime:endtime,
			totaltimes:totaltimes,
			everydaytimes:everydaytimes,
			join_number:join_number,
			timespan:timespan,
			record_nums:record_nums,
			is_limitwin:is_limitwin,
			remind_word:remind_word,
			remind_link:remind_link,
			is_amount:is_amount,
			reply_pic:reply_pic,
			integral_status:integral_status,
			integral_nub:integral_nub,
			status:status
		};
		$.post(post_url, data, function (result) {
			if (result.err_code == 0) {
				layer_tips(0, "保存成功");
				if(to=='true'){
					var aid=result.err_msg;
					window.location = index_url+'#prizelist/'+aid;
				}else{
					window.location = index_url;
				}
			} else {
				layer_tips(1, result.err_msg);
			}
		});
	});
	// 领奖记录保存
	$(".js-create-save-record").live("click",function(){
		var isaccept = $("input[name=isaccept]:checked").val();
		var recordid = $("#recordid").val();
		var aid      = $("#aid").val();
		$.post('?c=shakelottery&a=record_post_edit',{recordid:recordid,isaccept:isaccept},function(result){
                        if(result.err_code==0){
                            	layer_tips(0, "保存成功");
                            	window.location="#recordlist/"+aid;
                        }else{
                            layer.alert(result.err_msg);
                        }
		},'json');
	})
	// 实物奖品设置保存
	$(".js-create-save-good").live("click",function(){
		var prize_types = 1;
		var product_id = $("input[name=product_id]").val();
		var prizenum = parseInt($("input[name=prizenum]").val());
		var skunub = parseInt($("input[name=skunub]").val());
		var prizeimg = $("input[name=prizeimg]").val();
		var expendnum = parseInt(  $("input[name=expendnum]").val()  );//奖品消耗数量
		if(product_id<1){
			layer.alert('请选择商品作为奖品');
			return false;
		}
		if(prizenum==undefined || prizenum<1 ){
			layer.alert('请输入奖品数量，且大于0');
			return false;
		}
		if(prizenum>skunub){
			layer.alert('奖品数量不能超过库存数量');
			return false;
		}
		var post_url = set_product_url;
		var prizename = $("#prizename").val();
		var sku_id = $("input[name=sku_id]").val();
		var aid = $("input[name=aid]").val();
		var prize_id =  $("input[name=prize_id]").val();
		if(prize_id!=0){
			if(prizenum<expendnum){
				layer.alert('奖品数量必须大于等于奖品消耗数量');
				return false;
			}
		}
		var data={
			prize_type:prize_types,
			prize_id:prize_id,
			aid:aid,
			product_id:product_id,
			sku_id:sku_id,
			prizename: prizename,
			prizenum:prizenum,
			prizeimg:prizeimg
		};
		$.post(post_url,data,function(result){
                        if(result.err_code==0){
                            	layer_tips(0, "保存成功");
                            	window.location="#prizelist/"+aid;
                        }else{
                            layer.alert(result.err_msg);
                        }
		},'json');
	})
	// 虚拟奖品类型变化
	$("#prize_types").live("change",function(){
		var prize_types=$("#prize_types").val();
		if(prize_types==0){
			$("#coupon_select").hide(400);
			$("#integral_write").hide(400);
			$("#expendnum").hide(400);
			$("input[name=ku]").val(0);
			$(".ku-fictitiou").hide(400);
			$("#coupon_value").val(0);
			return;
		}
		if(prize_types==2){
			$("#coupon_select").show();
			$("#integral_write").hide();
			return;
		}
		if(prize_types==3){
			$("#integral_write").show();
			$("#coupon_select").hide();
			$(".coupon").hide(400);
			$("#coupon_value").val(0);
			return;
		}
	})
	// 优惠券类型修改
	$("#coupon_value").live("change",function(){
		var coupon_value=parseInt($("#coupon_value").val());
		var sku_nub = $("#coupon_value").find("option:selected").attr("ku");
		if(coupon_value!=0){
			$(".coupon").show(400);
			$("input[name=ku]").val(sku_nub);
		}else{
			$(".coupon").hide(400);
			$("input[name=ku]").val(0);
		}
	})
	// 虚拟奖品设置保存
	$(".js-create-save-fictitiou").live("click",function(){
		var post_url = set_product_url;
		var prize_types = parseInt($("#prize_types").val());
		var prizenum = parseInt($("input[name=prizenum]").val());
		var sku_id = parseInt($("input[name=sku_id]").val());
		var aid = parseInt($("input[name=aid]").val());
		var prize_id =  parseInt($("input[name=prize_id]").val());
		var prize_types = parseInt($("#prize_types").val());
		var coupon_value = parseInt($("#coupon_value").val());
		var integral = $("#integral").val();
		var prizename = '';
		var value = '';
		var expendnum = parseInt(  $("input[name=expendnum]").val()  );//奖品消耗数量
		if(prize_types<1){
			layer.alert('请选择虚拟奖品类型');
			return false;
		}
		if(prizenum==undefined || prizenum<1 ){
			layer.alert('请输入奖品数量，且大于0');
			return false;
		}
		if(prize_types==2){//优惠券
			if(prize_id!=0 && prizenum<expendnum){
				layer.alert('奖品数量必须大于等于奖品消耗数量');
				return false;
			}
			var ku = $("input[name=ku]").val();
			if(prizenum>ku){
				layer.alert('奖品数量不能大于库存数量');
				return false;
			}
			if(coupon_value==0){
				layer.alert('请选择优惠券');
				return false;
			}
			prizename=$.trim($("#coupon_value").find("option:selected").text());
			value = 1;
			prizename = prizename+'1张';
		}
		if(prize_types==3){//积分
			if(integral=='' || integral==undefined || integral==null || integral=='0' ){
				layer.alert('请填写店铺积分');
				return false;
			}
			value=integral;
			prizename="店铺积分"+value+"分";
		}
		if(prizename=='' || value==''){
			layer.alert('异常错误，请刷新后重试');
			return false;
		}
		var data={
			value:value,
			product_id:coupon_value,
			prize_type:prize_types,
			prize_id:prize_id,
			aid:aid,
			sku_id:sku_id,
			prizename: prizename,
			prizenum:prizenum
		};
		$.post(post_url,data,function(result){
			// console.log(result);
                        if(result.err_code==0){
                            	layer_tips(0, "保存成功");
                            	window.location="#prizelist/"+aid;
                        }else{
                            layer.alert(result.err_msg);
                        }
		},'json');
	})
	// 删除项目
	$(".js-delete").live("click",function(){
		var active_id= $(this).closest("td").data("product_id");
		var url='?c=shakelottery&a=del_active&id='+active_id;
		$.get(url,function(sta){
			if(sta.err_code==0){
				layer_tips(0, "操作完成");
				window.location=index_url;
			}else{
				layer_tips(1, sta.err_msg);
			}
		})
	})

	// 删除抽奖记录
	$(".js-delete-record").live("click", function(e){
		var recordid = $(this).closest("td").data("product_id");
		var url = '?c=shakelottery&a=del_record&recordid='+recordid;
		var active_id = $("#activeid").val();
		var type = $("#type").val();
		button_box($(this), e, 'left', 'confirm', '删除之后无法恢复<br />确认删除该项目活动吗？', function(){
			$.get(url, function (result) {
				close_button_box();
				if (result.err_code == 0) {
					layer_tips(0, "操作完成");
					load_page('.app__content', load_url, {page : "recordlist", "id" : active_id, "type":type,p : 1}, '');
				} else {
					layer_tips(1, result.err_msg);
				}
			});
		});

	});
	// 删除奖品
	$(".js-delete-good").live("click",function(){
		var goodid=$(this).attr("goodId");
		var active_id= $("#active_id").val();
		var url='#prizelist/'+active_id;
		$.post(good_del_url,{goodid:goodid},function(sta){
			if(sta.err_code==0){
				layer_tips(0, "操作完成");
				load_page('.app__content', load_url, {page : "prizelist", "id" : active_id, "p" : 1}, '');
			}else{
				layer_tips(1, sta.err_msg);
			}
		})
	})

	// 复制链接
	$(".js-copy-link").live("click", function (e) {
		var product_id = $(this).closest("td").data("product_id");
		if(product_id>0){
			button_box($(this),e,'left','copy', wap_url+'?id='+product_id, function(){
				layer_tips(0,'复制成功');
			});
		}else{
			layer_tips(0,'复制失败');
		}
	});

	// 编辑项目
	$(".js-edit").live("click", function () {
		if($(this).attr('href') && $(this).attr('href').substr(0, 1) == '#') {
			window.location=$(this).attr('href');
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
		$("input[name=reply_pic]").val('');

	});

	// 添加分享图片
	$(".js-add-logo").live('click', function(){
		var self = $(this);
		var className=$(this).attr("className");
		upload_pic_box(1,true,function(pic_list){
			// console
			if (pic_list.length == 0) {
				layer_tips(1, "请先上传图片");
				return false;
			}
			if (pic_list.length > 0) {
			    for (var i in pic_list) {
			        self.parents("ul:first").prepend('<li class="sort"><a href="javascript:void(0)" target="_blank"><img src="'+pic_list[i]+'"></a><a class="js-delete-picture close-modal small hide">×</a></li>');
			        $("#"+className).val(pic_list[i]);
			        self.parent().hide();
			    }
			}

        	},1);
    	});



	// 点击预览
	$(".js_show").live("click",function(e) {
		event.stopPropagation();
		var dom = $(this);
		var dom_offset = dom.offset();
		var qrcode_url=$(this).attr("url");
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

	// 查看订单状态
	$(".look_order").live("click",function(e){
		window.location="#"
	})
})
