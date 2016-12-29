<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $areaNum ?>元专区 - 夺宝</title>
    <link rel="stylesheet" type="text/css" href="<?php echo STATIC_URL;?>unitary/css/bef6decb938119df87327e5e548e997f221af746.css">
    <link rel="stylesheet" type="text/css" href="<?php echo STATIC_URL;?>unitary/css/5ac2c03db3b92ef5dc4579754bc4462ee470b456.css">
    <link rel="stylesheet" type="text/css" href="<?php echo STATIC_URL;?>unitary/css/b60c21141e2e2b7f063bdc699f23fdb86c4a5cad.css">
    <script src="<?php echo STATIC_URL;?>unitary/js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script type="text/javascript">
    $(function(){
        
        // 分页
        function changePage(page) {
            if (page.length == 0) {
                return;
            }

            var re = /^[0-9]*[1-9][0-9]*$/;
            if (!re.test(page)) {
                alert("请填写正确的页数");
                return;
            }
            var url = "<?php echo dourl('unitary:num_area', array('area'=>$areaNum)); ?>";
            location.href = url + "&page=" + page;
        }

        $(function () {
            $("#pages a").click(function () {
                var page = $(this).attr("data-page-num");
                changePage(page);
            });
        });

    })
    </script>
</head>
<body>
<?php include display('public:header_unitary'); ?>
<div class="g-body">
    <div class="m-ten">
        <div class="m-ten-slogan">
            <div class="m-ten-slogan-ft"></div>
        </div>
        <div class="g-wrap g-body-bd f-clear">
            <div class="g-main">
                <div class="m-ten-mod m-ten-allGoods">
                    <div class="w-hd">
                        <h3 class="w-hd-title">所有商品</h3>
                    </div>
                    <div class="m-ten-mod-bd">
                        <ul class="w-goodsList f-clear">
                            <?php foreach ($unitaryList as $key => $val) { ?>
                            <li class="w-goodsList-item row-first">
                                <?php if (in_array($val['item_price'], $area_ids)) { ?>
                                    <i class="ico ico-label " style="background: url(<?php echo $area_icons[$val['item_price']] ?>)"></i>
                                <?php } ?>
                                <div class="w-goods w-goods-ing">
                                    <div class="w-goods-pic">
                                        <a href="<?php echo dourl('unitary:detail', array('id'=>$val['id'])) ?>" title="<?php echo $val['name'] ?>" target="_blank">
                                            <img width="200" height="200" alt="<?php echo $val['name'] ?>" class="lazyimg" data-src="<?php echo $val['logopic'] ?>" src="<?php echo STATIC_URL;?>unitary/images/l.png">
                                        </a>
                                    </div>
                                    <p class="w-goods-title f-txtabb"><a title="<?php echo $val['name'] ?>" href="<?php echo dourl('unitary:detail', array('id'=>$val['id'])) ?>" target="_blank"><?php echo $val['name'] ?></a></p>
                                    <p class="w-goods-price">总需：<?php echo $val['total_num'] ?> 人次</p>
                                    <div class="w-progressBar" title="<?php echo $val['proportion'] ?>%">
                                        <p class="w-progressBar-wrap">
                                            <span class="w-progressBar-bar" style="width:<?php echo $val['proportion'] ?>%;"></span>
                                        </p>
                                        <ul class="w-progressBar-txt f-clear">
                                            <li class="w-progressBar-txt-l"><p><b><?php echo $val['pay_count'] ?></b></p><p>已参与人次</p></li>
                                            <li class="w-progressBar-txt-r"><p><b><?php echo $val['left_count'] ?></b></p><p>剩余人次</p></li>
                                        </ul>
                                    </div>
                                    <p class="w-goods-progressHint">
                                        <b class="txt-blue"><?php echo $val['pay_count'] ?></b>人次已参与，赶快去参加吧！剩余<b class="txt-red"><?php echo $val['left_count'] ?></b>人次
                                    </p>
                                    <div class="w-goods-opr" data-id="<?php echo $val['id'] ?>">
                                        <a class="w-button w-button-main w-button-l w-goods-quickBuy js-quickBuy" href="javascript:void(0)" style="width:96px;" target="_blank">立即夺宝</a>
                                    </div>
                                </div>
                            </li>
                            <?php } ?>
                        </ul>
                        <div class="m-list-pager" style="padding-top: 20px;"><div class="w-pager" id="pages"><?php echo $pages; ?></div></div>
                    </div>
                </div>
            </div>
            <div class="g-side">
                <div class="m-ten-mod m-ten-rule">
                    <div class="m-ten-mod-hd">
                        <h3><?php echo $areaNum ?> 元专区 规则说明</h3>
                    </div>
                    <div class="m-ten-mod-bd">
                        <ul class="m-ten-rule-list">
                            <li><span class="txt-red index">1.</span> “<?php echo $areaNum ?> 元专区”是指宝物的购买单价为<b> <?php echo $areaNum ?> 元</b>；</li>
                            <li><span class="txt-red index">2.</span> <?php echo $areaNum ?> 元专区分配的号码非连号，亦是随机分配；</li>
                            <li><span class="txt-red index">3.</span> 幸运号码计算规则不变。</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include display('public:footer_unitary'); ?>
</body>
<script type="text/javascript" src="<?php echo STATIC_URL;?>unitary/js/common.js"></script>
<script type="text/javascript">
$(function(){
    // 调用夺宝与购物
    $(".w-goods-opr").setAddCart({
        "redirect": cart_url,
        "addCartUrl": add_cart_url,
    });
    $(".lazyimg").lazyLoad();

})
</script>
</html>