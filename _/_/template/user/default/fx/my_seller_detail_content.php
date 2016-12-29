<style type="text/css">
    .ui-nav {
        border: none;
        background: none;
        position: relative;
        border-bottom: 1px solid #e5e5e5;
        margin-bottom: 15px;
        margin-top: 23px;
    }
    .pull-left {
        float: left;
    }
    .ui-nav ul {
        zoom: 1;
        margin-bottom: -1px;
        margin-left: 1px;
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
        margin:0px;
        line-height: 32px;
    }



    #js-store-board {
        position: relative;
        padding-top: 10px;
        background: #fff;
        padding-left: 20px;
        background: #fff;
        border: 1px solid #fff;
    }

    .app-block-pageview {
        background-color: #fff;
        padding: 12px;
        margin-bottom: 15px;
        border: 1px solid #fff;
        border-top: 0;
        padding-top: 30px;
    }

    .ui-overview {
        background-color: #fff;
        padding: 12px;
        margin-bottom: -15px;
        border: 1px solid #fff;
        border-top: 0;
        padding-top: 30px;
    }

    .overview-group {
        display: inline-block;
        height: 61px;
        text-align: center;
        min-width: 0px;
        padding: 0 25px;
        border-left: 1px dotted #ccc;
        vertical-align: top;
        line-height: 2.4em;
    }

    .ui-store-board-desc {
        float: left;
        margin-left: 80px;
        margin-top: -74px;
    }

</style>
<nav class="clearfix">
    <div class="js-app-inner app-inner-wrap hide" style="display: block;">
        <div id="js-overview" class="ui-overview">

            <!--<div id="js-store-board" class="ui-store-board">
                <dl class="clearfix">
                    <dt class="js-store-board-logo ui-store-board-logo">
                        <a href="<?php /*echo option('config.wap_site_url'); */?>/home.php?id=<?php /*echo $sellerInfo['store_id']; */?>" target="_blank"><img style="width: 70px;height:70px;" src="<?php /*if ($sellerInfo['logo'] == '' || $sellerInfo['logo'] == './upload/images/') { */?><?php /*echo TPL_URL; */?>/images/logo.png<?php /*} else { */?><?php /*echo $sellerInfo['logo']; */?><?php /*} */?>" /></a>
                    </dt>
                    <dd class="ui-store-board-desc">
                        <h2><?php /*echo $sellerInfo['name']; */?></h2>
                    </dd>
                </dl>
            </div>-->
            <style>
                .js-logo {

                }
            </style>

            <div class="overview-group" style="border-left: 0px dotted #ccc;">
                <div class="clearfix">
                    <div class="js-logo">
                        <a href="<?php echo option('config.wap_site_url'); ?>/home.php?id=<?php echo $sellerInfo['store_id']; ?>" target="_blank"><img style="width: 70px;height:70px;margin-left: -107px;margin-bottom: 10px;" src="<?php if ($sellerInfo['logo'] == '' || $sellerInfo['logo'] == './upload/images/') { ?><?php echo TPL_URL; ?>/images/logo.png<?php } else { ?><?php echo $sellerInfo['logo']; ?><?php } ?>" /></a>
                    </div>
                    <div class="ui-store-board-desc">
                        <span style="font-size: 13px;">分销商昵称：</span><br/>
                        <span style="font-size: 15px;"><?php echo $sellerInfo['name']; ?></span>
                    </div>
                </div>
            </div>

            <div class="overview-group" style="border-left: 1px dotted #ccc;">
                <div class="overview-group-inner">
                    <span class="h4" style="font-size:20px;"><?php echo $currentLevel['level']; ?></span><br/>
                    <span class="h5"style="font-size: 15px;">当前等级</span>
                </div>
            </div>
            <div class="overview-group">
                <div class="overview-group-inner">
                    <span class="h4" style="font-size:20px;"><?php echo !empty($nextSellerNum) ? $nextSellerNum : '0'; ?></span><br/>
                    <span class="h5" style="font-size: 15px;">下级分销商数</span>
                </div>
            </div>
            <div class="overview-group">
                <div class="overview-group-inner">
                    <span class="h4" style="font-size:20px;"><?php echo !empty($nextTwoSellerNum) ? $nextTwoSellerNum : '0'; ?></span><br/>
                    <span class="h5"style="font-size: 15px;">下属二级分销商数</span>
                </div>
            </div>
        </div>
    </div>
</nav>
<nav class="ui-nav clearfix">
    <ul class="pull-left">
        <li class="<?php echo $level==1 ? 'active' : ''?>">
            <a href="#1" data-level="1">上级分销商</a>
        </li>
        <li class="<?php echo $level==2 ? 'active' : ''?>">
            <a href="#2" data-level="2">下一级分销商</a>
        </li>
        <li class="<?php echo  $level==3 ? 'active' : ''?>">
            <a href="#3" data-level="3">下两级分销商</a>
        </li>
    </ul>
</nav>

<style type="text/css">
    .red {
        color:red;
    }
