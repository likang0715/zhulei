<?php
    require_once 'init.php';
?>
<html>
<head>
    <meta charset="utf-8" />
    <title>微店数据导出工具</title>
    <link rel="stylesheet" href="css/style.css" />
    <script type="text/javascript" src="js/jquery.min.js"></script>
</head>
<body>
<div id="main">
    <div id="header">
        <div class="menu">
            <ul>
                <li><a href="#">查询</a></li>
                <li class="active"><a href="">导出</a></li>
                <li><a href="">导入</a></li>
            </ul>
        </div>
    </div>
    <div id="body">
        <div class="search">
            <form action="" method="get">
                <label class="label-field">字段名：</label>
                <select name="field" class="field">
                    <option value="nickname" <?php if (!empty($_REQUEST['field']) && strtolower($_REQUEST['field']) == 'nickname') { ?>selected="true" <?php } ?>>用户昵称</option>
                    <option value="phone" <?php if (!empty($_REQUEST['field']) && strtolower($_REQUEST['field']) == 'phone') { ?>selected="true" <?php } ?>>手机号</option>
                    <option value="source_site_url" <?php if (!empty($_REQUEST['field']) && strtolower($_REQUEST['field']) == 'source_site_url') { ?>selected="true" <?php } ?>>对接来源网站URL</option>
                </select>
                <input type="text" name="value" class="text" value="<?php echo !empty($_REQUEST['value']) ? $_REQUEST['value'] : ''; ?>" />
                <input type="submit" name="search" class="search-btn btn" value="查 询" />&nbsp;&nbsp;
                <label class="label-field">来源内容：</label><input type="text" name="source_value" class="text" value="<?php echo !empty($_REQUEST['value']) ? $_REQUEST['value'] : ''; ?>" /> => <label class="label-field">目标内容：</label><input type="text" name="target_value" class="text" />
                <input type="submit" name="replace" class="replace-btn btn" value="替 换" />
            </form>
        </div>
        <div class="data-table">
            <div class="table-list">
                <select multiple="true" class="tables">
                    <option><?php echo config('DB_PREFIX'); ?>user</option>
                    <option><?php echo config('DB_PREFIX'); ?>store</option>
                    <option><?php echo config('DB_PREFIX'); ?>company</option>
                    <option><?php echo config('DB_PREFIX'); ?>user_address</option>
                    <option><?php echo config('DB_PREFIX'); ?>wei_page</option>
                    <option><?php echo config('DB_PREFIX'); ?>wei_page_category</option>
                    <option><?php echo config('DB_PREFIX'); ?>wei_page_to_category</option>
                    <option><?php echo config('DB_PREFIX'); ?>wei_product</option>
                    <option><?php echo config('DB_PREFIX'); ?>product_custom_field</option>
                    <option><?php echo config('DB_PREFIX'); ?>product_group</option>
                    <option><?php echo config('DB_PREFIX'); ?>product_image</option>
                    <option><?php echo config('DB_PREFIX'); ?>product_qrcode_activity</option>
                    <option><?php echo config('DB_PREFIX'); ?>product_sku</option>
                    <option><?php echo config('DB_PREFIX'); ?>product_to_group</option>
                    <option><?php echo config('DB_PREFIX'); ?>product_to_property</option>
                    <option><?php echo config('DB_PREFIX'); ?>product_to_property_value</option>
                    <option><?php echo config('DB_PREFIX'); ?>store_nav</option>
                    <option><?php echo config('DB_PREFIX'); ?>store_supplier</option>
                    <option><?php echo config('DB_PREFIX'); ?>store_user_data</option>
                    <option><?php echo config('DB_PREFIX'); ?>store_withdrawal</option>
                </select>
            </div>
            <div class="file">
                文件名：<input type="text" value="" />
            </div>
        </div>
    </div>
    <div id="footer"></div>
</div>
</body>
</html>