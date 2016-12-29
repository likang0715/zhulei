<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>通知 - <?php echo $config['site_name'];?></title>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/common.js"></script>
		<script src="<?php echo STATIC_URL;?>js/cart/jscolor.js" type="text/javascript"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.form.min.js"></script>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/sendall.css" rel="stylesheet" type="text/css"/>
		<script src="<?php echo TPL_URL;?>js/tpl_msg.js" type="text/javascript"></script>
		<script>var load_url="<?php dourl('load');?>";</script>
	</head>
	<body class="font14 usercenter">
		<?php include display('public:first_sidebar');?>
        <?php include display('sidebar');?>
		<!-- ▼ Container-->
        <div id="container" class="clearfix container right-sidebar">
            <div id="container-left">
                <!-- ▼ Third Header -->
                <div id="third-header">
                    <ul class="third-header-inner">
				        <li>
							<a href="javascript:;">通知</a>
						</li>
                    </ul>
                </div>
                <!-- ▲ Third Header -->
                <!-- ▼ Container App -->
                <div class="container-app">
				<div class="app-inner clearfix">
					<div class="app-init-container">
						<div class="nav-wrapper--app">
						<nav class="ui-nav clearfix">
							<ul class="pull-left">
								<li>
									<a href="<?php dourl('template_msg')?>" data-is="3">预设消息模板</a>
								</li>
								<li class="active">
									<a href="<?php dourl('notice_power_list') ?>" data-is="1">微信/短信 开关管理</a>
								</li>
							</ul>
						</nav>
						</div>
						<div class="app__content page-setting-weixin js-list-body-region">
							<div>
								<div style="background:#fefbe4;border:1px solid #f3ecb9;color:#993300;padding:10px;margin-bottom:5px;font-size:12px;margin-top:5px;">
								温馨提示： 以下规则 选择保存后，将用于本店铺、其名下分销店铺 或相应用户，如果您还有其他店铺，请前往 并对应操作！<br/>
