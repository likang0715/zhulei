<?php
/**
 * @description:  总后台权限组
 * User: pigcms_089
 * Date: 2016/1/23
 * Time: 17:02
 */

class AdminGroupModel extends Model {

	/**
	 * 判断路由访问是否有权限/同时获取当前登录者信息
	 * @param    int $uid 当前登陆者admin_id
	 * @param    string $module 
	 * @param    string $action 
	 * @return   array
	 * @Auther   pigcms_89
	 * @DateTime 2016-02-26T15:15:09+0800
	 */
	public function allowAccess ($uid = 0, $module = '', $action = '') {

		$database_admin = D('Admin');
		$database_admin_rbac = D('Admin_rbac');
		$database_admin_group = D('Admin_group');
		$database_system_menu = D('System_menu');
		$database_system_rbac_menu = D('System_rbac_menu');

		if (empty($uid) || !$admin = $database_admin->field(true)->where(array('id'=>$uid))->find()) {
			$isAllow = false;
			return array('isAllow'=>$isAllow, 'admin_user'=>array());
		}

		
		if ($admin['status'] == 0 && $admin['type'] != 0) {
			$isAllow = false;
			return array('isAllow'=>$isAllow, 'admin_user'=>$admin);
		}

		// 管理地域
		if ($admin['type'] == 2) {
			import('area', './source/class');
			$areaClass = new area();
			$admin['province_txt'] = $areaClass->get_name($admin['province']);
			$admin['city_txt'] = $areaClass->get_name($admin['city']);
			$admin['county_txt'] = $areaClass->get_name($admin['county']);
		}

		if ($admin['type'] == 2 || $admin['type'] == 3) {
			$admin['un_reward'] = number_format($admin['reward_total'] - $admin['reward_balance'], 2);
			$admin['reward_total'] = number_format($admin['reward_total'], 2);
			$admin['reward_balance'] = number_format($admin['reward_balance'], 2);
		}

		$adminType = $this->getAdminType(1);
		$admin['type_name'] = $adminType[$admin['type']]['name'];

		switch ($admin['type']) {

			case 0:					// 超级管理员
				$isAllow = true;
				return array('isAllow'=>$isAllow, 'admin_user'=>$admin);
				break;

			case 1:		// 一般管理员
			case 2:		// 区域管理员
			case 3:		// 代理商
				// 获取所属组
				$admin_group = $database_admin_group->where(array('id'=>$admin['group_id']))->find();
				if (empty($admin_group) || $admin_group['status'] == 0) {
					$isAllow = false;
					return array('isAllow'=>$isAllow, 'admin_user'=>$admin);
				}

				// 获取该团是否有此权限
				// 纳入判断
				if ($system_menu = $database_system_rbac_menu->where(array('module'=>$module, 'action'=>$action))->find()) {

					if ($system_menu['status'] == 0) {
						$isAllow = false;
						return array('isAllow'=>$isAllow, 'admin_user'=>$admin);
					}

					if (!$admin_rbac = $database_admin_rbac->where(array('group_id'=>$admin['group_id'], 'module'=>$module, 'action'=>$action))->find()) {
						$isAllow = false;
						return array('isAllow'=>$isAllow, 'admin_user'=>$admin);
					}

				}

				$isAllow = true;
				return array('isAllow'=>$isAllow, 'admin_user'=>$admin);
				break;
			
			default:
				$isAllow = false;
				return array('isAllow'=>$isAllow, 'admin_user'=>array());
				break;
		}

	}

	/**
	 * [allowShow 对于用户uid是否显示该页面 module/action]
	 * @param    int $uid [用户uid]
	 * @param    string $module 
	 * @param    string $action 
	 * @return   bool
	 * @Auther   pigcms_89
	 * @DateTime 2016-03-28T17:51:08+0800
	 */
	public function allowShow ($uid = 0, $module = '', $action = '') {

		$admin_user = D('Admin')->field(true)->where(array("id"=>$uid))->find();

		$database_system_menu = D('System_menu');
		$database_admin_group = D('Admin_group');


		$admin_group = $database_admin_group->where(array('id'=>$admin_user['group_id']))->find();

		switch ($admin_user['type']) {
			case 0:
				return true;
				break;
			
			case 1:		// 一般管理员
			case 2:		// 区域管理员
			case 3:		// 代理商

				$all_filter = !empty($admin_group['menu_ids']) ? explode(",", $admin_group['menu_ids']) : array();
				$find_system_menu = $database_system_menu->where(array('module'=>$module, 'action'=>$action))->find();
				if (empty($find_system_menu)) {
					return false;
				}

				if (in_array($find_system_menu['id'], $all_filter)) {
					return true;
				} else {
					return false;
				}

				break;

			default:
				return false;
				break;
		}


	}

