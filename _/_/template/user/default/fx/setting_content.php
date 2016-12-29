<style type="text/css">
    .dash-bar .info-group {
        float: left;
        width: 25.33%;
        padding-top: 18px;
    }
    .widget .chart-body {
        height: 345px;
    }
    .form-horizontal input {
        width: 206px!important;
    }
    .form-actions input {
        width: auto!important;
        height: auto;
    }
    input[type="radio"] {
        margin: 0;
        vertical-align: middle;
    }
    input[type="button"] {
        width: auto!important;
    }
    .text-strong {
        color: #FF6600;
    }
    .widget-product {
        height: 537px;
    }
    .modal-body {
        height: 420px;
        overflow-x: hidden;
        overflow-y: auto;
    }
    .green {
        color:green;
    }
    .modal-footer {
        font-size: 12px;
        color: #FF6600;
    }
    .platform-tag {
        display: inline-block;
        vertical-align: middle;
        color: #fff;
        font-size: 12px;
        line-height: 14px;
        border-radius: 2px;
        margin: 0;
        border: 0;
        font: inherit;
    }
    .price {
        color:orangered;
        display: inline-block;
        width: 120px;
    }
    .cost {
        color: gray;
    }
    .profit {
        color: green;
        display: inline-block;
        width: 150px;
    }
    .modal {
        width: 700px;
    }
    .wholesale-profit {
        color:#07d;
    }
</style>

<div class="widget-app-board ui-box" style="border: none;">
    <div class="widget-app-board-info" style="width: 100%">
        <h3>商品分润设置</h3>
        <div>
            <p>全局设置<a href="<?php dourl('supplier_market'); ?>">本店商品</a>的分销利润(%)</p><br/>
            <div style="float: left">
                <div>
                    <span style="color: #07d;display: inline-block;width: 120px;">一级分润（上上级）：</span> <input type="text" style="width: 80px" name="drp_profit_1" class="drp-profit drp-profit-1" value="<?php echo ($store_config['drp_profit_1'] > 0) ? $store_config['drp_profit_1'] : ''; ?>" /> <span style="color: #07d">%</span><br/>
                </div>
                <div>
                    <span style="color: #07d;display: inline-block;width: 120px;">二级分润（上级）：</span> <input type="text" style="width: 80px" name="drp_profit_2" class="drp-profit drp-profit-2" value="<?php echo ($store_config['drp_profit_2'] > 0) ? $store_config['drp_profit_2'] : ''; ?>" /> <span style="color: #07d">%</span><br/>
                </div>
                <div>
                    <span style="color: #07d;display: inline-block;width: 120px;">三级分润（直销）：</span> <input type="text" style="width: 80px" name="drp_profit_3" class="drp-profit drp-profit-3" value="<?php echo ($store_config['drp_profit_3'] > 0) ? $store_config['drp_profit_3'] : ''; ?>" /> <span style="color: #07d">%</span><br/>
                </div>
            </div>
            <div style="border-right: 1px dashed lightgray;float: left;height: 110px;margin-left: 10px">&nbsp;</div>
            <div style="float: left;padding-top: 40px">
                <input type="checkbox" name="unified_profit" value="1" class="unified-profit" id="unified-profit" <?php if ($store_config['unified_profit'] == 1) { ?>checked="true"<?php } ?> style="margin:0;margin-left: 10px;"/> <label for="unified-profit" style="color: #07d;display: inline-block;">统一直销利润</label><br/>
                <input type="checkbox" name="save_original_setting" value="1" class="save-original-setting" id="save-original-setting" <?php if ($store_config['drp_original_setting'] == 1) { ?>checked="true"<?php } ?> style="margin:0;margin-left: 10px;"> <label for="save-original-setting" style="color: #07d;display: inline-block;">保留原设置</label>
                <input type="button" class="ui-btn ui-btn-primary save-fx-btn" value="保 存" style="margin-left: 15px" />
            </div>
            <div class="alert" style="float: left;width:335px;height:105px;margin-left: 10px;">
                <span class="text-strong">温馨提示：</span><br/>
                1、全局设置本店商品（含批发商品）的分销利润，简化操作。<br/>
                2、分销利润以零售价的百分比填写，简化分润计算。<br/>
                3、分销价与本店设置的商品零售价统一，统一售价便于分销。<br/>
                4、需要单独设置的分销商品，请到 “<a href="<?php dourl('supplier_market'); ?>">本店商品</a>” 设置。<br/>
                5、保证原设置：之前单独设置的分销商品不会被覆盖。
            </div>
        </div>
    </div>
