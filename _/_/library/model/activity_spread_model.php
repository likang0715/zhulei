<?php

/**
 * 活动推广二维码
 * User: pigcms_89
 * Date: 2015/12/10
 * Time: 11:13
 */
class activity_spread_model extends base_model
{

	/**
	 * [getQcode 生成营销活动推广 临时二维码]
	 * @param    [type] $data = array(
	 *     'modelId' => '活动id',
	 *     'model' => '活动类型',
	 *     'title' => '活动名称',
	 *     'info' => '商品说明',
	 *     'image' => '活动图片',
	 *     'product_id' => '产品id',
	 *     'sku_id' => '规格id',
	 *     'token' => 'token',
	 * );
	 * @return   [arr]
	 * @Auther   pigcms_89
	 * @DateTime 2015-12-14T16:52:12+0800
	 */
	public function getQcode($data)
	{

		$where = array('modelId'=>$data['modelId'], 'model'=>$data['model']);
		$qcodeTmp = $this->db->where($where)->find();

		$time = time();
		$out_time = 7*86400;

		if (empty($qcodeTmp) || $time > ($qcodeTmp['addtime'] + $out_time)) {   // 初次/过期重新获取

			$addData = array(
					'modelId' => $data['modelId'],
					'model' => $data['model'],
					'title' => $data['title'],
					'info' => $data['info'],
					'keyword' => $data['keyword'],
					'image' => $data['image'],
					'token' => $data['token'],
					'product_id' => $data['product_id'],
					'sku_id' => $data['sku_id'],
				);
			$pigcms_id = $this->db->data($addData)->add();

			$qid = "900000000";                 //场景起始id
			$get_qid = $pigcms_id;
			$qid = (int)$qid + (int)$get_qid;

			$recoTmp = M('Recognition')->get_tmp_qrcode($qid);

			// // 测试店铺token
			// $whereStore['pigcmsToken'] = trim($addData['token']);
			// $storeInfo = D('Store')->where($whereStore)->find();
			// if ($storeInfo) {       // 店铺二维码
			//     $recoTmp = M('Recognition')->get_bind_tmp_qrcode($qid, $storeInfo['store_id']);
			// } else {                // 平台二维码
			//     $recoTmp = M('Recognition')->get_tmp_qrcode($qid);
			// }

			if ($recoTmp['error_code'] == '0') {
				$status = $this->db->where(array('pigcms_id'=>$pigcms_id))->data(array('qcode' => $recoTmp['ticket'], 'addtime' => 0))->save();
				if($status){
					$where = array('pigcms_id'=>array('!=',$pigcms_id),'modelId'=>$data['modelId'], 'model'=>$data['model']);
					$this->db->where($where)->delete();
				}
				$resultData = array(
					'qcode' => $recoTmp['ticket'],
					'error_code' => 0,
					'error_msg' => '请求成功',
				);

			} else {

				$resultData = array(
					'qcode' => '',
					'error_code' => $recoTmp['error_code'],
					'error_msg' => $recoTmp['msg'],
				);

			}

		} else {                                            //直接使用

			$upData = array(
				'title' => $data['title'],
				'info' => $data['info'],
				'image' => $data['image'],
				'keyword' => $data['keyword'],
				'product_id' => $data['product_id'],
				'sku_id' => $data['sku_id'],
			);

			// 更新记录
			$this->db->where(array('pigcms_id'=>$qcodeTmp['pigcms_id']))->data($upData)->save();

			$resultData = array(
				'qcode' => $qcodeTmp['qcode'],
				'error_code' => 0,
				'error_msg' => '请求成功',
			);

		}

		return $resultData;
	}

