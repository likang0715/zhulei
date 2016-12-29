<?php
class meal_controller extends base_controller {
	public function load(){
		$action = strtolower(trim($_POST['page']));
		if (empty($action)) pigcms_tips('非法访问！', 'none');
		switch ($action) {
		    case 'dashboard_content': //概况
		    $this->_dashboard_content();
		    break;
		    case 'order_list_content': //列表数据
		    $this->_order_list_content();
		    break;
		    default:
		    break;
		}
		$this->display($_POST['page']);
	}

	//概况
	private function _dashboard_content(){

		$store_id = $this->store_session['store_id'];
		if(empty($store_id)){
			json_return(1,'用户未登录');
		}

		$physical_id = intval($_POST['shopid']);
		if(empty($physical_id)){
			json_return(1,'门店不能为空');
		}

		$state = array('1'=>'待审核','2'=>'待消费','3'=>'已完成','4'=>'已取消');
		$time=time();
		$database = D('Meal_order');
		$todaywhere['store_uid'] = $store_id;
		$sevenwhere['store_uid'] = $store_id;
		$waitwhere['store_uid'] = $store_id;
		$waitmoneywhere['store_uid'] = $store_id;
		$data_seven_where['store_uid'] = $store_id;

		// 即将到店
		$today_endtime = $time+ 86400;
		$todaywhere['status'] = 2;
		$todaywhere['dd_time'] = array(array('>=',$time),array('<',$today_endtime));

		// 待确认订座
		$waitwhere['status'] = 1;
		$waitwhere['dd_time'] = array('>=',$time);

		// 待确认到店
		$wait_endtime = $time- 86400;
		$waitmoneywhere['status'] = 2;
		$waitmoneywhere['dd_time'] = array(array('<=',$time),array('>=',$wait_endtime));

		// 近七日到店
		$waitmoney_endtime = strtotime(date('Y-m-d',time()));- 86400*7;
		$sevenwhere['status'] = 3;
		$sevenwhere['dd_time'] = array(array('<=',$time),array('>=',$waitmoney_endtime));

		$where['physical_id'] = $physical_id;
		$sevenwhere['physical_id'] = $physical_id;
		$todaywhere['physical_id'] = $physical_id;
		$waitwhere['physical_id'] = $physical_id;
		$waitmoneywhere['physical_id'] = $physical_id;
		$data_seven_where['physical_id'] = $physical_id;

		$today=$database->where($todaywhere)->count('order_id');
		$wait=$database->where($waitwhere)->count('order_id');
		$waitmoney=$database->where($waitmoneywhere)->count('order_id');
		$sevendays=$database->where($sevenwhere)->count('order_id');

		// 近七日数据
		for ($i=0; $i<7; $i++)
		{
			if($i==0){
				$data_seven[$i] = date('Y-m-d',$time);
			}else{
				$data_seven[$i] = date('Y-m-d',strtotime('-'.$i.' day'));
			}
			$etime=strtotime($data_seven[$i])+86399;
			$stime=strtotime($data_seven[$i]);
			$data_seven_where['dd_time'] = array(">='$stime' and dd_time<='$etime'");

			$data_seven_where['status'] = 2;
			$data_seven_order[$i] = $database->where($data_seven_where)->order('`order_id` DESC')->count();
			
			$data_seven_where['status'] = 3;
			$data_seven_shop[$i] = $database->where($data_seven_where)->order('`order_id` DESC')->count();
		}

		$this->assign('today',$today);
		$this->assign('today_endtime',$today_endtime);
		$this->assign('wait',$wait);
		$this->assign('wait_endtime',$wait_endtime);
		$this->assign('waitmoney',$waitmoney);
		$this->assign('waitmoney_endtime',$waitmoney_endtime);
		$this->assign('sevendays',$sevendays);
		$this->assign('time',$time);
		$this->assign('data_seven',json_encode($data_seven));
		$this->assign('data_seven_order',json_encode($data_seven_order));
		$this->assign('data_seven_shop',json_encode($data_seven_shop));
		$this->assign('physical_id',$physical_id);

	}
	private function _order_list_content(){
		$postpages = max(1, $_POST['pages']);
		$limit = 20;
		$physical_id = intval($_POST['shopid']);
		$keywords = $_POST['keywords'];
		$start_time = $_POST['stime'];
		$end_time = $_POST['etime'];

		if(empty($physical_id)){
			$physical = D('Store_physical')->where(array('store_id'=>$this->store_session['store_id']))->order('`pigcms_id` ASC')->find();
			$physical_id=$physical['pigcms_id'];
		}

		$store_physical = D('Store_physical')->where(array('store_id'=>$this->store_session['store_id']))->select();
		$this->assign('store_physical',$store_physical);
		$now_store = $this->check_store($physical_id);

		$state = array('1'=>'待审核','2'=>'待消费','3'=>'已完成','4'=>'已取消');

		$database = D('pigcms_meal_order');
		$where['store_uid'] = $this->store_session['store_id'];
		$where['physical_id'] = $_POST['shopid'];

		if ($keywords){
			if ($_POST['search_type']==1){

				$where['name'] = array('like', '%' . $keywords . '%');

			}elseif ($_POST['search_type']==2){

				$where['phone'] = array('like', '%' . $keywords . '%');
			}

		}

		if ($_POST['source']){
			$where['type'] = $_POST['source'];
		}

		if($start_time){
			$where['dd_time'] = array('>=',$start_time);
		}
		if($end_time){
			$where['dd_time'] = array('<=',$end_time);

		}
		if($start_time && $end_time){
			$where['dd_time'] = array(array('>=',$start_time),array('<=',$end_time));
		}

		$status = !empty($_POST['status']) ? $_POST['status'] : array('<', 5);
		
		$where['status'] = $status;

		$count = $database->where($where)->count('order_id');

		$list = array();

		$pages = '';

		$total_pages = ceil($count / $limit);

		if ($count > 0) {

			$postpages = min($postpages, $total_pages);

			$offset = ($postpages - 1) * $limit;

			$list = $database->where($where)->order('`order_id` DESC')->limit($offset.','.$limit)->select();

			foreach ($list as $key => $store)
			{
				$user = D('User')->where(array('uid'=>$store['uid']))->find();
				$list[$key]['nickname'] = $user['nickname'];
				$list[$key]['avatar'] = $user['avatar'];
				if($store['tableid']){
					$list[$key]['tableid'] = $this->store_cz($store['tableid']);
				}else{

					$list[$key]['tableid'] = '未分配';
				}
				$list[$key]['status'] = $state[$store['status']];

			}

			// 分页
			import('source.class.user_page');
			$user_page = new Page($count, $limit, $postpages);
			$pages = $user_page->show();
		}


		$this->assign('pages', $pages);

		$this->assign('physical_id', $physical_id);
		$this->assign('order_list', $list);

		$this->assign('now_store', $now_store);
		$user =M('User');
		$user = $user->getUserById($this->user_session['uid']);
		$this->assign('mendian', $user['drp_store_id']);
		$this->assign('zqx', $user['zqx']);
		$this->assign('status', $status);
	// $this->display();
	}
 //设置店铺
	public function cat_list(){

		$physical_id=$_REQUEST['physical_id'];
		$category=D('Meal_category');
		$cat_list = $category->where(array('store_id'=>$this->store_session['store_id'],'physical_id'=>$physical_id))->order('cat_sort desc')->select();

		$this->assign('cat_list',$cat_list);
		$this->display('catlist');

	}

