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

<script type="text/javascript" src="<?php echo ($static_public); ?>js/layer/layer.min.js"></script>
		<div class="mainbox">
			<div id="nav" class="mainnav_title">
				<ul>
					<a href="<?php echo U('User/checkout');?>" class="on">用户信息导出</a>
				</ul>
			</div>
			<table class="search_table" width="100%">
				<tr>
					<td><center>
						<form action="<?php echo U('User/checkout');?>" method="get">
							<input type="hidden" name="c" value="User"/>
							<input type="hidden" name="a" value="checkout"/>
							导出筛选: 
							<select name="searchtype">
								<option value="0" <?php if($_GET['searchtype'] == 'uid'): ?>selected="selected"<?php endif; ?>>不限</option>
								<option value="1" <?php if($_GET['searchtype'] == 'nickname'): ?>selected="selected"<?php endif; ?>>导出有手机号的用户</option>
								<option value="2" <?php if($_GET['searchtype'] == 'phone'): ?>selected="selected"<?php endif; ?>>导出有微信登陆的用户</option>
							</select>
							
							&nbsp;&nbsp;用户注册时间：
							<input type="text" name="start_time" id="js-start-time" class="input-text Wdate" style="width: 150px" value="<?php echo ($_GET['start_time']); ?>" />- <input type="text" name="end_time" id="js-end-time" style="width: 150px" class="input-text Wdate" value="<?php echo ($_GET['end_time']); ?>" />
							<span class="date-quick-pick" data-days="7">最近7天</span>
							<span class="date-quick-pick" data-days="30">最近30天</span>
							<input type="button" value="查询并导出" class="button search_checkout"/>
						</form>
					</center></td>
				</tr>
			</table>
			<!--
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
						<tr><th colspan="8"><center style="font-size:14px;font-weight:700">导出记录</center></th></tr>
							<tr>
								<th>ID</th>
								<th>昵称</th>
								<th>手机号</th>
								<th>店铺数量</th>
								<th>最后登录时间</th>
								<th>最后登录IP</th>
								<th class="textcenter">状态</th>
								<th class="textcenter">操作</th>
							</tr>
						</thead>
						<tbody>
							
							
									<tr>
										<td><?php echo ($vo["uid"]); ?></td>
										<td><?php echo ($vo["nickname"]); ?></td>
										<td><?php echo ($vo["phone"]); ?></td>
										<td><?php if ($vo['stores'] > 0) { ?><a href="javascript:;" href="javascript:void(0);" style="color: #3865B8" onclick="window.top.artiframe('<?php echo U('User/stores',array('id' => $vo['uid'], 'frame_show' => true));?>','商家“<?php echo ($vo["nickname"]); ?>”的店铺',750,700,true,false,false,false,'detail',true);"><?php echo ($vo["stores"]); ?></a><?php } else { ?>0<?php } ?></td>
										<td><?php echo (date('Y-m-d H:i:s',$vo["last_time"])); ?></td>
										<td><?php echo ($vo["last_ip_txt"]); ?></td>
										<td class="textcenter"><?php if($vo['status'] == 1): ?><font color="green">正常</font><?php else: ?><font color="red">禁止</font><?php endif; ?></td>
										<td class="textcenter"><a href="javascript:void(0);" onclick="window.top.artiframe('<?php echo U('User/edit',array('uid'=>$vo['uid']));?>','编辑用户信息',620,360,true,false,false,editbtn,'edit',true);">编辑</a>&nbsp;|&nbsp;<a href="<?php echo U('tab_store',array('uid'=>$vo['uid']));?>" target="_blank">进入店铺</a></td>
									</tr>
								
								<tr><td class="textcenter pagebar" colspan="9"><?php echo ($pagebar); ?></td></tr>
							
								<tr><td class="textcenter red" colspan="8">列表为空！</td></tr>
							
						</tbody>
					</table>
				</div>
			</form>
			-->
		</div>
		
<script>
//搜索有多少需要导出

$(".search_checkout").click(function(){
	var searchtype = $("select[name='searchtype']").val();
	var start_time = $("input[name='start_time']").val();
	var end_time = $("input[name='end_time']").val();

	var start_time1 = start_time.replace(/:/g,'-');
	start_time1 = start_time1.replace(/ /g,'-');
	var arr1 = start_time1.split("-");
	var end_time1 = end_time.replace(/:/g,'-');
	end_time1 = end_time1.replace(/ /g,'-');
	var arr2 = end_time1.split("-");
	var datum1 = new Date(Date.UTC(arr1[0],arr1[1]-1,arr1[2],arr1[3]-8,arr1[4],arr1[5]));
	var starttime = datum1.getTime()/1000;
	var datum2 = new Date(Date.UTC(arr2[0],arr2[1]-1,arr2[2],arr2[3]-8,arr2[4],arr2[5]));
	var endtime = datum2.getTime()/1000;
		
	if(!start_time || !end_time || starttime >= endtime) {

		layer.alert('开始时间不能小于结束时间！', 8); 
		return;
	}
	
	
	var loadi =layer.load('正在查询', 10000000000000);
	$.post(
			"<?php echo U('User/checkout');?>",
			{"searchtype":searchtype,"start_time":start_time,"end_time":end_time},
			function(obj) {
				layer.close(loadi);
				if(obj.msg>0) {
					layer.confirm('该指定条件下有 用户  '+obj.msg+' 人，确认导出？',function(index){
					 	layer.close(index);
					 	location.href="<?php echo U('User/download_csv_byuser');?>&searchtype="+searchtype+"&start_time="+starttime+"&end_time="+endtime;

					
					});
				} else {
					layer.alert('该搜索条件下没有用户数据，无需导出！', 8); 
				}
				
			},
			'json'
	)

})





</script>		
		
	</body>
</html>