<?php

/**
 *  我的收藏
 */
require_once dirname(__FILE__) . '/global.php';
if (empty($wap_user))
    redirect('./login.php?referer=' . urlencode($_SERVER['REQUEST_URI']));

if ($_GET['action'] == 'clear') {
    setcookie('good_history', '', $_SERVER['REQUEST_TIME'] - 86400 * 365, '/');
    redirect('./my_collect.php');
} else {
    $good_history = $_COOKIE['good_history'];
    if (!empty($good_history)) {
        $good_history_arr = json_decode($good_history, true);
        if (is_array($good_history_arr)) {
            foreach ($good_history_arr as &$value) {
                $tmp_time = $_SERVER['REQUEST_TIME'] - $value['time'];
                if ($tmp_time < 60) {
                    $value['time_txt'] = $tmp_time . '秒前';
                } else if ($tmp_time < 3600) {
                    $value['time_txt'] = floor($tmp_time / 60) . '分钟前';
                } else if ($_SERVER['REQUEST_TIME'] - $value['time'] < 86400) {
                    $value['time_txt'] = floor($tmp_time / 3600) . '小时前';
                } else if ($_SERVER['REQUEST_TIME'] - $value['time'] < 86400) {
                    $value['time_txt'] = floor($tmp_time / 86400) . '天前';
                }
            }
        }
    }
}
?>