	public function cat_del()
	{
		$physical_id = $_REQUEST['physical_id'];
		$cat_id=$_REQUEST['cat_id'];
		$database = D('Meal_category');
		if ($database->where(array('store_id'=>$this->store_session['store_id'],'physical_id'=>$physical_id,'cat_id'=>$cat_id))->delete()) {
			json_return(0,'成功');
		} else{
			json_return(1,'失败');
		}
	}

	public function cat_add(){
		if(IS_POST){
			$dataorder = D('Meal_category');
			if(empty($_REQUEST['cat_name'])){
				json_return(1,'分类名称必填');
			}
			$data['store_id'] = $this->store_session['store_id'];
			$data['physical_id'] = $_REQUEST['physical_id'];
			$data['cat_name'] = $_REQUEST['cat_name'];
			$data['cat_sort'] = empty($_REQUEST['cat_sort'])? 50 : $_REQUEST['cat_sort'];
			$data['cat_status'] = 1;
			if($dataorder->data($data)->add()){
				json_return(0,'添加成功');
			}else{
				json_return(1,'添加失败！请重试');
			}
		}
	}
	/* 编辑店铺 */
	public function cat_edit(){
		$database_category = D('Meal_category');
		$condition_category['physical_id'] = $_REQUEST['physical_id'];
		$condition_category['cat_id'] = $_REQUEST['cat_id'];
		$data_category['cat_name'] = $_REQUEST['cat_name'];
		$data_category['cat_sort'] = $_REQUEST['cat_sort'];
		if (empty($_REQUEST['cat_name'])) {
			json_return(1,'分类名称不能为空');
		}
		if (empty($_REQUEST['cat_sort'])) {
			json_return(1,'分类排序不能为空');
		}
		$this_category = $database_category->where($condition_category)->find();
		if(empty($this_category)){
			json_return(1,'分类不存在');
		}else{
			$database_category->where($condition_category)->data($data_category)->save();
			json_return(0,'保存成功');
		}
	}

	/* 店铺管理 */
	public function dashboard(){

		
    //var_dump($store_physical);
		$user =M('User');
		$user = $user->getUserById($this->user_session['uid']);
		
		$where=array();
		if($_SESSION['user']['item_store_id']){
		$where['pigcms_id']=$_SESSION['user']['item_store_id'];
		}
		$where['store_id']=$this->store_session['store_id'];
        $store_physical = D('Store_physical')->where($where)->select();
	
		$this->assign('mendian', $user['drp_store_id']);
		$this->assign('store_physical',$store_physical);

		if($user['drp_store_id']>0){ 
			$store_id = $user['drp_store_id'];
			redirect(url('meal:order').'&store_id='.$store_id.'&action=all');
		}

		$physical = D('Store_physical')->where($where)->order('`pigcms_id` ASC')->find();
		$frist_sore=$physical['pigcms_id'];
		$this->assign('frist_sore', $frist_sore);
		$this->display();
	}

