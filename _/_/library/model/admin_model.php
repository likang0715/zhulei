<?php
class admin_model extends base_model{

	// 通过代理商推广码 获取推广管理员admin_id
	public function getAdminByInvite ($agent_code = "") {

		if (empty($agent_code) || !$admin = D("Admin")->where(array("agent_code"=>$agent_code))->find()) {
			return false;
		}

		return $admin;

	}

	// 通过省市区 代码获取参与管理的区域管理员列表
	public function getAreaAdminByCode ($province = "", $city = "", $county = "") {

		$where = array();
		if (!empty($province)) {
			$where[] = "(province = " . $province . " AND type = 2 AND area_level = 1)";
		}

		if (!empty($city)) {
			$where[] = "(city = " . $city . " AND type = 2 AND area_level = 2)";
		}

		if (!empty($county)) {
			$where[] = "(county = " . $county . " AND type = 2 AND area_level = 3)";
		}

		$where = implode(' OR ', $where);
		$admin_list = D('Admin')->where($where)->select();

		return $admin_list;
	}
}