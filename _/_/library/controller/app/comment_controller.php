<?php
/**
 * 评论控制器
 */
class comment_controller extends base_controller{
	// 评论列表
	public function comment_list() {
		$page = max(1, $_REQUEST['page'] + 0);
		$id = $_REQUEST['data_id'];
		$type = $_REQUEST['type'];
		$tab = $_REQUEST['tab'];
		$has_image = $_REQUEST['has_image'];
			
		if (empty($id)) {
			json_return(1000, '参数错误');
			exit;
		}
			
		$type_arr = array('PRODUCT', 'STORE');
		if (!in_array($type, $type_arr)) {
			json_return(1000, '参数错误');
			exit;
		}
			
		$where = array();
		$where['type'] = $type;
		if (!empty($has_image)) {
			$where['has_image'] = 1;
		}
		$where['relation_id'] = $id;
		$where['status'] = 1;
		$where['delete_flg'] = 0;
		switch($tab) {
			case 'HAO' :
				$where['score'] = array('>=', 4);
				break;
			case 'ZHONG' :
				$where['score'] = 3;
				break;
			case 'CHA' :
				$where['score'] = array('<=', 2);
				break;
			case 'IMAGE' :
				$where['has_image'] = 1;
			default :
				break;
		}
			
		$comment_model = M('Comment');
		$count = $comment_model->getCount($where);
			
		$comment_list = array();
		$pages = '';
		$limit = 5;
		$total_page = ceil($count / $limit);
		if ($count > 0) {
			$page = min($page, ceil($count / $limit));
			$offset = ($page - 1) * $limit;
			$comment_list = $comment_model->getList($where, 'id desc', $limit, $offset, true);
		}
			
		$user_list = array();
		if ($comment_list['user_list']) {
			foreach ($comment_list['user_list'] as $key => $user) {
				$tmp = array();
				$tmp['nickname'] = anonymous($user['nickname']);
				$tmp['avatar'] = $user['avatar'];
				
				$user_list[$key] = $tmp;
			}
		}
		
		$list = array();
		if ($comment_list['comment_list']) {
			foreach ($comment_list['comment_list'] as $tmp) {
				$comment = array();
				$comment['content'] = htmlspecialchars($tmp['content']);
				$comment['score'] = $tmp['score'];
				$comment['date'] = date('Y-m-d', $tmp['dateline']);
				$comment['nickname'] = isset($user_list[$tmp['uid']]) ? $user_list[$tmp['uid']]['nickname'] : '匿名';
				$comment['avatar'] = isset($user_list[$tmp['uid']]) ? $user_list[$tmp['uid']]['avatar'] : getAttachmentUrl('images/touxiang.png', false);
				$comment['attachment_list'] = $tmp['attachment_list'];
				
				$list[] = $comment;
			}
		}
		
		$json_return = array();
		$json_return['comment_list'] = $list;
		$json_return['count'] = $count;
		$json_return['max_page'] = ceil($count / $limit);
		
		$json_return['no_next_page'] = false;
		if(count($json_return['list']) < $limit || $total_page <= $page){
			$json_return['no_next_page'] = true;
		}
		
		json_return(0, $json_return);
	}
}
?>