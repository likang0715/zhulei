<!DOCTYPE html>
<html class="no-js  mobile" lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>{pigcms:$shop_name}</title>
    <!-- meta viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo rtrim(TPL_URL,'/');?>/seckill/css/shop_base.css">
    <link rel="stylesheet" href="<?php echo rtrim(TPL_URL,'/');?>/seckill/css/shop_case.css">
    <link rel="stylesheet" href="<?php echo rtrim(TPL_URL,'/');?>/seckill/css/shop_goods.css">

    <link rel="stylesheet" href="<?php echo rtrim(TPL_URL,'/');?>/seckill/css/style.css"/>
    <script type="text/javascript" src="<?php echo rtrim(TPL_URL,'/');?>/ucenter/js/jquery-1.7.2.js"></script>
    <!-- CSS -->
    <script type="text/javascript" src="<?php echo rtrim(TPL_URL,'/');?>/seckill/js/jquery.min.js"></script>
    <link href="<?php echo rtrim(TPL_URL,'/');?>/seckill/css/owl.carousel.css" rel="stylesheet" type="text/css">
    <link href="<?php echo rtrim(TPL_URL,'/');?>/seckill/css/owl.theme.css" rel="stylesheet" type="text/css">
    <link href="<?php echo rtrim(TPL_URL,'/');?>/seckill/css/swipebox.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="<?php echo rtrim(TPL_URL,'/');?>/seckill/js/alert.js"></script>
    <link href="<?php echo rtrim(TPL_URL,'/');?>/seckill/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo rtrim(TPL_URL,'/');?>/seckill/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="<?php echo TPL_URL;?>/seckill/js/bootstrap.min.js"></script>
    <script src="<?php echo rtrim(TPL_URL,'/');?>/seckill/js/jquery.event.move.js"></script>
    <script src="<?php echo rtrim(TPL_URL,'/');?>/seckill/js/jquery.event.swipe.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style type="text/css">
        /* css 重置 */
        *{margin:0; padding:0; list-style:none; }
        body{ background:#fff; }
        img{ border:0;  }
        ._fly{
            height: 200px !important ;
            left: 0 !important;
        }
        .content-body{
            width: 100% !important;
            margin-top: -51px;
        }

        /* 本例子css */
        .picFocus{ margin:0 auto;  width:100%; border:1px solid #ccc; padding:5px;  position:relative;  overflow:hidden;  zoom:1; z-index: 999}
        .picFocus .bd li{ vertical-align:middle; }
        .picFocus .bd img{ width:100%; max-height:300px; display:block;  }

        .picFocus .prev,
        .picFocus .next{ position:absolute; left:3%; top:50%; margin-top:-25px; display:block; width:32px; height:40px; background: url({pigcms:$staticPath}/tpl/static/seckill/images/slider-arrow.png) -110px 5px no-repeat; filter:alpha(opacity=50);opacity:0.5;   }
        .picFocus .next{ left:auto; right:3%; background-position:8px 5px; }
        .goods-current-price{
            color: #f60 ;
            font-size: 30px ;
            margin-right: 10px ;
        }
        .goods-info{
            padding-left: 30px
        }
        .goods-title {
            color: #333 ;
            font-size: 16px ;
            font-weight: 700 ;
            line-height: 1.5 ;
            margin: 15px 0 ;
        }
        .goods-meta {
            width: 80%;
            font-size: 12px;
            background-color: #f8f8f8;
            padding: 20px;
            color: #333;
            margin-bottom: 35px;
        }
        .goods-meta tr, .goods-meta td{
            height: 40px;
        }
        .goods-meta td{
            line-height: 40px ;
        }
        .goods-meta-name {
            color: #999;
            width: 80px;
            padding-left: 20px;
        }
        .goods-meta-name {
            color: #999;
            width: 80px;
            padding-left: 20px;
        }
        .d-img img{
            width: 100% ;
            max-height: 400px ;
        }

        .wxname {
            position: absolute;
            width: 37px !important;
            height: 38px !important;
            margin: 0 auto !important;
            left: 50% ;
            margin-left: -20px !important;
            z-index: 999
        }

        .detail{
            width: 100% ;
            height: auto ;
        }

        .detail img{
            width: 100% ;
        }

        .header, .js-footer, .footer{
            width: 100% !important ;
            margin-bottom: 52px;
        }

        .copyright{
            margin: 0 auto !important ;
        }

        .share-mp-info{
            height: 30px !important;
            line-height: 30px !important ;
        }
        .borow{
            position: fixed;
            width: 100% ;
            text-align: center ;
            bottom: 0px ;
            background: #EEEEEE ;
            border-top: 1px solid #BFBFBF;
            z-index: 99999;
            height: 50px;
        }

        .seckill{
            width: 90% ;
            height: 40px ;
            margin-top: 5px ;
            line-height: 40px ;
            font-size: 16px !important ;
            background: red ;
            border-radius: 5px ;
            border: none ;
            color: #fff;
        }

        #windowcenter{
            height: 170px !important ;
            overflow: hidden ;
        }

        #windowcenter .content{
            width: 100% !important ;
            height: 100% !important ;
        }

        #windowcenter .content .txtbtn{
            width: 90% !important ;
            margin: 0 auto !important ;

        }

        .custom-richtext img{
            width: 100% !important;
        }

        .js-mp-info a:hover{
            text-decoration: none ;
        }

        /***** S-banner *****/

        .site_wrap {
            width: 100% ;
            height: auto ;
            position: relative;
        }

        .img_slides_wrap {
            width: 100% ;
            height: auto ;
            max-height: 300px ;
            overflow: hidden ;
        }

        .img_slide {
            /* Overide template's height transitions. */
            width:100%;
            display: none ;
            max-height: 300px ;
            height: auto ;
        }

        .notransition,
        .notransition .slide {
            -webkit-transition-duration: 0 !important;
            -moz-transition-duration: 0 !important;
            -ms-transition-duration: 0 !important;
            transition-duration: 0 !important;

            -webkit-transition-delay: 0 !important;
            -moz-transition-delay: 0 !important;
            -ms-transition-delay: 0 !important;
            transition-delay: 0 !important;
        }

        @media screen and (max-width: 640px) {
            .img_slides_wrap {
                width: 100%;

                -webkit-box-sizing: content-box;
                -moz-box-sizing: content-box;
                -ms-box-sizing: content-box;
                box-sizing: content-box;
            }
        }


        .slide.active{left:0;height:auto ;overflow:visible;z-index:2 ; display: block}
        .slide.active ~ .slide{left:100%}
        .slide.active ~ .slide.active{left:0}

        .horizontal{
            position: absolute;
            bottom: 20px;
            margin-left: 42%;
            margin-bottom: -6%;
        }

        .horizontal li{
            display: inline-block ;
            width: 10px;
            height: 10px;
            padding: 0 10px
        }

        .horizontal li a {
            display: block ;
            width: 10px;
            height: 10px;
            margin-right: 10px;
            border-radius: 50%;
            background: none repeat scroll 0% 0% #ccc;
        }

        .horizontal li a.on{
            background: none repeat scroll 0% 0% red;
        }

        /***** E-banner *****/
    </style>
