<?php
/**
 * 天猫订单（受天猫平台接口限制，最多只能获取三个月以内的交易信息）
* @author liuqi 
* @version v1.0
* Datetime: 2016/3/23 08:53
*/
class tmall_order_controller extends base_controller{
	
	/**
	 * 订单列表
	 */
	public function order_list(){
		// 分页
		$page = max(1,(int)$_GET['page']);
		// 每页订单数量，最多20条
		$offset = max(20,(int)$_GET['offset']);
		$result = M('tmall_order')->getOrders($page,$offset);
		exit(dump($result));
		// 数据校验及授权引导
		if($result['error_code'] > 0){
			if($result['error_code'] == 1001){
				// app_id等参数未设置
				pigcms_tips($result['msg']);
			}
			
			if($result['error_code'] == 1002 || $result['error_code'] == 27){
				// access_token已过期或不存在，引导用户重新授权
				$this->doAuth();
				return;
			}
			pigcms_tips($result['msg']);
		}
		
		$order_list = $result;
		$this->assign('order_list',$order_list);
		$this->display();
	}
	
	/**
	 * 订单详情
	 */
	public function order_detail(){
		$tid = trim($_GET['tid']);
		if(strlen($tid)==0){
			pigcms_tips('订单号缺失');
		}
		$result = M('tmall')->detail($tid);
		// 数据校验及授权引导
		if($result['error_code'] > 0){
			if($result['error_code'] == 1001){
				// app_id等参数未设置
				pigcms_tips($result['msg']);
			}
				
			if($result['error_code'] == 1002 || $result['error_code'] == 27){
				// access_token已过期或不存在，引导用户重新授权
				$this->doAuth();
				return;
			}
			pigcms_tips($result['msg']);
		}
		
		$order = $result;
		$this->assign('order',$order);
		$this->display();
	}

	/**
	 * 引导用户登录授权（获取code）
	 */
	public function doAuth(){
		$auth_url = 'https://oauth.taobao.com/authorize?response_type=code&client_id=23165457&redirect_uri=http://www.baidu.com?state=1212&view=web';
		redirect($auth_url);
	}
	
	/**
	 * 引导用户登录授权（获取access_token）
	 */
	public function getAccess_token(){
		$code = $_GET('code');
		
		import('source.class.http');
		$url = '';
		$rs = Http::curlGet($url);
		$tokenInfo = (array)json_decode($rs,true);
		dump($tokenInfo);
		// 保存access_token和expired
		
	}
	
}

