<?php

/**
 * 天猫订单数据模型
 */
class tmall_order_model extends tmall_core_model{
	
	// 天猫订单列表接口
	var $service_list = 'taobao.trades.sold.get';
	// 天猫订单详情接口
	var $servece_detail = 'taobao.trade.fullinfo.get';
	
	// client_id、client_secret
	var $client_id = '';
	var $client_secret = '';
	
	var $tmall_setting = false;
	
	function __construct(){
		parent::__construct();
		$this->tmall_setting = D('tmall_setting')->field('uid,client_id,client_secret,access_token')->where(array('uid'=>$this->user_session['uid']))->find();
		$this->tmall_setting['app_key'] = '23165457';
		$this->tmall_setting['client_secret'] = '9061a980f408a6a467f7b3c88a6db4e3';
		$this->tmall_setting['access_token'] = '6200922d8fa239046356a1d215cafcege82d77e10fd59b22226648515';
	}
	
	/**
	 * 订单列表
	 * @param $page：页，$offset：页大小
	 */
	public function getOrders($page = 1, $offset = 20){
		// 检查天猫接口设置
		$result = $this->check_setting();
		if($result['error_code'] > 0){
			return $result;
		}
		$access_token = $this->tmall_setting['access_token'];
		$app_key = $this->tmall_setting['app_key'];
		// 系统参数
		$params = $this->init_sysParams($app_key);
		$params['method'] = 'taobao.trades.sold.get';
		$params['session'] = $access_token;
		
		// 业务参数
		$start_created = date('Y-m-d H:i:s', strtotime('-3 month'));
		$end_created = date('Y-m-d H:i:s');
		$params['fields'] = 'receiver_address,consign_time,tid,status,type,total_fee,created,buyer_nick,orders,step_trade_status,step_paid_fee,receiver_mobile';
		$params['start_created'] = $start_created;
		$params['end_created'] = $end_created;
		$params['page_no'] = $page;
		$params['page_size'] = $offset;
		$params['sign'] = $this->getSign($params,$this->tmall_setting['client_secret']);
		
		// 从天猫接口拉取数据
		$rs = $this->openapi($params);
		if (isset($rs['error_response'])) {
			return array('error_code'=>$rs['error_response']['code'],'msg'=>$rs['error_response']['msg']);
		}
		$rs = $rs['trades_sold_get_response'];
		$data['total'] = $rs['total_results'];
		$data['lists'] = isset($rs['trades']['trade']) ? $rs['trades']['trade'] : array();
		return $data;
		
	}
	
	/**
	 * 订单详情
	 * @param $tid：天猫订单id
	 */
	public function detail($tid = 0){
		// 检查天猫接口设置
		$result = $this->check_setting();
		if($result['error_code'] > 0){
			return $result;
		}
	}
	
}