</div>

<?php $version = option('config.weidian_version');?>
<?php if(empty($version) && empty($_SESSION['sync_store'])){?>
<div class="widget-app-board ui-box" style="border: none;">
    <div class="widget-app-board-info">
        <h3>关注公众号</h3>
        <div>
            <p>店铺绑定公众号（认证服务号）后，若开启此项，粉丝需要关注公众号才能申请分销。</p>
            <div style="float: left;margin-top: 10px">
                <b style="color: #07d">封面图片</b> <a href="javascript:void(0);" class="upload-img1">上传图片</a> | <a href="javascript:void(0);" class="default-img1" data-img="<?php echo getAttachmentUrl('images/drp_ad_01.png', false); ?>">默认图片</a><br/><br/>
                <b style="color: #07d">消息模板</b>
                <textarea class="reg-drp-subscribe-tpl" cols="100" rows="3"><?php if (!empty($reg_drp_subscribe_tpl)) { ?><?php echo $reg_drp_subscribe_tpl; ?><?php } else { ?>尊敬的 {$nickname}, 感谢您关注 {$store} 公众号，点击申请分销。<?php } ?></textarea><br/>
            </div>
            <div style="border-right: 1px dashed lightgray;float: left;height: 97px;margin-left: 20px;margin-top: 20px">&nbsp;</div>
            <div style="float: left;padding-top: 0px">
                <input type="button" class="ui-btn ui-btn-primary save-btn1" value="保 存" style="margin-left: 30px;margin-top: 65px" />
                预览：<img class="preview1" src="<?php if (!empty($reg_drp_subscribe_img)) { ?><?php echo $reg_drp_subscribe_img; ?><?php } else { ?><?php echo getAttachmentUrl('images/drp_ad_01.png', false); ?><?php } ?>" width="220" />
            </div>
        </div>
        <div style="clear: both;color:orange;">温馨提示：若需要自定义消息模板，请保留{$xxx}，封面图片建议尺寸 900x600。</div>
    </div>
    <div class="widget-app-board-control drp-subscribe">
        <label class="js-switch ui-switch pull-right <?php if ($open_drp_subscribe) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?>"></label>
    </div>
</div>

<div class="widget-app-board ui-box" style="border: none;">
    <div class="widget-app-board-info">
        <h3>自动分销（关注公众号）</h3>
        <div>
            <p>店铺绑定公众号（认证服务号）后，若开启此项，粉丝关注公众号即可成为分销商。</p>
            <div style="float: left;margin-top: 10px">
                <b style="color: #07d">封面图片</b> <a href="javascript:void(0);" class="upload-img2">上传图片</a> | <a href="javascript:void(0);" class="default-img2" data-img="<?php echo getAttachmentUrl('images/drp_ad_02.png', false); ?>">默认图片</a><br/><br/>
                <b style="color: #07d">消息模板</b>
                <textarea class="drp-subscribe-tpl" cols="100" rows="3"><?php if (!empty($drp_subscribe_tpl)) { ?><?php echo $drp_subscribe_tpl; ?><?php } else { ?>尊敬的 {$nickname}, 您已成为 {$store} 第 {$num} 位分销商，点击管理店铺。<?php } ?></textarea><br/>
            </div>
            <div style="border-right: 1px dashed lightgray;float: left;height: 97px;margin-left: 20px;margin-top: 20px">&nbsp;</div>
            <div style="float: left;padding-top: 0px">
                <input type="button" class="ui-btn ui-btn-primary save-btn3" value="保 存" style="margin-left: 30px;margin-top: 65px" />
                预览：<img class="preview2" src="<?php if (!empty($drp_subscribe_img)) { ?><?php echo $drp_subscribe_img; ?><?php } else { ?><?php echo getAttachmentUrl('images/drp_ad_02.png', false); ?><?php } ?>" width="220" />
            </div>
        </div>
        <div style="clear: both;color:orange;">温馨提示：若需要自定义消息模板，请保留{$xxx}, {$num=100}支持默认值，封面图片建议尺寸 900x600。</div>
    </div>
    <div class="widget-app-board-control drp-subscribe-auto">
        <label class="js-switch ui-switch pull-right <?php if ($open_drp_subscribe_auto) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?>"></label>
    </div>
</div>
<?php } ?>