	/*订餐分类*/
	public function meal_sort(){
		$now_store = $this->check_store($_GET['physical_id']);
		$this->assign('now_store',$now_store);

		$database_meal_sort = D('Meal_sort');
		$condition_merchant_sort['physical_id'] = $now_store['store_id'];
		$count_sort = $database_meal_sort->where($condition_merchant_sort)->count();
		import('@.ORG.merchant_page');
		$p = new Page($count_sort,20);
		$sort_list = $database_meal_sort->field(true)->where($condition_merchant_sort)->order('`sort` DESC,`sort_id` ASC')->limit($p->firstRow.','.$p->listRows)->select();
		foreach($sort_list as $key=>$value){
			if(!empty($value['week'])){
				$week_arr = explode(',',$value['week']);
				$week_str = '';
				foreach($week_arr as $k=>$v){
					$week_str .= $this->get_week($v).' ';
				}
				$sort_list[$key]['week_str'] = $week_str;
			}
		}
		$this->assign('sort_list',$sort_list);
		$this->assign('pagebar',$p->show());
		$user =M('User');
		$user = $user->getUserById($this->user_session['uid']);
		$this->assign('mendian', $user['drp_store_id']);
		$this->assign('zqx', $user['zqx']);
		$this->display();
	}
	protected function get_week($num){
		switch($num){
			case 1:
			return '星期一';
			case 2:
			return '星期二';
			case 3:
			return '星期三';
			case 4:
			return '星期四';
			case 5:

			return '星期五';
			case 6:
			return '星期六';
			case 0:
			return '星期日';
			default:
			return '';
		}
	}
	/*添加分类*/
	public function sort_add(){
		$now_store = $this->check_store($_GET['physical_id']);
		$this->assign('now_store',$now_store);

		if(IS_POST){
			if(empty($_POST['sort_name'])){
				$error_tips = '分类名称必填！'.'<br/>';
			}else{
				$database_meal_sort = D('Meal_sort');
				$data_meal_sort['physical_id'] = $now_store['store_id'];
				$data_meal_sort['sort_name'] = $_POST['sort_name'];
				$data_meal_sort['sort'] = intval($_POST['sort']);
				$data_meal_sort['is_weekshow'] = intval($_POST['is_weekshow']);
				if($_POST['week']){
					$data_meal_sort['week'] = strval(implode(',',$_POST['week']));
				}
				if($database_meal_sort->data($data_meal_sort)->add()){
					$ok_tips = '添加成功！！';
				}else{
					$error_tips = '添加失败！！请重试。';
				}
			}
			if(!empty($error_tips)){
				$this->assign('now_sort',$_POST);
			}
			$this->assign('ok_tips',$ok_tips);
			$this->assign('error_tips',$error_tips);
		}
		$user =M('User');
		$user = $user->getUserById($this->user_session['uid']);
		$this->assign('mendian', $user['drp_store_id']);
		$this->assign('zqx', $user['zqx']);
		$this->display();
	}
	/*修改分类*/
	public function sort_edit(){
		$now_sort = $this->check_sort($_GET['sort_id']);
		$now_store = $this->check_store($now_sort['store_id']);		
		$this->assign('now_sort',$now_sort);
		$this->assign('now_store',$now_store);
		if(IS_POST){
			if(empty($_POST['sort_name'])){
				$error_tips = '分类名称必填！'.'<br/>';
			}else{
				$database_meal_sort = D('Meal_sort');
				$data_meal_sort['sort_id'] = $now_sort['sort_id'];
				$data_meal_sort['sort_name'] = $_POST['sort_name'];
				$data_meal_sort['sort'] = intval($_POST['sort']);
				$data_meal_sort['is_weekshow'] = intval($_POST['is_weekshow']);
				$data_meal_sort['week'] = implode(',',$_POST['week']);
				if($database_meal_sort->data($data_meal_sort)->save()){
					$ok_tips = '保存成功！！';
				}else{
					$error_tips = '保存失败！！您是不是没做过修改？请重试。';
				}
			}
			$_POST['sort_id'] = $now_sort['sort_id'];
			$this->assign('now_sort',$_POST);
			$this->assign('ok_tips',$ok_tips);
			$this->assign('error_tips',$error_tips);
		}
		$user =M('User');
		$user = $user->getUserById($this->user_session['uid']);
		$this->assign('mendian', $user['drp_store_id']);
		$this->assign('zqx', $user['zqx']);
		$this->display();
	}
	/* 分类状态 */
	public function sort_status(){
		$now_sort = $this->check_sort($_POST['id']);
		$now_store = $this->check_store($now_sort['store_id']);

		$database_meal_sort = D('Meal_sort');
		$condition_merchant_sort['sort_id'] = $now_sort['sort_id'];
		$data_merchant_sort['is_weekshow'] = $_POST['type'] == 'open' ? '1' : '0';
		if($database_meal_sort->where($condition_merchant_sort)->data($data_merchant_sort)->save()){
			exit('1');
		}else{
			exit;
		}
	}
	/* 删除分类 */
	public function sort_del(){
		$now_sort = $this->check_sort($_GET['physical_id']);
		$now_store = $this->check_store($now_sort['store_id']);

		$database_meal_sort = D('Meal_sort');
		$condition_merchant_sort['sort_id'] = $now_sort['sort_id'];
		if($database_meal_sort->where($condition_merchant_sort)->delete()){
			$this->success('删除成功！');
		}else{
			$this->error('删除失败！');
		}
	}

