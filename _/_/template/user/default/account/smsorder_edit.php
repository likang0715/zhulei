
<style>
.block-help>a {
  display: inline-block;
  width: 16px;
  height: 16px;
  line-height: 18px;
  border-radius: 8px;
  font-size: 12px;
  text-align: center;
  background: #bbb;
  color: #fff;
}
.block-help>a:after {
  content: "?";
}		
.hide{display:none}
	</style>

	<div class="container wrap_800">
			<div class="content" role="main">
				<div class="app">
					<div class="app-init-container">
						<div class="team">
							<div class="wrapper-app">
								<div id="header">
									<div class="addition">

									</div>
								</div>
								<div id="content">
<!-- - ---------------------->
<style type="text/css">
	.get-web-img-input {
		height: 30px!important;
	}
</style>
<div>
	<form class="form-horizontal">
		<fieldset>

			<div class="control-group">
				<label class="control-label">短信价格：</label>

				<div class="controls">
					<input type="text" data-price="<?php echo $order_sms['sms_price']?>" readonly="readonly" value="<?php echo $order_sms['sms_price']?>分/条" name="sms_price" maxlength="15" />
				</div>
			</div>
			<div class="control-group">&#12288;</div>
			<div class="control-group">
				<label class="control-label">购买条数：</label>

				<div class="controls">
					<input type="text" value="<?php echo $order_sms['sms_num']?>" class="sms_amounts" name="sms_amount" maxlength="6" /> 条 
				</div>
			</div>
			<div class="control-group">&#12288;</div>
			<div class="control-group">
				<label class="control-label">价格合计：</label>

				<div class="controls controls_account">
					<?php echo $order_sms['money'];?>
				</div>
			</div>
			

			
			<div class="control-group">&#12288;</div>
			
			<?php if(time()-$order_sms['dateline']>86400) {?>
			<div class="control-group control-action">
				<div class="controls">
					<button class="btn btn-large btn-primary"　style="background:#999999" disabled="disabled"  type="button" data-loading-text="已过期...">订单已过期，返回继续操作</button>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="<?php dourl('store:select'); ?>">取消</a>
				</div>
			</div>			
			
			
			<?php }else {?>
			<div class="control-group control-action">
				<div class="controls">
					<button class="btn btn-large btn-primary js-btn-submits2 create_buysm_qcode"  type="button" data-loading-text="正在提交...">生成购买二维码</button>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="<?php dourl('store:select'); ?>">取消</a>
				</div>
			</div>
			
			
			
			<div class="qrcode_img_class control-group" style="display:none">
				<label class="control-label">请使用微信扫码支付：</label>

				<div class="controls">
					<img width="200" height="200"  src="<?php echo STATIC_URL;?>images/blank.gif"class="qrcode_img">
				</div>
				<div class="loading"></div>
			</div>		
			<?php }?>
		</fieldset>
	</form>
	
	
	
	
	
	
</div>









	<script type="text/javascript">
	

		$(function(){
			//getPayUrl();
		});
		function getPayUrl(){
			
			$('.loading').html('二维码正在加载中，请稍候...');
			$(".js-btn-submits2").html("二维码正在加载中，请稍候...");

			$.post('<?php dourl('recognition:see_tmp_qrcode',array('qrcode_id'=>700000000+$order_sms['sms_order_id']));?>',function(result){
				if(result.err_code != 0){
					$('.loading').html('<a href="javascript:getPayUrl();" style="color:red;text-decoration:none;">点击重新获取二维码</a>');
					alert(result.err_msg+'\r\n请点击重新获取二维码');
				}else{
					if(result.err_msg.error_code != 0){
						$('.pay-code .code .loading').html('<a href="javascript:getPayUrl();" style="color:red;text-decoration:none;">点击重新获取二维码</a>');
						alert(result.err_msg+'\r\n请点击重新获取二维码');
					}else{
						$('.loading').html('');
						$('.qrcode_img').attr('src',result.err_msg.ticket);
						$(".js-btn-submits2").html("请使用微信扫码支付！").css({"background":"#999999"}).attr("disabled","disabled");
					}
				}
			});
			setInterval("checkPay(0)", 7000);
			$('#submitButton').click(function(){
				$('#checkPayTxt').html('正在检测订单是否已付款，请稍等...');
				//checkPay(1);
			});
		}
		function next(){
			if ($('input[name="payChannel"]:checked').length < 1) {
				alert("请选择一个支付渠道！");
				return;
			}
			$('#cashierForm').submit();
		};
	
		//轮询查询支付状态
		checkPayNow = false;
		function checkPay(type){
			if(type == 1){
				checkPayNow = true;
				$('#checkPayTxt').html('正在检测订单是否已付款，请稍等...');
			}
			if(checkPayNow == false){
				$.getJSON("<?php dourl('account:smsorder_check',array('sms_order_id'=>$order_sms['sms_order_id']));?>",function(result){
					checkPayNow = false;
					if(result.err_msg == 'ok'){
						window.location.href = "<?php dourl('account:smsorder_detail',array('sms_order_id'=>$order_sms['sms_order_id']));?>";
					}
				});
			}
		}
				
	//更改购买条数
	$(".sms_amounts").live("keyup", function(){
		$(".qrcode_img_class").hide();
		$('.qrcode_img').attr('src',"");
		$(".js-btn-submits2").html("请生成购买二维码！").css({"background":"#0077dd"});
		$(".js-btn-submits2").attr("disabled",false);

		var buy_num = $(this).val();
		buy_num = buy_num ? buy_num:'0';
		var buy_sms_price = $("input[name='sms_price']").attr("data-price");
		var control_account = parseInt(buy_num) * (buy_sms_price)*1/100;
		$(".controls_account").html("&yen"+control_account+"元");
	})	
	
	$(".create_buysm_qcode").live("click",function(){
		
		if($(this).attr("disabled") != "disabled") {	
			
			
			updateorder();
			
			
			//getPayUrl();			
		}else {
			layer.msg('短信订单已更新，生成购买二维码，请支付');
		}
	
	})

function updateorder() {
	
	var sms_amount = $("input[name='sms_amount']").val();
	
	var re = /^[1-9]+[0-9]*]*$/;
	if (!re.test(sms_amount)) {
		layer.msg('购买的短信数错误');
		return false;
	} 
	if(sms_amount<1000) {
		layer.msg('最低也要买个1000条吧！');
		return false;		
	}
	$(".qrcode_img_class").show();
	
	
	
	$.post('<?php dourl('account:load',array('sms_order_id'=>$order_sms['sms_order_id']));?>',{'page':"smsorder_edit",'do_sms_amount':sms_amount},function(result){
		
		if(result.err_code != 0){
			var rerr_code = $.trim(result.err_code);
			switch(rerr_code) {
				case '4':
					layer.msg(result.err_msg);
					location.href="<?php echo url('account:sms_record');?>"
				break;
				
				default:
					layer.msg(result.err_msg);
					break;
				
			}
			
		}else{
			//更新成功
			layer.msg('更新成功');
			getPayUrl();	
		}
	});	
	
	
	
}	
	
	</script>
														
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
