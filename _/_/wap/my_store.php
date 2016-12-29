<?php
/**
 *  微网站首页
 */
require_once dirname(__FILE__).'/global.php';
import('source.class.Margin');
import('WechatShare');

if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));

$action = $_REQUEST['action'] ? $_REQUEST['action'] : '';
$store_id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
$display = 'my_store';

switch ($action) {
	case 'withdrawal':
		//已兑换商家积分
		$store_id = !empty($store_id) ? intval($store_id) : 0;

		if (IS_POST) {
			$value = !empty($_POST['value']) ? floatval($_POST['value']) : 0;
			$type = !empty($_POST['type']) ? trim($_POST['type']) : '';

			$store = D('Store')->field('store_id,point2money,balance,point2money_balance,bank_card,income,point_balance,bank_id,bank_card,bank_card_user,opening_bank,withdrawal_type,withdrawal_amount,sales_ratio')->where(array('store_id' => $store_id, 'uid' => $wap_user['uid']))->find();

			//提现服务费
			$sales_ratio = ($store['sales_ratio'] > 0)?$store['sales_ratio']:option('config.sales_ratio');
			$sales_ratio = number_format($sales_ratio, 2, '.', '');

			if (empty($store)) {
				json_return(1001, '店铺不存在');
			}
			if ($type == 'point') { //处理积分兑换
				if ($value <= 0) {
					json_return(1003, '提现金额输入无效');
				} else if ($value > $store['point2money_balance']) {
					json_return(1005, '可提现金额不足');
				}

				$data = array();
				$data['supplier_id'] = 0;
				$data['trade_no'] = date('YmdHis',$_SERVER['REQUEST_TIME']).mt_rand(100000,999999);
				$data['uid'] = $wap_user['uid'];
				$data['store_id'] = $store_id;
				$data['bank_id'] = $store['bank_id'];
				$data['opening_bank'] = $store['opening_bank'];
				$data['bank_card'] = $store['bank_card'];
				$data['bank_card_user'] = $store['bank_card_user'];
				$data['withdrawal_type'] = $store['withdrawal_type'];
				$data['status'] = 1;
				$data['channel'] = 1;
				$data['add_time'] = time();
				$data['amount'] = $value;
				$data['type'] = 1;
				$data['sales_ratio'] = $sales_ratio;
				if (M('Store_withdrawal')->add($data)) {
					$balance = ($store['point2money_balance'] - $value > 0) ? ($store['point2money_balance'] - $value) : 0;
					D('Store')->where(array('store_id' => $store_id))->data(array('point2money_balance' => $balance))->save();

					import('source.class.Margin');
					Margin::init($store_id);
					Margin::cash_provision_log($value, 2, 0, '提现扣除备付金');

					json_return(0, '提现申请成功');
				} else {
					json_return(1006, '提现申请失败');
				}
				json_return(0, '提现申请成功');

			} else if ($type == 'amount') { //处理提现
				if ($value <= 0) {
					json_return(1003, '提现金额输入无效');
				} else if ($value > $store['balance']) {
					json_return(1005, '可提现金额不足');
				}

				$data = array();
				$data['supplier_id'] = 0;
				$data['trade_no'] = date('YmdHis',$_SERVER['REQUEST_TIME']).mt_rand(100000,999999);
				$data['uid'] = $wap_user['uid'];
				$data['store_id'] = $store_id;
				$data['bank_id'] = $store['bank_id'];
				$data['opening_bank'] = $store['opening_bank'];
				$data['bank_card'] = $store['bank_card'];
				$data['bank_card_user'] = $store['bank_card_user'];
				$data['withdrawal_type'] = $store['withdrawal_type'];
				$data['status'] = 1;
				$data['channel'] = 0;
				$data['add_time'] = time();
				$data['amount'] = $value;
				$data['type'] = 1;
				$data['sales_ratio'] = $sales_ratio;
				if (M('Store_withdrawal')->add($data)) {
					$balance = ($store['balance'] - $value > 0) ? ($store['balance'] - $value) : 0;
					D('Store')->where(array('store_id' => $store_id))->data(array('balance' => $balance))->save();

					json_return(0, '提现申请成功');
				} else {
					json_return(1006, '提现申请失败');
				}

			} else {
				json_return(1002, '参数无效');
			}
		}
		if (empty($store_id)) {
			pigcms_tips('店铺不存在');
		}
		$store = D('Store')->field('store_id,point2money,balance,bank_card,income,point_balance,point2money_balance')->where(array('store_id' => $store_id, 'uid' => $wap_user['uid']))->find();
		if (empty($store)) {
			pigcms_tips('店铺不存在');
		}

		//银行卡
		$store['bank_card'] = preg_replace('/^([1-9]{6})(\d*)(\d{4})$/', '$1******$3', $store['bank_card']);

		$display = 'my_store_withdrawal';
		break;

	case 'withdrawals':
		Margin::init($store_id);
		$point_alias = Margin::point_alias();

		if (IS_POST) {
			$page = max(1, $_REQUEST['page']);
			$limit = 6;

			$where = array();
			$where['sw.store_id'] = $store_id;
			$where['sw.uid'] = $wap_user['uid'];
			if (is_numeric($_POST['channel'])) {
				$where['sw.channel'] = $_POST['channel'];
			}
			if (!empty($_POST['start_time']) && !empty($_POST['end_time'])) {
				$start_time = strtotime($_POST['start_time'] . ' 00:00:00');
				$end_time = strtotime($_POST['end_time'] . ' 23:59:59');
				$where['_string'] = "sw.add_time >= '" . $start_time . "' AND sw.add_time <= '" . $end_time . "'";
			} else if (!empty($_POST['start_time'])) {
				$start_time = strtotime($_POST['start_time'] . ' 00:00:00');
				$where['_string'] = "sw.add_time >= '" . $start_time . "'";
			} else if (!empty($_POST['end_time'])) {
				$end_time = strtotime($_POST['end_time'] . ' 23:59:59');
				$where['_string'] = "sw.add_time <= '" . $end_time . "'";
			}
			$withdrawal_count = M('Store_withdrawal')->getWithdrawalCount($where);

			$page = min($page, ceil($withdrawal_count / $limit));
			$offset = abs(($page - 1) * $limit);
			$withdrawals = M('Store_withdrawal')->getWithdrawals($where, $offset, $limit);

			if (!empty($withdrawals)) {
				foreach ($withdrawals as &$withdrawal) {
					$withdrawal['add_time'] = date('Y-m-d H:i:s', $withdrawal['add_time']);
					$withdrawal['status'] = M('Store_withdrawal')->getWithdrawalStatus($withdrawal['status']);
					$withdrawal['channel'] = M('Store_withdrawal')->getWithdrawalChannel($withdrawal['channel']);
				}
			}

			$json_return = array();
			$json_return['noNextPage'] = true;
			$json_return['list'] = $withdrawals;
			$json_return['max_page'] = ceil($withdrawal_count / $limit);
			json_return(0, $json_return);
		}

		$display = 'my_store_withdrawals';
		break;

	case 'margin_withdrawal': //保证金提现
		$store_id = !empty($store_id) ? intval($store_id) : 0;
		$store = D('Store')->field('store_id,margin_balance,margin_withdrawal,bank_card')->where(array('store_id' => $store_id))->find();

		if (IS_POST) {
			if (empty($store)) {
				json_return(1001, '店铺不存在');
			}
			$amount = !empty($_POST['amount']) ? intval(trim($_POST['amount'])) : 0;
			if ($amount <= 0) {
				json_return(1002, '金额输入有误');
			}

			import('source.class.Margin');
			Margin::init($store_id);
			$result = Margin::consume($amount, 1, '充值现金余额返还', 1);
			if ($result) {
				json_return(0, '充值现金返还申请成功');
			} else {
				json_return(1003, '充值现金返还申请失败');
			}
		}

		if (empty($store)) {
			pigcms_tips('店铺不存在');
		}
		//银行卡
		$store['bank_card'] = preg_replace('/^([1-9]{6})(\d*)(\d{4})$/', '$1******$3', $store['bank_card']);

	  	$display = 'my_store_margin_withdrawal';
		break;

	case 'account': //提现账号
		$store_id = !empty($_GET['store_id']) ? intval($_GET['store_id']) : 0;

		if (IS_POST) {
			if (empty($store_id)) {
				json_return(1001, '缺少必要参数');
			}
			$bank_card_user = array('持卡用户', '公司名称');
			$data = array();
			$data['bank_id'] = !empty($_POST['bank_id']) ? $_POST['bank_id'] : json_return(1002, '请选择发卡银行');
			$data['opening_bank'] = !empty($_POST['opening_bank']) ? trim($_POST['opening_bank']) : json_return(1003, '请输入开户银行');
			$data['bank_card'] = !empty($_POST['bank_card']) && is_numeric($_POST['bank_card']) ? trim($_POST['bank_card']) : json_return(1005, '请输入银行卡号');
			$data['bank_card_user'] = !empty($_POST['bank_card_user']) ? trim($_POST['bank_card_user']) : json_return(1006, '请输入' . $bank_card_user[intval($_POST['withdrawal_type'])]);
			$data['withdrawal_type'] = !empty($_POST['withdrawal_type']) ? intval($_POST['withdrawal_type']) : 0;
			if (D('Store')->where(array('store_id' => $store_id, 'uid' => $wap_user['uid']))->data($data)->save()) {
				json_return(0, '提现账号编辑成功');
			} else {
				json_return(1000, '提现账号编辑失败');
			}
		}
		if (empty($store_id)) {
			pigcms_tips('缺少必要参数');
		}
		$store = D('Store')->field('store_id,bank_id,bank_card,bank_card_user,opening_bank,withdrawal_type')->where(array('store_id' => $store_id, 'uid' => $wap_user['uid']))->find();
		if (empty($store)) {
			pigcms_tips('店铺不存在');
		}
		$banks = M('Bank')->getEnableBanks();

		$display = 'my_store_account';
		break;

	default:
		$store_id = !empty($store_id) ? intval($store_id) : pigcms_tips('店铺不存在');
		$store = D('Store')->field('store_id,name,logo,margin_balance,point_balance')->where(array('store_id' => $store_id, 'uid' => $wap_user['uid']))->find();
		if (empty($store)) {
			pigcms_tips('店铺不存在');
		}
		$store['logo'] = !empty($store['logo']) ? getAttachmentUrl($store['logo']) : '../static/images/default_shop.png';
		Margin::init($store_id);
		$point_alias = Margin::point_alias();
		$now_hour = date('H',$_SERVER['REQUEST_TIME']);
		if ($now_hour > 2 || $now_hour < 4) {
			$time_tip = '午夜好';
		} else if($now_hour < 9) {
			$time_tip = '早上好';
		} else if($now_hour < 12) {
			$time_tip = '上午好';
		} else if($now_hour < 19) {
			$time_tip = '下午好';
		} else {
			$time_tip = '晚上好';
		}

		//分享配置 start
		$share_conf 	= array(
			'title' 	=> $store['name'] . ' - 我的店铺', // 分享标题
			'desc' 		=> str_replace(array("\r","\n"), array('',''),   option('config.seo_description')), // 分享描述
			'link' 		=> 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], // 分享链接
			'imgUrl' 	=> $store['logo'], // 分享图片链接
			'type'		=> '', // 分享类型,music、video或link，不填默认为link
			'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
		);

		$share 		= new WechatShare();
		$shareData 	= $share->getSgin($share_conf);
		//分享配置 end
		break;
}

include display($display);

echo ob_get_clean();
?>