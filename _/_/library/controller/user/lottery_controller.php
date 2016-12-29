<?php
/**
 * 游戏活动
 */
class lottery_controller extends base_controller {
	// 加载
	public function load() {
		$action = strtolower(trim($_POST['page']));
		if (empty($action)) pigcms_tips('非法访问！', 'none');
	
		switch ($action) {
			case 'lottery_list' :
				$this->_lottery_list();
				break;
			case 'edit' :
				$this->_edit();
				break;
			case 'info' :
				$this->_info();
				break;
			case 'order' :
				$this->_order();
				break;
			case 'create' :
				$this->_create();
				break;
			case 'data' :
				$this->_data();
				break;
			default:
				break;
		}
		//exit($action);
		$this->display($_POST['page']);
	}
	
	// 游戏活动列表
	function lottery_index(){
		$this->display();
	}
	
	private function _lottery_list(){
		// 游戏类型 1大转盘2九宫格3刮刮卡4水果机5砸金蛋0未知
		$lottery_type = array(0=>'未知',1=>'大转盘',2=>'九宫格',3=>'刮刮卡',4=>'水果机',5=>'砸金蛋');
		$type = $_REQUEST['type'];
		$p = max(1,(int)$_REQUEST['p']);
		$keyword = $_REQUEST['keyword'];
		$type_arr = array('future', 'on', 'end', 'all');
		if (!in_array($type, $type_arr)) {
			$type = 'all';
		}
		$where['status'] = array('!=',3);
		$where['store_id'] = $_SESSION['store']['store_id'];
		$order_by_field = 'id desc';
		if (!empty($keyword)) {
			$where['title'] = array('like', '%' . $keyword . '%');
		}
		$time = time();
		if ($type == 'future') {
			$where['starttime'] = array('>', $time);
		} else if ($type == 'on') {
			$where['status'] = array('not in',array(1,3));
			$where['starttime'] = array('<', $time);
			$where['endtime'] = array('>', $time);
		} else if ($type == 'end') {
			$where = "`store_id` = '" . $_SESSION['store']['store_id'] . "' AND (`endtime` < '" . $time . "' OR `status` = '2') and(`status`!=3)";
		}
		
		$count = D('Lottery')->field('count(1) as count')->where($where)->find();
		import('source.class.user_page');
		$page = new Page($count['count'], 10,$p);
		$lottery_list = D('Lottery')->where($where)->order($order_by_field)->limit($page->firstRow.','.$page->listRows)->select();
		// 关联的商品
		/*if($cutprice_list){
			foreach($cutprice_list as $key => $item){
				$cutprice_list[$key]['product'] = D('Product')->where(array('product_id'=>$item['product_id']))->find();
			}
		}*/
		$this->assign('keyword', $keyword);
		$this->assign('type', $type);
		$this->assign('pages', $page->show());
		$this->assign('lottery_list',$lottery_list);
		$this->assign('lottery_type',$lottery_type);
	}
	
	// 显示添加页
	public function _create () {
		$group_list = M('Product_group')->get_all_list($this->store_session['store_id']);
		
		$time = time();
		$where = array();
		$where['uid'] = $_SESSION['store']['uid'];
		$where['store_id'] = $_SESSION['store']['store_id'];
		$where['status'] = 1;
		$where['type'] = 1;
		$where['start_time'] = array('<=', $time);
		$where['end_time'] = array('>=', $time);
		// 优惠券
		$coupon_list = M('Coupon')->getList($where);
		$this->assign('group_list', $group_list);
		$this->assign('coupon_list',$coupon_list);
	}
	
