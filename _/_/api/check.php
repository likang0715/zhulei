<?php
define('PIGCMS_PATH', dirname(__FILE__).'/../');
require_once PIGCMS_PATH.'source/init.php';
require_once 'functions.php';

$action 	= $_GET['action'];
if($action == 'currentUpdateFileID'){
	$updateRecord=D('System_info')->order('lastsqlupdate DESC')->find();
	echo $updateRecord['currentfileid'];
}else if($action == 'currentUpdateSqlID'){
	$updateRecord=D('System_info')->order('lastsqlupdate DESC')->find();
	echo $updateRecord['currentsqlid'];
}else if($action == 'del_system_info'){//删除旧表
	D('')->query('DROP TABLE  `'.option('system.DB_PREFIX').'system_info`');
}
?>