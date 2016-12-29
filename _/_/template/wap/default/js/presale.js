	$(function(){
		$(".pre_button").click(function(){

			
		})
		
		$('.sale_but').click(function(){
			
			var pre_type = $(this).data("type");
			if(pre_type == 'unstart') {
				//预售尚未开启
				motify.log('预售尚未开启');
				return;
			}
			
			if(pre_type == 'end') {
				//预售已结束
				motify.log('预定已截止');
				return;
			}
			
			if(pre_type == 'unsoldout') {
				//仓库中无此商品
				motify.log('仓库中无此商品');
				return;
			}
			
			if(pre_type == 'unquantity') {
				//商品无库存
				motify.log('商品无库存');
				return;
			}
			
			
			if (!is_logistics && !is_selffetch) {

				motify.log('商家未设置配送方式，暂时不能购买');
				return;
			}
			var nowDom = $(this);
			if(nowDom.attr('disabled')){
				motify.log('提交中,请稍等..');
				return false;
			}
			nowDom.attr('disabled',true).html('<i></i>正在提交中');
	
			skuBuy(product_id,5,function(){
				nowDom.attr('disabled',false).html('<i></i>预订');
			});

		})
		
		$(".js-open-share").click(function () {
			$("#js_share_guide").removeClass("hide");
		});
		
		$(".js-close-guide").live("click",function () {
			$("#js_share_guide").addClass("hide");
			return;
		});


		//ajax	
		$(".activity_title li").click(function(){
			var li_index = $(".activity_title li").index($(this));
			if(li_index == 1) {
				//加载预售订单
				var page = $(".order_list").data("page");
				//alert(page);
				//return page;
				if($(".order_list").attr("next") != "false") {
					getBuyHistory(page)
				}
			}
		})
		
	// 滚动显示评论
	$(window).scroll(function(){		
		//return;
		if($(".activity_title li").eq(1).is(":visible") == true) {
			if($(".order_list").attr("next") == "false") {
				return false;
			}
			if ($(window).scrollTop()/($('body').height() -$(window).height()) >= 0.95) {
			
				var page = $(".order_list").data("page");
				getBuyHistory(page);
			}
		}
		
	})
		//加载预售订单
		function getBuyHistory(page) {
			//$(".js-buy_history").find(".noData").show();
			if(!presale_id) {
				return false;
			}
			
			//$(".js-buy_history").find(".noData").html("努力加载中！");
			//$(".js-buy_history").find(".noData").show();
			
			var url = "presale.php?id=" + presale_id + "&action=order&page=" + page ;
			$.get(url, function (result) {
				//console.log(result.err_msg);return;
				var html = "";
				var comments_index='';

				for(var i in result.err_msg.list){
					var orders = result.err_msg.list[i];
					var nickname = "";
					html += '<tr>';
					html +=	'	<td width="33.3%" class="clearfix"><img src="'+orders.avatar+'">';
					html += '		<h5>'+orders.nickname+'</h5>';
					html += '	</td>';
					html += '	<td  width="22.3%">￥'+presale_price+'</td>';
					var dateline = new Date((orders.add_time)*1000);
					html += '	<td    width="38.3%">'+formatDate(dateline,'all')+'</td>';	
					html += '</tr>';
				}
				
				page = parseInt(page) + 1;
				$(".noData").hide();
				$(".order_list").append(html);
				$(".order_list").data("type", "value");
				$(".order_list").data("page", page);

				if (result.err_msg.noNextPage) {
					$(".noData").html("已无更多预订记录！");
					$(".noData").show();
					$(".order_list").attr("next", "false");
				}
				
				load_buy_history = false;
			});
		}	
		
		function formatDate(now,type)   {
			var year=now.getFullYear();
			var month=now.getMonth()+1;
			var date=now.getDate();
			var hour=now.getHours();
			var minute=now.getMinutes();
			var second=now.getSeconds();
			if(type  == 'all') {
				if(second <10) {
					second = '0'+second;
				} 
				if(hour <10) {
					hour = '0'+hour;
				} 
				if(minute <10) {
					minute = '0'+minute;
				} 
				if(date <10) {
					date = '0'+date;
				} 
				if(month <10) {
					month = '0'+month;
				} 				
				return year + "-" + month + "-" + date +" "+hour+":"+minute+":"+second;
			} else {
				return year + "." + month + "." + date;
			}
		}
	});