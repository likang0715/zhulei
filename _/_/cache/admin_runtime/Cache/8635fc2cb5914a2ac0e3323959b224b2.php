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
> 
	<script type="text/javascript">
		$(function() {
			//是否启用
			$('.status-enable > .cb-enable').click(function(){
				if (!$(this).hasClass('selected')) {
					var uid = $(this).data('id');
					$.post("<?php echo U('User/fans_forever'); ?>",{'status': 1, 'id': uid}, function(data){})
				}
			})
			$('.status-disable > .cb-disable').click(function(){
				if (!$(this).hasClass('selected')) {
					var uid = $(this).data('id');
					if (!$(this).hasClass('selected')) {
						$.post("<?php echo U('User/fans_forever'); ?>", {'status': 0, 'id': uid}, function (data) {})
					}
				}
			})
		});
	</script>
		<div class="mainbox">
			<div id="nav" class="mainnav_title">
				<ul>
					<a href="<?php echo U('User/index');?>" class="on">用户列表</a>
				</ul>
			</div>
			<table class="search_table" width="100%">
				<tr>
					<td>
						<form action="<?php echo U('User/index');?>" method="get">
							<input type="hidden" name="c" value="User"/>
							<input type="hidden" name="a" value="index"/>
							筛选: <input type="text" name="keyword" class="input-text" value="<?php echo ($_GET['keyword']); ?>"/>
							<select name="searchtype">
								<option value="uid" <?php if($_GET['searchtype'] == 'uid'): ?>selected="selected"<?php endif; ?>>用户ID</option>
								<option value="nickname" <?php if($_GET['searchtype'] == 'nickname'): ?>selected="selected"<?php endif; ?>>昵称</option>
								<option value="phone" <?php if($_GET['searchtype'] == 'phone'): ?>selected="selected"<?php endif; ?>>手机号</option>
							</select>&nbsp;&nbsp;
							<select name="pid">
								<option value="" >所属店铺套餐</option>
								<?php if(is_array($packagelist)): $i = 0; $__LIST__ = $packagelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["pigcms_id"]); ?>" <?php if($_GET['pid'] == $vo['pigcms_id']): ?>selected="selected"<?php endif; ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
							<input type="submit" value="查询" class="button"/>
						</form>
					</td>
				</tr>
			</table>
			<form name="myform" id="myform" action="" method="post">
				<div class="table-list">
					<table width="100%" cellspacing="0">
						<colgroup>
							<col/>
							<col/>
							<col/>
							<col/>
							<col/>
							<col/>
							<col/>
							<col width="180" align="center"/>
						</colgroup>
						<thead>
							<tr>
								<th>ID</th>
								<th>昵称</th>
								<th>手机号</th>
                                <th style="text-align: right;">店铺数量</th>
								<th style="text-align: right;">积分余额</th>
								<th style="text-align: right;">待发放积分</th>
								<th style="text-align: right;">已使用积分</th>
								<th style="text-align: center;">最后登录时间</th>
								<th>最后登录IP</th>
								<th class="textcenter">状态</th>
								<th class="textcenter" style="width: 90px;">粉丝终身制</th>
								<th class="textcenter">操作</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($user_list)): if(is_array($user_list)): $i = 0; $__LIST__ = $user_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
										<td><?php echo ($vo["uid"]); ?></td>
										<td><?php echo ($vo["nickname"]); ?></td>
										<td><?php echo ($vo["phone"]); ?></td>
										<td style="text-align: right;"><?php if ($vo['stores'] > 0) { ?><a href="javascript:;" href="javascript:void(0);" style="color: #3865B8" onclick="window.top.artiframe('<?php echo U('User/stores',array('id' => $vo['uid'], 'frame_show' => true));?>','商家“<?php echo ($vo["nickname"]); ?>”的店铺',750,700,true,false,false,false,'detail',true);"><?php echo ($vo["stores"]); ?></a><?php } else { ?>0<?php } ?></td>
										<td style="text-align: right;color:green;"><a href="<?php echo U('Credit/record',array('record_type' => 1, 'ktype' => 'user', 'keyword' => $vo['nickname']));?>"><?php echo $vo['point_balance']; ?></a></td>
										<td style="text-align: right;color:#999;"><?php echo $vo['point_unbalance']; ?></td>
										<td style="text-align: right;color:red;"><?php echo $vo['point_used']; ?></td>
										<td style="text-align: center;"><?php echo (date('Y-m-d H:i:s',$vo["last_time"])); ?></td>
										<td><?php echo ($vo["last_ip_txt"]); ?></td>
										<td class="textcenter"><?php if($vo['status'] == 1): ?><font color="green">正常</font><?php else: ?><font color="red">禁止</font><?php endif; ?></td>
										<td class="textcenter">
											<?php if (isset($vo['fans_forever'])) { ?>
											<div style="margin: 0 auto;">
												<span class="cb-enable status-enable"><label class="cb-enable <?php if (!empty($vo['fans_forever'])) { ?>selected<?php } ?>" data-id="<?php echo $vo['uid']; ?>"><span>启用</span><input type="radio" name="status" value="1"></label></span>
												<span class="cb-disable status-disable"><label class="cb-disable <?php if (empty($vo['fans_forever'])) { ?>selected<?php } ?>" data-id="<?php echo $vo['uid']; ?>"><span>取消</span><input type="radio" name="status" value="0"></label></span>
												<div style="clear: both;"></div>
											</div>
											<?php } else { ?>
												无
											<?php } ?>
										</td>
										<td class="textcenter">
											<a href="javascript:void(0);" onclick="window.top.artiframe('<?php echo U('User/edit',array('uid'=>$vo['uid']));?>','编辑用户信息',700,360,true,false,false,editbtn,'edit',true);">编辑</a>&nbsp;|&nbsp;
											<a href="<?php echo U('tab_store',array('uid'=>$vo['uid']));?>" target="_blank">进入店铺</a>
											<?php if(C('config.allow_agent_invite')): ?>&nbsp;|&nbsp;
												<a href="javascript:void(0);" onclick="window.top.artiframe('<?php echo U('User/agent_invite', array('uid'=>$vo['uid']));?>','绑定客户经理(代理商)',620,360,true,false,false,editbtn,'edit',true);">绑定客户经理(代理商)</a><?php endif; ?>
										</td>
									</tr><?php endforeach; endif; else: echo "" ;endif; ?>
								<tr><td class="textcenter pagebar" colspan="12"><?php echo ($pagebar); ?></td></tr>
							<?php else: ?>
								<tr><td class="textcenter red" colspan="12">列表为空！</td></tr><?php endif; ?>
						</tbody>

					</table>
				</div>
			</form>
		</div>
	</body>
</html>