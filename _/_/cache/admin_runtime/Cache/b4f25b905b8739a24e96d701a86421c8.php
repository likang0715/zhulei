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
    .c-gray {
        color: #999;
    }
    .table-list tfoot tr {
        height: 40px;
    }
    .green {
        color: green;
    }
    .ui-money, .ui-money-income, .ui-money-outlay {
        font-weight: bold;
        color: #333;
    }
    .ui-money-income {
        color: #55BD47;
    }
    .ui-money-outlay {
        color: #f00;
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
    .statistics {
        padding: 5px;
    }
    .statistics ul {
        list-style: none;
    }
    .statistics ul li {
        float: left;
        width: 20%;
        height: 50px;
        padding: 10px 0;
    }
    .statistics ul li div {
        margin-left: 10px;
    }
</style>

<div class="mainbox">
    <div id="nav" class="mainnav_title">
        <ul>
            <a href="<?php echo U('Order/promotionRecord');?>" class="on" id="url_for_checkout" >奖金流水记录</a>
        </ul>
    </div>

    <div class="statistics">
        <ul>
            <li style="background-color: #6699CC">
                <div>
                    <b>推广奖励总额（元）</b><br>
                    <span class="money"><?php echo $promotion_reward; ?></span>
                </div>
            </li>
            <li style="background-color: #FF9966">
                <div>
                    <b>已发放总额（元）</b><br>
                    <span class="money"><?php echo $promotion_reward_send; ?></span>
                </div>
            </li>
            <?php if (empty($platform_credit_open)) { ?>
            <li style="background-color: #36C8A0">
                <div>
                    <b>最大可发放总额（元）</b><br>
                    <span class="money"><?php echo $withdrawal_service_fee; ?></span>
                </div>
            </li>
            <?php } ?>
            <li style="background-color: #FF6666">
                <div>
                    <b>今日发放总额（元）</b><br>
                    <span class="money"><?php echo $promotion_reward_send_today; ?></span>
                </div>
            </li>
            <li style="background-color: #669966">
                <div>
                    <b>今日新增总额（元）</b><br>
                    <span class="money"><?php echo $promotion_reward_today; ?></span>
                </div>
            </li>
        </ul>
    </div>

    <table class="search_table" width="100%">
        <tr>
            <td>
                <form action="<?php echo U('Order/promotionRecord');?>" method="get">
                    <input type="hidden" name="c" value="Order"/>
                    <input type="hidden" name="a" value="promotionRecord"/>
                    筛选: <input type="text" name="keyword" class="input-text" value="<?php echo ($_GET['keyword']); ?>" />
                    <select name="type">
                        <option value="store_id" <?php if($_GET['type'] == 'store_id'): ?>selected="selected"<?php endif; ?>>店铺ID</option>
                        <option value="store" <?php if($_GET['type'] == 'store'): ?>selected="selected"<?php endif; ?>>店铺名称</option>
                        <option value="admin_id" <?php if($_GET['type'] == 'admin_id'): ?>selected="selected"<?php endif; ?>>管理员ID</option>
                        <option value="account" <?php if($_GET['type'] == 'account'): ?>selected="selected"<?php endif; ?>>管理员账号</option>
                        <option value="order_no" <?php if($_GET['type'] == 'order_no'): ?>selected="selected"<?php endif; ?>>收支流水号</option>
                        <option value="trade_no" <?php if($_GET['type'] == 'trade_no'): ?>selected="selected"<?php endif; ?>>交易单号</option>
                    </select>
                    &nbsp;&nbsp;
                    类型：
                    <select name="record_type">
                        <option value="all">全部</option>
                        <option value="plus" <?php if($_GET['record_type']== 'plus'): ?>selected="true"<?php endif; ?>>奖励</option>
                        <option value="minus" <?php if($_GET['record_type']== 'minus'): ?>selected="true"<?php endif; ?>>发送</option>
                    </select>
                    &nbsp;&nbsp;
                    订单来源：
                    <select name="from_type">
                        <option value="0" <?php if($_GET['from_type']== 0): ?>selected="true"<?php endif; ?>>线上</option>
                        <option value="1" <?php if($_GET['from_type']== 1): ?>selected="true"<?php endif; ?>>线下</option>
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
                <th>所属推广者</th>
                <th>来自店铺</th>
                <th>奖励(元)</th>
                <th>发送(元)</th>
                <th>当时奖励比率(%)</th>
                <th>当时服务费</th>
                <!-- <th>收支流水号</th> -->
                <th>发送信息</th>
                <th>备注</th>
                <th>时间</th>
            </tr>
            </thead>
            <tbody>
            <?php if(!empty($promotions)): if(is_array($promotions)): $i = 0; $__LIST__ = $promotions;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$promotion): $mod = ($i % 2 );++$i;?><tr>
                        <td><span class="c-gray"><?php echo ($promotion["order_no"]); ?></span></td>
                        <td><?php echo ($promotion["account"]); ?></td>
                        <td><?php echo ($promotion["name"]); ?></td>
                        <td><span class="ui-money-income"><?php if($promotion['type'] == 0): ?>+ <?php echo ($promotion["amount"]); endif; ?></span></td>
                        <td><span class="ui-money-outlay"><?php if($promotion['type'] == 1): ?>- <?php echo ($promotion["amount"]); endif; ?></span></td>
                        <td><?php echo ($promotion["reward_rate"]); ?></td>
                        <td><?php echo ($promotion["service_fee"]); ?></td>
                        <!-- <td><?php echo ($promotion["trade_no"]); ?></td> -->
                        <td>
                            <?php if($promotion['type'] == 1): ?>由【<?php echo ($promotion["send_atype"]); ?>】<br>
                                <span style="color:red"><?php echo ($promotion["send_aname"]); ?></span> 通过
                                <span style="color:green"><?php echo ($promotion["pay_type"]); ?></span> 发送<?php endif; ?>
                        </td>
                        <td><?php echo ($promotion["bak"]); ?></td>
                        <td><?php echo (date('Y-m-d H:i:s', $promotion["add_time"])); ?></td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; endif; ?>
            </tbody>
            <tfoot>
            <?php if(!empty($promotions)): ?><tr>
                    <td class="textcenter pagebar" colspan="10"><?php echo ($page); ?></td>
                </tr>
                <?php else: ?>
                <tr><td class="textcenter red" colspan="10">列表为空！</td></tr><?php endif; ?>
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