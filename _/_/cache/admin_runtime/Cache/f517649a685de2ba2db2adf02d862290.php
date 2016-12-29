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
> 	<style type="text/css">		.date-quick-pick {			display: inline-block;			color: #07d;			cursor: pointer;			padding: 2px 4px;			border: 1px solid transparent;			margin-left: 12px;			border-radius: 4px;			line-height: normal;		}		.date-quick-pick.current {			background: #fff;			border-color: #07d!important;		}		.date-quick-pick:hover{border-color:#ccc;text-decoration:none}	</style>		<div class="mainbox">			<div id="nav" class="mainnav_title">				<ul>					<a href="<?php echo U('Order/rights');?>" class="on">维权列表</a>				</ul>			</div>			<table class="search_table" width="100%">				<tr>					<td>						<form action="<?php echo U('Order/rights');?>" method="get">							<input type="hidden" name="c" value="Order" />							<input type="hidden" name="a" value="rights" />							筛选: 订单号：<input type="text" name="order_no" class="input-text" value="<?php echo ($_GET['order_no']); ?>" />							&nbsp;&nbsp;							类型：							<select name="type">								<option value="">全部</option>								<?php  foreach ($type_arr as $key => $val) { ?>									<option value="<?php echo $key ?>" <?php echo $key == $type ? 'selected="selected"' : '' ?>><?php echo $val ?></option>								<?php } ?>							</select>							&nbsp;&nbsp;状态：							<select name="status">								<option value="">全部</option>								<?php  foreach ($status_arr as $key => $val) { ?>									<option value="<?php echo $key ?>" <?php echo $key == $status ? 'selected="selected"' : '' ?>><?php echo $val ?></option>								<?php } ?>							</select>														&nbsp;&nbsp;时间：							<input type="text" name="start_time" id="js-start-time" class="input-text Wdate" style="width: 150px" value="<?php echo ($_GET['start_time']); ?>" />- <input type="text" name="end_time" id="js-end-time" style="width: 150px" class="input-text Wdate" value="<?php echo ($_GET['end_time']); ?>" />							<span class="date-quick-pick" data-days="7">最近7天</span>							<span class="date-quick-pick" data-days="30">最近30天</span>							<input type="submit" value="查询" class="button"/>						</form>					</td>				</tr>			</table>			<form name="myform" id="myform" action="" method="post">				<div class="table-list">					<table width="100%" cellspacing="0">						<colgroup>							<col/>							<col/>							<col/>							<col/>							<col/>							<col width="180" align="center"/>						</colgroup>						<thead>							<tr>								<th width="150">订单号</th>								<th>商家信息</th>								<th>购买产品信息</th>								<th>买家信息</th>								<th>维权类型</th>								<th>维权状态</th>								<th>维权时间</th>								<th class="textcenter">操作</th>							</tr>						</thead>						<tbody>							<?php  if (!empty($rights_list)) { foreach ($rights_list as $rights) { ?>									<tr>										<td><?php echo ($rights["order_no"]); ?></td>										<td>											店铺名称：<?php echo $rights['store_name'] ?><br />											联系电话：<?php echo $rights['store_tel'] ?>										</td>										<td>											<img src="<?php echo $rights['image'] ?>" style="max-width:60px; max-height:60px; float:left; padding-right:5px;" />											<?php echo htmlspecialchars($rights['name']) ?><br />											<?php  if (!empty($rights['sku_data'])) { $sku_data_arr = unserialize($rights['sku_data']); foreach ($sku_data_arr as $val) { echo '<br />' . $val['name'] . ':' . $val['value']; } } ?>										</td>										<td>											<?php echo $rights['nickname'] ?><br />											<?php echo $rights['phone'] ?>										</td>										<td><?php echo $rights['type_txt'] ?></td>										<td><?php echo $rights['status_txt'] ?></td>																														<td><?php echo date('Y-m-d H:i', $rights['dateline']) ?></td>										<td class="textcenter">											<a href="javascript:void(0);" onclick="window.top.artiframe('<?php echo U('Order/rights_detail',array('id' => $rights['id'], 'frame_show' => true));?>','维权详情',750,700,true,false,false,false,'detail',true);">查看</a>									  	</td>									</tr>								<?php  } ?>								<tr>									<td class="textcenter pagebar" colspan="8"><?php echo ($page); ?></td>								</tr>							<?php  } else { ?>								<tr><td class="textcenter red" colspan="10">列表为空！</td></tr>							<?php  } ?>						</tbody>					</table>				</div>			</form>		</div>	</body>
</html>