	/**
	 * 获取可用的 system_menu
	 * @param    int $uid admin_id
	 * @return   array
	 * @Auther   pigcms_89
	 * @DateTime 2016-02-26T15:16:49+0800
	 */
	public function getSystemMenu ($uid = 0) {
		
		$admin_user = D('Admin')->field(true)->where(array("id"=>$uid))->find();

		$system_menu = array();
		$database_system_menu = D('System_menu');
		$database_admin_group = D('Admin_group');
		$database_admin_rbac = D('Admin_rbac');

		switch ($admin_user['type']) {

			case 0:			// 超级管理员
				$condition_system_menu['status'] = 1;
				$condition_system_menu['show'] = 1;
				$menu_list = $database_system_menu->field(true)->where($condition_system_menu)->order('`sort` DESC,`fid` ASC,`id` ASC')->select();

				foreach ($menu_list as $key => $value) {
					if ($value['fid'] == 0) {
						$system_menu[$value['id']] = $value;
					} else {
						$system_menu[$value['fid']]['menu_list'][] = $value;
					}
				}

				break;

			case 1:		// 一般管理员
			case 2:		// 区域管理员
			case 3:		// 代理商
				
				$all_filter = array();
				$system_menu = array();
				
				$admin_group = $database_admin_group->where(array('id'=>$admin_user['group_id']))->find();
				$all_filter = !empty($admin_group['menu_ids']) ? explode(",", $admin_group['menu_ids']) : array();

				if (empty($all_filter)) {
					return $system_menu;
				}

				// 过滤system_menu
				$condition_system_menu['status'] = 1;
				$condition_system_menu['show'] = 1;
				$condition_system_menu['is_admin'] = 0;
				$menu_list = $database_system_menu->field(true)->where($condition_system_menu)->order('`sort` DESC,`fid` ASC,`id` ASC')->select();

				foreach ($menu_list as $key => $value) {

					if (!in_array($value['id'], $all_filter)) {
						continue;
					}

					if ($value['fid'] == 0) {
						$system_menu[$value['id']] = $value;
					} else {
						$system_menu[$value['fid']]['menu_list'][] = $value;
					}

				}

				break;

			default:
				$system_menu = array();
				break;

		}

		return $system_menu;

	}

	/**
	 * 重设 system_menu module/action 格式重置 [保证格式规整]
	 * [use] D('AdminGroup')->systemMenuReset();
	 *
	 * @Auther   pigcms_89
	 * @DateTime 2016-02-26T15:18:02+0800
	 */
	public function systemMenuReset () {

		$database_system_menu = D('System_menu');
		$database_admin_rbac = D('Admin_rbac');

		$system_menu_list = $database_system_menu->where(array('fid'=>array('neq', 0)))->select();
		foreach ($system_menu_list as $val) {
			$module = ucfirst($val['module']);
			// $action = strtolower($val['action']);
			$action = lcfirst($val['action']);
			$data = array(
				'module' =>$module,
				'action' =>$action,
			);
			$database_system_menu->where(array('id'=>$val['id']))->data($data)->save();
		}

		// rbac权限表 module/action 格式重置
		$admin_rbac_list = $database_admin_rbac->select();
		foreach ($admin_rbac_list as $val) {

			if (empty($val['module']) || empty($val['action'])) {
				continue;
			}

			$module = ucfirst($val['module']);
			$action = strtolower($val['action']);
			$data = array(
				'module' =>$module,
				'action' =>$action,
			);
			$database_admin_rbac->where(array('id'=>$val['id']))->data($data)->save();
		}

	}

