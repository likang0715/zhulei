<?php

require_once dirname(__FILE__) . '/global.php';


$pigcms_id = isset($_GET['id']) ? $_GET['id'] : '';
$chahui = D('Chahui')->where(array('pigcms_id'=>$pigcms_id))->find();

$chahui['sttime']=date('Y-m-d H:i:s',$chahui['sttime']);
$chahui['endtime']=date('Y-m-d H:i:s',$chahui['endtime']);

D('Chahui')->where(array('pigcms_id' => $pigcms_id))->setInc('pv');


include display('chahui_app');

echo ob_get_clean();
?>