<?php if ($open_drp_team_platform) { ?>
    <div class="widget-app-board ui-box" style="border: none;">
        <div class="widget-app-board-info">
            <h3>分销团队</h3>
            <div>
                <p>一级分销商可以创建分销团队，以团队统计、排名等，默认为已启用。</p>
            </div>
        </div>
        <div class="widget-app-board-control drp-team">
            <label class="js-switch ui-switch pull-right <?php if ($open_drp_team) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?>"></label>
        </div>
    </div>
<?php } ?>


<?php if ($open_drp_degree_platform) { ?>
<div class="widget-app-board ui-box" style="border: none;">
    <div class="widget-app-board-info">
        <h3>分销商等级</h3>
        <div>
            <p>分销商有等级之分，每卖出一个分销商品可从供货商那里获得额外赠送的分销等级奖励，默认为已启用。</p>
            <p style="color: #07d;margin-top: 10px;"><b>扣分规则：</b>连续 <input type="text" name="drp_deduct_point_month" style="width: 60px" <?php if (!empty($drp_deduct_point_month) && $drp_deduct_point_month > 0) { ?>value="<?php echo $drp_deduct_point_month; ?>"<?php } ?> /> 个月，销售额未满 <input type="text" style="width:60px" name="drp_deduct_point_sales" <?php if (!empty($drp_deduct_point_sales) && $drp_deduct_point_sales > 0) { ?>value="<?php echo $drp_deduct_point_sales; ?>"<?php } ?> /> 元，扣除 <input type="text" style="width: 60px" name="drp_deduct_point" <?php if (!empty($drp_deduct_point) && $drp_deduct_point > 0) { ?>value="<?php echo $drp_deduct_point; ?>"<?php } ?> /> 积分作为惩罚。<input type="button" class="ui-btn ui-btn-primary save-btn5" value="保 存" /></p>
        </div>
        <div style="clear: both;color:orange;">温馨提示：此处统计的销售额不包含退货返还的金额。</div>
    </div>
    <div class="widget-app-board-control drp-degree">
        <label class="js-switch ui-switch pull-right <?php if ($open_drp_degree_store) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?>"></label>
    </div>
</div>
<?php } ?>


<!--<div class="widget-app-board ui-box" style="border: none;">
    <h3>二维码类别</h3>

    <div style="margin-top: 10px">
        <input type="radio" <?php /*echo empty($setting_canal_qrcode) ? 'checked' : '';*/?> name="qcode" value="0">
        <b style="font-weight: normal;">普通连接二维码 &nbsp;&nbsp;<span style="color:red;">(默认使用此二维码推广)</span> </b><br/>

        <input type="radio" <?php /*echo !empty($setting_canal_qrcode) ? 'checked' : '';*/?> name="qcode" value="1">
        <b style="font-weight: normal;">渠道二维码 &nbsp;&nbsp;<span style="color:red;">(如果没有店铺公众号,则使用平台公众号)</span> </b>
    </div>
    <div class="widget-app-qcode widget-app-board-info" style="display:<?php /*echo !empty($setting_canal_qrcode) ? 'block' : 'none'*/?>;">
        <h3>渠道二维码生成</h3>
        <div>
            <p>开启后分销二维码变成渠道二维码</p>
            <div style="float: left;margin-top: 10px">
                <b style="color: #07d">封面图片</b> <a href="javascript:void(0);" class="upload-img3">上传图片</a> | <a href="javascript:void(0);" class="default-img3" data-img="<?php /*echo getAttachmentUrl('images/drp_ad_01.png', false); */?>">默认图片</a><br/><br/>
                <b style="color: #07d">消息模板</b>
                <textarea class="canal_qrcode-tpl" cols="100" rows="3"><?php /*if (!empty($canal_qrcode_tpl)) { */?><?php /*echo $canal_qrcode_tpl; */?><?php /*} else { */?>尊敬的 {$nickname}, 感谢您关注 {$store}，点击进入店铺。<?php /*} */?></textarea><br/>
            </div>
            <div style="border-right: 1px dashed lightgray;float: left;height: 97px;margin-left: 20px;margin-top: 20px">&nbsp;</div>
            <div style="float: left;padding-top: 0px">
                <input type="button" class="ui-btn ui-btn-primary save-btn-can" value="保 存" style="margin-left: 30px;margin-top: 65px" />
                预览：<img class="preview3" src="<?php /*if (!empty($canal_qrcode_img)) { */?><?php /*echo $canal_qrcode_img; */?><?php /*} else { */?><?php /*echo getAttachmentUrl('images/drp_ad_01.png', false); */?><?php /*} */?>" width="220" />
            </div>
        </div>
        <div style="clear: both;color:orange;">温馨提示：若需要自定义消息模板，请保留{$xxx}，封面图片建议尺寸 900x600。</div>
    </div>
