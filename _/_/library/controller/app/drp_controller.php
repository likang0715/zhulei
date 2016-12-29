<?php 
/**
 * 分销商管理
 */
class drp_controller extends base_controller {
	// 注册成为分销商
	public function index() {
		$store_id = $_REQUEST['store_id'];
		if (empty($store_id)) {
			json_return(1000, '缺少参数');
		}
		
		$store = M('Store')->getStore($store_id);
		
		if (empty($store)) {
			json_return(1000, '抱歉，您访问的页面不存在！');
		}
		
		// 分销商申请审核
		Drp::init();
		$visitor = Drp::checkID($store_id, $this->user['uid']);
		if (empty($visitor)) {
			json_return(1000, '抱歉，您访问的页面不存在！');
		} else if (empty($visitor['code'])) {
			json_return(1000, $visitor['msg']);
		} else if (!empty($visitor['data']['drp_limit_buy'])) {
			json_return(1000, $visitor['data']['drp_limit_msg'] . 'aaadd');
		}
		
		if (!empty($visitor['data']['store_id']) && !empty($visitor['data']['allow_drp_manage'])) {
			$data = array();
			$data['type'] = 'jump';
			$data['app_url'] = 'promotion';
			$data['wap_url'] = './ucenter.php?id=' . $store_id . '#promotion';
			json_return(0, array('data' => $data));
		} else if (!empty($visitor['data']['store_id']) && empty($visitor['data']['allow_rp_register'])) {
			json_return(1000, '抱歉，您访问的页面不存在！');
		}
		
		//店铺套餐增加分销商数限制
		$supplier_id = $store['root_supplier_id'] > 0 ? $store['root_supplier_id'] : $store['store_id'];
		$supplier_store = $store;
		if ($supplier_id != $store_id) {
			$supplier_store = D('Store')->where(array('store_id' => $supplier_id))->find();
		}
		
		$seller_count = M('Store')->seller_count('', $supplier_id);
		
		$temp_arr = D('')->table("Store as s")->join('User as u ON s.uid=u.uid', 'LEFT')->join('Package as p ON u.package_id=p.pigcms_id','LEFT')->where("`s`.`store_id`=".$supplier_id)->field("`u`.uid,`s`.store_id,`s`.name,`s`.openid,`u`.package_id,`p`.distributor_nums " )-> find();
		$p_distributor_nums = $temp_arr['distributor_nums'];
		
		if($p_distributor_nums > 0 && $seller_count >= $p_distributor_nums) {
			//发送模板消息告知供货商
			if($temp_arr['openid']) {
				import('source.class.ShopNotice');
				ShopNotice::fxsLimitResultNotice($temp_arr['store_id'],$temp_arr['openid'],$temp_arr['name']);
			}
			
			json_return(1000, '该商家分销商数量已达上限，请联系供货商扩展数量');
		}
		
		$qrcode = array();
		// 在微信端打开时,并且店铺需要关注公众号成为分销商
		if (!$this->is_app && empty($store['drp_supplier_id'])) {
			$open_drp_subscribe = $store['open_drp_subscribe'];
			$open_drp_subscribe_auto = $store['open_drp_subscribe_auto'];
			
			if ($open_drp_subscribe || $open_drp_subscribe_auto) {
				$weixin_bind = M('Weixin_bind')->get_access_token($store_id);
				
				if (!empty($weixin_bind) && empty($weixin_bind['errcode'])) {
					if ($_SESSION['STORE_OPENID_' . $store_id]) {
						// 关注时间等于0为静态授权，非关注
						$is_subscribed = D('Subscribe_store')->where(array('openid' => $_SESSION['STORE_OPENID_' . $store_id], 'store_id'=>$store_id, 'subscribe_time' => array('>', 0),'is_leave'=>0))->count('sub_id');
						if ($is_subscribed <= 0) { //未关注
							$qrcode = M('Recognition')->get_drp_tmp_qrcode(200000000 + $this->user['uid'], $store_id);
						}
					} else {
						// 跳到中间页面，获取店铺的openid
						$data = array();
						$data['type'] = 'jump';
						$data['wap_url'] = './store_openid?store_id=' . $store_id;
						json_return(0, array('data' => $data));
					}
				} else {
					json_return(1000, $weixin_bind['errmsg']);
				}
			}
		}
		
		$user = D('User')->where(array('uid' => $this->user['uid']))->find();
		
		$store_data = array();
		$store_data['root_store_name'] = $supplier_store['name'];
		$store_data['supplier_store_name'] = $store['name'];
		$store_data['team_name'] = '无';
		
		if ($store['drp_level'] > 0 && M('Drp_team')->checkDrpTeam($store_id, true)) {
			//一级分销商（团队所有者）
			$first_seller_id = M('Store_supplier')->getFirstSeller($store_id);
			$first_seller = D('Store')->field('drp_team_id')->where(array('store_id' => $first_seller_id))->find();
			if (!empty($first_seller['drp_team_id'])) {
				$drp_team = D('Drp_team')->where(array('pigcms_id' => $first_seller['drp_team_id']))->find();
				if (!empty($drp_team)) {
					$store_data['team_name'] = $drp_team['name'];
				}
			}
		}
		
		
		$return = array();
		$return['user'] = $user;
		if (!empty($qrcode)) {
			$return['qrcode'] = $qrcode;
		}
		$return['agreement'] = option('config.readme_content');
		$return['store_data'] = $store_data;
		
		json_return(0, $return);
	}
	
