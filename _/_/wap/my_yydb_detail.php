<?php
/**
 *  一元夺宝
 */
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user))  {
	redirect('./login.php?referer=' . urlencode($_SERVER['REQUEST_URI']));
}



$action = $_GET['action'];

switch($action) {
	
	//追加
	case 'zj':
		
			$orderList = array();
			include display('my_yydb_zj');

		break;
		
	//已结束 看详情
	case 'detail':
			$orderList = array();
			include display('my_yydb_detail');	
		break;
		
	//计算详情
	case 'jsxq':
			include display('my_yydb_jsxq');	
		break;
		
	//追加结算	
	case 'zjjs':
		include display('my_yydb_zjjs');	
		break;
}



echo ob_get_clean();
?>