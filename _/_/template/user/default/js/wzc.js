/**
 * Created by ediancha on 2016/8/9.
 */
function location_page(mark, page){
	var mark_arr = mark.split('/');
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
				window.location='#list';
				location_page('');
			}
			break;
		case '#create_repay': // 添加回报设置
			load_page('.app__content', load_url, {page : "create_repay",id:mark_arr[1]}, '', function(){
				init_create();
			});
			break;
		case '#edit_repay': // 添加回报设置
			load_page('.app__content', load_url, {page : "edit_repay",id:mark_arr[1]}, '', function(){
				init_create();
			});
			break;
		case "#repaylist":
			if(mark_arr[1]){
				load_page('.app__content', load_url,{page:'repaylist', id : mark_arr[1], "p" : page},'');
			}else{
				layer.alert('非法访问！');
				window.location.hash = '#repaylist';
				location_page('');
			}
			break;
		case "#future" : 	// 未开始
			action = "future";
			load_page('.app__content', load_url, {page : "wzc_list", "type" : action, "p" : page}, '');
			break;
		case "#on" : 	// 进行中
			action = "on";
			load_page('.app__content', load_url, {page : "wzc_list", "type" : action, "p" : page}, '');
			break;
		case "#end" : 	// 已结束
			action = "end";
			load_page('.app__content', load_url, {page : "wzc_list", "type" : action, "p" : page}, '');
			break;
		case "#apply" : 	// 申请中
			action = "apply";
			load_page('.app__content', load_url, {page : "wzc_list", "type" : action, "p" : page}, '');
			break;
		default :
			action = "all"; 	// 所有
			load_page('.app__content', load_url, {page : "wzc_list", "type" : action, "p" : page}, '');
	}
}
var tagSize =28;
function changetag(tid, index) {
	var selectedSize = 0;
	if ($("#choosetag_" + index).val() != null && $("#choosetag_" + index).val() != "") {
	    $("#choosetag_" + index).val("");
	    $("#tagId_" + index).removeClass("cur");
	} else {
	    for (var i = 1; i <= tagSize; i++) {
	        if ($("#choosetag_" + i).val() != null && $("#choosetag_" + i).val() != "") {
	            selectedSize++;
	        }
	    }
	    if (selectedSize >= 3) {
	        layer.alert('最多选择三个');
	        return;
	    }
	    $("#tagId_" + index).addClass("cur");
	    $("#choosetag_" + index).val(tid);
	}
}




