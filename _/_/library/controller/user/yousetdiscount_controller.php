<?php
// 优惠接力
class yousetdiscount_controller extends base_controller {
	
	public function __construct() {
		parent::__construct();
	}

	// 加载
	public function load () {
		$action = strtolower(trim($_POST['page']));
		if (empty($action)) pigcms_tips('非法访问！', 'none');
		
		switch ($action) {
			case 'list' :
				$this->_list();
				break;
			case 'edit' :
				$this->_edit();
				break;
			case 'order' :
				$this->_order();
			case 'create' :
				$this->_create();
			case 'record' :
				$this->_record();
			default:
				break;
		}
		
		$this->display($_POST['page']);
	}

	public function yousetdiscount_index () {
		$this->display();
	}
	
	public function _list () {

		$type = $_REQUEST['type'];
		$keyword = $_REQUEST['keyword'];
		$where['store_id'] = $this->store_session['store_id'];

		$type_arr = array('future', 'on', 'end', 'all');
		if (!in_array($type, $type_arr)) {
			$type = 'all';
		}

		$time = time();
		switch ($type) {
			case 'on':
				$where['_string'] = "$time >= startdate and $time < enddate";	//进行中
				break;
			case 'end':
				$where['_string'] = "$time > enddate";	//结束
				break;
			case 'future':
				$where['_string'] = "$time < startdate";	//未开始
				break;
		}

		if (!empty($keyword)) {
			$where['name'] = array('like', '%' . $keyword . '%');
		}

		$count = D('Yousetdiscount')->where($where)->count('id');
		
		import('source.class.user_page');
		$page = new Page($count, 10);
		$show = $page->show();
		
		$list = D('Yousetdiscount')->where($where)->order("addtime desc")->limit($page->firstRow.','.$page->listRows)->select();
		
		foreach ($list as $key => &$val) {
			$val['allcount'] = D('Yousetdiscount_users')->where(array('store_id'=>$this->store_session['store_id'], 'yid'=>$val['id']))->count('id');
			$val['ydhcount'] = D('Yousetdiscount_users')->where(array('store_id'=>$this->store_session['store_id'], 'yid'=>$val['id'], 'discount'=>array('>',0),'state'=>1))->count('id');
			$val['wdhcount'] = D('Yousetdiscount_users')->where(array('store_id'=>$this->store_session['store_id'], 'yid'=>$val['id'], 'discount'=>array('>',0),'state'=>0))->count('id');
			$val['url'] = option('config.wap_site_url').'/yousetdiscount.php?action=index&id='.$val['id'].'&store_id='.$this->store_session['store_id'];

			$coupon_list = D('')->table("Yousetdiscount_direction as y")
		        ->join('Coupon as c ON y.coupon_id=c.id','LEFT')
		        ->where("y.yid=".$val['id'])
		        ->field("y.*,c.face_money,c.number,c.total_amount")
		        ->select();

			$val['coupon_list'] = !empty($coupon_list) ? $coupon_list : array();

			if ($val['startdate'] <= $time && $val['enddate'] > $time) {
				$val['time_status'] = 'ing';
			} else if ($val['enddate'] < $time) {
				$val['time_status'] = 'end';
			} else if ($val['startdate'] > $time) {
				$val['time_status'] = 'future';
			}

		}

		$this->assign('keyword', $keyword);
		$this->assign('type', $type);
		$this->assign('page', $show);
		$this->assign('list', $list);
		
	}