</style>
<div class="goods-list">
    <div class="js-list-filter-region clearfix ui-box" style="position: relative;display:none;">
        <div class="widget-list-filter">
            <div class="filter-box">
                <div class="js-list-search">
                    分销商名称：<input class="filter-box-search js-search" type="text" placeholder="搜索" />&nbsp;&nbsp;&nbsp;&nbsp;
                    审核状态：
                    <select class="js-search-drp-approve" style="margin-bottom: 0px;height: auto;line-height: normal;width: auto;font-size: 12px;font-family: Helvetica,STHeiti,'Microsoft YaHei',Verdana,Arial,Tahoma,sans-serif;">
                        <option value="*">审核状态</option>
                        <option value="0">未审核</option>
                        <option value="1">已审核</option>
                    </select>
                    <input id="level" style='display:none' type="text" value="<?php echo $level;?>" />
                    <input type="button" class="ui-btn ui-btn-primary js-search-btn" value="搜索">
                </div>
            </div>
        </div>
    </div>
    <div class="ui-box">
        <table class="ui-table ui-table-list" style="padding: 0px;">
            <?php if (!empty($sellers)) { ?>
                <thead class="js-list-header-region tableFloatingHeaderOriginal">
                <tr class="widget-list-header">
                    <th colspan="2">分销商</th>
                    <th>客服电话</th>
                    <th>客服 QQ</th>
                    <th>客服微信</th>
                    <th>状态</th>
                    <th style="text-align: right">销售额(元)</th>
                    <th style="text-align: right">佣金(元)</th>
                    <th style="text-align: center">操作</th>
                </tr>
                </thead>
                <tbody class="js-list-body-region">
                <?php foreach ($sellers as $seller) { ?>
                    <tr class="widget-list-item">
                        <td class="goods-image-td">
                            <div class="goods-image">
                                <a href="<?php echo option('config.wap_site_url'); ?>/home.php?id=<?php echo $seller['store_id']; ?>" target="_blank">
                                    <img src="<?php echo $seller['store_logo']; ?>" />
                                </a>

                            </div>
                        </td>
                        <td class="goods-meta">

                            <a class="new-window" href="<?php echo option('config.wap_site_url'); ?>/home.php?id=<?php echo $seller['store_id']; ?>" target="_blank">
                                <?php if (isset($_POST['keyword']) && $_POST['keyword'] != '') { ?>
                                    <?php echo str_replace($_POST['keyword'], '<span class="red">' . $_POST['keyword'] . '</span>', $seller['name']); ?>
                                <?php } else { ?>
                                    <?php echo $seller['name']; ?>&nbsp;&nbsp;<span><?php echo $seller['drp_level']==0 ? '(顶级供货商)' : '('.$seller['drp_level'].'级分销商)';?></span>
                                <?php } ?>
                            </a>
                        </td>
                        <td>
                            <?php echo $seller['service_tel']; ?>
                        </td>
                        <td>
                            <?php if (!empty($seller['service_qq'])) { ?>
                                <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $seller['service_qq']; ?>&amp;site=qq&amp;menu=yes"><img src="<?php echo TPL_URL; ?>/images/qq.png" /></a>
                            <?php } else { ?>
                                <img src="<?php echo TPL_URL; ?>/images/unqq.png" />
                            <?php } ?>
                        </td>
                        <td>
                            <?php echo $seller['service_weixin']; ?>
                        </td>
                        <td>
                            <?php if ($seller['status'] == 0) { ?><span style="color:gray">已禁用</span><?php } else if (!empty($seller['drp_approve'])) { ?><span style="color:green">已审核</span><?php } else { ?><span style="color:red">未审核</span><?php } ?>
                        </td>
                        <td style="text-align: right"><a href="<?php dourl('statistics', array('store_id' => $seller['store_id']));?>"><?php echo $seller['sales']; ?></a></td>
                        <td style="text-align: right"><a href="<?php dourl('statistics', array('store_id' => $seller['store_id']));?>"><?php echo $seller['profit']; ?></a></td>
                        <td style="text-align: center">
                            <?php if (!empty($seller['drp_approve'])) { ?>
                                <span class="gray" style="cursor: no-drop">审核</span>
                            <?php } else { ?>
                                <a href="javascript:;" class="js-drp-approve" data-id="<?php echo $seller['store_id']; ?>">审核</a>
                            <?php } ?>
                            <span>-</span>
                            <a href="javascript:;" class="<?php if ($seller['status'] == 1) { ?>js-drp-disabled<?php } else if ($seller['status'] == 0) { ?>js-drp-enabled<?php } ?>" data-id="<?php echo $seller['store_id']; ?>"><?php if ($seller['status'] == 1) { ?>禁用<?php } else if ($seller['status'] == 0) { ?>启用<?php } ?></a>
                            <a href="<?php dourl('my_seller_detail', array('store_id' => $seller['store_id']));?>" class="js-drp-pprove" id="js-drp-approve" >层级关系</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            <?php } ?>
        </table>
        <div class="js-list-empty-region">
            <?php if (empty($sellers)) { ?>
                <div>
                    <div class="no-result widget-list-empty">还没有相关数据。</div>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="js-list-footer-region ui-box">
        <div>
            <div class="js-page-list pagenavi ui-box"><?php echo $page; ?></div>
            <input type="hidden" id="fx-level" value='<?php echo $level;?>'>
            <input type="hidden" id="fx-store-id" value='<?php echo $supplierId;?>'>
        </div>
    </div>
</div>