<?php
/**
 *  游戏中心 @zhangzeyun
 */
require_once dirname(__FILE__) . '/global.php';
$game_center=new game_center();
$a=!empty($_GET['a']) ? trim($_GET['a']) : 'index';
// 强制用户登录
if(empty($_SESSION['wap_user'])) {
	if (!IS_AJAX) {
		$url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		redirect("./login.php?referer=" . urlencode($url));
	} else {
		json_return(1000, '请登录');
	}
}
call_user_func(array($game_center,$a));
class game_center{
	public $userInfo;//wap端用户
	public $page_size=10; //分页数
	public function __construct(){
		$this->userInfo=$_SESSION['wap_user'];
	}
	public function index(){
		if(empty($this->userInfo)){
			redirect('./login.php?referer=' . urlencode($_SERVER['REQUEST_URI']));exit;
		}

		$store_id = isset($_GET['id']) ? (int)$_GET['id'] : (int)$_SESSION['tmp_store_id'];
		if($store_id<=0){
			pigcms_tips('您输入的网址有误', 'none');
		}
		$_SESSION['store']=D('Store')->where(array('store_id' => $store_id))->find();
		if(empty($_SESSION['store'])){
			pigcms_tips('该店铺不存在', 'none');
		}
		$now_store = $_SESSION['store'];
		if(empty($this->userInfo['nickname'])){
			$this->userInfo['nickname']='匿名用户';
		}
		include display('game_center');
	}
	// 摇一摇抽奖列表
	public function shake_list(){
		if(empty($_SESSION['store'])){
			pigcms_tips('该店铺不存在', 'none');
		}
		$page = empty($_GET['page']) ? 1 : intval($_GET['page']);
		$status = empty($_GET['status']) ? 0 : intval($_GET['status']);
		$page_size = $this->page_size;
		$store_id=intval($_SESSION['store']['store_id']);
		$shakelottery=D('Shakelottery')->where(array('store_id'=>$store_id))->field('id,action_name,store_id')->select();
		$shakelottery = !empty($shakelottery) ? $shakelottery : array();
		$id_shake=$id_uid=$shake=array();
		foreach ($shakelottery as $k => $v) {
			array_push($id_shake, $v['id']);
			$shake[$v['id']]=$v['action_name'];
		}
		if(!empty($id_shake)){
			$where_user = '`uid`='.intval($this->userInfo['uid']).' AND `aid` in('.implode(',', $id_shake).')';
			$user_id=D('Shakelottery_users')->where($where_user)->field('id')->select();
			if(!empty($user_id)){
				foreach ($user_id as $k => $v) {
					array_push($id_uid, $v['id']);
				}
			}
		}
		$record=array();
		if(!empty($id_shake) && !empty($id_uid)){
			// 中奖，对应用户，该活动下所有摇一摇抽奖活动
			$where_record = '`iswin`=1 AND   `user_id` in('.implode(',', $id_uid).')  AND `aid` in('.implode(',', $id_shake).')';
			switch ($status) {
				case 1:
					$where_record .= '  AND `isaccept`=0';
					break;
				case 2:
					$where_record .= '  AND `isaccept`=1';
					break;
			}
			$first_limit  = ($page-1)*$page_size;
			$record=D('Shakelottery_record')->where($where_record)->limit($first_limit.','.$page_size)->order('`id` DESC')->select();
		}
		$temp='';
		if(!empty($record)){
			foreach ($record as $k => $v) {
				$status_msg =  $v['isaccept']==1 ? '<p><a href="javascript:;" class="ok">已兑奖</a></p>' : '<p><a href="javascript:;" rid="'.$v['id'].'" type="'.$v['prize_type'].'" class="go shakelottery">兑奖</a></p>';
				$temp .= '
			            <tr>
			                <td class="prizeInfo"><h2><span>'.$shake[$v['aid']].'</span>奖品：'.$v['prizename'].'</h2><p>中奖日期：'.date('Y-m-d',$v['shaketime']).'</p></td>
			                <td class="prizeState">'.$status_msg.'</td>
			            </tr>
				';
				unset($status_msg);
			}
		}
		echo json_encode(array('err_code'=>0,'err_msg'=>$temp));exit;
	}

	// 抽奖合集列表
	public function lottery_list(){
		$type = (int)$_GET['type'];
		$status = (int)$_GET['status'];
		$page = max(1,(int)$_GET['page']);
		$page_size = $this->page_size;
		$store_id = $_SESSION['store']['store_id'];
		if(!in_array($type,array(1,2,3,4,5))){
			echo json_encode(array('err_code'=>1,'err_msg'=>'未知的活动类型'));
			exit;
		}
		$lottery_list = D('Lottery')->where(array('store_id'=>$store_id))->select();

		if(!$lottery_list){
			echo json_encode(array('err_code'=>1,'err_msg'=>'没有找到抽奖记录'));
			exit;
		}
		$aids = array();
		foreach($lottery_list as $lottery){
			if(!in_array($lottery['id'],$aids)){
				$aids[] = $lottery['id'];
			}
		}
		if(!$aids){
			echo json_encode(array('err_code'=>1,'err_msg'=>'没有找到活动抽奖记录'));
			exit;
		}

		$where_record['user_id'] = $_SESSION['wap_user']['uid'];
		$where_record['type'] = $type;
		$where_record['prize_id'] = array('>',0);
		$where_record['active_id'] = array('in',$aids);
		// 兑奖状态
		if($status){
			$where_record['status'] = $status==1?0:1;
		}

		$first_limit  = ($page-1)*$page_size;
		// 我的中奖记录
		$lottery_type = array(1=>'大转盘',2=>'九宫格',3=>'刮刮卡',4=>'水果机',5=>'砸金蛋');
		$lottery_record = D('Lottery_record')->where($where_record)->limit($first_limit.','.$page_size)->order('status asc,id desc')->select();

		if(!$lottery_record){
			echo json_encode(array('err_code'=>1,'err_msg'=>'没有找到您的抽奖记录','ismore'=>false));
			exit;
		}
		// 奖品
		foreach($lottery_record as $key=> $record){
			$lottery_prize = D('Lottery_prize')->where(array('lottery_id'=>$record['active_id'],'prize_type'=>$record['prize_id']))->find();
			$lottery_record[$key]['product_name'] = $lottery_prize['product_name'];
			$lottery_record[$key]['type_name'] = $lottery_type[$record['type']];
			$lottery_record[$key]['dateline'] = date('Y-m-d H:i:s',$record['dateline']);
			$lottery_record[$key]['isonline'] = $lottery_prize['prize'] == 4 ? 0 : 1;
		}
		echo json_encode(array('err_code'=>0,'err_msg'=>'success','record_list'=>$lottery_record));
	}

}










 ?>