&#12288;&#12288;&#12288;&#12288;&#12288;（活动通知如：秒杀、团购、夺宝 等 会向成功的或失败的人均推送对应消息，故短信可能发送N+条！）
<br/><br/>
&#12288;&#12288;&#12288;&#12288;&#12288;您用户账户 还有短信：<span style="font-weight:700;"><?php echo $_SESSION['user']['smscount'];?></span> 条，<a style="text-decoration:underline;font-weight:700;" href="user.php?c=account&a=sms_record" target="_blank" >前往充值</a>
&#12288;&#12288;&#12288;&#12288;&#12288;
								<?php if(!$store_info['openid']) {?>
									您店铺还未绑定微信：<span></span> <a target="_blank" style="text-decoration:underline;" href="<?php echo dourl('substore:wxbind');?>" >去绑定</a>
								<?php } else {?>
									您店铺 <font style="color:#07d;font-weight:700;">已绑定</font> 微信</a>
								<?php }?>

								</div>
								<form name="myform" id="myform" action="<?php dourl('weixin:template_msg');?>" method="post" refresh="true">
									<table class="ui-table ui-table-list" width="100%" cellspacing="0">
										<colgroup><col> <col> <col><col>  <col width="180" align="center"> </colgroup>
										
										<thead class="js-list-header-region tableFloatingHeaderOriginal">
											<tr class="widget-list-header">
												<th colspan="7" style="vertical-align:middle"><input type="checkbox" class="chekckAll">&#12288;全选&#12288;&#12288;
												<span style="display:inline-block"><font color="#f60">* 这里只显示在 	"<b style="color:#029700">微信</b> >> <b style="color:#029700">模板消息</b> >> <b style="color:#029700">预设模板消息</b>"	 中 <b style="color:#029700">打开</b> 的模板消息</span>	
												</font></th>
											</tr>
										</thead>
										
										
										
										<thead>
											<tr>
												<th>模板名</th>
												<th>模板编号</th>
												<th align="center">功能开关</th>
											</tr>
										</thead>
										<tbody>
										<?php if(is_array($notice_manage)) {?>
											<?php foreach($notice_manage as $k=>$v) {?>
												<tr class="widget-list-item">
														<td><input class="checkzu check_zu[<?php echo $v['id'];?>]" type="checkbox" value="1" <?php if($store_notice_manage['has_power_arr'][$v['id']]['qx_list']) { if($store_notice_manage['has_power_arr'][$v['id']]['qx_list'] == '1,2') {?>checked="checked"<?php }}?>>&#12288;<?php echo $v['name'];?></td>
														<td><?php echo $v['tempkey'];?></td>
														
														<td colspan='3' align="center">
															<input type="checkbox" style="display:none" class="checks0" checked="checked" name="<?php echo $v[id]?>" value="0">&nbsp;
																<input <?php if($store_notice_manage['has_power_arr'][$v['id']]) {if(in_array(1,$store_notice_manage['has_power_arr'][$v['id']])) {?> checked="checked" <?php }}?> type="checkbox" class="checks1"   name="<?php echo $v[id]?>" value="1">&nbsp;短信通知
																&#12288;
																<input <?php if($store_notice_manage['has_power_arr'][$v['id']]) {if(in_array(2,$store_notice_manage['has_power_arr'][$v['id']])) {?> checked="checked" <?php }}?>  type="checkbox" class="checks2" name="<?php echo $v[id]?>" value="2">&nbsp;微信通知
															
														</td>
												</tr>
											<?php }?>
										
					
							                  <tr>
							                    <td colspan="6" align="center"><input type="button" name="dosubmit" value="保存" class="ui-btn ui-btn-primary js-btn-save-store"/></td>
							                  </tr>
							                 <?php } else {?>
								                 <tr>
								                    <td colspan="6" align="center">您在 “预设模板消息” 尚未开启过模板哦！ <b><a style="text-decoration:underline;" href="<?php echo dourl('template_msg');?>">去开启</a></b></td>
								                  </tr>
							                 <?php }?> 
										</tbody>
									</table>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			</div>
		</div>
		<?php include display('public:footer');?>
		<script>

		$(function(){

			$(".chekckAll").click(function(){
				if($(this).is(":checked") == true) {
					$(".js-list-body-region").find("input[type='checkbox']").attr("checked",true);
				} else {
					$(".js-list-body-region").find("input[type='checkbox']").attr("checked",false);
					$(".js-list-body-region").find(".checks0").attr("checked",true);
				}
			})

			$(".checkzu").click(function(){
				if($(this).is(":checked") == true) {
					$(this).closest("tr").find("input[type='checkbox']").attr("checked",true);	
				} else {
					$(this).closest("tr").find("input[type='checkbox']").attr("checked",false);
					$(this).closest("tr").find(".checks0").attr("checked",true);
				}	
			})


			$(".checks1").click(function(){
				var checks1_index =  $(".checks1").index($(this));
				
				if($(this).is(":checked") == true) {
					if($(".checks2").eq(checks1_index).is(":checked") == true) {
						$(".checkzu").eq(checks1_index).attr("checked",true);
					} else {
						$(".checkzu").eq(checks1_index).attr("checked",false);
					}
				}else{
					$(".checkzu").eq(checks1_index).attr("checked",false);
				}
			})

			$(".checks2").click(function(){
				var checks2_index =  $(".checks2").index($(this));
				
				if($(this).is(":checked") == true) {
					if($(".checks1").eq(checks2_index).is(":checked") == true) {
						$(".checkzu").eq(checks2_index).attr("checked",true);
					} else {
						$(".checkzu").eq(checks2_index).attr("checked",false);
					}
				} else{
					$(".checkzu").eq(checks2_index).attr("checked",false);
				}
			})	
			//alert("保存成功！");
			
			//保存已经选择的 通知选项
			$(".js-btn-save-store").live("click",function(){
				var fields_seria = $(".js-list-body-region input[type='checkbox']").serializeArray();

				$.post(
					'<?php dourl('store_notice_setting') ?>', 
					{"fields_seria":fields_seria}, 
					function(data){
						if(data.status == '0') {
							layer.alert('保存成功', 9); ;
						} else {
							layer.alert('保存成失败', 8); ;
						}
					},
					'json'
				
				)
				

			})
		})
		</script>
	</body>
</html>