<?php
/**
 *  微网站首页
 */
require_once dirname(__FILE__).'/global.php';

if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));

$action = $_REQUEST['action'] ? $_REQUEST['action'] : 'pingtai';

//模板
$display = 'my_margin_index';
switch($action) {
	//充值金额流水
	case 'index':
		import('source.class.Margin');

		$store_id = !empty($_GET['store_id']) ? intval($_GET['store_id']) : 0;
		$store = D('Store')->field('store_id,name,logo,margin_total,margin_balance,point_balance')->where(array('store_id' => $store_id))->find();

		if (isset($_REQUEST['type'])) {
			$type = explode(',', trim($_REQUEST['type']));
		}


		if (IS_AJAX) {
			if ($_GET['ajax'] == 1) {
				if (empty($store)) {
					json_return(1001, '店铺不存在');
				}

				$page = max(1, $_REQUEST['page']);
				$limit = 6;
				$where = array();
				$where['store_id'] = $store_id;
				if (isset($type)) {
					$where['type'] = array('in', $type);
				}
				$margin_count = D('Platform_margin_log')->where($where)->count('pigcms_id');
				$page = min($page, ceil($margin_count / $limit));
				$offset = abs(($page - 1) * $limit);

				$margin_logs = D('Platform_margin_log')->where($where)->order('pigcms_id DESC')->limit($offset . ',' . $limit)->select();
				if (!empty($margin_logs)) {
					foreach ($margin_logs as &$margin_log) {
						$margin_log['add_time'] = date('Y-m-d H:i:s', $margin_log['add_time']);
						$margin_log['point'] = $margin_log['amount'];
					}
				}

				$json_return = array();
				$json_return['noNextPage'] = true;
				$json_return['list'] = $margin_logs;
				$json_return['max_page'] = ceil($margin_count / $limit);
				json_return(0, $json_return);
			}

			json_return(1002, '缺少访问参数');
		}

		if (empty($store)) {
			pigcms_tips('店铺不存在');
		}

		$store['logo'] = !empty($store['logo']) ? getAttachmentUrl($store['logo']) : '../static/images/default_shop.png';
		$store['margin_used'] = number_format($store['margin_total'] - $store['margin_balance'], 2, '.', '');

		Margin::init($store_id);
		$point_alias = Margin::point_alias();

		if (isset($type)) {
			$type = implode(',', $type);
		}
		break;
}


//分享配置 start  
$share_conf 	= array(
	'title' 	=> $store['name'] . ' - 我的充值金额', // 分享标题
	'desc' 		=> str_replace(array("\r", "\n"), '', $store['name']), // 分享描述
	'link' 		=> 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], // 分享链接
	'imgUrl' 	=> $store['logo'], // 分享图片链接
	'type'		=> '', // 分享类型,music、video或link，不填默认为link
	'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share 		= new WechatShare();
$shareData 	= $share->getSgin($share_conf);
//分享配置 end

include display($display);

echo ob_get_clean();
?>