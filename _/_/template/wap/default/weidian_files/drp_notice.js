$(function() {
    $("#drp-notice .close").click(function() {
        $('#drp-notice').remove();
    })
})




		$('.custom-tag-list-menu-block').height($('.custom-tag-list-goods').eq(0).height());
		$('.control-group').each(function(){
			$(this).find('.custom-tag-list-side-menu li a').each(function(i){
	$(this).click(function(){
		$('.custom-tag-list-side-menu li a').each(function(){
			$(this).css('background','');
		});
		$(this).css('background','#fff');
		
		$('.custom-tag-list-goods').each(function(){
			$(this).hide();
		});
		$('.custom-tag-list-goods').eq(i).show();
		
		$('.custom-tag-list-menu-block').height($('.custom-tag-list-goods').eq(i).height());
	});
	
});
		});
	

	$('.js-tabber-tags a').each(function(i){
	$(this).click(function(){
		$('.js-tabber-tags a').each(function(){
			$(this).removeClass('active');
		});
		$('.custom-tag-list-goods').next('.js-goods-list').each(function(){
			$(this).hide();
		});
		$('.js-tabber-tags a').eq(i).addClass('active');
		$('.custom-tag-list-goods').next('.js-goods-list').eq(i).show();
	});
});

		$('.custom-tag-list-goods-buy').click(function(){
		if (!is_logistics && !is_selffetch) {
			motify.log('商家未设置配送方式，暂时不能购买');
			return;
		}
		
		var nowDom = $(this);
		if(nowDom.attr('disabled')){
			motify.log('提交中,请稍等..');
			return false;
		}
		var product_id=$(this).attr('product-id');
		skuBuy(product_id,0,function(){
		});
	});
	
	$('.custom-my_guanzhu a').each(function(i){
		$(this).click(function(){
			$('.custom-my_guanzhu a').each(function(){
				$(this).removeClass('active');
			});
			$(this).addClass('active');
			$('.custom-my_guanzhu').next('.wx_wrap').children('.mod_list').each(function(){
				$(this).hide();
			});
			$('.custom-my_guanzhu').next('.wx_wrap').children('.mod_list').eq(i).show();
		});
		
	});


// 添加收藏
function userCollect(id, type) {
	var obj = $(".js-shouchang");
	var url = "collect.php?action=add&id=" + id + "&type=" + type+'&store_id='+id;
	var number = parseInt(obj.find("span").html());
	$.get(url,function(data){
		motify.log(data.msg);
		if(data.status){
			obj.find("span").html(number + 1);
		}
	},'json');
}


//关注商品
function userAttention(id, type) {
	var obj = $(".js-guanzhu");
	var url = "collect.php?action=attention&id=" + id + "&type=" + type+'&store_id='+id;;
	var number = parseInt(obj.find("span").html());
	$.get(url, function(data){
		motify.log(data.msg);
		if(data.status){
			obj.find("span").html(number + 1);
		}
	},'json');
}

function showResponse(data) {
	if (data.status == true) {
		//当有信息提示时
		if (data.msg != '') {
			if (data.data.nexturl != '' && data.data.nexturl != 'undefined') {
				j_url = data.data.nexturl;
			}
			//refresh_vdcode();
			tusi(data.msg, 'jump');
		}
		return;
	} else {
		if (data.msg != '') {
			tusi(data.msg);
		}
	}
	return true;
}


function tusi(txt, fun) {
	$('.tusi').remove();
	//var div = $('<div class="tusi" style="background: url(/template/index/default/images/tusi.png);max-width: 85%;min-height: 77px;min-width: 270px;position: absolute;left: -1000px;top: -1000px;text-align: center;border-radius:10px;"><span style="color: #ffffff;line-height: 77px;font-size:20px;">' + txt + '</span></div>');
	var div = $('<div class="tusi" style="background: #5A5B5C;padding:0px 20px;min-height: 77px;min-width: 270px;position: absolute;left: -1000px;top: -1000px;text-align: center;border-radius:10px;"><span style="color: #ffffff;line-height: 77px;font-size:20px;">' + txt + '</span></div>');
	$('body').append(div);
	div.css('zIndex', 9999999);
	div.css('left', parseInt(($(window).width() - div.width()) / 2));
	var top = parseInt($(window).scrollTop() + ($(window).height() - div.height()) / 2);
	div.css('top', top);
	setTimeout(function () {
		div.remove();
		if (fun) {
			eval("(" + fun + "())");
		}
	}, 1500);
}