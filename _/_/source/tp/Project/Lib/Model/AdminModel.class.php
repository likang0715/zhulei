<?php
/**
 * @description:  总后台管理员
 * User: pigcms_089
 * Date: 2016/1/26
 * Time: 16:07
 */

class AdminModel extends Model {

	/**
	 * 普通管理员/区域管理员/代理商列表
	 * @param    array $where 管理员搜索条件
	 * @return   array
	 * @Auther   pigcms_89
	 * @DateTime 2016-02-26T15:04:38+0800
	 */
	public function getList ($where = array()) {

		$count_admin = $this->where($where)->count();
		import('@.ORG.system_page');
		$p = new Page($count_admin, 15);
		$admin_list = $this->field(true)->where($where)->order('`id` DESC')->limit($p->firstRow . ',' . $p->listRows)->select();

		$admin_group = D("AdminGroup")->adminGroupArr();

		if (!empty($admin_list)) {
			import('ORG.Net.IpLocation');
			import('area', './source/class');
			$areaClass = new area();
			$IpLocation = new IpLocation();
			foreach ($admin_list as &$value) {
				$last_location = $IpLocation->getlocation(long2ip($value['last_ip']));
				$value['last_ip_txt'] = iconv('GBK', 'UTF-8', $last_location['country']) . iconv('GBK', 'UTF-8', $last_location['area']);

				if (isset($where['type']) && $where['type'] == 2) {		//区域管理员

					$value['province_txt'] = $areaClass->get_name($value['province']);
					$value['city_txt'] 	= $areaClass->get_name($value['city']);
					$value['county_txt'] 	= $areaClass->get_name($value['county']);

				}

				$count = 0;
				if ($value['type'] == 3) {
					$count = D("User")->where(array('invite_admin'=>$value['id']))->count("uid");
					// 关联的区域管理

					if (!empty($value['area_admin']) && $find_admin = $this->where(array('id'=>$value['area_admin'], 'type'=>2))->find()) {

						$value['area_admin_name'] = $find_admin['account'];
						$tmp_area = array();

						!empty($find_admin['province']) ? $tmp_area[] = $areaClass->get_name($find_admin['province']) : true;
						!empty($find_admin['city']) ? $tmp_area[] = $areaClass->get_name($find_admin['city']) : true;
						!empty($find_admin['county']) ? $tmp_area[] = $areaClass->get_name($find_admin['county']) : true;

						$value['area_admin_address'] = implode('-', $tmp_area);
					} else {
						$value['area_admin_name'] = '';
						$value['area_admin_address'] = '';
					}
				}

				$value['user_count'] = $count;
				$value['group_name'] = $admin_group[$value['group_id']]['name'];
				$value['group_status'] = $admin_group[$value['group_id']]['status'];
				$value['store_count'] = $this->manageStoreCount($value);

			}
		}

		return array('list'=>$admin_list, 'page'=>$p);

	}

	/**
	 * 区域管理员获取 区域内店铺store_id 数组 修改关联 [admin_area_record]
	 * @param    array $admin 当前登录admin信息数组 $this->admin_user
	 * @return   array
	 * @Auther   pigcms_89
	 * @DateTime 2016-02-26T15:05:38+0800
	 */
	public function getAreaStoreIds ($admin = array()) {

		$store_ids = array();

		switch ($admin['area_level']) {
			case 1:
				$condition_admin_contact = array(
						'province' => $admin['province'],
					);
				break;
			
			case 2:
				$condition_admin_contact = array(
						'city' => $admin['city'],
					);
				break;

			case 3:
				$condition_admin_contact = array(
						'county' => $admin['county'],
					);
				break;

			default:
				return array();
				break;
		}

		// $admin_contact_list = D('StoreContact')->where($condition_admin_contact)->select();
		// foreach ($admin_contact_list as $val) {
		// 	$store_ids[] = $val['store_id'];
		// }

		$condition_admin_contact['status'] = 1;
		$admin_area_record = D('StoreAreaRecord')->where($condition_admin_contact)->select();
		foreach ($admin_area_record as $val) {
			$store_ids[] = $val['store_id'];
		}

		return $store_ids;
	}

	/**
	 * 获取代理商可查看店铺id数组
	 * @param    array $admin 当前登录admin信息数组 $this->admin_user
	 * @return   array
	 * @Auther   pigcms_89
	 * @DateTime 2016-02-26T15:06:46+0800
	 */
	public function getAgentStoreIds ($admin = array()) {

		$uids = $this->getAgentUids($admin);
		if (empty($uids)) {
			return array();
		}

		$in_str = implode(",", $uids);
		$where = array('u.uid'=>array('in', $uids));

		$db_prefix = C('DB_PREFIX');
		$this->table($db_prefix . 'user as u');
		$this->join($db_prefix . 'store as s on u.uid = s.uid', 'left');
		$this->where($where);
		$this->field('s.store_id');
		$store_ids = $this->select();

		if (empty($store_ids)) {
			return array();
		}

		$result_store = array();
		foreach ($store_ids as $val) {
			if (empty($val['store_id'])) {
				continue;
			}

			$result_store[] = $val['store_id'];
		}

		return $result_store;

	}

	/**
	 * 获取代理商关联用户id数组
	 * @param    array $admin 当前登录admin信息数组 $this->admin_user
	 * @return   array
	 * @Auther   pigcms_89
	 * @DateTime 2016-02-26T15:07:15+0800
	 */
	public function getAgentUids ($admin = array()) {

		$user_ids = array();
		$user_list = D('User')->where(array('invite_admin'=>$admin['id']))->select();
		foreach ($user_list as $val) {
			$user_ids[] = $val['uid'];
		}

		return $user_ids;

	}

