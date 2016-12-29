<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/html"><head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo C('DEFAULT_CHARSET');?>" />
		<title>网站后台管理 Powered by pigcms.com</title>
		<script type="text/javascript">
			<!--if(self==top){window.top.location.href="<?php echo U('Index/index');?>";}-->
			var kind_editor=null,static_public="<?php echo ($static_public); ?>",static_path="<?php echo ($static_path); ?>",system_index="<?php echo U('Index/index');?>",choose_province="<?php echo U('Area/ajax_province');?>",choose_city="<?php echo U('Area/ajax_city');?>",choose_area="<?php echo U('Area/ajax_area');?>",choose_circle="<?php echo U('Area/ajax_circle');?>",choose_map="<?php echo U('Map/frame_map');?>",get_firstword="<?php echo U('Words/get_firstword');?>",frame_show=<?php if($_GET['frame_show']): ?>true<?php else: ?>false<?php endif; ?>;
		</script>
		<link rel="stylesheet" type="text/css" href="<?php echo ($static_path); ?>css/style.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo ($static_path); ?>css/jquery.ui.css" />
		<script type="text/javascript" src="<?php echo C('JQUERY_FILE');?>"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/plugin/jquery-ui.js"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/plugin/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/jquery.form.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/jquery.validate.js"></script>
		<script type="text/javascript" src="/static/js/date/WdatePicker.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/jquery.colorpicker.js"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/common.js"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/date.js"></script>
			<?php if($withdrawal_count > 0): ?><script type="text/javascript">
					$(function(){
						$('#nav_4 > dd > #leftmenu_Order_withdraw', parent.document).html('提现记录 <label style="color:red">(' + <?php echo ($withdrawal_count); ?> + ')</label>')
					})
				</script><?php endif; ?>
			<?php if($unprocessed > 0): ?><script type="text/javascript">
					$(function(){
						if ($('#leftmenu_Credit_returnRecord', parent.document).length > 0) {
							var menu_html = $('#leftmenu_Credit_returnRecord', parent.document).html();
							menu_html = menu_html.split('(')[0];
							menu_html += ' <label style="color:red">(<?php echo ($unprocessed); ?>)</label>';
							$('#leftmenu_Credit_returnRecord', parent.document).html(menu_html);
						}
					})
				</script><?php endif; ?>
		</head>
		<body width="100%" 
		<?php if($bg_color): ?>style="background:<?php echo ($bg_color); ?>;"<?php endif; ?>
