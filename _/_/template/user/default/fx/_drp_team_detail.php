<style type="text/css">
    .ui-nav {
        border: none;
        background: none;
        position: relative;
        border-bottom: 1px solid #e5e5e5;
        margin-top: 10px;
    }
    .ui-nav ul {
        zoom: 1;
        margin-bottom: -1px;
        margin-left: 1px;
    }
    .pull-left {
        float: left;
    }
    .ui-nav li {
        float: left;
        margin-left: -1px;
    }
    .ui-nav li a {
        display: inline-block;
        padding: 0 12px;
        line-height: 32px;
        color: #333;
        border: 1px solid #e5e5e5;
        background: #f8f8f8;
        min-width: 80px;
        text-align: center;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .ui-nav li.active a {
        font-size: 100%;
        border-bottom-color: #fff;
        background: #fff;
        margin: 0px;
        line-height: 32px;
    }
    .account-info {
        width: 540px;
        float: left;
    }
    .rank-info {
        margin-top: 30px;
        margin-left: 30px;
        padding: 20px;
        float: left;
    }
    .clear {
        clear: both;
    }
    .rank {
        float: right;
        width: 80px;
        height: 80px;
        background: url(<?php echo TPL_URL;?>images/rank.png) no-repeat;
        cursor: pointer;
        background-position: 1px 0px;
    }
    .rank-null {
        float: right;
        width: 80px;
        height: 80px;
        background: url(<?php echo TPL_URL;?>images/rank-null.png) no-repeat;
        cursor: pointer;
        background-position: 1px 0px
    }
    .rank-num {
        text-align: center;
        padding-top: 16px;
        font-size: 12px;
        color: #B98E36;
        font-weight: bold;
    }
    .rank-null .rank-num {
        color: gray;
    }
</style>
<div class="page-settlement">
    <div class="ui-box settlement-info">
        <div class="account-info">
            <div class="logo">
                <img src="<?php echo $drp_team['logo']; ?>" class="logo-img" /><br/><br/>
            </div>
            <div class="account-info-meta">
                <div class="info-item" style="margin-top: 0px;">
                    <label>团队名称：</label>
                    <span><?php echo $drp_team['name']; ?></span>
                </div>
                <div class="info-item">
                    <label>直属成员：</label>
                    <span><input type="text" name="member_label[]" data-level="1" class="member-label" value="<?php echo !empty($drp_team['member_labels'][0]['name']) ? $drp_team['member_labels'][0]['name'] : '直属成员'; ?>" /></span>
                </div>
                <div class="info-item team-member">
                    <label>二级成员：</label>
                    <span><input type="text" name="member_label[]" data-level="2" class="member-label" value="<?php echo !empty($drp_team['member_labels'][1]['name']) ? $drp_team['member_labels'][1]['name'] : '下级成员'; ?>" /></span>
                    <input type="hidden" name="team_id" class="team_id" value="<?php echo !empty($drp_team['pigcms_id']) ? $drp_team['pigcms_id'] : ''; ?>" />
                    <a href="javascript:;" class="ui-btn ui-btn-primary js-save-btn">保存</a>
                </div>
            </div>
            <div><label style="color: #999;">团队简介：</label><?php echo $drp_team['desc']; ?></div>
        </div>
        <div class="rank-info">
            <div class="rank" title="团队排名：<?php echo $drp_team['rank']; ?>">
                <div class="rank-num"><?php echo $drp_team['rank']; ?></div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <nav class="ui-nav clearfix">
        <ul class="pull-left">
            <li class="active"><a href="javascript:void(0);"><?php echo !empty($drp_team['member_labels'][0]['name']) ? $drp_team['member_labels'][0]['name'] : '直属成员'; ?> - 统计</a></li>
        </ul>
    </nav>
    <div class="balance">
        <div class="balance-info team-members" style="border-left: none; position:relative">
            <div class="balance-title">成员数量
                <div class="help"></div>
                <div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: 25px; display: none;">
                    <div class="arrow"></div>
                    <div class="popover-inner">
                        <div class="popover-content">
                            <p><strong>成员数量:</strong> 当前级别下团队成员数量。</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="balance-content">
                <span class="money"><?php echo !empty($drp_team['members_1']['member_count']) ? $drp_team['members_1']['member_count'] : 0; ?></span>
                <span class="unit">人</span>
            </div>
        </div>

        <div class="balance-info team-orders" style="position:relative">
            <div class="balance-title">订单数量
                <div class="help"></div>
                <div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: 35px; display: none;">
                    <div class="arrow"></div>
                    <div class="popover-inner">
                        <div class="popover-content">
                            <p><strong>订单数量:</strong> 当前级别下团队成员订单数量</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="balance-content">
                <span class="money"><?php echo !empty($drp_team['members_1']['orders']) ? $drp_team['members_1']['orders'] : 0; ?></span>
                <span class="unit">笔</span>
            </div>
        </div>

        <div class="balance-info team-sales" style="position:relative">
            <div class="balance-title">销售额
                <div class="help"></div>
                <div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: 15px; display: none;">
                    <div class="arrow"></div>
                    <div class="popover-inner">
                        <div class="popover-content">
                            <p><strong>销售额:</strong> 当前级别下团队成员销售额。</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="balance-content">
                <span class="money"><?php echo !empty($drp_team['members_1']['sales']) ? number_format($drp_team['members_1']['sales'], 2, '.', '') : '0.00'; ?></span>
                <span class="unit">元</span>
            </div>
        </div>

        <div style="clear: both"></div>
    </div>
    <nav class="ui-nav clearfix">
        <ul class="pull-left">
            <li class="active"><a href="javascript:void(0);"><?php echo !empty($drp_team['member_labels'][1]['name']) ? $drp_team['member_labels'][1]['name'] : '下级成员'; ?> - 统计</a></li>
        </ul>
    </nav>
    <div class="balance">
        <div class="balance-info team-members" style="border-left: none; position:relative">
            <div class="balance-title">成员数量
                <div class="help"></div>
                <div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: 25px; display: none;">
                    <div class="arrow"></div>
                    <div class="popover-inner">
                        <div class="popover-content">
                            <p><strong>成员数量:</strong> 当前级别下团队成员数量。</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="balance-content">
                <span class="money"><?php echo !empty($drp_team['members_2']['member_count']) ? $drp_team['members_2']['member_count'] : 0; ?></span>
                <span class="unit">人</span>
            </div>
        </div>

        <div class="balance-info team-orders" style="position:relative">
            <div class="balance-title">订单数量
                <div class="help"></div>
                <div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: 35px; display: none;">
                    <div class="arrow"></div>
                    <div class="popover-inner">
                        <div class="popover-content">
                            <p><strong>订单数量:</strong> 当前级别下团队成员订单数量</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="balance-content">
                <span class="money"><?php echo !empty($drp_team['members_2']['orders']) ? $drp_team['members_2']['orders'] : 0; ?></span>
                <span class="unit">笔</span>
            </div>
        </div>

        <div class="balance-info team-sales" style="position:relative">
            <div class="balance-title">销售额
                <div class="help"></div>
                <div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: 15px; display: none;">
                    <div class="arrow"></div>
                    <div class="popover-inner">
                        <div class="popover-content">
                            <p><strong>销售额:</strong> 当前级别下团队成员销售额。</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="balance-content">
                <span class="money"><?php echo !empty($drp_team['members_2']['sales']) ? number_format($drp_team['members_2']['sales'], 2, '.', '') : '0.00'; ?></span>
                <span class="unit">元</span>
            </div>
        </div>

        <div style="clear: both"></div>
    </div>
</div>