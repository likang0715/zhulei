<?php
/**
 * 分销分红记录
 * User: HZ
 * Date: 2016/3/03
 * Time: 11:42
 */

require_once dirname(__FILE__).'/global.php';

if (empty($_SESSION['wap_drp_store'])) {
    pigcms_tips('您没有权限访问，<a href="./home.php?id=' . $_COOKIE['wap_store_id'] . '">返回首页</a>','none');
}

if (IS_GET && $_GET['a'] == 'index') { //分销分红
	
    $store = $_SESSION['wap_drp_store'];
    $root_supplier_id = $_SESSION['root_supplier_id'];

    if(!$root_supplier_id){

        $storeInfo = D('Store')->where(array('store_id'=>$store['store_id']))->find();
        $root_supplier_id = $storeInfo['root_supplier_id'];
    }

    //团队奖金分红 统计
    $where_team['store_id'] = $store['store_id'];
    $where_team['dividends_type'] = '2';
    $team_dividends_total = M('Dividends_send_log')->getAmountTotal($where_team);

    //独立分销奖金 统计
    $where_my['store_id'] = $store['store_id'];
    $where_my['dividends_type'] = '3';
    $my_dividends_total = M('Dividends_send_log')->getAmountTotal($where_my);
    //总奖金  统计

    $all_dividends_total = M('Dividends_send_log')->getAmountTotal(array('store_id'=>$store['store_id']));

    //可提现奖金

    $my_dividends = D('Store')->field('dividends')->where(array('store_id'=>$store['store_id']))->find();
    
    $my_dividends = $my_dividends['dividends'];


    $allow_num = 10;

    //获取奖金记录

    $dividends_send_log =  D('Dividends_send_log')->where(array('store_id'=>$store['store_id']))->order('pigcms_id desc')->limit($allow_num)->select();

    $dividends_send_log_count = D('Dividends_send_log')->where(array('store_id'=>$store['store_id']))->count('pigcms_id');


    if($dividends_send_log_count > $allow_num){
        $dividends_send_log_more = 1;
    }else{
        $dividends_send_log_more = 0;
    }



    //获取提现记录
    $where_withdrawal['store_id'] = $store['store_id'];
    $where_withdrawal['type'] = '2';
 
    $my_dividends_withdrawal = D('Store_withdrawal')->where($where_withdrawal)->order('pigcms_id desc')->limit($allow_num)->select();
    $my_dividends_withdrawal_count = D('Store_withdrawal')->where($where_withdrawal)->count('pigcms_id');

    if($my_dividends_withdrawal_count > $allow_num){
        $dividends_withdrawal_more = 1;
    }else{
        $dividends_withdrawal_more = 0;
    }
    


    //获取该分销商对应供货商设置的分红规则说明
    $where['supplier_id'] = $root_supplier_id;
    $where['dividends_type']   = array('in', array(2, 3));
    $rules_des = M('Dividends_rules')->getRulesDescription($where);
    $rules_type = array(2=>'团队奖金分红',3=>'独立分销奖金分红');

    //获取该分销商对应供货商设置的发放规则说明
    /*
        $rules_send_times = D('Dividends_send_rules')->where(array('supplier_id'=>$root_supplier_id))->find();

       
        if($rules_send_times['type'] == 1){
            $rules_send_times_str .= '<p>不限制</p>';
        }else if($rules_send_times['type'] == 2){
            $rules_send_times_str .= '<p>每月'.$rules_send_times['rules'].'号</p>';
        }else if($rules_send_times['type'] == 3){
            $_rules = unserialize($rules_send_times['rules']);
            $_count = count($_rules);
            $rules_send_times_str .= '<p>';
            foreach ($_rules as $key => $value) {
                $rules_send_times_str .= '每月'.$value['rules3_day'].'号发放'.$value['rules3_percent'].'%,';
            }
            $rules_send_times_str = rtrim($rules_send_times_str,',');
            $rules_send_times_str .= '</p>';
        }
    */

    include display('dividends_record_index');
    echo ob_get_clean();
}else if (IS_GET && $_GET['a'] == 'withdrawal') { //提现申请页面
    $store_model = M('Store');
    $bank = M('Bank');
    $financial_record = M('Financial_record');

    $store = $store_model->getStore($_SESSION['wap_drp_store']['store_id']);
    //可提现金额
    $balance = $store['balance'];
    $balance = number_format($balance, 2, '.', '');
    //佣金总额
    $income = $store['income'];
    $income = number_format($income, 2, '.', '');
    //开户行
    $bank_name = '';
    if (!empty($store['bank_id'])) {
        $bank = $bank->getBank($store['bank_id']);
        $bank_name = $bank['name'];
    }
    //提现最低金额
    $withdrawal_min_amount = option('config.withdrawal_min_amount');

    include display('dividends_withdrawal');
    echo ob_get_clean();

}else if(IS_POST && $_GET['a'] == 'get_withdrawal'){

    $store_id = $_SESSION['wap_drp_store']['store_id'];

    //获取提现记录
    $where_withdrawal['store_id'] = $store['store_id'];
    $where_withdrawal['type'] = '2';

    $allow_num = intval($_POST['allow_num']);
    $start_num = intval($_POST['start_num']);


    $my_dividends_withdrawal = D('Store_withdrawal')->where($where_withdrawal)->order('pigcms_id desc')->limit($start_num.','.$allow_num)->select();

    json_return(0,$my_dividends_withdrawal);

}else if(IS_POST && $_GET['a'] == 'get_sendlog'){

    $store_id = $_SESSION['wap_drp_store']['store_id'];

    $allow_num = intval($_POST['allow_num']);
    $start_num = intval($_POST['start_log_num']);
    
    //获取记录
    $dividends_send_log =  D('Dividends_send_log')->where(array('store_id'=>$store_id))->order('pigcms_id desc')->limit($start_num.','.$allow_num)->select();
   

    json_return(0,$dividends_send_log);

}