<?php
class index_controller extends base_controller{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function index() {
		if(is_mobile()){
			redirect($this->config['wap_site_url']);
		}
		
		$index_cache = $this->config['web_index_cache'];

		if ($index_cache > 0) {
			$content = S('index');
			if ($content) {
			//	echo $content;
			//	exit;
			}
		}
		//幻灯广告位
		$adList = M('Adver')->get_adver_by_key('pc_index_slide',6);
		//幻灯片右侧广告位
		$adList_right = M('Adver')->get_adver_by_key('pc_index_slide_right',1);
		//获取您周边店铺数量
		$WebUserInfo = $this->user_location;
		if($WebUserInfo['long'] && $WebUserInfo['lat']) {
			$nearshop_count = M('Store')->nearshop_count($WebUserInfo['long'],$WebUserInfo['lat'],10);
		} else{
			$nearshop_count = 0;
		}
		$this->assign('nearshop_count', $nearshop_count);
		
		// 活动广告
		$ad_activity_list = M('Adver')->get_adver_by_key('pc_index_activity', 6);
		$this->assign('ad_activity_list', $ad_activity_list);
		
		//店铺数 分销商数
		$common_data_arr = D('Common_data')->where("`key` in('store_qty','drp_seller_qty')")->select();
		foreach($common_data_arr as $data) {
			$common_data[$data['key']] = $data;
		}

		//热卖商品 (目前获取id 最优先的)
		//加载产品类别
		$db_product_category = M('Product_category');
		$hot_products['category'] =  $db_product_category->getAllCategory(6);
		$order_by_field = "sales";
		$order_by_method = "desc";

		//默认
		$hot_products['product'] = M('Product')->getSellingAndDistance_new($where, $order_by_field, $order_by_method, 0, 10);
		
		// 积分赠送
		import('source.class.Margin');
		$open_margin_recharge = Margin::check();
		$credit_setting = D('Credit_setting')->find();
		$platform_credit_name = $credit_setting['platform_credit_name'] ;
		$platform_credit_name = $platform_credit_name ? $platform_credit_name : "平台币";
		
		
		
		if(is_array($hot_products['product'])) {
			foreach($hot_products['product'] as $k => &$v) {
				$wheres = array(
						'ss.supplier_id' => $v['store_id'],
						's.status' => array('>',0),
				);
				$count_user1 = M('Store_supplier')->seller_count($wheres);
					
				$sellerList =M('Store_supplier')->getNextSellers($v['store_id'], 'all');
				if (count($sellerList) > 0) {
					$sellerIdLists = array();
					foreach ($sellerList as $sellerId) {
						$sellerIdLists[] = $sellerId['seller_id'];
					}
	
					$sellerIdList = rtrim(implode(',', $sellerIdLists), ',');
				}
				if($sellerIdList) {
					$where1['ss.supplier_id'] = array ('in' => $sellerIdList);
					$count_user2 = M('Store_supplier')->seller_count($where1);
				} else {
					$count_user2 = "0";
				}
				$count_user = $count_user1 + $count_user2;
				$v['drp_seller_qty'] = $count_user;
			}
		}
		
		 //平台在售商品
		 $selling_product_count = F('selling_product_count');
		 if(empty($selling_product_count)) {
			$selling_product_count = D('Product')->where(array('status' => 1))->count('product_id');
			 F('selling_product_count', $selling_product_count);
		 }
		 if($selling_product_count >= 10000) {
			$selling_product_count = sprintf('%.1f',$selling_product_count/10000).'k';
		 }		 
		$this->assign('selling_product_count',$selling_product_count);      		//平台在售商品
		
		
		//周边店铺
		//模拟用户坐标  117.22895,31.866208
		$cookie_location = show_distance();
		if($cookie_location['long']) {
			$long = $cookie_location['long'];
			$lat = $cookie_location['lat'];
			$nearshops = M('Store_contact')->nearshops($long,$lat,'10');

		} else {
			//任意抽取10个
			$orderby = "`s`.`collect` desc";
			//$nearshops	= M('Store')->getlist(array('`s`.`status`'=>1,'`s`.`public_display`'=>1,'`s`.`drp_supplier_id`'=>0),$orderby,10);
			$nearshops	= M('store')->getList_new("`s`.`is_point_mall`=0 and `s`.`status`=1 and `s`.`public_display`=1 and `s`.`drp_supplier_id`=0 ",$orderby,10);
		}
		
		
		//热门品牌类别
		$hot_brand['type'] = M('Store_brand_type')->getBrandTypeList();
		//默认热门品牌
		$hot_brand['brand'] = M('Store_brand')->getList(array('status'=>1),'','10');
		$test = array(0,3); $i = rand(0,1);
		$hot_brand['rand'] = $test[$i];

		//评论晒单
		$comment = M('Comment_attachment')->getSimpleList("12");

		//优质分销商品
		$excellfx = M('Product')->getExcellentFx_new(0,8);

