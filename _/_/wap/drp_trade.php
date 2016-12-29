<?php
/**
 * 分销交易记录
 * User: pigcms_21
 * Date: 2015/4/23
 * Time: 11:42
 */

require_once dirname(__FILE__).'/global.php';

if (empty($_SESSION['wap_drp_store'])) {
    pigcms_tips('您没有权限访问，<a href="./home.php?id=' . $_COOKIE['wap_store_id'] . '">返回首页</a>','none');
}

if (IS_GET && $_GET['a'] == 'index') { //交易记录
    $store_model = M('Store');
    $financial_record = M('Financial_record');

    $store = $_SESSION['wap_drp_store'];

    //收入记录数
    $where = array();
    $where['store_id'] = $store['store_id'];
    $where['income']   = array('>', 0);
    $income_records = $financial_record->getRecordCount($where);
    //支出记录数
    $where = array();
    $where['store_id'] = $store['store_id'];
    $where['income']   = array('<', 0);
    $expend_records = $financial_record->getRecordCount($where);

    include display('drp_trade_index');
    echo ob_get_clean();
} else if (IS_POST && $_POST['type'] == 'incometab') {

    $financial_record = M('Financial_record');

    $store = $_SESSION['wap_drp_store'];
    $page_size = !empty($_POST['pagesize']) ? intval(trim($_POST['pagesize'])) : 10;

    $where['store_id'] = $store['store_id'];
    $where['income']   = array('>', 0);
    $income_count = $financial_record->getRecordCount($where);

    import('source.class.user_page');
    $page = new Page($income_count, $page_size);
    $income_records = $financial_record->getRecords($where, $page->firstRow, $page->listRows);
    $html = '';
    foreach ($income_records as $record) {
        $html .= '<tr style="border: none"><td colspan="3">订单号：' . $record['order_no'] . ' <a href="drp_order.php?a=detail&id=' . $record['order_id'] . '">详细>></a></td></tr>';
        $html .= '<tr style="border-top: none;">';
        $html .=    '<td>' . $record['order_id'] . '</td>';
        $html .=    '<td align="right" style="color:green">+' . $record['income'] . '</td>';
        $html .=    '<td style="text-align: center">' . date('Y-m-d', $record['add_time']) .'</td>';
        $html .= '</tr>';
    }
    echo json_encode(array('count' => count($records), 'data' => $html));
    exit;
} else if (IS_POST && $_POST['type'] == 'expendtab') {

    $financial_record = M('Financial_record');

    $store = $_SESSION['wap_drp_store'];
    $page_size = !empty($_POST['pagesize']) ? intval(trim($_POST['pagesize'])) : 10;

    $where['store_id'] = $store['store_id'];
    $where['income']   = array('<', 0);
    $expend_count = $financial_record->getRecordCount($where);

    import('source.class.user_page');
    $page = new Page($income_count, $page_size);
    $expend_records = $financial_record->getRecords($where, $page->firstRow, $page->listRows);
    $html = '';
    foreach ($expend_records as $record) {
        $html .= '<tr style="border: none"><td colspan="3">订单号：' . $record['order_no'] . ' <a href="drp_order.php?a=detail&id=' . $record['order_id'] . '">详细>></a></td></tr>';
        $html .= '<tr style="border-top: none;">';
        $html .=    '<td>' . $record['order_id'] . '</td>';
        $html .=    '<td align="right" style="color:red">' . $record['income'] . '</td>';
        $html .=    '<td style="text-align: center">' . date('Y-m-d', $record['add_time']) . ' - ' . $financial_record->getRecordTypes($record['type']) .'</td>';
        $html .= '</tr>';
    }
    echo json_encode(array('count' => count($records), 'data' => $html));
    exit;
}