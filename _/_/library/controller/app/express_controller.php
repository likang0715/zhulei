<?php
/**
 * 查看物流控制器
 */
class express_controller extends base_controller{
	// 查看物流
	public function index() {
		$type = $_REQUEST['type'];
		$express_no = $_REQUEST['express_no'];
		
		if (empty($type) || empty($express_no)) {
			json_return(1000, '缺少参数');
			exit;
		}
		
		$express = D('Express')->where(array('code' => $type))->find();
		if (empty($express)) {
			json_return(1000, '未找到相应的物流公司');
		}
		
		$url = 'http://www.kuaidi100.com/query?type=' . $type . '&postid=' . $express_no . '&id=1&valicode=&temp=' . time() . rand(100000, 999999);
		import('class.Express');
		//$content = Http::curlGet($url);
		$content = Express::kuadi100($url);
		$content_arr = json_decode($content, true);
		
		if ($content_arr['status'] != '200') {
			json_return(1000, '物流查看失败，请稍后重试');
			exit;
		} else {
			json_return(0, array('data' => $content_arr['data']));
			exit;
		}
	}
}
