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

if ($payType == 'yeepay') {
    import('source.class.pay.Yeepay');
    $payClass = new Yeepay(array(), $payMethodList[$payType]['config'], $wap_user);
    $payInfo = $payClass->notice();
    pay_notice_call($payInfo);
} else if ($payType == 'tenpay') {
    import('source.class.pay.Tenpay');
    $payClass = new Tenpay(array(), $payMethodList[$payType]['config'], $wap_user);
    $payInfo = $payClass->notice();
    pay_notice_call($payInfo);
} else if ($payType == 'test') { //测试支付 正式环境中需删除
    $payInfo = array();
    $payInfo['order_param']['trade_no'] = $_REQUEST['trade_no'];
    $payInfo['order_param']['third_id'] = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(1000000000, 9999999999);
    $payInfo['order_param']['pay_money'] = $_REQUEST['pay_money'];
    $payInfo['order_param']['pay_type'] = $_REQUEST['pay_type'];
    $payInfo['err_code'] = 0;
    pay_notice_call($payInfo);
} else if ($payType == 'weixin_peerpay') {
    import('source.class.pay.Weixin');
    $payClass = new Weixin(array(), $payMethodList['weixin']['config'], $wap_user, '');
    $payInfo = $payClass->notice();
    if ($payInfo['err_code'] === 0) {
        peerpay_notice_call($payInfo, $payInfo['echo_content']);
    } else {
        peerpay_notice_call($payInfo);
    }
} else if ($payType == 'alipay') {
	$doc = new DOMDocument();
	$doc->loadXML($_POST['notify_data']);
	$out_trade_no = $doc->getElementsByTagName("out_trade_no")->item(0)->nodeValue;

	import('source.class.pay.Alipay');

	if (strpos($out_trade_no, 'PMPAY') !== FALSE) {
		// 支付宝帐号信息
		$pay_method = array();
		$pay_method['pay_alipay_pid'] = option('config.platform_alipay_pid');
		$pay_method['pay_alipay_name'] = option('config.platform_alipay_name');
		$pay_method['pay_alipay_key'] = option('config.platform_alipay_key');

		$payClass = new Alipay(array(), $pay_method, $wap_user);
		$payInfo = $payClass->notice();
		pmp_notice_call($payInfo);
	} else {
		$payClass = new Alipay(array(), $payMethodList[$payType]['config'], $wap_user);
		$payInfo = $payClass->notice();
		pay_notice_call($payInfo);
	}
} else if ($payType == 'allinpay') {
	$payConfig = $payMethodList['allinpay']['config'];
	foreach($payConfig as $key_config => $item_config){
		$count_arrs = explode(',', $item_config);
		if(count($count_arrs)>1){
			$payConfig[$key_config] = $count_arrs[1];
		}else{
			$payConfig[$key_config] = $count_arrs[0];
		}
	}
	$pay_config['pay_allinpay_merchantid']  = $payConfig['pay_allinpay_merchantid'];
	$pay_config['pay_allinpay_merchantkey'] = $payConfig['pay_allinpay_merchantkey'];


    import('source.class.pay.Allinpay');
    $payClass = new Allinpay(array(), $pay_config, $wap_user);
    $payInfo = $payClass->return_url();
    pay_notice_call($payInfo);
}else if (!empty($GLOBALS['HTTP_RAW_POST_DATA'])) {
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

    import('source.class.pay.Weixin');
    $payClass = new Weixin(array(), $pay_method, $wap_user, '');
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
		
		
		$where = array();
		$trade_no=$payInfo['order_param']['trade_no'];
		if(strpos($trade_no, '_')){ //异常支付处理
			$order_no_arr = explode('_', $trade_no);
			//订单原始id
			$order_no = $order_no_arr[0];
			//商户订单号
			$trade_no = $order_no_arr[1];
			$where['order_no'] = $order_no;
		} else {
			$where['trade_no'] = $trade_no;
		}
		$order = D('Order')->where($where)->find();
	
		
		$order_products = D('Order_product')->where(array('order_id' => $order['order_id']))->limit(1)->select();
		foreach ($order_products as $i => $value) {
		$product = M('Product')->get(array('product_id' => $value['product_id']));
		$product_name = msubstr($product['name'], 0, 16);
		}
		$now_store = D('Store')->where(array('store_id' => $order['store_id']))->find();
			$user=M('User')->getUserById($now_store['uid']);
			$power=M('Sms_by_code')->power($now_store['store_id'],8);
			if($user['smscount']>0 && $power){
			
			$sms = D('Sms_tpl')->where(array('id'=>'8','status'=>'1'))->find();
			
				if($sms){
			 import('source.class.SendSms');
			 $storename=$now_store['name'];
			 $price=$order['total']; 
			 $content=$product_name.'等商品';
			 $ordersn=$order['order_no']; 
			 $mobile=$order['address_tel']; 
			 $name=$order['address_user'];
			 $tel=$now_store['tel'];
		     $str=$sms['text'];
			 $str=str_replace('{storename}',$storename,$str);
			 $str=str_replace('{content}',$content,$str); 
			 $str=str_replace('{ordersn}',$ordersn,$str); 
			 $str=str_replace('{mobile}',$mobile,$str); 
			 $str=str_replace('{price}',$price,$str);
		     $str=str_replace('{name}',$name,$str);
			 $str=str_replace('{tel}',$tel,$str);
			 $order_id='G'.$order['order_id'];
			 $record = D('Sms_record')->where(array('orderid'=>$order_id,'status'=>'0'))->find();
			 if($record){
			 exit($ok_msg);
			 }
			 
			
		 	 $return	= SendSms::send($mobile,$str);
	//	exit(json_encode(array('error' => 0, 'message' => $return)));
			if($return==0){
			$uid=array($now_store['uid']);
			 M('User')->deduct_sms($uid,1);	
			 
				}
			$data = array(
						'uid' 	=> $order['uid'],
						'store_id' 	=> $order['store_id'],
						'price' 	=> 10,
						'mobile' 	=> $mobile,
						'text'		=> $str,
						'status'	=> $return,
						'orderid'	=> $order_id,
						'type'	=> 8,
						'time' => time(),
						'last_ip'	=> ip2long(get_client_ip())
				);
			D('Sms_record')->data($data)->add();
			
		 }
			}
		
		
		
		
		
		$pj = D('Sms_power')->where(array('store_id' =>$order['store_id'],'type' => '18','app' => '1'))->find();
				if ($pj) {
					$sms = D('Sms_tpl')->where(array('id'=>'18','status'=>'1'))->find();

						if($sms){
				$price=$order['total']; 
			 $content=$product_name.'等商品';
					 $receiver_send = D('User')->where(array('drp_store_id'=>$_POST['store_id'],'group'=>'2'))->select();
					$value = '';
					foreach($receiver_send as $key =>$r){
					
					$value .= 'store'.$r['uid'].',';
					
					 }
					 $value .= 'store'.$now_store['uid'];
					
				
					 
					 $str=$sms['text'];
					  $str=str_replace('{content}',$content,$str); 
			 
			               $str=str_replace('{price}',$price,$str);
				
					            $n_title   =  $str;
								$n_content =  $str;		
								$receiver_value = $value;	
								$ios=array('sound'=>'default', 'content-available'=>1);
								$sendno = $order['order_id'];
								$platform = 'android,ios' ;
								$msg_content = json_encode(array('n_builder_id'=>0, 'n_title'=>$n_title, 'n_content'=>$n_content, 'n_extras'=>array('ios'=>$ios)));        
								import('source.class.Jpush');
				                $jpush = new Jpush();
								$jpush->send($sendno, 3, $receiver_value, 1, $msg_content, $platform, 1);	

                        $data = array(
						'uid' 	=> $value,
						'store_id' 	=> $now_store['store_id'],
						'price' 	=> 10,
						'mobile' 	=> $mobile,
						'text'		=> $str,
						'status'	=> 1,
						'time' => time(),
						'type'	=> 18,
						'last_ip'	=> ip2long(get_client_ip())
			               	);
		          	D('Sms_jpush')->data($data)->add();
					}
				} 
		
		
		
		
		
		
		
		
		
		
		    $power=M('Sms_by_code')->power($now_store['store_id'],18);
			if($user['smscount']>0 && $power){
			
			$sms = D('Sms_tpl')->where(array('id'=>'18','status'=>'1'))->find();
			
				if($sms){
			 import('source.class.SendSms');
			 $price=$order['total']; 
			 $content=$product_name.'等商品';
			 
			 $m = D('Sms_mobile')->where(array('store_id'=>$order['store_id'],'type'=>'1'))->find();
			 if($m){
			 $mobile=$m['mobile'];
			 }else{
			 $mobile=$now_store['tel'];
			 }
		     $str=$sms['text'];
			 
			 $str=str_replace('{content}',$content,$str); 
			 
			 $str=str_replace('{price}',$price,$str);
		     
			 $order_id='GS'.$order['order_id'];
			 $record = D('Sms_record')->where(array('orderid'=>$order_id,'status'=>'0'))->find();
			 if($record){
			 exit($ok_msg);
			 }
			 
			 
		 	 $return	= SendSms::send($mobile,$str);
	//	exit(json_encode(array('error' => 0, 'message' => $return)));
			
			$uid=array($now_store['uid']);
			if($return==0){
			 M('User')->deduct_sms($uid,1);	
			 
				}
			$data = array(
						'uid' 	=> $order['uid'],
						'store_id' 	=> $order['store_id'],
						'price' 	=> 10,
						'mobile' 	=> $mobile,
						'text'		=> $str,
						'status'	=> $return,
						'orderid'	=> $order_id,
						'type'	=> 18,
						'time' => time(),
						'last_ip'	=> ip2long(get_client_ip())
				);
			D('Sms_record')->data($data)->add();
			
		 }
			}
		
            exit($ok_msg);
        } else {
            exit($result['err_msg']);
        }
    } else {
        exit($ok_msg);
    }
}


?>