	/* 菜品管理 */
	public function meal_list(){
		$now_sort = $this->check_sort($_GET['physical_id']);
		$now_store = $this->check_store($now_sort['store_id']);
		$this->assign('now_sort',$now_sort);
		$this->assign('now_store',$now_store);

		$database_meal = D('Meal');
		$condition_meal['sort_id'] = $now_sort['sort_id'];
		$count_meal = $database_meal->where($condition_meal)->count();
		import('@.ORG.merchant_page');
		$p = new Page($count_meal,20);
		$meal_list = $database_meal->field(true)->where($condition_meal)->order('`sort` DESC,`meal_id` ASC')->limit($p->firstRow.','.$p->listRows)->select();
		$this->assign('meal_list',$meal_list);
		$this->assign('pagebar',$p->show());
		$user =M('User');
		$user = $user->getUserById($this->user_session['uid']);
		$this->assign('mendian', $user['drp_store_id']);
		$this->assign('zqx', $user['zqx']);
		$this->display();
	}
	/* 添加店铺 */
	public function order_add(){
		$now_store = $this->check_store($_GET['physical_id']);
		$this->assign('now_store',$now_store);

		if(IS_POST){
			$dataorder = D('pigcms_meal_order');
			if(empty($_POST['name'])){
				$error_tips .= '联系人必填！'.'<br/>';
			}
			if(empty($_POST['phone'])){
				$error_tips .= '联系电话必填！'.'<br/>';
			}
			if(empty($_POST['start_time'])){
				$error_tips .= '到店时间必填！'.'<br/>';
			}
			if(empty($error_tips)){

				$date['orderid'] = date("YmdHis",$_SERVER['REQUEST_TIME']).'0000'.$this->user_session['uid'];
				$date['dateline'] = $_SERVER['REQUEST_TIME'];
				$date['store_uid'] = $this->store_session['store_id'];
				$date['physical_id'] = $_POST['physical_id'];
				$date['name'] = $_POST['name'];
				$date['phone'] = $_POST['phone'];
				$date['dd_time'] = strtotime($_POST['start_time']);
				$date['bz'] = $_POST['bz'];
				$date['type'] = $_POST['type'];
				$date['sc'] = $_POST['sc'];
				$date['tablename'] = $_POST['tableid'];
				$date['status'] = $_POST['status'];
				if($dataorder->data($date)->add()){

					$ok_tips = '添加成功！';
				}else{
				//$sql = D('Product_category')->last_sql;
					$error_tips = '添加失败！请重试。';
				}
			}else{
				$this->assign('now_meal',$_POST);
			}




			$this->assign('ok_tips',$ok_tips);
			$this->assign('error_tips',$error_tips);
		}
		$database = D('pigcms_meal_cz');
		$where = array();
		$where['physical_id'] = $_GET['physical_id'];
		$list = $database->where($where)->order('`cz_id` DESC')->select();

		$this->assign('czlist',$list);
		$user =M('User');
		$user = $user->getUserById($this->user_session['uid']);
		$this->assign('mendian', $user['drp_store_id']);
		$this->assign('zqx', $user['zqx']);
		$this->display();
	}
	/* 编辑店铺 */
	public function order_edit(){

		$this->assign('now_meal',$now_meal);
		$this->assign('now_sort',$now_sort);
		$this->assign('now_store',$now_store);

		if(IS_POST){
			$database_category = D('pigcms_meal_order');
			$condition_category['order_id'] = $_POST['order_id'];

			if($_POST['tablename']){
				$data_category['tablename'] = $_POST['tablename'];
			}
			$data_category['use_time'] = $_SERVER['REQUEST_TIME'];
			$data_category['bz'] = $_POST['bz'];
			$data_category['status'] = $_POST['status'];
			$database_category->where($condition_category)->data($data_category)->save();
			$this->assign('ok_tips','保存成功');



			if($_POST['status']==2){
				$id=15;
			}elseif($_POST['status']==4){
				$id=16;
			}
			if($id){
				$dcz = D('pigcms_meal_order');
				$cz['order_id'] = $_POST['order_id'];
				$order = $dcz->where($cz)->find();

				$now_store = D('Store')->where(array('store_id' => $order['store_uid']))->find();
				$user=M('User')->getUserById($now_store['uid']);
				$power=M('Sms_by_code')->power($now_store['store_id'],$id);
				if($user['smscount']>0 && $power){

					$sms = D('Sms_tpl')->where(array('id'=>$id,'status'=>'1'))->find();

					if($sms){
						import('source.class.SendSms');

						$physical = M('Store_physical')->getOne($order['physical_id']);
						$storename=$now_store['name'];
						$pname=$physical['name']; 
						$bname=$order['tablename']; 
						$mobile=$order['phone'];
						$tel=$physical['mobile'];
						if(empty($mobile)) {
							$tel=$now_store['tel'];
						}
						$times=$order['dd_time']; 

						$str=$sms['text'];
						$str=str_replace('{storename}',$storename,$str);
						$str=str_replace('{pname}',$pname,$str); 
						$str=str_replace('{bname}',$bname,$str); 
						$str=str_replace('{tel}',$tel,$str);
						$str=str_replace('{times}',$times,$str);
						$return	= SendSms::send($mobile,$str);
	//	exit(json_encode(array('error' => 0, 'message' => $return)));

						$uid=array($now_store['uid']);
						if($return==0){
							M('User')->deduct_sms($uid,1);	

						}
						$data = array(
							'uid' 	=> $this->user_session['uid'],
							'store_id' 	=> $order['store_id'],
							'price' 	=> 10,
							'mobile' 	=> $mobile,
							'text'		=> $str,
							'status'	=> $return,
							'time' => time(),
							'type'	=> $id,
							'last_ip'	=> ip2long(get_client_ip())
							);
						D('Sms_record')->data($data)->add();




					}
				}


			}	

		}
		$dcz = D('pigcms_meal_order');
		$cz['order_id'] = $_GET['order_id'];
		$czn = $dcz->where($cz)->find();
		$this->assign('czn',$czn);			

		$user =M('User');
		$user = $user->getUserById($this->user_session['uid']);
		$database = D('pigcms_meal_cz');
		$where = array();
		$where['physical_id'] = $_REQUEST['physical_id'];
		$list = $database->where($where)->order('`cz_id` DESC')->select();

		$this->assign('czlist',$list);
		$this->assign('mendian', $user['drp_store_id']);
		$this->assign('zqx', $user['zqx']);
		$this->display();
	}


