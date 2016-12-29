<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>商品分类 - 夺宝</title>
    <link rel="stylesheet" type="text/css" href="<?php echo STATIC_URL;?>unitary/css/bef6decb938119df87327e5e548e997f221af746.css">
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
            var url = "<?php echo dourl('unitary:category', array('cat_id'=>$selectCat['cat_id'], 'orderBy'=>$selectOrderBy)); ?>";
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
    <div class="m-list">
        <div class="g-wrap g-body-hd f-clear">
            <div class="w-dir">
                <a href="<?php echo dourl('unitary:index') ?>">首页</a> &gt; 
                <?php if (empty($selectCat)) { ?> 
                <span class="txt-red">全部商品</span>
                <?php } else { ?>
                <a href="<?php echo dourl('unitary:category') ?>">全部商品</a> &gt; 
                <span class="txt-red"><?php echo $selectCat['cat_name']; ?></span>
                <?php } ?>
            </div>
            <div class="m-list-mod m-list-allType">
                <div class="m-list-mod-hd">
                    <h3><a href="/list.html">所有商品</a> <span class="extra">（共 <b class="txt-red count"><?php echo $count ?></b> 件相关商品）</span></h3>
                </div>
                <div class="m-list-mod-bd">
                    <ul class="m-list-allType-list">
                        <li class="<?php if (empty($selectCat)) { echo 'selected'; } ?>">
                            <a href="<?php dourl('unitary:category') ?>">
                                <span class="icon">
                                    <i class="ico ico-type first" style="background:url(<?php echo STATIC_URL;?>unitary/images/cat_all.png)"></i>
                                    <i class="ico ico-type second" style="background:url(<?php echo STATIC_URL;?>unitary/images/cat_all.png)"></i>
                                </span>
                                <b class="name">全部</b>
                            </a>
                        </li>
                        <?php foreach ($categoryListFull as $val) { ?>
                        <li class="<?php if (!empty($selectCat) && $selectCat['cat_id'] == $val['cat_id']) { echo 'selected'; } ?>">
                            <a href="<?php echo dourl('unitary:category', array('cat_id'=>$val['cat_id'])) ?>">
                                <span class="icon">
                                    <i class="ico ico-type first" style="background:url(<?php echo $val['cat_indiana_pic'] ?>)"></i>
                                    <i class="ico ico-type second" style="background:url(<?php echo $val['cat_indiana_pic'] ?>)"></i>
                                </span>
                                <b class="name"><?php echo $val['cat_name'] ?></b>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                    <div class="f-clear"></div>
                </div>
            </div>
        </div>
        <?php if (empty($unitaryList)) { ?> <!-- 无商品 -->
        <div class="g-wrap g-body-bd f-clear">
            <p class="status-empty"><i class="littleU littleU-cry"></i>&nbsp;&nbsp;该分类下暂无商品，敬请期待~</p>
        </div>
        <?php } else { ?>   <!-- 有商品 -->
        <div class="g-wrap g-body-bd f-clear">
            <div class="m-list-mod m-list-goodsList">
                <div class="m-list-mod-hd">
                    <h6>排序：</h6>
                    <ul class="m-list-sortList">
                        <li class="<?php if ($selectOrderBy == 'renqi') { echo "selected"; } ?>">
                            <a href="<?php echo dourl('unitary:category', array('cat_id'=>$selectCat['cat_id'], 'orderBy'=>'renqi')) ?>">人气商品</a>
                        </li><li class="<?php if ($selectOrderBy == 'new') { echo "selected"; } ?>">
                            <a href="<?php echo dourl('unitary:category', array('cat_id'=>$selectCat['cat_id'], 'orderBy'=>'new')) ?>">最新商品</a>
                        </li><li class="<?php if ($selectOrderBy == 'total_asc') { echo "selected"; } ?>">
                            <a href="<?php echo dourl('unitary:category', array('cat_id'=>$selectCat['cat_id'], 'orderBy'=>'total_asc')) ?>">总需人次 <i title="升序" class="ico ico-arrow-sort ico-arrow-sort-gray-up"></i></a>
                        </li><li class="<?php if ($selectOrderBy == 'total_desc') { echo "selected"; } ?>">
                            <a href="<?php echo dourl('unitary:category', array('cat_id'=>$selectCat['cat_id'], 'orderBy'=>'total_desc')) ?>">总需人次 <i title="降序" class="ico ico-arrow-sort ico-arrow-sort-gray-down"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="m-list-mod-bd">
                    <ul class="w-quickBuyList f-clear" id="goodsList">
                        <?php foreach ($unitaryList as $key => $val) { ?>
                        <li class="w-quickBuyList-item <?php if ($key%4 == 3) { echo 'row-last'; } ?>">
                            <?php if (in_array($val['item_price'], $area_ids)) { ?>
                                <i class="ico ico-label " style="background: url(<?php echo $area_icons[$val['item_price']] ?>)"></i>
                            <?php } ?>
                            <div class="w-goods w-goods-l w-goods-ing">
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
                                        <li class="w-progressBar-txt-l">
                                            <p><b><?php echo $val['pay_count'] ?></b></p>
                                            <p>已参与人次</p>
                                        </li>
                                        <li class="w-progressBar-txt-r">
                                            <p><b><?php echo $val['left_count'] ?></b></p>
                                            <p>剩余人次</p>
                                        </li>
                                    </ul>
                                </div>
                                <p class="w-goods-progressHint">
                                    <b class="txt-blue"><?php echo $val['pay_count'] ?></b>人次已参与，赶快去参加吧！剩余<b class="txt-red"><?php echo $val['left_count'] ?></b>人次
                                </p>
                                <div class="w-goods-opr js-buy-opt" data-id="<?php echo $val['id'] ?>" data-left_count="<?php echo $val['left_count'] ?>">
                                    我要参与：
                                    <div class="w-goods-opr-number">
                                        <div class="w-number w-number-inline">
                                        <a class="w-number-btn w-number-btn-minus js-minus" pro="minus" href="javascript:void(0);">－</a>
                                        <input class="w-number-input js-input" pro="input" type="text" value="1">
                                        <a class="w-number-btn w-number-btn-plus js-plus" pro="plus" href="javascript:void(0);">＋</a></div>
                                    </div>
                                    人次
                                    <p class="w-goods-opr-buy">
                                        <a class="w-button w-button-main w-button-l w-goods-btn-quickBuy js-quickBuy" href="javascript:void(0)" style="width:90px;">立即夺宝</a>
                                        <a class="w-button w-button-l w-goods-btn-addToCart js-addToCart" href="javascript:void(0)" style="width:90px;">加入清单</a>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="g-wrap g-body-ft f-clear">
            <div class="m-list-pager"><div class="w-pager" id="pages"><?php echo $pages; ?></div></div>
        </div>
        <?php } ?>
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

    clickfiy.init($(".js-addToCart"), $(".w-miniCart"));    // 飞入效果
    scrollnav.init($(".m-nav"), $(".m-list-mod-bd"));    // 滚动效果
    $(".lazyimg").lazyLoad();  // 图片懒加载

})
</script>
</html>