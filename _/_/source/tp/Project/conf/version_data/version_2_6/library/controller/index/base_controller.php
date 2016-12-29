<?php

/**
 * 基础类
 *
 */
class base_controller extends controller {

    public $user_session;
    public $cart_number;

    public function __construct() {
        parent::__construct();
        $this->user_session = $_SESSION['user'];
        $this->assign('user_session', $_SESSION['user']);
		
        // 基类已经分类过此变量
        //$config = option('config');
        //$this->assign('config', $config);
        /**
         * 用F进行缓存时，后台更新此值，直接进行清空缓存
         */
        //获取导航 对此值进行文件缓存
        $navList = F('pc_slider_pc_nav');
        if (empty($navList)) {
            $navList = M('Slider')->get_slider_by_key('pc_nav', 7);
            F('pc_slider_pc_nav', $navList);
        }
        $this->assign('navList', $navList);      //导航栏目
        //获取热门搜索 对此值进行文件缓存
        $search_hot = F('pc_search_hot');
        if (empty($search_hot)) {
            $search_hot = D('Search_hot')->order("sort asc ,id desc")->limit(7)->select();
            F('pc_search_hot', $search_hot);
        }
        $this->assign('search_hot', $search_hot);

		
		//平台币 自定义
		$platform_credit_name = F('platform_credit_name');
		if(empty($platform_credit_name)){
			$credit_setting = D('Credit_setting')->find();
			$platform_credit_name = $credit_setting['platform_credit_name'] ;
			 F('platform_credit_name', $platform_credit_name);
		}
		$platform_credit_name = $platform_credit_name ? $platform_credit_name : "平台币";
		$this->assign('platform_credit_name',$platform_credit_name);	
		
		
        //公用头部右侧广告位 对此值进行文件缓存
        $public_top_ad = F('pc_adver_pc_index_top_right');
        if (empty($public_top_ad)) {
            $public_top_ad = M('Adver')->get_adver_by_key('pc_index_top_right', 1);
            F('pc_adver_pc_index_top_right', $public_top_ad);
        }
        $this->assign('public_top_ad', $public_top_ad[0]);

        // 购物内的数量
        //dump($this->user_session);
        $cart_number = 0;
        if (isset($this->user_session['uid'])) {
            $user_cart = D('User_cart')->where(array('uid' => $this->user_session['uid']))->field('sum(pro_num) as number')->find();
            $cart_number = $user_cart['number'];
        }

        $this->cart_number = $cart_number;
        $this->assign('cart_number', $cart_number);

        // 产品分类进行缓存
        $categoryList = F('pc_product_category_all');
        if (empty($categoryList)) {
            $categoryList = M('Product_category')->getAllCategory(15, true);

            if (!$categoryList) {
                $categoryList = array();
            }
            F('pc_product_category_all', $categoryList);
        }

        $this->assign('categoryList', $categoryList);

        //cookie 地理坐标
        $WebUserInfo = show_distance();

        /*
          if($WebUserInfo['long']) {
          $xml_array=simplexml_load_file("http://api.map.baidu.com/geocoder?location={$WebUserInfo[lat]},{$WebUserInfo[long]}&output=xml&key=18bcdd84fae25699606ffad27f8da77b"); //将XML中的数据,读取到数组对象中
          foreach($xml_array as $tmp){
          $WebUserInfo['address'] = $tmp->formatted_address;
          }
          } */
        //dump($WebUserInfo);
        $this->assign('WebUserInfo', $WebUserInfo);
        $this->user_location = $WebUserInfo;

        // 友情链接
        $flink_list = D('Flink')->where(array('status' => 1))->order('sort desc')->limit(10)->select();
        $this->assign('flink_list', $flink_list);
        //公共底部信息读取
        $flink_config = D('Flink_config')->select();
        $new_flink_list = array();
        $public_footer_config = array();
		foreach ($flink_config as $key => $value) {
			$public_footer_config[$value['key']] = $value['value'];
			if($value['is_show'] == 1){
				$temp_arr = D('Flink')->where(array('status' => 1,'parent_key'=>$value['key']))->order('sort desc')->limit(10)->select();
				if($temp_arr){
					$new_flink_list[$value['key']] = $temp_arr;
				}
			}
		}
		
		 $this->assign('new_flink_list', $new_flink_list);
		 $this->assign('public_footer_config', $public_footer_config);


        if (empty($WebUserInfo['long']) || empty($WebUserInfo['lat'])) {
            if (empty($_COOKIE['Location_qrcode']) || empty($_COOKIE['Location_qrcode']['ticket']) || $_COOKIE['Location_qrcode']['status'] > 0) {
                $location_return = M('Recognition')->get_location_qrcode();

                if ($location_qrcode['error_code'] == false) {
                    $location_data = D('Location_qrcode')->where(array('id' => $location_return['id']))->find();

                    setcookie('Location_qrcode[id]', $location_return['id'], time() + 60 * 60 * 24);
                    setcookie('Location_qrcode[ticket]', $location_return['ticket'], time() + 60 * 60 * 24);
                    setcookie('Location_qrcode[status]', $location_data['status'], time() + 60 * 60 * 24);
                };
                //dump($location_return);
                $this->assign('location_qrcode', $location_return);
            } else {
                $this->assign('location_qrcode', $_COOKIE['Location_qrcode']);
            }
        } else {
            $location_return = M('Recognition')->get_location_qrcode();
            $location_data = D('Location_qrcode')->where(array('id' => $location_return['id']))->find();
            $location_qrcode['id'] = $location_return['id'];
            $location_qrcode['ticket'] = $location_return['ticket'];
            $location_qrcode['status'] = $location_data['status'];
            $this->assign('location_qrcode', $location_qrcode);
        }
        
		if(isset($WebUserInfo['city_name']) && isset($WebUserInfo['area_name'])){
            $this->assign('user_location_area_name', msubstr($WebUserInfo['area_name'],0,8,'utf-8'));
        }elseif($WebUserInfo['city_name']) {
			$this->user_location_city_name = $WebUserInfo['city_name'];
			$this->assign('user_location_city_name', msubstr($WebUserInfo['city_name'],0,8,'utf-8'));
		}


        //判定pc站是否开启了 短信功能
        if (!option("config.sms_topdomain") || !option("config.sms_price") || !option("config.sms_sign") || !option("config.sms_open")) {
            $is_used_sms = '0'; //关闭使用
        } else {
            $is_used_sms = '1'; //开启使用
        }
        $this->is_used_sms = $is_used_sms;
        $this->assign('is_used_sms', $is_used_sms);

		$this->_get_lbs_info();
    }
	
