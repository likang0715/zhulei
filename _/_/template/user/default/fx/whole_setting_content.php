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

    .widget-account-pretty-text {
        position: absolute;
        top: 133px;
        display: none;
        background: #fffdca;
        border: 1px solid #facf66;
        color: #dd0000;
        width: 268px;
        height: 35px;
        line-height: 35px;
        padding: 0 10px;
        font-size: 18px;
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
    }
</style>
<?php $version = option('config.weidian_version');?>
<div class="widget-app-board ui-box" style="border: none;">
    <div class="widget-app-board-info">
        <h3>是否审核批发商</h3>
        <div>
            <p>经销商批发本店商品是否需要通过审核，如果需要请开启审核，默认为未启用。</p>
        </div>
    </div>
    <div class="widget-app-board-control audit">
        <label class="js-switch ui-switch pull-right <?php if ($is_required_to_audit) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?>"></label>
    </div>
</div>

<div class="widget-app-board ui-box" style="border: none;">
    <div class="widget-app-board-info">
        <h3>是否需要保证金</h3>
        <div style="margin-bottom:8px;">
            <p>经销商批发本店商品是否需要交纳保证金，如果需要请开启，默认为未启用。</p>
        </div>
        <h4>开启此功能需要设置保证金额度</h4>
        <div style="margin-top:5px;">
            <div style="float: left">
                <b style="color: #07d">额度:</b> <input type="text" style="width: 80px" name="bond" class="drp-limit-buy bond-setting" value="<?php echo $bond; ?>" /> <b style="color: #07d">元</b><br/>
            </div>
            <div style="float: left;padding-top: 0px">
                <input type="button" class="ui-btn-bond ui-btn ui-btn-primary save-btn" value="保 存" style="margin-left: 30px;margin-right: -28px" />
            </div>
            <div class="store-margin-account" style="float: left;padding-top: 0px;display:<?php if ($is_required_margin) { ?>block<?php } else { ?>none<?php } ?>">
                <input type="button" class="margin-account ui-btn-bond ui-btn ui-btn-primary save-btn" value="修改保证金帐号" style="margin-left: 30px" />
            </div>
        </div>

    </div>
    <div class="widget-app-board-control guidance">
        <label class="js-switch ui-switch pull-right <?php if ($is_required_margin) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?>"></label>
    </div>
</div>

<div class="widget-app-board ui-box" style="border: none;">
    <div class="widget-app-board-info">
        <h3>保证金额度剩余多少提醒充值</h3>
        <div style="margin-bottom:8px;">
            <p>经销商批发本店商品保证金额度剩余多少提醒充值，如果需要请开启，默认为未启用。</p>
        </div>
        <h4>开启此功能需要设置保证金最低额度</h4>
        <div style="margin-top:5px;">
            <div style="float: left">
                <b style="color: #07d">提醒额度:</b> <input type="text" style="width: 80px" name="margin_minimum" class="drp-limit-buy" value="<?php echo $margin_minimum; ?>" /> <b style="color: #07d">元</b><br/>
            </div>
            <div style="float: left;padding-top: 0px">
                <input type="button" class="ui-btn-margin ui-btn ui-btn-primary save-btn" value="保 存" style="margin-left: 30px" />
            </div>
        </div>

    </div>
    <div class="widget-app-board-control margin_amount">
        <label class="js-switch ui-switch pull-right <?php if ($margin_amount) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?>"></label>
    </div>
</div>

<div class="widget-app-board ui-box" style="border: none;">
    <div class="widget-app-board-info">
        <h3>是否开启排他批发</h3>
        <div>
            <p>开启排他批发后,所属批发商无法在成为别人的批发商,也无法查看其他的供货商。</p>
        </div>
    </div>
    <div class="widget-app-board-control open-store">
        <label class="js-switch ui-switch pull-right <?php if ($open_store_whole) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?>"></label>
    </div>
</div>





