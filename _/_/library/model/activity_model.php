<?php
class activity_model extends base_model{

	public function getActivity($type, $num = 10 ,$ext = ''){
		$activity_table_arr = array(
				'tuan' => array('Tuan', "id = '#'"),
				'presale' => array('Presale', "id = '#'"),
				'bargain' => array('Bargain', "pigcms_id = '#'"),
				'seckill' => array('Seckill', "pigcms_id = '#'"),
				'crowdfunding' => array('Zc_product', "product_id = '#'"),
				'unitary' => array('Unitary', "id = '#'"),
				'cutprice' => array('Cutprice', "pigcms_id = '#'")
		);
		
		$activity_recommend_mode = M('Activity_recommend');
		$page = 1;
		$i = 0;
		
		$activity_list = array();
		while(true) {
			$activity_recommend_list = $activity_recommend_mode->getActivity($type, $num, $page, $ext);
			
			if (empty($activity_recommend_list)) {
				break;
			}
			
			foreach ($activity_recommend_list as $activity_recommend) {
				$tmp = array();
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
						$activity_recommend_mode->closeActivity($activity_recommend['id']);
						continue;
					}
					
					if ($activity['start_time'] > time()) {
						continue;
					}
					
					// 团购
					$product = D('Product')->where("product_id='" . $activity['product_id'] . "'")->find();
					if (empty($product) || $product['status'] != 1) {
						$activity_recommend_mode->closeActivity($activity_recommend['id']);
						continue;
					}
					
					//$tuan_person = M('Order')->getActivityOrderCount(6, $activity['id']);
					$images = getAttachmentUrl($product['image']);
					
					$tmp['qcode'] = option('config.site_url') . '/source/qrcode.php?type=tuan&id=' . $activity['id'];
					$tmp['id'] = $activity['id'];
					$tmp['name'] = $activity['name'];
					$tmp['intro'] = str_replace(array('"', "'"), '', $activity['description']);
					$tmp['image'] = $images;
					$tmp['count'] = $activity['count'];
					$tmp['time'] = $activity['dateline'];
					$tmp['typename'] = '拼团';
					$tmp['wap_url']  = option('config.site_url') . '/webapp/groupbuy/#/details/' . $activity['id'];
					
					$activity_list[] = $tmp;
				} else if ($model == 'presale') {
					if ($activity['endtime'] < time() || $activity['is_open'] == 0) {
						$activity_recommend_mode->closeActivity($activity_recommend['id']);
						continue;
					}
					
					// 预售
					$product = D('Product')->where("product_id='" . $activity['product_id'] . "'")->find();
					$order_count = M('Order')->getActivityOrderCount(6, $activity['id']);
					$images = getAttachmentUrl($product['image']);
					
					$tmp['qcode'] = option('config.site_url') . '/source/qrcode.php?type=presale&id=' . $activity['id'];
					$tmp['id'] = $activity['id'];
					$tmp['name'] = $activity['name'];
					$tmp['intro'] = str_replace(array('"', "'"), '', $activity['description']);
					$tmp['image'] = $images;
					$tmp['count'] = $order_count;
					$tmp['time'] = $activity['timestamp'];
					$tmp['typename'] = '预售';
					$tmp['wap_url']  = option('config.wap_site_url') . '/presale.php?id='. $activity['id'];
					
					$activity_list[] = $tmp;
				} else if ($model == 'bargain') {
					if ($activity['delete_flag'] == 1 || $activity['state'] == 0) {
						$activity_recommend_mode->closeActivity($activity_recommend['id']);
						continue;
					}
					
					// 砍价
					$product = D('Product')->where("product_id='" . $activity['product_id'] . "'")->find();
					$images = getAttachmentUrl($product['image']);
					
					$bargain_person = D('Bargain_kanuser')->where(array('bargain_id' => $activity['pigcms_id']))->count("pigcms_id");
					
					$tmp['qcode'] = option('config.site_url') . '/source/qrcode.php?type=bargain&id=' . $activity['pigcms_id'] . '&store_id=' . $activity['store_id'];
					$tmp['id'] = $activity['pigcms_id'];
					$tmp['name'] = $activity['name'];
					$tmp['intro'] = str_replace(array('"', "'"), '', $activity['info']);
					$tmp['image'] = $images;
					$tmp['count'] = $bargain_person;
					$tmp['time'] = $activity['addtime'];
					$tmp['typename'] = '砍价';
					$tmp['wap_url']  = option('config.wap_site_url') . '/bargain.php?action=detail&id=' . $activity['pigcms_id'] . '&store_id=' . $activity['store_id'];
					
					$activity_list[] = $tmp;
				} else if ($model == 'seckill') {
					if ($activity['delete_flag'] == 1 || $activity['status'] == 2) {
						$activity_recommend_mode->closeActivity($activity_recommend['id']);
						continue;
					}
					// 秒杀
					$product = D('Product')->where(array('product_id' => $activity['product_id']))->find();
					$images = getAttachmentUrl($product['image']);
						
					//秒杀价
					// $seckill_price = $activity['seckill_price'] ? $activity['seckill_price'] : $product['product_price'];
					$seckill_persons = D('Seckill_user')->where(array('seckill_id' => $activity['pigcms_id']))->count('pigcms_id');
					
					$tmp['qcode'] = option('config.site_url') . '/source/qrcode.php?type=seckill&id=' . $activity['pigcms_id'];
					$tmp['id'] = $activity['pigcms_id'];
					$tmp['name'] = $product['name'];
					$tmp['intro'] = '';
					$tmp['image'] = $images;
					$tmp['count'] = $seckill_persons;
					$tmp['time'] = $activity['add_time'];
					$tmp['typename'] = '秒杀';
					$tmp['wap_url']  = option('config.wap_site_url') . '/seckill.php?seckill_id=' . $activity['pigcms_id'];

					$activity_list[] = $tmp;
				} else if ($model == 'crowdfunding') {
					if ($activity['endtime'] < time()) {
						//$activity_recommend_mode->closeActivity($activity_recommend['id']);
						//continue;
					}
					// 众筹
					$images = getAttachmentUrl($activity['productImageMobile']);
					
					$tmp['qcode'] = option('config.site_url') . '/source/qrcode.php?type=crowdfunding&id=' . $activity['product_id'];
					$tmp['id'] = $activity['product_id'];
					$tmp['name'] = $activity['productName'];
					$tmp['intro'] = str_replace(array('"', "'"), '', $activity['productSummary']);
					$tmp['image'] = $images;
					$tmp['count'] = $activity['people_number'];
					$tmp['time'] = $activity['add_time'];
					$tmp['typename'] = '众筹';
					$tmp['wap_url']  = option('config.site_url') . '/webapp/chanping/index.html#/view/' . $activity['product_id'];
					
					$activity_list[] = $tmp;
				} else if ($model == 'unitary') {
					// 夺宝
					$product = D('Product')->where("product_id='" . $activity['product_id'] . "'")->find();
						
					$unitary_person = D('Unitary_lucknum')->where(array('id' => $activity['id']))->count('id');
					$images = getAttachmentUrl($product['image']);
					
					$tmp['qcode'] = option('config.site_url') . '/source/qrcode.php?type=unitary&id=' . $activity['id'];
					$tmp['id'] = $activity['id'];
					$tmp['name'] = $activity['name'];
					$tmp['intro'] = str_replace(array('"', "'"), '', $activity['descript']);
					$tmp['image'] = $images;
					$tmp['count'] = $unitary_person;
					$tmp['time'] = $activity['addtime'];
					$tmp['typename'] = '夺宝';
					$tmp['wap_url']  = option('config.site_url') . '/webapp/snatch/#/main/' . $activity['id'];
					
					$activity_list[] = $tmp;;
				} else if ($model == 'cutprice') {
					if ($activity['state'] != 0 || $activity['endtime'] < time()) {
						$activity_recommend_mode->closeActivity($activity_recommend['id']);
						continue;
					}
					
					// 降价拍
					$product = D('Product')->where(array('product_id' => $activity['product_id']))->field('product_id,name,image,info')->find();
					$images = getAttachmentUrl($product['image']);
				
					// 已有多少人参与
					$part_in = D('Cutprice_record')->where(array('cutprice_id' => $activity['pigcms_id']))->count('id');
					
					$tmp['qcode'] = option('config.site_url') . '/source/qrcode.php?type=cutprice&id=' . $activity['pigcms_id'] . '&store_id=' . $activity['store_id'];
					$tmp['id'] = $activity['pigcms_id'];
					$tmp['name'] = $activity['active_name'];
					$tmp['intro'] = '';
					$tmp['image'] = $images;
					$tmp['count'] = $part_in;
					$tmp['time'] = $activity['addtime'];
					$tmp['typename'] = '降价拍';
					$tmp['wap_url']  = option('config.wap_site_url') . '/cutprice.php?action=detail&store_id=' . $activity['store_id'] . '&id=' . $activity['pigcms_id'];
					
					$activity_list[] = $tmp;
				}
				
				$i++;
				if ($i >= $num) {
					break;
				}
			}
			
