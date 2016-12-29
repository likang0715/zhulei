<?php
/**
 *  店铺主页
 */
require_once dirname(__FILE__).'/global.php';

$homePage = D('Wei_page')->where(array('page_id'=>$config['platform_mall_index_page']))->find();
redirect(option('config.wap_site_url').'/home.php?id='.$homePage['store_id']);

?>