$(function(){
	var hash=window.location.hash;
	(hash!=null && hash!='')  ? location_page(location.hash) : load_page('.app__content', load_url, {page:'wzc_list'}, '');
	$(window).bind('hashchange', function() {
		location_page(window.location.hash,1);
	})
	// 添加众筹
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
					layer_tips(1, '只能添加一张图片！');
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
	}

	$(".js-list-filter-region a").live('click', function () {
		var action = $(this).attr("href");
		window.location=action;
	});
	$(".js-edit-repay").live('click', function () {
		var action = $(this).attr("href");
		window.location=action;
	});
	// 众筹项目分页
	$(".js-list_page a").live("click", function () {
		var page = $(this).data("page-num");
		location_page(window.location.hash, page);
	});

	// // 回报设置分页
	$(".js-repay_page a").live("click", function () {
		var page = $(this).data("page-num");
		location_page(window.location.hash, page);
	});


	// 开始项目路演
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
	// 开始项目筹资
	$(".js-start-collect").live("click",function(){
		var product_id=$(this).attr("data-id");
		$.post(wzc_start_collect_url,{product_id:product_id},function(sta){
			if(sta.err_code==0){
				window.location=index_url;
				layer_tips(0, sta.err_msg);
			}else{
				layer_tips(1, sta.err_msg);
			}
		})
	})

	// 取消项目
	$(".js-btn-quit").live("click", function () {
		location.href = index_url;
	});
	// 取消回报设置
	$(".js-btn-quit-repay").live("click", function () {
		var action = $(this).attr("url");
		window.location=action;
	});

	// 添加/修改
	$(".js-create-save").live("click", function () {
		var toNext=$(this).attr("to");
		var post_url = pro_update_url;
		var product_id = $("#product_id").val().length>0 ? $("#product_id").val() : 0;
		var productType = $("input[name=productType]:checked").val();
		// var selectClass = $("#selectClass").val();
		var productName = $.trim($("#productName").val());
		var productAdWord = $.trim($("#productAdWord").val());
		var amount = $.trim($("#amount").val());
		var toplimit = $.trim($("#toplimit").val());
		var raiseType= $("input[name=raiseType]:checked").val();
		var collectDays=$.trim($("#collectDays").val());
		var productThumImage = $("#productThumImage").val();
		var productListImg  = $("#productListImg").val();
		var productFirstImg = $("#productFirstImg").val();
		var productImage = $("#productImage").val();
		var productImageMobile = $("#productImageMobile").val();
		var productSummary=$("#productSummary").val();
		var videoAddr = $("#videoAddr").val();
		var introduce = $("#introduce").val();
		var sponsorDetails = $("#sponsorDetails").val();
		var weiBo = $("#weiBo").val();
		var thankMess = $("#thankMess").val();
		var sponsorPhone = $("#sponsorPhone").val();
		var productDetails = uf.getContent();
		var laber='';
		// console.log(selectClass);
		$.each($(".choosetag"),function(i,v){
			if($(this).val()!=null && $(this).val()!='' ){
				laber = laber+$(this).val()+',';
			}
		})
		if(laber!=''){
			laber=laber.substring(0,laber.length-1);
		}
		// if(selectClass==0){
		// 	layer.msg("请选择分类");
		// 	return false;
		// }
		if (productName == '') {
			layer.msg("请填写项目名称");
			return false;
		}
		if (productAdWord == '') {
			layer.msg("请填写简单的一句话说明");
			return false;
		}
		// 筹资类型
		if($("#radNormal").attr("checked")=='checked'){
			if (amount == '') {
			    layer.msg("请填写筹资金额");
			    return false;
			}
			if (toplimit == '') {
			    layer.msg("请填写筹资上限");
			    return false;
			}
			if (collectDays == '' || collectDays < 1) {
			    layer.msg("请填写筹资天数，并且大于0天");
			    return false;
			}
		}else{
			$("#amount").val('');
			$("#toplimit").val('');
		}
		if(productThumImage==''){
			layer.msg("请上传预热图片");
			return false;
		}
		if(productListImg==''){
			layer.msg("请上传列表页图片");
			return false;
		}
		if(productFirstImg==''){
			layer.msg("请上传首页图片");
			return false;
		}
		if(productImage==''){
			layer.msg("请上传项目图片");
			return false;
		}
		if(productImageMobile==''){
			layer.msg("请上传移动端图片");
			return false;
		}
		if(productSummary==''){
			layer.msg("请填写项目简介");
			return false;
		}
		if(productDetails==''){
			layer.msg("请填写项目详情");
			return false;
		}
		if(introduce==''){
			layer.msg("请填写自我介绍");
			return false;
		}
		if(sponsorDetails==''){
			layer.msg("请填写详细自我介绍");
			return false;
		}
		if(thankMess==''){
			layer.msg("请填写感谢信");
			return false;
		}
		if(sponsorPhone==''){
			layer.msg("请填写联系电话");
			return false;
		}
		var data = {
			label:laber,
			productType:productType,
			// class:selectClass,
			productName:productName,
			productAdWord:productAdWord,
			amount:amount,
			toplimit:toplimit,
			raiseType:raiseType,
			collectDays:collectDays,
			productThumImage:productThumImage,
			productListImg:productListImg,
			productFirstImg:productFirstImg,
			productImage:productImage,
			productImageMobile:productImageMobile,
			productSummary:productSummary,
			videoAddr:videoAddr,
			introduce:introduce,
			sponsorDetails:sponsorDetails,
			weiBo:weiBo,
			thankMess:thankMess,
			sponsorPhone:sponsorPhone,
			productDetails:productDetails,
			product_id:product_id
		};
		$.post(post_url, data, function (result) {
			if (result.err_code == 0) {
				layer_tips(0, "保存成功");
				if(toNext=='true'){
					var action='#create_repay/'+result.err_msg;
					window.location = action;
					// load_page('.app__content', load_url, {page : "create_repay", "id" : result.err_msg, "p" : 1}, '');
				}else{
					window.location = index_url;
				}
			} else {
				layer_tips(1, result.err_msg);
			}
		});
	});
	// 回报设置保存
	$(".js-create-save-repay,.js-create-save-repay-to").live("click",function(){
		var raffleType=$("input[name=raffleType]:checked").val();
		if(checkRepay()==true){
			var post_url = repay_update_url;
			var optType  = $("#optType").val();
			var repay_id = $("#repay_id").val();
			var proId=$(this).attr("proId");
			var toNext=$(this).attr("to");
			var redoundType=$("input[name=redoundType]").val();
			var amount=$("#amount").val();
			var mamount=$("#mamount").val();
			var redoundContent=$("#redoundContent").val();
			var raffleType=$("input[name=raffleType]:checked").val();
			var platform = $("input[name=platform]").val();//回报档位
			var redoundDays=$("#redoundDays").val();
			var images=$("#images").val();
			var limits         = $("#limits").val();
			var freight        = $("#freight").val();
			var invoiceStatus  = $("input[name=invoiceStatus]:checked").val();
	                var remarkStatus   = $("input[name=remarkStatus]:checked").val();
	                var remark         = $("#remark").val().trim();
	                var raffleRule     = $("input[name=raffleRule]:checked").val();
	                var raffleBase     = $("#raffleBase").val();
	                var luckyCount     = $("#luckyCount").val();
	                var raffleReword   = $("#raffleReword").val();//抽奖规则1的奖品
	                var luckyReword    = $("#luckyReword").val();//抽奖规则2的奖品
	                var scrambleStatus = $("input[name=scrambleStatus]:checked").val();
	                var link=$(this).attr("url");
			var data={
				product_id:proId,
				repay_id:repay_id,
				optType: optType,
				redoundType:redoundType,
				amount:amount,
				mamount:mamount,
				redoundContent:redoundContent,
				raffleType:raffleType,
				platform:platform,
				redoundDays:redoundDays,
				images:images,
				limits:limits,
				freight:freight,
				invoiceStatus:invoiceStatus,
				remarkStatus:remarkStatus,
				remark:remark,
				raffleRule:raffleRule,
				raffleBase:raffleBase,
				luckyCount:luckyCount,
				raffleReword:raffleReword,
				luckyReword:luckyReword,
				scrambleStatus:scrambleStatus
			};
			$.post(post_url,data,function(result){
	                        if(result.err_code==0){
	                            	layer_tips(0, "保存成功");
	                            	if(toNext=='true'){
	                            		location_page(link, 1);
	                            	}else{
	                            		window.location=link;
	                            	}
	                        }else{
	                            layer.alert(result.err_msg);
	                        }
			},'json');
		}
	})

	// 检查回报设置填写
	function checkRepay(){
		var redoundType=$("input[name=redoundType]:checked").val();
		var amount=$("#amount").val();
		var mamount=$("#mamount").val();
		var redoundContent=$("#redoundContent").val();
		var raffleType=$("input[name=raffleType]:checked").val();
		var platform = $("input[name=platform]:checked").val();//回报档位
		var redoundDays=$("#redoundDays").val();
		var images = $("#images").val();
		switch (platform){
			case '0':
				if(amount==0||amount==''||amount==undefined){
					layer.alert("支持金额不能为0");
					return false;
				}
				break;
			case '2':
				if(mamount==0||mamount==''||mamount==undefined){
					layer.alert( "手机端金额不能为0");
					return false;
				}
				break;
			case '1':
				if(amount==0||amount==''||amount==undefined){
					layer.alert( "支持金额不能为0");
					return false;
				}
				if(mamount==0||mamount==''||mamount==undefined){
					layer.alert( "手机端金额不能为0");
					return false;
				}
				break;
		}
		if(redoundContent=='' || redoundContent==undefined){
			layer.alert("回报内容不能为空");
			return false;
		}
		if(redoundDays<1 || redoundDays=='' || redoundDays==undefined){
			layer.alert("回报时间小于最低值");
			return false;
		}
		if(images=='' || images==undefined){
			layer.alert("请上传600*600的说明图片");
			return false;
		}else{
			var img=new Image();
			img.src=images;
			var width='600';
			var height='600';
			if(img.width!=width || img.height!=height){
				layer.alert("请上传600*600的说明图片");
				return false;
			}
		}
		return true;
	}

	// 操作状态 删除
	$(".js-delete").live("click", function(e){
		var self = $(this);
		var product_id = self.closest("td").data("product_id");
		button_box($(this), e, 'left', 'confirm', '删除之后无法恢复<br />确认删除该项目活动吗？', function(){
			$.post(wzc_del_url, { product_id:product_id }, function (result) {
				close_button_box();
				if (result.err_code == 0) {
					layer_tips(0, "操作完成");
					var action='#wzc_list';
					window.location=action;
				} else {
					layer_tips(1, result.err_msg);
				}
			});
		});

	});
	// 删除回报设置
	$(".js-delete-repay").live("click",function(){
		var repayId=$(this).attr("repayId");
		var product_id= $("#product_id").val();
		var url=repaylist_url+product_id;
		$.post(repay_del_url,{repayId:repayId},function(sta){
			if(sta.err_code==0){
				layer_tips(0, "操作完成");
				load_page('.app__content', load_url, {page : "repaylist", "id" : product_id, "p" : 1}, '');
			}else{
				layer_tips(1, sta.err_msg);
			}
		})
	})

	// 复制链接
	$(".js-copy-link").live("click", function (e) {
		var product_id = $(this).closest("td").data("product_id");
		if(product_id>0){
			button_box($(this),e,'left','copy', wzc_product_url + product_id, function(){
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
	// 众筹回报设置列表
	$(".js-repay-list").live("click",function(){
		if($(this).attr('href') && $(this).attr('href').substr(0, 1) == '#') {
			window.location=$(this).attr('href');
		}
	})

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

	// 添加预热图片
	$(".js-add-logo,.js-add-logo-list,.js-add-logo-first,.js-add-logo-product,.js-add-logo-web").live('click', function(){
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
			        if(className=='images'){
				        var img=new Image();
				        var width='600';
				        var height='600';
				        img.src=pic_list[i];
				        img.onload=function(){
				        	if(img.width!=width || img.height!=height){
							layer_tips(1, "请上传600*600图片");
				        	}
				        }
			        }
			    }
			}

        	},1);
    	});
	$("#radForever").live('click',function(){
		$("#collectDays").hide(400);
		$("#targetAmount").hide(400);
		$("#productTopLimit").hide(400);
		$("#amount").val('');
		$("#toplimit").val('');
		$("#collectDays").val('');
	})
	$("#radNormal").live('click',function(){
		$("#collectDays").show(400);
		$("#targetAmount").show(400);
		$("#productTopLimit").show(400);
	})
	$("input[name=platform]").live('click',function(){
		var val=$(this).val();
		switch (val){
			case '0':
				$(".amount").show();
				$(".mamount").hide();
				$("#mamount").val(0);
				break;
			case '1':
				$(".amount").show();
				$(".mamount").show();
				break;
			case '2':
				$(".amount").hide();
				$(".mamount").show();
				$("#amount").val(0);
				break;

		}
	})
	$("input[name=raffleType]").live("click",function(){
		var val=$(this).val();
		switch (val){
			case '1':
				$(".guize1").show();
				$(".guize2").show();
				$("#redoundContent").attr("disabled",true);
				break;
			case '0':
				$(".guize1").hide();
				$(".guize2").hide();
				$("#redoundContent").attr("disabled",false);
				break;
		}
	})
	$("#raf1").live("click",function(){
		var buf=$(this).val();
		switch (buf){
			case '1':
				$(".guize1").show();
				$(".guize2").show();
				break;
			case '0':
				$(".guize1").hide();
				$(".guize2").hide();
				break;
		}
	})
	//点击"抽奖规则1"
	$("#rar0").live("click",function(){
		$("#redoundContent").val('');
		$("#luckyCount").attr("disabled", true);
		$("#luckyReword").attr("disabled", true);
		$("#luckyCount").val(0);
		$("#luckyReword").val("");
		$("#raffleBase").attr("disabled", false);
		$("#raffleReword").attr("disabled", false);
	});

	//点击"抽奖规则2"
	$("#rar1").live("click",function(){
		$("#redoundContent").val('');
		$("#luckyCount").attr("disabled", false);
		$("#raffleBase").val(0);
		$("#raffleBase").attr("disabled", true);
		$("#raffleReword").val("");
		$("#raffleReword").attr("disabled", true);
		$("#luckyReword").attr("disabled", false);
	});
	//自动拼接回报内容
	$("#raffleBase,#raffleReword,#luckyCount,#luckyReword").live("blur",function(){
		var content=raffle();
		$("#redoundContent").attr("disabled", true);
		$("#redoundContent").val(content);
	})
    	//自动拼接回报内容
    	function raffle() {
        	var rule = $("input[name='raffleRule']:checked").val();
                if (rule == undefined) {
                    return;
                }
                var str = '';
	        switch (rule) {
	            case "0":
			var raffleBase = $.trim($('#raffleBase').val());
			var raffleReword = $.trim($('#raffleReword').val());
			if (raffleBase != '' && raffleReword != '') {
				str += '每满' + raffleBase + '位支持者抽取1位幸运用户，不满足时也抽取1位。幸运用户将会获得' + raffleReword + '。';
				str += '幸运用户将有由官方抽取，抽奖规则及中奖者名单将在话题区公布。';
			}
	                break;
	            case "1":
			var luckyCount = $.trim($('#luckyCount').val());
			var luckyReword = $.trim($('#luckyReword').val());
			if (luckyCount != '' && luckyReword != '') {
				str += '将从所有支持者中抽取' + luckyCount + '位幸运用户。幸运用户将会获得' + luckyReword + '。';
				str += '幸运用户将有由官方抽取，抽奖规则及中奖者名单将在话题区公布。';
			}
	                break;
	        }
	        return str;
    	}
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

})