		//分销动态
		$financiallist = M('Financial_record')->sns('',6);
		//dump($financiallist);
		$this->assign('adList',array_values($adList));      		//幻灯广告位
		$this->assign('adList_right', array_values($adList_right));	//幻灯片右侧广告位
		$this->assign('common_data',$common_data);					//公共数据读取
		$this->assign('hot_products',$hot_products);				//热门商品
		$this->assign('nearshops',$nearshops);						//周边店铺
		$this->assign('hot_brand',$hot_brand);						//热门品牌
		$this->assign('excellfx',$excellfx);						//优质分销商品
		$this->assign('financiallist',$financiallist);				//分销动态		
		$this->assign('comment',$comment);							//评论晒单
		$this->assign('open_margin_recharge',$open_margin_recharge);
		$this->assign('platform_credit_name',$platform_credit_name);
		
		$index_cache = $index_cache * 3600;

		$is_have_activity = $this->config['is_have_activity'];
		$this->assign('is_have_activity', $is_have_activity);
		if ($is_have_activity) {
			$unitary_list = M('Activity')->getActivity('unitary', 8);
			$tuan_list = M('Activity')->getActivity('tuan', 8);
			$presale_list = M('Activity')->getActivity('presale', 8);
			$zc_product_list = M('Activity')->getActivity('crowdfunding', 8);
			$cutprice_list = M('Activity')->getActivity('cutprice', 8);
			$seckill_list = M('Activity')->getActivity('seckill', 8);
			$bargain_list = M('Activity')->getActivity('bargain', 8);
			
			$this->assign('unitary_list', $unitary_list);
			$this->assign('tuan_list', $tuan_list);
			$this->assign('presale_list', $presale_list);
			$this->assign('zc_product_list', $zc_product_list);
			$this->assign('cutprice_list', $cutprice_list);
			$this->assign('seckill_list', $seckill_list);
			$this->assign('bargain_list', $bargain_list);
	
			$hot = M('Activity')->getActivity(array('is_rec' => 1), 5);
			$this->assign('hot',$hot);

			$rec = M('Activity')->getActivity(array('is_rec' => 1), 1);
			$this->assign('rec',$rec);
		}
		
		if ($index_cache <= 0) {
			$this->display();
		} else {
			ob_start();
			$this->display();
			$content = ob_get_clean();

			S('index', $content, $index_cache);
			echo $content;
		}

	}




			public function check_username() {
				
							$mobile = trim($_POST['mobile']);
								
							if(empty($mobile)) {
								echo json_encode(array('status' => '3', 'msg' => '手机号为空！'));
								exit;
							}
								
							if (!preg_match("/^1[3|5|7|8|9]{1}[0-9]{9}$/i", $mobile)) {
								echo json_encode(array('status' => '2', 'msg' => '该手机号不正确！'));
								exit;
							}
												
							$user = D('User')->where(array('phone'=>$mobile))->find();
							if($user) {
								echo json_encode(array('status' => '1', 'msg' => '对不起该手机号已存在！'));
								exit;
							}
								
					echo json_encode(array('status' => '-1'));
					exit;	
				}


	public function user() {
		if ($this->user_session) {
			$data = array();
			$data['nickname'] = $this->user_session['nickname'];
			$data['cart_number'] = $this->cart_number + 0;
			
			echo json_encode(array('status' => true, 'data' => $data));
			exit;
		}
		
		echo json_encode(array('status' => false));
		exit;
	}


//店铺名称唯一性检测
    public function storename_check() {
	
        $store =D('Store');

        $name = isset($_REQUEST['name']) ? trim($_REQUEST['name']) : '';
		
        $unique = $store->where(array('name' => $name, 'status' => 1))->count('store_id');
	
		if($unique){
        echo $unique;
		}else{
		 echo 2;
		}
        exit;
    }


//获取热卖商品数据
	function ajax_hot_product() {

		$catid_string = $_GET['cateIdstr']; //所在栏目顶级id
		if(!$catid_string) echo json_encode(array('status' => false));

		//二级分类 显示商品
		$catid_arr = explode(",",$catid_string);

		//分类 显示商品
		if (is_array($catid_arr)) {
			foreach ($catid_arr as $k1 => $v1) {
				$where1 = "(p.category_id ='".$v1."' or p.category_fid ='".$v1."') ";
				$order_by_field1 = "sales";
				$order_by_method1 = "desc";

				$pro['product'] = M('Product')->getSellingAndDistance_new($where1, $order_by_field1, $order_by_method1, 0, 10);
				
				foreach ($pro['product'] as $k => &$v) {
					$wheres = array(
						'ss.supplier_id' => $v['store_id'],
						's.status' => array('>',0),
					);
					$count_user1 = M('Store_supplier')->seller_count($wheres);
					
					$sellerList =M('Store_supplier')->getNextSellers($v['store_id'], 'all');
					if (count($sellerList) > 0) {
						foreach ($sellerList as $sellerId) {
							$sellerIdLists[] = $sellerId['seller_id'];
						}
					
						if(count($sellerIdLists)) $sellerIdList = rtrim(implode(',', $sellerIdLists), ',');
					}
					if($sellerIdList) {
						$where2['ss.supplier_id'] = array ('in' => $sellerIdList);
						$count_user2 = M('Store_supplier')->seller_count($where2);
					} else {
						$count_user2 = "0";
					}
					$count_user = $count_user1 + $count_user2;
					$v['drp_seller_qty'] = $count_user;
					
				}
				
				$louceng[$v1] = $pro;
			}
		}
		echo json_encode($louceng);exit;
	}


//获取热门品牌数据
	function ajax_hot_brand() {
		$typeid_string = $_GET['typeIdstr']; //所在栏目顶级id
		if(!$typeid_string) echo json_encode(array('status' => false));
		//  二级分类 显示商品
		$typeid_arr = explode(",",$typeid_string);

		//  分类 显示品牌
		if (is_array($typeid_arr)) {
			foreach ($typeid_arr as $k1 => $v1) {
				$where1 = "status = 1 and  (type_id ='".$v1."') ";

				$pro['brand'] = M('Store_brand')->getbrandList($where1,'', '', 0, 10);
				$test = array(0,3); $i = rand(0,1);
				$pro['rand'] = $test[$i];

				$louceng[$v1] = $pro;
			}
		}

		echo json_encode($louceng);exit;
	}