	/* 商品删除 */
	public function order_del(){

		$database_meal = D('pigcms_meal_order');
		$condition_meal['order_id'] = $_GET['order_id'];
		if($database_meal->where($condition_meal)->delete()){
			redirect(url('user:meal:order').'&ok_tips=成功&physical_id='.$_GET['physical_id']);
		}else{
			redirect(url('user:meal:order').'&ok_tips=失败&physical_id='.$_GET['physical_id']);
		}
	}




	/* 检测店铺存在，并检测是不是归属于商家 */
	protected function check_store($physical_id){

		$database_merchant_store = D('pigcms_store_physical');
		$condition_merchant_store['pigcms_id'] = $physical_id;
		$condition_merchant_store['store_id'] = $this->store_session['store_id'];
		$now_store = $database_merchant_store->where($condition_merchant_store)->find();
		if(empty($now_store)){
			echo '该门店不存在';
		}else{
			return $now_store;
		}
	}


	public function order()	{
		// $page = max(1, $_GET['page']);
		// $limit = 20;
		// $physical_id = intval($_GET['physical_id']);
		// $keywords = $_GET['keywords'];
		// $start_time = strtotime($_GET['start_time']);
		// $end_time = strtotime($_GET['end_time']);
		// if(empty($physical_id)){
		// 	$physical = D('Store_physical')->where(array('store_id'=>$this->store_session['store_id']))->order('`pigcms_id` ASC')->find();
		// 	$physical_id=$physical['pigcms_id'];
		// 	redirect(url('user:meal:order').'&physical_id='.$physical_id.'&action=all');
		// }

		// $store_physical = D('Store_physical')->where(array('store_id'=>$this->store_session['store_id']))->select();
		// $this->assign('store_physical',$store_physical);
		// $now_store = $this->check_store($physical_id);
		// $state = array('1'=>'待审核','2'=>'待消费','3'=>'已完成','4'=>'已取消');

		// $database = D('pigcms_meal_order');
		// $where['store_uid'] = $this->store_session['store_id'];
		// $where['physical_id'] = $_GET['physical_id'];
		// if ($keywords){
		// 	if ($_GET['search_type']==1){

		// 		$where['name'] = array('like', '%' . $keywords . '%');

		// 	}elseif ($_GET['search_type']==2){
		// 		$where['phone'] = $keywords;

		// 	}

		// }

		// if ($_GET['type']){

		// 	$where['type'] = $_GET['type'];

		// }

		// if($start_time){
		// 	$where['dd_time'] = array('>=',$start_time);
		// }
		// if($end_time){
		// 	$where['dd_time'] = array('<=',$end_time);

		// }
		// if($start_time && $end_time){
		// 	$where['dd_time'] = array(array('>=',$start_time),array('<=',$end_time));

		// }

		// $action = isset($_GET['action']) ? $_GET['action'] : 'all';
		// switch($action){
		// 	case 'dsh':
		// 	$pageTitle = '待审核的预约';
		// 	$where['status'] = 1;
		// 	break;
		// 	case 'dxf':
		// 	$pageTitle = '待消费的预约';
		// 	$where['status'] = 2;
		// 	break;
		// 	case 'suc':
		// 	$pageTitle = '已完成的预约';
		// 	$where['status'] = 3;
		// 	break;
		// 	case 'cancel':
		// 	$pageTitle = '已取消的预约';
		// 	$where['status'] = 4;
		// 	break;
		// 	default:
		// 	$where['status'] = array('<', 5);
		// 	$pageTitle = '全部预约';
		// }

		// $count = $database->where($where)->count('order_id');

		// $list = array();
		// $pages = '';
		// $total_pages = ceil($count / $limit);
		// if ($count > 0) {
		// 	$page = min($page, $total_pages);
		// 	$offset = ($page - 1) * $limit;

		// 	$list = $database->where($where)->order('`order_id` DESC')->limit($offset.','.$limit)->select();

		// 	foreach ($list as $key => $store)
		// 	{
		// 		$user = D('User')->where(array('uid'=>$store['uid']))->find();
		// 		$list[$key]['nickname'] = $user['nickname'];
		// 		$list[$key]['avatar'] = $user['avatar'];
		// 		if($store['tableid']){
		// 			$list[$key]['tableid'] = $this->store_cz($store['tableid']);
		// 		}else{

		// 			$list[$key]['tableid'] = '未分配';
		// 		}
		// 		$list[$key]['status'] = $state[$store['status']];

		// 	}

		// 	// 分页
		// 	import('source.class.user_page');
		// 	$user_page = new Page($count, $limit, $page);
		// 	$pages = $user_page->show();
		// }


		// $this->assign('pages', $pages);
		// $this->assign('order_list', $list);

		// $this->assign('now_store', $now_store);
		// $user =M('User');
		// $user = $user->getUserById($this->user_session['uid']);
		// $this->assign('mendian', $user['drp_store_id']);
		// $this->assign('zqx', $user['zqx']);
		
		$where=array();
		if($_SESSION['user']['item_store_id']){
		$where['pigcms_id']=$_SESSION['user']['item_store_id'];
		}
		$where['store_id']=$this->store_session['store_id'];
		$store_physical = D('Store_physical')->where($where)->select();
		$this->assign('store_physical',$store_physical);
		$physical = D('Store_physical')->where($where)->order('`pigcms_id` ASC')->find();
		$frist_sore=$physical['pigcms_id'];
		$this->assign('frist_sore', $frist_sore);
		$this->display();
	}

