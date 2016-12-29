<?php
/**
 * 维权
 */
class rights_controller extends base_controller{
	public function apply() {
		$order_id = $_GET['order_no'];
		$pigcms_id = $_GET['pigcms_id'];
		$is_ajax = $_POST['is_ajax'];
		if (empty($order_id) || empty($pigcms_id)) {
			if ($is_ajax) {
				echo json_encode(array('status' => false, 'msg' => '缺少最基本的参数'));
				exit;
			}
			pigcms_tips('缺少最基本的参数');
		}
		
		if (empty($this->user_session)) {
			$referer = $_SERVER['HTTP_REFERER'];
			if (empty($referer)) {
				$referer = url('account:order');
			}
			
			if ($is_ajax) {
				echo json_encode(array('status' => false, 'data' => array('nexturl' => 'refresh')));
				exit;
			}
			redirect(url('account:login', array('referer' => $referer)));
		}
		
		// 只能查看自己的订单
		$order_model = M('Order');
		$order = $order_model->find($order_id);
		
		if (empty($order)) {
			if ($is_ajax) {
				echo json_encode(array('status' => false, 'msg' => '未找到相应的订单'));
				exit;
			}
			
			pigcms_tips('未找到相应的订单');
		}
		
		if ($order['uid'] != $this->user_session['uid']) {
			if ($is_ajax) {
				echo json_encode(array('status' => false, 'msg' => '您无权查看此订单'));
				exit;
			}
			pigcms_tips('您无权查看此订单');
		}
		
		if (!in_array($order['status'], array(2, 3, 4, 7))) {
			if ($is_ajax) {
				echo json_encode(array('status' => false, 'msg' => '此订单不能维权'));
				exit;
			}
			pigcms_tips('此订单不能维权');
		}
		
		$order_product = D('Order_product')->where(array('pigcms_id' => $pigcms_id))->find();
		
		if (empty($order_product)) {
			if ($is_ajax) {
				echo json_encode(array('status' => false, 'msg' => '未找到要维权的产品'));
				exit;
			}
			pigcms_tips('未找到要维权的产品');
		}
		
		if ($order_product['rights_status'] == 2) {
			if ($is_ajax) {
				echo json_encode(array('status' => false, 'msg' => '此产品已经维权了'));
				exit;
			}
			pigcms_tips('此产品已经维权了');
		}
		
		// 根据退货数量，判断是否可以退货
		$rights_number = M('Rights_product')->rightsNumber($order['order_id'], $pigcms_id);
		if (IS_POST) {
			$type = $_POST['type'];
			$phone = $_POST['phone'];
			$content = trim($_POST['content']);
			$image_list = $_POST['image_list'];
			$number = max(0, $_POST['number'] + 0);
			
			if (!in_array($type, array(1, 2, 3))) {
				$type = 3;
			}
			
			if (empty($number)) {
				echo json_encode(array('status' => false, 'msg' => '请至少维权一件商品'));
				exit;
			}
			
			if (strlen($content) == 0) {
				echo json_encode(array('status' => false, 'msg' => '请填写维权原因'));
				exit;
			}
			
			if ($order_product['pro_num'] < $rights_number + $number) {
				echo json_encode(array('status' => false, 'msg' => '维权数量超出购买数量'));
				exit;
			}
			
			import('source.class.RightsOrder');
			$data = array();
			$data['pigcms_id'] = $pigcms_id;
			$data['type'] = $type;
			$data['phone'] = $phone;
			$data['content'] = $content;
			$data['images'] = $image_list;
			$data['number'] = $number;
			
			$result = RightsOrder::apply($order, $data);
			
			if ($result) {
				echo json_encode(array('status' => true, 'msg' => '维权申请提交成功，请等待处理', 'data' => array('nexturl' => url('account:rights_detail&id=' . $result))));
				exit;
			} else {
				echo json_encode(array('status' => false, 'msg' => '维权申请失败，请重试'));
				exit;
			}
		}
		
		// 店铺信息
		$store = M('Store')->getStore($order['store_id']);
		
		// 查看满减送
		//$order_ward_list = M('Order_reward')->getByOrderId($order['order_id']);
		// 使用优惠券
		//$order_coupon = M('Order_coupon')->getByOrderId($order['order_id']);
		
		if ($order['payment_method'] == 'peerpay') {
			$order_peerpay_list = D('Order_peerpay')->where(array('order_id' => $order['order_id'], 'status' => 1))->select();
			$this->assign('order_peerpay_list', $order_peerpay_list);
		}
		
		$type_arr = M('Rights')->rightsType();
		
		$this->assign('type_arr', $type_arr);
		$this->assign('pigcms_id', $pigcms_id);
		$this->assign('order', $order);
		$this->assign('store', $store);
		$this->assign('return_number', $return_number);
		//$this->assign('order_package', $order_package);
		//$this->assign('order_ward_list', $order_ward_list);
		//$this->assign('order_coupon', $order_coupon);
		$this->display();
	}
	
