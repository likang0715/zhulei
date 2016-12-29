<?php
/**
 *  支付异步通知
 */
require_once dirname(__FILE__) . '/global.php';

$payType = isset($_REQUEST['pay_type']) ? $_REQUEST['pay_type'] : (isset($_REQUEST['attach']) ? $_REQUEST['attach'] : 'weixin');

// 支付宝支付
if (strpos($_REQUEST['service'], 'alipay') !== false) {
    $payType = 'alipay';
}

$payMethodList = M('Config')->getPlatformPayMethod(true);


$payMethodList['test'] = '测试支付';
if (empty($payMethodList[$payType]) && $payType != 'alipay' && $payType != 'weixin') {
    json_return(1009, '您选择的支付方式不存在<br/>请更新支付方式');
}
if ($payType == 'weixi_peerpay') {
    if (empty($payMethodList['weixin'])) {
        json_return(1009, '您选择的支付方式不存在<br/>请更新支付方式');
    }
} else if ($payType == 'weixin') {
	if (empty($payMethodList['weixin']) && empty($payMethodList['platform_weixin'])) {
		json_return(1009, '您选择的支付方式不存在<br/>请更新支付方式');
	}
} else if ($payType == 'alipay') {
	if (empty($payMethodList[$payType]) && empty($payMethodList['platform_alipay'])) {
        json_return(1009, '您选择的支付方式不存在<br/>请更新支付方式');
    }
} else {
    if (empty($payMethodList[$payType])) {
        json_return(1009, '您选择的支付方式不存在<br/>请更新支付方式');
    }
}

if (!empty($GLOBALS['HTTP_RAW_POST_DATA'])) {
	// 对返回的数据进处理，判断是否是丛APP支付
	$array_data = json_decode(json_encode(simplexml_load_string($GLOBALS['HTTP_RAW_POST_DATA'], 'SimpleXMLElement', LIBXML_NOCDATA)), true);

	$pay_method = $payMethodList[$payType]['config'];
	if ($array_data['trade_type'] == 'APP') {
		//$pay_method = $payMethodList['weixinapp']['config'];
		$pay_method['pay_weixin_appid'] = option('config.pay_weixin_app_appid');
		$pay_method['pay_weixin_mchid'] = option('config.pay_weixin_app_mchid');
		$pay_method['pay_weixin_key'] = option('config.pay_weixin_app_key');
	}

	if (strpos($array_data['out_trade_no'], 'PMPAY') !== FALSE) {
		$pay_method['pay_weixin_appid'] = option('config.platform_weixin_appid');
		$pay_method['pay_weixin_mchid'] = option('config.platform_weixin_mchid');
		$pay_method['pay_weixin_key'] = option('config.platform_weixin_key');
	}

    import('source.class.pay.Weixinapp');
    $payClass = new Weixinapp(array(), $pay_method, $wap_user, '');
    $payInfo = $payClass->notice();

    if ($array_data['trade_type'] == 'APP') {
    	$payInfo['trade_type_app'] = 'APP';
    }
    if ($payInfo['err_code'] === 0) {
        $trade_no = $payInfo['order_param']['trade_no'];
        if (strpos($trade_no, 'PEERPAY') !== FALSE) {
            peerpay_notice_call($payInfo, $payInfo['echo_content']);
        } elseif (strpos($trade_no, 'SMSPAY') !== FALSE) {
            smspay_notice_call($payInfo, $payInfo['echo_content']);
        } elseif(strpos($trade_no, 'ZCPAY') !==FALSE){
            zcpay_notice_call($payInfo, $payInfo['echo_content']);
        } elseif(strpos($trade_no, 'DBPAY') !==FALSE){
            dbpay_notice_call($payInfo, $payInfo['echo_content']);
        } elseif (strpos($array_data['out_trade_no'], 'PMPAY') !== FALSE) {
        	pmp_notice_call($payInfo, $payInfo['echo_content']);
        } else {
            pay_notice_call($payInfo, $payInfo['echo_content']);
        }
    } else {
        pay_notice_call($payInfo);
    }
}

//对接签名
function getSign($data, $salt)
{
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            $validate[$key] = getSign($value, $salt);
        } else {
            $validate[$key] = $value;
        }
    }
    $validate['salt'] = $salt;
    sort($validate, SORT_STRING);
    return sha1(implode($validate));
}

