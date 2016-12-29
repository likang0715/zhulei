<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link href="<?php echo TPL_URL;?>css/base.css" rel="stylesheet">
    <link href="<?php echo TPL_URL;?>css/index.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>ucenter/css/jiefen.css" type="text/css">
    <title>积分明细 - <?php echo $storeInfo['name']; ?></title>
    <script src="<?php echo TPL_URL;?>js/rem.js"></script>
    <script src="<?php echo TPL_URL;?>js/jquery-1.7.2.js"></script>
    <script src="<?php echo TPL_URL;?>js/index.js"></script>
</head>
<body>
<?php
$types = array(
    1 =>'关注公众号送',
    2 =>'订单满送',
    3 =>'消费送',
    4 =>'分享送',
    5 =>'签到送',
    6 =>'买特殊商品所送',
    7 =>'手动变更',
    8 =>'推广增加',
    9 =>'订单抵扣现金',
    10=>'退货退还积分',
    11=>'升级会员等级',
    14=>'抽奖积分',
	15=>'摇一摇积分',
	16=>'微助力积分',
);
?>
<div class="bonusDetail">
    <div class="bonusDetailTop">
        <p>剩余积分：<em><?php echo $user_points_count['point'];?></em></p>
        <div class="bonusBtn">
            <a href="./home.php?id=<?php echo $storeInfo['store_id'];?>">
                有分，去花
            </a>
            <a href="./task_center.php?store_id=<?php echo $storeInfo['store_id'];?>">
                没分，去赚
            </a>
        </div>
    </div>
    <div class="bonusTable">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th scope="col">内容</th>
                <th scope="col">积分</th>
                <th scope="col">时间</th>
            </tr>
            <?php foreach($user_points_list as $user_points){?>
            <tr>
                <td>
                    <?php foreach($types as $key=>$type){?>
                        <?php if($user_points['type'] == $key){?>
                            <?php
                             $user_points['bak'] && $type .='['. $user_points['bak'].']';
                             echo $type;
                             ?>
                        <?php }?>
                    <?php }?>
                </td>
                <td><?php echo $user_points['points']?></td>
                <td><?php echo date('Y-m-d',$user_points['timestamp'])?></td>
            </tr>
            <?php }?>
        </table>
    </div>
</div>
</body>
</html>
