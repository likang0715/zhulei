<?php
/**
 *  摇一摇抽奖   zhangzeyun
 */

// // 积分赠送
// import('source.class.Margin');
// $open_margin_recharge = Margin::check();
// $credit_setting = D('Credit_setting')->find();
// $platform_credit_name = $credit_setting['platform_credit_name'] ;
// $platform_credit_name = $platform_credit_name ? $platform_credit_name : "平台币";

require_once dirname(__FILE__).'/global.php';

$shake=new shakelottery();
$a=!empty($_GET['a']) ? trim($_GET['a']) : 'index';


// var_dump($_SESSION['wap_user']);exit;
call_user_func(array($shake,$a));
class shakelottery{
	public $userInfo;
	public $actioninfo;
	public function __construct(){
		$this->userInfo=$_SESSION['wap_user'];
	}
	public function index(){
		if(empty($_GET['id'])){
			pigcms_tips('您访问的活动不存在', 'none');
		}
		$id=intval($_GET['id']);
		$this->actioninfo=$actioninfo=D('Shakelottery')->where(array('id'=>$id))->find();
		if(empty($this->userInfo)){
			$url=option('config.site_url').'/wap/shakelottery.php?id='.$id;
			pigcms_tips('请先授权登录', 'login.php?referer='.urlencode($url),true);
		}
		if(empty($actioninfo)){
			pigcms_tips('活动不存在', 'none');
		}
		if($actioninfo['status'] == 0){
			pigcms_tips('活动已经关闭', 'none');
		}
		//奖品列表
		$prize=D('Shakelottery_prize')->where(array('aid'=>$id))->order('prizenum asc')->select();

		//提示语
		//$stat = $this->public_notice($actioninfo,$userinfo['tel']);
		$notice_content =  '';
		// $notice_content =  'no_follow';

		//增加参与者
		$user_id = $this->addPlayer();
		//每日清空摇奖次数
		$this->clear_shake_day($user_id);

		//分享配置 start
		$share_conf 	= array(
			'title'    	=> empty($actioninfo['custom_sharetitle']) ? '我正在参加'.$actioninfo['action_name'].'活动，摇手机轻松赢取丰厚奖品！' : $actioninfo['custom_sharetitle'],   // 分享标题
			'desc' 	   	=> str_replace(array("\r","\n"), array('',''), $actioninfo['custom_sharedsc']), // 分享描述
			'link' 		=> 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], // 分享链接
			'imgUrl' 	=> empty($actioninfo['reply_pic']) ? option('config.site_url').'/template/wap/default/images/shakelottery/shakelottery.jpg' :  getAttachmentUrl($actioninfo['reply_pic']),
			'types'		=> 'shakelottery', // 分享类型,music、video或link，不填默认为link
			'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
			'uid'           => $this->userInfo['uid'],
			'store_id'      => $actioninfo['store_id'],
			'data_id'       => $actioninfo['id']
		);
		import('WechatShare');
		$share 		= new WechatShare();
		$shareData 	= $share->getSgin($share_conf);
		//分享配置 end
		include display('lottery_index');exit;
	}
	public function ajaxReturnPrize(){
		if(empty($this->userInfo)){
			echo '{"status":"errormsg","msg":"请重新登录"}';exit;
		}
		if(empty($_GET['id'])){
			echo '{"status":"errormsg","msg":"活动不存在"}';exit;
		}
		$id = intval($_GET['id']);
		$this->actioninfo=$actioninfo = D('Shakelottery')->where(array('id'=>$id))->find();
		if(empty($actioninfo)){
			echo '{"status":"errormsg","msg":"抽奖活动不存在"}';exit;
		}
		if($actioninfo['status'] == 0){
			echo '{"status":"errormsg","msg":"抽奖活动未开启"}';exit;
		}
		if($actioninfo['starttime'] > $_SERVER['REQUEST_TIME']){
			echo '{"status":"errormsg","msg":"抽奖活动未开始,请注意页面的倒计时"}';exit;
		}
		if($actioninfo['endtime'] < $_SERVER['REQUEST_TIME']){
			echo '{"status":"errormsg","msg":"抽奖活动已结束"}';exit;
		}

		$where_user = '`aid`='.$id.' AND `uid`='.$this->userInfo['uid'];
		$player = D('Shakelottery_users')->where($where_user)->find();
		if(empty($player)){ echo '{"status":"errormsg","msg":"抽奖失败"}';exit; }

		// 中过一次奖的记录
		$todaytime = strtotime(date("Y-m-d 00:00:00",$_SERVER['REQUEST_TIME']));
		$where_record = '`aid`='.$id.' AND `user_id`='.$player['id'].' AND `iswin`=1'.' AND `shaketime`>'.$todaytime;
		$lottery_record = D('Shakelottery_record')->where($where_record)->order('`id` desc')->find();

		$totay_lottery_count = D('Shakelottery_record')->where($where_record)->count('id');

		// 最后一次摇奖记录
		$where_lastshake = '`aid`='.$id.' AND `user_id`='.$player['id'];
		$lottery_last=D('Shakelottery_record')->where($where_lastshake)->order('`id` desc')->field('shaketime')->find();
		$lastshaketime = $lottery_last['shaketime'];
		if($_SERVER['REQUEST_TIME'] - $lastshaketime < 1){//防止重复摇奖
			echo '{"status":"timelimit","msg":""}';exit;
		}

		if($actioninfo['is_limitwin'] > 0 && ($totay_lottery_count >= $actioninfo['is_limitwin'])){
			echo '{"status":"errormsg","msg":"您今天的中奖次数超限，请明天再来吧"}';exit;
		}
		if($actioninfo['everydaytimes'] > 0 && $player['today_shakes'] >= $actioninfo['everydaytimes']){
			echo '{"status":"errormsg","msg":"您今天的摇奖次数已经超限,请明天再来吧"}';exit;
		}
		if($player['total_shakes'] >= $actioninfo['totaltimes']){  // *********
			echo '{"status":"errormsg","msg":"您的摇奖次数已经用完"}';exit;
		}
		if($actioninfo['integral_status']==1){//开启活动积分玩法
			// 检查用户剩余积分
			$user_poins = M('Store_user_data')->getUserData($actioninfo['store_id'], $_SESSION['wap_user']['uid']);
			if($user_poins['point']<$actioninfo['integral_nub']){
				echo '{"status":"errormsg","msg":"您的积分不足"}';exit;
			}
			$this->integral_use($actioninfo);//扣除积分
		}
		//上次中奖时间在规定时间区间内
		if($actioninfo['timespan'] > 0 && (time() - $lottery_record['shaketime'] < $actioninfo['timespan']*60 )){
			$prize = $this->lotteryPrize(true);
		}else{
			$prize = $this->lotteryPrize(false);
		}
		$iswin = ($prize['status'] == 'success') ? 1 : 0;
		$data = array();
		if($iswin == 1){
			$data['prizeid'] = $prize['msg']['id'];
			$data['prize_type'] = $prize['msg']['prize_type'];
			$data['prizename'] = $prize['msg']['prizename'];
		}
		$data['iswin'] = $iswin;
		$data['aid'] = $id;
		$data['user_id'] = $player['id'];
		$data['shaketime'] = $_SERVER['REQUEST_TIME'];
		$data['isaccept'] = 0;
		$data['accepttime'] = 0;
		$data['phone'] = $player['phone'];
		$data['wecha_name'] = $player['wecha_name'];
		$record_add = D('Shakelottery_record')->data($data)->add();

		// 记录更新
		unset($where_user);
		$where_user='`aid`='.$id.' AND `uid`='.$this->userInfo['uid'];
		$info='`total_shakes`=`total_shakes`+1,`today_shakes`=`today_shakes`+1';
		$player_update = D('Shakelottery_users')->where($where_user)->data($info)->save();

		D('Shakelottery')->where(array('id'=>$id))->data('`actual_join_number`=`actual_join_number`+1')->save();
		if(empty($record_add)  || empty($player_update)){
			echo '{"status":"errormsg","msg":"摇奖失败"}';exit;
		}
		if($iswin == 1){
			$prizeimg = '';
			switch ($prize['msg']['prize_type']) {
				case '1':
					$prizeimg = getAttachmentUrl($prize['msg']['prizeimg']);
					break;
				case '2':
					$prizeimg = option("config.site_url").'/template/wap/default/images/shakelottery/youhuiquan.jpg';
					break;
				case '3':
					$prizeimg = option("config.site_url").'/template/wap/default/images/shakelottery/jifen.jpg';
					break;
				default:
					$prizeimg = getAttachmentUrl($prize['msg']['prizeimg']);
					break;
			}
			echo '{"status":"success","prizename":"'.$prize['msg']['prizename'].'","prizeimg":"'.$prizeimg.'"}';exit;
		}else{
			echo '{"status":"error","msg":"'.$prize['msg'].'"}';exit;
		}
	}
	//公共提示语
	protected function public_notice($action_info = '',$tel = ''){
		// $stat = true;
		// //需要关注
		// if($action_info['is_follow'] == 0 && $this->isSubscribe() == false){
		// 	$follow_msg = (!empty($action_info['follow_msg'])) ? $action_info['follow_msg'] : '';
		// 	$custom_url = (!empty($action_info['custom_follow_url'])) ? $action_info['custom_follow_url'] : '';
		// 	$custom_btn_msg = (!empty($action_info['follow_btn_msg'])) ? $action_info['follow_btn_msg'] : '';
		// 	$this->assign('notice_content','no_follow');
		// 	$this->memberNotice($follow_msg,1,$custom_url,$custom_btn_msg);
		// 	$stat = false;
		// }
		// if($action_info['is_follow'] == 0 && $this->isSubscribe() == false) {
		// 	$follow_msg = (!empty($action_info['follow_msg'])) ? $action_info['follow_msg'] : '';
		// 	$custom_url = (!empty($action_info['custom_follow_url'])) ? $action_info['custom_follow_url'] : '';
		// 	$custom_btn_msg = (!empty($action_info['follow_btn_msg'])) ? $action_info['follow_btn_msg'] : '';
		// 	$this->assign('notice_content','no_follow');
		// 	$this->memberNotice($follow_msg,1,$custom_url,$custom_btn_msg);
		// 	$stat = false;
		// //需要注册
		// }elseif($action_info['is_register'] == 1 && $tel == ''){
		// 	$custom_register_msg = (!empty($action_info['register_msg'])) ? $action_info['register_msg'] : '';
		// 	$this->assign('notice_content','no_register');
		// 	$this->memberNotice($custom_register_msg);
		// 	$stat = false;
		// }else{
		// 	$this->assign('notice_content','');
		// }
		// return $stat;
	}
	// 增加参与者
	private function addPlayer(){
		$wap_user=$_SESSION['wap_user'];
		$where = '`aid`='.$this->actioninfo['id'].' AND `uid`='.$wap_user['uid'];
		$player = D('Shakelottery_users')->where($where)->find();
		if(empty($player)){
			$data = array();
			$data['uid'] = $wap_user['uid'];
			$data['aid'] = $this->actioninfo['id'];
			$data['total_shakes'] = 0;
			$data['today_shakes'] = 0;
			$data['wecha_id'] = '';
			$data['wecha_name'] = !empty($wap_user['wechaname']) ? $wap_user['wechaname'] : "匿名用户" ;
			$data['wecha_pic'] = !empty($wap_user['avatar']) ? $wap_user['avatar'] : $this->siteUrl.'/tpl/User/default/common/images/portrait.jpg';
			$data['phone'] = !empty($wap_user['phone']) ? $wap_user['phone'] : "no" ;
			$data['addtime'] = $_SERVER['REQUEST_TIME'];
			$data['token'] = '';
			$addid = D('Shakelottery_users')->data($data)->add();
			return $addid;
		}else{
			$savedata = array('phone'=>$wap_user['phone'],'wecha_pic'=>$wap_user['avatar'],'wecha_name'=>$wap_user['nickname']);
			D('Shakelottery_users')->where($where)->data($savedata)->save();
			return $player['id'];
		}
	}
    	//每日摇奖数清0
	private function clear_shake_day($user_id){
		$action_id = $this->actioninfo['id'];
		$cache_name='shakelottery_day_'.$action_id.'_'.$user_id;

		if(!S($cache_name)){
			$evening_time = strtotime(date('Y-m-d 23:59:59',$_SERVER['REQUEST_TIME']));
			$cache_time = $evening_time - $_SERVER['REQUEST_TIME'];
			$where = "`aid`=".$action_id." AND `id`=".$user_id;
			D('Shakelottery_users')->where($where)->data(array('today_shakes'=>0))->save();
			S($cache_name,1,$cache_time);
		}
	}
	//其他人的中奖名单ajax返回
	public function lotteryRecord(){
		$aid = intval($_POST['aid']);
		$user_id = intval($_POST['user_id']);
		$record_nums = !empty($_GET['record_nums']) ? intval($_GET['record_nums']) : 20;
		$where = '`aid`='.$aid.' AND `iswin`=1 AND `user_id`!='.$user_id;
		$otherRecord = D('Shakelottery_record')->where($where)->limit(0,$record_nums)->order('id desc')->select();
		if(!empty($otherRecord)){
			$html = '';
			foreach ($otherRecord as $key => $value) {
				$str = '';
				if(empty($value['phone']) || $value['phone'] == 'no'){
					$str = '<li>恭喜<label style="color:#c63535;">'.$value['wecha_name'].'</label>&nbsp;&nbsp;&nbsp;摇中'.mb_substr($value['prizename'], 0,10,'UTF-8').'</li>';
				}else{
					$str = '<li>恭喜<label style="color:#c63535;">'.substr_replace($value['phone'],'****',3,4).'</label>&nbsp;&nbsp;&nbsp;摇中'.mb_substr($value['prizename'], 0,10,'UTF-8').'</li>';
				}
				$html .= $str;
			}
			echo $html;exit;
		}else{
			echo 'fail';exit;
		}
	}
	//我的中奖记录
	public function lotteryMyRecord(){
		$aid = (int)$_POST['aid'];
		$user_id = (int)$_POST['user_id'];
		$myRecord = D('Shakelottery_record')->where(array('aid'=>$aid,'user_id'=>$user_id,'iswin'=>1))->order('id desc')->select();
		if(!empty($myRecord)){
			$html = '';
			foreach ($myRecord as $key => $value) {
				$isaccept  = $value['isaccept'] == 1 ? '<i style="color:#44b549;">已领取</i>' : '<i style="color:#C63535;">未领取</i>';
				if($value['prize_type']==1){
					$status   = $value['isaccept'] == 1 ? '<a href="javascript:;" style="margin-left: 70%;color:#44b549;">已兑奖</a>' : '<a href="javascript:getprize('.$value['id'].');" style="margin-left: 70%;">兑奖</a>';
					$html .= '<li>&nbsp;'.mb_substr($value['prizename'], 0,10,'UTF-8').'&nbsp;'.$isaccept.'<span class="font-c63535">'.date('Y-m-d H:i',$value['shaketime']).'</span>'.$status.'</li>';
				}else{
					$status   = $value['isaccept'] == 1 ? '<a href="javascript:;" style="margin-left: 70%;color:#44b549;">已兑奖</a>' : '<a href="javascript:getfictitiou('.$value['id'].');" style="margin-left: 70%;">兑奖</a>';
					$html .= '<li>&nbsp;'.mb_substr($value['prizename'], 0,10,'UTF-8').'&nbsp;'.$isaccept.'<span class="font-c63535">'.date('Y-m-d H:i',$value['shaketime']).'</span>'.$status.'</li>';
				}
				unset($isaccept,$status);
			}
			echo $html;exit;
		}else{
			echo 'fail';exit;
		}
	}
	//抽奖操作
	public function lotteryPrize($setting = false){
		if($setting){ return array('status'=>'fail','msg'=>'继续努力哦');}
		$shakePrize = $prizenum =$prizeArr=array();
		$shakePrize = $this->actioninfo;
		$prize = D('Shakelottery_prize')->where(array('aid'=>$this->actioninfo['id']))->select();
		foreach($prize as $k=>$v){
			$prizenum[$k] = $v['prizenum'];//一维数组
			$prizeArr[$v['id']] = $v;//按照奖品ID索引重新排序
		}
		array_multisort($prizenum,SORT_ASC,$prize);//按照奖品数量升序排序
		$shakePrize['prizelist'] = $prize;
		$prizeid = $this->shakePrize($shakePrize);
		if($prizeid == 0){
			$res =  array('status'=>'fail','msg'=>'继续努力哦');
		}else{
			D('Shakelottery_prize')->where(array('id'=>$prizeid))->data('`expendnum`=`expendnum`+1')->save();
			$res = array('status'=>'success','msg'=>$prizeArr[$prizeid]);
		}
		return $res;
	}
	// 摇一摇抽奖操作
	public function shakePrize($shakePrize = ''){
		$prizetype = '';
		if(empty($shakePrize) || empty($shakePrize['prizelist'])){
			return false;
		}
		$actual_join_number = intval($shakePrize['actual_join_number']);//实际参与人数
		$join_number = intval($shakePrize['join_number']);//预计参与人数
		$totaltimes = intval($shakePrize['totaltimes']);//每人总摇奖次数
		$prize_arr = array();
		$startnum = 0;
		foreach ($shakePrize['prizelist'] as $key => $value) {
			$leftnum = ($value['prizenum'] > $value['expendnum']) ? intval($value['prizenum'] - $value['expendnum']) : 0;//奖品剩余数量
			$endnum += $leftnum;//剩余所有奖品数量
			$prize_arr[$value['id']] = array('id'=>$value['id'],'prize'=>$value['prizename'],'v'=>$leftnum,'start'=>$startnum,'end'=>$endnum);
			$startnum += $leftnum;
		}
		$prize_arr[0] = array('id'=>0,'prize'=>'谢谢参与','v'=>$join_number*$totaltimes-$endnum,'start'=>$endnum,'end'=>$join_number*$totaltimes);
		if ($join_number == 1) {//只有一个人的时候，抽一个产品出来
			foreach ($shakePrize['prizelist'] as $key => $value) {
				if($value['prizenum'] - $value['expendnum'] > 0){
					$prizeid = $value['id'];
					break;
				}else{
					$prizeid = 0;
				}
			}
		}else{
			//预计参与人数*每人总摇奖次数-实际参与人数
			$prizeid = $this->get_rand($prize_arr,($join_number*$totaltimes)-$actual_join_number);
		}
		return $prizeid;
	}
	//抽奖随机概率
	private function get_rand($proArr,$total) {
		$result = 0;
		$randNum = mt_rand(1, $total);
		foreach ($proArr as $k => $v) {
			if ($v['v']>0){
				if ($randNum>$v['start']&&$randNum<=$v['end']){
					$result=$k;
					break;
				}
			}
		}
		return $result;
	}
	// 实物奖品兑奖
	public function getprize(){
		$this->isLogin();
		if(empty($_POST['userAddressId'])){
			echo json_encode(array('err_code'=>'101','err_msg'=>'参数错误'));exit;
		}
		if(!empty($_POST['id'])){
			$id=intval($_POST['id']);
			$userAddressId = intval($_POST['userAddressId']);
			$record=D('Shakelottery_record')->where(array('id'=>$id))->find();
			$this->testgrize($record);//领取奖品验证
			$user=D('Shakelottery_users')->where(array('id'=>$record['user_id']))->field('id,uid')->find();//用户信息
			$shakelottery=D('Shakelottery')->where(array('id'=>$record['aid']))->field('id,store_id')->find(); //活动信息
			$prize = D('Shakelottery_prize')->where(array('id'=>$record['prizeid']))->find();  //奖品信息
			$product = D('Product')->where(array('product_id'=>$prize['product_id']))->find();  // 产品信息
			$product_sku=D('Product_sku')->where(array('sku_id'=>$prize['sku_id']))->field('sku_id,price,properties')->find();//产品库存信息
			$address=D('User_address')->where(array('address_id'=>$userAddressId))->find();//收货地址信息
			$data=$info=$accept=array();
			// 商品库存数量小于1  判断库存是否有
			$data['store_id'] =$shakelottery['store_id'];
			$data['order_no'] = date('YmdHis',time()).mt_rand(100000,999999);
			$data['trade_no'] = date('YmdHis',time()).mt_rand(100000,999999);
			$data['third_id'] = '';
			$data['uid']=$user['uid'];
			$data['postage']='0.00';
			$data['total']='0';
			$data['sub_total']=$product_sku['price'];
			$data['total']=$product_sku['price'];
			$data['pro_num']='1';
			$data['payment_method']='text';
			$data['shipping_method']='express';
			$data['type']='57';//摇一摇订单类型
			$data['status']='2';
			$data['add_time']=$_SERVER['REQUEST_TIME'];
			$data['paid_time']=$_SERVER['REQUEST_TIME'];
			$data['is_check']='1';
			$data['activity_id']=$shakelottery['id'];
			$data['comment']=strip_tags($_POST['remark']);
			$data['address_user']=trim($address['name']);
			$data['address_tel']=trim($address['tel']);
			$data['activity_type']='57';

			//收货地址
			import('source.class.area');
			$areaClass = new area();
			$get_address['address']=$address['address'];
			$get_address['province_code']=$address['province'];
			$get_address['province']=$areaClass->get_name($address['province']);
			$get_address['city_code']=$address['city'];
			$get_address['city']=$areaClass->get_name($address['city']);
			$get_address['area_code']=$address['area'];
			$get_address['area']=$areaClass->get_name($address['area']);
			$data['address']=serialize($get_address);
			$oid=D('Order')->data($data)->add();
			if(!empty($oid)){
				$info['order_id']=$oid;
				$info['product_id']=$prize['product_id'];
				$info['sku_id']=$prize['sku_id'];
				$info['pro_num']='1';
				$info['pro_price']=$product_sku['price'];
				$properties=explode(';', $product_sku['properties']);
				$property_value =$v_arr= array();
				if(!empty($properties)){
					foreach ($properties as $k=> $v) {
						$value=explode(':', $v);
						array_push($v_arr, $value[1]);
						unset($value);
					}
					$where_property = '`vid` in('.implode(',', $v_arr).')';
					$property_value=D('Product_property_value')->where($where_property)->field('vid,pid,value')->select();
					foreach ($property_value as $k => $v) {
						$s=D('Product_property')->where(array('pid'=>$v['pid']))->field('name')->find();
						$property_value[$k]['name']=$s['name'];
						unset($s);
					}
				}
				$info['sku_data']=!empty($property_value) ? serialize($property_value) : '';
				D('Order_product')->data($info)->add();

				// 领取信息修改
				$accept['accepttime']=$_SERVER['REQUEST_TIME'];
				$accept['isaccept']='1';
				$accept['order_id']=$oid;
				D("Shakelottery_record")->where(array('id'=>$id))->data($accept)->save();

				// 库存减少
				$sku_info=D('Product_sku')->where(array('sku_id'=>$prize['sku_id']))->data('quantity=quantity-1')->save();
				echo json_encode(array('err_code'=>'0','err_msg'=>"收货地址添加成功，奖品等待发货中，请前往个人中心查看"));exit;
			}else{
				echo json_encode(array('err_code'=>'0','err_msg'=>"服务器繁忙，请稍后再试"));exit;
			}
		}else{
			echo json_encode(array('err_code'=>'101','err_msg'=>'参数错误'));exit;
		}
	}
	// 领取奖品验证
	public function testgrize($record=array()){
		if(empty($record)){
			echo json_encode(array('err_code'=>'105','err_msg'=>'不能非法领取'));exit;
		}
		if($record['prize_type']!=1){
			echo json_encode(array('err_code'=>'102','err_msg'=>'类型错误'));exit;
		}
		if($record['isaccept']==1){
			echo json_encode(array('err_code'=>'103','err_msg'=>'不能重复兑奖'));exit;
		}
		if(empty($record['user_id'])){
			echo json_encode(array('err_code'=>'104','err_msg'=>'非法领取'));exit;
		}
	}
	// 获取地址
	public function lottery_getadress(){
		if(!empty($_GET['id'])){
			$id=intval($_GET['id']);
			$record=D('Shakelottery_record')->where(array('id'=>$id))->find();
			$address_list = $this->getAddressInfo();
			$address_default=$this->getAddressDefault();
			include display('lottery_getadress');exit;
		}else{
			pigcms_tips('参数错误', 'none');
		}
	}
	// 获取收货列表
	protected function getAddressInfo(){
		import('source.class.area');
		$areaClass = new area();
		$address_list=array();
		$address_list=D('User_address')->where(array('uid'=>$this->userInfo['uid']))->select();
		if(!empty($address_list)){
		foreach ($address_list as $k => $v) {
		     $address_list[$k]['full_address']=$areaClass->get_name($v['province']).$areaClass->get_name($v['city']).$areaClass->get_name($v['area']).$v['address'];
		}
		}
		return $address_list;
	}
	// 获取默认地址
	protected function getAddressDefault(){
		import('source.class.area');
		$areaClass = new area();
		$where['uid']=$this->userInfo['uid'];
		$where['default']=1;
		$info=D('User_address')->where($where)->find();
		$tmp=array();
		if(empty($info)){
		    $address_list=D('User_address')->where(array('uid'=>$this->userInfo['uid']))->limit(1)->select();
		    $tmp=reset($address_list);
		}else{
		    $tmp=$info;
		}
		if(!empty($tmp)){
		    $tmp['full_address']=$areaClass->get_name($tmp['province']).$areaClass->get_name($tmp['city']).$areaClass->get_name($tmp['area']).$tmp['address'];
		}
		return $tmp;
	}
	// 新增地址
	public function ajax_setAddress(){
		$this->isLogin();
	        import('source.class.area');
	        if($_POST){
			$data=$info=array();
			$addressId=intval($_POST['addressId']);
			$data['name']=trim($_POST['name']);
			$data['province']=intval($_POST['province']);//省市县
			$data['city']=intval($_POST['city']);
			$data['area']=intval($_POST['area']);
			$data['address']=trim($_POST['address']);//地址
			$data['tel']=trim($_POST['tel']); //电话
			$data['add_time']=$_SERVER['REQUEST_TIME'];
			$data['uid']=$this->userInfo['uid'];
			if(!empty($addressId)){
			    D('User_address')->where(array('address_id'=>$addressId))->data($data)->save();
			    $lid=$addressId;
			}else{
			    $lid=D('User_address')->data($data)->add();
			}
			// var_dump($data);exit;
			if(!empty($lid)){
				$info['name']=$data['name'];
				$areaClass = new area();
				$info['tel']=$data['tel'];
				$info['id']=$lid;
				$info['fullAddress']=$areaClass->get_name($data['province']).'&nbsp;'.$areaClass->get_name($data['city']).'&nbsp;'.$areaClass->get_name($data['area']).'&nbsp;'.$data['address'];
				echo json_encode(array('err_code'=>0,'err_msg'=>$info));exit;
			}else{
				echo json_encode(array('err_code'=>105,'err_msg'=>'操作失误'));exit;
			}
	        }else{
	            echo json_encode(array('err_code'=>104,'err_msg'=>'错误参数'));exit;
	        }
	}
	public function isLogin(){
		if(empty($this->userInfo)){
			echo json_encode(array('err_code'=>101,'err_msg'=>'请先登录'));exit;
		}
	}
	public function ajax_delAddess(){
	        $this->isLogin();
	        if(!empty($_POST['addressId'])){
		        $address_id=intval($_POST['addressId']);
		        $lid=D('User_address')->where(array('address_id'=>$address_id))->delete();
		        if(!empty($lid)){
		        	echo json_encode(array('err_code'=>0,'err_msg'=>'ok'));exit;
		        }else{
		        	echo json_encode(array('err_code'=>0,'err_msg'=>'NotLogin'));exit;
		        }
	        }else{
	        	echo json_encode(array('err_code'=>0,'err_msg'=>'参数错误'));exit;
	        }

	}
	public function ajax_reloadAddress(){
	        $this->isLogin();
	        import('source.class.area');
	        $areaClass = new area();
	        $addressList=D('User_address')->where(array('uid'=>$this->userInfo['uid']))->select();
	        $html='';
	        if(!empty($addressList)){
	            foreach ($addressList as $k => $v) {
	                $full_address=$areaClass->get_name($v['province']).'&nbsp;'.$areaClass->get_name($v['city']).'&nbsp;'.$areaClass->get_name($v['area']).'&nbsp;'.$v['address'];
	                $html.='<div class="take_p"><input    name="addrList" id="addrList_'.$v['address_id'].'" type="radio"  value="'.$v['address_id'].'" addrName="'.$v['name'].'" addrMobile="'.$v['tel'].'"addrFullAddress="'.$full_address.'" class="ta_r"/><label for="'.$v['address_id'].'">'.$v['name'].'&nbsp;&nbsp;'.$full_address.'&nbsp;'.$v['tel'].'</label> <em class="t_em t_em_a" name="editaddr" id="editaddr" addressId="'.$v['address_id'].'" addressName="'.$v['name'].'" addressAddressDetail="'.$v['address'].'" addressMobile="'.$v['tel'].'"   addressProvinceId="'.$v['province'].'" addressCityId="'.$v['city'].'" addressCountyId="'.$v['area'].'" >编辑</em> <em class="t_em t_em_a" name="'.$v['address_id'].'" id="removeAddress">删除</em>
	                        </div>';
	                unset($full_address);
	            }
	        }
	        $html.="<div class='take_p'><input name='addrList' id='newAddressRadio' type='radio'  value='0' class='ta_r'/><label>&nbsp;使用新地址</label></div>";
	        echo json_encode(array('err_code'=>0,'err_msg'=>$html));exit;
	}
	//ajax 领取虚拟奖品
	public function user_get_fictitiou() {
		$this->isLogin();
		$wuser=$this->userInfo;
		$uid = $wuser['uid'];

		$id = intval($_GET['id']);
		if (empty($id)) {
			json_return('1001','缺少最基本的参数');
		}
		$where_record = 'record.id='.$id.' AND record.prizeid=prize.id';
		$record=D('')->table(array('pigcms_shakelottery_record'=>'record','pigcms_shakelottery_prize'=>'prize'))->where($where_record)->find();
		if( empty($record) || empty($record['user_id']) ){
			echo json_encode(array('err_code'=>'105','err_msg'=>'不能非法领取'));exit;
		}
		if($record['iswin']!=1){
			json_return('1012','抱歉未中奖');
		}
		if($record['isaccept']==1){
			echo json_encode(array('err_code'=>'103','err_msg'=>'不能重复兑奖'));exit;
		}
		// 领取优惠券
		$time = $_SERVER['REQUEST_TIME'];
		if($record['prize_type']==2){
			$where_coupon = array('id'=>intval($record['product_id']));
			$coupon = D('Coupon')->where($where_coupon)->find();
			if(empty($coupon)){
				json_return('1012','未发现该优惠券');
			}
			if ($coupon['total_amount'] <= $coupon['number']) {
				json_return('1002','该优惠券已经全部发放完了');
			}
			if ($coupon['status'] == '0') {
				json_return('1003','该优惠券已失效!');
			}
			if ($time > $coupon['end_time'] || $time < $coupon['start_time']) {
				json_return('1004','该优惠券未开始或已结束!');
			}
			if($coupon['most_have']!='0'){
				$where_user_coupon = array('coupon_id'=>intval($record['product_id']));
				$user_coupon_nub=D('User_coupon')->where($where_user_coupon)->count('id');
				if($user_coupon_nub>=$coupon['most_have']){
					json_return('1123','该优惠券每人最多领取'.$coupon['most_have'].'张!');
				}
			}
			//领取
			if(M('User_coupon')->add($uid,$coupon)){
				//修改优惠券领取信息
				D('Coupon')->where($where_coupon)->setInc('number',1);
				$data_record = '`isaccept`=1,`accepttime`='.$time;
				D('Shakelottery_record')->where(array('id'=>$id))->data($data_record)->save();
				json_return('0','领取成功,请前往登录的个人中心查看');
			} else{
				json_return('1111','领取失败!');
			}
		}elseif($record['prize_type']==3){//领取积分
			$shakelottery=D('Shakelottery')->where(array('id'=>$record['aid']))->field('id,store_id')->find();
			// 积分流水
			$data['uid'] = $_SESSION['wap_user']['uid'];
			$data['store_id'] = $shakelottery['store_id'];
			$data['type'] = 15;// 摇一摇抽奖
			$data['is_available'] = 0;
			$data['timestamp'] =$time;
			$data['points'] = intval($record['value']);
			$data['bak'] = '摇一摇抽奖获取';
			$result = D('User_points')->data($data)->add();
			if($result){
				$changePoint=M('Store_user_data')->changePoint($shakelottery['store_id'], $_SESSION['wap_user']['uid'], $data['points']);
				$data_record = '`isaccept`=1,`accepttime`='.$time;
				D('Shakelottery_record')->where(array('id'=>$id))->data($data_record)->save();
				json_return('0','领取成功,请前往个人中心查看您的积分总额');
			}else{
				json_return('1111',$integral_status['err_msg']);
			}
		}else{
			json_return('1111','奖品类型错误!');
		}
	}
	// 积分消耗
	protected function integral_use($lottery){
		// 积分流水
		$data['uid'] = $_SESSION['wap_user']['uid'];
		$data['store_id'] = $lottery['store_id'];
		$data['type'] = 15;// 摇一摇抽奖
		$data['is_available'] = 0;
		$data['timestamp'] =$_SERVER['REQUEST_TIME'];
		$data['points'] = -$lottery['integral_nub'];
		$data['bak'] = '摇一摇抽奖消耗';
		$result = D('User_points')->data($data)->add();
		if($result){
			$changePoint=M('Store_user_data')->changePoint($lottery['store_id'], $_SESSION['wap_user']['uid'], $data['points']);
			return array('err_code'=>0,'err_msg'=>'ok');
		}else{
			return array('err_code'=>12111,'err_msg'=>'流水生成失败');
		}
	}
}
echo ob_get_clean();
?>