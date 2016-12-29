<?php

/**
 *  活动列表
 */
require_once dirname(__FILE__) . '/global.php';

$table_name = isset($_GET['table_name']) ? trim($_GET['table_name']) : 'all';
$title_array = array('crowdfunding' => '众筹', 'seckill_action' => '秒杀', 'unitary' => '一元夺宝', 'bargain' => '砍价', 'cutprice' => '降价拍', 'lottery' => '抽奖专场');
$pageTitle = isset($title_array[$table_name]) ? $title_array[$table_name] : '活动列表';
include display('activity');
echo ob_get_clean();
?>