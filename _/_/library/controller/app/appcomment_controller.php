<?php
/**
 * 评论控制器
 */
class appcomment_controller extends base_controller{
    public $arrays=array();
	public $config;
	public $_G;
	public function __construct(){
		global $_G;
		$this->_G = $_G;
		$this->arrays['config'] = $this->config = $_G['config'];
	}
	// 评论列表
	public function index() {
	
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
		$page = max(1, $_REQUEST['page'] + 0);
		$id = $_REQUEST['data_id'];
		$type = $_REQUEST['type'];
		$tab = $_REQUEST['tab'];
		$has_image = $_REQUEST['has_image'];
		$size = $_REQUEST['size'];	
		if (empty($id)) {
		
		    $results['result']='1';
			$results['msg']='data_id不能为空';
			exit(json_encode($results));
		}
			
		$type_arr = array('PRODUCT', 'STORE');
		if (!in_array($type, $type_arr)) {
			$results['result']='1';
			$results['msg']='类型错误';
			exit(json_encode($results));
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
		$limit = $size ? $size : 5;
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
				$comment['price'] = $tmp['price'];
				foreach ($tmp['attachment_list'] as &$r) {
				unset($r['id']);
				unset($r['cid']);
				unset($r['type']);
				unset($r['size']);
				unset($r['uid']);
				unset($r['width']);
				unset($r['height']);
				}
				$comment['attachment_list'] = $tmp['attachment_list'];
				
				$list[] = $comment;
			}
		}
		
		$json_return = array();
		$json_return['page_index'] = $page;
		$json_return['page_count'] = ceil($count / $limit);
	
		
		$results['data']=$list;
		$results['page_info']=$json_return;
			exit(json_encode($results));
	}
	
	
public function add() {



		$results = array('result'=>'0','data'=>array(),'msg'=>'');
	    $uid = $_REQUEST['uid'];
		$token = $_REQUEST['token'];
		$tokens = D('Users_token')->where(array('uid' => $uid))->find();
		if ($token!=$tokens['token']) {
		     $results['result']='1';
			$results['msg']='token不正确';
			exit(json_encode($results));
		}
		
		$this->status = 0;
		
		$relation_id = $_REQUEST['data_id'];
		$type = $_REQUEST['type'];
		$score = ceil($_REQUEST['score'] + 0);
		//$logistics_score = min(1, max(5, $_POST['logistics_score']));
		//$description_score = min(1, max(5, $_POST['description_score']));
		//$speed_score = min(1, max(5, $_POST['speed_score']));
		//$service_score = min(1, max(5, $_POST['service_score']));
		$images = $_REQUEST['images'];
		$content = $_REQUEST['content'];
		$tag_id_str = $_REQUEST['tag_id_str'];
		$price = $_REQUEST['price'];
		$type_arr = array('PRODUCT', 'STORE');
		if (!in_array($type, $type_arr)) {
		
			$results['result']='1';
			$results['msg']='来源错误';
			exit(json_encode($results));
		}
		
		// debug score
		if ($score < 0 || $score > 5) {
			$score = 5;
		}
		
		$order_product = array();
		if ($type == 'PRODUCT') {
			// 查找是否有评论权限，判断标准为
			$order_product = M('Order_product')->isComment($relation_id);
			if (!$order_product) {
			
			$results['result']='1';
			$results['msg']='购买后才能评论';
			exit(json_encode($results));
			}
			
			//产品即管理其店铺id
			$product_arr = D('Product')->where(array('product_id'=>$relation_id))->find();
			$store_id = $product_arr['store_id'];
			
			
		} else if ($type == 'STORE') {
			// 逻辑处理
			$store_id = $relation_id;
		} else {
			exit;
		}
		
		if (!empty($content)) {
			$content = M('Ng_word')->filterNgWord($content);
		}
	
		
		$data = array();
		$data['dateline'] = time();
		$data['order_id'] = $order_product['order_id'];
		$data['relation_id'] = $relation_id;
		$data['uid'] = $uid;
		$data['price'] = $price;
		$data['store_id'] = $store_id;
		$data['score'] = $score;
		//$data['logistics_score'] = $logistics_score;
		//$data['description_score'] = $description_score;
		//$data['speed_score'] = $speed_score;
		//$data['service_score'] = $service_score;
		$data['type'] = $type;
		$data['status'] = $this->status;
		$data['content'] = $content;
		$data['has_image'] = empty($images) ? 0 : 1;
		
		$cid = D('Comment')->data($data)->add();
		if (empty($cid)) {
		
			$results['result']='1';
			$results['msg']='发表评论失败';
			exit(json_encode($results));
		}
		$attachment_user_list=explode(',',$images);
		
		if(!empty($images)){
		// 插入评论附件表
		$upload_dir = PIGCMS_PATH . '/upload/';
		foreach ($attachment_user_list as $r) {
		     $imginfo= getimagesize($r); 
			$data = array();
			$data['cid'] = $cid;
			$data['uid'] = $uid;
			$data['type'] = 0;
			$data['file'] = str_replace($upload_dir,"",$r);
			$data['size'] = $imginfo['bits'];
			$data['width'] = $imginfo['0'];
			$data['height'] = $imginfo['1'];
			
			D('Comment_attachment')->data($data)->add();
		}
		
		}
		// 插入评论TAG表
		if (!empty($tag_id_str)) {
			$tag_id_arr = explode(',', $tag_id_str);
			
			foreach ($tag_id_arr as $tag_id) {
				$tag_id += 0;
				if (empty($tag_id) || $tag_id <= 0) {
					continue;
				}
				
				$data = array();
				$data['cid'] = $cid;
				$data['tag_id'] = $tag_id;
				$data['relation_id'] = $relation_id;
				$data['type'] = $type;
				$data['status'] = $this->status;
				D('Comment_tag')->data($data)->add();
			}
		}
		
		// 更改相应订单的产品为已评论
		if ($type == 'PRODUCT') {
			D('Order_product')->where(array('pigcms_id' => $order_product['pigcms_id']))->data(array('is_comment' => 1))->save();
		}
		
	exit(json_encode($results));
	}
	

	
	
}
?>