</div>-->



<div class="widget-app-board ui-box" style="border: none;">
    <div class="widget-app-board-info">
        <h3>分销审核</h3>
        <div>
            <p>店铺粉丝申请成为分销商是否需要通过审核，如果需要请开启审核，默认为未启用。</p>
        </div>
    </div>
    <div class="widget-app-board-control approve">
        <label class="js-switch ui-switch pull-right <?php if ($open_drp_approve) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?>"></label>
    </div>
</div>

<div class="widget-app-board ui-box" style="border: none;">
    <div class="widget-app-board-info">
        <h3>引导分销</h3>
        <div>
            <p>在店铺首页添加引导分销提醒，在商品页面显示分销利润，引导粉丝注册成为分销商</p>
            <p style="color:red">注:【引导分销】与【店铺订单通知】互斥，开启引导分销同时会关闭【店铺订单通知】 &nbsp; <a href="<?php echo url('setting:store').'#shop_notice'; ?>" target="_blank">设置店铺订单通知</a></p>
        </div>
    </div>
    <div class="widget-app-board-control guidance">
        <label class="js-switch ui-switch pull-right <?php if ($open_drp_guidance) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?>"></label>
    </div>
</div>

<div class="widget-app-board ui-box" style="border: none;">
    <div class="widget-app-board-info">
        <h3>分销限制</h3>
        <div>
            <p>设置粉丝申请分销商的门槛，为商家筛选优质分销商</p><br/>
            <div style="float: left">
                <b style="color: #07d">消费满</b> <input type="text" style="width: 80px" name="drp_limit_buy" class="drp-limit-buy" value="<?php echo $drp_limit_buy; ?>" /> <b style="color: #07d">元</b><br/>
                <!--<input type="radio" name="drp_limit_condition" class="drp-limit-condition" value="0" <?php /*if (empty($drp_limit_condition)) { */?>checked="true"<?php /*} */?> /> 或 / <input type="radio" name="drp_limit_condition" class="drp-limit-condition" value="1" <?php /*if (!empty($drp_limit_condition)) { */?>checked="true"<?php /*} */?> /> 和<br/>-->
                <!--<b style="color: #07d;display:inline-block;margin-top:20px">分享满</b> <input type="text" name="drp_limit_share" class="drp-limit-share" style="width: 80px" value="<?php /*echo $drp_limit_share; */?>" /> <b style="color: #07d">次</b>-->
            </div>
            <div style="border-right: 1px dashed lightgray;float: left;height: 30px;margin-left: 20px">&nbsp;</div>
            <div style="float: left;padding-top: 0px">
                <input type="button" class="ui-btn ui-btn-primary save-btn" value="保 存" style="margin-left: 30px" />
            </div>
        </div>
    </div>
    <div class="widget-app-board-control limit">
        <label class="js-switch ui-switch pull-right <?php if ($open_drp_limit) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?>"></label>
    </div>
</div>

<div class="widget-app-board ui-box" style="border: none;">
    <div class="widget-app-board-info">
        <h3>单次提现最低金额</h3>
        <div>
            <p>分销商向供货商单次提现最低金额，如果分销商可提现金额（分销利润）小于最低金额将无法提现，平台设置的供货商最低提现金额为：<?php if ($platform_withdrawal_min > 0) { ?><span style="color: red;"><?php echo $platform_withdrawal_min; ?></span> 元<?php } else { ?><span style="color:red;">不限</span><?php } ?>，可做参考为分销商设置最低提现金额。</p><br/>
            <div style="float: left">
                <b style="color: #07d">最低额：</b> <input type="text" style="width: 80px" name="drp_withdrawal_min" class="drp-withdrawal-min" value="<?php echo $drp_withdrawal_min; ?>" /> <b style="color: #07d">元</b><br/>
            </div>
            <div style="border-right: 1px dashed lightgray;float: left;height: 30px;margin-left: 20px">&nbsp;</div>
            <div style="float: left;padding-top: 0px">
                <input type="button" class="ui-btn ui-btn-primary save-withdrawal-btn" value="保 存" style="margin-left: 30px" />
            </div>
        </div>
    </div>
