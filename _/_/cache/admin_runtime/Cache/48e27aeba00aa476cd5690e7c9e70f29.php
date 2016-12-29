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
>         <style type="text/css">            .c-gray {                color: #999;            }            .table-list tfoot tr {                height: 40px;            }            .green {                color: green;            }            .gray {                color: grey;            }            .red {                color:red;            }            .date-quick-pick {                display: inline-block;                color: #07d;                cursor: pointer;                padding: 2px 4px;                border: 1px solid transparent;                margin-left: 12px;                border-radius: 4px;                line-height: normal;            }            .date-quick-pick.current {                background: #fff;                border-color: #07d!important;            }            .date-quick-pick:hover{border-color:#ccc;text-decoration:none}            .statistics {                padding: 5px;            }            .statistics ul {                list-style: none;            }            .statistics ul li {                float: left;                width: 25%;                height: 50px;                padding: 10px 0;            }            .statistics ul li div {                margin-left: 10px;            }        </style>        <script type="text/javascript">            $(function(){                $('.status-enable > .cb-enable').click(function(){                    if (!$(this).hasClass('selected')) {                        if ($(this).closest('.status-enable').siblings('.status-disable').children('.cb-disable').hasClass('selected')) {                            window.top.msg(0, '此记录状态已修改，不要重复修改状态', true);                            return false;                        }                        var id = $(this).data('id');                        window.top.art.dialog({                            icon: 'question',                            title: '请确认',                            id: 'msg' + Math.random(),                            lock: true,                            fixed: true,                            opacity:'0.4',                            resize: false,                            content: '你确定这样操作吗？操作后可能不能恢复！',                            ok:function (){                                $.post("<?php echo U('Credit/chgReturnStatus'); ?>",{'status': 2, 'id': id}, function(data){                                    data = $.parseJSON(data);                                    window.top.msg(data.error, data.message, true);                                    if (data.error == 1) {                                        window.top.main_refresh();                                    }                                });                            },                            cancel:true                        });                        return false;                    }                })                $('.status-disable > .cb-disable').click(function(){                    if (!$(this).hasClass('selected')) {                        if ($(this).closest('.status-disable').siblings('.status-enable').children('.cb-enable').hasClass('selected')) {                            window.top.msg(0, '此记录状态已修改，不要重复修改状态', true);                            return false;                        }                        var id = $(this).data('id');                        window.top.art.dialog({                            icon: 'question',                            title: '请确认',                            id: 'msg' + Math.random(),                            lock: true,                            fixed: true,                            opacity:'0.4',                            resize: false,                            content: '你确定这样操作吗？操作后可能不能恢复！',                            ok:function (){                                $.post("<?php echo U('Credit/chgReturnStatus'); ?>", {'status': 3, 'id': id}, function (data) {                                    data = $.parseJSON(data);                                    window.top.msg(data.error, data.message, true);                                    if (data.error == 1) {                                        window.top.main_refresh();                                    }                                });                            },                            cancel:true                        });                        return false;                    }                })            })        </script>		<div class="mainbox">			<div id="nav" class="mainnav_title">				<ul>					<a href="<?php echo U('Credit/returnRecord');?>" class="on" id="url_for_checkout" >提现记录</a>				</ul>			</div>			<table class="search_table" width="100%">				<tr>					<td>						<form action="<?php echo U('Credit/returnRecord');?>" method="get">							<input type="hidden" name="c" value="Credit"/>							<input type="hidden" name="a" value="returnRecord"/>							筛选: <input type="text" name="keyword" class="input-text" value="<?php echo ($_GET['keyword']); ?>" />							<select name="type">								<option value="order_no" <?php if($_GET['type'] == 'order_no'): ?>selected="selected"<?php endif; ?>>单号</option>                                <option value="bank_account" <?php if($_GET['type'] == 'bank_account'): ?>selected="selected"<?php endif; ?>>银行账户</option>								<option value="store" <?php if($_GET['type'] == 'store'): ?>selected="selected"<?php endif; ?>>店铺名称</option>                                <option value="user" <?php if($_GET['type'] == 'user'): ?>selected="selected"<?php endif; ?>>申请人</option>								<option value="tel" <?php if($_GET['type'] == 'tel'): ?>selected="selected"<?php endif; ?>>联系电话</option>							</select>                            &nbsp;&nbsp;                            收款银行：                            <select name="bank">                                <option value="0">收款银行</option>                                <?php if(is_array($banks)): $i = 0; $__LIST__ = $banks;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$bank): $mod = ($i % 2 );++$i;?><option value="<?php echo ($bank["bank_id"]); ?>" <?php if($_GET['bank']== $bank['bank_id']): ?>selected<?php endif; ?>><?php echo ($bank["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>                            </select>                            &nbsp;&nbsp;处理状态：                            <select name="status">                                <option value="0">全部</option>                                <?php foreach ($status as $key => $value) { ?>                                <option value="<?php echo $key; ?>" <?php if ($_REQUEST['status'] == $key || ($key == 1 && $unprocessed > 0 && !isset($_GET['status']))) { ?>selected<?php } ?>><?php echo $value; ?></option>                                <?php } ?>                            </select>                            &nbsp;&nbsp;申请时间：                            <input type="text" name="start_time" id="js-start-time" class="input-text Wdate" style="width: 150px" value="<?php echo ($_GET['start_time']); ?>" readonly />- <input type="text" name="end_time" id="js-end-time" style="width: 150px" class="input-text Wdate" value="<?php echo ($_GET['end_time']); ?>" readonly />                            <span class="date-quick-pick" data-days="7">最近7天</span>                            <span class="date-quick-pick" data-days="30">最近30天</span>                            <input type="submit" value="查询" class="button"/>                            <input type="button" value="导出" class="button search_checkout" />						</form>					</td>				</tr>			</table>            <div class="table-list">                <table width="100%" cellspacing="0">                    <thead>                        <tr>                            <th>编号</th>                            <th>单号</th>                            <th>申请时间</th>                            <th>银行账户</th>                            <th>店铺名称</th>                            <th style="text-align: right">返还金额(元)</th>                            <th style="text-align: right">可用余额(元)</th>                            <th>申请人</th>                            <th>联系方式</th>                            <th>状态</th>                            <th>备注</th>                            <th class="textcenter">操作</th>                        </tr>                    </thead>                    <tbody>                        <?php if(is_array($platform_margin_logs)): if(is_array($platform_margin_logs)): $i = 0; $__LIST__ = $platform_margin_logs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$platform_margin_log): $mod = ($i % 2 );++$i;?><tr>                                    <td><?php echo ($platform_margin_log["pigcms_id"]); ?></td>                                    <td><span class="c-gray"><?php echo ($platform_margin_log["order_no"]); ?></span></td>                                    <td><?php echo (date('Y-m-d H:i:s', $platform_margin_log["add_time"])); ?></td>                                    <td>                                        <span class="c-gray">账户类型：</span><?php if($platform_margin_log['withdrawal_type'] == 0): ?>个人账户<?php else: ?>公司账户<?php endif; ?><br/>                                        <span class="c-gray">收款银行：</span><?php echo $platform_margin_log['bank']; ?><br />                                        <span class="c-gray">开户银行：</span><?php echo $platform_margin_log['opening_bank']; ?><br />                                        <span class="c-gray">银行帐户：</span><?php echo $platform_margin_log['bank_card']; ?><br />                                        <span class="c-gray">帐户名称：</span><?php echo $platform_margin_log['bank_card_user']; ?><br/><br/>                                    </td>                                    <td><?php echo ($platform_margin_log["store"]); ?></td>                                    <td style="text-align: right;color:green;font-weight: bold;"><?php echo ($platform_margin_log["amount"]); ?></td>                                    <td style="text-align: right"><?php echo ($platform_margin_log["margin_balance"]); ?></td>                                    <td><?php echo ($platform_margin_log["nickname"]); ?></td>                                    <td><?php echo ($platform_margin_log["tel"]); ?></td>                                    <td><?php if($platform_margin_log['status'] == 1): ?><span class="red">待处理</span><?php elseif($platform_margin_log['status'] == 2): ?><span class="green">已处理</span><?php elseif($platform_margin_log['status'] == 3): ?><span class="gray">已取消</span><?php endif; ?></td>                                    <td><?php echo ($platform_margin_log["bak"]); ?></td>                                    <td class="radio_box textcenter">                                        <div style="margin: 0 auto;width: 120px">                                            <span class="cb-enable status-enable"><label class="cb-enable<?php if ($platform_margin_log['status'] == 2) { ?> selected<?php } ?>" data-id="<?php echo $platform_margin_log['pigcms_id']; ?>"><span>已处理</span><input type="radio" name="status" value="2" <?php if ($platform_margin_log['status'] == 2) { ?> checked="checked"<?php } ?>></label></span>                                            <span class="cb-disable status-disable"><label class="cb-disable<?php if ($platform_margin_log['status'] == 3) { ?> selected<?php } ?>" data-id="<?php echo $platform_margin_log['pigcms_id']; ?>"><span>已取消</span><input type="radio" name="status" value="3" <?php if ($platform_margin_log['status'] == 3) { ?> checked="checked"<?php } ?>></label></span>                                            <div style="clear: both"></div>                                        </div>                                    </td>                                </tr><?php endforeach; endif; else: echo "" ;endif; endif; ?>                    </tbody>                    <tfoot>                        <?php if(is_array($platform_margin_logs)): ?><tr>                            <td class="pagebar" colspan="16">                                <div>                                    <div style="float: right">                                        <?php echo ($page); ?>                                    </div>                                </div>                            </td>                        </tr>                        <?php else: ?>                        <tr><td class="textcenter red" colspan="16">列表为空！</td></tr><?php endif; ?>                    </tfoot>                </table>            </div>		</div><script type="text/javascript" src="<?php echo ($static_public); ?>js/layer/layer.min.js"></script>

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