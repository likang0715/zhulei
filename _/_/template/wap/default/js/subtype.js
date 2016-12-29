var subtypePage = 1;
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
			//alert("宽高比"+$(window).scrollTop()/($('body').height() -$(window).height()))
			//alert("subtypePage:"+subtypePage)
			//alert(max_page)
			if(subtypeIsAjax == false){
				if(typeof(max_page) != 'undefined'){
					if(subtypePage <= max_page) {
						
						if($('.wx_loading2').is(":hidden")) {
							getsubtypes();
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

	getsubtypes();
	
	function getsubtypes(){
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
						
						if(result.err_msg.count){
							$('#sFound').removeClass('hide').find('#totResult').html(result.err_msg.count);
						}
						
						var str = '';
						for(var i in result.err_msg.list){
							var subtype = result.err_msg.list[i];
							///////////////////////////////////////////
							//start
							str+='<li>';
							str+='	<a href=./subinfo.php?store_id='+result.err_msg.now_store_id+'&subject_id='+subtype.id+'><img src="'+subtype.pic+'" class="enlarge">';
							if(subtype.is_dianzan) {
								dianzs = " dianzan_selected";
							} else {
								dianzs = "";
							}
							str+='		<i data-subjectid="'+subtype.id+'" class="'+dianzs+' actives"><em></em><span class="dz_count">'+subtype.dz_count+'</span></i>	';
							
							
							str+='		<p>'+subtype.name+'<b>1</b></p>';
							str+='	</a>';
							str+='</li>';
							//////////////////////////////////////////
						}
						//$('.b-list').append(str).removeClass('hide');
						
						$("#subject_show").append(str)
						
					
						if(typeof(result.err_msg.noNextPage) == 'undefined'){
							subtypeIsAjax = false;
						}else if(result.err_msg.noNextPage) {
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