<?php
/**
 * 用户收货地址控制器
 */
class appaddress_controller extends base_controller{
	// 保存收货地址,添加与修改
	public function save() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
	    $uid = $_REQUEST['uid'];
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
			$user_address = M('User_address')->getAdressById(session_id(), $uid, $address_id);
			if (empty($user_address)) {
			
			$results['result']='1';
			$results['msg']='未找到要修改的收货地址';
			exit(json_encode($results));
			}
			$data['address_id'] = $address_id;
			
			D('User_address')->where(array('address_id' => $user_address['address_id']))->data($data)->save();
		} else {
			$data['uid'] = $uid;
			$data['session_id'] = session_id();
			
			$address_id = D('User_address')->data($data)->add();
			$data['address_id'] = $address_id;
		}
		
		$results['data']=$data;

	   exit(json_encode($results));
	
	}
	
	// 收货地址列表
	public function all() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
	    $uid = $_REQUEST['uid'];
		$user_address_list = M('User_address')->select(session_id(), $uid);
		foreach ($user_address_list as &$user_address) {
			$user_address['is_default'] = $user_address['default'];
			unset($user_address['default']);
			unset($user_address['session_id']);
			unset($user_address['uid']);
			unset($user_address['add_time']);
		}
		

		$results['data']=$user_address_list;

	   exit(json_encode($results));
	}
	
	// 收货地址删除
	public function delete() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
	$uid = $_REQUEST['uid'];
		$address_id = $_REQUEST['address_id'];
		if (empty($address_id)) {
			
			$results['result']='1';
			$results['msg']='缺少基本的参数';
			exit(json_encode($results));
		}
		
		$user_address = M('User_address')->getAdressById(session_id(), $uid, $address_id);
		if (empty($user_address)) {
		
			$results['result']='1';
			$results['msg']='未找到要删除的收货地址';
			exit(json_encode($results));
		}
		
		M('User_address')->deleteAddress(array('address_id' => $address_id));
		exit(json_encode($results));
	}
	
	// 设置默认收货地址
	public function set_default() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
	$uid = $_REQUEST['uid'];
		$address_id = $_REQUEST['address_id'];
		if (empty($address_id)) {
			$results['result']='1';
			$results['msg']='缺少基本的参数';
			exit(json_encode($results));
		}
		
		$user_address = M('User_address')->getAddress($address_id);
		if (empty($user_address) || $user_address['uid'] != $uid) {
		
			$results['result']='1';
			$results['msg']='未找到相应的收货地址';
			exit(json_encode($results));
		}
		
		if ($user_address['default'] == 1) {
			exit(json_encode($results));
		}
		
		M('User_address')->canelDefaultAaddress($uid, $address_id);
		exit(json_encode($results));
	}
}
?>