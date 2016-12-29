<!DOCTYPE html>
<html>
<head>
    <script src="<?php echo TPL_URL;?>js/rem.js"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="address=no">
    <title>分销店铺 - 我的分销</title>
    <link href="<?php echo TPL_URL;?>ucenter/css/base.css" rel="stylesheet">
    <link href="<?php echo TPL_URL;?>ucenter/css/style.css" rel="stylesheet">
</head>
<style>
    .fx-td{
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
        max-width: 3.7rem;
    }
</style>

<body>
<header class="header_title">
    <a href="javascript:void(0)" onclick="javascript:history.go(-1);"><i></i></a>
    <p>我的分销</p>
</header>
<table class="member_table">
    <thead>
    <tr>
        <th>名称</th>
        <th>销售额(元)</th>
        <th>利润(元)</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($fx_list as $store) {?>
    <tr>
        <td class="fx-td"><?php echo $store['name']?></td>
        <td><?php echo $store['sales']?></td>
        <td><?php echo $store['income']?></td>

    </tr>
    <?php }?>
    </tbody>
</table>
</body>
</html>