	/**
	 * 初始化后台rbac访问权限表记录 类似system_menu
	 *
	 * @Auther   pigcms_89
	 * @DateTime 2016-02-26T15:18:47+0800
	 */
	public function systemRbacMenuReset () {

		$admin_module_action = array(
			'Ng_word' => array(
					'name' => '后台敏感词基础类',
					'child' => array('index' => '列表', 'add' => '添加', 'delete' => '删除', 'edit' => '修改', )
				),
			'Adver' => array(
					'name' => '广告管理',
					'child' => array('index' => '分类列表', 'cat_modify' => '分类添加', 'cat_amend' => '分类编辑', 'cat_del' => '分类删除', 'adver_list' => '广告列表', 'adver_modify' => '广告添加', 'adver_amend' => '广告编辑', 'adver_del' => '广告删除', )
				),
			'Bank' => array(
					'name' => '收款银行',
					'child' => array('index' => '列表', 'modify' => '添加', 'amend' => '修改', 'del' => '删除', )
				),
			'Config' => array(
					'name' => '站点配置',
					'child' => array('index' => '站点配置', 'amend' => '站点修改', 'show' => '微信API接口填写信息', 'sendmsg' => '测试短信接口', )
				),
			'Credit' => array(
					'name' => '总后台积分配置',
					'child' => array('index' => '配置表单', 'chgStatus' => '修改配置记录状态', 'chgTodayCreditWeight' => '修改积分权数', 'rules' => '积分规则', 'upRules' => '修改规则', 'depositRecord' => '保证金记录', 'record' => '积分记录', 'myDepositRecord' => '下属店铺充值流水', )
				),
			'Diymenu' => array(
					'name' => '微信自定义菜单',
					'child' => array('index' => '列表', 'class_add' => '添加', 'class_edit' => '修改', 'class_del' => '删除', 'class_send' => '发送到微信设置', )
				),
			'Express' => array(
					'name' => '快递公司',
					'child' => array('index' => '列表', 'modify' => '添加', 'amend' => '修改', 'del' => '删除', )
				),
			'Flink' => array(
					'name' => '友情链接',
					'child' => array('index' => '列表', 'modify' => '添加', 'amend' => '修改', 'del' => '删除', )
				),
			'Home' => array(
					'name' => '微信首页回复',
					'child' => array('index' => '首页回复表单', 'first' => '首次关注回复', 'other' => '关键词回复', 'other_add' => '关键词添加', 'other_edit' => '关键词修改', 'other_del' => '关键词删除', )
				),
			'Index' => array(
					'name' => '总后台首页',
					'child' => array('main' => '后台首页', 'amend_pass' => '修改密码', 'amend_profile' => '修改个人资料', 'cache' => '清除缓存', 'offical_tore' => '创建官方店铺', )
				),
			'Order' => array(
					'name' => '订单',
					'child' => array('dashboard' => '账务概况', 'paymentRecord' => '平台收款记录', 'incomeRecord' => '平台收益', 'index' => '所有订单(不含临时订单)', 'selffetch' => '到店自提订单(不含临时订单)', 'codpay' => '货到付款订单(不含临时订单)', 'payagent' => '代付的订单(不含临时订单)', 'refund_peerpay' => '退款', 'withdraw' => '提现记录', 'withdraw_status' => '获取提现状态', 'smspay' => '短信订单列表', 'detail' => '订单详情', 'check' => '对账列表', 'checklog' => '对账日志', 'alert_check' => '详细对账抽成比例', 'check_status' => '修改出账状态', 'return_order' => '退货列表', 'return_detail' => '退货详情', 'rights' => '维权列表', 'rights_detail' => '维权详情', 'rights_status' => '修改维权状态', 'promotionRecord' => '奖金流水记录', 'myPromotionRecord' => '我的奖金', 'subPromotionRecord' => '查看下属奖金流水', )
				),
			'Product_property' => array(
					'name' => '商品属性',
					'child' => array('property' => '商品属性列表', 'property_status' => '修改商品属性分类的状态', 'propertyvalue_status' => '修改商品属性值的分类状态', 'property_edit' => '商品属性修改', 'property_del' => '属性删除', 'property_add' => '属性添加', 'propertyValue' => '商品属性值列表', 'getOnePropertyValueList' => '商品属性对应商品属性值的列表', 'propertyValue_edit' => '商品属性修改', 'propertyValue_del' => '商品属性删除', )
				),
			'Product' => array(
					'name' => '商品列表',
					'child' => array('index' => '产品列表', 'category' => '分类列表', 'status' => '修改产品状态', 'category_add' => '添加商品分类', 'category_edit' => '修改', 'category_del' => '删除', 'category_status' => '状态修改', 'group' => '产品组列表', 'fxlist' => '被分销的商品列表', 'comment_del' => '评价删除', 'comment_status' => '评价状态修改', 'comment' => '评价列表', )
				),
			'Search_hot' => array(
					'name' => '热门关键词',
					'child' => array('index' => '列表', 'modify' => '添加', 'amend' => '修改', 'del' => '删除', )
				),
			'Slider' => array(
					'name' => '导航管理',
					'child' => array('index' => '分类列表', 'cat_modify' => '分类添加', 'cat_amend' => '分类修改', 'cat_del' => '分类删除', 'slider_list' => '导航列表', 'slider_modify' => '导航添加', 'slider_amend' => '导航修改', 'slider_del' => '导航删除', )
				),
			'Store' => array(
					'name' => '店铺',
					'child' => array('index' => '店铺列表', 'detail' => '店铺详情', 'certification_detail' => '认证详情', 'status' => '状态修改', 'approve' => '认证通过', 'inoutdetail' => '收支明细', 'category' => '主营类目列表', 'category_add' => '主营类目添加', 'category_edit' => '主营类目编辑', 'category_status' => '主营类目状态修改', 'category_del' => '主营类目删除', 'brandType' => '品牌类别列表', 'brandType_status' => '品牌类别状态', 'brandtype_add' => '品牌类别添加', 'brandtype_edit' => '品牌类别修改', 'brandtype_del' => '品牌类别删除', 'brand' => '品牌列表', 'brand_status' => '品牌状态修改', 'brand_add' => '品牌添加', 'brand_edit' => '品牌编辑', 'brand_del' => '品牌删除', 'activityManage' => '获取对接营销活动列表', 'activityRecommendAdd' => '对接活动添加', 'activityRecommend' => '本站活动记录', 'activityRecommendDel' => '对接活动删除', 'activityRecommendRecAdd' => '添加到本站活动记录', 'activityRecommendRecDel' => '本站活动记录删除', 'check' => '店铺对账', 'comment_del' => '评价删除', 'comment_status' => '评价状态修改', 'comment' => '店铺商品评价', 'diyAttestation' => '认证自定义表单', 'diyAttestation_del' => '认证自定义表单删除', 'drp_degree' => '分销商等级', 'drp_degree_add' => '分销商等级添加', 'drp_degree_edit' => '分销商等级修改', 'drp_degree_status' => '分销商等级状态修改', 'drp_degree_del' => '分销商等级删除', 'showButton' => '店铺保证金充值按钮', 'change_public_display'=> '店铺综合展示操作', )
				),
			'Sys_product_property' => array(
					'name' => '系统商品属性',
					'child' => array('propertyType' => '商品属性类别', 'propertytype_status' => '商品属性类别状态', 'propertyType_add' => '商品属性类别添加', 'propertyType_edit' => '商品属性类别修改', 'propertyType_del' => '商品属性类别删除', 'property' => '商品属性', 'property_status' => '商品属性状态', 'property_edit' => '商品属性修改', 'property_del' => '商品属性删除', 'property_add' => '商品属性添加', 'propertyValue' => '商品属性值', 'propertyValue_add' => '商品属性值添加', 'propertyvalue_status' => '商品属性值状态修改', 'propertyValue_edit' => '商品属性值修改', 'propertyValue_del' => '商品属性值删除', )
				),
			'Tag' => array(
					'name' => '标签tag',
					'child' => array('index' => '列表', 'add' => '添加', 'delete' => '删除', 'edit' => '修改', 'status' => '状态修改', )
				),
			'TemplateMsg' => array(
					'name' => '模板消息',
					'child' => array('index' => '列表和操作', )
				),
			'User' => array(
					'name' => '用户',
					'child' => array('index' => '列表', 'amend' => '用户修改', 'stores' => '查看拥有店铺列表', 'tab_store' => '进入商家店铺 ', 'checkout' => '导出列表', 'agent_invite' => '给用户绑定客户经理(代理商)', )
				),
			'Lbs' => array(
					'name' => 'LBS展示区域',
					'child' => array('index' => '列表', 'set_to_hot' => '操作', )
				),
			'Admin' => array(
					'name' => '管理员管理',
					'child' => array('send_reward' => '发送奖金',)
				),
            'Promotion' => array(
                'name' => '推广管理',
                'child' => array('index' => '首页', 'upload' => '更新', 'add' => '添加', 'agent_to_wchat' => '绑定区域代理微信', 'detach' => '解除绑定')
            ),
		);

		$time = time();

		foreach ($admin_module_action as $key => $val) {

			if (D('System_rbac_menu')->where(array('module'=>$key, 'fid'=>0))->find()) {
				continue;
			} else {
				D('System_rbac_menu')->data(array(
					'name' => $val['name'],
					'module' => $key,
					'add_time' => $time,
				))->add();
			}

		}

		foreach ($admin_module_action as $key => $val) {

			if (empty($val['child'])) {
				continue;
			}

			$p_tmp = D('System_rbac_menu')->where(array('module'=>$key))->find();
			foreach ($val['child'] as $k => $v) {

				if (D('System_rbac_menu')->where(array('module'=>$key, 'action'=>$k))->find()) {
					continue;
				} else {
					D('System_rbac_menu')->data(array(
						'fid' => $p_tmp['id'],
						'name' => $v,
						'module' => $key,
						'action' => $k,
						'add_time' => $time,
					))->add();
				}

			}

		}

	}

