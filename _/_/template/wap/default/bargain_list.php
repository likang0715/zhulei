<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js" lang="zh-CN">
<head>
    <meta charset="utf-8"/>
    <meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
    <meta name="description" content="<?php echo $config['seo_description'];?>" />
    <meta name="HandheldFriendly" content="true"/>
    <meta name="MobileOptimized" content="320"/>
    <meta name="format-detection" content="telephone=no"/>
    <meta http-equiv="cleartype" content="on"/>
    <link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
    <title><?php echo $pageTitle;?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <link rel="stylesheet" href="<?php echo TPL_URL;?>activity_style/css/base.css"/>
    <link rel="stylesheet" href="<?php echo TPL_URL;?>activity_style/css/style.css"/>

    <script src="<?php echo TPL_URL;?>courier_style/js/jquery-1.7.2.js"></script>
    <script src="<?php echo TPL_URL;?>js/base.js"></script>
    <script src="<?php echo TPL_URL;?>activity_style/js/iscroll.js"></script>
    <script src="<?php echo TPL_URL;?>js/bargain.js"></script>

    <script src="<?php echo TPL_URL;?>activity_style/js/layer.js"></script>
</head>
<body>
<div class="userHeader">
    <a class="back" href="javascript:;" onclick="window.history.back();">返回</a>
    <h2>活动列表</h2>
</div>
<section class="navBox pageSliderHide">
    <ul>
        <li class="dropdown-toggle caret category" data-nav="category"><span class="nav-head-name">全部分类</span></li>
        <li class="dropdown-toggle caret sort" data-nav="sort"><span class="nav-head-name">默认排序</span></li>
    </ul>
    <div class="dropdown-wrapper">
        <div class="dropdown-module">
            <div class="scroller-wrapper">
                <div id="dropdown_scroller" class="dropdown-scroller">
                    <div>
                        <ul>
                            <li class="category-wrapper">
                                <ul class="dropdown-list">
                                    <li data-category-id="all" class="active" onclick="jump('/wap/activity.php?table_name=all');return false;">
                                        <span data-name="全部分类">全部分类</span>
                                    </li>
                                    <li data-category-id="crowdfunding" onclick="jump('/wap/activity.php?table_name=crowdfunding');return false;" class=" ">
                                        <span data-name="微众筹">微众筹</span>
                                    </li>
                                    <li data-category-id="seckill" onclick="jump('/wap/activity.php?table_name=seckill');return false;" class=" ">
                                        <span data-name="微秒杀">微秒杀</span>
                                    </li>
                                    <li data-category-id="unitary" onclick="jump('/wap/activity.php?table_name=unitary');return false;" class=" ">
                                        <span data-name="一元夺宝">一元夺宝</span>
                                    </li>
                                    <li data-category-id="bargain" onclick="list_location($(this));return false;" class=" ">
                                        <span data-name="微砍价">微砍价</span>
                                    </li>
                                    <li data-category-id="cutprice" onclick="jump('/wap/activity.php?table_name=cutprice');return false;" class=" ">
                                        <span data-name="降价拍">降价拍</span>
                                    </li>
                                    <li data-category-id="lottery" onclick="jump('/wap/activity.php?table_name=lottery');return false;" class=" ">
                                        <span data-name="抽奖专场">抽奖专场</span>
                                    </li>
                                </ul>
                            </li>
                            <li class="sort-wrapper">
                                <ul class="dropdown-list">
                                    <li data-sort-id="asc" class="active" onclick="list_location($(this));return false;"><span data-name="默认排序">默认排序</span></li>
                                    <li data-sort-id="desc" onclick="list_location($(this));return false;"><span data-name="最新发布">最新发布</span></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <div id="dropdown_sub_scroller" class="dropdown-sub-scroller" style="left: 100%;">
                    <div></div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="listBox specialItem" style="height: auto;">
    <ul id="content">
        <li class="pro_shop" style="">
            <div class="home-tuan-list js-store-list">
                <p class="clickMore"><a href="javascript:;" id="mypageid" data-pageid="2">查看更多</a></p>
            </div>
        </li>
    </ul>
</section>

<script type="text/javascript">
    var table_name = "<?php echo $table_name ?>", order = 'asc';
    // getAjaxList(table_name, 1);
    var tableObj = $(".dropdown-list > li[data-category-id="+table_name+"]");

    list_location(tableObj);

    function jump(url){
        location.href = url;
        exit;
    };

</script>
<?php echo $shareData;?>
</body>
</html>
