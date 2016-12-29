<?php
class shakelottery_controller extends base_controller{
	public function __construct() {
		parent::__construct();
		$this->user_session=$_SESSION['user'];
	}
	public function load(){
		$action = strtolower(trim($_POST['page']));
		if (empty($action)) pigcms_tips('非法访问！', 'none');
		$id=!empty($_POST['id']) ? intval($_POST['id']) : 0;
		switch ($action) {
			case 'lottery_list' :
				$this->_lottery_list();
				break;
			case 'create' :
				$this->_create();
				break;
			case 'edit' :
				$this->_edit($id);
				break;
			case 'recordlist':
				$this->_recordlist($id);
				break;
			case 'edit_record':
				$this->_edit_record($id);
				break;
			case 'prizelist':
				$this->_prizelist($id);
				break;
			case 'addprize_good':
				$this->_addprize_good($id);
				break;
			case 'editprize_good':
				$this->_editprize_good($id);
				break;
			case 'addprize_fictitiou':
				$this->_addprize_fictitiou($id);
				break;
			case 'editprize_fictitiou':
				$this->_editprize_fictitiou($id);
				break;
			case 'order_info':
				$this->_order_info($id);
				break;
			default:
				break;
		}
		// var_dump($action);
		$this->display($_POST['page']);
	}
	public function shakelottery_index(){
		$this->display();
	}
	public function _lottery_list(){
		$type = $_REQUEST['type'];
		$type = !empty($type) ? $type : 'all';
		$where = '`store_id`='.$this->store_session['store_id'];
		switch ($type) {
			case 'open':
				$where .= ' AND `status`=1';
				break;
			case 'close':
				$where .= ' AND `status`=0';
				break;
			default:
				break;
		}
		import('source.class.user_page');
		$count=D('Shakelottery')->where($where)->count();
		$page = new Page($count, 10);
		$show = $page->show();
		$lottery_list=D('Shakelottery')->where($where)->limit($page->firstRow.','.$page->listRows)->order('id DESC')->select();
		$this->assign("page", $show);
		$this->assign('type', $type);
		$this->assign("lottery_list",$lottery_list);
	}
	public function _create(){
	}
	public function _edit($id){
		if(empty($id)){  json_return(102, '参数错误'); }
		$lotteryInfo=D('Shakelottery')->where(array('id'=>$id))->find();
		$this->assign('lotteryInfo',$lotteryInfo);

	}
	// 活动新增/修改
	public function doupdate(){
		$info=$_POST;
		$this->post_filter($info);
		$info['starttime']=strtotime($info['starttime']);
		$info['endtime']=strtotime($info['endtime']);
		$info['store_id']=$this->store_session['store_id'];
		$info['reply_pic'] = !empty($info['reply_pic']) ? getAttachment($info['reply_pic']) : '';
		$product_id=$info['product_id'];
		unset($info['product_id']);
		if(empty($product_id)){
			$lastId=D('Shakelottery')->data($info)->add();
			json_return(0, $lastId);
		}else{
			unset($info['store_id']);
			$effId=D('Shakelottery')->where(array('id'=>$product_id))->data($info)->save();
			json_return(0, $effId);
		}
	}
	// 活动信息过滤
	protected function post_filter($info){
		if(empty($info['action_name']) ){
			json_return(101,"活动名称不能为空");
		}
		if(empty($info['remind_word']) ){
			json_return(101,"广告语不能为空");
		}
		if(empty($info['remind_link'])){
			json_return(101,"广告跳转地址不能为空");
		}
		if(!is_numeric($info['totaltimes']) || (int)$info['totaltimes'] < 0){
			json_return(101,"总共摇奖次数请输入大于0的整数");
		}
		if(!is_numeric($info['everydaytimes'])){
			json_return(101,"每人每天摇奖次数请输入整数");
		}
		if(!is_numeric($info['join_number'])){
			json_return(101,"预计参与人数请输入整数");
		}elseif($info['join_number'] == ''){
			json_return(101,"预计参与人数不能为空");
		}
		if((int)$info['everydaytimes'] > (int)$info['totaltimes']){
			json_return(101,"每人每天摇奖次数不能大于总共摇奖次数");
		}
		if(empty($info['starttime'] ) ){
			json_return(101,"活动开始时间不能为空");
		}
		if(empty($info['endtime']) ){
			json_return(101,"活动结束时间不能为空");
		}
		if($info['starttime'] > $info['endtime']){
			json_return(101,"活动开始时间不能大于活动结束时间");
		}
	}
	// 摇奖记录
	public function _recordlist($id){
		if(empty($id)){  json_return(102, '参数错误'); }
		$type = !empty($_POST['type']) ? trim($_POST['type']) : 'win';
		$where = '`aid`='.$id;
		switch ($type) {
			case 'win':
				$where .= ' AND `iswin`=1';
				break;
			case 'lose':
				$where .= ' AND `iswin`=0';
				break;
			default:
				break;
		}
		import('source.class.user_page');
		$count=D('Shakelottery_record')->where($where)->count('id');
		$page = new Page($count, 10);
		$show = $page->show();
		$recordList=D('Shakelottery_record')->where($where)->limit($page->firstRow.','.$page->listRows)->order('id DESC')->select();
		$this->assign("page", $show);
		$this->assign("recordList",$recordList);
		$this->assign("type",$type);
		$this->assign('aid',$id);
	}
	// 奖品列表
	public function _prizelist($id){
		if(empty($id)){  json_return(106, '参数错误'); }
		import('source.class.user_page');
		$where='`aid`='.$id;
		$count=D('Shakelottery_prize')->where($where)->count('id');
		$page = new Page($count, 10);
		$show = $page->show();
		$prizelist=D('Shakelottery_prize')->where($where)->limit($page->firstRow.','.$page->listRows)->order('id DESC')->select();

		$this->assign("id",$id);
		$this->assign("page", $show);
		$this->assign("prizelist",$prizelist);
	}
	// 添加实物奖品页
	protected function _addprize_good($aid){//活动ID
		if(empty($aid)){  json_return(106, '参数错误'); }
		$this->assign('activeId',$aid);
	}
	// 添加虚拟奖品页
	protected function _addprize_fictitiou($aid){
		if(empty($aid)){  json_return(106, '参数错误'); }
		$time = $_SERVER['REQUEST_TIME'];
		$where = array();
		$where['uid'] = $_SESSION['store']['uid'];
		$where['store_id'] = $_SESSION['store']['store_id'];
		$where['status'] = 1;//正常状态
		// $where['type'] = 2;//赠送券
		$where['start_time'] = array('<=', $time);
		$where['end_time'] = array('>=', $time);
		// 优惠券
		$coupon_list = M('Coupon')->getList($where);
		$this->assign('coupon_list', $coupon_list);
		$this->assign('activeId',$aid);
	}
	// 编辑实物奖品页
	public function _editprize_good($id){//奖品ID
		if(empty($id)){  json_return(106, '参数错误'); }
		$prizeInfo=D('Shakelottery_prize')->where(array('id'=>$id))->find();
		$prizeInfo['prizeimg']=getAttachmentUrl($prizeInfo['prizeimg']);
		if(empty($prizeInfo['sku_id'])){
			$sku_info=D('Product')->where(array('product_id'=>$prizeInfo['product_id']))->field('product_id,quantity')->find();
		}else{
			$sku_info=D('Product_sku')->where(array('sku_id'=>$prizeInfo['sku_id']))->field('sku_id,quantity')->find();
		}
		$prizeInfo['quantity']=$sku_info['quantity'];
		$this->assign('prizeInfo',$prizeInfo);
	}
	// 编辑虚拟奖品页
	public function _editprize_fictitiou($id){//奖品ID
		if(empty($id)){  json_return(106, '参数错误'); }
		$prizeInfo=D('Shakelottery_prize')->where(array('id'=>$id))->find();
		$time = $_SERVER['REQUEST_TIME'];
		$where = array();
		$where['uid'] = $_SESSION['store']['uid'];
		$where['store_id'] = $_SESSION['store']['store_id'];
		$where['status'] = 1;
		// $where['type'] = 2;
		$where['start_time'] = array('<=', $time);
		$where['end_time'] = array('>=', $time);
		if($prizeInfo['prize_type']==2){
			$couponInfo=D('Coupon')->where(array('id'=>$prizeInfo['product_id']))->field('total_amount,number')->find();
			$prizeInfo['coupon_ku']=$couponInfo['total_amount']-$couponInfo['number'];
		}
		// 优惠券
		$coupon_list = M('Coupon')->getList($where);
		$this->assign('coupon_list', $coupon_list);
		$this->assign('prizeInfo',$prizeInfo);
	}
	// 新增/修改  实物和虚拟奖品
	public function setproduct(){
		$info=$_POST;
		if(intval($info['prize_type'])>1){
			$this->filter_fictitiou($info);//虚拟奖品验证
		}
		$info['prizeimg']=getAttachment($info['prizeimg']);
		$prize_id=intval($info['prize_id']);
		unset($info['prize_id']);
		if(empty($prize_id)){
			$lastId=D('Shakelottery_prize')->data($info)->add();
		}else{
			$effId=D('Shakelottery_prize')->where(array('id'=>$prize_id))->data($info)->save();
		}
		json_return(0,"ok");
	}
	// 虚拟奖品验证
	protected function filter_fictitiou($info=array()){
		if(empty($info)){
			json_return(101,"请填写奖品信息");
		}
		if(empty($info['aid'])){
			json_return(102,"活动异常错误");
		}
		$prize_type=intval($info['prize_type']);
		if(empty($info['prizenum'])){
			json_return(104,"请输入奖品数量，且大于0");
		}
		$prize_id = intval($info['prize_id']);
		if($prize_type==2 && !empty($prize_id)){//优惠券
			$prizeInfo=D('Shakelottery_prize')->where(array('id'=>$prize_id))->find();
			if(empty($prizeInfo)){
				json_return(113,"奖品异常");
			}
			$couponInfo=D('Coupon')->where(array('id'=>$prizeInfo['product_id']))->field('total_amount,number')->find();
			if(!empty($info['prize_id']) && $info['prizenum']<$prizeInfo['expendnum']){
				json_return(105,"奖品数量必须大于等于奖品消耗数量");
			}
			if($info['prizenum']>($couponInfo['total_amount']-$couponInfo['number'])){
				json_return(106,"奖品数量不能大于库存数量");
			}
			if(empty($info['product_id'])){
				json_return(106,"请选择优惠券");
			}
		}
		if(empty($info['prizename']) || empty($info['value'])){
			json_return(106,"提交数据错误");
		}
	}
	// 删除 奖品  不论实物还是虚拟
	public function delproduct(){
		if(!empty($_POST['goodid'])){
			$goodid=intval($_POST['goodid']);
			D('Shakelottery_prize')->where(array('id'=>$goodid))->delete();
			json_return(0,"ok");
		}else{
			json_return(101,"参数错误");
		}
	}
	// 生成二维码
	public function toCode(){
		import('source.class.phpqrcode');
		if($_GET['id']){
			$id=intval($_GET['id']);
			$url=option('config.site_url')."/wap/shakelottery.php?id=".$id;
			QRcode::png($url);
		}
	}
	// 修改奖品领取状态 获取奖品图像
	public function _edit_record($id){
		if(empty($id)){  json_return(106, '参数错误'); }
		$where = 'record.prizeid = prize.id AND record.id='.$id;
		$field = 'record.id as recordid,record.prizename as prizename,record.phone as phone,record.isaccept as isaccept,record.wecha_name as wecha_name,record.aid as aid';
		$info = D('')->table(array('pigcms_shakelottery_record'=>'record','pigcms_shakelottery_prize'=>'prize'))->where($where)->field($field)->find();
		$this->assign('info',$info);
	}
	// 修改奖品领取状态
	public function record_post_edit(){
		$id=$_POST['recordid'];
		if(empty($id)){  json_return(106, '参数错误'); }
		$isaccept= intval($_POST['isaccept']);
		$data=array();
		$data['isaccept']=$isaccept;
		$data['accepttime']=empty($isaccept) ? '' : $_SERVER['REQUEST_TIME'];
		D('Shakelottery_record')->where(array('id'=>$id))->data($data)->save();
		json_return(0,"ok");
	}
	// 删除抽奖记录
	public function del_record(){
		$id=$_GET['recordid'];
		if(empty($id)){  json_return(106, '参数错误'); }
		D('Shakelottery_record')->where(array('id'=>$id))->delete();
		json_return(0,"ok");
	}
	// 删除摇一摇抽奖活动
	public function del_active(){
		$id=$_GET['id'];
		if(empty($id)){  json_return(106, '参数错误'); }
		D('Shakelottery')->where(array('id'=>$id))->delete();
		json_return(0,"ok");
	}
	// 订单详情
	public function _order_info($id){//订单ID
		if(empty($id)){   json_return(106, '参数错误');  }
		$info=D('Shakelottery_record')->where(array('id'=>$id))->find();
		$where_order = '`order_id`='.$info['order_id'];
		$order=D('Order')->where($where_order)->field('order_id,status')->find();
		switch ($order['status']) {
			case '0':
				$info['order_status']='临时订单';
				break;
			case '1':
				$info['order_status']='未支付';
				break;
			case '2':
				$info['order_status']='未发货';
				break;
			case '3':
				$info['order_status']='已发货';
				break;
			case '4':
				$info['order_status']='已完成';
				break;
			case '5':
				$info['order_status']='已取消';
				break;
			case '6':
				$info['order_status']='退款中';
				break;
			case '7':
				$info['order_status']='已收货';
				break;
		}
		$this->assign('info',$info);
	}



}


 ?>