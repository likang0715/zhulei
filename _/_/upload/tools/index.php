<?php
    require_once 'init.php';

    $where = array();

    if (!empty($_POST['replace']) && !empty($_POST['field'])) {
        if (strtolower($_POST['field']) == 'source_site_url') {
            $sql = "UPDATE " . config('DB_PREFIX') . "user SET `" . $_POST['field'] . "` = REPLACE(" . $_POST['field'] . ", '" . $_POST['source_value'] . "', '" . $_POST['target_value'] . "'), `payment_url` = REPLACE(payment_url, '" . $_POST['source_value'] . "', '" . $_POST['target_value'] . "'), `notify_url` = REPLACE(notify_url, '" . $_POST['source_value'] . "', '" . $_POST['target_value'] . "'), `oauth_url` = REPLACE(oauth_url, '" . $_POST['source_value'] . "', '" . $_POST['target_value'] . "')";
            if (!empty($_POST['value'])) {
                $sql .= " WHERE `" . $_POST['field'] . "` = '" . $_POST['value'] . "'";
            }
        } else {
            $sql = "UPDATE " . config('DB_PREFIX') . "user SET `" . $_POST['field'] . "` = REPLACE(" . $_POST['field'] . ", '" . $_POST['source_value'] . "', '" . $_POST['target_value'] . "')";
            $sql .= " WHERE `" . $_POST['field'] . "` = '" . $_POST['value'] . "'";
        }
        if ($db->execute($sql)) {
            header('Location: index.php?field=' . $_POST['field'] .'&value=' . $_POST['target_value']);
        }
    }

    if (!empty($_REQUEST['field']) && !empty($_REQUEST['value'])) {
        $field = strtolower($_REQUEST['field']);
        switch ($field) {
            case 'nickname' :
                $where[$field] = array('like', '%' . mysql_real_escape_string(trim($_REQUEST['value'])) . '%');
                break;
            default :
                $where[$field] = mysql_real_escape_string(trim($_REQUEST['value']));
        }
    }

    $user_count = $db->table(config('DB_PREFIX') . 'user')->where($where)->count('uid');
    $page = new Pager($user_count, 20, array('field' => $_REQUEST['field'], 'value' => $_REQUEST['value']));
    $users = $db->table(config('DB_PREFIX') . 'user')->where($where)->order('uid DESC')->limit($page->firstRow . ',' . $page->listRows)->select();
    $page_nav = $page->show();
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
                        <li class="active"><a href="index.php">查询</a></li>
                        <!--<li><a href="export.php">导出</a></li>
                        <li><a href="import.php">导入</a></li>-->
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
                <table border="0" cellpadding="5" cellspacing="1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>昵称</th>
                            <th>手机号</th>
                            <th>对接来源网站URL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user) { ?>
                        <tr>
                            <td><?php echo $user['uid']; ?></td>
                            <td><?php echo $user['nickname']; ?></td>
                            <td><?php echo $user['phone']; ?></td>
                            <td><?php echo $user['source_site_url']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="pagenavi">
                    <?php echo $page_nav; ?>
                </div>
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