<style type="text/css">
    .page-settlement .account-info .account-info-meta label {
        line-height: 0px;
    }
    .page-settlement .account-info img {
        width:90px;
        height: 90px;
    }
    .money{
        font-size: 25px;
    }
    .page-settlement .balance .balance-info {
        width: 24.33%;
    }
    .widget {
        margin-bottom: 30px;
    }
    .widget .widget-head {
        position: relative;
        height: 20px;
        padding: 10px;
        padding-bottom: 30px;
        line-height: 20px;
        background: rgba(255,255,255,1);
    }
    .widget .widget-head .widget-title {
        display: inline-block;
        margin: 0 12px 0 0;
        padding: 0 0 0 10px;
        font-size: 14px;
        font-weight: bold;
        line-height: 20px;
    }
    .widget .widget-nav {
        font-size: 12px;
        display: inline-block;
        vertical-align: baseline;
    }
    .widget .widget-head .help {
        position: absolute;
        top: 10px;
        right: 14px;
    }
    .income-total .arrow {
        left: 21%!important;
    }
    .sales-total .arrow {
        left: 26%!important;
    }
    .outlay-total .arrow {
        left: 27%!important;
    }
    .wait-outlay-total .arrow {
        left: 29%!important;
    }
    .margin-balance .arrow {
        left: 30%!important;
    }
    .withdrawal-amount .arrow {
        left: 30%!important;
    }
    .withdrawal-my-profit .arrow {
        left: 23%!important;
    }
    .withdrawal-wait-outlay .arrow {
        left: 48%!important;
    }
    .unwithdrawal-amount .arrow {
        left: 29%!important;
    }
    .return-amount .arrow {
        left: 57%!important;
    }
    .supplier-balance .arrow {
        left: 23%!important;
    }
    .wait-outlay-profit .arrow {
        left: 57%!important;
    }
    .paid-total .arrow {
        left: 36%!important;
    }
    .not-paid-total .arrow {
        left: 36%!important;
    }
    .return-owe-total .arrow {
        left: 36%!important;
    }
    .bond-balance-total .arrow {
        left: 57%!important;
    }
    .ui-nav-table li a {
        display: inline-block;
        padding: 0 12px;
        line-height: 35px;
        color: #333;
        border: 1px solid #ccc;
        background: #f8f8f8;
        min-width: 80px;
        text-align: center;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .ui-nav-table {
        position: relative;
        top: 2px;
    }
    .ui-nav-table li {
        float: left;
        margin-left: -1px;
    }
    .ui-nav-table li.active a {
        border-color: #E5E5E5 #E5E5E5 #fff;
        background: #F7F7F7;
        color: #07d;
    }
    .widget {
        margin-bottom: 30px;
        margin-top: 30px;
    }
    .widget .chart-body {
        clear: none;
        width: 100%;
        min-height: 281px;
        height: 281px;
        float: left;
    }
    .widget .widget-body {
        background: rgba(255,255,255,1);
        min-height: 150px;
    }
    .widget .chart-body {
        height: 310px;
    }
    .widget-pagedata .arrow {
        left: 93%!important;
    }
</style>
<script type="text/javascript">
    require.config({
        paths: {
            echarts: './static/js/echart'
        }
    });

    require(
        [
            'echarts',
            'echarts/chart/line',
        ],
        function (ec) {
            var myChart = ec.init(document.getElementById('chart-body'));
            myChart.setOption({
                tooltip : {
                    trigger: 'axis',
                    formatter: function(data){
                        var str = data[0].name + "<br/>";
                        for (i in data) {
                            str += data[i].seriesName + '：' + data[i].value.toFixed(2) + '<br/>';
                        }
                        return str;
                    },
                    backgroundColor : 'white',
                    borderColor : 'black',
                    borderWidth : 2,
                    borderRadius : 5,
                    textStyle : {color : 'black'},
                    axisPointer : {
                        type: 'line',
                        lineStyle: {
                            color: '#8FD1FA',
                            width: 1,
                            type: 'dotted'
                        }
                    }
                },
                legend: {
                    data:['收入(元)',<?php if (empty($_SESSION['store']['drp_supplier_id'])) { ?>'支出(元)',<?php } else { ?>'利润(元)',<?php } ?>'提现(元)']
                },
                grid: {
                    x: 80,
                    y: 60,
                    x2: 80,
                    y2: 60,
                    width : '700px',
                    backgroundColor: 'rgba(0,0,0,0)',
                    borderWidth: 0,
                    borderColor: '#ccc'
                },
                calculable : true,
                xAxis : [
                    {
                        type : 'category',
                        boundaryGap : false,
                        axisLine : {show : false},
                        axisTick : {show : false},
                        splitLine : {show : false},
                        data : <?php echo $days; ?>
                    }
                ],
                yAxis : [
                    {
                        type : 'value',
                        axisLine : {show : false},
                        splitArea : {show : false},
                        splitLine : {
                            show : true,
                            lineStyle : {
                                color: ['#ccc'],
                                width: 1,
                                type: 'dotted'
                            }
                        }
                    }
                ],
                series : [
                    {
                        name:'收入(元)',
                        type:'line',
                        smooth:true,
                        data:<?php echo $days_7_income; ?>
                    },
                    <?php if (empty($_SESSION['store']['drp_supplier_id'])) { ?>
                    {
                        name:'支出(元)',
                        type:'line',
                        smooth:true,
                        data:<?php echo $days_7_outlay; ?>
                    },
                    <?php } else { ?>
                    {
                        name:'利润(元)',
                        type:'line',
                        smooth:true,
                        data:<?php echo $days_7_profit; ?>
                    },
                    <?php } ?>
                    {
                        name:'提现(元)',
                        type:'line',
                        smooth:true,
                        data:<?php echo $days_7_withdrawal; ?>
                    }
                ]
            });
        }
    );
</script>
<div>
    <div class="page-settlement">
        <div class="ui-box settlement-info">
            <?php if(empty($version) && empty($_SESSION['sync_store'])){?>
            <div class="account-info">
                <img src="<?php echo $store['logo']; ?>" class="logo"/>
                <div class="account-info-meta">
                    <div class="info-item" style="margin-top: 0px;">
                        <label>店铺名称：</label>
                        <span><?php echo $store['name']; ?></span>
                    </div>
                    <div class="info-item">
                        <label>收款账户：</label>
                        <span><?php if (!empty($store['bank_card_user'])) { ?><?php echo $store['bank_card_user']; ?><?php } else { ?>未填写<?php } ?></span>
                    </div>
                    <div class="info-item">
                        <label>银行卡号：</label>
                        <span><?php if (!empty($store['bank_card'])) { ?><?php echo $store['bank_card']; ?><?php } else { ?>未填写<?php } ?></span>
                        <?php if($is_change_bankcard_open || empty($store['bank_card'])){ ?>
                            <a href="javascript:;" class="js-setup-account">修改提现账号</a>
                        <?php } ?>
                    </div>
                    <div class="info-item">
                        <label>累计提现：<span class="money" style="font-size: 20px;color:green"><?php echo $store['withdrawal_amount']; ?></span> <span class="unit">元</span></label><?php if (empty($_SESSION['store']['drp_supplier_id'])) { ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>店铺收款：<span class="money" style="font-size: 20px;color:green"><?php echo $store['store_pay_income']; ?></span> <span class="unit">元</span></label> <label><span>&nbsp;&nbsp;&nbsp;已发放奖金: <span class="money" style="font-size: 20px;color:green"><?php echo $sended_dividends; ?></span> <span class="unit">元</span>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" class="ui-btn ui-btn-primary js-send-jj disabled" style="height:16px;line-height: 16px;" >发放奖金</a><a href="javascript:;" class="js-bonus-mx">明细</a></span></label><?php } ?>
                       
                    </div>
                </div>

            </div>
            <?php } ?>

            <?php if (empty($_SESSION['store']['drp_supplier_id'])) { ?>
            <div class="balance">
                <div class="balance-info income-total" style="border-left: none; position:relative">
                    <div class="balance-title">累计收益
                        <div class="help"></div>
                        <div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: 25px; display: none;">
                            <div class="arrow"></div>
                            <div class="popover-inner">
                                <div class="popover-content">
                                    <p><strong>累计收益:</strong> 店铺总收入。</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="balance-content">
                        <span class="money"><?php echo $store['income']; ?></span>
                        <span class="unit">元</span>
                    </div>
                </div>

                <div class="balance-info supplier-balance" style="position:relative">
                    <div class="balance-title">可提现金额
                        <div class="help"></div>
                        <div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: 35px; display: none;">
                            <div class="arrow"></div>
                            <div class="popover-inner">
                                <div class="popover-content">
                                    <p><strong>可提现金额:</strong> 交易完成并未提现的金额</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="balance-content">
                        <span class="money"><?php echo $store['balance']; ?></span>
                        <span class="unit">元</span>
                    </div>
                </div>

                <div class="balance-info unwithdrawal-amount" style="position:relative">
                    <div class="balance-title">待结算金额
                        <div class="help"></div>
                        <div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: 15px; display: none;">
                            <div class="arrow"></div>
                            <div class="popover-inner">
                                <div class="popover-content">
                                    <p><strong>待结算金额:</strong> 交易未完成的订单总额。</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="balance-content">
                        <span class="money"><?php echo $store['unbalance']; ?></span>
                        <span class="unit">元</span>
                    </div>
                </div>

                <div class="balance-info wait-outlay-profit" style="position:relative">
                    <div class="balance-title">待支出分润
                        <div class="help"></div>
                        <div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: -65px; display: none;">
                            <div class="arrow"></div>
                            <div class="popover-inner">
                                <div class="popover-content">
                                    <p><strong>待支出分润:</strong> 欠分销商的分销利润。</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="balance-content">
                        <span class="money"><?php echo $store['wait_outlay_profit']; ?></span>
                        <span class="unit">元</span>
                    </div>
                </div>
                <div style="clear: both"></div>
            </div>
            <?php if (empty($version) && !empty($allow_platform_drp)) { ?>
            <div class="balance">
                <div class="balance-info paid-total" style="border-left: none; position:relative">
                    <div class="balance-title">已支付给供货商
                        <div class="help"></div>
                        <div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: 25px; display: none;">
                            <div class="arrow"></div>
                            <div class="popover-inner">
                                <div class="popover-content">
                                    <p><strong>已支付给供货商:</strong> 已支付的供货商订单总额。</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="balance-content">
                        <span class="money"><?php echo $store['paid_amount']; ?></span>
                        <span class="unit">元</span>
                        <!--<a href="javascript:;" class="ui-btn ui-btn-primary pull-right ui-btn-disabled js-goto" data-goto="renzheng" disabled="disabled">提现</a>-->
                        <?php if(empty($version) && $store['drp_level'] != 0){?>
                        <a href="<?php if ($store['balance'] <= 0) { ?>javascript:;<?php } else { ?>#<?php if ($bind_bank_card) { ?>applywithdrawal<?php } else { ?>settingwithdrawal<?php } ?><?php } ?>" class="ui-btn ui-btn-primary pull-right <?php if ($store['balance'] <= 0) { ?>ui-btn-disabled<?php } else { ?>js-goto<?php } ?>" data-goto="renzheng">提现</a>
                        <?php }?>
                    </div>
                </div>
                <div class="balance-info not-paid-total" style="position:relative">
                    <div class="balance-title">未支付欠供货商
                        <div class="help"></div>
                        <div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: 25px; display: none;">
                            <div class="arrow"></div>
                            <div class="popover-inner">
                                <div class="popover-content">
                                    <p><strong>未支付欠供货商:</strong> 未支付的供货商订单总额。</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="balance-content">
                        <span class="money"><?php echo $store['not_paid_amount']; ?></span>
                        <span class="unit">元</span>
                    </div>
                </div>
                <div class="balance-info return-owe-total" style="position:relative">
                    <div class="balance-title">因退货欠供货商
                        <div class="help"></div>
                        <div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: 25px; display: none;">
                            <div class="arrow"></div>
                            <div class="popover-inner">
                                <div class="popover-content">
                                    <p><strong>因退货欠供货商:</strong> 供货商处理批发商品退货不含成本的总额。</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="balance-content">
                        <span class="money"><?php echo $store['return_owe_amount']; ?></span>
                        <span class="unit">元</span>
                    </div>
                </div>
                <div class="balance-info bond-balance-total" style="position:relative">
                    <div class="balance-title">保证金余额(批发)
                        <div class="help"></div>
                        <div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: -65px; display: none;">
                            <div class="arrow"></div>
                            <div class="popover-inner">
                                <div class="popover-content">
                                    <p><strong>保证金余额:</strong> 在供货商处缴纳的保证金剩余金额。</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="balance-content">
                        <span class="money"><?php echo $store['bond_balance']; ?></span>
                        <span class="unit">元</span>
                    </div>
                </div>
                <div style="clear: both"></div>
            </div>
            <?php } ?>
            <?php } else { ?>
            <div class="balance">
                <div class="balance-info sales-total" style="border-left: none; position:relative">
                    <div class="balance-title">累计销售额
                        <div class="help"></div>
                        <div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: 25px; display: none;">
                            <div class="arrow"></div>
                            <div class="popover-inner">
                                <div class="popover-content">
                                    <p><strong>累计销售额:</strong> 店铺总销售额，不含分销利润。</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="balance-content">
                        <span class="money"><?php echo $store['sales_total']; ?></span>
                        <span class="unit">元</span>
                    </div>
                </div>

                <div class="balance-info withdrawal-my-profit" style="position:relative">
                    <div class="balance-title">可提现金额
                        <div class="help"></div>
                        <div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: 35px; display: none;">
                            <div class="arrow"></div>
                            <div class="popover-inner">
                                <div class="popover-content">
                                    <p><strong>可提现金额:</strong> 交易完成并未提现的金额</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="balance-content">
                        <span class="money"><?php echo $store['balance']; ?></span>
                        <span class="unit">元</span>
                    </div>
                </div>

                <div class="balance-info unwithdrawal-amount" style="border-left: none; position:relative">
                    <div class="balance-title">待结算金额
                        <div class="help"></div>
                        <div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: 15px; display: none;">
                            <div class="arrow"></div>
                            <div class="popover-inner">
                                <div class="popover-content">
                                    <p><strong>待结算金额:</strong> 交易未完成的订单总额。</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="balance-content">
                        <span class="money"><?php echo $store['unbalance']; ?></span>
                        <span class="unit">元</span>
                    </div>
                </div>

                <div class="balance-info return-amount" style="border-left: none; position:relative">
                    <div class="balance-title">已退货金额
                        <div class="help"></div>
                        <div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: -65px; display: none;">
                            <div class="arrow"></div>
                            <div class="popover-inner">
                                <div class="popover-content">
                                    <p><strong>退货金额:</strong> 店铺产生的退货总金额。</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="balance-content">
                        <span class="money"><?php echo $store['return_total']; ?></span>
                        <span class="unit">元</span>
                    </div>
                </div>

                <div style="clear: both"></div>
            </div>
            <?php } ?>

            <div id="js-pagedata" class="widget widget-pagedata">
                <div class="widget-inner">
                    <div class="widget-head">
                        <h3 class="widget-title">7日<?php if (empty($_SESSION['store']['drp_supplier_id'])) { ?>收入<?php } else { ?>销售<?php } ?>统计(截止今日)</h3>
                        <!--<ul class="widget-nav">
                            <li>
                                <a href="#">详细 》</a>
                            </li>
                        </ul>-->
                        <div class="help"></div>
                        <div class="js-intro-popover popover popover-help-notes bottom" style="top: 25px; left: 545px; display: none;">
                            <div class="arrow"></div>
                            <div class="popover-inner">
                                <div class="popover-content">
                                    <p><strong><?php if (empty($_SESSION['store']['drp_supplier_id'])) { ?>收入<?php } else { ?>销售额<?php } ?>:</strong> 最近7天的收入统计，含支出。</p>
                                    <?php if (empty($_SESSION['store']['drp_supplier_id'])) { ?>
                                    <p><strong>支出:</strong> 最近7天我的经销商/分销商提现成功统计。</p>
                                    <?php } else { ?>
                                    <p><strong>利润:</strong> 最近7天分销所获利润统计。</p>
                                    <?php } ?>
                                    <p><strong>提现:</strong> 最近7天我的经销商/分销商提现统计。</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="padding:5px 5px 25px 5px;text-align: center;background-color: white;">
                        <span style="color: #FF7F50">7日<?php if (empty($_SESSION['store']['drp_supplier_id'])) { ?>收入<?php } else { ?>销售额<?php } ?>(元)：<b><?php echo $days_7_income_total; ?></b></span>&nbsp;&nbsp;&nbsp;
                        <?php if (empty($_SESSION['store']['drp_supplier_id'])) { ?>
                        <span style="color: #87CEFA">7日支出(元)：<b><?php echo $days_7_outlay_total; ?></b></span>&nbsp;&nbsp;&nbsp;
                        <?php } else { ?>
                        <span style="color: #87CEFA">7日利润(元)：<b><?php echo $days_7_profit_total; ?></b></span>&nbsp;&nbsp;&nbsp;
                        <?php } ?>
                        <span style="color: #32CD32">7日提现(元)：<b><?php echo $days_7_withdrawal_total; ?></b></span>
                    </div>
                    <div class="widget-body with-border">
                        <div class="js-body widget-body__inner clearfix">
                            <div class="js-body-chart chart-body" id="chart-body">
                                <div class="widget-chart-no-data">暂无数据</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
