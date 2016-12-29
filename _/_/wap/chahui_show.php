<?php

require_once dirname(__FILE__) . '/global.php';


$pigcms_id = isset($_GET['id']) ? $_GET['id'] : '';
$chahui = D('Chahui')->where(array('pigcms_id'=>$pigcms_id))->find();

$chahui['sttime']=date('Y-m-d H:i:s',$chahui['sttime']);
$chahui['endtime']=date('Y-m-d H:i:s',$chahui['endtime']);
$store_id=$chahui['store_id'];
$now_store = M('Store')->wap_getStore($store_id);
$time=time();
$where=" zt ='$chahui[zt]' and sttime>'$time' ";

$list = D('Chahui')->where($where)->order('`sttime` ASC')->limit(2)->select();

foreach($list as $key =>$r){
$list[$key]['time']=date('m/d H:i',$r['sttime']);
$list[$key]['url']=$config['wap_site_url'] . '/chahui_show.php?id=' . $r['pigcms_id'];
}
D('Chahui')->where(array('pigcms_id' => $pigcms_id))->setInc('pv');

$is_collect = D('User_collect')->where(array('user_id' => $_SESSION['wap_user']['uid'], 'type' => 3,'dataid' => $pigcms_id))->find();

include display('chahui_show');
echo ob_get_clean();

?>
