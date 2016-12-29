<?php

/* 手机端公共文件 */
define('PIGCMS_PATH', dirname(__FILE__).'/../');
define('GROUP_NAME','wap');
define('IS_SUB_DIR',true);
require_once PIGCMS_PATH.'source/init.php';

//坐标
$WebUserInfo = show_distance();
if(isset($WebUserInfo['city_name']) && isset($WebUserInfo['area_name'])){
    $user_location_area_name_all = trim($WebUserInfo['area_name']);
    $user_location_area_name = msubstr($WebUserInfo['area_name'],0,2,false,'utf-8');
}elseif($WebUserInfo['city_name']) {
    $user_location_city_name_all = trim($WebUserInfo['city_name']);
    $user_location_city_name = msubstr($WebUserInfo['city_name'],0,2,false,'utf-8');
}

if($WebUserInfo['long']) {
	$xml_array=simplexml_load_file("http://api.map.baidu.com/geocoder?location={$WebUserInfo[lat]},{$WebUserInfo[long]}&output=xml&key=18bcdd84fae25699606ffad27f8da77b"); //将XML中的数据,读取到数组对象中
	$lbs_distance_limit = option("config.lbs_distance_limit");
	foreach($xml_array as $tmp){
		$WebUserInfo['address'] = $tmp->formatted_address;
		$WebUserInfo['city'] =$tmp->addressComponent->city;
	}
				
	if (!empty($WebUserInfo['address'])) {
		$user_location_city_name_all = trim($WebUserInfo['city']);
		$user_location_city_name = msubstr($WebUserInfo['city'],0,8,'utf-8');
		$location_info = array('status' => 1,'type'=>'location', 'msgAll'=>$WebUserInfo['address'],'city'=> msubstr($WebUserInfo['city'],0,8,'utf-8') ,'msg' => msubstr($WebUserInfo['address'],0,8,'utf-8'));
	} else {
		$location_info = array('status' => 0);
	}
}


/*用户信息*/
///////////////粉丝同步///////////////////
if (!empty($_GET['id'])) {
	if (!empty($_GET['store_id'])) {
		$tmp_store_id = $_GET['store_id'];
	} else if (stripos($_SERVER['REQUEST_URI'], 'good.php')) {
        $tmp_product = D('Product')->field('store_id')->where(array('product_id' => intval(trim($_GET['id']))))->find();
        $tmp_store_id = $tmp_product['store_id'];
    } else if (stripos($_SERVER['REQUEST_URI'], 'goodcat.php')) {
        $tmp_group = D('Product_group')->field('store_id')->where(array('group_id' => intval(trim($_GET['id']))))->find();
        $tmp_store_id = $tmp_group['store_id'];
    } else if (stripos($_SERVER['REQUEST_URI'], 'page.php')) {
        $tmp_page = D('Wei_page')->field('store_id')->where(array('page_id' => intval(trim($_GET['id']))))->find();
        $tmp_store_id = $tmp_page['store_id'];
    } else if (stripos($_SERVER['REQUEST_URI'], 'drp_product_share.php')) {
        $tmp_product = D('Product')->field('store_id')->where(array('product_id' => intval(trim($_GET['id']))))->find();
        $tmp_store_id = $tmp_product['store_id'];
    } else if (stripos($_SERVER['REQUEST_URI'], 'pay.php')) {
        $tmp_order = M('Order')->find($_GET['id']);
        $tmp_store_id = $tmp_order['store_id'];
    } else if (stripos($_SERVER['REQUEST_URI'], 'drp_register.php')) {
		$tmp_store_id = intval(trim($_GET['id']));
	} else if (stripos($_SERVER['REQUEST_URI'], 'drp_')) { //分销管理页面
		$tmp_store_id = $_SESSION['wap_drp_store']['store_id'];
	} else if (stripos($_SERVER['REQUEST_URI'], 'pagecat.php')) {
		$nowCategory = D('Wei_page_category')->where(array('cat_id'=>$_GET['id']))->find();
		$tmp_store_id = $nowCategory['store_id'];
	} else {
        $tmp_store_id = intval(trim($_GET['id']));
    }
} else if (!empty($_GET['store_id'])) {
    $tmp_store_id = intval(trim($_GET['store_id']));
}
if (!empty($tmp_store_id) && !empty($_GET['sessid']) && !empty($_GET['token'])) { //对接粉丝登录
    $user = M('User');
    $tmp_sessid = trim($_GET['sessid']);
    $tmp_token = trim($_GET['token']);
    $tmp_openid = trim($_GET['wecha_id']);
    $user = $user->checkUser(array('session_id' => $tmp_sessid, 'token' => $tmp_token, 'third_id' => $tmp_openid, 'status' => array('>', 0)));


    if (!empty($user)) {
        $_SESSION['wap_user'] = $user;
        $_SESSION['wap_user']['store_id'] = $tmp_store_id;
        $_SESSION['sync_user'] = true;

		$url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$url = parse_url($url);
		parse_str($url['query'], $params);
		unset($params['token']);
		unset($params['wecha_id']);
		unset($params['sessid']);
		$params = http_build_query($params);
		$url['query'] = $params;
		if (function_exists('http_build_url')) {
			$redirect_url = http_build_url($url);
		} else {
			$url['scheme'] .= '://';
			$url['query'] = '?' . $url['query'];
			$redirect_url = implode('', $url);
		}
		redirect($redirect_url);
        /*import('source.class.String');

        if (empty($_SESSION['sessid'])) {
            $session_id = String::keyGen();
            $_SESSION['sessid'] = $session_id;
        }
        D('User')->where(array('uid' => $user['uid']))->data(array('session_id' => $_SESSION['sessid']))->save();*/
    }
}
$php_self 	= php_self();
////////////////////////////////////

