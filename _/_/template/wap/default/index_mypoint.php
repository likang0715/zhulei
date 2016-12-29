<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>我的帐户</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/my_point_style.css">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/font-awesome.min.css">
    <script src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
    <script src="<?php echo TPL_URL; ?>js/jquery.ba-hashchange.js"></script>
    <style>
    .select-store{
        height:26px;
        line-height: 26px;
        margin-right:10px;
    }
    .change-store{
        border: 0px;
    }
    </style>
    <script>
	var noCart = true;
    </script>
    <script src="<?php echo TPL_URL;?>js/base.js"></script>
    <style>
	.motify{
		display:none;
		position:fixed;
		top:35%;
		left:50%;
		width:220px;
		padding:0;
		margin:0 0 0 -110px;
		z-index:9999;
		background:rgba(0, 0, 0, 0.8);
		color:#fff;
		font-size:14px;
		line-height:1.5em;
		border-radius:6px;
		-webkit-box-shadow:0px 1px 2px rgba(0, 0, 0, 0.2);
		box-shadow:0px 1px 2px rgba(0, 0, 0, 0.2);
		@-webkit-animation-duration 0.15s;
		@-moz-animation-duration 0.15s;
		@-ms-animation-duration 0.15s;
		@-o-animation-duration 0.15s;
		@animation-duration 0.15s;
		@-webkit-animation-fill-mode both;
		@-moz-animation-fill-mode both;
		@-ms-animation-fill-mode both;
		@-o-animation-fill-mode both;
		@animation-fill-mode both;
	}
	.motify .motify-inner{
		padding:10px 10px;
		text-align:center;
		word-wrap:break-word;
	}
	.motify p{
		margin:0 0 5px;
	}
	.motify p:last-of-type{
		margin-bottom:0;
	}
	@-webkit-keyframes motifyFx{
		0%{-webkit-transform-origin:center center;-webkit-transform:scale(1);opacity:1;}
		100%{-webkit-transform-origin:center center;-webkit-transform:scale(0.85);}
	}
	@-moz-keyframes motifyFx{
		0%{-moz-transform-origin:center center;-moz-transform:scale(1);opacity:1;}
		100%{-moz-transform-origin:center center;-moz-transform:scale(0.85);}
	}
	@keyframes motifyFx{
		0%{-webkit-transform-origin:center center;-moz-transform-origin:center center;transform-origin:center center;-webkit-transform:scale(1);-moz-transform:scale(1);transform:scale(1);opacity:1;}
		100%{-webkit-transform-origin:center center;-moz-transform-origin:center center;transform-origin:center center;-webkit-transform:scale(0.85);-moz-transform:scale(0.85);transform:scale(0.85);}
	}
	.motifyFx{@-webkit-animation-name motifyFx;@-moz-animation-name motifyFx;@-ms-animation-name motifyFx;@-o-animation-name motifyFx;@animation-name motifyFx;}
	.select_store {
        padding:5px;
    }
    </style>
</head>
<?php
    if($store_id == 0){ 
        $user_class = 'accountnavli-active';
        $store_class = '';
        $account_user_class = '';
        $account_store_class = 'style="display: none;"';
    }else{
        $user_class = '';
        $store_class = 'accountnavli-active';
        $account_user_class = 'style="display: none;"';
        $account_store_class = '';
    }