	private function _get_lbs_info() {

		$data_areas = D('Lbs_area')->where(array('is_open'=>1))->select();
		if(!$data_areas) {
			return ;
		} 

		$new_province_area = F('new_province_area');
		if($new_province_area) {
			$city_array = F('city_array');
			$hot_city = F('hot_city');
			$zimu_area = F('zimu_area');
			$city_array = F('city_array');
			$all_city = F('all_city');

			//按字母区分城市
			$this->assign('city_array',$city_array);
			//热门城市
			$this->assign('hot_city',$hot_city);
			//拥有城市全部字母
			$this->assign('zimu_area',$zimu_area);
			//根据省份/城市
			$this->assign('new_province_area',$new_province_area);
			//全部可选的城市_平级
			$this->assign('all_city',$all_city);			
			
			return;
		}
		
		import('source.class.area');
		$class_area = new area();
		
		$hot_city = array();
		$data_area = array();
		$zimu_area = array();
		$new_province_area = array();
		$all_city = array();
				
		$default_area = $class_area->get_AllProvCity();
		
		foreach($data_areas as $k=>$v) {
            if($v['first_spell']!=''){
			    $data_area[$v['first_spell']][] = $v;
            }
			$data_code_area[$v['code']] = $v;
			if($v['is_hot']) {
				$hot_city[$v['code']] = $v['name'];
			}
		}
		//筛选出开启的省市
		foreach($default_area as $k=>$v) {	
			if(is_array($v['city'])) {
				foreach($v['city'] as $k1=>$v1) {
					if($data_code_area[$k1]) {
						$new_province_area[$k]['province'] = $v['province'];
						$new_province_area[$k]['province_code'] = $v['province_code'];
						$new_province_area[$k]['city'][$k1] = $v1;
		
						$all_city[$k1] = $v1;
					} else {
						unset($v1);
					}
				}
			}
				
		}
		
		if(count($data_area)) {
			ksort($data_area);
			$zimu_area = array_keys($data_area);
		}
		//按字母区分城市
		$this->assign('city_array',$data_area);
		//热门城市
		$this->assign('hot_city',$hot_city);
		//拥有城市全部字母
		$this->assign('zimu_area',$zimu_area);
		//根据省份/城市
		$this->assign('new_province_area',array_values($new_province_area));
		//全部可选的城市_平级
		$this->assign('all_city',$all_city);
		
		F('city_array',$data_area);
		F('hot_city', $hot_city);
		F('zimu_area', $zimu_area);
		F('new_province_area', array_values($new_province_area));
		F('all_city', $all_city);
	}

	protected function nav_list() {
		$categoryList = M('Product_category')->getAllCategory(15);
		return $categoryList;
	}

}

?>