	// 编辑抽奖活动
	public function _edit()
	{	
		$store_id = $_SESSION['store']['store_id'];
		$active_id = (int)$_POST['id'];
		$lottery = D('Lottery')->where(array('id'=>$active_id, 'store_id'=>$store_id))->find();
		if (!$lottery) {
			exit('参数错误');
		}
		// 判断是否可以再编辑
		/*if($lottery['starttime']<=time()||$lottery['status'] > 0){
			exit('已开始的活动无法再次编辑');
		}*/
		
		$lottery_prizes = array();
		$tmp = D('Lottery_prize')->where(array('lottery_id'=>$lottery['id']))->select();
		if($tmp){
			foreach($tmp as $key => $prize){
				// 获取商品图片
				$product = D('Product')->field('image')->where(array('product_id'=>$prize['product_id']))->find();
				$prize['image'] = $product['image'];
				$lottery_prizes[$prize['prize_type']] = $prize;
			}
		}
		// 优惠券
		$time = time();
		$where = array();
		$where['uid'] = $_SESSION['store']['uid'];
		$where['store_id'] = $_SESSION['store']['store_id'];
		$where['status'] = 1;
		$where['type'] = 1;
		$where['start_time'] = array('<=', $time);
		$where['end_time'] = array('>=', $time);
		$coupon_list = M('Coupon')->getList($where);
		
		$this->assign("lottery", $lottery);
		$this->assign('lottery_prizes',$lottery_prizes);
		$this->assign('coupon_list',$coupon_list);
	}
	
	// 保存抽奖活动
	public function save(){
		$postData = $_POST['data'];
		$game_type = explode(',', $postData['game_type']);
		if(!$game_type){
			json_return(1001,'请选择活动表现形式');
		}
		// 奖项设置数据校验
		$res = $this->checkPrizeData($postData);
		if(res.err_code>0){
			json_return($res['err_code'],$res['err_msg']);
		}
		// 数据保存
		$data['store_id'] = $_SESSION['store']['store_id'];
		$data['anwei'] = $postData['anwei_id'];
		$data['title'] = $postData['title'];
		$data['win_info'] = $postData['win_info'];
		$data['win_tip'] = $postData['win_tip'];
		$data['starttime'] = strtotime($postData['starttime']);
		$data['endtime'] = strtotime($postData['endtime']);
		if($data['starttime']>=$data['endtime']){
			json_return(1001,'开始时间不能早于结束时间');
		}
		$data['active_desc'] = $postData['active_desc'];
		$data['endtitle'] = $postData['endtitle'];
		$data['rejoin_tip'] = $postData['rejoin_tip'];
		$data['backgroundThumImage'] = getAttachment($postData['backgroundThumImage']);
		$data['fill_type'] = $postData['fill_type'];
		$data['isshow_num'] = $postData['isshow_num'];
		$data['win_limit'] = $postData['win_limit'];
		$data['win_limit_extend'] = $postData['win_limit_extend'];
		$data['win_limit_share_extend'] = $postData['win_limit_share_extend'];
		$data['need_subscribe'] = $postData['need_subscribe'];
		$data['win_type'] = $postData['win_type'];
		$data['win_type_extend'] = $postData['win_type_extend'];
		$data['password'] = $postData['win_password'];
		$data['createtime'] = time();
		// 保存基础数据
		$edit_lottery_id = (int)$_POST['lottery_id'];
		foreach($game_type as $game){
			$data['type'] = $game;
			if($edit_lottery_id){
				D('Lottery')->where(array('id'=>$edit_lottery_id))->data($data)->save();
			}else{
				$lottery_id = D('Lottery')->data($data)->add();
			}
			
			// 保存奖项数据
			$data_prize['lottery_id'] = $lottery_id;
			for($i=1;$i<=6;$i++){
				if($postData['prize_'.$i]){
					$data_prize['prize_type'] = $i;
					$data_prize['prize'] = $postData['prize_'.$i];
					$data_prize['product_id'] = $postData['product_id_'.$i];
					$data_prize['sku_id'] = $postData['sku_id_'.$i];
					$data_prize['product_name'] = $postData['product_name_'.$i];
					$data_prize['coupon'] = $postData['coupon_'.$i];
					$data_prize['product_recharge'] = $postData['product_recharge_'.$i];
					$data_prize['product_num'] = $postData['product_num_'.$i];
					$data_prize['rates'] = $postData['rates_'.$i];
					if($edit_lottery_id){
						$data_prize['lottery_id'] = $edit_lottery_id;
						D('Lottery_prize')->where(array('lottery_id'=>$edit_lottery_id,'prize_type'=>$i))->data($data_prize)->save();
					}else{
						D('Lottery_prize')->data($data_prize)->add();
					}
				}
			}
		}
		json_return(0,'保存成功');
	}
	