	// 注册
	public function register() {
		$store_id = $_REQUEST['store_id'];
		$name = $_REQUEST['name'];
		$tel = $_REQUEST['tel'];
		$linkname = $_REQUEST['linkname'];
		$qq = $_REQUEST['qq'];
		
		if (empty($store_id) || empty($name) || empty($tel)) {
			json_return(1000, '缺少参数');
		}
		
		if (!preg_match("/\d{5,12}$/", $tel)) {
			json_return(1000, '手机号码格式不正确');
		}
		
		if (M('Store')->checkStoreExist(array('name' => $name, 'status' => 1))) {
			json_return(1000, '店铺名称已存在');
		}
		
		if (M('User')->checkUser(array('phone' => trim($tel), 'uid' => array('!=', $this->user['uid'])))) {
			json_return(1000, '手机号码已存在');
		}
		
		$store = M('Store')->getStore($store_id);
		if (empty($store)) {
			json_return(1000, '抱歉，您访问的页面不存在！');
		}
		
		// 分销商申请审核
		Drp::init();
		$visitor = Drp::checkID($store_id, $this->user['uid']);
		if (empty($visitor)) {
			json_return(1000, '抱歉，您访问的页面不存在！');
		} else if (empty($visitor['code'])) {
			json_return(1000, $visitor['msg']);
		} else if (!empty($visitor['data']['drp_limit_buy'])) {
			json_return(1000, $visitor['data']['drp_limit_msg']);
		}
		
		if (!empty($visitor['data']['store_id']) && !empty($visitor['data']['allow_drp_manage'])) {
			json_return(1000, '您已是分销商');
		} else if (!empty($visitor['data']['store_id']) && empty($visitor['data']['allow_rp_register'])) {
			json_return(1000, '抱歉，您访问的页面不存在！');
		}
		
		//店铺套餐增加分销商数限制
		$supplier_id = $store['root_supplier_id'] > 0 ? $store['root_supplier_id'] : $store['store_id'];
		$seller_count = M('Store')->seller_count('', $supplier_id);
		
		$temp_arr = D('')->table("Store as s")->join('User as u ON s.uid=u.uid', 'LEFT')->join('Package as p ON u.package_id=p.pigcms_id','LEFT')->where("`s`.`store_id`=".$supplier_id)->field("`u`.uid,`s`.store_id,`s`.name,`s`.openid,`u`.package_id,`p`.distributor_nums " )-> find();
		$p_distributor_nums = $temp_arr['distributor_nums'];
		
		if($p_distributor_nums > 0 && $seller_count >= $p_distributor_nums) {
			json_return(1000, '该商家分销商数量已达上限，请联系供货商扩展数量');
		}
		
		// 在微信端打开时,并且店铺需要关注公众号成为分销商
		if (!$this->is_app && empty($store['drp_supplier_id'])) {
			$open_drp_subscribe = $store['open_drp_subscribe'];
			$open_drp_subscribe_auto = $store['open_drp_subscribe_auto'];
			
			if ($open_drp_subscribe || $open_drp_subscribe_auto) {
				// 关注时间等于0为静态授权，非关注
				$is_subscribed = D('Subscribe_store')->where(array('openid' => $_SESSION['STORE_OPENID_' . $store_id], 'store_id' => $store_id, 'subscribe_time' => array('>', 0), 'is_leave' => 0))->count('sub_id');
				if ($is_subscribed <= 0) { //未关注
					json_return(1000, '请先注册公众号，再申请分销商');
				}
			}
		}
		
		// 实时获取用户信息
		$user = D('User')->where(array('uid' => $this->user['uid']))->find();
		// 获取供货商店铺信息
		$supplier_store = M('Store')->getSuppliers($store_id);
		
		$uid = $this->user['uid'];
		$open_drp_approve = !empty($_POST['open_drp_approve']) ? intval(trim($_POST['open_drp_approve'])) : 0; //是否开启分销商审核
		//获取顶级供货商
		$top_store_info = M('Store')->getSuppliers($supplier_id);
		//商家（供货商店铺所有者）
		$tmp_user = D('User')->field('openid,phone')->where(array('uid' => $top_store_info['uid']))->find();
		$supplier_wecha_id = !empty($tmp_user['openid']) ? $tmp_user['openid'] : ''; //供货商的openid(发送模板消息)
		//分销商
		$seller_wecha_id = !empty($_SESSION['wap_user']['openid']) ? $_SESSION['wap_user']['openid'] : $_SESSION['openid'];
		
		
		$data = array();
		$data['uid'] = $this->user['uid'];
		$data['name'] = $name;
		$data['sale_category_id'] = $supplier_store['sale_category_id'];
		$data['sale_category_fid'] = $supplier_store['sale_category_fid'];
		$data['linkman'] = $linkname;
		$data['tel'] = $tel;
		$data['status'] = 1;
		$data['qq'] = $qq;
		$data['drp_supplier_id'] = $store_id;
		$data['date_added'] = time();
		$data['drp_level'] = $store['drp_level'] + 1;
		$data['logo'] = $user['avatar'];
		$data['open_nav'] = $supplier_store['open_nav'];
		$data['open_ad'] = $supplier_store['open_ad'];
		$data['nav_style_id'] = $supplier_store['nav_style_id'];
		$data['use_nav_pages'] = $supplier_store['use_nav_pages'];
		$data['has_ad'] = $supplier_store['has_ad'];
		$data['root_supplier_id'] = $supplier_store['store_id'];
		$data['source_site_url'] = $supplier_store['source_site_url'];
		$data['payment_url'] = $supplier_store['payment_url'];
		$data['notify_url'] = $supplier_store['notify_url'];
		$data['oauth_url'] = $supplier_store['oauth_url'];
		$data['token'] = $supplier_store['token'];
		
		$root_supplier_id = $supplier_store['store_id'];
		
		$data['bind_weixin'] = $supplier_store['bind_weixin']; // 微信绑定按供货商
		if ($store['open_drp_approve']) {
			$data['drp_approve'] = 0; //需要审核
		}
		
		$data['drp_diy_store'] = 0; //不允许分销商装修店铺
		
		//检测是否可用分销团队，如果有则加入
		$drp_team_id = 0;
		if ($store['drp_level'] > 0 && M('Drp_team')->checkDrpTeam($store_id, true)) {
			//一级分销商（团队所有者）
			$first_seller_id = M('Store_supplier')->getFirstSeller($store_id);
			$first_seller = D('Store')->field('drp_team_id')->where(array('store_id' => $first_seller_id))->find();
			if (!empty($first_seller['drp_team_id'])) {
				$data['drp_team_id'] = $first_seller['drp_team_id'];
				$drp_team_id = $first_seller['drp_team_id'];
			}
		}
		
		$result = M('Store')->create($data);
		if (!empty($result['err_code'])) { //店铺添加成功
			$store_id = $result['err_msg']['store_id']; //分销商id
			//平台店铺数+1
			M('Common_data')->setStoreQty();
			//分销商数+1
			M('Common_data')->setDrpSellerQty();
			$_SESSION['wap_drp_store'] = M('Store')->getStore($store_id);
			
			if (empty($user['password']) && empty($user['phone'])) { //未设置密码
				// 对接用户首次分销设置登录密码为手机号
				if ($user->setField(array('uid' => $uid), array('phone' => $tel, 'password' => md5($tel)))) {
					$_SESSION['wap_user']['phone'] = $tel;
				}
			}
			
			//团队成员数+1
			if (!empty($data['drp_team_id'])) {
				M('Drp_team')->setMembersInc($data['drp_team_id']);
			}
			//用户店铺数+1
			M('User')->setStoreInc($this->user['uid']);
			//设置为卖家
			M('User')->setSeller($this->user['uid'], 1);
			//主营类目店铺数加1
			M('Sale_category')->setStoreInc($supplier_store['sale_category_id']);
			M('Sale_category')->setStoreInc($supplier_store['sale_category_fid']);
			
			// 如果是一级分销商，增加团队
			if ($store['drp_level'] == 0) {
				$data = array();
				$data['name'] = $name;
				$data['logo'] = $user['logo'];
				$data['store_id'] = $store_id;
				$data['supplier_id'] = $store['store_id'];
				$data['sales'] = 0;
				$data['members'] = 1;
				$data['status'] = 1;
				$data['add_time'] = time();
				
				D('Drp_team')->data($data)->add();
			} else if ($drp_team_id) {
				D('Drp_team')->where(array('pigcms_id' => $drp_team_id))->setInc('members', 1);
			}
			
			$seller = M('Store_supplier')->getSeller(array('seller_id' => $store['store_id'])); //获取上级分销商信息
			if (empty($seller['type'])) { //全网分销的分销商
				$seller['supply_chain'] = 0;
				$seller['level'] = 0;
			}
			$seller['supply_chain'] = !empty($seller['supply_chain']) ? $seller['supply_chain'] : 0;
			$seller['level'] = !empty($seller['level']) ? $seller['level'] : 0;
			$supply_chain = $seller['supply_chain'] . ',' . $store['store_id'];
			$level = $seller['level'] + 1;
			$data = array();
			$data['supplier_id'] = $store['store_id'];
			$data['seller_id'] = $store_id;
			$data['supply_chain'] = $supply_chain;
			$data['level'] = $level;
			$data['type'] = 1;
			$data['root_supplier_id'] = $supplier_store['store_id']; //统一供货商id
			M('Store_supplier')->add($data);//添加分销关联关系
			
			//商家（供货商店铺所有者）
			$tmp_user = D('User')->field('openid,phone')->where(array('uid' => $supplier_store['uid']))->find();
			$supplier_wecha_id = !empty($tmp_user['openid']) ? $tmp_user['openid'] : ''; //供货商的openid(发送模板消息)
			//分销商
			$seller_wecha_id = $user['openid'];
			if (!empty($supplier_wecha_id) || !empty($seller_wecha_id)) {
				if ($store['open_drp_approve']) {
					$remark = '待审核分销商';
				} else {
					$remark = '正式分销商';
				}
			}
			
			//添加分销用户
			if (!D('Store_user_data')->where(array('store_id' => $supplier_store['store_id'], 'uid' => $user['uid']))->count('pigcms_id')) {
				D('Store_user_data')->data(array('store_id' => $supplier_store['store_id'], 'uid' => $user['uid']))->add();
			}
			
			//已关注过店铺公众号
			if (M('Subscribe_store')->subscribed($user['uid'], $supplier_store['store_id'])) {
				import('source.class.Points');
				Points::subscribe($user['uid'], $supplier_store['store_id'], $store_id, true);
			} else {
				//普通注册送积分
				import('source.class.Points');
				Points::drpStore($user['uid'], $supplier_store['store_id'], $store_id);
			}
			
			//产生提醒-分销商申请成功通知
			import('source.class.Notice');
			Notice::FxStoreApplication($store, $supplier_store, $tmp_user , $remark, $tel, $name);
			
			json_return(0, '店铺创建成功');
		} else {
			json_return(1000, '店铺创建失败');
		}
	}
}