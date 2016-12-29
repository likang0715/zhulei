<!DOCTYPE>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <!--<link href="<?php /*echo TPL_URL;*/?>ucenter/css/base.css" rel="stylesheet">
    <link href="<?php /*echo TPL_URL;*/?>ucenter/css/index.css" rel="stylesheet">-->
    <link rel="stylesheet" href="<?php echo TPL_URL;?>ucenter/css/distribution.css" type="text/css">
    <title>企业简介</title>
</head>
<body>
<ul class="userinfo">
    <li>
        <span class="fl userinfo-left">所属公司</span>
        <span class="fl userinfo-right"><?php echo $company_info['name'];?></span>
    </li>
    <li>
        <span class="fl userinfo-left">供货商</span>
        <span class="fl userinfo-right"><?php echo $supplier_info['name'];?></span>
    </li>
    <li>
        <span class="fl userinfo-left">主营类目</span>
        <span class="fl userinfo-right"><?php echo $category_f['name'] .'-'.$category_c['name'];?></span>
    </li>
    <li>
        <span class="fl userinfo-left">创建日期</span>
        <span class="fl userinfo-right"><?php echo date('Y-m-d H:i:s', $supplier_info['date_added']);?></span>
    </li>
    <li>
        <span class="fl userinfo-left">联系人姓名</span>
        <span class="fl userinfo-right"><?php echo $supplier_info['linkman'];?></span>
    </li>
    <li>
        <span class="fl userinfo-left">联系人QQ</span>
        <span class="fl userinfo-right"><?php echo $supplier_info['qq'];?></span>
    </li>
    <li>
        <span class="fl userinfo-left">手机/电话</span>
        <span class="fl userinfo-right"><?php echo $supplier_info['tel'];?></span>
    </li>
    <li>
        <span class="fl userinfo-left">团队简介</span>
        <span class="fl userinfo-right"><?php echo empty($supplier_info['intro']) ? : '这个团队很懒，什么都没有留下';?></span>
    </li>
</ul>
</body>
</html>

