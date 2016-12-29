<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link href="<?php echo TPL_URL;?>css/base.css" rel="stylesheet">
    <link href="<?php echo TPL_URL;?>css/index.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/distribution.css" type="text/css">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>ucenter/css/distribution.css" type="text/css">
    <title>分销等级 - <?php echo $store['name']; ?></title>
    <script src="<?php echo TPL_URL;?>js/rem.js"></script>
    <script src="<?php echo TPL_URL;?>js/jquery-1.7.2.js"></script>
    <script src="<?php echo TPL_URL;?>js/index.js"></script>
</head>
<?php
$types = array(
    1 =>'发展分销商送',
    2 =>'销售额比例生成',
    3 =>'分享送',
    4 =>'签到送',
    5 =>'推广增加',
);
?>
<style>
    .disHead ul li .level i {
        display: inline-block;
        width: 3rem;
        /* vertical-align: middle; */
        margin-right: 0.67rem;
    }
</style>
<body>
<section class="distribution">
    <div class="distributionTab dTab">
        <div class="hd">
            <ul>
                <li class="on">分销等级</li>
                <li>积分等级</li>
            </ul>
        </div>
        <div class="bd">
            <div class="row">
                <div class="disHead">
                    <ul>
                        <li>
                            <div class="level level1 "><i><img style='width: 1.3rem;' src="<?php echo empty($degree[0]['icon']) ? TPL_URL.'ucenter/images/kong.png' : getAttachmentUrl($degree[0]['icon']);?>"/></i><div class="levelDesc"><p>当前等级</p><h3><?php echo empty($degree[0]['degree_name']) ? '暂无等级' : $degree[0]['degree_name'];?></h3></div></div>
                        </li>
                        <li>
                            <div class="level level1 "><i><img style='width: 1.3rem;' src="<?php echo empty($next_degree['icon']) ? TPL_URL.'ucenter/images/kong.png' : getAttachmentUrl($next_degree['icon']);?>"/></i><div class="levelDesc"><p>下一等级</p><h3><?php echo empty($next_degree['name']) ? '暂未开放' : $next_degree['name'];?></h3></div></div>
                        </li>
                    </ul>
                </div>
                <?php foreach($drp_degree_list as $drp_degree){?>
                    <div class="distribution">
                        <div class="distribution-top">
                            <div class="fl">
                                <img src="<?php echo getAttachmentUrl($drp_degree['icon'], FALSE);?>"class="nowgradepage fl" alt="">
                                <span class="fl nowgradepage-tit nowgradepage-tita"><?php echo $drp_degree['name']?></span>
                                <div class="clear"></div>
                            </div>
                            <div class="fr"><img class="distribution-img fl" src="<?php echo TPL_URL;?>ucenter/images/bonusnow.png" alt="">
                                <span class="nowgradepage-tit nowgradepage-titb fl">所需积分：<?php echo $drp_degree['condition_point'];?></span>
                                <div class="clear"></div>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="privilege">
                            <ul>
                                <li class="fl">特权</li>
                                <li class="fl privilegeli">
                                    <div class="privilegeli-div">
                                        <img class="fl" src="<?php echo TPL_URL;?>ucenter/images/increase.png" alt="">
                                        <span class="fl"><?php echo $drp_degree['seller_reward_1'];?>%</span>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="privilegeli-zx">直销利润</div>
                                </li>
                                <li class="fl privilegeli">
                                    <div class="privilegeli-div">
                                        <img class="fl" src="<?php echo TPL_URL;?>ucenter/images/increase.png" alt="">
                                        <span class="fl"><?php echo $drp_degree['seller_reward_2'];?>%</span>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="privilegeli-zx">二级分销利润</div>
                                </li>
                                <li class="fl privilegeli">
                                    <div class="privilegeli-div">
                                        <img class="fl" src="<?php echo TPL_URL;?>ucenter/images/increase.png" alt="">
                                        <span class="fl"><?php echo $drp_degree['seller_reward_3'];?>%</span>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="privilegeli-zx">三级分销利润</div>
                                </li>
                            </ul>
                            <div class="clear"></div>
                        </div>
                    </div>
                <?php }?>
            </div>
            <div class="row">
                <div class="disHead">
                    <ul>
                        <li>
                            <div class="level"><i><img style='width: 1.3rem;' src="<?php echo TPL_URL;?>ucenter/images/bonusnow.png"/></i><div class="levelDesc"><p>当前积分</p><h3><?php echo empty($storeUserData) ? '暂无等级' : $storeUserData;?></h3></div></div>
                        </li>
                        <li>
                            <div class="level "><i><img style='width: 1.3rem;' src="<?php echo TPL_URL;?>ucenter/images/bonusnext.png"/></i><div class="levelDesc"><p>下一等级</p><h3><?php echo empty($next_degree['condition_point']) ? '暂未开放' : $next_degree['condition_point'];?></h3></div></div>
                        </li>
                    </ul>
                </div>
                <div class="table">
                    <h3>积分纪录</h3>
                    <table  width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <th>积分</th>
                            <th>内容</th>
                            <th>时间</th>
                        </tr>
                        <?php foreach ($points_record as $points) {?>
                            <tr>
                                <td><?php echo $points['points'];?></td>
                                <td><?php foreach($types as $key=>$type){?>
                                        <?php if($points['type'] == $key){?>
                                            <?php echo $type;?>
                                        <?php }?>
                                    <?php }?></td>
                                <td><?php echo date('Y-m-d H:i:s',$points['timestamp']);?></td>
                            </tr>
                        <?php }?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>