	// 图片添加
	public function attachment() {
		if (empty($this->user_session)) {
			echo json_encode(array('status' => false, 'msg' => 'nologin'));
			exit;
		}
		
		if(!empty($_FILES['file']) && $_FILES['file']['error'] != 4){
			$img_path_str = '';
		
			// 用会员uid
			$img_path_str = sprintf("%09d",$this->user_session['uid']);
		
			// 产生目录结构
			$rand_num = 'images/' . substr($img_path_str, 0, 3) . '/' . substr($img_path_str, 3, 3) . '/' . substr($img_path_str, 6, 3) . '/' . date('Ym', $_SERVER['REQUEST_TIME']) . '/';
				
			$upload_dir = './upload/' . $rand_num;
			if(!is_dir($upload_dir)) {
				mkdir($upload_dir, 0777, true);
			}
		
			// 进行上传图片处理
			import('UploadFile');
			$upload = new UploadFile();
			$upload->maxSize = 1 * 1024 * 1024;
			$upload->allowExts = array('jpg', 'jpeg', 'png', 'gif');
			$upload->allowTypes = array('image/png', 'image/jpg', 'image/jpeg', 'image/gif');
			$upload->savePath = $upload_dir;
			$upload->saveRule = 'uniqid';
			if($upload->upload()) {
				$uploadList = $upload->getUploadFileInfo();
				$pigcms_id = $this->_attachmentAdd($uploadList[0]['name'], $rand_num . $uploadList[0]['savename'], $uploadList[0]['size']);
				if(!$pigcms_id){
					unlink($upload_dir . $uploadList[0]['name']);
					
					echo json_encode(array('status' => false, 'msg' => '图片上传失败'));
					exit;
				} else {
					$attachment_upload_type = option('config.attachment_upload_type');
					// 上传到又拍云服务器
					if ($attachment_upload_type == '1') {
						import('source.class.upload.upyunUser');
						upyunUser::upload('./upload/' . $rand_num . $uploadList[0]['savename'], '/' . $rand_num . $uploadList[0]['savename']);
					}
					
					echo json_encode(array('status' => true, 'msg' => '上传成功', 'data' => array('id' => $pigcms_id, 'file' => getAttachmentUrl($rand_num . $uploadList[0]['savename']))));
					exit;
				}
			} else {
				echo json_encode(array('status' => false, 'msg' => '图片上传失败'));
				exit;
			}
		} else {
			echo json_encode(array('status' => false, 'msg' => '未找到要上传文件'));
			exit;
		}
	}
	
	/**
	 * 插入会员素材图片
	 */
	private function _attachmentAdd($name, $file, $size, $from=0, $type=0){
		$data['uid'] = $this->user_session['uid'];
		$data['name'] = $name;
		$data['from'] = $from;
		$data['type'] = $type;
		$data['file'] = $file;
		$data['size'] = $size;
		$data['add_time'] = $_SERVER['REQUEST_TIME'];
		$data['ip'] = get_client_ip(1);
		$data['agent'] = $_SERVER['HTTP_USER_AGENT'];
	
		if($type == 0) {
			list($data['width'], $data['height']) = getimagesize('./upload/' . $file);
		}
	
		if($pigcms_id = M('Attachment_user')->add($data)) {
			return $pigcms_id;
		} else {
			return false;
		}
	}
}