	// 添加活动
	public function set () {
		if (IS_POST) {

			$id = isset($_POST['data']['id']) ? intval($_POST['data']['id']) : 0;

			$info['name'] = isset($_POST['data']['name']) ? $_POST['data']['name'] : '';
			$info['startdate'] = isset($_POST['data']['startdate']) ? $_POST['data']['startdate'] : '';
			$info['enddate'] = isset($_POST['data']['enddate']) ? $_POST['data']['enddate'] : '';

			$info['fxpic'] = isset($_POST['data']['fxpic']) ? $_POST['data']['fxpic'] : '';
			$info['fxtitle'] = isset($_POST['data']['fxtitle']) ? $_POST['data']['fxtitle'] : '';
			$info['fxinfo'] = isset($_POST['data']['fxinfo']) ? $_POST['data']['fxinfo'] : '';
			$info['fxtitle2'] = isset($_POST['data']['fxtitle2']) ? $_POST['data']['fxtitle2'] : '';
			$info['fxinfo2'] = isset($_POST['data']['fxinfo2']) ? $_POST['data']['fxinfo2'] : '';

			$info['bg1'] = isset($_POST['data']['bg1']) ? $_POST['data']['bg1'] : '';
			$info['bg2'] = isset($_POST['data']['bg2']) ? $_POST['data']['bg2'] : '';
			$info['my_count'] = isset($_POST['data']['my_count']) ? intval($_POST['data']['my_count']) : 0;
			$info['friends_count'] = isset($_POST['data']['friends_count']) ? intval($_POST['data']['friends_count']) : 0;
			$info['playtime'] = isset($_POST['data']['playtime']) ? intval($_POST['data']['playtime']) : 0;
			$info['money_end'] = isset($_POST['data']['money_end']) ? intval($_POST['data']['money_end']) : 0;

			$info['bg3'] = STATIC_URL.'yousetdiscount/images/yellowtit.png';
			$info['gamepic1'] = STATIC_URL.'yousetdiscount/img/m0.png';
			$info['gamepic2'] = STATIC_URL.'yousetdiscount/img/mb0.png';

			$info['info'] = isset($_POST['data']['info']) ? $_POST['data']['info'] : '';
			$info['is_open'] = isset($_POST['data']['is_open']) ? intval($_POST['data']['is_open']) : 0;
			$info['is_attention'] = isset($_POST['data']['is_attention']) ? intval($_POST['data']['is_attention']) : 0;
			$info['store_id'] = $this->store_session['store_id'];

			$direction = isset($_POST['data']['direction']) ? $_POST['data']['direction'] : array();

			$info['startdate'] = strtotime(trim($info['startdate']));
			$info['enddate'] = strtotime(trim($info['enddate']));

			if ($info['startdate'] >= $info['enddate']) {
				json_return(0, '开始时间不能大于结束时间');
			}

			$yousetdiscount = D('Yousetdiscount')->where(array('id'=>$id, 'store_id'=>$this->store_session['store_id']))->find();
			if (!empty($yousetdiscount)) {	// 修改

				// 活动开启后不允许修改 兑换
				// $del_direction = D('Yousetdiscount_direction')->where(array('store_id'=>$this->store_session['store_id'],'yid'=>$id))->delete();

				// foreach ($direction as $val) {
				// 	$add_data = array(
				// 		'yid' => $id,
				// 		'store_id' => $this->store_session['store_id'],
				// 		'at_least' => $val['at_least'],
				// 		'coupon_id' => $val['coupon'],
				// 	);
				// 	$id_direction = D('Yousetdiscount_direction')->data($add_data)->add();
				// }

				D('Yousetdiscount')->where(array('id'=>$id, 'store_id'=>$this->store_session['store_id']))->data($info)->save();

				json_return(0, '修改成功');

			} else {				

				$direction_count = count($direction);
				if ($direction_count < 2) {
					json_return(0, '至少需要两个兑换档次');
				}

				if ($direction_count > 4) {
					json_return(0, '优惠档次最多为4个');
				}

				$info['addtime'] = time();
				// 添加
				$id = D('Yousetdiscount')->data($info)->add();
				foreach ($direction as $val) {
					$add_data = array(
						'yid' => $id,
						'store_id' => $this->store_session['store_id'],
						'at_least' => $val['at_least'],
						'coupon_id' => $val['coupon'],
					);
					$id_direction = D('Yousetdiscount_direction')->data($add_data)->add();
				}

				json_return(0, '添加成功');

			}
			
		} else {
			json_return(1, '非法访问');
		}
	}

	// 显示添加页
	public function _create () {
	}

	// 修改
	public function _edit () {

		$yid = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$yousetdiscount = D('Yousetdiscount')->where(array('id'=>$yid))->find();

		$coupon_list = D('')->table("Yousetdiscount_direction as y")
		        ->join('Coupon as c ON y.coupon_id=c.id','LEFT')
		        ->where("y.yid=".$yid)
		        ->field("y.*,c.face_money,c.number,c.total_amount")
		        ->select();

		// 优惠劵列表
		$this->assign('yousetdiscount', $yousetdiscount);
		$this->assign('coupon_list', $coupon_list);
	}

	// 更新
	public function doupdate () {

	}

	// 参与者订单
	public function _order () {
		
	}

	// 操作
	public function operate () {

		$yousetdiscount_database = D('Yousetdiscount');
		$type = $_POST['type'];
		$where_yousetdiscount['id'] = isset($_POST['yid']) ? intval($_POST['yid']) : 0;
		$where_yousetdiscount['store_id'] = $this->store_session['store_id'];

		switch ($type) {

			case 'del':

				$del = $yousetdiscount_database->where($where_yousetdiscount)->delete();
				if ($del > 0) {
					json_return(0, '删除成功');
				}
				break;

			case 'stop':
				$save_yousetdiscount['is_open'] = 1;
				$update = $yousetdiscount_database->where($where_yousetdiscount)->data($save_yousetdiscount)->save();
				if ($update > 0) {
					json_return(0, '关闭成功');
				}
				break;

			case 'start':
				$save_yousetdiscount['is_open'] = 0;
				$update = $yousetdiscount_database->where($where_yousetdiscount)->data($save_yousetdiscount)->save();
				if ($update > 0) {
					json_return(0, '开启成功');
				}
				break;

		}

		json_return(1, '操作失败，稍后再试');
		exit;

	}

	//优惠领取记录
	public function _record () {

		$yid = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;

		$database_y = D('Yousetdiscount');
		$database_user = D('User');
		$database_coupon = D('Coupon');
		$database_yuser = D('Yousetdiscount_users');

		$yinfo = $database_y->where(array('id'=>$yid))->find();

		$where_order['store_id'] = $this->store_session['store_id'];
		$where_order['yid'] = $yid;

		$count = $database_yuser->where($where_order)->count('id');

		import('source.class.user_page');
		$page = new Page($count, 20);
		$show = $page->show();

		$yuser_list = $database_yuser->where($where_order)->order("addtime desc")->limit($page->firstRow.','.$page->listRows)->select();

		foreach ($yuser_list as &$val) {
			$find_user = $database_user->where(array('uid'=>$val['uid']))->find();
			$val['name'] = $find_user['nickname'];
			$val['phone'] = $find_user['phone'];
			$val['avatar'] = !empty($find_user['avatar']) ? $find_user['avatar'] : option('config.site_url').'/static/images/avatar.png';
			$val['coupon'] = $database_coupon->where(array('id'=>$val['coupon_id']))->find();
		}

		$this->assign("page", $show);
		$this->assign("yinfo", $yinfo);
		$this->assign("yuser_list", $yuser_list);

	}

}
?>