	public function table()
	{  

		$page = max(1, $_GET['page']);
		$limit = 200;
		$cat_id=$_REQUEST['cat_id'];
		$physical_id=$_REQUEST['physical_id'];
		$where=array();
		if($_SESSION['user']['item_store_id']){
		$where['pigcms_id']=$_SESSION['user']['item_store_id'];
		}
		$where['store_id']=$this->store_session['store_id'];
		$store_physical = D('Store_physical')->where($where)->select();
		$this->assign('store_physical',$store_physical);

		if(empty($physical_id)){
			$physical = D('Store_physical')->where($where)->order('`pigcms_id` ASC')->find();
			$physical_id=$physical['pigcms_id'];
			redirect(url('user:meal:table').'&physical_id='.$physical_id);
		}

		$now_store = $this->check_store($physical_id);
		$this->assign('now_store',$now_store);
		$database = D('pigcms_meal_cz');
		$where=array();
		if($cat_id){
			$where['wz_id'] = $_REQUEST['cat_id'];
		}
		$where['physical_id'] = $physical_id;
		$count = $database->where($where)->count('physical_id');
		$list = array();
		$pages = '';
		$total_pages = ceil($count / $limit);

		if ($count > 0) {
			$page = min($page, $total_pages);
			$offset = ($page - 1) * $limit;

			$list = $database->where($where)->order('`cz_id` DESC')->limit($offset.','.$limit)->select();

			//var_dump($list);
			// 分页
			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}


		$cz =$database->where($where)->order('`cz_id` DESC')->find();
		$olimit = 50;
		$ooffset = 0;
		$tableid = isset($_GET['cz_id']) ? $_GET['cz_id'] : $cz['cz_id'];
		$tdatabase = D('pigcms_meal_order');
		$twhere['physical_id'] = $physical_id;
		$twhere['tableid'] = $tableid;
		$twhere['status'] = 2;

		$olist = $tdatabase->where($twhere)->order('`order_id` DESC')->limit($ooffset.','.$olimit)->select();
		foreach ($olist as $key => $store)
		{

			$user = D('User')->where(array('uid'=>$store['uid']))->find();
			$olist[$key]['nickname'] = $user['nickname'];
			$olist[$key]['avatar'] = $user['avatar'];
		}
		$this->assign('pages', $pages);
		$this->assign('list', $list);
		$this->assign('order_list', $olist);
		$this->assign('cz', $tableid);


		$category=D('Meal_category');
		$cat_list = $category->where(array('store_id'=>$this->store_session['store_id'],'physical_id'=>$physical_id))->order('cat_sort desc')->select();
		$this->assign('cat_list', $cat_list);

		$user =M('User');
		$user = $user->getUserById($this->user_session['uid']);
		$this->assign('mendian', $user['drp_store_id']);
		$this->assign('zqx', $user['zqx']);
        $where=array();
		if($_SESSION['user']['item_store_id']){
		$where['pigcms_id']=$_SESSION['user']['item_store_id'];
		}
		$where['store_id']=$this->store_session['store_id'];
		$physical = D('Store_physical')->where($where)->order('`pigcms_id` ASC')->find();
		$frist_sore=$physical['pigcms_id'];
		$this->assign('frist_sore', $frist_sore);
		$this->display();
	}

