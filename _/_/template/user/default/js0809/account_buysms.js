$(function(){
	load_page('#content',load_url,{page:'buysms_content'},'');

	$('.js-trigger-image').live('click', function(){
		var obj = this;
		upload_pic_box(1,true,function(pic_list){
			if(pic_list.length > 0){
				for(var i in pic_list){
					$('.display-image').attr('data-url', pic_list[i]);
					$('.avatar').css('background-image', 'url(' + pic_list[i] + ')');
				}
			} else {
				return false;
			}
		},1);
	})
	
	//提交操作
	$('.js-btn-submit').live('click', function(){
		var flag = true;

		//检测购买条数及价格
		var sms_price = $("input[name='sms_price']").attr("data-price");
		var sms_amount = $("input[name='sms_amount']").val();
		if (!/^[1-9]{1}[0-9]{1,3}$/.test(sms_price)){
			$("input[name='sms_price']").closest('.control-group').addClass('error');
			$("input[name='sms_price']").after('<p class="help-block error-message">短信单价异常！</p>');
			 flag = false;
		}
		
		if (!/^[1-9]{1}[0-9]{3,}$/.test(sms_amount)){
			$("input[name='sms_amount']").closest('.control-group').addClass('error');
			$("input[name='sms_amount']").after('<p class="help-block error-message">购买短信条数最低1000条！</p>');	
			 flag = false;
		}
		
		if(!flag){
			 return false;
		}
		
		$.post(buysms_url,{'sms_amount':sms_amount},function(obj) {
			if(!obj.err_code) {
				location.href= dobuysms_url+"&order_no="+obj.err_msg;
			} else{
				
				alert("失败"+obj.err_msg);
			}
			
			
		})


		
		return;
		if ($('.error-message').length == 0) {
			$.post(personal_url, {'nickname': nickname, 'avatar': avatar, 'intro': intro}, function(data){
				if(!data.err_code) {
					$('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
				} else {
					$('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
				}
				t = setTimeout('msg_hide()', 2000);
			})
		}
	})
});

function msg_hide() {
	$('.notifications').html('');
	clearTimeout(t);
}