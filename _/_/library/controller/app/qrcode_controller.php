<?php
/**
 * 条型码、二维码控制器
 */
class qrcode_controller extends base_controller {
	// 用户条形码
	public function txm() {
		import('source.class.scanCode');
		$code = $_REQUEST['uid'];//$this->user['uid'];
		if(!$code) return false;
		//应用场景
		$scene = strtonumber(option('config.site_url') . '/card');
		//条形码文本
		$code_text = sprintf("%010d", $code);
		//条形码内容
		$code_value = '1-' . $scene . '-' . $code;
		$code_value = sprintf("%010s", $code_value);
		$barcode = new scanCode($code_value, $code_text);
		$barcode->createBarCode();
	}
	
	// 用户二维码
	public function ewm() {
		import('phpqrcode');
		//应用场景
		$scene = strtonumber(option('config.site_url') . '/card');
		$code = $_REQUEST['uid'];//$this->user['uid'];
		
		$code = '2-' . $scene . '-' . $code;
		QRcode::png(urldecode($code), false, 2, 7, 2);
	}
	
	// 店铺二维码
	public function store_ewm() {
		import('phpqrcode');
		//应用场景
		$scene = strtonumber(option('config.site_url') . '/card');
		$code = $_REQUEST['store_id'];
		$code = '2-' . $scene . '-' . $code;
		QRcode::png(urldecode($code), false , 2, 7, 2);
	}
}
?>