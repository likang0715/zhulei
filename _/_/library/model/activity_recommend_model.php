<?php
class activity_recommend_model extends base_model{
	public function getActivityHTML($type, $num = 10) {
		$html = '';
		$page = 1;
		$i = 0;
		
		$activity_table_arr = array(
								'tuan' => array('Tuan', "id = '#'"),
								'presale' => array('Presale', "id = '#'"),
								'bargain' => array('Bargain', "pigcms_id = '#'"),
								'seckill' => array('Seckill', "pigcms_id = '#'"),
								'crowdfunding' => array('Zc_product', "product_id = '#'"),
								'unitary' => array('Unitary', "id = '#'"),
								'cutprice' => array('Cutprice', "pigcms_id = '#'"),
								/*'lottery' => array('Lottery', "id = '#'"),
								'guajiang' => array('Lottery', "id = '#'"),
								'jiugong' => array('Lottery', "id = '#'"),
								'luckyFruit' => array('Lottery', "id = '#'"),
								'goldenEgg' => array('Lottery', "id = '#'")*/
							);
		
		while(true) {
			$activity_recommend_list = $this->getActivity($type, $num, $page);
			if (empty($activity_recommend_list)) {
				break;
			}
			$page++;
			foreach ($activity_recommend_list as $activity_recommend) {
				$model = $activity_recommend['model'];
				if (!isset($activity_table_arr[$model])) {
					continue;
				}
				
				$activity = D($activity_table_arr[$model][0])->where(str_replace('#', $activity_recommend['modelId'], $activity_table_arr[$model][1]))->find();
				if (empty($activity)) {
					continue;
				}
				
				if ($model == 'tuan') {
					if ($activity['delete_flg'] == 1 || $activity['status'] == 2 || $activity['end_time'] < time()) {
						$this->closeActivity($activity_recommend['id']);
						continue;
					}
						
					if ($activity['start_time'] > time()) {
						continue;
					}
						
					// 团购
					$product = D('Product')->where("product_id='" . $activity['product_id'] . "'")->find();
					if (empty($product) || $product['status'] != 1) {
						$this->closeActivity($activity_recommend['id']);
						continue;
					}
					// 团购
					$tuan_person = M('Order')->getActivityOrderCount(6, $activity['id']);
					$images = getAttachmentUrl($product['image']);
					
					$html .= '<li class="swiper-slide"><a href="' . option('config.site_url') . '/webapp/groupbuy/#/details/' . $activity['id'] . '"><img src="' . $images . '"/><h3>' . $activity['name'].'</h3><p><span>' . $activity['start_price'].'<i>元</i></span><span>原价' . $product['price'] . '元</span></p><div class="time">已有' . $tuan_person.'人参团</div></a><i class="tipOn ' . $model . '">团购</i></li>';
				} else if ($model == 'presale') {
					if ($activity['endtime'] < time() || $activity['is_open'] == 0) {
						$this->closeActivity($activity_recommend['id']);
						continue;
					}
					// 预售
					$product = D('Product')->where("product_id='" . $activity['product_id'] . "'")->find();
					$images = getAttachmentUrl($product['image']);
					
					$html .= '<li class="swiper-slide"><a href="' . option('config.wap_site_url') . '/presale.php?id=' . $activity['id'] . '&store_id=' . $activity['store_id'] . '"><img src="' . $images . '"/><h3>' . $activity['name'] . '</h3><p><span>' . $activity['dingjin'] . '<i>元</i></p><p>已参与<span>' . $activity['presale_person'] . '<i>人</i></p></a><i class="tipOn ' . $model . '">预售</i></li>';
				} else if ($model == 'bargain') {
					if ($activity['delete_flag'] == 1 || $activity['state'] == 0) {
						$this->closeActivity($activity_recommend['id']);
						continue;
					}
					// 砍价
					$product = D('Product')->where("product_id='" . $activity['product_id'] . "'")->find();
					$images = getAttachmentUrl($product['image']);
					
					$bargain_person = D('Bargain_kanuser')->where(array('bargain_id' => $activity['pigcms_id']))->count("pigcms_id");
					$html .= '<li class="swiper-slide"><a href="' . option('config.wap_site_url') . '/bargain.php?action=detail&id=' . $activity['pigcms_id'] . '&store_id=' . $activity['store_id'].'"><img src="' . $images . '"/><h3>' . msubstr($product['product_name'], 0, 8) . '</h3><p><span>' . ($activity['minimum'] / 100) . '<i>元</i></span><span>原价' . ($product['original'] / 100) . '元</span></p><div class="time">已有' . $bargain_person . '人参与</div></a><i class="tipOn ' . $model . '">砍价</i></li>';
				} else if ($model == 'seckill') {
					if ($activity['delete_flag'] == 1 || $activity['status'] == 2) {
						$this->closeActivity($activity_recommend['id']);
						continue;
					}
					
					// 秒杀
					$product = D('Product')->where(array('product_id' => $activity['product_id']))->find();
					$images = getAttachmentUrl($product['image']);
					
					//秒杀价
					$seckill_price = $activity['seckill_price'] ? $activity['seckill_price'] : $product['product_price'];
					$seckill_persons = D('Seckill_user')->where(array('seckill_id' => $activity['pigcms_id']))->count('pigcms_id');
					$html .= '<li class="swiper-slide"><a href="' . option('config.wap_site_url') . '/seckill.php?seckill_id=' . $activity['pigcms_id'] . '"><img src="' . $images . '"/><h3>' . msubstr($activity['name'], 0, 8).'</h3><p><span>' . $seckill_price . '<i>元</i></span><span>原价' . $seckill_list['price'] . '元</span></p><div class="time">已有' . $seckill_persons . '人参与</div></a><i class="tipOn ' . $model . '">秒杀</i></li>';
				} else if ($model == 'crowdfunding') {
					// 众筹
					$images = getAttachmentUrl($activity['productImageMobile']);
						
					$per = 100;
					if (!empty($activity['amount'])) {
						$per = min(100, round($activity['collect'] / $activity['amount'] * 100, 2));
					}
					
					$html .= '<li class="swiper-slide"><a href="' . option('config.site_url') . '/webapp/chanping/#/view/' . $activity['product_id'] . '"><img src="' . $images . '"><h3>' . $activity['productName'] . '</h3><p class="zcPrice"><span>筹到' . $activity['collect'].'<i>元</i></span><span></span><!--<span></span>--></p><div class="progressBar"><span><i style="width:' . $per . '%"></i></span><small>已完成' . $per . '%</small></div></a><i class="tipOn ' . $model . '">众筹</i></li>';
				} else if ($model == 'unitary') {
					// 夺宝
					$product = D('Product')->where("product_id='" . $activity['product_id'] . "'")->find();
					
					$unitary_person = D('Unitary_lucknum')->where(array('id' => $activity['id']))->count('id');
					$images = getAttachmentUrl($product['image']);
					
					$per = round($unitary_person / $activity['total_num'] * 100, 2);
					$html .= '<li class="swiper-slide"><a href="' . option('config.site_url') . '/webapp/snatch/#/main/' . $activity['id'] . '"><img src="' . $images . '"><h3>' . $activity['name'] . '</h3><p class="zcPrice"><span>' . $activity['item_price'].'<i>元夺宝</i></span><span></span><span>' . $product['price'].'元</span></p><div class="progressBar"><span><i style="width:' . $per . '%"></i></span><small>已完成' . $per . '%</small></div></a><i class="tipOn ' . $model . '">夺宝</i></li>';
				} else if ($model == 'cutprice') {
					if ($activity['state'] != 0 || $activity['endtime'] < time()) {
						$this->closeActivity($activity_recommend['id']);
						continue;
					}
					
					// 降价拍
					$product = D('Product')->where(array('product_id' => $activity['product_id']))->field('product_id,name,image,info')->find();
					$images = getAttachmentUrl($product['image']);
					
					$cha = time() - $activity['starttime'];
					$activity['nowprice'] = $activity['startprice'];
					if($cha > 0){
						$chaprice = (floor($cha / 60 / $activity['cuttime'])) * $activity['cutprice'];
						if($activity['inventory'] > 0 && ($activity['startprice'] - $chaprice) > $activity['stopprice']){
							$activity['nowprice'] = $activity['startprice'] - $chaprice;
						}
					}
					
					// 已有多少人参与
					$part_in = D('Cutprice_record')->where(array('cutprice_id' => $activity['pigcms_id']))->count('id');
					$html .= '<li class="swiper-slide"><a href="' . option('config.wap_site_url') . '/cutprice.php?action=detail&id=' . $activity['pigcms_id'] . '&store_id=' . $activity['store_id'] . '"><img src="' . $images . '"/><h3>' . $activity['active_name'] . '</h3><p><span>' . $activity['nowprice'].'<i>元</i></span><span>原价' . $activity['original'].'元</span></p><div class="time">已有' . $part_in . '人参与</div></a><i class="tipOn ' . $model . '">降价拍</i></li>';
				}
				
				$i++;
				if ($i > $num) {
					break;
				}
			}
			
			if ($i > $num) {
				break;
			}
			
			// 禁止无限查询太多，导致耗资源
			if ($page > 5) {
				break;
			}
		}
		
		return $html;
	}
	
	public function getActivity($type, $num = 10, $page = 1, $ext = '') {
		$page = max(1, $page);
		$offset = ($page - 1) * $num;
		
		$where = array();
		$where['status'] = 0;
		if (is_array($type)) {
			$where = array_merge($where, $type);
		} else if (!empty($type)) {
			$where['model'] = $type;
		}

		if ($ext) {
			$where['_string'] = "($ext)";
		}

		$activity_recommend_list = D('Activity_recommend')->where($where)->limit($offset . ', ' . 10)->order('is_rec DESC, id DESC')->select();
		
		return $activity_recommend_list;
	}
	
	// 活动过期时直接关闭
	public function closeActivity($id) {
		$this->db->where(array('id' => $id))->data(array('status' => 1))->save();
	}
}