	/**
	 * 区域管理员获取下属区域管理员admin_ids 数组 修改关联 
	 * @param    array $admin 当前登录admin信息数组 $this->admin_user
	 * @return   array
	 * @Auther   pigcms_89
	 * @DateTime 2016-04-25T15:05:38+0800
	 */
	public function getAreaAdminIds ($admin = array()) {

		$admin_ids = array();

		switch ($admin['area_level']) {
			case 1:
				$condition_admin['province'] = $admin['province'];
				$condition_admin['area_level'] = array('gt', 1);
				break;
			
			case 2:
				$condition_admin['province'] = $admin['province'];
				$condition_admin['city'] = $admin['city'];
				$condition_admin['area_level'] = array('gt', 2);
				break;

			default:
				return array();
				break;
		}

		// $condition_admin['status'] = 1;
		$admin_list = D('Admin')->where($condition_admin)->select();
		foreach ($admin_list as $val) {
			$admin_ids[] = $val['id'];
		}

		return $admin_ids;
	}

	/**
	 * 区域管理员获取关联代理商admin_ids数组
	 * @param    array $admin 当前登录admin信息数组 $this->admin_user
	 * @return   array
	 * @Auther   pigcms_89
	 * @DateTime 2016-04-25T15:05:38+0800
	 */
	public function getAgentAdminIds ($admin = array()) {

		if ($admin['type'] != 2) {
			return array();
		}

		$admin_ids = array();
		$admin_list = D('Admin')->where(array('area_admin'=>$admin['id'], 'type'=>3))->select();
		foreach ($admin_list as $val) {
			$admin_ids[] = $val['id'];
		}

		return $admin_ids;

	}

	/**
	 * 获取代理商邀请码
	 * @param    array $now_admin 当前登录admin信息数组 $this->admin_user
	 * @return   array
	 * @Auther   pigcms_89
	 * @DateTime 2016-02-26T15:07:49+0800
	 */
	public function getAgentCode ($now_admin = array()) {

		if (!$admin = D('Admin')->where(array('id'=>$now_admin['id'], 'type'=>3))->find()) {
			return false;
		}

		if (!empty($admin['agent_code'])) {
			return $admin['agent_code'];
		}

		$agent_code = $this->getRandomString(6);
		if (D('Admin')->where(array('id'=>$now_admin['id'], 'type'=>3))->data(array('agent_code'=>$agent_code))->save()) {
			return $agent_code;
		}

		return false;
	}

	/**
	 * 获取自定义长度随机字符串
	 * @param    int $len 随机字符串长度
	 * @param    string $chars 允许自定义随机字符串
	 * @return   string 
	 * @Auther   pigcms_89
	 * @DateTime 2016-02-26T15:08:30+0800
	 */
	public function getRandomString ($len, $chars = null) {

		if (is_null($chars)) {
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789";
		}

		mt_srand(10000000*(double)microtime());
		for ($i = 0, $str = '', $lc = strlen($chars)-1; $i < $len; $i++) {
			$str .= $chars[mt_rand(0, $lc)];
		}

	    return $str;
	}

	/**
	 * 记录 代理商关联用户修改
	 * @param    int $uid 关联用户
	 * @param    int $admin_id 代理商admin_id
	 * @param    int $creator 操作者admin_id
	 * @return   bool 
	 * @Auther   pigcms_89
	 * @DateTime 2016-02-26T15:10:03+0800
	 */
	public function saveAgentUserRecord ($uid = 0, $admin_id = 0, $creator = 0) {

		if (empty($uid) || empty($admin_id)) {
			return false;
		}

		$data = array(
				'uid' => $uid,
				'admin_id' => $admin_id,
				'creator' => $creator,
				'add_time' => time(),
			);
		$result = D("AgentInvite")->data($data)->add();
		if ($result) {
			return true;
		}

		return false;

	}

	/**
	 * 获取管理员关联店铺数量 代理商/区域管理
	 * @param    array $now_admin 当前登录admin信息数组 $this->admin_user
	 * @return   int 
	 * @Auther   pigcms_89
	 * @DateTime 2016-02-26T15:13:04+0800
	 */
	public function manageStoreCount ($now_admin = array()) {

		$count = 0;

		if ($now_admin['type'] == 2) {
			if ($now_admin['area_level'] == 1) {
				$where = array('province'=> $now_admin['province']);
			} else if ($now_admin['area_level'] == 2) {
				$where = array('province'=> $now_admin['province'], 'city'=>$now_admin['city']);
			} else if ($now_admin['area_level'] == 3) {
				$where = array('province'=> $now_admin['province'], 'city'=>$now_admin['city'], 'county'=>$now_admin['county']);
			}

			$count = D("StoreAreaRecord")->where($where)->count('pigcms_id');

		} else if ($now_admin['type'] == 3) {
			$count = D("User")->where(array('invite_admin'=>$now_admin['id']))->count('uid');

		}

		return $count;

	}

	/**
	 * 获取发送奖金方式
	 * @return   array
	 * @Auther   pigcms_89
	 * @DateTime 2016-02-26T15:14:08+0800
	 */
	public function getPromotionType () {
		return array(
			'0'=>array(
				'type'=>0,
				'name'=>'其他支付',
			),
			'1'=>array(
				'type'=>1,
				'name'=>'银行转账',
			),
			'2'=>array(
				'type'=>2,
				'name'=>'微信',
			),
			'3'=>array(
				'type'=>3,
				'name'=>'支付宝',
			),
		);
	}

} 