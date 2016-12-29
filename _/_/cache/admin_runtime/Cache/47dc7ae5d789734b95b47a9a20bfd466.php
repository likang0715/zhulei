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
<style>
.cursor{cursor:pointer;}
.display_edit,.display_save{background:url('./source/tp/Project/tpl/Static/images/glyphicons-halflings.png') no-repeat;}
.display_edit{background-position: -20px -23px;display:inline-block;height:20px;width:20px;}
.display_save{background-position: -283px 0px;display:inline-block;height:20px;width:20px;}
</style>
		<div class="mainbox">
			<div id="nav" class="mainnav_title">
				<ul>
					<a href="<?php echo U('Physicals/index');?>" class="on">茶馆列表</a>
				</ul>
			</div>
			<table class="search_table" width="100%">
				<tr>
					<td>
						<form action="<?php echo U('Physical/index');?>" method="get">
							<input type="hidden" name="c" value="Physical"/>
							<input type="hidden" name="a" value="index"/>
							<select name="type">
					            <option value="name" <?php if($_GET['type'] == 'name'): ?>selected="selected"<?php endif; ?>>茶馆名称</option>
								<option value="tel" <?php if($_GET['type'] == 'tel'): ?>selected="selected"<?php endif; ?>>茶馆电话</option>
								<option value="address" <?php if($_GET['type'] == 'address'): ?>selected="selected"<?php endif; ?>>茶馆地址</option>
							
							</select>
							筛选: <input type="text" name="keyword" class="input-text" value="<?php echo ($_GET['keyword']); ?>" />
							
                  							<input type="submit" value="查询" class="button"/>
											<input type="button" value="导出" class="button search_checkout">
						</form>
					</td>
				</tr>
			</table>
			<form name="myform" id="myform" action="" method="post">
				<div class="table-list">
					<table width="100%" cellspacing="0">
						<colgroup><col> <col> <col> <col><col><col><col><col><col width="240" align="center"> </colgroup>
						<thead>
							<tr>
								<th>编号</th>
                                <th>茶馆名称</th>
								<th>茶馆电话</th>
								<th>茶馆地址</th>
								<th>店铺名称</th>
								<th>商户账号</th>
								<th>商户联系人</th>
								<th>联系人电话</th>
								<th>更新时间</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($physicals)): if(is_array($physicals)): $i = 0; $__LIST__ = $physicals;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$store): $mod = ($i % 2 );++$i;?><tr>
										<td><?php echo ($store["store_id"]); ?></td>
                                        <td><?php echo ($store["name"]); ?></td>
										
										
										<td><?php echo ($store["phone1"]); ?>-<?php echo ($store["phone2"]); ?></td>
										<td><?php echo ($store["address"]); ?></td>
										<td><?php echo ($store["store_name"]); ?></td>
										<td><?php echo ($store["nickname"]); ?></td>
										<td><?php echo ($store["linkman"]); ?></td>
										<td><?php echo ($store["tel"]); ?></td>
                                        <td><?php echo (date('Y-m-d H:i:s', $store["last_time"])); ?></td>
                                   	   
									
										
                                       
									</tr><?php endforeach; endif; else: echo "" ;endif; ?>
								<tr><td class="textcenter pagebar" <?php if(in_array($my_version,array(4,8))) {?>colspan="9"  <?php }else{?>colspan="9"<?php }?>  ><?php echo ($page); ?></td></tr>
							<?php else: ?>
								<tr><td class="textcenter red" <?php if(in_array($my_version,array(4,8))) {?>colspan="7"  <?php }else{?>colspan="9"<?php }?> >列表为空！</td></tr><?php endif; ?>
						</tbody>
					</table>
				</div>
			</form>
		</div>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/layer/layer.min.js"></script>
		<script type="text/javascript">
    $(function() {

       $(".search_checkout").click(function(){
  
            var loadi =layer.load('正在导出', 10000000000000);

            var searchcontent = encodeURIComponent(window.location.search.substr(1));
            $.post(
                    "<?php echo U('Physical/index');?>",
                    {"searchcontent":searchcontent},
                    function(obj) {
                        layer.close(loadi);
                        if(obj.msg>0) {
                            layer.confirm('该条件下有记录  '+obj.msg+' 条，确认导出？',function(index){
                               layer.close(index);
                               location.href="<?php echo U('Physical/index');?>&searchcontent="+searchcontent+"&download=1";
                            });
                        } else {
                            layer.alert('该搜索条件下没有数据，无需导出！', 8); 
                        }
                        
                    },
                    'json'
            )

        })

    })
</script>
	</body>
</html>