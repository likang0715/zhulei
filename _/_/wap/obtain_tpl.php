<?php

require_once dirname(__FILE__).'/global.php';
//        var_dump($_SESSION);
        
        $store_info = D('Store')->where(array('store_id'=>$_GET['id']))->find();

        $img_info = D('Aptitude_obtain')->where(array('drp_supplier_id'=>$store_info['root_supplier_id'],'store_id'=>$_GET['id'],'object'=>2))->find();
       // var_dump($_GET['id']);
        // $drp_degree_id = $_SESSION['store']['drp_degree_id'];
        // $tpl_info = D('Aptitude_tpl')->where(array('status'=>1,'object'=>2,'store_id'=>$store_id,'drp_degree_id'=>$drp_degree_id))->find();
        // $tpl_info['store_name_seat'] = explode(',',$tpl_info['store_name_seat']);
        // $tpl_info['proposer_seat'] = explode(',',$tpl_info['proposer_seat']);
        // $tpl_info['validity_time_seat'] = explode(',',$tpl_info['validity_time_seat']);
        // $time = time()+$tpl_info['validity_time']*31*86400;
        // $stime = date("Y-m-d ",time());
        // $otime = date("Y-m-d ",$time);
        // $tpl_info['validity_time'] =  $stime.'— '.$otime;
//        echo data('Y-m-d',$time);

//        var_dump($tpl_info);

include display('obtain_tpl');
echo ob_get_clean();
?>