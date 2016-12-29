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
<style type="text/css">
    .table-list tfoot tr {
        height: 40px;
    }
     .date-quick-pick {
        display: inline-block;
        color: #07d;
        cursor: pointer;
        padding: 2px 4px;
        border: 1px solid transparent;
        margin-left: 12px;
        border-radius: 4px;
        line-height: normal;
    }
    .date-quick-pick.current {
        background: #fff;
        border-color: #07d!important;
    }
    .date-quick-pick:hover{border-color:#ccc;text-decoration:none}
    .search_table span{
        margin: auto 4px;
    }
</style>

<div class="mainbox">
    <div id="nav" class="mainnav_title">
        <ul>
             <?php if(is_array($credit_config)): $k = 0; $__LIST__ = $credit_config;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><a href="<?php echo U('Credit/record',array('record_type'=>$k));?>" <?php if($record_type == $k): ?>class="on url_for_checkout"<?php endif; ?>>
                    <?php echo ($vo); ?>
               </a>|<?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>

    <table class="search_table" width="100%">
        <tbody>
            <tr>
                 <td>         
                    <span>平台充值现金总额 <?php echo ($common_data[1]['value']); ?></span>
                    <span>平台积分收入（销毁） <?php echo ($common_data[0]['value']); ?></span><br />
                    <span>可用有效积分数 （用户  <?php echo ($user_point_balance); ?> 店铺  <?php echo ($store_point_balance); ?>）</span>
                    <span>用户积分池积分总额  <?php echo ($user_point_pool_sum); ?></span>                      
                </td>
            </tr>
        </tbody>
    </table>

     <table class="search_table" width="100%">
        <tr>
            <td>
                <form action="<?php echo U('Credit/record');?>" method="get">
                    <input type="hidden" name="c" value="Credit"/>
                    <input type="hidden" name="a" value="record"/>
                    <input type="hidden" name="record_type" value="<?php echo ($_GET['record_type']); ?>"/>
                    <input type="text" name="keyword" class="input-text" value="<?php echo ($_GET['keyword']); ?>" />
                    &nbsp;&nbsp;
                    <select name="ktype">
                       
                           <option value="order" <?php if($_GET['ktype'] == 'order'): ?>selected="selected"<?php endif; ?>>订单号</option>
                           <?php if($record_type != 1): ?><option value="store" <?php if($_GET['ktype'] == 'store'): ?>selected="selected"<?php endif; ?>>店铺名称</option><?php endif; ?>
                           <?php if($record_type == 1): ?><option value="user"  <?php if($_GET['ktype'] == 'user'): ?>selected="selected"<?php endif; ?>>用户名称</option>

                                 <option value="uid"  <?php if($_GET['ktype'] == 'uid'): ?>selected="selected"<?php endif; ?>>用户ID</option>

                                  <option value="phone"  <?php if($_GET['ktype'] == 'phone'): ?>selected="selected"<?php endif; ?>>手机号</option><?php endif; ?>
                          

                    </select>
                    &nbsp;&nbsp;
                    渠道：
                    <select name="channel">
                       
                           <option value="0" <?php if($_GET['channel'] == 0): ?>selected="selected"<?php endif; ?>>请选择</option>
                         
                           <option value="1"  <?php if($_GET['channel'] == 1): ?>selected="selected"<?php endif; ?>>线上</option>
                           
                           <option value="2"  <?php if($_GET['channel'] == 2): ?>selected="selected"<?php endif; ?>>线下</option>
                          
                    </select>
                    &nbsp;&nbsp;
                    内容：
                    <select name="type">
                       
                           <option value="0" <?php if($_GET['type'] == 0): ?>selected="selected"<?php endif; ?>>请选择</option>
                         
                           <option value="1"  <?php if($_GET['type'] == 1): ?>selected="selected"<?php endif; ?>>用户积分抵现</option>
                           
                           <option value="2"  <?php if($_GET['type'] == 2): ?>selected="selected"<?php endif; ?>>
                                <?php echo ($record_type == 1?'用户获得积分':'积分转现'); ?>
                           </option>
                        
                    </select>
                    &nbsp;&nbsp;时间：
                    <input type="text" name="start_time" id="js-start-time" class="input-text Wdate" style="width: 150px" value="<?php echo ($_GET['start_time']); ?>" />- <input type="text" name="end_time" id="js-end-time" style="width: 150px" class="input-text Wdate" value="<?php echo ($_GET['end_time']); ?>" />
                    <span class="date-quick-pick" data-days="7">最近7天</span>
                    <span class="date-quick-pick" data-days="30">最近30天</span>
                    <input type="submit" value="查询" class="button"/>
                    <input type="button" value="导出" class="button search_checkout" />
                </form>
            </td>
        </tr>
    </table> 
    
    <div class="table-list">
        <table width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>订单号</th>
                <?php if($record_type != 1): ?><th>店铺</th><?php endif; ?>
                <?php if($record_type == 1): ?><th>用户</th><?php endif; ?>
                <th>积分</th>
                <th>渠道</th>
                <th>内容</th>
                <th>时间</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($list)): if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lists): $mod = ($i % 2 );++$i;?><tr>
                        <td><span class="c-gray"><?php echo ($lists["order_no"]); ?></span></td>
                        <?php if($record_type != 1): ?><td><?php echo ($lists["store"]); ?></td><?php endif; ?>
                        <?php if($record_type == 1): ?><td><?php echo ($lists["nickname"]); ?></td><?php endif; ?>
                        <td><?php if($lists['point'][0] != '-'): ?>+<?php endif; echo ($lists['point']); ?></td>
                        <td><?php echo ($lists['channel'] == 1?'线下':'线上'); ?></td>
                        <td><?php echo ($lists["bak"]); ?></td>
                        <td><?php echo (date('Y-m-d H:i:s', $lists["add_time"])); ?></td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; endif; ?>
            </tbody>
            <tfoot>
            <?php if(is_array($list)): ?><tr>
                    <td class="textcenter pagebar" colspan="14"><?php echo ($page); ?></td>
                </tr>
                <?php else: ?>
                <tr><td class="textcenter red" colspan="14">列表为空！</td></tr><?php endif; ?>
            </tfoot>
        </table>
    </div>

</div>
<script type="text/javascript" src="<?php echo ($static_public); ?>js/layer/layer.min.js"></script>

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
</script>
	</body>
</html>