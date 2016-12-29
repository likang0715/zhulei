<?php

class cashierapi_controller extends controller {

    public function __construct(){
        parent::__construct();
    }

    // 收银台对接 - 门店列表
    public function cashPhysicalList() {
        if(IS_POST){

            $data = $this->curlDecode();
            $cashPhysicals = M("Store_physical")->cashGetList($data['mid'], $data['pg'], $data['pgsize']);

            $this->curlEncode($cashPhysicals);
            // $this->curlEncode($data);

        }else{
            $this->dexit('非法访问！');
        }
    }

    // 收银台对接 - 门店管理员列表
    public function cashPhysicalUserList () {
        if(IS_POST){

            $data = $this->curlDecode();

            $cashPhysicalUsers = M("Store_physical")->cashGetUserList($data['mid'], $data['pg'], $data['pgsize']);

            $this->curlEncode($cashPhysicalUsers);

        }else{
            $this->dexit('非法访问！');
        }
    }

    // {"error":0,"msg":"ok","data":{"orderidd":"订单号","store_id":"1"
    // "ispay":"0未支付1已支付","goodsid":"订单表自增id","goodsname":"商品名","euid":"员工id","goods_type":"商品类型",'mprice':56.25}}
    // 收银台对接 - 获取订单对接数据
    public function cashGetOrder () {

        $data = $this->curlDecode();
        
        // $data = array('mid' => $this->merchant['thirdmid'], 'orderidd' => $data['goods_name']);
        $cashOrder = M("Store_physical")->cashGetOrder($data['mid'], $data['orderidd']);

        $this->curlEncode($cashOrder);

    }

