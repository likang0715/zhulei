<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>商家提现</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/my_store_withdrawal.css">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/font-awesome.min.css">
    <script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
    <script src="<?php echo TPL_URL; ?>js/jquery.ba-hashchange.js"></script>
    <script src="<?php echo TPL_URL;?>index_style/js/base.js"></script>
    <script src="<?php echo TPL_URL;?>/js/my_store.js?id=<?php echo time();?>"></script>
    <script type="text/javascript">
        var sales_ratio = parseFloat("<?php echo $sales_ratio; ?>");
        var post_url = "my_store.php?action=withdrawal&id=<?php echo $store['store_id']; ?>";
        var store_id = "<?php echo $store['store_id']; ?>";
    </script>
    <style type="text/css">
        html{
            background: #f5f5f5;
        }
        .account-btn{
            width:50px;
        }
        .accountdiva:first-child{
            border-top: solid 1px #e1e1e1;
        }
        .buesscash-fl {
            width: 100px;
        }
        .to-money-div {
            display: none;
        }
        .withdrawal-money-div {
            display: none;
        }
        .cancel-btn {
            margin-top: 0px;
            background-color: lightgrey;
        }
    </style>
</head>
<body>
<!-- 导航条 -->
<div class="accountnav" style="margin-bottom: 10px;">
    <div class="fl accountnavli" data-hash="#point">兑现提现</div>
    <div class="fl accountnavli" data-hash="#amount">收益提现</div>
    <div class="clear"></div>
</div>

<!-- 可用积分提现 -->
<div class="accountdiv" style="display: none;">
    <div class="accountdiva">
        <div class="fl buesscash-fl">已变现积分</div>
        <div class="fl"><?php echo $store['point2money']; ?></div>
        <div class="clear"></div>
    </div>

    <div class="accountdiva">
        <div class="fl buesscash-fl">可提现金额</div>
        <div class="fl point2money-balance"><?php echo $store['point2money_balance']; ?></div>
        <div class="clear"></div>
    </div>

    <div class="accountdiva">
        <div class="fl buesscash-fl">银行卡号</div>
        <a class="edit-account" href="my_store.php?action=account&store_id=<?php echo $store['store_id']; ?>&type=point"><div class="fr account-btn" style="margin-left: 0px;"><span class="buesscash-addbtn">编 辑</span></div></a>
        <div class="fl bank-card"><?php echo $store['bank_card']; ?></div>
        <div class="clear"></div>
    </div>

    <div class="accountdiva">
        <div class="fl buesscash-fl">输入金额</div>
        <div class="fl"><input type="text" class="money" placeholder="请输入提现金额" /></div>
        <div class="clear"></div>
    </div>

    <div class="accountdiva">
        <div class="fl buesscash-fl">服务费</div>
        <div class="fl"><span class="buesscash-span service-fee-rate"><?php echo $sales_ratio; ?>%</span><span class="service-fee-money">0.00</span></div>
        <div class="clear"></div>
    </div>

    <div class="accountdiva to-money-div">
        <div class="fl buesscash-fl">可提现金额</div>
        <div class="fl to-money">0.00</div>
        <div class="clear"></div>
    </div>

    <div class="btn save-btn">提现申请</div>
    <div class="btn cancel-btn">返回</div>
</div>

<!-- 商家货款提现 -->
<div class="accountdiv">
    <div class="accountdiva">
        <div class="fl buesscash-fl">商家收益</div>
        <div class="fl"><?php echo $store['income']; ?></div>
        <div class="clear"></div>
    </div>

    <div class="accountdiva">
        <div class="fl buesscash-fl">可提现收益</div>
        <div class="fl balance"><?php echo $store['balance']; ?></div>
        <div class="clear"></div>
    </div>

    <div class="accountdiva">
        <div class="fl buesscash-fl">银行卡号</div>
        <a class="edit-account" href="my_store.php?action=account&store_id=<?php echo $store['store_id']; ?>&type=amount"><div class="fr account-btn" style="margin-left: 0px;"><span class="buesscash-addbtn">编 辑</span></div></a>
        <div class="fl bank-card"><?php echo $store['bank_card']; ?></div>
        <div class="clear"></div>
    </div>

    <div class="accountdiva">
        <div class="fl buesscash-fl">输入金额</div>
        <div class="fl"><input type="text" class="amount" placeholder="请输入提现金额" /></div>
        <div class="clear"></div>
    </div>

    <div class="accountdiva">
        <div class="fl buesscash-fl">服务费</div>
        <div class="fl"><span class="buesscash-span"><?php echo $sales_ratio; ?>%</span><span class="sales-ratio-money">0.00</span></div>
        <div class="clear"></div>
    </div>

    <div class="accountdiva withdrawal-money-div">
        <div class="fl buesscash-fl">可提现金额</div>
        <div class="fl withdrawal-money">0.00</div>
        <div class="clear"></div>
    </div>

    <div class="btn save-btn">提现申请</div>
</div>


</body>
</html>