> 	<style type="text/css">		.date-quick-pick {			display: inline-block;			color: #07d;			cursor: pointer;			padding: 2px 4px;			border: 1px solid transparent;			margin-left: 12px;			border-radius: 4px;			line-height: normal;		}		.date-quick-pick.current {			background: #fff;			border-color: #07d!important;		}		.date-quick-pick:hover{border-color:#ccc;text-decoration:none}	</style>	<script>	$(function () {		$(".js-order_status").click(function () {			var status = $(this).data("status");			var order_id = $(this).data("order_id");						if (status == "2") {				if (!confirm("确认审核不通过吗？")) {					return;				}			}			var url = "<?php echo U('Order/order_offline_check') ?>";			$.post(url, {status: status, order_id: order_id}, function (result) {				if (result.status == true) {					window.top.msg(1, "<font color=\"red\">" + result.message + "</font>", true, 3);					location.reload();				} else {					window.top.msg(2, "<font color=\"red\">" + result.message + "</font>", true, 3);				}			});		});	});	</script>		<div class="mainbox">			<div id="nav" class="mainnav_title">				<ul>					<a href="<?php echo U('Order/offline');?>" class="on" id="url_for_checkout" >店铺添加订单列表</a>				</ul>			</div>			<table class="search_table" width="100%">				<tr>					<td>						<form action="<?php echo U('Order/offline');?>" method="get">							<input type="hidden" name="c" value="Order" />							<input type="hidden" name="a" value="offline" />							筛选: 订单号：<input type="text" name="order_no" class="input-text" value="<?php echo ($_GET['order_no']); ?>" />							&nbsp;&nbsp;审核状态：							<select name="check_status">								<option value="*">全部</option>								<option value="-1" <?php echo $_GET['check_status'] == '-1' ? 'selected="selected"' : '' ?>>未审核</option>								<option value="1" <?php echo $_GET['check_status'] == '1' ? 'selected="selected"' : '' ?>>审核通过</option>								<option value="2" <?php echo $_GET['check_status'] == '2' ? 'selected="selected"' : '' ?>>审核未通过</option>							</select>							&nbsp;&nbsp;下单时间：							<input type="text" name="start_time" id="js-start-time" class="input-text Wdate" style="width: 150px" value="<?php echo ($_GET['start_time']); ?>" />- <input type="text" name="end_time" id="js-end-time" style="width: 150px" class="input-text Wdate" value="<?php echo ($_GET['end_time']); ?>" />							<span class="date-quick-pick" data-days="7">最近7天</span>							<span class="date-quick-pick" data-days="30">最近30天</span>							<input type="submit" value="查询" class="button"/>							<input type="button" value="导出" class="button search_checkout" />						</form>					</td>				</tr>			</table>			<form name="myform" id="myform" action="" method="post">				<div class="table-list">					<table width="100%" cellspacing="0">						<thead>							<tr>								<th width="150">订单号/商品</th>								<th>店铺名称</th>								<th>会员用户</th>								<th>订单金额</th>								<th>服务费</th>								<th>平台保证金</th>								<th>商家可用平台积分/商家平台积分</th>								<th>添加时间</th>								<th>送平台积分</th>								<th>审核状态</th>								<th>备注</th>								<th class="textcenter">操作</th>							</tr>						</thead>						<tbody>							<?php  if (is_array($order_offline_list)) { foreach ($order_offline_list as $order_offline) { ?>									<tr>										<td>											<?php echo $order_offline['order_no'] ?><br />											<?php echo htmlspecialchars($order_offline['product_name']) ?>										</td>										<td><?php echo htmlspecialchars($store_arr[$order_offline['store_id']]) ?></td>										<td><?php echo $user_arr[$order_offline['uid']]['nickname'] ? $user_arr[$order_offline['uid']]['nickname'] : $user_arr[$order_offline['uid']]['phone'] ?></td>										<td><?php echo $order_offline['total'] ?></td>										<td><?php echo $order_offline['service_fee'] ?></td>										<td><?php echo $order_offline['cash'] ?></td>										<td>											<span style="color: green;"><?php echo $order_offline['store_user_point'] ?></span> / <br /> 											<span style="color: red;"><?php echo $order_offline['store_point'] ?></span>										</td>										<td><?php echo date('Y-m-d H:i', $order_offline['dateline']) ?></td>										<td>											<?php echo $order_offline['return_point'] ?><br />											<?php  if ($order_offline['status'] == 1) { echo '<span style="color: green;">已发放</span>'; } else { echo '<span style="color: red;">未发放</span>'; } ?>										</td>										<td>											<?php  if ($order_offline['check_status'] == 1) { echo '<span style="color: green;">审核通过</span>'; } else if ($order_offline['check_status'] == 2) { echo '<span style="color: red;">审核不通过</span>'; } else { echo '未审核'; } ?>										</td>										<td><?php echo htmlspecialchars($order_offline['bak']) ?></td>										<td class="js-operate">											<?php  if ($order_offline['check_status'] == 0) { ?>												<a href="javascript:" class="js-order_status" data-order_id="<?php echo $order_offline['id'] ?>" data-status="1">审核通过</a>												<a href="javascript:" class="js-order_status" data-order_id="<?php echo $order_offline['id'] ?>" data-status="2">审核不通过</a>											<?php  } else { echo '-'; } ?>										</td>									</tr>								<?php  } ?>								<tr>									<td class="textcenter pagebar" colspan="12"><?php echo ($page); ?></td>								</tr>							<?php  } else { ?>								<tr><td class="textcenter red" colspan="12">列表为空！</td></tr>							<?php  } ?>						</tbody>					</table>				</div>			</form>		</div><script type="text/javascript" src="<?php echo ($static_public); ?>js/layer/layer.min.js"></script>

<script type="text/javascript">
    $(function() {
        
        if($('.url_for_checkout').hasClass('on')){
            var checkout_url = $('.url_for_checkout').filter('.on').attr('href');
        }else{
             var checkout_url = $('#url_for_checkout').attr('href');
        }


       $(".search_checkout").click(function(){
  
            var loadi =layer.load('正在导出', 10000000000000);

            var searchcontent = encodeURIComponent(window.location.search.substr(1));

            $.post(
                    checkout_url,
                    {"searchcontent":searchcontent},
                    function(obj) {
                        layer.close(loadi);
                        if(obj.msg>0) {
                            layer.confirm('该条件下有记录  '+obj.msg+' 条，确认导出？',function(index){
                               layer.close(index);
                               location.href=checkout_url+"&searchcontent="+searchcontent+"&download=1";
                            });
                        } else {
                            layer.alert('该搜索条件下没有数据，无需导出！', 8); 
                        }
                        
                    },
                    'json'
            )

        })

    })
</script>	</body>
</html>