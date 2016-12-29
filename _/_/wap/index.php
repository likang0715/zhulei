<?php
/**
 *  店铺主页
 */
require_once dirname(__FILE__).'/global.php';


if(option('config.is_diy_template')){
	//模板类型

	//首页幻灯片
	$slide 	= M('Adver')->get_adver_by_key('wap_index_slide_top',5);

	//首页自定义导航
	$slider_nav =  M('Slider')->get_slider_by_key('wap_index_nav', 10000000);

	//热门品牌下方广告
	$hot_brand_slide = M('Adver')->get_adver_by_key('wap_index_brand',5);

    //yfz@20160620首页推荐茶馆
	$hot_physical 	= D('Store')->where("is_hot = 1")->order('store_id DESC')->limit('3')->select();
	foreach($hot_physical as $key=>$value){
	$hot_physical[$key]['url'] = $config['wap_site_url'].'/home.php?id='.$value['store_id'];
     $tuan = D('Tuan')->field('`name`')->where("store_id = ".$value['store_id'])->order('`id` DESC')->limit(1)->select();
	 foreach($tuan as $k=>$r){
	 $hot_physical[$key]['tuan'] = $r['name'];
	 }
	
     $hui= D('Reward')->field('`name`')->where("store_id = ".$value['store_id'])->order('`id` DESC')->limit(1)->select();
	  foreach($hui as $k=>$r){
	 $hot_physical[$key]['hui'] = $r['name'];
	 }
      }

//yfz@20160620首页推荐茶会
    $chahui = D('Chahui')->where("tj = 1")->order('`sttime` DESC')->limit(3)->select();
foreach($chahui as $key =>$r){
$chahui_store = M('Store')->wap_getStore($r['store_id']);
$chahui[$key]['logo']=$chahui_store['logo'];
$chahui[$key]['time']=date('m/d H:i',$r['sttime']);
$chahui[$key]['url']=$config['wap_site_url'] . '/chahui_show.php?id=' . $r['pigcms_id'];
}

	//首页分类
	$cat 	= D('Product_category')->where("cat_status = 1 and cat_level = 1 and cat_pic != ''")->order('cat_sort ASC,cat_id DESC')->limit('12')->select();
	foreach($cat as $key=>$value){
		$cat[$key]['cat_pic'] = getAttachmentUrl($value['cat_pic']);
	}
	
	//$sql = D('Product_category')->last_sql;
	
	//品牌
	$brand 	= D('Store')->where(array('status'=>1,'approve'=>1))->field('`store_id`,`name`,`logo`')->order('`store_id` DESC')->limit(6)->select();
	foreach($brand as $key=>$value){
		$brand[$key]['url'] =  'home.php?id='.$value['store_id'];
		if (empty($value['logo'])) {
			$brand[$key]['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
		} else {
			$brand[$key]['logo'] = getAttachmentUrl($value['logo']);
		}
	}
	//首页推荐商品
	$product_list = M('Product')->getSelling('quantity>0 AND status=1 AND is_recommend = 1', '', '', 0, 6);//D('Product')->where('quantity>0 AND status=1 AND is_recommend = 1')->limit('4')->select();
	//首页推荐活动
	$active_list = M('Activity')->getActivity('',6,"is_rec=1");


//$imUrl 	= getImUrl($_SESSION['wap_user']['uid'],$store_id);

//活动列表
// $list = D('Activity_recommend')->where($where)->limit(0,6)->select();
$list  = M('Activity')->getHotActivity(8);
$is_have_activity = option('config.is_have_activity');

// 店铺动态
$shop_articles = D('Custom_field')->where(array('field_type'=>'article'))->order('field_id desc')->limit('0,3')->select();
$articles = array();
if($shop_articles){
	$article_ids = $store_ids = $product_ids = array();
	foreach($shop_articles as $k => $v){
		if(!in_array($v['store_id'],$store_ids)){
			$store_ids[] = $v['store_id'];
		}
		$content = unserialize($v['content']);
		$article_info = D('Article')->where(array('id'=>$content['activity_arr'][0]['id'],'status'=>1,'dateline'=>array('>',time()-2592000)))->find();
		if(!$article_info){
			continue;
		}
		// 文章是否被该用户收藏
		$iscollect = D('My_collection_article')->where(array('uid'=>$_SESSION['wap_user']['uid'],'article_id'=>$article_info['id']))->find();
		$articles[$k]['iscollect'] = $iscollect?1:0;
		// 该文章被收藏总数
		$collect_count = D('My_collection_article')->field('count(*) as count')->where(array('article_id'=>$article_info['id']))->find();
		$articles[$k]['collect_count'] = $collect_count['count'];

		$articles[$k]['store_id'] = $v['store_id'];
		$articles[$k]['article_id'] = $content['activity_arr'][0]['id'];
		// 商品
		$articles[$k]['article_info'] = $article_info;
		$articles[$k]['product_id'] = $article_info['product_id'];
		if(!in_array($article_info['product_id'],$product_ids)){
			$product_ids[] = $article_info['product_id'];
		}
	}
	$where_store['store_id'] = array('in',$store_ids);
	$tmp_stores = D('Store')->where($where_store)->field('store_id,name')->select();
	$stores = array();
	foreach($tmp_stores as $vv){
		$stores[$vv['store_id']] = $vv;
	}
	// 商品
	$where_product['product_id'] = array('in',$product_ids);
	$tmp_products = D('Product')->where($where_product)->field('product_id,name,image')->select();
	$products = array();
	foreach($tmp_products as $vvv){
		$products[$vvv['product_id']] = $vvv;
	}
}



/* 20160224 统计点击平台分享的点击数 */
$shar_user_id = !empty($_GET['uid']) ? $_GET['uid'] : 0;

/* 获取平台配置积分奖励数 */
$platform_config = D('Credit_setting')->field('share_qrcode_effective_click,share_qrcode_credit')->find();
if(!empty($shar_user_id)){
    $ip = get_client_ip();
    $is_share = D('Platform_share_log')->where(array('user_id'=>$shar_user_id))->find();
    $user_info = D('User')->field('point_gift')->where(array('uid'=>$shar_user_id))->find();
    if(empty($is_share)){
        $data = array();

        $data['user_id'] = $shar_user_id;
        $data['share_num'] = 1;
        $data['share_num_count'] = 1;
        $data['share_ip'] = $ip;
        $data['share_time'] = time();
        $data['update_time'] = time();
        $oneResult = D('Platform_share_log')->data($data)->add();

    }else{
        if(stripos($is_share['share_ip'],$ip) === FALSE){
            $data = array();

            $data['share_num_count'] = $is_share['share_num_count'] + 1;
            $data['share_num'] = $is_share['share_num'] + 1;
            $data['share_ip'] = $is_share['share_ip'].','.$ip;
            $data['update_time'] = time();

            $twoResult = D('Platform_share_log')->where(array('user_id'=>$shar_user_id))->data($data)->save();
        }
        if(!empty($platform_config['share_qrcode_effective_click']) && !empty($platform_config['share_qrcode_credit'])){

            $new_share = D('Platform_share_log')->where(array('user_id'=>$shar_user_id))->find();
            if($new_share['share_num'] >= $platform_config['share_qrcode_effective_click']){
                $result = D('User')->where(array('uid'=>$shar_user_id))->data(array('point_gift'=>$user_info['point_gift']+$platform_config['share_qrcode_credit']))->save();

                $data = array();
                if($result)
                {
                    /* 更新点击数 */
                    $data['share_num'] = $new_share['share_num'] - $platform_config['share_qrcode_effective_click'];
                    $data['update_time'] = time();
                    $sharResult = D('Platform_share_log')->where(array ('user_id' => $shar_user_id))->data($data)->save();

                    /* 添加积分赠送日志 */
                    $datalog['user_id'] = $shar_user_id;
                    $datalog['point'] = $platform_config['share_qrcode_effective_click'];
                    $datalog['point_type'] = 2;
                    $datalog['add_time'] = time();
                    D('Platform_user_points_log')->data($datalog)->add();
                }
            }
        }
    }
}
$html = M('Activity_recommend')->getActivityHTML('', 10);


// 积分赠送
import('source.class.Margin');
$open_margin_recharge = Margin::check();
$credit_setting = D('Credit_setting')->find();
$platform_credit_name = $credit_setting['platform_credit_name'] ;
$platform_credit_name = $platform_credit_name ? $platform_credit_name : "平台币";


}else{
	if(empty($config['platform_mall_index_page'])){
		pigcms_tips('请管理员在管理后台【系统设置】=》【站点配置】=》【平台商城配置】选取微页面','none');
	}

	//首页的微杂志
	$homePage = D('Wei_page')->where(array('page_id'=>$config['platform_mall_index_page']))->find();
	if(empty($homePage)){
		pigcms_tips('您访问的店铺没有首页','none');
	}

	//微杂志的自定义字段
	if($homePage['has_custom']){
		$homeCustomField = M('Custom_field')->getParseFields(0,'page',$homePage['page_id']);
	}
}

/* end */
//分享配置 start
$share_conf 	= array(
	'title' 	=> option('config.site_name'), // 分享标题
	'desc' 		=> str_replace(array("\r","\n"), array('',''), option('config.seo_description')), // 分享描述
	'link' 		=> option('config.wap_site_url'), // 分享链接
	'imgUrl' 	=> option('config.site_logo'), // 分享图片链接
	'type'		=> '', // 分享类型,music、video或link，不填默认为link
	'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share 		= new WechatShare();
$shareData 	= $share->getSgin($share_conf);
//分享配置 end

include display('index');

echo ob_get_clean();
?>