</head>

<body class=" body-fixed-bottom">
<!-- container -->
<div class="header">
    <!-- ▼顶部通栏 -->
    <!--<div class="js-mp-info share-mp-info">
        <a class="page-mp-info" id="home" href="javascript:;">
            返回首页
        </a>
        <div class="links">
            <a class="mp-homepage" id="info" href="javascript:;">我的记录</a>
        </div>
    </div>-->
    <!-- ▲顶部通栏 -->
</div>
<div class="container wap-goods internal-purchase">

    <div class="content ">
        <div class="content-body">
            <!--<if condition="$memberNotice neq ''">
                <if condition="$notice_content eq 'no_follow'">
                    <div style="display:none;" id="membernotice">{pigcms:$memberNotice}</div>
                    <elseif condition="$notice_content eq 'no_register'" />
                    {pigcms:$memberNotice}
                </if>
            </if>-->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display:none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close orderclose" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title" id="myModalLabel">收货信息</h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" id="myform" role="form" action="{pigcms::U('pay')}" method="post">
                                <div class="form-group">
                                    <label for="title1" class="col-sm-3 control-label">商品名称:</label>
                                    <div class="col-sm-3">
                                        <?php echo $productInfo['name'];?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="price" class="col-sm-3 cntrol-label" style="text-align: right">商品价格:</label>
                                    <span>
                                        <?php echo $productInfo['price'];?>&nbsp;元
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label for="tran" class="col-sm-3 cntrol-label" style="text-align: right">运费</label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="tran" name="tran" readonly value="">
                                            <span class="input-group-addon ">元</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="addr" class="col-sm-3 control-label">收货地址</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="addr" name="addr" placeholder="买家收货地址" value="<?php?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-sm-3 control-label">联系人姓名</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="联系人姓名" value="{pigcms:$list['wechaname']}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="cel" class="col-sm-3 control-label">联系手机</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="cel" name="cel" placeholder="常用手机号码" value="{pigcms:$list['tel']}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tel" class="col-sm-3 control-label">联系固话</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="tel" name="tel" placeholder="固定电话">
                                    </div>
                                </div>
                                <input type="hidden" name="aid" value="{pigcms:$_GET['id']}" />
                                <input type="hidden" name="sid" value="{pigcms:$_GET['sid']}" />
                                <input type="hidden" name="uid" value="{pigcms:$_GET['uid']}" />
                                <input type="hidden" name="token" value="{pigcms:$_GET['token']}" />
                                <input type="hidden" name="wecha_id" value="{pigcms:$wecha_id}" />
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-8">
                                        <button type="button" id="cf" class="btn btn-info btn-lg btn-block">确认购买</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="site_wrap wrap">
                <div class="img_slides_wrap slides_wrap">
                    <img class='img_slide slide active' src="<?php echo $productInfo['image'];?>"/>
                </div>
            </div>



            <script>
                (function(jQuery, undefined) {
                    jQuery(document).ready(function() {
                        var wrap = jQuery('.slides_wrap'),
                            slides = wrap.find('.img_slide'),
                            active = slides.filter('.active'),
                            buttons = jQuery('.slide_button'),
                            i = slides.index(active),
                            width = wrap.width();
                        slides.on('swipeleft', function(e) {
                            if (i === slides.length - 1) { return; }
                            slides.eq(i + 1).trigger('activate');
                        }).on('swiperight', function(e) {
                            if (i === 0) { return; }
                            slides.eq(i - 1).trigger('activate');
                        }).on('activate', function(e) {
                            slides.eq(i).removeClass('active');
                            buttons.eq(i).removeClass('on');

                            jQuery(e.target).addClass('active');

                            // Update the active slide index
                            i = slides.index(e.target);

                            // select active class for slide button
                            buttons.eq(i).addClass('on');
                        }).on('movestart', function(e) {
                            // If the movestart heads off in a upwards or downwards
                            // direction, prevent it so that the browser scrolls normally.
                            if ((e.distX > e.distY && e.distX < -e.distY) ||
                                (e.distX < e.distY && e.distX > -e.distY)) {
                                e.preventDefault();
                                return;
                            }

                            // To allow the slide to keep step with the finger,
                            // temporarily disable transitions.
                            wrap.addClass('notransition');
                        }).on('move', function(e) {
                            var left = 100 * e.distX / width;

                            // Move slides with the finger
                            if (e.distX < 0) {
                                if (slides[i+1]) {
                                    slides[i].style.left = left + '%';
                                    slides[i+1].style.left = (left+100)+'%';
                                }
                                else {
                                    slides[i].style.left = left/4 + '%';
                                }
                            }
                            if (e.distX > 0) {
                                if (slides[i-1]) {
                                    slides[i].style.left = left + '%';
                                    slides[i-1].style.left = (left-100)+'%';
                                }
                                else {
                                    slides[i].style.left = left/5 + '%';
                                }
                            }
                        }).on('moveend', function(e) {
                            wrap.removeClass('notransition');

                            slides[i].style.left = '';

                            if (slides[i+1]) {
                                slides[i+1].style.left = '';
                            }
                            if (slides[i-1]) {
                                slides[i-1].style.left = '';
                            }
                        });
                        jQuery(document)
                            .on('click', '.slide_button', function(e) {
                                var href = e.currentTarget.hash;

                                jQuery(href).trigger('activate');

                                e.preventDefault();
                            });
                    });
                })(jQuery);
            </script>
            <div class="goods-header">
                <h2 class="title"><?php echo mb_substr($productInfo['name'],0, 18, 'utf-8');?></h2>
                <div class="goods-price">
                    <div class="current-price">
                        <span>￥&nbsp;</span>
                        <i class="js-goods-price price"><?php echo $productInfo['price']?></i>
                    </div>

                </div>
            </div>
            <hr class="with-margin">
            <div class="sku-detail adv-opts" style="border-top:none;">
                <div class="sku-detail-inner adv-opts-inner">
                    <dl>
                        <dt>库存：</dt>
                        <dd><?php echo $productInfo['quantity']?>&nbsp;&nbsp;件</dd>
                    </dl>
                    <dl>
                        <dt>运费：</dt>
                        <dd>免运费</dd>
                    </dl>
                </div>
            </div>
            <div class="js-components-container components-container">
                <div class="custom-richtext">
                    <p>
                        <?php echo $seckillInfo['description']; ?>
                    </p>
                </div>
            </div>

        </div>
    </div>
    <div class="js-footer" style="min-height: 1px;">
        <div class="footer">
            <div class="copyright">
                <div class="ft-links">
                    <a href="">秒杀主页</a>
                    <a href="">我的信息</a>
                </div>
            </div>
            <div class="ft-copyright">
               <span style="font-size:10px;">©2012-2016 pigcms 版权所有</span>
            </div>
        </div>
    </div>
