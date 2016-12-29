<?php
class index_controller extends base_controller{
	public function index() {
		//首页幻灯片
		$adver_list = M('Adver')->get_adver_by_key('wap_index_slide_top', 5);
		foreach ($adver_list as &$adver) {
			$adver['adver_id'] = $adver['id'];
			unset($adver['id']);
		}
		
		//首页自定义导航
		$slider_nav_list = M('Slider')->get_slider_by_key('wap_index_nav', 16);
		foreach ($slider_nav_list as &$slider_nav) {
			$slider_nav['slider_id'] = $slider_nav['id'];
			unset($slider_nav);
		}
		
		// 默认5个店铺,只抽取供货商店铺
		$store_list = D('Store')->where(array('status' => 1, 'drp_level' => 0))->field('`store_id`, `name`, `logo`, `collect`, `attention_num`')->order('`approve` DESC, `store_id` DESC')->limit(5)->select();
		$store_model = M('Store');
		foreach ($store_list as &$store) {
			$store['url'] =  url('store:index', array('id' => $store['store_id']));
			if(empty($store['logo'])) {
				$store['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
			} else {
				$store['logo'] = getAttachmentUrl($store['logo']);
			}
			$sale_category = $store_model->getSaleCategory($store['store_id'], $store['uid']);
			$store['category'] = $sale_category;
		}
		
		//首页推荐活动
		$active_list = D('Activity_recommend')->order("is_rec desc,ucount desc")->limit(5)->select();
		$activity = M('activity');
		$activity_recommend_list = array();
		foreach($active_list as $k=> $value) {
			$tmp = array();
			$tmp['url'] = $activity->createUrl($value, $value['model'], '1');
			$tmp['image'] = getAttachmentUrl($value['image']);
			$tmp['title'] = msubstr($value['title'], 0 , 12,'utf-8');
			$tmp['info'] = msubstr($value['info'], 0 , 20,'utf-8');
			$tmp['ucount'] = $value['ucount'];
			
			$activity_recommend_list[] = $tmp;
		}
		
		$json_data = array();
		$json_data['adver_list'] = $adver_list;
		$json_data['slider_nav_list'] = $slider_nav_list;
		$json_data['store_list'] = $store_list;
		$json_data['activity_recommend_list'] = $activity_recommend_list;
		$json_data['my_url'] = option('config.wap_site_url') . '/my.php';
		$json_data['unitary_url'] = option('config.wap_site_url') . '/activity.php?table_name=unitary';
		$json_data['seckill_url'] = option('config.wap_site_url') . '/activity.php?table_name=seckill';
		$json_data['crowdfunding_url'] = option('config.wap_site_url') . '/activity.php?table_name=crowdfunding';
		$json_data['bargain_url'] = option('config.wap_site_url') . '/activity.php?table_name=bargain';
		$json_data['cutprice_url'] = option('config.wap_site_url') . '/activity.php?table_name=cutprice';
		$json_data['lottery_url'] = option('config.wap_site_url') . '/activity.php?table_name=lottery';
		
		json_return(0, $json_data);
	}

	// 活动
	public function activity() {
		$list  = M('Activity')->getHotActivity(8);
		
		$activity_list = array();
		foreach ($list as $key => $val) {
			$activityTmp = M('Activity')->getActivityDetail($val['id']);
			$activityTmp['joinurl'] = $activityTmp['joinurl'] . '&rget=1';
			$activityTmp['pic'] = $val['image'];
			$activity_list[$key] = $activityTmp;
		}
		
		echo json_encode($activity_list);
	}

}
?>