	/**
	 * 设置初始化地域 store_contact -> store_area_record
	 *
	 * @Auther   pigcms_89
	 * @DateTime 2016-02-26T15:19:25+0800
	 */
	public function initStoreArea () {
		$time = time();
		$store_contact_list = D("storeContact")->order("store_id ASC")->select();
		foreach ($store_contact_list as $val) {
			if (!$store_area_record = D("StoreAreaRecord")->where(array("store_id"=>$val["store_id"]))->find()) {
				$data = array(
					'store_id' => $val['store_id'],
					'province' => $val['province'],
					'city' => $val['city'],
					'county' => $val['county'],
					'add_time' => $time,
					'status' => 1,
				);

				D("StoreAreaRecord")->data($data)->add();
			}
		}
	}

	/**
	 * 获取管理员管理组数组
	 * @return   array
	 * @Auther   pigcms_89
	 * @DateTime 2016-02-26T15:19:48+0800
	 */
	public function adminGroupArr () {

		$admin_group_list = D("AdminGroup")->select();
		if (empty($admin_group_list)) {
			return array();
		}

		$adminGroupArr = array();
		foreach ($admin_group_list as $key => $val) {

			$adminGroupArr[$val['id']] = array(
				'name' => $val['name'],
				'status' => $val['status'],
			);

		}

		return $adminGroupArr;
	}

	/**
	 * 获取管理员类型数组
	 * @param    int
	 * @return   array
	 * @Auther   pigcms_89
	 * @DateTime 2016-02-26T15:20:15+0800
	 */
	public function getAdminType ($type) {

		switch ($type) {
			
			case 1:
				return array(
					'0'=>array(
						'id'=>1,
						'name'=>'超级管理员',
					),
					'1'=>array(
						'id'=>1,
						'name'=>'普通管理员',
					),
					'2'=>array(
						'id'=>2,
						'name'=>'区域管理',
					),
					'3'=>array(
						'id'=>3,
						'name'=>'客户经理(代理商)',
					)
				);
				break;
			
			default:
				return array(
					'1'=>array(
						'id'=>1,
						'name'=>'普通管理员',
					),
					'2'=>array(
						'id'=>2,
						'name'=>'区域管理',
					),
					'3'=>array(
						'id'=>3,
						'name'=>'客户经理(代理商)',
					)
				);
				break;
		}

		

	}

} 