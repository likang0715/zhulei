<?php
/**
 * 找人代付
 */
class peerpay_controller extends base_controller {
	//加载
	public function load() {
		$action = strtolower(trim($_POST['page']));
		if (empty($action)) pigcms_tips('非法访问！', 'none');
		
		switch ($action) {
			case 'content_list':
				$this->_content_list();
				break;
			case 'setting':
				$this->_setting();
				break;
			default:
				break;
		}
		
		$this->display($_POST['page']);
	}
	
	public function peerpay_index() {
		$store = D("Store")->where(array('store_id' => $this->store_session['store_id']))->find();
		
		$this->assign('store', $store);
		$this->display();
	}
	
	
	public function pay_agent() {
		$status = intval(trim($_POST['status']));
		$store_id = $this->store_session['store_id'];
	
		$result = D('Store')->where(array('store_id' => $store_id))->data(array('pay_agent' => $status))->save();
		if ($result) {
			json_return(0, '保存成功！');
		} else {
			json_return(4099, '保存失败，请重试！');
		}
	}

	// 删除
	public function delete() {
		$id = $_GET['id'] + 0;
		
		if (empty($id)) {
			json_return(1001, '缺少最基本的参数ID');
		}
		
		$peerpay_fetchtxt = D('Store_pay_agent')->where(array('agent_id' => $id, 'store_id' => $_SESSION['store']['store_id']))->find();
		if (empty($peerpay_fetchtxt)) {
			json_return(1001, '未找到相应的信息');
		}
		
		D('Store_pay_agent')->where(array('agent_id' => $id))->delete();
		json_return(0, '删除完成');
	}
	
	public function content() {
		$id = $_POST['id'];
		$type = $_POST['type'] + 0;
		$nickname = $_POST['nickname'];
		$content = $_POST['content'];
		
		if (!in_array($type, array(0, 1))) {
			$type = 0;
		}
		
		if (empty($content)) {
			json_return(1001, '请输入 发起人求助内容');
		}
		
		if (mb_strlen($content, 'utf-8') > 200) {
			json_return(1001, '内容最多只能写200个字');
		}
		
		if (!empty($id)) {
			$peerypay_fetchtxt = D('Store_pay_agent')->where(array('agent_id' => $id, 'store_id' => $_SESSION['store']['store_id']))->find();
			if (empty($peerypay_fetchtxt)) {
				json_return(1001, '未找到要修改的信息');
			}
			
			$result = D('Store_pay_agent')->where(array('agent_id' => $id, 'store_id' => $_SESSION['store']['store_id']))->data(array('content' => $content, 'nickname' => $nickname))->save();
			if ($result) {
				json_return(0, '修改成功');
			} else {
				json_return(1001, '修改失败');
			}
		}
		
		$count = D('Store_pay_agent')->where(array('store_id' => $_SESSION['store']['store_id'], 'type' => $type))->count('id');
		if ($count >= 10) {
			json_return(1001, '最多只能添加10条');
		}
		
		$data = array();
		//$data['dateline'] = time();
		$data['store_id'] = $_SESSION['store']['store_id'];
		$data['type'] = $type;
		$data['nickname'] = $nickname;
		$data['content'] = $content;
		
		$result = D('Store_pay_agent')->data($data)->add();
		if ($result) {
			json_return(0, '添加成功', $result);
		} else {
			json_return(1001, '添加失败');
		}
	}
	
	public function setting_save() {
		$img = $_POST['img'];
		$color = $_POST['color'];
		
		$peerpay_custom = D('Custom_field')->where(array('store_id' => $_SESSION['store']['store_id'], 'module_name' => 'peerpay'))->find();
		
		if (empty($peerpay_custom)) {
			$data = array();
			$data['store_id'] = $_SESSION['store']['store_id'];
			$data['module_name'] = 'peerpay';
			$data['module_id'] = 0;
			$data['field_type'] = 'peerpay';
			$data['content'] = serialize(array('color' => $color, 'img' => getAttachment($img)));
			
			$result = D('Custom_field')->data($data)->add();
		} else {
			$data = array();
			$data['content'] = serialize(array('color' => $color, 'img' => getAttachment($img)));
			
			$result = D('Custom_field')->where(array('field_id' => $peerpay_custom['field_id']))->data($data)->save();
		}
		
		json_return(0, '操作完成');
	}
	
	private function _content_list() {
		$type = $_POST['type'] + 0;
		if (!in_array($type, array(0, 1))) {
			$type = 0;
		}
		
		$store_pay_agent_list = D('Store_pay_agent')->where(array('store_id' => $_SESSION['store']['store_id'], 'type' => $type))->order('agent_id desc')->select();
		
		$this->assign('store_pay_agent_list', $store_pay_agent_list);
	}
	
	private function _setting() {
		$peerpay_custom = D('Custom_field')->where(array('store_id' => $_SESSION['store']['store_id'], 'module_name' => 'peerpay'))->find();
		
		if (empty($peerpay_custom)) {
			$peerpay_custom['txt_color'] = '#FFFFFF';
			$peerpay_custom['img'] = '';
		} else {
			$tmp = unserialize($peerpay_custom['content']);
			$peerpay_custom['txt_color'] = $tmp['color'];
			$peerpay_custom['img'] = getAttachmentUrl($tmp['img']);
		}
		
		$peerpay_custom['color'] = '#a0bf54';
		$this->assign('peerpay_custom', $peerpay_custom);
	}
	
	
}