<?php
/**
 * 计划任务 ---自动释放积分
 */

define('PIGCMS_PATH', dirname(__FILE__) . '/../');
require_once PIGCMS_PATH . 'source/init.php';
require_once 'functions.php';

function IsModeCLI() {
	$sSAPIName = php_sapi_name();
	$sCleanName = strtolower(trim($sSAPIName));
	if ($sCleanName == 'cli') {
		return true;
	} else {
		return false;
	} 
} 

// 判断是否在命令行执行
if (IsModeCLI()) {
	// 调用自动发放类
	set_time_limit(0);
	SendPoints :: init();
} else {
	die('error');
} 

?>