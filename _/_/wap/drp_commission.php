<?php
/**
 * 分销佣金
 * User: pigcms_21
 * Date: 2015/4/23
 * Time: 11:42
 */

require_once dirname(__FILE__).'/global.php';

if (empty($_SESSION['wap_drp_store'])) {
    pigcms_tips('您没有权限访问，<a href="./home.php?id=' . $_COOKIE['wap_store_id'] . '">返回首页</a>','none');
}

if (IS_GET && $_GET['a'] == 'index') { //分销佣金
	
	redirect('./drp_commission.php?a=statistics');
	return;
    $store_model = M('Store');
    $financial_record = M('Financial_record');

    $store = $_SESSION['wap_drp_store'];
    $store_info = $store_model->getStore($store['store_id']);

    //可提现余额
    $balance = !empty($store_info['balance']) ? $store_info['balance'] : 0;
    //已提现金额
    $withdrawal_amount = !empty($store_info['withdrawal_amount']) ? $store_info['withdrawal_amount'] : 0;

    $balance = number_format($balance, 2, '.', '');
    $withdrawal_amount = number_format($withdrawal_amount, 2, '.', '');
    //店铺url
    $store_url = option('config.wap_site_url') . '/home.php?id=' . $store['store_id'];

    include display('drp_commission_index');
    echo ob_get_clean();
} else if ($_GET['a'] == 'statistics') {
    $store_model = M('Store');
    $financial_record = M('Financial_record');

    $store = $_SESSION['wap_drp_store'];
    $store_info = $store_model->getStore($store['store_id']);

    //有分销商id
    if (!empty($_GET['store_id'])) {
        $store['store_id'] = intval(trim($_GET['store_id']));
        $store_info = $store_model->getStore($store['store_id']);
        $seller = $store_info['name'];
        $store['name'] = $seller;
    }

    if (IS_POST) {
        $type = trim($_GET['type']);
        if (strtolower($type) == 'today') { //今日佣金
            //今日佣金 00:00-6:00 6:00-12:00 12:00-18:00 18:00-24:00
            //00:00-6:00
            $starttime = strtotime(date('Y-m-d') . ' 00:00:00');
            $stoptime  = strtotime(date('Y-m-d') . ' 06:00:00');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['status']   = array('in', array(1, 3));
            $where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $todaycommissiontotal_0_6 = $financial_record->drpProfit($where);
            if (!$todaycommissiontotal_0_6) {
                $todaycommissiontotal_0_6 = 0;
            }
            //6:00-12:00
            $starttime = strtotime(date('Y-m-d') . ' 06:00:00');
            $stoptime  = strtotime(date('Y-m-d') . ' 12:00:00');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['status']   = array('in', array(1, 3));
            $where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $todaycommissiontotal_6_12 = $financial_record->drpProfit($where);
            if (!$todaycommissiontotal_6_12) {
                $todaycommissiontotal_6_12 = 0;
            }
            //12:00-18:00
            $starttime = strtotime(date('Y-m-d') . ' 12:00:00');
            $stoptime  = strtotime(date('Y-m-d') . ' 18:00:00');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['status']   = array('in', array(1, 3));
            $where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $todaycommissiontotal_12_18 = $financial_record->drpProfit($where);
            if (!$todaycommissiontotal_12_18) {
                $todaycommissiontotal_12_18 = 0;
            }
            //18:00-24:00
            $starttime = strtotime(date('Y-m-d') . ' 18:00:00');
            $stoptime  = strtotime(date('Y-m-d') . ' 23:59:59');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['status']   = array('in', array(1, 3));
            $where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $todaycommissiontotal_18_24 = $financial_record->drpProfit($where);
            if (!$todaycommissiontotal_18_24) {
                $todaycommissiontotal_18_24 = 0;
            }
            $todaycommissiontotal = "[" . number_format($todaycommissiontotal_0_6, 2, '.', '') . ',' . number_format($todaycommissiontotal_6_12, 2, '.', '') . ',' . number_format($todaycommissiontotal_12_18, 2, '.', '') . ',' . number_format($todaycommissiontotal_18_24, 2, '.', '') ."]";
            echo $todaycommissiontotal;
            exit;
        } else if (strtolower($type) == 'yesterday') { //昨日佣金
            //昨日佣金 00:00-6:00 6:00-12:00 12:00-18:00 18:00-24:00
            $date = date('Y-m-d' , strtotime('-1 day'));
            //00:00-6:00
            $starttime = strtotime($date . ' 00:00:00');
            $stoptime  = strtotime($date . ' 06:00:00');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['status']   = array('in', array(1, 3));
            $where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $yesterdaycommissiontotal_0_6 = $financial_record->drpProfit($where);
            if (!$yesterdaycommissiontotal_0_6) {
                $yesterdaycommissiontotal_0_6 = 0;
            }
            //6:00-12:00
            $starttime = strtotime($date . ' 06:00:00');
            $stoptime  = strtotime($date . ' 12:00:00');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['status']   = array('in', array(1, 3));
            $where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $yesterdaycommissiontotal_6_12 = $financial_record->drpProfit($where);
            if (!$yesterdaycommissiontotal_6_12) {
                $yesterdaycommissiontotal_6_12 = 0;
            }
            //12:00-18:00
            $starttime = strtotime($date . ' 12:00:00');
            $stoptime  = strtotime($date . ' 18:00:00');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['status']   = array('in', array(1, 3));
            $where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $yesterdaycommissiontotal_12_18 = $financial_record->drpProfit($where);
            if (!$yesterdaycommissiontotal_12_18) {
                $yesterdaycommissiontotal_12_18 = 0;
            }
            //18:00-24:00
            $starttime = strtotime($date . ' 18:00:00');
            $stoptime  = strtotime($date . ' 23:59:59');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['status']   = array('in', array(1, 3));
            $where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $yesterdaycommissiontotal_18_24 = $financial_record->drpProfit($where);
            if (!$yesterdaycommissiontotal_18_24) {
                $yesterdaycommissiontotal_18_24 = 0;
            }
            $yesterdaycommissiontotal = "[" . number_format($yesterdaycommissiontotal_0_6, 2, '.', '') . ',' . number_format($yesterdaycommissiontotal_6_12, 2, '.', '') . ',' . number_format($yesterdaycommissiontotal_12_18, 2, '.', '') . ',' . number_format($yesterdaycommissiontotal_18_24, 2, '.', '') ."]";
            echo $yesterdaycommissiontotal;
            exit;
        } else if (strtolower($type) == 'week') {
            $date = date('Y-m-d');  //当前日期
            $first = 1; //$first =1 表示每周星期一为开始日期 0表示每周日为开始日期
            $w = date('w',strtotime($date));  //获取当前周的第几天 周日是 0 周一到周六是 1 - 6
            $now_start = date('Y-m-d',strtotime("$date -".($w ? $w - $first : 6).' days')); //获取本周开始日期，如果$w是0，则表示周日，减去 6 天
            $now_end   = date('Y-m-d',strtotime("$now_start +6 days"));  //本周结束日期

            //周一佣金
            $starttime = strtotime($now_start . ' 00:00:00');
            $stoptime  = strtotime($now_start . ' 23:59:59');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['status']   = array('in', array(1, 3));
            $where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $weekcommissiontotal_1 = $financial_record->drpProfit($where);
            if (!$weekcommissiontotal_1) {
                $weekcommissiontotal_1 = 0;
            }
            //周二佣金
            $starttime = strtotime(date("Y-m-d",strtotime($now_start . "+1 day")) . ' 00:00:00');
            $stoptime  = strtotime(date("Y-m-d",strtotime($now_start . "+1 day")) . ' 23:59:59');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['status']   = array('in', array(1, 3));
            $where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $weekcommissiontotal_2 = $financial_record->drpProfit($where);
            if (!$weekcommissiontotal_2) {
                $weekcommissiontotal_2 = 0;
            }
            //周三佣金
            $starttime = strtotime(date("Y-m-d",strtotime($now_start . "+2 day")) . ' 00:00:00');
            $stoptime  = strtotime(date("Y-m-d",strtotime($now_start . "+2 day")) . ' 23:59:59');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['status']   = array('in', array(1, 3));
            $where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $weekcommissiontotal_3 = $financial_record->drpProfit($where);
            if (!$weekcommissiontotal_3) {
                $weekcommissiontotal_3 = 0;
            }
            //周四佣金
            $starttime = strtotime(date("Y-m-d",strtotime($now_start . "+3 day")) . ' 00:00:00');
            $stoptime  = strtotime(date("Y-m-d",strtotime($now_start . "+3 day")) . ' 23:59:59');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['status']   = array('in', array(1, 3));
            $where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $weekcommissiontotal_4 = $financial_record->drpProfit($where);
            if (!$weekcommissiontotal_4) {
                $weekcommissiontotal_4 = 0;
            }
            //周五佣金
            $starttime = strtotime(date("Y-m-d",strtotime($now_start . "+4 day")) . ' 00:00:00');
            $stoptime  = strtotime(date("Y-m-d",strtotime($now_start . "+4 day")) . ' 23:59:59');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['status']   = array('in', array(1, 3));
            $where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $weekcommissiontotal_5 = $financial_record->drpProfit($where);
            if (!$weekcommissiontotal_5) {
                $weekcommissiontotal_5 = 0;
            }
            //周六佣金
            $starttime = strtotime(date("Y-m-d",strtotime($now_start . "+5 day")) . ' 00:00:00');
            $stoptime  = strtotime(date("Y-m-d",strtotime($now_start . "+5 day")) . ' 23:59:59');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['status']   = array('in', array(1, 3));
            $where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $weekcommissiontotal_6 = $financial_record->drpProfit($where);
            if (!$weekcommissiontotal_6) {
                $weekcommissiontotal_6 = 0;
            }
            //周日佣金
            $starttime = strtotime(date("Y-m-d",strtotime($now_start . "+6 day")) . ' 00:00:00');
            $stoptime  = strtotime(date("Y-m-d",strtotime($now_start . "+6 day")) . ' 23:59:59');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['status']   = array('in', array(1, 3));
            $where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $weekcommissiontotal_7 = $financial_record->drpProfit($where);
            if (!$weekcommissiontotal_7) {
                $weekcommissiontotal_7 = 0;
            }
            $weekcommissiontotal = "[" . number_format($weekcommissiontotal_1, 2, '.', '') . ',' . number_format($weekcommissiontotal_2, 2, '.', '') . ',' . number_format($weekcommissiontotal_3, 2, '.', '') . ',' . number_format($weekcommissiontotal_4, 2, '.', '') . ',' . number_format($weekcommissiontotal_5, 2, '.', '') . ',' . number_format($weekcommissiontotal_6, 2, '.', '') . ',' . number_format($weekcommissiontotal_7, 2, '.', '') ."]";
            echo $weekcommissiontotal;
            exit;
        } else if (strtolower($type) == 'month') { //当月佣金
            $month = date('m');
            $year  = date('Y');
            //1-7日
            $starttime = strtotime($year . '-' . $month . '-01' . ' 00:00:00');
            $stoptime  = strtotime($year . '-' . $month . '-07' . ' 00:00:00');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['status']   = array('in', array(1, 3));
            $where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $monthcommissiontotal_1_7 = $financial_record->drpProfit($where);
            if (!$monthcommissiontotal_1_7) {
                $monthcommissiontotal_1_7 = 0;
            }
            //7-14日
            $starttime = strtotime($year . '-' . $month . '-07' . ' 00:00:00');
            $stoptime  = strtotime($year . '-' . $month . '-14' . ' 00:00:00');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['status']   = array('in', array(1, 3));
            $where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $monthcommissiontotal_7_14 = $financial_record->drpProfit($where);
            if (!$monthcommissiontotal_7_14) {
                $monthcommissiontotal_7_14 = 0;
            }
            //14-21日
            $starttime = strtotime(($year . '-' . $month . '-14') . ' 00:00:00');
            $stoptime  = strtotime(($year . '-' . $month . '-21') . ' 00:00:00');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['status']   = array('in', array(1, 3));
            $where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $monthcommissiontotal_14_21 = $financial_record->drpProfit($where);
            if (!$monthcommissiontotal_14_21) {
                $monthcommissiontotal_14_21 = 0;
            }
            //21-本月结束
            //当月最后一天
            $lastday = date('t',time());
            $starttime = strtotime($year . '-' . $month . '-21' . ' 00:00:00');
            $stoptime  = strtotime($year . '-' . $month . '-' . $lastday . ' 23:59:59');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['status']   = array('in', array(1, 3));
            $where['_string']  = "add_time >= " . $starttime . " AND add_time <= " . $stoptime;
            $monthcommissiontotal_21_end = $financial_record->drpProfit($where);
            if (!$monthcommissiontotal_21_end) {
                $monthcommissiontotal_21_end = 0;
            }
            $data = array();
            $monthcommissiontotal = "[" . number_format($monthcommissiontotal_1_7, 2, '.', '') . ',' . number_format($monthcommissiontotal_7_14, 2, '.', '') . ',' . number_format($monthcommissiontotal_14_21, 2, '.', '') . ',' . number_format($monthcommissiontotal_21_end, 2, '.', '') ."]";
            $data['monthcommissiontotal'] = $monthcommissiontotal;
            $data['lastday'] = $lastday;
            echo json_encode(array('data' => $data));
            exit;
        }
    }

    //店铺余额
    $unbalance  = !empty($store_info['unbalance']) ? $store_info['unbalance'] : 0;
    $balance    = !empty($store_info['balance']) ? $store_info['balance'] : 0;
    $store['balance']   = number_format($balance, 2, '.', '');
    $store['unbalance'] = number_format($unbalance, 2, '.', '');

    include display('drp_commission_statistics');
    echo ob_get_clean();
} else if (IS_GET && $_GET['a'] == 'withdrawal') { //提现申请页面

    if(isset($_GET['type'])){
        $type = trim($_GET['type']);
    }else{
        $type = 'income';
    }

    switch ($type) {
        case 'dividends'://分红申请单独处理
            import('source.class.Drp');
            $store_model = M('Store');
            $bank = M('Bank');
            $store = $store_model->getStore($_SESSION['wap_drp_store']['store_id']);
            //可提现分红
            $dividends = $store['dividends'];
            $dividends = number_format($dividends, 2, '.', '');
            //开户行
            $bank_name = '';
            if (!empty($store['bank_id'])) {
                $bank = $bank->getBank($store['bank_id']);
                $bank_name = $bank['name'];
            }
            //提现最低金额
            $withdrawal_min_amount = Drp::withdrawal_min($store['root_supplier_id']);

            include display('drp_dividends_withdrawal');
            echo ob_get_clean();
            break;
        
        default:
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
            $withdrawal_min_amount = Drp::withdrawal_min($store['root_supplier_id']);

            include display('drp_commission_withdrawal');
            echo ob_get_clean();
            break;
    }
 
} else if (IS_POST && $_POST['type'] == 'dividends_withdrawal') { //分红提现申请提交

    $store = M('Store');
    $store_withdrawal = M('Store_withdrawal');

    $store_info = $store->getStore($_SESSION['wap_drp_store']['store_id']);

    $supplier_supply = D('Store_supplier')->field('supply_chain')->where(array('seller_id'=>$store_info['store_id']))->find();

    $supplier_array = explode(',', $supplier_supply['supply_chain']);

    $supplier_id = $supplier_array[1];

    if (empty($store_info)) {
        json_return(1002, '店铺不存在，提现失败');
    }

    $data = array();
    $data['supplier_id'] = $supplier_id;
    $data['trade_no']        = date('YmdHis',$_SERVER['REQUEST_TIME']).mt_rand(100000,999999);
    $data['uid']             = $store_info['uid'];
    $data['store_id']        = $store_info['store_id'];
    $data['bank_id']         = isset($_POST['bank_id']) ? intval(trim($_POST['bank_id'])) : 0;
    $data['opening_bank']    = isset($_POST['opening_bank']) ? trim($_POST['opening_bank']) : '';
    $data['bank_card']       = isset($_POST['bank_card']) ? trim($_POST['bank_card']) : '';
    $data['bank_card_user']  = isset($_POST['bank_card_user']) ? trim($_POST['bank_card_user']) : '';
    $data['withdrawal_type'] = 0; //对私
    $data['amount']          = isset($_POST['amount']) ? floatval(trim($_POST['amount'])) : 0;
    $data['status']          = 1; //申请中
    $data['add_time']        = time();

    //分红提现类型
    $data['type'] = '2';
    $data['bak'] = '分红';

    if ($store_info['dividends'] >= $data['amount']) {
        if ($store_withdrawal->add($data)) {
            //减分红余额
            D('Store')->where(array('store_id' => $data['store_id']))->setDec('dividends', $data['amount']);
            json_return(0, $data['amount']);
        } else {
            json_return(1001, $data['amount']);
        }
    } else {
        json_return(1002, '余额不足，提现失败');
    }

}else if (IS_GET && $_GET['a'] == 'dividends_withdrawal_result') { //提现申请结果
    $store = $_SESSION['wap_drp_store'];
    $amount = !empty($_GET['amount']) ? trim($_GET['amount']) : 0;
    $status = !empty($_GET['status']) ? intval(trim($_GET['status'])) : 0;
    if ($status) {
        include display('drp_commission_dividends_withdrawal_success');
    } else {
        include display('drp_commission_dividends_withdrawal_error');
    }
    echo ob_get_clean();
} else if (IS_POST && $_POST['type'] == 'withdrawal') { //提现申请提交

    $store = M('Store');
    $store_withdrawal = M('Store_withdrawal');

    $store_info = $store->getStore($_SESSION['wap_drp_store']['store_id']);

    $supplier_supply = D('Store_supplier')->field('supply_chain')->where(array('seller_id'=>$store_info['store_id']))->find();

    $supplier_array = explode(',', $supplier_supply['supply_chain']);

    $supplier_id = $supplier_array[1];

    if (empty($store_info)) {
        json_return(1002, '店铺不存在，提现失败');
    }

    $data = array();
    $data['supplier_id'] = $supplier_id;
    $data['trade_no']        = date('YmdHis',$_SERVER['REQUEST_TIME']).mt_rand(100000,999999);
    $data['uid']             = $store_info['uid'];
    $data['store_id']        = $store_info['store_id'];
    $data['bank_id']         = isset($_POST['bank_id']) ? intval(trim($_POST['bank_id'])) : 0;
    $data['opening_bank']    = isset($_POST['opening_bank']) ? trim($_POST['opening_bank']) : '';
    $data['bank_card']       = isset($_POST['bank_card']) ? trim($_POST['bank_card']) : '';
    $data['bank_card_user']  = isset($_POST['bank_card_user']) ? trim($_POST['bank_card_user']) : '';
    $data['withdrawal_type'] = 0; //对私
    $data['amount']          = isset($_POST['amount']) ? floatval(trim($_POST['amount'])) : 0;
    $data['status']          = 1; //申请中
    $data['add_time']        = time();

    if ($store_info['balance'] >= $data['amount']) {
        if ($store_withdrawal->add($data)) {
            //减余额
            $store->applywithdrawal($data['store_id'], $data['amount']);
            json_return(0, $data['amount']);
        } else {
            json_return(1001, $data['amount']);
        }
    } else {
        json_return(1002, '余额不足，提现失败');
    }

} else if (IS_GET && $_GET['a'] == 'withdrawal_result') { //提现申请结果
    $store = $_SESSION['wap_drp_store'];
    $amount = !empty($_GET['amount']) ? trim($_GET['amount']) : 0;
    $amount = number_format($amount, 2, '.', '');
    $status = !empty($_GET['status']) ? intval(trim($_GET['status'])) : 0;
    if ($status) {
        include display('drp_commission_withdrawal_success');
    } else {
        include display('drp_commission_withdrawal_error');
    }
    echo ob_get_clean();
} else if (IS_GET && $_GET['a'] == 'withdraw_account') { //提现账号
    $bank = M('Bank');
    $store = M('Store');

    $store_id = $_SESSION['wap_drp_store']['store_id'];
    $store = $store->getStore($store_id);
    $banks = $bank->getEnableBanks();

    include display('drp_commission_withdrawal_account');
    echo ob_get_clean();
} else if (IS_POST && $_POST['type'] == 'withdraw_account') { //提现账号修改
    $store = M('Store');

    $store_id = $_SESSION['wap_drp_store']['store_id'];
    $bank_id = isset($_POST['bank_id']) ? intval(trim($_POST['bank_id'])) : 0;
    $opening_bank = isset($_POST['opening_bank']) ? trim($_POST['opening_bank']) : '';
    $bank_card = isset($_POST['bank_card']) ? trim($_POST['bank_card']) : '';
    $bank_card_user = isset($_POST['bank_card_user']) ? trim($_POST['bank_card_user']) : '';

    if ($store->settingWithdrawal(array('store_id' => $store_id), array('bank_id' => $bank_id, 'opening_bank' => $opening_bank, 'bank_card' => $bank_card, 'bank_card_user' => $bank_card_user, 'last_edit_time' => time()))) {
        json_return(0, '保存成功');
    } else {
        json_return(1001, '保存失败');
    }
} else if (IS_GET && $_GET['a'] == 'detail') { //佣金明细
    $financial_record = M('Financial_record');
    $store_withdrawal = M('Store_withdrawal');

    $store = $_SESSION['wap_drp_store'];
    $where = array();
    $where['store_id'] = $store['store_id'];
    $date = strtolower(trim($_GET['date']));
    if ($date == 'today') { //今天佣金明细
        $starttime = strtotime(date("Y-m-d") . ' 00:00:00');
        $stoptime = strtotime(date("Y-m-d") . ' 23:59:59');
        $where['_string'] = "add_time >= " . $starttime . " AND add_time <= " . $stoptime;
    } else if ($date == 'yesterday') { //昨天佣金明细
        $date = date('Y-m-d' , strtotime('-1 day'));

        $starttime = strtotime($date . ' 00:00:00');
        $stoptime = strtotime($date . ' 23:59:59');
        $where['_string'] = "add_time >= " . $starttime . " AND add_time <= " . $stoptime;
    } else if ($date == 'week') { //本周佣金明细
        $date = date('Y-m-d');  //当前日期
        $first = 1; //$first =1 表示每周星期一为开始日期 0表示每周日为开始日期
        $w = date('w',strtotime($date));  //获取当前周的第几天 周日是 0 周一到周六是 1 - 6
        $now_start = date('Y-m-d',strtotime("$date -".($w ? $w - $first : 6).' days')); //获取本周开始日期，如果$w是0，则表示周日，减去 6 天
        $now_end = date('Y-m-d',strtotime("$now_start +6 days"));  //本周结束日期

        $starttime = strtotime($now_start . ' 00:00:00');
        $stoptime = strtotime($now_end . ' 23:59:59');
        $where['_string'] = "add_time >= " . $starttime . " AND add_time <= " . $stoptime;
    } else if ($date == 'month') { //本月佣金明细
        $month = date('m');
        $year = date('Y');
        //当月最后一天
        $lastday = date('t',time());

        $starttime = strtotime($year . '-' . $month . '-01' . ' 00:00:00');
        $stoptime = strtotime($year . '-' . $month . '-' . $lastday . ' 23:59:59');
        $where['_string'] = "add_time >= " . $starttime . " AND add_time <= " . $stoptime;
    }
    $record_count = $financial_record->getProfitRecordCount($where);
    $withdrawal_count = $store_withdrawal->getWithdrawalCount(array('store_id' => $store['store_id']));

    include display('drp_commission_detail');
    echo ob_get_clean();
} else if (IS_GET && $_GET['a'] == 'from') { //佣金明细

    $id = intval(trim($_GET['id']));
    if (empty($id)) {
        pigcms_tips('抱歉，佣金记录不存在！');
    }
    $order_product = M('Order_product');
    $fx_order = M('Fx_order');

    $store = $_SESSION['wap_drp_store'];

    $record = D('Financial_record')->where(array('pigcms_id' => $id, 'store_id' => $store['store_id']))->find();
    $record['order_no'] = option('config.orderid_prefix') . $record['order_no'];

    $order = M('Order');
    $order_detail = $order->getOrder($store['store_id'], $record['order_id']);
    $order_detail['add_time'] = date('Y-m-d H:i:s', $order_detail['add_time']);

    //供货商
    $fx_order = $fx_order->getSellerOrder($store['store_id'], $record['order_id']);
    $supplier = D('Store')->where(array('store_id' => $fx_order['supplier_id']))->find();
    $order_detail['supplier'] = $supplier['name'];

    //利润
    $profit = M('Financial_record')->getTotal(array('order_id' => $record['order_id']));
    $order_detail['profit'] = number_format($profit, 2, '.', '');

    if (empty($order_detail['user_order_id'])) {
        $from = '本店';
    } else {
        $fx_order = D('Fx_order')->field('store_id')->where(array('fx_order_id' => $order_detail['fx_order_id']))->find();
        $store_id = $fx_order['store_id'];
        $store = D('Store')->field('name')->where(array('store_id' => $store_id))->find();
        $from = $store['name'];
    }
    $order_detail['from'] = $from;

    $products = $order_product->getProducts($record['order_id']);
    foreach ($products as $key => $product) {
        $products[$key]['image'] = getAttachmentUrl($product['image']);
        if (!empty($product['sku_data'])) {
            $sku_data = unserialize($product['sku_data']);
            foreach ($sku_data as $key2 => $sku) {
                $products[$key]['skus'][$key2] = array('name' => $sku['name'], 'value' => $sku['value']);
            }
        }

        //向后兼容利润计算
        $no_profit = false;
        if ($product['profit'] == 0) {
            $fx_order = D('Fx_order')->field('fx_order_id')->where(array('order_id' => $order_detail['order_id']))->find();
            $fx_order_product = D('Fx_order_product')->field('cost_price')->where(array('fx_order_id' => $fx_order['fx_order_id'], 'source_product_id' => $product['product_id']))->find();
            $product['cost_price'] = $fx_order_product['cost_price'];
            $product['profit'] = $product['pro_price'] - $product['cost_price'];
            if ($product['profit'] <= 0) {
                $product['profit'] = 0;
                $no_profit = true;
            }
        }
        $product['cost_price'] = ($product['pro_price'] - $product['profit'] > 0) ? $product['pro_price'] - $product['profit'] : 0;
        if ($product['profit'] == 0 && empty($product['supplier_id']) && empty($no_profit)) {
            $product['profit'] = $product['pro_price'];
        }
        $products[$key]['profit']     = number_format($product['profit'], 2, '.', '');
        $products[$key]['cost_price'] = number_format($product['cost_price'], 2, '.', '');
    }

    include display('drp_commission_from');
    echo ob_get_clean();

} else if (IS_POST && $_POST['type'] == 'brokeragetab') {
    $financial_record = M('Financial_record');

    $store = $_SESSION['wap_drp_store'];
    $page_size = !empty($_POST['pagesize']) ? intval(trim($_POST['pagesize'])) : 10;
    $where['store_id'] = $store['store_id'];
    $date = strtolower(trim($_POST['date']));
    if ($date == 'today') { //今天佣金明细
        $starttime = strtotime(date("Y-m-d") . ' 00:00:00');
        $stoptime  = strtotime(date("Y-m-d") . ' 23:59:59');
        $where['_string'] = "add_time >= " . $starttime . " AND add_time <= " . $stoptime;
    } else if ($date == 'yesterday') { //昨天佣金明细
        $date = date('Y-m-d' , strtotime('-1 day'));
        $starttime = strtotime($date . ' 00:00:00');
        $stoptime  = strtotime($date . ' 23:59:59');
        $where['_string'] = "add_time >= " . $starttime . " AND add_time <= " . $stoptime;
    } else if ($date == 'week') { //本周佣金明细
        $date = date('Y-m-d');  //当前日期
        $first = 1; //$first =1 表示每周星期一为开始日期 0表示每周日为开始日期
        $w = date('w',strtotime($date));  //获取当前周的第几天 周日是 0 周一到周六是 1 - 6
        $now_start = date('Y-m-d',strtotime("$date -".($w ? $w - $first : 6).' days')); //获取本周开始日期，如果$w是0，则表示周日，减去 6 天
        $now_end   = date('Y-m-d',strtotime("$now_start +6 days"));  //本周结束日期

        $starttime = strtotime($now_start . ' 00:00:00');
        $stoptime  = strtotime($now_end . ' 23:59:59');
        $where['_string'] = "add_time >= " . $starttime . " AND add_time <= " . $stoptime;
    } else if ($date == 'month') { //本月佣金明细
        $month = date('m');
        $year = date('Y');
        //当月最后一天
        $lastday = date('t',time());

        $starttime = strtotime($year . '-' . $month . '-01' . ' 00:00:00');
        $stoptime = strtotime($year . '-' . $month . '-' . $lastday . ' 23:59:59');
        $where['_string'] = "add_time >= " . $starttime . " AND add_time <= " . $stoptime;
    }
    $record_count = $financial_record->getProfitRecordCount($where);
    import('source.class.user_page');
    $page = new Page($record_count, $page_size);
    $records = $financial_record->getProfitRecords($where, $page->firstRow, $page->listRows);
    $html = '';
    foreach ($records as $record) {
        //退货
        $return_profit = D('Financial_record')->where(array('order_id' => $record['order_id'], 'store_id' => $record['store_id'], 'type' => 3))->sum('income');
        $html .= '<tr style="border: none"><td colspan="3">订单号：<a href="drp_order.php?a=detail&id=' . $record['order_id'] . '">' . option('config.orderid_prefix') . $record['order_no'] . '</a> <a href="drp_commission.php?a=from&id=' . $record['pigcms_id'] . '">详细>></a></td></tr>';
        $html .= '<tr style="border-top: none;">';
        $html .=    '<td>' . $record['order_id'] . '</td>';
        $html .=    '<td align="right" style="color:green">+' . number_format($record['profit'] + $return_profit, 2, '.', '') . '</td>';
        $html .=    '<td style="text-align: center">' . date('Y-m-d', $record['add_time']) .'</td>';
        $html .= '</tr>';
    }
    echo json_encode(array('count' => count($records), 'data' => $html));
    exit;
} else if (IS_POST && $_POST['type'] == 'extracttab') { //提现记录

    $store_withdrawal = M('Store_withdrawal');

    $store = $_SESSION['wap_drp_store'];
    $page_size = !empty($_POST['pagesize']) ? intval(trim($_POST['pagesize'])) : 10;
    $withdrawal_count = $store_withdrawal->getWithdrawalCount(array('sw.store_id' => $store['store_id']));
    import('source.class.user_page');
    $page = new Page($withdrawal_count, $page_size);
    $withdrawals = $store_withdrawal->getWithdrawals(array('sw.store_id' => $store['store_id']), $page->firstRow, $page->listRows);
    $html = '';
    foreach ($withdrawals as $withdrawal) {
        $html .= '<tr>';
        $html .=    '<td style="text-align: center">' . date('Y-m-d H:i:s', $withdrawal['add_time']) . '</td>';
        $html .=    '<td align="right">' . $withdrawal['amount'] . '</td>';
        $html .=    '<td style="text-align: center">' . $store_withdrawal->getWithdrawalStatus($withdrawal['status']) .'</td>';
        $html .= '</tr>';
    }
    echo json_encode(array('count' => count($records), 'data' => $html));
    exit;
}