</div>

<div class="borow">
    <?php if($productInfo['quantity'] == 0) {?>
        <button type="button" id="buy1" class="seckill">已结束</button>
    <?php } else if($productInfo['quantity'] > 0){?>
        <button type="button" id="buy" data-toggle="modal" data-target="#myModal" class="seckill">
        立即购买
        </button>
    <?php }?>
</div>
<script type="text/javascript">
    var sid = "{pigcms:$_GET['sid']}" ;
    var uid = "{pigcms:$_GET['uid']}" ;
    $.post("eee", {"shop_id": sid, "user_id": uid}, function(data) {
        var info = JSON.parse(data) ;
        if(info.status == 0) {
            var tran = "{pigcms:$shop_tran}" ;
            var price = "{pigcms:$shop_price}" ;
            var name = "{pigcms:$shop_name}" ;

            $("#tran").val(tran) ;
            $("#price").val(price) ;
            $("#title1").val(name) ;
            $("#buy").click(function(){
                var h = $("#myModal").css('display');
                if(h == 'none'){
                    $('.borow').hide();
                }
            });
            $("#buy2").click(function(){
                var h = $("#myModal").css('display');
                if(h == 'none'){
                    $('.borow').hide();
                }
            });
        }else{
            var buys = '{pigcms:$buys}' == 2 ? 'buy2' : 'buy';
            $("#"+buys).click(function() {
                alert(info.msg) ;
                return false ;
            }) ;
        }

    }) ;
    $(".orderclose").click(function(){
        $(".borow").show();
        $(".borow").show();
    });
    $("#cf").click(function() {
        var addr = $("#addr").val() ;
        var name = $("#name").val() ;
        var tel = $("#tel").val() ;
        var cel = $("#cel").val() ;

        if(addr==undefined || addr=="" || addr==null) {
            alert("收货地址不能为空！") ;
            return false ;
        }

        if(name==undefined || name=="" || name==null) {
            alert("收件人不能为空！") ;
            return false ;
        } else {
            var num = len(name) ;
            if(num > 4) {
                alert("请输入正确的收件人格式！") ;
                return false ;
            }
        }

        if( (tel==undefined || tel=="" || tel==null) && (cel==undefined || cel=="" || cel==null) ) {
            alert("请至少填写一种联系方式！") ;
            return false ;
        }

        if( (cel!=undefined && cel!="" && cel!=null) ) {
            var re = /^1\d{10}$/i;
            var shouji=re.test(cel);
            if(!shouji) {
                alert("您输入的联系方式有误！") ;
                return false ;
            }
        }

        if( (tel!=undefined && tel!="" && tel!=null) ) {
            var partten = /^(\d{3,4}\-)?\d{7,8}$/i;
            var zuoji=partten.test(tel);
            if(!zuoji) {
                alert("您输入的联系方式有误！") ;
                return false ;
            }
        }
        $("#cf").attr("disabled","disabled");
        $("#myform").submit() ;
    }) ;
    //返回首页
    /*$("#home").click(function() {
        window.location.href = '{pigcms::U("index", array(
        "uid" => $_GET['uid'] ,
            "id" => $_GET['id'] ,
            "token" => $_GET['token']
        ))}' ;
    }) ;*/

    $("#buy1").click(function() {
        alert("活动已结束") ;
        return false ;
    }) ;
    // 我的记录
    /*$("#info").click(function() {
        window.location.href = '{pigcms::U("my_cart", array(
        "uid" => $_GET['uid'] ,
            "id" => $_GET['id'] ,
            "token" => $_GET['token']
        ))}' ;
    }) ;*/

    function len(s) {
        var l = 0;
        var a = s.split("");
        for (var i=0;i<a.length;i++) {
            if (a[i].charCodeAt(0)<299) {
                l++;
            } else {
                l++;
            }
        }
        return l;
    }


</script>

<script type="text/javascript">
    //锚点
    function anchor(){
        $(".closed").show();
        $("._flys").show();
        $("#TipContent").show();
        $(".zhezhao").show();
        /*if($("#TopTipHolder").css('height') == '0px'){
         $("#TopTipClose").click();//执行关闭
         $("#TopTipHolder").css('height','35px');//弹出
         }*/
    }
    function anchor_follow(){
        $(".closed").show();
        $("._flys").show();
        $("#fly_page").show();
    }
    //隐藏提醒关注注册弹框
    $(".close").click(function(){
        $("#no_follow").hide();
        $("#bg").hide();
    });
</script>
</body>
</html>