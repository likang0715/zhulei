<?php
/**
 *  微网站首页
 */
require_once dirname(__FILE__).'/global.php';

//所有一级分类
$cat_list = D('Product_category')->where(array('cat_fid'=>0))->order('`cat_sort` DESC')->select();


include display('index');

echo ob_get_clean();
?>