?>
<body>
    <div class="accountnav">
        <div <?php if(!$store || !$platform_credit_open){ ?>style="width:100%"<?php }?> class="fl accountnavli <?php echo $user_class;?>" data-hash="#0">购物会员帐号</div>
        <?php if (!empty($store) && ($platform_credit_open == 1)) { ?>
        <div class="fl accountnavli <?php echo $store_class;?>" data-hash="#1">商家会员帐号</div>
        <?php } ?>
        <div class="clear"></div>
    </div>

    <!-- 用户帐号 -->
    <div class="account" <?php echo $account_user_class;?> >
        <div class="accountdiv" >
            <div class="fl">统计数据截止时间</div>
            <div class="fr"><?php echo $now; ?></div>
            <div class="clear"></div>
        </div>

        <div class="accountdiv">
            <div class="fl"><?php echo $point_alias; ?></div>
            <a href="my_point.php?action=udetaiil"><div class="fr account-fr">明细</div></a>
            <div class="clear"></div>

            <div class="account-info">
                <div class="fl account-info-div account-info-div-a">
                    <img src="<?php echo TPL_URL;?>images/icon-a.png" class="fl" alt="">
                    <div class="fl account-info-div-a-text">今日释放消费积分<br/>
                        <b style="color: #ff7216"><?php echo $user_info['today_send_point']; ?></b>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="fr account-info-div account-info-div-b">
                    <img src="<?php echo TPL_URL;?>images/icon-b.png" class="fl" alt="">
                    <div class="fl account-info-div-b-text">今日新增可用积分<br/>
                        <b style="color: #ff7216"><?php echo $user_info['today_point_balance']; ?></b>
                    </div>
                    <div class="clear"></div>
                    </div>
                <div class="clear"></div>
            </div>
        </div>
        
        <div class="accountdiv">
	        <div class="fl">用户做单</div>
	            <a href="user_offline_search.php"><div class="fr account-fr">做单</div></a>
	        <div class="clear"></div>
        </div>
		<div class="accountdiva">
            <div class="fl">做单管理</div>
            <a href="store_offline_list.php"><div class="fr account-btn"><span>查看</span></div></a>
            <div class="fr"></div>
            <div class="clear"></div>
        </div>
        <div class="accountdiva">
            <div class="fl">累计消费积分总额</div>
            <div class="fr account-btn"></div>
            <div class="fr"><?php echo $user_info['point_total']; ?></div>
            <div class="clear"></div>
        </div>

        <div class="accountdiva">
            <div class="fl">累计消费积分余额</div>
            <a href="my_point.php?action=give"><div class="fr account-btn"><span>积分赠送</span></div></a>
            <div class="fr"><?php echo $user_info['point_unbalance']; ?></div>
            <div class="clear"></div>
        </div>

        <div class="accountdiva">
            <div class="fl">累计已释放消费积分</div>
            <a href="my_point.php?action=release"><div class="fr account-btn"><span>明细</span></div></a>
            <div class="fr"><?php echo $user_info['release_point']; ?></div>
            <div class="clear"></div>
        </div>

        <div class="accountdiva">
            <div class="fl">累计购物赠消费积分</div>
            <a href="my_point.php?action=udetaiil&type=0,1,2,3"><div class="fr account-btn"><span>明细</span></div></a>
            <div class="fr"><?php echo $user_info['shopping_point_total']; ?></div>
            <div class="clear"></div>
        </div>

        <div class="accountdiva">
            <div class="fl">累计受赠消费积分</div>
            <a href="my_point.php?action=udetaiil&type=6"><div class="fr account-btn"><span>明细</span></div></a>
            <div class="fr"><?php echo $user_info['point_received']; ?></div>
            <div class="clear"></div>
        </div>

        <div class="accountdiva">
            <div class="fl">累计转赠消费积分</div>
            <a href="my_point.php?action=udetaiil&type=5"><div class="fr account-btn"><span>明细</span></div></a>
            <div class="fr"><?php echo $user_info['point_given']; ?></div>
            <div class="clear"></div>
        </div>

        <div class="accountdiva">
            <div class="fl">今日新增<?php echo $point_alias; ?></div>
            <div class="fr account-btn"></div>
            <div class="fr"><?php echo $user_info['today_user_point']; ?></div>
            <div class="clear"></div>
        </div>

        <div class="accountdiva">
            <div class="fl">累计可用积分</div>
            <div class="fr account-btn"></div>
            <div class="fr"><?php echo $user_info['point_balance_total']; ?></div>
            <div class="clear"></div>
        </div>

        <?php if (!empty($store)) { ?>
            <div class="accountdiva">
                <div class="fl">商家积分转可用积分</div>
                <a href="my_point.php?action=udetaiil&type=4"><div class="fr account-btn"><span>明细</span></div></a>
                <div class="fr"><?php echo $store['point2user']; ?></div>
                <div class="clear"></div>
            </div>
        <?php } ?>

        <div class="accountdiva">
            <div class="fl">可用积分余额</div>
            <div class="fr account-btn"></div>
            <div class="fr"><?php echo $user_info['point_balance']; ?></div>
            <div class="clear"></div>
        </div>

        <div class="accountdiva">
            <div class="fl">已消耗可用积分</div>
            <div class="fr account-btn"></div>
            <div class="fr"><?php echo $user_info['point_used']; ?></div>
            <div class="clear"></div>
        </div>

        <div class="accountdiva">
            <div class="fl">可用积分已兑换商品</div>
            <a href="my_point.php?action=udetaiil&type=1&channel=3"><div class="fr account-btn"><span>明细</span></div></a>
            <div class="fr"><?php echo $user_info['point2product']; ?></div>
            <div class="clear"></div>
        </div>
        <?php if (isset($store['offline_order_point'])) { ?>
        <div class="accountdiva">
            <div class="fl">可用积分转做单(商家)</div>
            <a href="my_point.php?action=udetaiil&type=1&channel=4"><div class="fr account-btn"><span>明细</span></div></a>
            <div class="fr"><?php echo $store['offline_order_point']; ?></div>
            <div class="clear"></div>
        </div>
        <?php } ?>
        <div class="accountdiva">
            <div class="fl">分享积分</div>
            <a href="my_point.php?action=tuiguang"><div class="fr account-btn"><span>明细</span></div></a>
            <!-- <div class="fr">2500</div> -->
            <div class="clear"></div>
        </div>
    </div>

    <!-- 商家帐号 -->
    <div class="account" <?php echo $account_store_class;?> >
        <div class="accountdiv">
            <div class="fl">统计数据截止时间</div>
            <div class="fr"><?php echo $now; ?></div>
            <div class="clear"></div>
        </div>

        <div class="accountdiv">
            <div class="account-con fl">
                <div class="account-condiv">
                    <img class="fl" src="<?php echo TPL_URL;?>images/icon-c.png" alt="<?php echo $store['name']; ?>">
                    <span class="fl"> 
                      <?php echo $store['name']; ?>
                    </span>
                </div>
            </div>
           
            
            <div class="fr account-fr change-store">
                <span> 
                        <select class="select_store" name="select_store" >
                            <option value="0" selected>请选择店铺</option>
                            <?php
                            foreach ($my_stores as $key => $value) {
                            ?>
                            <option value="<?php echo $value['store_id']; ?>"><?php echo $value['name']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                </span>

            </div>
            
            <div class="clear"></div>
        </div>
        
    <?php if ($access_offline_index == 1) { ?>
        <div class="accountdiva">
            <div class="fl">商家做单</div>
            <a href="my_offline.php?store_id=<?php echo $store['store_id']; ?>"><div class="fr account-btn"><span>做单</span></div></a>
            <div class="fr account-btn js-store_qrcode" data-store_id="<?php echo $store['store_id'] ?>"><span>店铺二维码</span></div>
            <div class="clear"></div>
        </div>
    <?php } ?>
    <?php if ($access_offline_list == 1) { ?>
        <div class="accountdiva">
            <div class="fl">做单管理</div>
            <a href="my_offline_list.php?store_id=<?php echo $store['store_id']; ?>"><div class="fr account-btn"><span>查看管理</span></div></a>
            
            <div class="clear"></div>
        </div>
    <?php } ?>


         <div class="accountdiva">
            <div class="fl">累计商家积分总额</div>
            <a href="my_point.php?action=store_point&store_id=<?php echo $store['store_id']; ?>"><div class="fr account-btn"><span>查看明细</span></div></a>
            <div class="fr"><?php echo $store['point_total']; ?></div>
            <div class="clear"></div>
        </div>

        <div class="accountdiva">
            <div class="fl">商家积分余额</div>
            <a href="my_point.php?action=exchange&store_id=<?php echo $store['store_id']; ?>"><div class="fr account-btn"><span>兑换/转移</span></div></a>
            <div class="fr"><?php echo $store['point_balance']; ?></div>
            <div class="clear"></div>
        </div>

        <div class="accountdiva">
            <div class="fl">已消耗商家积分</div>
            <a href="my_point.php?action=store_point_used&store_id=<?php echo $store['store_id']; ?>"><div class="fr account-btn"><span>查看明细</span></div></a>
            <div class="fr"><?php echo $store['point_used']; ?></div>
            <div class="clear"></div>
        </div>

        <div class="accountdiva">
            <div class="fl">累计商家积分转做单</div>
            <a href="my_point.php?action=store_point_used&store_id=<?php echo $store['store_id']; ?>&type=0&target=service_fee"><div class="fr account-btn"><span>查看明细</span></div></a>
            <div class="fr"><?php echo $store['store_point_order']; ?></div>
            <div class="clear"></div>
        </div>

        <div class="accountdiva">
            <div class="fl">累计转可用积分</div>
            <a href="my_point.php?action=store_point_used&store_id=<?php echo $store['store_id']; ?>&type=5&target=point"><div class="fr account-btn"><span>查看明细</span></div></a>
            <div class="fr"><?php echo $store['point2user']; ?></div>
            <div class="clear"></div>
        </div>

        <div class="accountdiva">
            <div class="fl">累计转可兑现现金</div>
            <a href="my_point.php?action=store_point_used&store_id=<?php echo $store['store_id']; ?>&type=2&target=amount"><div class="fr account-btn"><span>查看明细</span></div></a>
            <div class="fr"><?php echo $store['point2money_total']; ?></div>
            <div class="clear"></div>
        </div>

        <div class="accountdiva">
            <div class="fl">累计已扣兑现服务费</div>
            <a href="my_point.php?action=store_point_used&store_id=<?php echo $store['store_id']; ?>&type=2&target=service_fee"><div class="fr account-btn"><span>查看明细</span></div></a>
            <div class="fr"><?php echo $store['point2money_service_fee']; ?></div>
            <div class="clear"></div>
        </div>

        <div class="accountdiva">
            <div class="fl">今日新增商家积分</div>
            <div class="fr account-btn"></div>
            <div class="fr"><?php echo $store['today_point']; ?></div>
            <div class="clear"></div>
        </div>

        <div class="accountdiva" style="margin-top: 5px">
            <div class="fl">累计已提现金额</div>
            <a href="my_store.php?action=withdrawals&id=<?php echo $store['store_id']; ?>"><div class="fr account-btn"><span>查看明细</span></div></a>
            <div class="fr"><?php echo $store['point2money_withdrawal'];?></div>
            <div class="clear"></div>
        </div>

        <div class="accountdiva">
            <div class="fl">可兑现现金余额</div>
            <a href="my_store.php?action=withdrawal&id=<?php echo $store['store_id']; ?>#point"><div class="fr account-btn"><span>申请兑现</span></div></a>
            <div class="fr"><?php echo $store['point2money_balance']; ?></div>
            <div class="clear"></div>
        </div>


        <div class="accountdiva" style="margin-top: 5px;">
            <div class="fl">累计充值金额</div>
            <a href="my_margin.php?action=index&store_id=<?php echo $store['store_id']; ?>&type=0"><div class="fr account-btn"><span>查看明细</span></div></a>
            <div class="fr"><?php echo $store['margin_total']; ?></div>
            <div class="clear"></div>
        </div>

        <div class="accountdiva">
            <div class="fl">充值现金余额</div>
            <?php if($store['is_show_recharge_button']) { ?>
            <a href="recharge.php?store_id=<?php echo $store['store_id'] ?>"><div class="fr account-btn"><span>充值现金</span></div></a>
            <?php } else {?>
                <a><div class="fr account-btn"><span style="color:#44413F; border: solid 1px #44413F;">充值现金</span></div></a>
            <?php }?>
            <div class="fr"><?php echo $store['margin_balance']; ?></div>
            <div class="clear"></div>
        </div>

        <div class="accountdiva">
            <div class="fl">已消耗充值金额</div>
            <a href="my_margin.php?action=index&store_id=<?php echo $store['store_id']; ?>&type=1,2,3"><div class="fr account-btn"><span>查看明细</span></div></a>
            <div class="fr"><?php echo $store['margin_used']; ?></div>
            <div class="clear"></div>
        </div>

        <div class="accountdiva">
            <div class="fl">已充值返还金额</div>
            <a href="my_store.php?action=margin_withdrawal&id=<?php echo $store['store_id']; ?>"><div class="fr account-btn"><span>申请返还</span></div></a>
            <div class="fr"><?php echo $store['margin_withdrawal']; ?></div>
            <div class="clear"></div>
        </div>

    </div>
    
    <div id="js-share-guide" class="js-fullguide fullscreen-guide" style="display:none; font-size: 16px; line-height: 35px; color: #fff; text-align: center; background-color: rgba(0, 0, 0, 0.9); height: 100%; left: 0; position: fixed; text-align: center; top: 0; width: 100%; z-index: 2000;">
    	<div class="guide-inner">
    		请用户做单扫描此二维码<br>
    		<img src="" />
    	</div>
    </div>

<?php echo $share_data ?>
<script type="text/javascript">
	var scan_qrcode_scenario = "<?php echo $scene ?>";
    var click = false;
    var default_store_id = parseInt("<?php echo !empty($store['store_id']) ? $store['store_id'] : 0; ?>");
    $(function() {
        if (default_store_id > 0) {
            window.onpopstate = function(event) {
                var ref = document.referrer.toLowerCase();
                var back_hash = window.location.hash;
                if (back_hash == $('.accountnav > .accountnavli-active').data('hash') && click == false && ref.indexOf('my.php') <= 0) {
                    window.location.href = 'my.php';
                }
                click = false;
            };
            //绑定事件处理函数.
            history.pushState("", "", "");
        }

        var $accountDiv = $(".account-info-div"),
             accountDivWidth = $accountDiv.width(),
             accountA = $(".account-info-div-a-text").width(),
             accountb = $(".account-info-div-b-text").width(),
            textlen = Math.floor($accountDiv.width() / 14);

        if(accountA + 35 > accountDivWidth) {
            $(".account-info-div-a-text").text($(".account-info-div-a-text").text().slice(0,textlen-3)+"...");
        }
        if(accountb + 35 > accountDivWidth) {
            $(".account-info-div-b-text").text($(".account-info-div-b-text").text().slice(0,textlen-3)+"...");
        }

        $('.accountnav > .accountnavli').click(function(e) {
            click = true;
            $(this).addClass('accountnavli-active').siblings('.accountnavli').removeClass('accountnavli-active');
            var index = $(this).index('.accountnav > .accountnavli');
            $('.account').eq(index).show();
            $('.account').eq(index).siblings('.account').hide();
            window.location.hash = index;
        });

        if (window.location.hash != undefined) {
            var hash = window.location.hash;
            hash = hash.toLowerCase();
            if (hash == '#0') {
                index = 0;
                $('.accountnav > .accountnavli').eq(0).trigger('click');
            } else {
                index = 1;
                $('.accountnav > .accountnavli').eq(1).trigger('click');
            }
            click = false;
        }

        $('.change-store').change(function(){
            var store_id = $("select[name='select_store'] option:selected").val();
            if (store_id == default_store_id) {
                return false;
            }
            location.href = 'my_point.php?store_id='+store_id+'#1';
        });

		$(".js-store_scan").click(function () {
			scan_qrcode_func();
		});

		$(".js-store_qrcode").click(function () {
			var store_id = $(this).data("store_id");
			$("#js-share-guide img").attr("src", "my_memcard.php?action=store_ewm&store_id=" + store_id);
			$("#js-share-guide").show();
		});

		$("#js-share-guide").click(function () {
			$(this).hide();
		});

        $(window).hashchange( function(){
            var back_hash = window.location.hash;
            if (back_hash != $('.accountnav > .accountnavli-active').data('hash')) {
                window.location.href = 'my.php';
            }
        })
	});
	//扫一扫回调
	function scan_qrcode_callback(data) {
		if (data == '' || data == undefined) {
			motify.log('未找到店铺');
		}
		
		var data = data.split('-');
		var card = data[0]; // 1条形码 2二维码
		var scene = data[1];
		var store_id = data[2];
		
    	if (card != 2) {
    		motify.log('扫一扫只能扫描店铺做单二维码');
    		return false;
    	}
		
    	if (scan_qrcode_scenario != scene) {
    		motify.log('扫码场景有误，请扫描本站的店铺做单二维码');
    		return false;
    	}
		
    	if (store_id == undefined || store_id == '') {
    		motify.log('店铺不存在');
    	}
		
    	$.post("check_ewm.php?action=store_scan", {'store_id': store_id, 'card': card, 'scene': scene}, function(result) {
    		if (result.err_code == 0) {
    			location.href = "user_offline.php?store_id=" + store_id;
    		} else {
    			motify.log(result.err_msg);
    		}
    	});
    }
</script>
</body>
</html>