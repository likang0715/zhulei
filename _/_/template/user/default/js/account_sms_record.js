function location_page(mark, page){
	var mark_arr = mark.split('/');
	
	switch(mark_arr[0]){
		
		case "#edit":
		
		if(mark_arr[1]){
			load_page('#content', load_url,{page:'smsorder_edit',"sms_no":mark_arr[1]},'',function(){

			});
		}else{
			layer.alert('非法访问！');
                    //location.hash = '#list';
                    location_page('');
                }
                break;
                
                default:
                load_page('#content', load_url,{page:'sms_record_content', "p" : page}, '');
            }
        }
        $(function(){
        	location_page(location.hash, 1);
        	
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

	//进入修改page
	$(".team .unpay").live('click', function () {
		var action = $(this).attr("href");
		location_page(action, 1)
	});	
	
	
	
    //分页
    $('.pagenavi > a').live('click', function(e){
    	var p = $(this).attr('data-page-num');

    	location_page(window.location.hash, p);

    });	
    
	//更改购买条数
	$(".sms_amount").live("keyup", function(){
		$(".qrcode_img_class").hide();
		$(".js-btn-submits2").html("请生成购买二维码！").css({"background":"#0077dd"}).attr("disabled","false");
		var buy_num = $(this).val();
		buy_num = buy_num ? buy_num:'0';
		var buy_sms_price = $("input[name='sms_price']").attr("data-price");
		var control_account = parseInt(buy_num) * (buy_sms_price)*1/100;
		$(".controls_account").html("&yen"+control_account+"元");
	})

	
	//提交操作
	$('.js-btn-submit').live('click', function(){
		var flag = true;

		//检测购买条数及价格
		var sms_price = $("input[name='sms_price']").attr("data-price");
		var sms_amount = $("input[name='sms_amount']").val();
		if (!/^[1-9]{1}[0-9]{0,3}$/.test(sms_price)){
			$("input[name='sms_price']").closest('.control-group').addClass('error');
			
			$("input[name='sms_price']").closest('.control-group').find('.error-message').detach().empty();
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
		
		//判定是否有未支付的订单
		var unpay_sum = $(".js-list-body-region").find(".unpay").size();

		if(unpay_sum) {
			layer_tips(1,'您还有未支付的订单，请优先处理！');
			return false;
		}
		
		
		
		$.post(buysms_url,{'sms_amount':sms_amount},function(obj) {
			if(!obj.err_code) {
				location.href= dobuysms_url+"&order_no="+obj.err_msg;

				
			} else{
				layer_tips(4,'失败!&#12288;'+obj.err_msg);
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