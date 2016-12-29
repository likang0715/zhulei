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
> 	<style type="text/css">		.date-quick-pick {			display: inline-block;			color: #07d;			cursor: pointer;			padding: 2px 4px;			border: 1px solid transparent;			margin-left: 12px;			border-radius: 4px;			line-height: normal;		}		.date-quick-pick.current {			background: #fff;			border-color: #07d!important;		}		.date-quick-pick:hover{border-color:#ccc;text-decoration:none}	</style>		<div class="mainbox">			<div id="nav" class="mainnav_title">				<ul>					<a href="<?php echo U('Order/checklog');?>" class="on">订单列表</a>				</ul>			</div>			<table class="search_table" width="100%">				<tr>					<td>						<form action="<?php echo U('Order/checklog');?>" method="get">							<input type="hidden" name="c" value="Order" />							<input type="hidden" name="a" value="checklog" />						   	 筛选: <input type="text" name="keyword" class="input-text" value="<?php echo ($_GET['keyword']); ?>" />							<select name="type">							<option value="realname" <?php if($_GET['type'] == 'realname'): ?>selected="selected"<?php endif; ?>>管理员姓名</option>								<option value="account" <?php if($_GET['type'] == 'account'): ?>selected="selected"<?php endif; ?>>管理员登陆账户名</option>															</select>																					<!-- 							&nbsp;&nbsp;下单时间： --><!-- 							<span class="date-quick-pick" data-days="7">最近7天</span> --><!-- 							<span class="date-quick-pick" data-days="30">最近30天</span> --> 							<input type="submit" value="查询" class="button"/>						</form>					</td>				</tr>			</table>			<form name="myform" id="myform" action="" method="post">				<div class="table-list">					<table width="100%" cellspacing="0">						<colgroup>							<col/>							<col/>							<col/>							<col/>							<col/>							<col width="180" align="center"/>						</colgroup>						<thead>							<tr>								<th width="150">标记号</th>								<th>订单id</th>								<th>操作人信息</th>								<th>操作信息描述</th>								<th>IP</th>								<th>操作的时间</th>															</tr>						</thead>						<tbody>							<?php if(is_array($array)): if(is_array($array)): $i = 0; $__LIST__ = $array;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$arr): $mod = ($i % 2 );++$i;?><tr>										<td><?php echo ($arr["id"]); ?></td>										<td>订单id：<?php echo ($arr["order_id"]); ?><br/>订单no：<?php echo ($arr["order_no"]); ?></td>										<td><?php echo ($arr["linkman"]); ?>																																																												<?php echo ($arr["realname"]); ?><BR/>										用户名:<?php echo ($arr["account"]); ?><br/>										最后登录ip: <?php echo (long2ip($arr["last_ip"])); ?><BR/>																														</td>										<td><?php echo ($arr["desciption"]); ?></td>										<td><?php echo (long2ip($arr["ip"])); ?></td>																				<td><?php echo (date('Y-m-d H:i:s',$arr["timestamp"])); ?></td>																																																											</tr><?php endforeach; endif; else: echo "" ;endif; ?>								<tr>									<td class="textcenter pagebar" colspan="10"><?php echo ($page); ?></td>								</tr>							<?php else: ?>								<tr><td class="textcenter red" colspan="10">列表为空！</td></tr><?php endif; ?>						</tbody>					</table>				</div>			</form>		</div>	</body>
</html>