	public function table_add()
	{
		$now_store = $this->check_store($_GET['physical_id']);
		$this->assign('now_store',$now_store);
		if (IS_POST) {

			if(empty($_POST['name'])){
				$error_tips .= '茶座编号必填！'.'<br/>';
			}

			if(empty($error_tips)){

				$database = D('pigcms_meal_cz');


				$data_category['name'] = $_POST['name'];
				$data_category['physical_id'] = $_POST['physical_id'];
				$data_category['description'] = $_POST['description'];
				$data_category['content'] = $_POST['content'];
				$data_category['sale'] = $_POST['sale'];
				$data_category['wz_id'] = $_POST['wz_id'];
				$data_category['zno'] = $_POST['zno'];
				$data_category['add_time'] = $_SERVER['REQUEST_TIME'];
				$data_category['price'] = $_POST['price'];
				$data_category['status'] = $_POST['status'];
				$data_category['seller_id'] = $this->store_session['store_id'];
				$data_category['image'] = $_POST['image'];
				$data_category['images'] = implode(',',$_POST['images']);

				if($database->data($data_category)->add()){
					json_return(0, '添加成功');
				}else{
					json_return(1000, '添加失败');
				}
			}else{



				$dcz = D('pigcms_meal_cz');
				$cz['physical_id'] = $_GET['physical_id'];
				$cz['seller_id'] = $this->store_session['store_id'];
				$czn = $dcz->where($cz)->find();
				$this->assign('czn',$czn);			
			}
			$this->assign('now_table',$_POST);
			$this->assign('ok_tips',$ok_tips);
			$this->assign('error_tips',$error_tips);
		}
		$this->assign('error_tips',$error_tips);
		$user =M('User');
		$user = $user->getUserById($this->user_session['uid']);
		$this->assign('mendian', $user['drp_store_id']);
		$physical_id=$_REQUEST['physical_id'];
		$category=D('Meal_category');
		$cat_list = $category->where(array('store_id'=>$this->store_session['store_id'],'physical_id'=>$physical_id))->order('cat_sort desc')->select();
		$this->assign('cat_list', $cat_list);
		$this->assign('zqx', $user['zqx']);
		$this->display();
	}

	public function table_edit()
	{
		$now_store = $this->check_store($_GET['physical_id']);
		$this->assign('now_store',$now_store);
		if (IS_POST) {
			$database_category = D('pigcms_meal_cz');
			$condition_category['cz_id'] = $_POST['cz_id'];
			$data_category['name'] = $_POST['name'];
			$data_category['physical_id'] = $_POST['physical_id'];
			$data_category['description'] = $_POST['description'];
			$data_category['content'] = $_POST['content'];
			$data_category['sale'] = $_POST['sale'];
			$data_category['wz_id'] = $_POST['wz_id'];
			$data_category['zno'] = $_POST['zno'];
			$data_category['add_time'] = $_SERVER['REQUEST_TIME'];
			$data_category['price'] = $_POST['price'];
			$data_category['status'] = $_POST['status'];
			$data_category['seller_id'] = $this->store_session['store_id'];
			$data_category['image'] = $_POST['image'];
			$data_category['images'] = implode(',',$_POST['images']);

			if (!$database_category->where($condition_category)->data($data_category)->save()) {
				json_return(1000, '保存失败');
			} else { 
				json_return(0, '保存成功');
			}
		}else{

			$dcz = D('pigcms_meal_cz');
			$cz['cz_id'] = $_GET['cz_id'];
			$czn = $dcz->where($cz)->find();
			$this->assign('czn',$czn);			
		}
		$user =M('User');
		$user = $user->getUserById($this->user_session['uid']);
		$this->assign('mendian', $user['drp_store_id']);

		$physical_id=$_REQUEST['physical_id'];
		$category=D('Meal_category');
		$cat_list = $category->where(array('store_id'=>$this->store_session['store_id'],'physical_id'=>$physical_id))->order('cat_sort desc')->select();

		$this->assign('pic_list', explode(',',$czn['images']));
		$this->assign('cat_list', $cat_list);
		$this->assign('zqx', $user['zqx']);
		$this->display();
	}

	public function table_del()
	{
		$now_store = $this->check_store($_GET['physical_id']);
		$database = D('pigcms_meal_cz');
		if ($database->where(array('cz_id' => intval($_GET['cz_id']), 'physical_id' => $_GET['physical_id']))->delete()) {
			redirect(url('user:meal:table').'&ok_tips=成功&physical_id='.$_GET['physical_id']);
		} else{
			redirect(url('user:meal:table').'&ok_tips=失败&physical_id='.$_GET['physical_id']);
		}
	}




	public function store_cz($cz_id)
	{
		$canz = D('pigcms_meal_cz');

		$canzn = $canz->where(array('cz_id'=>$cz_id))->find();
		$baoxiang =$canzn['name'];
		return $baoxiang;
	}	