	// 根据百度获取位置
/* 	function ajax_loaction() {
		$WebUserInfo = show_distance();
		if($WebUserInfo['long']) {
			$xml_array=simplexml_load_file("http://api.map.baidu.com/geocoder?location={$WebUserInfo[lat]},{$WebUserInfo[long]}&output=xml&key=18bcdd84fae25699606ffad27f8da77b"); //将XML中的数据,读取到数组对象中
			
			foreach($xml_array as $tmp){
				$WebUserInfo['address'] = $tmp->formatted_address;
				$WebUserInfo['city'] =$tmp->addressComponent->city;
				
			}
			
			if (!empty($WebUserInfo['address'])) {
				echo json_encode(array('status' => true, 'msgAll'=>$WebUserInfo['address'],'city'=> msubstr($WebUserInfo['city'],0,8,'utf-8') ,'msg' => msubstr($WebUserInfo['address'],0,8,'utf-8')));
				exit;
			} else {
				echo json_encode(array('status' => false));
				exit;
			}
		} else {
			echo json_encode(array('status' => false));
			exit;
		}
	} */
	
	// 根据百度获取位置	
	function ajax_loaction() {
		$WebUserInfo = show_distance();
		if($WebUserInfo['long']) {
			$xml_array=simplexml_load_file("http://api.map.baidu.com/geocoder?location={$WebUserInfo[lat]},{$WebUserInfo[long]}&output=xml&key=18bcdd84fae25699606ffad27f8da77b"); //将XML中的数据,读取到数组对象中
			
			$lbs_distance_limit = option("config.lbs_distance_limit");
			
			foreach($xml_array as $tmp){
				$WebUserInfo['address'] = $tmp->formatted_address;
				$WebUserInfo['city'] =$tmp->addressComponent->city;
			}
				
			if (!empty($WebUserInfo['address'])) {
				echo json_encode(array('status' => 1,'type'=>'location', 'msgAll'=>$WebUserInfo['address'],'city'=> msubstr($WebUserInfo['city'],0,8,'utf-8') ,'msg' => msubstr($WebUserInfo['address'],0,8,'utf-8')));
				exit;
			} else {
				echo json_encode(array('status' => 0));
				exit;
			}
		} else {
            if(isset($WebUserInfo['city_name'])&&isset($WebUserInfo['area_name'])) {
                echo json_encode(array('status' => 1,'type'=>'city','city'=>msubstr($WebUserInfo['area_name'],0,8,'utf-8'),'cityall'=>$WebUserInfo['area_name'],'ohter'=>$WebUserInfo));
                exit;
            }elseif($WebUserInfo['city_name']) {
				echo json_encode(array('status' => 1,'type'=>'city','city'=>msubstr($WebUserInfo['city_name'],0,8,'utf-8'),'cityall'=>$WebUserInfo['city_name'],'ohter'=>$WebUserInfo));
				exit;
			} else {
				echo json_encode(array('status' => 0));
			}
		}
	}
	
	//模拟数据
	public function set_location() {
		
		//116.331398,39.897445
		//117.22895,31.866208
		//写入cookie
		$cookie_arr = array(
				'long' => 117.22895,
				'lat' => 31.866208,
				'lbs_distance_limit'=> option("config.lbs_distance_limit")*2000,
				'timestamp' => time()
			);
		setcookie("Web_user", json_encode($cookie_arr), time() + 3600 * 24 * 365);		
	}

	
}
?>