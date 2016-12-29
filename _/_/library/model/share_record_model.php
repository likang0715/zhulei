<?php

/**
 * 分享记录
 * User: pigcms_89
 * Date: 2016/01/16
 * Time: 10:09
 */
class share_record_model extends base_model
{

	/**
	 * [getShareRecord 获取一条记录 无则生成]
	 * @param    int $store_id 被分享店铺store_id
	 * @param    int $share_uid 分享者uid
	 * @return   array 
	 * @Auther   pigcms_89
	 * @DateTime 2016-01-16T10:12:32+0800
	 */
	public function getShareRecord($store_id = 0, $share_uid = 0) {

		if (empty($store_id) || !$store_info = D('Store')->where(array('store_id'=>$store_id))->find()) {
			return false;
		}

		if (empty($share_uid) || !$store_info = D('User')->where(array('uid'=>$share_uid))->find()) {
			return false;
		}		

		$share_record = $this->db->where(array('store_id'=>$store_id, 'uid'=>$share_uid))->find();
		if (!empty($share_record)) {
			return $share_record;
		}

		return $this->add_record($store_id, $share_uid);

	}

	/**
	 * [add_record 生成分享记录]
	 * @param    int $store_id [供货商id]
	 * @param    int $share_uid [分享者uid]
	 * @Auther   pigcms_89
	 * @DateTime 2016-01-20T14:16:47+0800
	 */
	public function add_record($store_id = 0, $share_uid = 0) {

		$add_data = array(
			'store_id' => $store_id,
			'uid' => $share_uid,
			'addtime' => time(),
		);

		$salt = "[~.~]";
		$key = md5($store_id.$salt.$share_uid);
		$add_data['key'] = $key;
		$result = $this->db->data($add_data)->add();

		if ($result) {
			return $add_data;
		} else {
			return array();
		}

	}

	/**
	 * [createLink 生成分享链接]
	 * @param    int $store_id [供货商id]
	 * @param    int $share_uid [分享者uid]
	 * @return   str [分享链接]
	 * @Auther   pigcms_89
	 * @DateTime 2016-01-20T14:17:47+0800
	 */
	public function createLink($store_id = 0, $share_uid = 0) {

		$share_record = $this->getShareRecord($store_id, $share_uid);

		if (empty($share_record)) {
			return false;
		} 

		return option('config.wap_site_url') . '/home.php?id='.$share_record['store_id'].'&key=' . $share_record['key'];

	}

	/**
	 * [addPoints 访问分享链接，给分享者添加积分]
	 * @param    string $key [description]
	 * @Auther   pigcms_89
	 * @DateTime 2016-01-20T14:19:10+0800
	 */
	public function addPoints($key = '') {

		if (empty($key) || !$share_record = $this->db->where(array('key'=>$key))->find()) {
			return;
		}

		$seller_id = 0;
		$drp_store = $this->is_drp_store($share_record['uid'], $share_record['store_id']);
		Points::shareLink($share_record['uid'], $share_record['store_id'], $drp_store['seller_id']);

	}

	// 判断是否是该店铺的分销商
	public function is_drp_store($uid = 0, $store_id = 0) {

		$now_store = D('Store')->where(array('store_id'=>$store_id))->find();
		$drp_link = false;
		$seller_id = 0;
		if ($now_store['uid'] == $uid) {	//自己店铺
			if (!empty($now_store['drp_supplier_id'])) { //分销商
                $drp_link     = true;
                $seller_id = $store_id;
            }
		} else { //他人店铺
			
			//获取当前店铺分销链（上级分销商）
			$supply_chain = D('Store_supplier')->field('supply_chain')->where(array('seller_id' => $store_id, 'type' => 1))->find();
			$supply_chain = explode(',', $supply_chain['supply_chain']);
			array_shift($supply_chain);
			//获取当前用户的店铺
			$stores = D('Store')->field('store_id,name,drp_supplier_id,status')->where(array('uid' => $uid))->select();
			$user_supply_chains = array();

			if (!empty($stores)) {
			    foreach ($stores as $tmp_store) {
			        if (in_array($tmp_store['status'], array(4,5))) { //店铺被禁用或删除
			            continue;
			        }
			        if (!empty($tmp_store['drp_supplier_id']) && $tmp_store['drp_supplier_id'] == $store_id) { //当前店铺的下级分销商（当前访问的店铺是登陆用户的上级分销商或供货商）
			            $drp_link     = true;
			            $seller_id = $tmp_store['store_id'];
			            break;
			        } else if (!empty($tmp_store['drp_supplier_id'])) { //分销商
			            //获取店铺分销链（上级分销商）
			            $store_supply_chain = D('Store_supplier')->field('supply_chain')->where(array('seller_id' => $tmp_store['store_id'], 'type' => 1))->find();
			            $store_supply_chain = explode(',', $store_supply_chain['supply_chain']);
			            array_shift($store_supply_chain);
			            //当前访问的店铺的上级（当前访问的店铺是登陆用户的下级分销商）
			            if (in_array($tmp_store['store_id'], $supply_chain)) {
			                $drp_link     = true;
			                $seller_id = $tmp_store['store_id'];
			                break;
			            } else if ($store_supply_chain == $supply_chain) { //同级分销商
			                $drp_link     = true;
			                $seller_id = $tmp_store['store_id'];
			                break;
			            } else if (array_intersect($supply_chain, $store_supply_chain)) { //有交集的分销商
			                $drp_link     = true;
			                $seller_id = $tmp_store['store_id'];
			                break;
			            }
			        }
			    }
			    if (!empty($user_supply_chains)) {
			        foreach ($user_supply_chains as $tmp_seller_id => $user_supply_chain) {
			            if (in_array($store_id, $user_supply_chain)) { //当前访问店铺的非直属下级
			                $drp_link     = true;
			                $seller_id = $tmp_seller_id;
			                break;
			            }
			        }
			    }
			}
		}

		return array('is_drp'=>$drp_link, 'seller_id'=>$seller_id);
	}

}