	public function order_ajax()
	{ 
		$physical_id = intval($_REQUEST['shopid']);
		$tableid = intval($_REQUEST['tableid']);
		$stime = $_REQUEST['stime'];
		$etime = $_REQUEST['etime'];
		$status = intval($_REQUEST['status']);
		$store_id = $this->store_session['store_id'];
		if(empty($store_id)){
			json_return(1,'用户未登录');
		}
		if(empty($physical_id)){
			json_return(1,'门店不能为空');
		}
		$state = array('1'=>'待审核','2'=>'待消费','3'=>'已完成','4'=>'已取消');
		$time=strtotime(date('Y-m-d',time()));
		$database = D('Meal_order');
		$where['store_uid'] = $store_id;
		$todaywhere['store_uid'] = $store_id;
		$sevenwhere['store_uid'] = $store_id;
		$waitwhere['store_uid'] = $store_id;
		$waitmoneywhere['store_uid'] = $store_id;

	
		// 待确认订座
		$waitwhere['status'] = 1;
		
		// 即将到店
	
		$todaywhere['status'] = 2;
		$todaywhere['dd_time'] = array(array('>=',time()),array('<',time()+ 86400));

	

		// 待确认到店
		
		$waitmoneywhere['status'] = 2;
		$waitmoneywhere['dd_time'] = array(array('<=',time()),array('>=',time()- 86400));

		// 近七日到店
	
		$sevenwhere['status'] = 3;
		$sevenwhere['dd_time'] = array(array('<=',time()),array('>=',$time- 86400*7));
		
		
		
		
		
		if($status){
			$where['status'] = $status;
		}else{

			$where['status'] = array('<', 5);
		}
		if($tableid){
			$where['tableid'] = $tableid;
		}
		if($stime){
			$where['dd_time'] = array('>=', $stime);
		}
		if($etime){
			$where['dd_time'] = array('<=', $etime); 
		}
		
		
		if($stime && $etime){
			$where['dd_time'] = array(array('>=',$stime),array('<=',$etime));
		}

		
		
		if($physical_id){
			$where['physical_id'] = $physical_id;
			$sevenwhere['physical_id'] = $physical_id;
			$todaywhere['physical_id'] = $physical_id;
			$waitwhere['physical_id'] = $physical_id;
			$waitmoneywhere['physical_id'] = $physical_id;
		}
		$waitmoney=$database->where($waitmoneywhere)->count('order_id');
		$wait=$database->where($waitwhere)->count('order_id');
		$today=$database->where($todaywhere)->count('order_id');
		$sevendays=$database->where($sevenwhere)->count('order_id');
		$count = $database->where($where)->count('order_id');
		$list = array();
		$list = $database->where($where)->order('`order_id` DESC')->select();
		foreach ($list as $key => $store)
		{

			$user = D('User')->where(array('uid'=>$store['uid']))->find();
			$list[$key]['nickname'] = $user['nickname'];
			$list[$key]['avatar'] = $user['avatar'];
			if($store['tableid']){
				$list[$key]['tableid'] = $this->store_cz($store['tableid']);
			}else{

				$list[$key]['tableid'] = '未分配';
			}
			$list[$key]['status'] = $state[$store['status']];
			$list[$key]['dd_time'] = date('Y-m-d H:i',$store['dd_time']);
		}

		$results = array('err_code'=>'0','err_msg'=>$list,'count'=>$count,'sevendays'=>$sevendays,'wait'=>$wait,'waitmoney'=>$waitmoney,'today'=>$today,'time'=>time().'000');
		exit(json_encode($results));	
	}




	public function sevenorder_ajax()
	{ 
		$physical_id = intval($_REQUEST['shopid']);
		$starttime = $_REQUEST['stime'];
		$endtime = $_REQUEST['etime'];
		$store_id = $this->store_session['store_id'];
		if(empty($store_id)){
			json_return(1,'用户未登录');
		}
		if(empty($physical_id)){
			json_return(1,'门店不能为空');
		}
		$state = array('1'=>'待审核','2'=>'待消费','3'=>'已完成','4'=>'已取消');

		$database = D('Meal_order');
		$where['store_uid'] = $store_id;


		if($physical_id){
			$where['physical_id'] = $physical_id;

		}

		$list = array();

		for ($i=0; $i<7; $i++)
		{
			if($i==0){
				$day[$i] = date('Y-m-d',time());
			}else{
				$day[$i] = date('Y-m-d',strtotime('-'.$i.' day'));
			}

			$etime=strtotime($day[$i])+86399;

			$stime=strtotime($day[$i]);

			$where['dd_time'] = array(">='$stime' and dd_time<='$etime'"); 

			$where['status'] = 2;

			$waitmoney[$i] = $database->where($where)->order('`order_id` DESC')->count();

			$where['status'] = 3;
			$sucess[$i] = $database->where($where)->order('`order_id` DESC')->count();

		}

		$list['day'] = $day;
		$list['waitmoney'] = $waitmoney;
		$list['sucess'] = $sucess;

		$results = array('err_code'=>'0','err_msg'=>$list);
		exit(json_encode($results));	
	}



}




?>