function peerpay_notice_call($payInfo, $ok_msg = 'success', $err_msg = 'fail')
{
    if ($payInfo['err_code'] === 0) {
        $where = array();
        $where['peerpay_no'] = $payInfo['order_param']['trade_no'];
        $order_peerpay = D('Order_peerpay')->where($where)->find();

        if ($order_peerpay && $order_peerpay['status'] == '0') {
            $data = array();
            $data['pay_dateline'] = time();
            $data['third_id'] = $payInfo['order_param']['third_id'];
            $data['third_data'] = serialize($payInfo['order_param']['third_data']);
            $data['status'] = 1;

            $result = D('Order_peerpay')->where($where)->data($data)->save();
            if ($result) {
                // 查看是否支付完成，支付完成更改总订状态
                $pay_money = M('Order_peerpay')->sumMoney($order_peerpay['order_id']);
                $order = D('Order')->where(array('order_id' => $order_peerpay['order_id']))->find();
                if (!empty($order) && $order['total'] <= $pay_money) {
                    $trade_no = date('YmdHis') . mt_rand(100000, 999999);
                    D('Order')->where(array('order_id' => $order_peerpay['order_id']))->data(array('trade_no' => $trade_no))->save();
                    // 更改订单状态
                    $order_info = array();
                    $order_info['order_param']['trade_no'] = $trade_no;
                    $order_info['order_param']['pay_type'] = 'peerpay';
                    $order_info['order_param']['pay_money'] = $order['total'];
                    $order_info['order_param']['third_id'] = $trade_no;
                    $order_info['err_code'] = 0;
                    pay_notice_call($order_info);
                }
                exit($ok_msg);
            } else {
                exit($err_msg);
            }
        } else {
            exit($err_msg);
        }
    } else {
        exit($ok_msg);
    }
}

// 众筹支付回调
function zcpay_notice_call($payInfo, $ok_msg = 'success', $err_msg = 'fail'){
    	if ($payInfo['err_code'] === 0) {
	        $data_order = $where_order = $data = $where = array();
	        $where['trade_no'] = $payInfo['order_param']['trade_no'];
	        $order = D('Invest_order')->where($where)->find();

			if($order['order_type'] == 1){

				if (!empty($order) && $order['order_status'] == '1') {
					$data['pay_time'] = $_SERVER['REQUEST_TIME'];
					$data['third_id'] = $payInfo['order_param']['third_id'];
					$data['third_data'] = serialize($payInfo['order_param']['third_data']);
					$data['pay_openid'] = $payInfo['order_param']['third_data']['openid'];
					$data['order_status'] = '2';
					$effid = D('Invest_order')->where($where)->data($data)->save();
					if (!empty($effid)) {
						$where_order['project_id']=$order['project_id'];
						$where_order['order_status']='2';
						$proList=D('Invest_order')->where($where_order)->select();
						$all_intention_amount = 0 ;
						$maxShareholder = $minShareholder = 0;
						if(!empty($proList)){
							foreach ($proList as $k => $v) {
								$all_intention_amount += $v['intention_amount'];
								if($v['type']==2){
									$maxShareholder++;
								}
								if($v['type']==1){
									$minShareholder++;
								}
							}
						}
                        $data_order = 'collect='.$all_intention_amount.',invest_number=invest_number+1';
						D('Project')->where(array('project_id'=>$order['project_id']))->data($data_order)->save();
						exit($ok_msg);
					} else {
						exit($err_msg);
					}
				} else {
					exit($err_msg);
				}

			} else{


				if (!empty($order) && $order['order_status'] == '1') {
                                        $data['extract_number'] =  time().mt_rand(100000,999999);
					$data['pay_time'] = $_SERVER['REQUEST_TIME'];
					$data['third_id'] = $payInfo['order_param']['third_id'];
					$data['third_data'] = serialize($payInfo['order_param']['third_data']);
					$data['pay_openid'] = $payInfo['order_param']['third_data']['openid'];
					$data['order_status'] = '2';

					$effid = D('Invest_order')->where($where)->data($data)->save();
					if (!empty($effid)) {
                                            $databases_zc_product = D('Zc_product');
                                            $productInfo = $databases_zc_product->where(array('product_id'=>$order['project_id']))->find();
                                            $people_number = $productInfo['people_number']+1;
                                            $collect = $productInfo['collect']+$order['pay_money'];
                                            $pInfo = $databases_zc_product->where(array('product_id'=>$order['project_id']))->data(array('people_number'=>$people_number,'collect'=>$collect))->save();
                                            D('Zc_product_repay')->where(array('repay_id'=>$order['repay_id']))->data('`collect_nub` = `collect_nub`+1')->save();
						exit($ok_msg);
					} else {
						exit($err_msg);
					}
				} else {
					exit($err_msg);
				}



			}

    	} else {
        	exit($err_msg);
    	}
}