	/**
	 * [getShopQcode 活动接口调用 获取未关注所需信息]
	 *     【认证公众号】-参数二维码
	 *     【非认证公众号】- 公众号二维码img url + 快速关注链接
	 * @param    [type] array(
	 *     'modelId' => '活动id',
	 *     'model' => '活动类型',
	 *     'title' => '活动名称',
	 *     'info' => '商品说明',
	 *     'image' => '活动图片',
	 *     'token' => 'token',
	 * );
	 * @return   [arr]
	 * @Auther   pigcms_89
	 * @DateTime 2015-12-14T16:48:57+0800
	 */
	public function getShopQcode($data) {

		$whereStore['pigcmsToken'] = trim($data['token']);
		$storeInfo = D('Store')->where($whereStore)->find();

		$weixinBind = D('Weixin_bind')->where(array('store_id'=>$storeInfo['store_id']))->find();

		if (empty($weixinBind)) {
			$resultData = array(
				'hurl' => '',
				'qcode' => '',
				'error_code' => 1004,
				'error_msg' => '店铺未绑定公众号',
			);
			return $resultData;
		}

		if ($weixinBind['service_type_info'] == 2 && $weixinBind['verify_type_info'] != '-1' ) {   // 认证订阅号  店铺参数二维码  

			// 创建/保存二维码
			$where = array('modelId'=>$data['modelId'], 'model'=>$data['model']);
			$qcodeTmp = $this->db->where($where)->find();

			$time = time();
			$out_time = 7*86400;

			if (empty($qcodeTmp) || $time > ($qcodeTmp['addtime'] + $out_time)) {   // 初次/过期重新获取

				$addData = array(
					'modelId' => $data['modelId'],
					'model' => $data['model'],
					'title' => $data['title'],
					'info' => $data['info'],
					'image' => $data['image'],
					'token' => $data['token'],
					'keyword' => $data['keyword'],
				);
				$pigcms_id = $this->db->data($addData)->add();

				$qid = "500000000";                 //场景起始id
				$get_qid = $pigcms_id;
				$qid = (int)$qid + (int)$get_qid;
				$recoTmp = M('Recognition')->get_bind_tmp_qrcode($qid, $storeInfo['store_id']);

				if ($recoTmp['error_code'] == '0') {
					$status = $this->db->where(array('pigcms_id'=>$pigcms_id))->data(array('qcode' => $recoTmp['ticket'], 'addtime' => $time))->save();
					if($status){
						$where = array('pigcms_id'=>array('!=',$pigcms_id),'modelId'=>$data['modelId'], 'model'=>$data['model']);
						$this->db->where($where)->delete();
					}
					// $hurl = M('Activity')->createUrl($data, $data['model'], true);
					$resultData = array(
						'hurl' => $weixinBind['hurl'],
						'qcode' => $recoTmp['ticket'],
						'error_code' => 0,
						'error_msg' => '请求成功',
					);

				} else {

					$resultData = array(
						'hurl' => '',
						'qcode' => '',
						'error_code' => $recoTmp['error_code'],
						'error_msg' => $recoTmp['msg'],
					);

				}

			} else if (!empty($qcodeTmp) && empty($qcodeTmp['qcode'])) {            // 未获取到qcode

				$qid = "500000000";                 //场景起始id
				$get_qid = $qcodeTmp['pigcms_id'];
				$qid = (int)$qid + (int)$get_qid;
				$recoTmp = M('Recognition')->get_bind_tmp_qrcode($qid, $storeInfo['store_id']);

				if ($recoTmp['error_code'] == '0') {

					$this->db->where(array('pigcms_id'=>$pigcms_id))->data(array('qcode' => $recoTmp['ticket'], 'addtime' => $time))->save();
					// $hurl = M('Activity')->createUrl($data, $data['model'], true);
					$resultData = array(
						'hurl' => $weixinBind['hurl'],
						'qcode' => $recoTmp['ticket'],
						'error_code' => 0,
						'error_msg' => '请求成功',
					);

				} else {

					$resultData = array(
						'hurl' => '',
						'qcode' => '',
						'error_code' => $recoTmp['error_code'],
						'error_msg' => $recoTmp['msg'],
					);

				}

			} else {
				// $hurl = M('Activity')->createUrl($data, $data['model'], true);
				$resultData = array(
					'hurl' => $weixinBind['hurl'],
					'qcode' => $qcodeTmp['qcode'],
					'error_code' => 0,
					'error_msg' => '请求成功',
				);
			}

			return $resultData;

		} else {                                                                                    // 非认证订阅号  获取上传的公众号二维码图片

			return array(
				'hurl' => $weixinBind['hurl'],
				'qcode' => $weixinBind['qrcode_url'],
				'error_code' => 0,
				'error_msg' => '请求成功',
			);

		}

	}

	/**
	 * [isSubscribe 活动对接，判断是否关注店铺公众号]
	 * @param    [int] $store_id [店铺id]
	 * @param    [str] $openid [平台openid]
	 * @return   bool [description]
	 * @Auther   pigcms_89
	 * @DateTime 2015-12-14T16:47:50+0800
	 */
	public function isSubscribe($token, $openid) {

		$storeInfo = D('Store')->where(array('pigcmsToken'=>$token))->find();
		if (empty($storeInfo)) {
			return false;
		}

		$weixin_bind = D('Weixin_bind')->where(array('store_id' => $storeInfo['store_id']))->find();
		if (empty($weixin_bind)) {
			return false;
		}

		$userInfo = D('User')->where(array('openid'=>$openid))->find();
		if (empty($userInfo)) {
			return false;
		}
		
		//关注店铺信息
		$subscribeStore = D('Subscribe_store')->where(array('uid'=>$userInfo['uid'], 'store_id'=>$storeInfo['store_id']))->find();

		//是否是认证服务号
		if ($weixin_bind['service_type_info'] == 2 && $weixin_bind['verify_type_info'] != '-1') {
			//是否有记录关注openid
			if(empty($subscribeStore)) {
				return false;
			} else {
				$result = M('Weixin_bind')->get_access_token($weixin_bind['store_id']);
				$url = 'https://api.weixin.qq.com/cgi-bin/user/info?openid='.$subscribeStore['openid'].'&access_token='.$result['access_token'];

				import('source.class.Http');
				$result = Http::curlGet($url);
				$data   = json_decode($result);
				// dump($data);
				if ($data->subscribe == 0) {
					//没有关注
					return false;
				} else {
					return true;
				}
			}
		} else {
			//非认证服务号 判断是否存在关注记录
			if (empty($subscribeStore)) {
				//没有关注
				return false;
			} else {
				return true;
			}	
		}

	}

	/**
	 * [getActByGoods 获取商品的关联活动]
	 * @param    int $product_id 商品id
	 * @param    int $sku_id 规格id
	 * @return   array
	 * @Auther   pigcms_89
	 * @DateTime 2016-01-05T16:32:47+0800
	 */
	public function getActByGoods($product_id, $sku_id = 0) {

		if ($sku_id == 0) {
			$where = array(
				'product_id' => $product_id,
			);
		} else {
			$where = array(
				'product_id' => $product_id,
				'sku_id' => $sku_id,
			);
		}

		return $this->db->where($where)->select();
	}

}
