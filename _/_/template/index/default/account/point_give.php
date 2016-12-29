<?php include display( 'public:person_header');?>

<script type="text/javascript">
	var search_user_url = "index.php?c=account&a=point_give_ajax";
	var get_uid = 0; //获赠用户id
	var card = ''; //扫码类型
	var scene = ''; //扫码场景
	var get_user = ''; //获取获赠用户方式 手机号 扫码

    $(document).ready(function () {
    	
    	//查找获赠用户
		$('#btn_search').click(function(e) {
			
			//清除前一次结果
			get_uid = 0;
			$('.nickname').val('');
			$('.give_point').val('');
			$('.service_fee').val('');
			get_user = 'phone';
			var phone = $.trim($('.phone').val());
			
			if (phone == '') {
				tusi('手机号码不能为空');
				return false;
			}
			if(!/^[0-9]{11}$/.test(phone)){
				tusi("请填写正确手机号码");
				return false;
			}
			//搜索用户
			$.post(search_user_url, {'phone': phone, 'type': 'search_user'}, function(data) {
				if (data.err_code == 0) {
					var user = data.err_msg;
					if (user.nickname == '') {
						user.nickname = phone;
					}
					$('.nickname').val(user.nickname);
					$('.service_fee').val("<?php echo $give_point_service_fee; ?>");
					get_uid = user.uid;
				} else {
					$('.service_fee').val("<?php echo $give_point_service_fee; ?>");
					tusi(data.err_msg);
				}
			});
		});	



		$('.btn-submit').click(function(e) {
			if (get_uid == 0) {
				tusi('请先选择一个获赠的用户');
				return false;
			}
			var give_point = $("input[name='give_point']").val();
			var max_give_point = parseFloat($("input[name='max_give_point']").val());
			if (isNaN(give_point) || give_point == '') {
				tusi('无效的赠送数量');
				return false;
			}
			if (parseFloat(give_point) > max_give_point) {
				tusi('可赠送的消费积分不足');
				return false;
			}

			if (parseFloat(give_point) < 0) {
				tusi('赠送数值不能为负数');
				return false;
			}

			$('.btn-submit').attr('disabled', true);

			$.post(search_user_url, {'give_point': give_point, 'give_uid': get_uid, 'type': 'give_point', 'get_user': get_user, 'card': card, 'scene': scene}, function(data){
				if (data.err_code == 0) {
					tusi(data.err_msg);
					window.location.reload();
				} else {
					tusi(data.err_msg);
				}
				$('.btn-submit').attr('disabled', false);
			})
		})

    });
</script>
<style type="text/css">
.order_tianjia_form { padding: 40px 0 0 20px; line-height: normal; }
.order_tianjia_form .order_tianjian_form_select select { color: #000 }
.order_tianjia_form ul { text-align: left; padding: 0; font-size: 14px; }
.order_tianjia_form ul li { margin-bottom: 20px; }
.order_tianjia_form .my_label { display: inline-block; vertical-align: top; margin-top: 7px; margin-right: 15px; width: 110px; text-align: right; }
.order_tianjia_form .my_label span.txt-impt { display: inline-block; vertical-align: middle; color: red; }
.order_tianjia_form .my_content { display: inline-block; position: relative; width: auto; background: #fff; }
.order_tianjia_form .my_content a.search_btn { height: 20px; line-height: 20px; color: #fff; padding: 8px 10px; background-color: #43CCA7; }
.order_tianjia_form .my_content a.search_btn:hover { background-color: #00bb88; }
.order_tianjia_form .my_content input { padding: 8px; width: 300px; border: 1px solid #ABABAB; outline: none; }
.order_tianjia_form .my_form_bottom { text-align: left; padding-left: 130px; }
.order_tianjia_form .my_form_bottom .btn-submit { width: 140px; height: 45px; color: #fff; background-color: #43CCA7; font-size: 18px; font-weight: normal; cursor: pointer; }
.order_tianjia_form .my_form_bottom .btn-submit:hover { background-color: #00bb88; }
</style>
<div id="con_one_5"> 
	<div class="danye_content_title">
		<div class="danye_suoyou"><a href="###"><span>积分赠送</span></a></div>
	</div>
	<div class="order_add_list">
		<div class="order_tianjia_form">
			<form name="address" id="address" method="post">
				<ul>
					
					<li>
						<div class="my_label"><span class="txt-impt">* &nbsp;</span>受赠人手机号</div>
						<div class="my_content">
							<input class="phone" id="phone" class="inputText" type="text" maxlength="11" name="phone"><span style="line-height: 32px;"> &nbsp; <a href="javascript:" id="btn_search" class="search_btn" >搜索</a></span>
						</div>
					</li>

					<li>
						<div class="my_label"><span class="txt-impt">* &nbsp;</span>账号昵称</div>
						<div class="my_content">
							<input style="border-style: dotted;" type="text" name="nickname" class="nickname"  readonly="true" /> 
						</div>
					</li>

					<li>
						<div class="my_label"><span class="txt-impt">* &nbsp;</span>赠送数值</div>
						<div class="my_content">
							<input type="text" name="give_point" class="give_point" placeholder="输入赠送数量" /><span style="line-height: 32px;"> &nbsp; 当前可赠送值: <?php echo $user['point_unbalance']; ?><input type="hidden" name="max_give_point" value="<?php echo $user['point_unbalance']; ?>" readonly="true" /></span>
						</div>
					</li>

					<li>
						<div class="my_label"><span class="txt-impt">* &nbsp;</span>费率</div>
						<div class="my_content">
							<input style="border:0px;" type="text" name="service_fee" class="service_fee" value="<?php echo $give_point_service_fee; ?>" readonly="true" />
						</div>
					</li>

				</ul>
				<div class="my_form_bottom">
					<button class="btn-submit">确认提交</button>
					<input type="hidden" name="保存" id="add" />
				</div>
			</form>
		</div>
	</div>
	
</div>

<?php include display( 'public:person_footer');?>

