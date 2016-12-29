<?php
	require_once dirname(__FILE__).'/global.php';
	
    $store_supplier = M('Store_supplier');
    $getAllSellerList = $store_supplier->getAllSellerId($_POST['store_id']);

    $new_seller_arr = array();
    foreach ($getAllSellerList as $v) {
		$new_seller_arr[] = $v['seller_id'];
    }

    $_condition['store_id'] = array('in', $new_seller_arr);
    $store_list = D('Store')->where($_condition)->select();


    $user_list = array();
    foreach ($store_list as $v) {
		$user_list[] = $v['uid'];
    }
    
    $user = D('User')->field('uid,nickname,avatar,password,phone,openid')->where(array('uid' => $_POST['uid']))->find();

    if (!in_array($_POST['uid'], $user_list)) {
		$uid = $_POST['uid'];
		$common_data = M('Common_data');
		$sale_category = M('Sale_category');
	
		
		$store = D('Store')->field('store_id,name,open_drp_approve,sale_category_id,sale_category_fid,open_nav,drp_level,open_drp_subscribe_auto,drp_subscribe_tpl,open_drp_subscribe,reg_drp_subscribe_tpl,reg_drp_subscribe_img,drp_subscribe_img')->where(array('store_id' => $_POST['store_id']))->find();
		$supplier_id = $_POST['store_id'];
		$name = !empty($user['nickname']) ? $user['nickname'] : $store['name'] . '分店';
		$linkname = $user['nickname'];
		$avatar = $user['avatar'];
		$drp_level = ($store['drp_level'] + 1); //分销级别
	
		$data = array();
		$data['uid'] = $uid;
		$data['name'] = $name;
		$data['sale_category_id'] = $store['sale_category_id'];
		$data['sale_category_fid'] = $store['sale_category_fid'];
		$data['linkman'] = $linkname;
		$data['tel'] = '';
		$data['status'] = 1;
		$data['qq'] = '';
		$data['drp_supplier_id'] = $supplier_id;
		$data['date_added'] = time();
		$data['drp_level'] = $drp_level;
		$data['logo'] = $avatar;
		$data['open_nav'] = $store['open_nav'];
		$data['bind_weixin'] = 0;
		$data['open_drp_diy_store'] = 0;
		$data['drp_diy_store'] = 0;
		if (!empty($store['open_drp_approve'])) {
		    $data['drp_approve'] = 0; //需要审核
		}

		$store['drp_subscribe_img'] = !empty($store['drp_subscribe_img']) ? $store['drp_subscribe_img'] : getAttachmentUrl('images/drp_ad_01.png');
	
		$result = M('Store')->create($data);
		if (!empty($result['err_code'])) { //店铺添加成功
		    $common_data->setStoreQty();
	
		    $store_id2 = $result['err_msg']['store_id']; //分销商id
		    //用户店铺数加1
		    M('User')->setStoreInc($uid);
		    //设置为卖家
		    M('User')->setSeller($uid, 1);
	
		    //主营类目店铺数加1
		    $sale_category->setStoreInc($store['sale_category_id']);
		    $sale_category->setStoreInc($store['sale_category_fid']);
	
		    $current_seller = $store_supplier->getSeller(array('seller_id' => $store_id2));
		    if ($current_seller['supplier_id'] != $supplier_id) {
			$seller = $store_supplier->getSeller(array('seller_id' => $supplier_id)); //获取上级分销商信息
			if (empty($seller['type'])) { //全网分销的分销商
			    $seller['supply_chain'] = 0;
			    $seller['level'] = 0;
			}
			$seller['supply_chain'] = !empty($seller['supply_chain']) ? $seller['supply_chain'] : 0;
			$seller['level'] = !empty($seller['level']) ? $seller['level'] : 0;
			$supply_chain = !empty($supplier_id) ? $seller['supply_chain'] . ',' . $supplier_id : 0;
			$level = $seller['level'] + 1;
			$store_supplier->add(array('supplier_id' => $supplier_id, 'seller_id' => $store_id2, 'supply_chain' => $supply_chain, 'level' => $level, 'type' => 1)); //添加分销关联关系
		    }
		    if(!$user['password']&&!$user['phone']){
		    	$user = D('User')->field('uid,nickname,avatar,password,phone,openid')->where(array('uid' => $_POST['uid']))->find();
		    //发送模板消息
		    import('source.class.Factory');
		    import('source.class.MessageFactory');
		    
		    $template_data = array(
		    		'wecha_id' => $user['openid'],
		    		'first'    => '您好，恭喜您分享店铺成为分销商。',
		    		'keyword1' => $user['nickname'],
		    		'keyword2' => date('Y-m-d H:i:s'),
		    		'keyword3' => date('Y-m-d H:i:s'),
		    		'remark'   => '状态：' . "待审核分销商",
		    		 'href'     => option('config.wap_site_url') . '/home.php?id=' . $store_id2,
		    );
		    
		    $params['template'] = array('template_id' => 'OPENTM207126233', 'template_data' => $template_data);
		    $moban = array('TemplateMessage');
		    MessageFactory::method($params,$moban);
		    }
	
		    $common_data->setDrpSellerQty();
	
		    $return = array();
		    $store['drp_subscribe_tpl'] = !empty($store['drp_subscribe_tpl']) ? $store['drp_subscribe_tpl'] : '尊敬的 {$nickname}, 您已成为 {$store} 第 {$num} 位分销商，点击管理店铺。';
	
		    
		    
		    
		    
		    if (stripos($store['drp_subscribe_tpl'], '{$num}') !== false) {
			$sellers = $store_supplier->getSubSellers($supplier_id);
			$seller_num = count($sellers);
			$content = str_replace(array('{$nickname}', '{$store}', '{$num}'), array($user['nickname'], $store['name'], $seller_num), $store['drp_subscribe_tpl']);
		    } else if (preg_match('/\{\$num=(\d+)\}/i', $store['drp_subscribe_tpl'])) {
			$sellers = $store_supplier->getSubSellers($supplier_id);
			global $global_seller_num;
			$global_seller_num = count($sellers);
			$content = str_replace(array('{$nickname}', '{$store}'), array($user['nickname'], $store['name']), $store['drp_subscribe_tpl']);
			$content = preg_replace_callback('/\{\$num=(\d+)\}/i', function($num) {
			    global $global_seller_num;
			    $num[1] = !empty($num[1]) ? $num[1] : 0;
			    return $num[1] + $global_seller_num;
			}, $content);
		    }
		    echo json_encode(array(
		    	'title'  => $name,
		    	'imgUrl' => $avatar,
		    	'desc'   => $name,
		    	'link'   => option('config.wap_site_url') . '/home.php?id=' . $store_id2 . '&uid=' . $uid
		    ));

		    exit;
		}
    }


?>