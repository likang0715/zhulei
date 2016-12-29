var subtypePage = 1;
var i_index = 1;
var subtypeIsAjax = false;
var subtypeSort = 'default';
var subtypeShowRows = false;
var max_page;
var minute = 1000 * 60;
var hour = minute * 60;
var day = hour * 24;
var halfamonth = day * 15;
var month = day * 30;

$(function(){
	if($('li.block-subtype').size() == 0){
		//$('.empty-list').show();
	}
/*	$('.js-cancel-subtype').click(function(){
		var nowDom = $(this);
		$.post('./subtype.php?del_id='+$(this).data('id'),function(result){
			//motify.log(result.err_msg);
			alert(result.err_msg)
			if(result.err_code == 0){
				nowDom.closest('li').remove();
				if($('li.block-subtype').size() == 0){
					$('.empty-list').show();
				}
			}
		});
	});*/
	
	$(".js-delivery").click(function () {
		var delivery_obj = $(this);
		if (delivery_obj.attr("disabled") == "disabled") {
			return;
		}
		
		if (!confirm("确认已经收到货了？")) {
			return;
		}
		
		var subtype_no = delivery_obj.data("subtype_no");
		delivery_obj.attr("disabled", "disabled");
		var url = "subtype_delivery.php?subtype_no=" + subtype_no;
		$.getJSON(url, function (result) {
			try {
				//motify.log(result.err_msg);
				alert(result.err_msg)
				if (result.err_code == "0") {
					location.reload();
				} else {
					delivery_obj.removeAttr("disabled");
				}
			} catch(e) {
				//motify.log("网络错误");
				alert("网络错误")
				delivery_obj.removeAttr("disabled");
			}
		});
	});
});



$(function(){
	FastClick.attach(document.body);
	$(window).scroll(function(){

		
		if(subtypePage > 1 && $(window).scrollTop()/($('body').height() -$(window).height())>=0.92){

			if(subtypeIsAjax == false){
				if(typeof(max_page) != 'undefined'){
					if(subtypePage <= max_page) {
						
						if($('.wx_loading2').is(":hidden")) {
							getpinlun();
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
		subtypeShowRows = true;
	}

	getpinlun();
	
	function getpinlun(){
		$('.wx_loading2').show();
		$.ajax({
			type:"POST",
			url: page_url,
			data:'page='+subtypePage,	
			dataType:'json',
			success:function(result){
				try {
				$('.wx_loading2').hide();
				if(result.err_code){
					//motify.log(result.err_msg);
				}else{
					if(result.err_msg.list.length > 0){
						///$(".product_bottom").hide();
						if(result.err_msg.count){
							$('#sFound').removeClass('hide').find('#totResult').html(result.err_msg.count);
						}
						
						var str = '';
						
						for(var i in result.err_msg.list){
						
							var comment = result.err_msg.list[i];
							var times = "";
							if(comment.timestamp) {
								var now = new Date(1000*comment.timestamp);
								var hour=now.getHours();
								var minute=now.getMinutes(); 
								if(hour<10) hour = "0"+hour;
								if(minute<10) minute = "0"+minute;
								times = hour+':'+minute;
							} 
							str +='<li class="clearfix">';
							str +='		<div class="comments_list"><img src="'+comment.avatar+'" /></div>';
							str +='		<div class="comments_txt">';
							str +='			<p> <span> '+comment.nickname+'</span> <span>'+getDateDiff(1000*comment.timestamp)+','+times+'</span> </p>';
							str +='			<p>'+comment.content+' </p>';
							str +='		</div>';
							str +='</li>';
							
							i_index++;
							
						}
						//$('.b-list').append(str).removeClass('hide');
						
						$(".comments_list ul").append(str)
						
					
						if(typeof(result.err_msg.noNextPage) == 'undefined'){
							
							
							subtypeIsAjax = false;
						}else if(result.err_msg.noNextPage) {
							

							
					//	$(".wx_loading2").after(fx_bottom)	
							
							$(".product_bottom").show();
							
							
							
							subtypeIsAjax = true;
							$('#noMoreTips').removeClass('hide');
						}
						max_page = result.err_msg.max_page;
					}else{
						$('.empty-list').show();
						if(subtypePage == 1){
							$('#sNull01').removeClass('hide');
						}else{
							$('#noMoreTips').removeClass('hide');
						}
						var footer_height = $(".footer").height();
						//$(".product_bottom").css("{position:fixed;bottom:"+footer_height+"}").show();
						$(".product_bottom").css("position","fixed").show();
						$(".product_bottom").css("position","fixed").show();
						
					}
					subtypePage ++;
				}
				} catch (e) {
					
				}
			},
			error:function(){
				$('.wx_loading2').hide();
				//motify.log('商品分类读取失败，<br/>请刷新页面重试',0);
				alert("读取失败，请刷新页面")
			}
		});
	}
	
	
	//去评论
	$(".do_pinlun").live("click",function(){
		window.location.reload();
		
		var layer_open_tips = layer.open({type: 2});
		var content = $(".input_pinlun").val();
		if(!content) {
			layer.close(layer_open_tips)
			layer.open({
			    content: '评论内容不能为空哦！',
			    time: 2 //2秒后自动关闭
			});
		} else {
			$.post(
				add_pinlun_url,
				{'content':content},
				function(obj) {
					layer.close(layer_open_tips)
					if(obj.err_msg == 0) {
						
						//添加成功
						layer.open({
						    content: '您已经评论成功了！',
						    time: 2, //2秒后自动关闭
						    success: function(elem){
						        window.location.reload();
						    }     
						});
						return;
					} else {
						
						//已经评论过
						layer.open({
						    content: obj.err_msg,
						    time: 2, //2秒后自动关闭
						    success: function(elem){
						    	window.location.reload();
						    	return;
						    }     
						});
					}
					
				}
			)
		}
		
		
	})
	
	
	
	
	

		function getDateDiff(dateTimeStamp){
		var now = new Date().getTime();
		var diffValue = now - dateTimeStamp;
		if(diffValue < 0){
		 //若日期不符则弹出窗口告之
		 //alert("结束日期不能小于开始日期！");
		 }
		var monthC =diffValue/month;
		var weekC =diffValue/(7*day);
		var dayC =diffValue/day;
		var hourC =diffValue/hour;
		var minC =diffValue/minute;
		if(monthC>=1){
		 result="1个月前";
		 }
		 else if(weekC>=1){
		 result="" + parseInt(weekC) + "周前";
		 }
		 else if(dayC>=1){
		 result=""+ parseInt(dayC) +"天前";
		 }
		 else if(hourC>=1){
		 result=""+ parseInt(hourC) +"个小时前";
		 }
		 else if(minC>=1){
		 result=""+ parseInt(minC) +"分钟前";
		 }else
		 result="刚刚发表";
		return result;
		}	
	
});