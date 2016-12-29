var subtypePage = 1;
var i_index = 1;
var subtypeIsAjax = false;
var subtypeSort = 'default';
var subtypeShowRows = false;
var max_page;


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
	
	
	
	
	//专题点赞操作
	$(".dianzan").live("click",function(){
		if($(this).hasClass("dianzan_selected")) {
			//取消点赞
			$.post(
					dianzan_url,
					{'types':'qx'},
					function(obj) {
						if(obj.err_code == '0') {
							$(".dianzan").removeClass("dianzan_selected");
							//添加成功
							dz_index = $(".dianzan").index($(this))
							var last_dz_count = $(".dz_count").eq(dz_index).text();
							last_dz_count = parseInt(last_dz_count*1)*1-1;
							if(last_dz_count>0) {}else {last_dz_count = 0;}
							$('.dz_count').text(last_dz_count);
						} else {
								//已经收藏过了
						}
						},
						'json'
					)
			
		} else {
			//点赞
			$.post(
				dianzan_url,
				{},
				function(obj) {
					if(obj.err_code == '0') {
						$(".dianzan").addClass("dianzan_selected");
						//添加成功
						dz_index = $(".dianzan").index($(this))
						var last_dz_count = $(".dz_count").eq(dz_index).text();
						last_dz_count = parseInt(last_dz_count*1)+1;
						$('.dz_count').text(last_dz_count);
					} else {
							//已经收藏过了
					}
					},
					'json'
				)
		}

	})

	
});



$(function(){
	FastClick.attach(document.body);
	$(window).scroll(function(){

		if(subtypePage > 1 && $(window).scrollTop()/($('body').height() -$(window).height())>=0.92){
			//alert("宽高比"+$(window).scrollTop()/($('body').height() -$(window).height()))
			//alert("subtypePage:"+subtypePage)
			//alert(max_page)
			if(subtypeIsAjax == false){
				if(typeof(max_page) != 'undefined'){
					if(subtypePage <= max_page) {
						
						if($('.wx_loading2').is(":hidden")) {
							getsubjects();
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

	getsubjects();
	
	function getsubjects(){
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
							var subinfo = result.err_msg.list[i];
	
							str+=' <li>';
							str+='		<div class="product_title"><i>'+i_index+'</i>'+subinfo.name+'</div>';
							str+='		<p class="product_info">'+subinfo.intro+'</p>';
							str+='		<div class="product_img">';
							str+='			<ul>';
							
							for(var j in subinfo.piclist) {
								str+='	<li> <img src="'+subinfo.piclist[j]+'" /></li>';
							}
							str+='			</ul>';
							str+='		</div>';
							if(subinfo.original_price >0){
								//str+='	<p>'+subinfo.name+'原价：<span>'+subinfo.original_price+'元</span></p>';
							}

							//str+='		<p>优惠：店铺红包可抵5.00元，送杯套、杯刷、杯垫</p>';
							str+='		<div  class="product_detailed">';
							str+='			<span>';
							str+='				<p>￥'+subinfo.now_price+'</p>';
							str+='				<p><i>'+subinfo.collect+'</i>人喜欢</p>';
							str+='			</span>';
							str+='			<span><a href="./good.php?id='+subinfo.product_id+'&store_id='+result.err_msg.now_store_id+'">查看详情</a></span>';
							str+='		</div>';
							str+='</li>';
							i_index++;
							
						}
						
						//$('.b-list').append(str).removeClass('hide');
						
						$(".product_con_list").append(str)
						
					
						if(typeof(result.err_msg.noNextPage) == 'undefined'){
							
							
							subtypeIsAjax = false;
						}else if(result.err_msg.noNextPage) {
							

							
					//	$(".wx_loading2").after(fx_bottom)	
							
							$(".product_bottom").show();
							
							
							
							subtypeIsAjax = true;
							$('#noMoreTips').removeClass('hide');
						}
						max_page = result.err_msg.max_page;
						if(max_page == subtypePage) {
							$(".product_bottom").show();
						}
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
	
});