// 夺宝活动支付回调
function dbpay_notice_call($payInfo, $ok_msg = 'success', $err_msg = 'fail') {
    if ($payInfo['err_code'] === 0) {
        $where = array();
        $where['trade_no'] = $payInfo['order_param']['trade_no'];
        $unitary_order = D('Unitary_order')->where($where)->find();

        $data['paytime'] = time();
        $data['third_id'] = $payInfo['order_param']['third_id'];
        $data['third_data'] = serialize($payInfo['order_param']['third_data']);
        $data['pay_openid'] = $payInfo['order_param']['third_data']['openid'];
        $data['paid'] = 1;
        $data['total'] = $payInfo['order_param']['pay_money'];
        $data['paytype'] = $payInfo['order_param']['pay_type'];
        // $data['addtime'] = 0;

        $result = D('Unitary_order')->where($where)->data($data)->save();
        if ($result) {

            // 更新活动表的订单信息
            // $return_url = option('config.site_url').'/webapp.php?c=unitary&a=dobuy&orderid='.$unitary_order['orderid'];
            // redirect($return_url);
            exit($ok_msg);
        } else {
            exit($err_msg);
        }

    } else {
        exit($ok_msg);
    }
}

//短信支付回调
function smspay_notice_call($payInfo, $ok_msg = 'success', $err_msg = 'fail') {
    if ($payInfo['err_code'] === 0) {
        $where = array();
        $where['trade_no'] = $payInfo['order_param']['trade_no'];
        $order_sms = D('Order_sms')->where($where)->find();

        if ($order_sms && $order_sms['status'] == '0') {
            $data = array();
            $data['pay_dateline'] = time();
            $data['third_id'] = $payInfo['order_param']['third_id'];
            $data['third_data'] = serialize($payInfo['order_param']['third_data']);
            $data['pay_openid'] = $payInfo['order_param']['third_data']['openid'];
            $data['status'] = 1;

            $result = D('Order_sms')->where($where)->data($data)->save();

            if ($result) {

                $user_data = "smscount=smscount+" . $order_sms['sms_num'];
                $uid = $order_sms['uid'];
                D('User')->where(array('uid' => $uid))->data($user_data)->save();

                exit($ok_msg);
            } else {
                exit($err_msg);
            }
        } else {
            exit($err_msg);
        }
    } else {
        exit($ok_msg);
    }
}

// 平台保证金支付回调
function pmp_notice_call($payInfo, $ok_msg = 'sucess', $err_msg = 'fail') {
	global $payType;
	if ($payInfo['err_code'] === 0) {
		$trade_no_arr = explode('_', $payInfo['order_param']['trade_no']);

		$where = array();
		if ($payType == 'alipay') {
			$where['order_no'] = ltrim($trade_no_arr[0], 'PMPAY');
		} else {
			$where['trade_no'] = ltrim($trade_no_arr[count($trade_no_arr) - 1], 'PMPAY');
		}
		$platform_margin_log = D('Platform_margin_log')->where($where)->find();

		if ($platform_margin_log && $platform_margin_log['status'] != '2') {
			Margin::init($platform_margin_log['store_id']);
			Margin::recharge($platform_margin_log['order_no'], $payInfo['order_param']['third_id'], $payInfo['order_param']['pay_money'], $payInfo['order_param']['pay_type'], 2);

			exit($ok_msg);
		} else {
			exit($err_msg);
		}
	} else {
		exit($ok_msg);
	}
}

function pay_notice_call($payInfo, $ok_msg = 'success', $err_msg = 'fail') {
    if ($payInfo['err_code'] === 0) {
        import('source.class.OrderPay');
        $pay = new OrderPay();
        $result = $pay->pay_callback($payInfo['order_param']['trade_no'], $payInfo['order_param']['pay_money'], $payInfo['order_param']['pay_type'], $payInfo['order_param']['third_id'], $payInfo['order_param']['third_data']);
        if (empty($result['err_code'])) {
            exit($ok_msg);
        } else {
            exit($result['err_msg']);
        }
    } else {
        exit($ok_msg);
    }
}


?>