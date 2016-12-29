<?php

/**
 * 天猫商品数据模型
*/
class tmall_order_model extends tmall_core_model{
	
	// 获取一个商品信息（收费接口）
	var $method_product = 'taobao.product.get';
	// 搜索商品（收费接口）
	var $method_search = 'taobao.products.search';
	// 上传一个产品，不包括产品非主图和属性图片
	var $method_add = 'taobao.product.add';
	// 上传单张产品非主图，如果需要传多张，可调多次
	var $method_upload_img = 'taobao.product.img.upload';
	// 上传单张产品属性图片，如果需要传多张，可调多次
	var $method_upload_propimg = 'taobao.product.propimg.upload';
	// 修改一个产品，可以修改主图，不能修改子图片
	var $method_update_product = 'taobao.product.update';
	// 获取当前会话用户出售中的商品列表（收费接口）
	var $method_onsale_products = 'taobao.items.onsale.get';
	
	// 添加一个商品
	var $method_add_item = 'taobao.item.add';
	
	// 接口必须的配置信息
	var $tmall_setting = false;
	function __construct(){
		parent::__construct();
		$this->tmall_setting = D('tmall_setting')->field('uid,client_id,client_secret,access_token')->where(array('uid'=>$this->user_session['uid']))->find();
		$this->tmall_setting['app_key'] = '23165457';
		$this->tmall_setting['client_secret'] = '9061a980f408a6a467f7b3c88a6db4e3';
		$this->tmall_setting['access_token'] = '6200922d8fa239046356a1d215cafcege82d77e10fd59b22226648515';
	}
	
	/**
	 * 根据product_id获取一个商品信息
	 */
	public function get_product($product_id = 0){
		// 检查天猫接口设置
		$result = $this->check_setting(false);
		if($result['error_code'] > 0){
			return $result;
		}
		$params = $this->init_sysParams($this->tmall_setting['app_key']);
		$params['method'] = $this->method_product;
		// 业务级参数
		$params['product_id'] = $product_id;
		$params['fields'] = 'name,binds,sale_props,price,desc,pic_url,modified,status,level,pic_path,rate_num,sale_num,shop_price,standard_price,vertical_market,product_id,created';
		$params['sign'] = $this->getSign($params,$this->tmall_setting['client_secret']);
		$rs = $this->openapi($params);
		if (isset($rs['error_response'])) {
			return array('error_code'=>$rs['error_response']['code'],'msg'=>$rs['error_response']['msg']);
		}
	}
	
	/**
	 * 添加一个商品
	 * @param array $item，商品数组，必须包含(title、num、price、desc、type、stuff_status、location.state、location.city、cid)
	 * @return number 商品id
	 */
	public function add_item($item = array()){
		// 检查天猫接口设置
		$result = $this->check_setting(false);
		if($result['error_code'] > 0){
			return $result;
		}
		// 初始化系统级参数
		$params = $this->init_sysParams($this->tmall_setting['app_key']);
		$params['method'] = $this->method_product;
		// 业务级参数
		$params['title'] = $item['title'];
		$params['num'] = $item['num'];
		$params['price'] = $item['price'];
		$params['desc'] = $item['desc'];
		$params['type'] = $item['type'];
		$params['stuff_status'] = $item['stuff_status'];
		$params['location.state'] = $item['location.state'];
		$params['location.city'] = $item['location.city'];
		$params['cid'] = $item['cid'];
		
		$params['sign'] = $this->getSign($params,$this->tmall_setting['client_secret']);
		$rs = $this->openapi($params);
		if (isset($rs['error_response'])) {
			return array('error_code'=>$rs['error_response']['code'],'msg'=>$rs['error_response']['msg']);
		}
	}
}