$wap_user = !empty($_SESSION['wap_user']) ? $_SESSION['wap_user'] : array();

//检测分销商是否存在
if (!empty($_SESSION['wap_drp_store']) && $_SESSION['wap_drp_store']['store_id'] != $tmp_store_id) {
    $store_exists = D('Store')->where(array('store_id' => $_SESSION['wap_drp_store']['store_id'], 'status' => 1))->find();
    if (empty($store_exists)) { //店铺不存在或已删除
        unset($_SESSION['wap_drp_store']); //删除保存在session中分销商
    }
}

/*是否移动端*/
$is_mobile = is_mobile();
/*是否微信端*/
$is_weixin = is_weixin();
//热门关键词
$hot_keyword 	= D('Search_hot')->where('1')->order('sort DESC')->limit(8)->select();

//合并SESSION和UID的购物车、订单、收货地址等信息
function mergeSessionUserInfo($sessionid, $uid, $store_id = 0){
    if (empty($store_id)) {
        $store_id = $_COOKIE['wap_store_id'];
    }
	//购物车
	D('User_cart')->where(array('uid' => 0,'session_id' => $sessionid))->data(array('uid' => $uid,'session_id' => ''))->save();
	
	//订单
	D('Order')->where(array('uid'=>0,'session_id'=>$sessionid))->data(array('uid'=>$uid,'session_id'=>''))->save();

    //分销订单
    D('Fx_order')->where(array('uid' => 0,'session_id' => $sessionid))->data(array('uid' => $uid,'session_id' => ''))->save();

    //收货地址
    D('User_address')->where(array('uid'=>0,'session_id'=>$sessionid))->data(array('uid'=>$uid,'session_id'=>''))->save();

    //用户店铺数据
    M('Store_user_data')->updateData($store_id, $uid, true);
}

//访问统计
function Analytics($store_id, $module, $title, $id)
{
    $analytics = M('Store_analytics');
    $ip = bindec(decbin(ip2long($_SERVER['REMOTE_ADDR'])));
    $time = time();
    $visit_id = $analytics->add(array('store_id' => $store_id, 'module' => $module, 'title' => $title, 'page_id' => $id, 'visited_time' => $time, 'visited_ip' => $ip));
    if (strtolower($module) == 'goods') {
        $product = M('Product');
        $product->analytics(array('product_id' => $id, 'store_id' => $store_id));

        echo $html 	= <<<EOM
		<script type="text/javascript">
            (function visit() {
                var start;
                var end;
                var duration = 0;
                start = new Date(); //用户访问时间
                $(window).bind('beforeunload', function(e) {
                    end = new Date(); //用户离开时间
                    duration = end.getTime() - start.getTime();
                    duration = duration / 1000; //单位秒
                    $.ajax({
                        type: 'POST',
                        async: false,
                        url: 'visit.php',
                        data: {
                            'uid': {$_SESSION['wap_user']['uid']},
                            'store_id': {$store_id},
                            'module': '{$module}',
                            'page_id': {$id},
                            'visit_id': {$visit_id},
                            'duration': duration
                        }
                    });
                });
            })();
		</script>
EOM;
    } else {
        echo $html 	= <<<EOM
		<script type="text/javascript">
            (function visit() {
                var start;
                var end;
                var duration = 0;
                start = new Date(); //用户访问时间
                $(window).bind('beforeunload', function(e) {
                    end = new Date(); //用户离开时间
                    duration = end.getTime() - start.getTime();
                    duration = duration / 1000; //单位秒
                    $.ajax({
                        type: 'POST',
                        async: false,
                        url: 'visit.php',
                        data: {
                            'visit_id': {$visit_id},
                            'duration': duration
                        }
                    });
                });
            })();
		</script>
EOM;
    }

}
//获取当前文件名称 （公用菜单选中效果）
function php_self(){
    $php_self=substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1);
    return $php_self;
}

//wap报错页面
function wap_error ($msg = '发生错误', $redirect_url = '') {
	$error_msg = $msg;
	$redirect_url = !empty($redirect_url) ? $redirect_url : $_SERVER['HTTP_REFERER'];
	include display('error_404');
	exit;
}

?>
