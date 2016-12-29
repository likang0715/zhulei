<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="寄售模式Apple iPhone6s Plus 64G">
    <meta name="keywords" content="寄售模式Apple iPhone6s Plus 64G">
    <title><?php echo $unitary['name'] ?> - 夺宝</title>
    <link rel="stylesheet" type="text/css" href="<?php echo STATIC_URL;?>unitary/css/bef6decb938119df87327e5e548e997f221af746.css">
    <link rel="stylesheet" type="text/css" href="<?php echo STATIC_URL;?>unitary/css/5b1201a430fcaf2e9033b779401dd55184f1dcec.css">
    <link rel="stylesheet" type="text/css" href="<?php echo STATIC_URL;?>unitary/css/b759d764a4df6cc7278af1542ecd318fef5a0d28.css">
    <link rel="stylesheet" type="text/css" href="<?php echo STATIC_URL;?>unitary/css/3b98125faf6f82d2406430c9cddfefcd32855604.css">
    <script src="<?php echo STATIC_URL;?>unitary/js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        var buy_list_url = "<?php dourl('unitary:buy_list'); ?>";
        var cart_lucknum_url = "<?php dourl('unitary:get_lucknum_ajax') ?>";
        var unitary_id = "<?php echo $unitary['id'] ?>";
    </script>
