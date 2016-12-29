<?php
/**
 * 用户收货地址控制器
 */
class address_controller extends base_controller{
	// 保存收货地址,添加与修改
	public function save() {
		$address_id = $_REQUEST['address_id'];
		$name = $_REQUEST['name'];
		$tel = $_REQUEST['tel'];
		$province = $_REQUEST['province'];
		$city = $_REQUEST['city'];
		$area = $_REQUEST['area'];
		$address = $_REQUEST['address'];
		$zipcode = $_REQUEST['zipcode'];
		
		$data = array();
		$data['name'] = $name;
		$data['tel'] = $tel;
		$data['province'] = $province;
		$data['city'] = $city;
		$data['area'] = $area;
		$data['address'] = $address;
		$data['zipcode'] = $zipcode;
		$data['add_time'] = time();
		
		if (!empty($address_id)) {
			$user_address = M('User_address')->getAdressById(session_id(), $this->user['uid'], $address_id);
			if (empty($user_address)) {
				json_return(1000, '未找到要修改的收货地址');
			}
			$data['address_id'] = $address_id;
			
			D('User_address')->where(array('address_id' => $user_address['address_id']))->data($data)->save();
		} else {
			$data['uid'] = $this->user['uid'];
			$data['session_id'] = session_id();
			
			$address_id = D('User_address')->data($data)->add();
			$data['address_id'] = $address_id;
		}
		
		json_return(0, $data);
	}
	
	// 收货地址列表
	public function all() {
		$user_address_list = M('User_address')->select(session_id(), $this->user['uid']);
		foreach ($user_address_list as &$user_address) {
			$user_address['is_default'] = $user_address['default'];
			unset($user_address['default']);
		}
		
		json_return(0, $user_address_list);
	}
	
	// 收货地址删除
	public function delete() {
		$address_id = $_REQUEST['address_id'];
		if (empty($address_id)) {
			json_return(1000, '缺少基本的参数');
		}
		
		$user_address = M('User_address')->getAdressById(session_id(), $this->user['uid'], $address_id);
		if (empty($user_address)) {
			json_return(1000, '未找到要删除的收货地址');
		}
		
		M('User_address')->deleteAddress(array('address_id' => $address_id));
		json_return(0, '删除完成');
	}
	
	// 设置默认收货地址
	public function set_default() {
		$address_id = $_REQUEST['address_id'];
		if (empty($address_id)) {
			json_return(1000, '缺少最基本的参数');
		}
		
		$user_address = M('User_address')->getAddress($address_id);
		if (empty($user_address) || $user_address['uid'] != $this->user['uid']) {
			json_return(1000, '未找到相应的收货地址');
		}
		
		if ($user_address['default'] == 1) {
			json_return(0, '操作成功');
		}
		
		M('User_address')->canelDefaultAaddress($this->user['uid'], $address_id);
		json_return(0, '操作成功');
	}
}
?>