<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/8
 * Time: 9:41
 */
require_once dirname(__FILE__).'/global.php';
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch($action){
    case 'promote_setting':
        $store_id = !empty($_POST['store_id']) ? $_POST['store_id'] : '';
        $title = !empty($_POST['title']) ? $_POST['title'] : '';
        $content = !empty($_POST['content']) ? $_POST['content'] : '';
        $description = !empty($_POST['description']) ? $_POST['description'] : '';
        $data = array();
        if (!empty($title)){
            $data = array (
                'title' => $title,
                'update_time' => time(),
            );
        }else if (!empty($content)){
            $data = array (
                'content' => $content,
                'update_time' => time(),
            );
        } else if (!empty($description)){
            $data = array (
                'description' => $description,
                'update_time' => time(),
            );
        }
        if (D('Store_promote_setting')->where(array ('store_id' => $store_id))->find()) {
            $result = D('Store_promote_setting')->where(array ('store_id' => $store_id))->data($data)->save();

            echo D('Store_promote_setting')->last_sql;
        }else {
            $data = array (
                'title' => $title,
                'content' => $content,
                'description' => $description,
                'add_time' => time(),
                'update_time' => time(),
                'store_id' => $store_id,
            );
            $result = D('Store_promote_setting')->data($data)->add();
        }

        if($result){
            json_return(0, '213');
        }
        break;
	
	//兑换等级
	case 'exchange_degree':
			import('source.class.Points');

			$uid= $wap_user['uid'];
			$store_id = $_GET['store_id'];
			//获取顶级供货商
			$store_info = M('Store')->getSuppliers($store_id);
			$store_id = $store_info['store_id'] ? $store_info['store_id']: $store_id ;
			
			$degree_id = $_GET['degree_id'];
			$return = Points::upDegree($uid, $store_id, $degree_id);
			
			echo json_encode($return);exit;
		break;
}