<body>
<?php include display('public:header_unitary'); ?>
<div class="g-body">
    <div class="m-detail m-detail-willReveal" module="detail/published/Published" id="pro-view-7" module-id="module-6" module-launched="true">
        <div class="g-wrap g-body-hd f-clear">
            <div class="g-main">
                <div class="w-dir">
                    <a href="<?php echo dourl('unitary:index') ?>">首页</a> &gt; <a href="<?php echo dourl('unitary:category', array('cat_id'=>1)) ?>"><?php echo $product_category['tree']['cat_name'] ?></a> &gt;
                    <span class="txt-gray"><?php echo $unitary['name'] ?></span>
                </div>
                <div class="g-main-l m-detail-show">
                    <i class="ico ico-label ico-label-ten"></i>
                    <?php if (in_array($unitary['item_price'], $area_ids)) { ?>
                        <i class="ico ico-label " style="background: url(<?php echo $area_icons[$unitary['item_price']] ?>)"></i>
                    <?php } ?>
                    <div class="w-gallery" pro="gallery">
                        <div class="w-gallery-fullsize">
                            <div class="w-gallery-picture">
                                <img pro="currentBigPicture" class="nowshowImg" src="<?php echo $product_image_list[0]['image'] ?>">
                            </div>
                        </div>
                        <i class="ico ico-arrow ico-arrow-red ico-arrow-red-up" style="left: 31px;"></i>
                        <div class="w-gallery-thumbnail">
                            <ul class="w-gallery-thumbnail-list" pro="thumbnailList">
                            <?php foreach ($product_image_list as $key => $val) { ?>
                                <li class="w-gallery-thumbnail-item <?php if ($key == 0) echo 'w-gallery-thumbnail-item-selected' ?>" pro="thumbnail">
                                    <img src="<?php echo $val['image'] ?>">
                                </li>
                            <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="g-main-m m-detail-main">
                    <div class="m-detail-main-intro">
                        <div class="m-detail-main-title">
                            <h1 title="<?php echo $unitary['name'] ?>"><?php echo $unitary['name'] ?></h1>
                        </div>
                        <p class="m-detail-main-desc" title="<?php echo $unitary['descript'] ?>"><?php echo $unitary['descript'] ?></p>
                    </div>
                    <div class="m-detail-main-winner">

                    <?php if ($unitary['state'] == 2 && $unitary['is_countdown'] == 1) { ?>
                        <!-- 倒计时 -->
                        <div>
                            <div class="m-detail-main-countdown f-clear">
                                <i class="ico ico-detail-main-hourglass"></i>
                                <div class="m-detail-main-countdown-content">
                                    <div class="m-detail-main-countdown-hd">
                                        <span class="period">期号：<?php echo $val['id'] ?></span>
                                        <span class="split">|</span>
                                        <span class="title">揭晓倒计时</span>
                                    </div>
                                    <div id="countdownNum" class="m-detail-main-countdown-num" data-countdown="<?php echo $unitary['countdown_time'] ?>">xx:xx:xx</div>
                                </div>
                            </div>
                            <div class="m-detail-main-calculation f-clear">
                                <div class="m-detail-main-calculation-formula m-detail-main-calculation-main f-clear">
                                    <div class="m-detail-main-calculation-title">如何计算？</div>
                                    <div class="m-detail-main-calculation-parameter m-detail-main-calculation-luckyCode">
                                        <span class="num">?</span>
                                        <span class="tip">本期幸运号码</span>
                                    </div>
                                    <div class="m-detail-main-calculation-operation m-detail-main-calculation-equal">=</div>
                                    <div class="m-detail-main-calculation-parameter m-detail-main-calculation-constant">
                                        <span class="num">100000</span>
                                        <span class="tip">固定数值</span>
                                    </div>
                                    <div class="m-detail-main-calculation-operation m-detail-main-calculation-add">+</div>
                                    <div class="m-detail-main-calculation-parameter m-detail-main-calculation-variable">
                                        <span class="num">?</span>
                                        <span class="tip">变化数值</span>
                                    </div>
                                </div>
                                <div class="m-detail-main-calculation-formula m-detail-main-calculation-secondary f-clear">
                                    <div class="m-detail-main-calculation-title"><strong>变化数值</strong>是取下面公式的余数</div>
                                    <div class="m-detail-main-calculation-operation m-detail-main-calculation-leftBracket">(</div>
                                    <div class="m-detail-main-calculation-parameter m-detail-main-calculation-sum" pro="formulaSum">
                                        <span class="num">时间之和</span>
                                        <span class="tip">100个时间求和</span>
                                        <span class="more">
                                            <i class="ico ico-detail-main-calculation-tipBox"></i>
                                            <span class="more-content">商品的最后一个号码分配完毕，公示该分配时间点前该店铺全部商品的<strong>最后100个参与时间</strong>，并求和。</span>
                                        </span>
                                    </div>
                                    <div class="m-detail-main-calculation-operation m-detail-main-calculation-rightBracket" style="left:240px;">)</div>
                                    <div class="m-detail-main-calculation-operation m-detail-main-calculation-divide">÷</div>
                                    <div class="m-detail-main-calculation-parameter m-detail-main-calculation-price">
                                        <span class="num"><?php echo $unitary['total_num'] ?></span>
                                        <span class="tip">总需人次</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } else if ($unitary['state'] == 2) { ?>
                        <!-- 已揭晓 -->
                        <div>
                            <div class="m-detail-main-winner-luckyCode f-clear">
                                <div class="hd">
                                    <span class="period">期号<span class="period-num"><?php echo $unitary['id'] ?></span></span>
                                    <span class="title">幸运号码</span>
                                </div>
                                <div class="code"><?php echo $unitary['lucknum']; ?></div>
                            </div>
                            <div class="m-detail-main-winner-detail f-clear">
                                <i class="ico ico-detail-main-winner"></i>
                                <img width="90" height="90" src="<?php echo $find_user['avatar'] ?>" class="user-avatar">
                                <div class="user-info">
                                    <div class="info-item user-nickname">
                                        <span class="hd">用户昵称</span>：
                                        <span class="bd"><a href="javascript:void(0)" target="_blank"><?php echo $find_user['nickname'] ?></a>
                                        <?php if ($find_user['province']) {
                                            echo '（'.$find_user['province'].$find_user['city'].'）';
                                        } ?>
                                        </span>
                                    </div>
                                    <div class="info-item user-id">
                                        <span class="hd">用户 I D</span>：
                                        <span class="bd"><?php echo $find_user['uid'] ?>（ID为用户唯一不变标识）</span>
                                    </div>
                                    <div class="info-item user-buyTimes">
                                        <span class="hd">本期参与</span>：
                                        <span class="bd"><?php echo $unitary['total_num'] ?>人次</span>
                                    </div>
                                </div>
                                <div class="record-info">
                                    <div class="info-item published-time"><span class="hd">揭晓时间</span>：<span class="bd"><?php echo date("Y-m-d H:i:s", $unitary['endtime']) ?>.000</span>
                                    </div>
                                    <div class="info-item buy-time"><span class="hd">夺宝时间</span>：<span class="bd"><?php echo $find_user['get_date'] ?></span>
                                    </div>
                                    <div class="info-item codes"><a id="btnWinnerCodes" data-lucknum="<?php echo $taLucknum; ?>" href="javascript:void(0)">查看TA的号码&gt;&gt;</a>
                                    </div>
                                </div>
                            </div>

                            <div class="m-detail-main-calculation f-clear">
                                <div class="m-detail-main-calculation-formula m-detail-main-calculation-main f-clear">
                                    <div class="m-detail-main-calculation-title">如何计算？</div>
                                    <div class="m-detail-main-calculation-parameter m-detail-main-calculation-luckyCode">
                                        <span class="num"><?php echo $unitary['lucknum'] ?></span>
                                        <span class="tip">本期幸运号码</span>
                                    </div>
                                    <div class="m-detail-main-calculation-operation m-detail-main-calculation-equal">=</div>
                                    <div class="m-detail-main-calculation-parameter m-detail-main-calculation-constant">
                                        <span class="num">100000</span>
                                        <span class="tip">固定数值</span>
                                    </div>
                                    <div class="m-detail-main-calculation-operation m-detail-main-calculation-add">+</div>
                                    <div class="m-detail-main-calculation-parameter m-detail-main-calculation-variable">
                                        <span class="num"><?php echo $find_lucknum['lucknum'] ?></span>
                                        <span class="tip">变化数值</span>
                                    </div>
                                </div>
                                <div class="m-detail-main-calculation-formula m-detail-main-calculation-secondary f-clear">
                                    <div class="m-detail-main-calculation-title"><strong>变化数值</strong>是取下面公式的余数</div>
                                    <div class="m-detail-main-calculation-operation m-detail-main-calculation-leftBracket">(
                                    </div>
                                    <div class="m-detail-main-calculation-parameter m-detail-main-calculation-sum"
                                         pro="formulaSum">
                                        <span class="num"><?php echo $jonList['time_total'] ?></span>
                                        <span class="tip">100个时间求和</span>
                                        <span class="more">
                                            <i class="ico ico-detail-main-calculation-tipBox"></i>
                                            <span class="more-content">商品的最后一个号码分配完毕，公示该分配时间点前本站全部商品的<strong>最后100个参与时间</strong>，并求和。</span>
                                        </span>
                                    </div>
                                    <div class="m-detail-main-calculation-operation m-detail-main-calculation-rightBracket" style="left:200px;">)</div>
                                    <div class="m-detail-main-calculation-operation m-detail-main-calculation-divide">÷
                                    </div>
                                    <div class="m-detail-main-calculation-parameter m-detail-main-calculation-price">
                                        <span class="num"><?php echo $unitary['total_num'] ?></span>
                                        <span class="tip">总需人次</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <!-- 正常购买 -->
                        <div>
                            <div class="m-detail-main-ing m-detail-main-onlyOne" pro="buyMain">
                                <div class="m-detail-main-onlyOne-content" id="typeOne" data-id="<?php echo $unitary['id'] ?>">
                                    <div class="m-detail-main-one-header f-clear">
                                        <h2 class="m-detail-main-type-title"><?php echo $unitary['item_price'] ?> 元夺宝</h2>
                                        <h3 class="m-detail-main-type-subtitle"><span class="period">期号 <?php echo $unitary['id'] ?>    </span>每满总需人次，即抽取1人获得该商品</h3>
                                        <div class="m-detail-main-one-explanation" pro="oneExplanationTip">?
                                            <div class="more-box">
                                                <i class="ico ico-detail-main-left-anchor"></i>
                                                <div class="content">
                                                    <p>“一元夺宝”指用户花费1元兑换一个夺宝币，随后可凭夺宝币使用一元夺宝的服务并可根据宝石获得规则获取相应的宝石。</p>
                                                    <p>每件商品的全部夺宝号码分配完毕后，一元夺宝根据夺宝规则计算出的一个号码。<strong>持有该幸运号码的用户可直接获得该商品。</strong></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-detail-main-one-progress">
                                        <div class="w-progressBar f-clear" title="<?php echo $unitary['proportion'] ?>%">
                                            <div class="w-progressBar-wrap">
                                                <span class="w-progressBar-bar" style="width:<?php echo $unitary['proportion'] ?>%;"></span>
                                            </div>
                                            <div class="w-progressBar-txt">已完成<?php echo number_format($unitary['proportion'], 2) ?>%</div>
                                        </div>
                                    </div>
                                    <div class="m-detail-main-one-intro f-clear">
                                        <div class="m-detail-main-one-price">总需人次<?php echo $unitary['total_num'] ?></div>
                                        <div class="m-detail-main-one-remain">剩余人次<span class="js-restNum"><?php echo $unitary['left_count'] ?></span></div>
                                    </div>
                                    <div class="m-detail-main-one-count f-clear">
                                        <span>参与</span>
                                        <div id="buyNumbers" class="m-detail-main-count-number m-detail-main-count-buyTimes f-clear">
                                            <div class="w-number" id="pro-view-10">
                                                <a class="w-number-btn w-number-btn-minus js-minus" href="javascript:void(0);">－</a>
                                                <input class="w-number-input js-input" type="text" value="1">
                                                <a class="w-number-btn w-number-btn-plus js-plus" href="javascript:void(0);">＋</a>
                                            </div>
                                        </div>
                                        <span style="padding-left: 0;">元</span>
                                        <span class="m-detail-main-buyHint"><i class="ico ico-arrow ico-arrow-grayBubbleArr"></i><b pro="txtOneBuyTip">多参与1人次，获取幸运号码机会翻倍！</b></span>
                                    </div>
                                    <div class="m-detail-main-one-operation f-clear">
                                        <a class="m-detail-main-type-btn m-detail-main-one-buy js-quickBuy" href="javascript:void(0)">立即夺宝</a>
                                        <a class="m-detail-main-type-btn m-detail-main-one-cart js-addToCart" href="javascript:void(0)"><i class="ico ico-miniCart"></i><span class="btn-txt">加入清单</span></a>
                                    </div>
                                </div>
                                <div id="wrapOutOfStock" class="m-detail-main-outOfStock f-clear" style="display: none;">
                                    <i class="ico m-detail-main-outOfStock-ico"></i>
                                    <div class="m-detail-main-outOfStock-content">
                                        <p><span>此商品暂时缺货。我们会尽快重新上架，</span><span>敬请期待！</span></p>
                                        <a href="/list.html">去逛逛其它商品</a>
                                    </div>
                                </div>
                                <div id="wrapExpired" class="m-detail-main-soldOut" style="display: none;">商品已下架</div>
                            </div>
                        </div>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-tabs w-tabs-main m-detail-mainTab" module="detail/tabs/Tabs" id="pro-view-6" module-id="module-5"
         module-launched="true">
        <div class="g-wrap g-body-bd f-clear">
            <div class="w-tabs-tab">
                <div id="introTab" class="w-tabs-tab-item w-tabs-tab-item-selected pro-tabs-tab-item-selected">商品详情</div>
                <div id="recordTab" class="w-tabs-tab-item">夺宝参与记录</div>
                <div id="resultTab" class="w-tabs-tab-item" <?php if ($unitary['state'] != 2) { echo 'style="display:none"'; } ?>>计算结果</div>
            </div>
            <div class="w-tabs-panel">

                <!-- 商品详情 -->
                <div id="introPanel" class="w-tabs-panel-item">
                    <?php if (!empty($product['info'])) { ?>
                    <div><?php echo $product['info'] ?></div>
                    <?php } else { ?>
                    <div>详情为空</div>
                    <?php } ?>
                    <dl class="special">
                        <dt>重要说明：</dt>
                        <dd>1、以上详情页面展示信息仅供参考，商品以实物为准；<br>2、如快递无法配送至获得者提供的送货地址，将默认配送到距离最近的送货地，由获得者本人自提。</dd>
                    </dl>
                </div>

                <!-- 计算结果 -->
                <?php if ($unitary['state'] == 2) { ?>
                <div id="resultPanel" class="w-tabs-panel-item" style="display:none">
                    <div class="m-detail-mainTab-calcRule">
                        <h4><span class="wrap">
                            <i class="ico ico-text"></i><span class="txt">幸运号码计算规则</span>
                        </span></h4>
                        <div class="ruleWrap">
                            <ol class="ruleList">
                                <li><span class="index">1</span>商品的最后一个号码分配完毕后，将公示该分配时间点前店铺全部商品的最后100个参与时间；</li>
                                <li><span class="index">2</span>将这100个时间的数值进行求和（得出数值A）（每个时间按时、分、秒、毫秒的顺序组合，如20:15:25.362则为201525362）；
                                </li>
                                <li><span class="index">3</span>（数值A）除以该商品总需人次得到的余数<i style="margin-top:-3px;" class="ico ico-questionMark"></i> + 原始数&nbsp;100000，得到最终幸运号码，拥有该幸运号码者，直接获得该商品。</li>
                            </ol>
                        </div>
                    </div>
                    <table class="m-detail-mainTab-resultList" cellpadding="0" cellspacing="0">
                        <thead>
                        <tr>
                            <th class="time" colspan="2">夺宝时间</th>
                            <th>会员帐号</th>
                            <th>商品名称</th>
                            <th width="70">商品编号</th>
                            <th width="70">参与人次</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="startRow">
                            <td colspan="6">截止该商品最后夺宝时间【<?php echo $jonList['last_date'] ?>】最后<?php echo count($jonList['list']); ?>条全站参与记录</td>
                        </tr>
                        <?php foreach ($jonList['list'] as $val) { ?>
                        <tr class="calcRow">
                            <td class="day"><?php echo $val['date_left'] ?></td>
                            <td class="time"><?php echo $val['date_right'] ?><i class="ico ico-arrow-transfer"></i><b class="txt-red"><?php echo $val['date_plus'] ?></b>
                            </td>
                            <td class="user">
                                <div class="f-txtabb">
                                    <a href="javascript:void(0)" target="_blank"><?php echo $val['nickname'] ?></a>
                                </div>
                            </td>
                            <td class="gname"><a href="<?php dourl('unitary:detail', array('id'=>$val['unitary_id'])) ?>" target="_blank"><?php echo $val['unitary_name'] ?></a></td>
                            <td><?php echo $val['unitary_id'] ?></td>
                            <td>1人次</td>
                        </tr>
                        <?php } ?>

                        <!-- 计算结果 -->
                        <tr class="resultRow">
                            <td colspan="6">
                                <h4>计算结果<a name="calcResult"></a></h4>
                                <ol>
                                    <li><span class="index">1、</span>求和：<?php echo $jonList['time_total'] ?> (上面100条参与记录的时间取值相加)</li>

                                    <?php if ($unitary['is_countdown'] == 1) { ?>

                                        <li><span class="index">2、</span>求余：(<?php echo $jonList['time_total'] ?>
                                            ) % <?php echo $unitary['total_num'] ?> (商品所需人次) =
                                            <span class="js-remainder" style="font-size: 16px; font-weight: bold;">
                                                ?????
                                            </span>
                                            (余数) <i data-func="remainder" class="ico ico-questionMark"></i>
                                        </li>
                                        <li><span class="index">3、</span>
                                            <span class="js-remainder" style="font-size: 16px; font-weight: bold;">
                                                ?????
                                            </span>
                                            (余数) + 100000 =
                                            <span class="js-lucknum" style="font-size: 16px; font-weight: bold;">
                                                ?????
                                            </span>
                                        </li>

                                    <?php } else { ?>

                                        <li><span class="index">2、</span>求余：(<?php echo $jonList['time_total'] ?>
                                            ) % <?php echo $unitary['total_num'] ?> (商品所需人次) =
                                            <span class="js-remainder" style="font-size: 16px; font-weight: bold;">
                                                <?php echo $find_lucknum['lucknum'] ?>
                                            </span>
                                            (余数) <i data-func="remainder" class="ico ico-questionMark"></i>
                                        </li>
                                        <li><span class="index">3、</span>
                                            <span class="js-remainder" style="font-size: 16px; font-weight: bold;">
                                                <?php echo $find_lucknum['lucknum'] ?>
                                            </span>
                                            (余数) + 100000 =
                                            <span class="js-lucknum" style="font-size: 16px; font-weight: bold;">
                                                <?php echo $unitary['lucknum'] ?>
                                            </span>
                                        </li>

                                    <?php } ?>
                                </ol>
                                <span class="resultCode">幸运号码： <?php echo $unitary['lucknum'] ?> </span>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <?php } ?>

                <!-- 夺宝参与记录 -->
                <div id="recordPanel" class="w-tabs-panel-item m-detail-mainTab-record" style="display:none;"></div>

            </div>
        </div>
    </div>


</div>
<?php include display('public:footer_unitary'); ?>
<script type="text/javascript" src="<?php echo STATIC_URL;?>unitary/js/common.js"></script>
<script type="text/javascript" src="<?php echo STATIC_URL;?>unitary/js/detail.js"></script>
<script src="<?php echo STATIC_URL;?>unitary/js/index.js" type="text/javascript"></script>
<script>
    imghover.init();
    scrollnav.init($(".m-nav"), $(".w-dir"));    // 滚动效果
    clickfiy.init($(".js-addToCart"), $(".w-miniCart"), true);    // 飞入效果
</script>
</body>
</html>