</div>

<div class="widget-app-board ui-box" style="border: none;">
    <div class="widget-app-board-info">
        <h3>允许分销修改店名LOGO</h3>
        <div>
            <p>设置分销商是否能修改店铺名称和LOGO</p><br/>
        </div>
    </div>
    <div class="widget-app-board-control update_name">
        <label class="js-switch ui-switch pull-right <?php if ($update_drp_store_info) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?>"></label>
    </div>
</div>

<div class="widget-app-board ui-box" style="border: none;">
    <div class="widget-app-board-info">
        <h3>粉丝终身制</h3>
        <div>
            <p>店铺开启粉丝终身制，访问的用户成为该店铺的粉丝后，再访问其它人的店铺，还是会跳到之前绑定的店铺。</p>
            <p><a href="javascript:void(0);" class="fans-list">粉丝列表>></a></p>
        </div>
    </div>
    <div class="widget-app-board-control fans_lifelong">
        <label class="js-switch ui-switch pull-right <?php if ($setting_fans_forever) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?>"></label>
    </div>
</div>

<?php if(empty($version) && empty($_SESSION['sync_store'])){?>
<div class="widget-app-board ui-box" style="border: none;">
    <div class="widget-app-board-info">
        <h3>粉丝分享自动成为分销商</h3>
        <div>
            <p>粉丝分享自动成为分销商</p>
        </div>
    </div>
    <div class="widget-app-board-control is_fanshare_drp">
        <label class="js-switch ui-switch pull-right <?php if ($is_fanshare_drp) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?>"></label>
    </div>
</div>
<?php } ?>
<?php if (!empty($_SESSION['store']['drp_diy_store'])) { ?>
<!--<div class="widget-app-board ui-box" style="border: none;">
    <div class="widget-app-board-info">
        <h3>允许分销商装修店铺</h3>
        <div>
            <p>启用此项分销商可自行装修店铺</p>
        </div>
    </div>
    <div class="widget-app-board-control drp-diy-store">
        <label class="js-switch ui-switch pull-right <?php /*if ($open_drp_diy_store) { */?>ui-switch-on<?php /*} else { */?>ui-switch-off<?php /*} */?>"></label>
    </div>
</div>-->

<!--<div class="widget-app-board ui-box" style="border: none;">
    <div class="widget-app-board-info">
        <h3>分销定价</h3>
        <div>
            <p>启用此配置在设置分销商品时会自动选择以下选中的定价方式，否则设置分销商品时手动选择定价方式</p>
            <div style="float: left;margin-top: 5px">
                <input type="radio" name="unified_price_setting" id="set-price-1" class="unified-price-setting" value="1" <?php /*if ($unified_price_setting) { */?>checked="1"<?php /*} */?> /> <label for="set-price-1" style="display: inline-block">统一定价（<span style="color:red">支持多级分销</span>）</label><br/>
                <input type="radio" name="unified_price_setting" id="set-price-0" class="unified-price-setting" value="0" <?php /*if (!$unified_price_setting) { */?>checked="1"<?php /*} */?> /> <label for="set-price-0" style="display: inline-block">自由定价（<span style="color:red">仅支持三级分销</span>）</label>
            </div>
            <div style="border-right: 1px dashed lightgray;float: left;height: 30px;margin-left: 20px;margin-top: 10px">&nbsp;</div>
            <div style="float: left;padding-top: 0px;margin-top: 10px">
                <input type="button" class="ui-btn ui-btn-primary save-btn2" value="保 存" style="margin-left: 30px" />
            </div>
        </div>
    </div>
    <div class="widget-app-board-control drp-setting-price">
        <label class="js-switch ui-switch pull-right <?php /*if ($open_drp_setting_price) { */?>ui-switch-on<?php /*} else { */?>ui-switch-off<?php /*} */?>"></label>
    </div>
</div>-->
<?php } ?>