			if ($i >= $num) {
				break;
			}
			
			$page++;
			// 禁止无限查询太多，导致耗资源
			if ($page > 5) {
				break;
			}
			
			// 没有过多数据时，直接跳出
			if (count($activity_recommend_list) < $num) {
				break;
			}
		}
		
		return $activity_list;
		
		
		
		
		
		
		
		
		
		$data = D('Activity_recommend')->where("model='$type'")->order('id DESC')->limit($num)->select();
		
		
		

		$res  	= array();
		
		foreach ($data as $key => $value) {
			$res[$key]['typename'] 	= $this->getTypeName($value['model']);
			$res[$key]['id'] 		= $value['id'];
			$res[$key]['name'] 		= $value['title'];
			$res[$key]['intro'] 	= array_pop(preg_split('/\r\n/',$value['info']));
			$res[$key]['token'] 	= $value['token'];
			$res[$key]['image'] 	= $value['image'];
			$res[$key]['count'] 	= $value['ucount'];
			$res[$key]['appurl'] 	= $this->createUrl($value,$type);
			//本地化$res[$key]['qcode'] 	=  $value['qcode']?getAttachmentUrl($value['qcode']):'./source/qrcode.php?type=activity&id=no&url='.$res[$key]['appurl'];
			$res[$key]['qcode'] 	=  $value['qcode']?$value['qcode']:'./source/qrcode.php?type=activity&id=no&url='.$res[$key]['appurl'];//微信端
			$res[$key]['modelId'] 	= $value['modelId'];
			$res[$key]['time'] 	= $value['time'];
		}

		return $res;

	}

	public function getHotActivity($num,$type="",$rank=""){
		$where 	= "is_rec=1";
		if($type != ''){
			$where	 .= " AND model='$type'";
			$order  = 'id DESC';
		}
		if($rank){
			$order 	= 'ucount DESC';
		}else{
			$order  = 'id DESC';
		}
		$data 	= D('Activity_recommend')->where($where)->order($order)->limit($num)->select();

		$res  	= array();
		
		foreach ($data as $key => $value) {
			$res[$key]['typename'] 	= $this->getTypeName($value['model']);
			$res[$key]['id'] 		= $value['id'];
			$res[$key]['name'] 		= $value['title'];
			$res[$key]['intro'] 	= array_pop(preg_split('/\r\n/',$value['info']));
			$res[$key]['token'] 	= $value['token'];
			$res[$key]['image'] 	= $value['image'];
			$res[$key]['count'] 	= $value['ucount'];
			$res[$key]['appurl'] 	= $this->createUrl($value,$type);
			//本地化$res[$key]['qcode'] 	=  $value['qcode']?getAttachmentUrl($value['qcode']):'./source/qrcode.php?type=activity&id=no&url='.$res[$key]['appurl'];
			$res[$key]['qcode'] 	=  $value['qcode']?$value['qcode']:'./source/qrcode.php?type=activity&id=no&url='.$res[$key]['appurl'];//微信端
			$res[$key]['modelId'] 	= $value['modelId'];
			$res[$key]['time'] 	= $value['time'];
		}

		return $res;
	}

	public function getTypeName($model){
		$array 	= array(
			'bargain'		=> '超级砍价',
			'seckill'		=> '极限秒杀',
			'crowdfunding'	=> '众筹',
			'unitary'		=> '一元夺宝',
			'cutprice'		=> '降价拍',
			'red_packet'	=> '红包',
		);
		return $array[$model];
	}

	// 获取有订单的活动数组
	public function getOrderArr(){
		$models = array(
            '6'  => '团购',
            '7'  => '预售',
			'50' => '超级砍价',
			'51' => '一元夺宝',
			'53' => '秒杀',
			'55' => '降价拍',
			'56' => '抽奖合集',
			'57' => '摇一摇',
			'58' => '微助力'
		);
		return $models;
	}

	// 输出新订单 html tag
	public function getOrderTag ($type) {

		$actArray = $this->getOrderArr();
		$className = '';
		switch ($type) {
			case '50':
				$className = 'bargain';
				break;
			
			case '51':
				$className = 'unitary';
				break;

			case '53':
				$className = 'seckill';
				break;

			case '55':
				$className = 'cutprice';
				break;

			case '56':
				$className = 'lottery';
				break;

			case '57':
				$className = 'shakelottery';
				break;

			case '58':
				$className = 'helping';
				break;

			default:
				return '';
				break;
		}

		$tag = '<span class="activity-tag '.$className.'">'.$actArray[$type].'</span>';
		return $tag;

	}
	
	//生成 url
	public function createUrl($val,$type,$trueurl=0){
		
		$activity_url 	= option('config.syn_domain') ? rtrim(option('config.syn_domain'),'/').'/' : 'http://demo.pigcms.cn/';

		if($type == 'unitary'){
			$url 	= $activity_url.'/index.php?g=Wap&m='.ucfirst($val['model']).'&a=goods&token='.$val['token'].'&unitaryid='.$val['modelId'];
		}else if($type == 'cutprice'){
			$url 	= $activity_url.'/index.php?g=Wap&m='.ucfirst($val['model']).'&a=goods&token='.$val['token'].'&id='.$val['modelId'];
		}else{
			$url 	= $activity_url.'/index.php?g=Wap&m='.ucfirst($val['model']).'&a=index&token='.$val['token'].'&id='.$val['modelId'];
		}

		if($trueurl){
			return $url;
		}else{
			return urlencode($url);
		}
	}

	/**
	 * [getActivityDetail 接口调取微信营销详细信息/实时获取]
	 * @param    [int] $activity_id activity_recommend表id
	 * @return   [arr] $caRow [活动详细信息]
	 * @Auther   pigcms_89
	 * @DateTime 2015-12-16T14:31:10+0800
	 */
	public function getActivityDetail($activity_id){

		$apiUrl = option('config.syn_domain');
        $salt = option('config.encryption') ? option('config.encryption') : 'pigcms';
        $title_array = array('crowdfunding' => '众筹', 'seckill_action' => '秒杀', 'unitary' => '一元夺宝', 'bargain' => '砍价', 'cutprice' => '降价拍', 'lottery' => '抽奖专场');

        $caRow = D('Activity_recommend')->where(array('id'=>$activity_id))->find();

        $type_array = array('crowdfunding' => '众筹', 'seckill_action' => '秒杀', 'unitary' => '一元夺宝', 'bargain' => '砍价', 'cutprice' => '降价拍', 'Lottery' => '大转盘', 'Guajiang' => '刮刮卡', 'Coupon' => '优惠券', 'LuckyFruit' => '水果机','GoldenEgg' => '砸金蛋', 'Research' => '微调研', 'AppleGame' => '走鹊桥', 'Lovers' => '摁死情侣', 'Autumn' => '吃月饼', 'Jiugong' => '九宫格');
        $now = time();
        $time = intval($caRow['endtime']) - $now;
		$caRow['endtime'] =  $time > 0 ? $time : 0;
        switch ($caRow['model']) {
        	case 'crowdfunding': //众筹 >
        		$caRow['percent'] = '0%'; 
				$whereCrowdfunding = array(
						'where'=>array(
								'token' => $caRow['token'], 
								'id' => $caRow['modelId'],
							),
						'order' => 'id DESC',
						'limit' => '0,1',
						);

				$crowdfunding = $this->curlModelGet('crowdfunding', $whereCrowdfunding, 'find');
				if (!empty($crowdfunding)) {
					$caRow['price'] = $crowdfunding['fund'];
					$caRow['original_price'] = 0;
					$caRow['price_count'] = $this->getOrderCount($caRow['token'], $caRow['modelId'], 1);
					$caRow['balance'] = $crowdfunding['fund'] - $caRow['price_count'];
					if($crowdfunding['max'] != 0){
						$crowdfunding['fund'] = $crowdfunding['fund'] * ($crowdfunding['max'] / 100);
						$caRow['balance'] = $caRow['balance'] > 0 ? $caRow['balance'] : ($crowdfunding['fund'] - $caRow['price_count']);
					}
					$progress = $crowdfunding['fund'] ? sprintf('%.2f%%', ($crowdfunding['price_count'] / $crowdfunding['fund']) * 100) : '100%';
					$caRow['percent'] = ($crowdfunding['price_count'] / $crowdfunding['fund']) > 1 ? '100%' : $progress;
				}
				
				$activeType = 'crowdfunding';
				$caRow['table_name'] = $activeType;
				$caRow['actname'] = isset($type_array[$activeType]) ? $type_array[$activeType] : $type_array[$caRow['table_name']];
				$caRow['joinurl'] = $this->createUrl($caRow, $caRow['model'], true);
        		break;
        	case 'seckill':	//秒杀 >

        		$whereShopTmp = array(
                        'order' => 'shop_id DESC',
                        'where' => array(
                                'shop_open' => 0,
                                'action_id' => $caRow['modelId'],
                            ),
                        'limit' => '0,1',
                    );
                $shops = $this->curlModelGet('seckillBaseShop', $whereShopTmp, 'select');
                $caRow['title'] = isset($shops[0]['shop_name']) ? $shops[0]['shop_name'] : $caRow['title'];
                $caRow['price'] = isset($shops[0]['shop_price']) ? $shops[0]['shop_price'] : 0;

        		$activeType = 'seckill_action';
				$caRow['table_name'] = $activeType;
				$caRow['actname'] = isset($type_array[$activeType]) ? $type_array[$activeType] : $type_array[$caRow['table_name']];
        		$caRow['joinurl'] = $this->createUrl($caRow, $caRow['model'], true);
        		break;
        	case 'unitary': //一元夺宝 >

				$where_unitary = array(
						'where' => array('id' => $caRow['modelId']),
						'order' => 'id DESC',
						'limit' => '0,1',
					);
				$unitary = $this->curlModelGet('unitary', $where_unitary, 'find');
				if (!empty($unitary)) {
					$caRow['original_price'] = $caRow['price'] = $unitary['price'];
					$caRow['endtime'] = $unitary['endtime'];
				}

				$where_lucknum_paycount = array(
						'token' => $caRow['token'],
						'unitary_id' => $caRow['modelId'],
					);
				// $caRow['price_count'] = $pay_count = M("unitary_lucknum")->count($where_lucknum_paycount);
				$whereLucknum = array(
						'where' => $where_lucknum_paycount,
					);
				$peyCountResult = $this->curlModelGet('unitaryLucknum', $whereLucknum, 'count');
				$caRow['price_count'] = $pay_count = $peyCountResult['count'];
				$caRow['balance'] = $caRow['price'] - $pay_count;
				$caRow['percent'] = sprintf('%.2f%%', ($pay_count/$caRow['original_price']) * 100);

				$activeType = 'unitary';
				$caRow['table_name'] = $activeType;
				$caRow['actname'] = isset($type_array[$activeType]) ? $type_array[$activeType] : $type_array[$caRow['table_name']];
				$caRow['joinurl'] = $this->createUrl($caRow, $caRow['model'], true);
        		break;
			case 'bargain':	//砍价 >

				$where_bargain = array(
					'where'=>array(
							'pigcms_id' => $caRow['modelId']
						),
					'order' => 'pigcms_id DESC',
					'limit' => '0,1',
					);
				$bargain = $this->curlModelGet('bargain', $where_bargain, 'find');
				if (!empty($bargain)) {
					$caRow['price'] = $bargain['minimum'];
					$caRow['original_price'] = $bargain['original'];
				}

				$where_kanuser = array('where'=>array(
						'token' => $caRow['token'],
						'bargain_id' => $caRow['modelId'],
					));
				$joinResult = $this->curlModelGet('bargainKanuser', $where_kanuser, 'count');

				$activeType = 'bargain';
				$caRow['table_name'] = $activeType;
				$caRow['actname'] = isset($type_array[$activeType]) ? $type_array[$activeType] : $type_array[$caRow['table_name']];
				$caRow['joincount'] = $joinResult['count'];
				$caRow['joinurl'] = $this->createUrl($caRow, $caRow['model'], true);
				break;
			case 'cutprice': //降价拍 >

				$where_cutprice = array(
						'where' => array(
								'pigcms_id' => $caRow['modelId'],
							),
						'order' => 'pigcms_id DESC',
						'limit' => '0,1',
					);
				$cutprice = $this->curlModelGet('cutprice', $where_cutprice, 'find');
				if (!empty($cutprice)) {
					$caRow['price'] = $cutprice['stopprice'];
					$caRow['original_price'] = $cutprice['original'];
				}

				$where_order['token'] = $caRow['token'];
				$where_order['cid'] = $caRow['modelId'];
				// $caRow['joincount'] = M("cutprice_order")->count($where_order);
				$whereOrder = array(
						'where' => $where_order,
					);
				$joinCountResult = $this->curlModelGet('cutpriceOrder', $whereOrder, 'count');
				if (!empty($joinCountResult)) {
					$caRow['joincount'] = $joinCountResult['count'];
				}

				$activeType = 'cutprice';
				$caRow['table_name'] = $activeType;
				$caRow['actname'] = isset($type_array[$activeType]) ? $type_array[$activeType] : $type_array[$caRow['table_name']];
				$caRow['joinurl'] = $this->createUrl($caRow, $caRow['model'], true);
				break;
			case 'lottery':

				$where_lottery = array(
						'where' => array(
								'id' => $caRow['modelId'],
							),
						'order' => 'id DESC',
						'limit' => '0,1',
					);
				$lottery = $this->curlModelGet('lottery', $where_lottery, 'find');
				if (!empty($lottery)) {
					$caRow['price'] = $lottery['fist'];
				}

				$caRow['original_price'] = 0;
				$activeType = 'Lottery';
				$caRow['table_name'] = $activeType;
				$caRow['actname'] = isset($type_array[$activeType]) ? $type_array[$activeType] : $type_array[$caRow['table_name']];
				$caRow['joinurl'] = $this->createUrl($caRow, $caRow['model'], true);
				break;
			case 'guajiang':
				$where_lottery = array(
						'where' => array(
								'id' => $caRow['modelId'],
							),
						'order' => 'id DESC',
						'limit' => '0,1',
					);
				$lottery = $this->curlModelGet('guajiang', $where_lottery, 'find');
				if (!empty($lottery)) {
					$caRow['price'] = $lottery['fist'];
				}

				$caRow['original_price'] = 0;

				$caRow['table_name'] = 'Guajiang';
				$caRow['actname'] = isset($type_array[$activeType]) ? $type_array[$activeType] : $type_array[$caRow['table_name']];
				$caRow['joinurl'] = $this->createUrl($caRow, $caRow['model'], true);
				break;
			case 'jiugong':
				$where_lottery = array(
						'where' => array(
								'id' => $caRow['modelId'],
							),
						'order' => 'id DESC',
						'limit' => '0,1',
					);
				$lottery = $this->curlModelGet('jiugong', $where_lottery, 'find');
				if (!empty($lottery)) {
					$caRow['price'] = $lottery['fist'];
				}

				$caRow['original_price'] = 0;

				$caRow['table_name'] = 'Jiugong';
				$caRow['actname'] = isset($type_array[$activeType]) ? $type_array[$activeType] : $type_array[$caRow['table_name']];
				$caRow['joinurl'] = $this->createUrl($caRow, $caRow['model'], true);
				break;
			case 'luckyFruit':
				$where_lottery = array(
						'where' => array(
								'id' => $caRow['modelId'],
							),
						'order' => 'id DESC',
						'limit' => '0,1',
					);
				$lottery = $this->curlModelGet('luckyFruit', $where_lottery, 'find');
				if (!empty($lottery)) {
					$caRow['price'] = $lottery['fist'];
				}
				
				$caRow['original_price'] = 0;

				$caRow['table_name'] = 'LuckyFruit';
				$caRow['actname'] = isset($type_array[$activeType]) ? $type_array[$activeType] : $type_array[$caRow['table_name']];
				$caRow['joinurl'] = $this->createUrl($caRow, $caRow['model'], true);
				break;
			case 'goldenEgg':
				$where_lottery = array(
						'where' => array(
								'id' => $caRow['modelId'],
							),
						'order' => 'id DESC',
						'limit' => '0,1',
					);
				$lottery = $this->curlModelGet('goldenEgg', $where_lottery, 'find');
				if (!empty($lottery)) {
					$caRow['price'] = $lottery['fist'];
				}

				$caRow['original_price'] = 0;

				$caRow['table_name'] = 'GoldenEgg';
				$caRow['actname'] = isset($type_array[$activeType]) ? $type_array[$activeType] : $type_array[$caRow['table_name']];
				$caRow['joinurl'] = $this->createUrl($caRow, $caRow['model'], true);
				break;
        }

        return $caRow;

	}

	private function curlModelGet($model, $condition, $method='select') {

        $apiUrl = option('config.syn_domain');
        $salt = option('config.encryption') ? option('config.encryption') : 'pigcms';

     //    if ($method == 'find') {
     //    	$condition = array_merge($condition, array(
					// 	'order' => 'id DESC',
					// 	'limit' => '0,1',
					// ));
     //    }

        if ($method == 'count') {
        	$curlUrl = $apiUrl.'/index.php?g=Home&m=Auth&a=count';

        } else {
	        $curlUrl = $apiUrl.'/index.php?g=Home&m=Auth&a=select';

        }
        
        $post = array(
	            'option' => $condition,
	            'model' => ucfirst($model),
	            'debug' => true,
	        );
        $post['sign'] = $this->getSign($post, $salt);
        $result = $this->api_curl_post($curlUrl, $post);

        if ($result['status'] == 0 && $result['data'] != null) {
        	if ($method == 'find') {
        		return isset($result['data'][0]) ? $result['data'][0] : array() ;
        	}
            return $result['data'];
        } else {
            return array();
        }
    }

	private function getSign($data, $salt) {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $validate[$key] = $this->getSign($value, $salt);
            } else {
                $validate[$key] = $value;
            }
        }
        $validate['salt'] = $salt;
        sort($validate, SORT_STRING);
        return sha1(implode($validate));
    }

	/**
     * 微信API CURL POST
     *
     * param url 抓取的URL
     * param data post的数组
     */
    private function api_curl_post($url, $data) {
        $result = $this->post($url, $data);

        $result_arr = json_decode($result, true);

        return $result_arr;
    }

    private function post($url, $post) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // post数据
        curl_setopt($ch, CURLOPT_POST, true);
        // post的变量
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        $result = curl_exec($ch);
        curl_close($ch);
        //返回获得的数据
        return $result;
    }

    // 获取众筹数量，总价
    private function getOrderCount($token, $pid = 0, $type = '')
    {
    	$where 	= array('token' => $token, 'paid' => '1');
    	$pid &&	$where['pid'] = $pid;
    	$count = 0;
    	if (empty($type)) {
    		$wherePeople = array(
				'where' => array(
					'token' => $token, 
					'paid' => '1'
				)
			);
    		// $people = M('crowdfunding_order')->count($where);
    		$people = $this->curlModelGet('crowdfunding_order', $wherePeople, 'count');
    		if ($people) {
    			$count = $people;
    		}
    	} else {
    		// $price 	= M('crowdfunding_order')->get_one($where, "SUM(price) AS total_price");
    		$wherePeople = array(
    			'field' => "SUM(price) AS total_price",
				'where' => array(
					'token' => $token, 
					'paid' => '1',
				),
			);
    		$price = $this->curlModelGet('crowdfunding_order', $wherePeople, 'select');
    		if (isset($price['total_price'])) {
    			$count = $price['total_price'];
    		}
    	}
    	return $count;
    }

}