	private function checkPrizeData($data){
		if($data['title']==''){
			return array('err_code' => 1,'err_msg'=>'请填写活动标题');
		}
		if($data['win_info']==''){
			return array('err_code' => 1,'err_msg'=>'请填写兑奖信息');
		}
		if($data['win_tip']==''){
			return array('err_code' => 1,'err_msg'=>'请填写中奖提示');
		}
		if($data['starttime']==''||$data['endtime']==''){
			return array('err_code' => 1,'err_msg'=>'请填写活动开始时间和结束时间');
		}
		if($data['active_desc']==''){
			return array('err_code' => 1,'err_msg'=>'请填写活动说明');
		}
		if($data['endtitle']==''){
			return array('err_code' => 1,'err_msg'=>'请填写活动结束提示语');
		}
		if($data['rejoin_tip'] == ''){
			return array('err_code' => 1,'err_msg'=>'请填写重复参与提示');
		}
		/*if($data['backgroundThumImage']==''){
			return array('err_code' => 1,'err_msg'=>'请上传活动背景图');
		}*/
		return array('err_code'=>0,'err_msg'=>'ok');
	}
	
	// 使失效
	public function disabled() {
		$id = (int)$_GET['id'];
		if (!$id) {
			json_return(1001, '缺少最基本的参数ID');
		}
		// 找到对应的活动
		$lottery = D('Lottery')->where(array('id'=>$id))->find();
		if (!$lottery) {
			json_return(1001, '未找到对应的活动');
		}
		$data = array();
		$data['status'] = 1;	// 失效
		D('Lottery')->where(array('id'=>$id))->data($data)->save();
		json_return(0, '操作完成');
	}
	
	// 删除
	public function delete() {
		$id = (int)$_GET['id'];
		$type = trim($_GET['type']);
		if($type=='del_prize_record'){
			D('Lottery_record')->where(array('id'=>$id))->delete();
			json_return(0,'删除成功');
		}
		
		if (!$id) {
			json_return(1001, '缺少最基本的参数ID');
		}
		// 找到对应的活动
		$lottery = D('Lottery')->where(array('id'=>$id))->find();
		if (!$lottery) {
			json_return(1001, '未找到对应的活动');
		}
		$data = array();
		$data['status'] = 3;	// 删除
		D('Lottery')->where(array('id'=>$id))->data($data)->save();
		json_return(0, '操作完成');
	}
	
	// 抽奖数据
	public function _data(){
		$active_id = (int)$_POST['id'];
		$p = max(1,(int)$_REQUEST['p']);
		$lottery = D('Lottery')->where(array('id'=>$active_id))->find();
		if(!$lottery){
			exit('没有找到该活动');
		}
		
		$where_record = array('active_id'=>$lottery['id']);
		$count = D('Lottery_record')->field('count(1) as count')->where($where_record)->find();
		import('source.class.user_page');
		$page = new Page($count['count'], 10,$p);
		$lottery_record = D('Lottery_record')->where($where_record)->order('status asc,id desc')->limit($page->firstRow.','.$page->listRows)->select();
		
		$lottery_prizes = $users = false;
		if($lottery_record){
			$prize_ids = $uids = array();
			foreach($lottery_record as $record){
				if(!in_array($record['prize_id'],$prize_ids)){
					$prize_ids[] = $record['prize_id'];
				}
				
				if(!in_array($record['user_id'],$uids)){
					$uids[] = $record['user_id'];
				}
			}
			if($prize_ids){
				$where_prize['lottery_id'] = $active_id;
				$where_prize['prize_type'] = array('in',$prize_ids);
				$lottery_prizes = D('Lottery_prize')->where($where_prize)->field('prize_type,prize,product_name')->select();
				if($lottery_prizes){
					$tmp_prize = array();
					foreach($lottery_prizes as $_prize){
						$tmp_prize[$_prize['prize_type']] = $_prize;
					}
					$lottery_prizes = $tmp_prize;
				}
			}
			if($uids){
				$where['uid'] = array('in',$uids);
				$users = D('User')->where($where)->field('uid,nickname,phone')->select();
				if($users){
					$tmp = array();
					foreach($users as $item){
						$tmp[$item['uid']] = $item;
					}
					$users = $tmp;
				}
			}
		}
		$this->assign('lottery',$lottery);
		$this->assign('lottery_prizes',$lottery_prizes);
		$this->assign('lottery_record',$lottery_record);
		$this->assign('users',$users);
		$this->assign('pages', $page->show());
	}
}