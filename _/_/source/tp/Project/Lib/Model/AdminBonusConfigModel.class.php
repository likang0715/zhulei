<?php
/**
 * @description:  区域管理员/代理商分润设置
 * User: pigcms_089
 * Date: 2016/2/15
 * Time: 17:02
 */

class AdminBonusConfigModel extends Model {

	/**
	 * 获取相关分润设置 'area'为区域管理员 'agent'为代理商, 未设置返回配置项为0 , area_level取地域等级 1省 2市 3区县
	 * @param    string $type 管理员 'area/agent' 类别，不传参则返回所有分润设置
	 * @param    int $area_level 区域管理员等级
	 * @return   array
	 * @Auther   pigcms_89
	 * @DateTime 2016-02-26T15:21:25+0800
	 */
	public function getConfig ($type, $area_level = 1) {

		$config_init = array(
			'self_online' => 0.00,
			'self_offline' => 0.00,
			'platform_online' => 0.00,
			'platform_offline' => 0.00,
			'foreign_online' => 0.00,
			'foreign_offline' => 0.00,
		);

		switch ($type) {
			case 'area':
				if (!in_array($area_level, array(1,2,3))) {
					return $config_init;
				}

				$admin_bouns_config = D("AdminBonusConfig")->where(array('type'=>2, 'area_level'=>$area_level, 'status'=>1))->find();
				if (!empty($admin_bouns_config)) {
					$config_init['self_online'] = $admin_bouns_config['self_online'];
					$config_init['self_offline'] = $admin_bouns_config['self_offline'];
					$config_init['platform_online'] = $admin_bouns_config['platform_online'];
					$config_init['platform_offline'] = $admin_bouns_config['platform_offline'];
					$config_init['foreign_online'] = $admin_bouns_config['foreign_online'];
					$config_init['foreign_offline'] = $admin_bouns_config['foreign_offline'];
				}

				return $config_init;
				break;

			case 'agent':

				$admin_bouns_config = D("AdminBonusConfig")->where(array('type'=>3, 'status'=>1))->find();
				if (!empty($admin_bouns_config)) {
					$config_init['self_online'] = $admin_bouns_config['self_online'];
					$config_init['self_offline'] = $admin_bouns_config['self_offline'];
					$config_init['platform_online'] = $admin_bouns_config['platform_online'];
					$config_init['platform_offline'] = $admin_bouns_config['platform_offline'];
					$config_init['foreign_online'] = $admin_bouns_config['foreign_online'];
					$config_init['foreign_offline'] = $admin_bouns_config['foreign_offline'];
				}

				return $config_init;
				break;

			default:	//获取全部

				$config_all = array(
						'agent'=>$config_init,
						'area1'=>$config_init,
						'area2'=>$config_init,
						'area3'=>$config_init,
					);

				$admin_bouns_config = D("AdminBonusConfig")->where(array('status'=>1))->select();

				foreach ($admin_bouns_config as $val) {
					if ($val['type'] == 2) {
						$config_all['area'.$val['area_level']] = array(
								'self_online' => (float)$val['self_online'],
								'self_offline' => (float)$val['self_offline'],
								'platform_online' => (float)$val['platform_online'],
								'platform_offline' => (float)$val['platform_offline'],
								'foreign_online' => (float)$val['foreign_online'],
								'foreign_offline' => (float)$val['foreign_offline'],
							);

					} else if ($val['type'] == 3) {
						$config_all['agent'] = array(
								'self_online' => (float)$val['self_online'],
								'self_offline' => (float)$val['self_offline'],
								'platform_online' => (float)$val['platform_online'],
								'platform_offline' => (float)$val['platform_offline'],
								'foreign_online' => (float)$val['foreign_online'],
								'foreign_offline' => (float)$val['foreign_offline'],
							);

					}
				}

				return $config_all;
				break;
		}


	}

	/**
	 * 获取该店铺关联的参与利润分配 区域管理员/代理商列表
	 * @param    int $store_id 店铺id
	 * @return   array
	 * @Auther   pigcms_89
	 * @DateTime 2016-02-26T15:24:00+0800
	 */
	public function getProfitAdmins ($store_id = 0) {
		
		if (empty($store_id)) {
			return array();
		}

		$store = D("Store")->where(array('store_id'=>$store_id))->find();
		if (empty($store)) {
			return array();
		}

		$user = D("User")->where(array('uid'=>$store['uid']))->find();
		if (empty($user)) {
			return array();
		}

		$where = array();
		$profit_admins = array();
		$database_admin = D("Admin");

		// 代理商
		if ($user['invite_admin'] != 0 && $agent_admin = $database_admin->where(array('id'=>$user['invite_admin']))->find()) {
			$profit_admins[] = $agent_admin;
		}


		// 区域管理
		$store_area_record = D("StoreAreaRecord")->where(array('store_id'=>$store_id, 'status'=>1))->find();
		if (!empty($store_area_record)) {
			$where['_string'] = "(province = ".$store_area_record['province']." AND type = 2 AND area_level = 1) OR (city = ".$store_area_record['city']." AND type = 2 AND area_level = 2) OR (county = ".$store_area_record['county']." AND type = 2 AND area_level = 3)";
			$area_admin = $database_admin->field(true)->where($where)->select();
			if (!empty($area_admin)) {
				$profit_admins = array_merge($profit_admins, $area_admin);
			}
		}

		return $profit_admins;

	}

	/**
	 * 获取该店铺关联接收通知消息的代理商/最近一级区域管理
	 * @param    int $store_id 店铺id
	 * @return   array
	 * @Auther   pigcms_89
	 * @DateTime 2016-04-07T13:41:00+0800
	 */
	public function getNoticeAdmin ($store_id = 0) {

		if (empty($store_id)) {
			return array();
		}

		$store = D("Store")->where(array('store_id'=>$store_id))->find();
		if (empty($store)) {
			return array();
		}

		$user = D("User")->where(array('uid'=>$store['uid']))->find();
		if (empty($user)) {
			return array();
		}

		$where = array();
		$notice_admin = array();
		$database_admin = D("Admin");

		// 代理商
		if ($user['invite_admin'] != 0 && $agent_admin = $database_admin->where(array('id'=>$user['invite_admin']))->find()) {
			$notice_admin[] = $agent_admin;
		}

		// 区域管理
		$store_area_record = D("StoreAreaRecord")->where(array('store_id'=>$store_id, 'status'=>1))->find();
		if (!empty($store_area_record)) {

			$where['_string'] = "(province = ".$store_area_record['province']." AND type = 2 AND area_level = 1) OR (city = ".$store_area_record['city']." AND type = 2 AND area_level = 2) OR (county = ".$store_area_record['county']." AND type = 2 AND area_level = 3)";
			$area_admin = $database_admin->field(true)->where($where)->order("area_level DESC")->limit(1)->select();
			
			if (!empty($area_admin)) {
				$notice_admin = array_merge($notice_admin, $area_admin);
			}
		}

		return $notice_admin;
	}

} 