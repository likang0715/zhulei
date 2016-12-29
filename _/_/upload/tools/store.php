<?php
    require_once 'init.php';

    $where = array();

    if (!empty($_POST['replace']) && !empty($_POST['field']) && !empty($_POST['value'])) {
        if (strtolower($_POST['field']) == 'source_site_url') {
            $sql = "UPDATE " . config('DB_PREFIX') . "store SET `" . $_POST['field'] . "` = REPLACE(" . $_POST['field'] . ", '" . $_POST['source_value'] . "', '" . $_POST['target_value'] . "'), `payment_url` = REPLACE(payment_url, '" . $_POST['source_value'] . "', '" . $_POST['target_value'] . "'), `notify_url` = REPLACE(notify_url, '" . $_POST['source_value'] . "', '" . $_POST['target_value'] . "'), `oauth_url` = REPLACE(oauth_url, '" . $_POST['source_value'] . "', '" . $_POST['target_value'] . "')";
            $sql .= " WHERE `" . $_POST['field'] . "` = '" . mysql_real_escape_string($_POST['value']) . "'";
        } else if (strtolower($_POST['field']) == 'token') {
            $sql = "UPDATE " . config('DB_PREFIX') . "store SET `" . $_POST['field'] . "` = '" . $_POST['target_value'] . "'";
            $sql .= " WHERE `" . $_POST['field'] . "` = '" . mysql_real_escape_string($_POST['value']) . "'";
        } else {
            $sql = "UPDATE " . config('DB_PREFIX') . "store SET `" . $_POST['field'] . "` = REPLACE(" . $_POST['field'] . ", '" . $_POST['source_value'] . "', '" . $_POST['target_value'] . "')";
            $sql .= " WHERE `" . $_POST['field'] . "` = '" . mysql_real_escape_string($_POST['value']) . "'";
        }
        if ($db->execute($sql)) {
            header('Location: store.php?field=' . $_POST['field'] .'&value=' . $_POST['target_value']);
        }
    }

    if (!empty($_GET['uid'])) {
        $where  = array(
            'uid' => intval(trim($_GET['uid']))
        );
        $stores = $db->table(config('DB_PREFIX') . 'store')->where($where)->order('store_id DESC')->select();
    } else {
        if (!empty($_REQUEST['field']) && !empty($_REQUEST['value'])) {
            $field = strtolower($_REQUEST['field']);
            switch ($field) {
                case 'name' :
                    $where[$field] = array('like', '%' . mysql_real_escape_string(trim($_REQUEST['value'])) . '%');
                    break;
                default :
                    $where[$field] = mysql_real_escape_string(trim($_REQUEST['value']));
            }
            $stores = $db->table(config('DB_PREFIX') . 'store')->where($where)->order('store_id DESC')->select();
        }
    }
?>
<html>
    <head>
        <meta charset="utf-8" />
        <title>数据操作工具</title>
        <link rel="stylesheet" href="css/style.css" />
        <script type="text/javascript" src="js/jquery.min.js"></script>
    </head>
    <body>
        <div id="main">
            <div id="header">
                <div class="menu">
                    <ul>
                        <li><a href="index.php">客户列表</a></li>
                        <li class="active"><a href="store.php?a=search">查找店铺</a></li>
                    </ul>
                </div>
            </div>
            <div class="search">
                <form action="" method="get">
                    <label class="label-field">字段名：</label>
                    <select name="field" class="field">
                        <option value="name" <?php if (!empty($_REQUEST['field']) && strtolower($_REQUEST['field']) == 'name') { ?>selected="true" <?php } ?>>店铺名称</option>
                        <option value="token" <?php if (!empty($_REQUEST['field']) && strtolower($_REQUEST['field']) == 'token') { ?>selected="true" <?php } ?>>Token</option>
                        <option value="source_site_url" <?php if (!empty($_REQUEST['field']) && strtolower($_REQUEST['field']) == 'source_site_url') { ?>selected="true" <?php } ?>>对接来源网站URL</option>
                    </select>
                    <input type="text" name="value" class="text" value="<?php echo !empty($_REQUEST['value']) ? $_REQUEST['value'] : ''; ?>" />
                    <input type="submit" name="search" class="search-btn btn" value="查 询" /><br/><br/>
                    <label class="label-field">来源内容：</label><input type="text" name="source_value" class="text" value="<?php echo !empty($_REQUEST['value']) ? $_REQUEST['value'] : ''; ?>" /> => <label class="label-field">目标内容：</label><input type="text" name="target_value" class="text" />
                    <input type="submit" name="replace" class="replace-btn btn" value="替 换" />
                </form>
            </div>
            <div id="body">
                <table border="0" cellpadding="5" cellspacing="1">
                    <?php if ($stores) { ?>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>名称</th>
                            <th>Token</th>
                            <th>对接来源网站URL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stores as $store) { ?>
                        <tr>
                            <td><?php echo $store['store_id']; ?></td>
                            <td><?php echo $store['name']; ?></td>
                            <td><?php echo $store['token']; ?></td>
                            <td><?php echo $store['source_site_url']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <?php } else { ?>
                        <tr>
                            <td style="color:red" align="center">未创建店铺！</td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <div id="footer"></div>
        </div>
    </body>
</html>
<script type="text/javascript">
    $(function() {
        $('.replace-btn').bind('click', function() {
            if ($("input[name='source_value']").val() == '') {
                alert('来源内容不能为空');
                return false;
            } else if ($("input[name='target_value']").val() == '') {
                alert('目标内容不能为空');
                return false;
            }
            $('form').attr('method', 'post');
        })
    })
</script>