<?php
/**
 * 退款通知
 * User: pigcms_21
 * Date: 2016/5/15
 * Time: 11:47
 */

require_once dirname(__FILE__) . '/global.php';

$payType = isset($_REQUEST['pay_type']) ? $_REQUEST['pay_type'] : 'alipay';
// 支付宝支付
if (strpos($_REQUEST['service'], 'alipay') !== false) {
    $payType = 'alipay';
}

$payMethodList = M('Config')->get_pay_method();

if ($payType == 'alipay') {
    import('source.class.pay.Alipay');

    $alipay = new Alipay(array(), $payMethodList[$payType]['config'], array());
    $refund_detail = $alipay->refund_notice();

    if (empty($refund_detail['err_code'])) {
        $return_no = $refund_detail['return_no'];
        $return = D('Return')->where(array('return_no' => array('like', '%' . $return_no . '%')))->find();
        if (empty($return['refund_status'])) { //未退款状态
            D('Return')->where(array('return_no' => array('like', '%' . $return_no . '%')))->data(array('refund_status' => 2, 'refund_time' => time()))->save();
            exit('已成功退款');
        } else if ($return['refund_status'] == 1) {
            exit('已成功退款');
        } else if ($return['refund_status'] == 2) {
            exit('已取消退款');
        }
        exit('退款失败');
    } else {
        exit('退款失败');
    }
}