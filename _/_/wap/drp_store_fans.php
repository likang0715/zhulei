<?php
/**
 * 店铺分丝
 * User: pigcms_21
 * Date: 2015/4/21
 * Time: 13:18
 */
require_once dirname(__FILE__) . '/drp_check.php';

	redirect('./change_store.php?action=fens');
	return;

//分享配置 start  
$share_conf = array(
    'title' => $_SESSION['wap_drp_store']['name'] . '-分销管理', // 分享标题
    'desc' => str_replace(array("\r", "\n"), array('', ''), $_SESSION['wap_drp_store']['intro']), // 分享描述
    'link' => 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], // 分享链接
    'imgUrl' => $_SESSION['wap_drp_store']['logo'], // 分享图片链接
    'type' => '', // 分享类型,music、video或link，不填默认为link
    'dataUrl' => '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share = new WechatShare();
$shareData = $share->getSgin($share_conf);
//分享配置 end

$user_attention_model=M('User_attention');
if (IS_GET && $_GET['a'] == 'index') {
    $store = $_SESSION['wap_drp_store'];
    //粉丝总数
    $where = array();
    $where['data_id']=$store['store_id'];
    $where['data_type']=2;
    $fans=$user_attention_model->getCount($where);
    //今日新增粉丝
    $start_time = strtotime(date('Y-m-d') . ' 00:00:00');
    $end_time = strtotime(date('Y-m-d') . ' 23:59:59');
    $where = array();
    
    $where['data_id']=$store['store_id'];
    $where['data_type']=2;
    $where['_string'] = "u.add_time >= '" . $start_time . "' AND u.add_time <= '" . $end_time . "'";
    $today_fans = $user_attention_model->getCount($where);
    //昨日新增粉丝
    $start_time = strtotime(date("Y-m-d", strtotime("-1 day")) . ' 00:00:00');
    $end_time = strtotime(date("Y-m-d", strtotime("-1 day")) . ' 23:59:59');
    $where = array();
    $where['data_id']=$store['store_id'];
    $where['data_type']=2;
    $where['_string'] = "add_time >= '" . $start_time . "' AND add_time <= '" . $end_time . "'";
    $yesterday_fans = $user_attention_model->getCount($where);
    include display('drp_store_fans_index');
    echo ob_get_clean();
} else if (IS_GET && $_GET['a'] == 'list') {

    $store = $_SESSION['wap_drp_store'];
    $date = isset($_GET['date']) ? strtolower(trim($_GET['date'])) : '';
    $where = array();
    $where['data_id']=$store['store_id'];
    $where['data_type']=2;
    if ($date == 'today') { //今日
        $start_time = strtotime(date('Y-m-d') . ' 00:00:00');
        $end_time = strtotime(date('Y-m-d') . ' 23:59:59');
        $where['_string'] = "add_time >= '" . $start_time . "' AND add_time <= '" . $end_time . "'";
    } else if ($date == 'yesterday') { //昨日
        $start_time = strtotime(date("Y-m-d", strtotime("-1 day")) . ' 00:00:00');
        $end_time = strtotime(date("Y-m-d", strtotime("-1 day")) . ' 23:59:59');
        $where['_string'] = "add_time >= '" . $start_time . "' AND add_time <= '" . $end_time . "'";
    }
    

    $fans_count = $user_attention_model->getCount($where);
    import('source.class.user_page');
    $page = new Page($fans_count, 20);
    $fans = $user_attention_model->getUserattention($where, $page->firstRow, $page->listRows);

    $user_arr = array();
    foreach ($fans as $v) {
        $user_arr[] = $v['user_id'];
    }
    $Map['uid'] = array('in', $user_arr);
    $user_list = M('User')->getList($Map);

    include display('drp_store_fans_list');
    echo ob_get_clean();
} else if (IS_POST && $_GET['a'] == 'list') {
    $store = $_SESSION['wap_drp_store'];
    $date = isset($_GET['date']) ? strtolower(trim($_GET['date'])) : '';
    $where = array();
    $where['data_id']=$store['store_id'];
    $where['data_type']=2;
    if ($date == 'today') { //今日
        $start_time = strtotime(date('Y-m-d') . ' 00:00:00');
        $end_time = strtotime(date('Y-m-d') . ' 23:59:59');
        $where['_string'] = "add_time >= '" . $start_time . "' AND add_time <= '" . $end_time . "'";
    } else if ($date == 'yesterday') { //昨日
        $start_time = strtotime(date("Y-m-d", strtotime("-1 day")) . ' 00:00:00');
        $end_time = strtotime(date("Y-m-d", strtotime("-1 day")) . ' 23:59:59');
        $where['_string'] = "add_time >= '" . $start_time . "' AND add_time <= '" . $end_time . "'";
    }
    
    $sort = !empty($_POST['sort']) ? trim($_POST['sort']) : '';
    switch ($sort) {
        case 'x1':
            $order = "order_count ASC";
            break;
        case 'x2':
            $order = "order_count DESC";
            break;
        case 'y1':
            $order = "order_total ASC";
            break;
        case 'y2':
            $order = "order_total DESC";
        default:
            $order = 'u.id DESC';
            break;
    }
    $page_size = !empty($_POST['pagesize']) ? intval(trim($_POST['pagesize'])) : 20;
    $fans_count=$user_attention_model->getCount($where);
    import('source.class.user_page');
    $page = new Page($fans_count, $page_size);
    $fans=$user_attention_model->getUserattention($where, $page->firstRow, $page->listRows, $order);
    
    
        $user_arr = array();
    foreach ($fans as $v) {
        $user_arr[] = $v['user_id'];
    }
    $Map['uid'] = array('in', array_unique($user_arr));
    $user_list = M('User')->getList($Map);
    
    $html = '';

    foreach ($fans as $v) {
        $html .='<tr>';
        $html .='<td style="text-align: left">'.$user_list[$v['user_id']]['nickname'].'</td>';
        $html .='<td style="text-align: center">'.date('Y-m-d H:i:s',$v['add_time']).'</td>';
        $html .='</tr>';
    }
    echo json_encode(array('count' => count($fans), 'data' => $html));
    exit;
}