	// POST array('orderidd'=>$o2oorder,'store_id'=>$data['storeid'],'euid'=>$data['eid'],'realprice'=>$data['goods_price'],'ispay'=>1,'pay_way'=>'weixin','wxtransaction_id'=>$transaction_id,'openid'=>$tmpopenid,'mprice'=>$data['mprice']);
	// return {"error":0,"msg":"ok"}
	public function cashOrderPaySuccess () {
		$data = $this->curlDecode();
		$order_no = $data['orderidd'];
		$money = $data['realprice'];
		
		if (empty($order_no)) {
			$this->curlEncode(array('error' => 1000));
			exit;
		}
		// dump($data);
		if (strpos($order_no, option('config.orderid_prefix')) === false) {
			$order_no = option('config.orderid_prefix') . $order_no;
		}
		
		$nowOrder = M('Order')->findSimple($order_no);
		if (empty($nowOrder)) {
			$this->curlEncode(array('error' => 1000));
			exit;
		}
		
		// 已经支付
		if ($nowOrder['status'] >= 2) {
			$this->curlEncode(array('error' => 0));
			exit;
		}
		
		$pay_money = !empty($money) ? $money : $nowOrder['total'];
		$data_order['payment_method'] = !empty($_POST['pay_way']) ? $_POST['pay_way'] : $nowOrder['payment_method'];
		$data_order['trade_no'] = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999);
		$data_order['pay_money'] = $pay_money; //支付金额
		$data_order['paid_time'] = $_SERVER['REQUEST_TIME'];
		$data_order['sent_time'] = $_SERVER['REQUEST_TIME'];
		$data_order['delivery_time'] = $_SERVER['REQUEST_TIME'];
		$data_order['complate_time'] = $_SERVER['REQUEST_TIME'];
		$data_order['status'] = 4; //已完成
		if(D('Order')->where(array('order_id' => $nowOrder['order_id']))->data($data_order)->save()) {
			$nowStore = D('Store')->field('`store_id`,`income`,`unbalance`,`drp_level`,`drp_supplier_id`,`drp_diy_store`')->where(array('store_id' => $nowOrder['store_id']))->find();
		
			$data_store['income'] = $nowStore['income'] + $pay_money; //更新收入
			//$data_store['unbalance'] = $nowStore['unbalance'] + $pay_money; //更新余额
			$data_store['balance'] = $nowStore['balance'] + $pay_money;
			$data_store['last_edit_time'] = time();
			//店铺收入
			if(D('Store')->where(array('store_id' => $nowOrder['store_id']))->data($data_store)->save()) {
				$type = 1;
				if (!empty($nowOrder['type']) && $nowOrder['type'] == 3) {
					$type = 5; //类型：分销
				}
				//收入记录
				$data_financial_record = array();
				$data_financial_record['store_id']       = $nowOrder['store_id'];
				$data_financial_record['order_id']       = $nowOrder['order_id'];
				$data_financial_record['order_no']       = $nowOrder['order_no'];
				$data_financial_record['income']         = $pay_money;
				$data_financial_record['type']           = $type;
				$data_financial_record['balance']        = $nowStore['income'];
				$data_financial_record['payment_method'] = !empty($_POST['pay_way']) ? $_POST['pay_way'] : $nowOrder['payment_method'];
				$data_financial_record['trade_no']       = $nowOrder['trade_no'];
				$data_financial_record['add_time']       = $_SERVER['REQUEST_TIME'];
				$data_financial_record['user_order_id']  = $nowOrder['order_id'];
				$data_financial_record['storeOwnPay']    = $nowOrder['useStorePay'];
				$financial_record_id = D('Financial_record')->data($data_financial_record)->add();
			}
			
			//修改店铺未发货的订单数量
			if (!empty($nowOrder['uid'])) {
				M('Store_user_data')->upUserData($nowOrder['store_id'], $nowOrder['uid'], 'complete');
			}
		
			//减少库存 因为支付的特殊性，不处理是否有过修改
			$database_order_product = D('Order_product');
			$condition_order_product['order_id'] = $nowOrder['order_id'];
			$orderProductList = $database_order_product->where($condition_order_product)->select(); //订单商品列表
			$database_product = D('Product');
			$database_product_sku = D('Product_sku');
			
			foreach($orderProductList as $value) {
				//分销订单处理
				$product = M('Product')->get(array('product_id' => $value['product_id']));
				
				// 更改已签收
				D('Product')->where(array('product_id' => $value['product_id']))->data(array('in_package_status' => 3))->save();
				
				if ($value['sku_id']) {
					$condition_product_sku['sku_id'] = $value['sku_id'];
					$database_product_sku->where($condition_product_sku)->setInc('sales', $value['pro_num']);
					$database_product_sku->where($condition_product_sku)->setDec('quantity', $value['pro_num']);
				}
				$condition_product['product_id'] = $value['product_id'];
				$database_product->where($condition_product)->setInc('sales', $value['pro_num']);
				$database_product->where($condition_product)->setDec('quantity', $value['pro_num']);
				
				if (!empty($product['is_wholesale'])) { //允许批发商品
					syncSku($value['product_id'], $value['product_id'], $value['sku_data'], $value['pro_num'], false);
				}
			}
			
			$this->curlEncode(array('error' => 0));
			exit;
		} else {
			$this->curlEncode(array('error' => 1000));
			exit;
		}
	}

    private function curlDecode () {

        $postStr = file_get_contents("php://input");
        $postStr = trim($postStr);
        $postStr = base64_decode($postStr);
        $postStr = $this->Encryptioncode($postStr,'DECODE');
		//file_put_contents('./apiiiiii.log', $postStr . '\r\n\n', FILE_APPEND);
        $data = json_decode($postStr, true);

        return $data;
    }

    private function curlEncode ($data) {

        $returnData = json_encode($data, true);
        $returnData = $this->Encryptioncode($returnData, 'ENCODE');
        $returnData = base64_encode($returnData);
        $this->dexit($returnData);

    }


    /* * json 格式封装函数* */

    final public function dexit($data = '') {
        if (is_array($data)) {
            echo json_encode($data);
        } else {
            echo $data;
        }
        exit();
    }

    /**
     * 加密和解密函数
     *
     * @access public
     * @param  string  $string    需要加密或解密的字符串
     * @param  string  $operation 默认是DECODE即解密 ENCODE是加密
     * @param  string  $key       加密或解密的密钥 参数为空的情况下取全局配置encryption_key
     * @param  integer $expiry    加密的有效期(秒)0是永久有效 注意这个参数不需要传时间戳
     * @return string
     */
    public function Encryptioncode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
        $ckey_length = 4;
        $key = md5($key != '' ? $key : 'lhs_simple_encryption_code_87063');
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';

        $cryptkey = $keya . md5($keya . $keyc);
        $key_length = strlen($cryptkey);

        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
        $string_length = strlen($string);

        $result = '';
        $box = range(0, 255);

        $rndkey = array();
        for ($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }

        for ($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }

        for ($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }

        if ($operation == 'DECODE') {
            if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            return $keyc . str_replace('=', '', base64_encode($result));
        }
    }

}

?>