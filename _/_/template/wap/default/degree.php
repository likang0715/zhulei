<!DOCTYPE>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link href="<?php echo TPL_URL;?>css/new/base.css" rel="stylesheet">
    <link href="<?php echo TPL_URL;?>css/new/index.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/new/usercenter.css" type="text/css">
    <title>会员等级-个人中心</title>
    <script src="<?php echo TPL_URL;?>js/rem.js"></script>
    <script src="<?php echo TPL_URL;?>js/jquery-1.7.2.js"></script>
    <script src="<?php echo STATIC_URL;?>js/layer_mobile/layer.m.js"></script>
    <script>
        $(function() {
            $(".exchange").click(function() {
                var degree_id = $(this).closest(".row").data("degree_id");
                var degree_name = $(this).closest(".row").find(".names").text();
                layer.open({
                    title: '提示',
                    content: '您确定要兑换 '+degree_name+"?",
                    btn: ['确定', '取消'],
                    yes: function(index){
                        $.get(
                            "<?php echo $config['wap_site_url'];?>/ajax.php",
                            {'action':'exchange_degree','degree_id':degree_id,'store_id':'<?php echo $user_point_info['store_id'];?>'},
                            function(obj){

                                //	window.reload();
                                if(obj.err_code == '0') {
                                    layer.open({
                                        content: "兑换成功",
                                        time: 2 //2秒后自动关闭
                                    });
                                    window.setTimeOut(aaa(),2000);
                                } else {

                                    layer.open({
                                        content: obj.err_msg,
                                        time: 2 //2秒后自动关闭
                                    });
                                }
                            },
                            'json'
                        )
                        layer.close(index);
                    }
                });
            })

            function aaa() {
                window.location.reload();
            }
        })
    </script>
</head>
<body>
<div class="grade">
    <div class="gradeTop">
        <div class="gradAvatar">
            <a href="javascript:;">
                <img src="<?php echo $avator;?>" alt=""/>
            </a>
        </div>
        <h2><?php echo $userinfo['nickname'];?></h2>
        <p>（当前等级有效期还剩<?php echo $user_point_info['sytime'];?>天）</p>

        <div class="gardTip onLeft">
            <em></em><?php  if($user_point_info['point']) {echo $user_point_info['point'];}else { echo "0";}?>分
        </div>
        <div class="gardTip onRight">
            <em><img src="<?php echo $userDegree['degree_logo']?>"/></em><?php echo $userDegree['degree_name'];?>
        </div>
    </div>
    <div class="gradList">
        <?php if(is_array($store_tag_list) && count($store_tag_list)>0) {?>
            <?php foreach($store_tag_list as $k => $v) {?>
                <div class="row" data-degree_id="<?php echo $v['id'];?>">
                    <div class="medal"><img src="<?php echo $v['new_level_pic'];?>" style="max-height:50px;"/></div>
                    <p><span class="names"><?php echo $v['name'];?></span><em>（<?php echo $v['degree_month']?>                                                                                                                                                              月）</em></p>
                    <ul>
                        <?php if($v['is_points_discount_ratio'] || $v['is_discount'] || $v['is_points_discount_toplimit'] || $v['is_postage_free']) {?>
                            <li class="grad-i0">
                                <?php if($v['is_points_discount_ratio']) {?>
                                    <i></i>抵现<?php echo $v['points_discount_ratio']?>%
                                <?php }?>
                            </li>
                            <li class="grad-i1">
                                <?php if($v['is_discount']) {?>
                                    <i></i>支付<?php echo $v['discount']?>折
                                <?php }?>
                            </li>
                            <li class="grad-i3">
                                <?php if($v['is_postage_free']) {?>
                                    <i></i>包邮
                                <?php }?>
                            </li>
                            <li class="grad-i2">
                                <?php if($v['is_points_discount_toplimit']) {?>
                                    <i></i>抵现上限<?php echo $v['points_discount_toplimit'];?>元
                                <?php }?>
                            </li>

                        <?php } else {?>
                            <li class="grad-i0"></li>
                            <li class="grad-i1">
                                该等级暂无特权
                            </li>
                        <?php }?>
                    </ul>
                    <span class="bonus">所需积分：<?php echo $v['points_limit'];?></span>
                    <?php if($now_store['degree_exchange_type']== 1) {?>
                        <?php if(empty($exchange)){?>
                            <a class="change exchange" href="javascript:void(0)">兑换</a>
                        <?php }?>
                    <?php }?>
                </div>
            <?php }?>
        <?php } else {
            ?>
            <div class="row" style="height:100px;">
                <div class="medal"><p>居然还没有设置店铺等级</p></div>
                <p><div><p><a href="<?php echo $now_store['url'];?>" class="tag tag-big tag-orange" style="padding:8px 30px;">去逛逛</a></p></div></p>
            </div>
        <?php }?>
    </div>
</div>
</body>
</html>