<?php
class events_controller extends base_controller{
	public function load(){
		$action = strtolower(trim($_POST['page']));
		if (empty($action)) pigcms_tips('非法访问！', 'none');
		switch ($action) {
			case 'list': //茶会列表
			$this->_list_content();
			break;
			case 'add': //新增茶会
			$this->_event_add_content();
			break;
			case 'edit': //门店管理
			$this->_event_edit_content();
			break;
			case 'result': //门店管理
			$this->_event_result_content();
			break;
			default:
			break;
		}
		$this->display($_POST['page']);
	}

	//茶会管理
	public function index(){

		$page = max(1, $_GET['page']);

		$limit = 6;
		$count = D('Chahui')->where(array('store_id'=>$this->store_session['store_id']))->count('pigcms_id');
		if ($count > 0) {
			$pages = '';
			$total_pages = ceil($count / $limit);

			$page = min($page, $total_pages);
			$offset = ($page - 1) * $limit;
			$store_physical = D('Chahui')->where(array('store_id'=>$this->store_session['store_id']))->order('pigcms_id DESC')->limit($offset.','.$limit)->select();
			foreach($store_physical as $key => $r){
				$store_physical[$key]['sttime']=date('Y-m-d H:i:s',$r['sttime']);
				$store_physical[$key]['endtime']=date('Y-m-d H:i:s',$r['endtime']);
			}
			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}
		
		$this->assign('pages', $pages);
		$this->assign('store_physical',$store_physical);
		$this->display();
	}
	
	
	
	public function result(){

		$pigcms_id=$_REQUEST['id'];
		$chahui = D('Chahui')->where(array('pigcms_id'=>$pigcms_id))->find();
		$chahui['sttime']=date('Y-m-d H:i:s',$chahui['sttime']);
		$chahui['endtime']=date('Y-m-d H:i:s',$chahui['endtime']);
		import('area');
		$areaClass = new area();
		$chahui['province_txt'] = $areaClass->get_name($chahui['province']);
		$chahui['city_txt'] 	= $areaClass->get_name($chahui['city']);
		$chahui['county_txt'] 	= $areaClass->get_name($chahui['county']);
		$category = D('Chahui_category')->where(array('cat_id'=>$chahui['zt']))->find();
		$chahui['category'] = $category['cat_name'];
		$where=array();
		$where['cid']=$pigcms_id;
		if($_REQUEST['status']){
			$where['status']=$_REQUEST['status'];
		}
		$page = max(1, $_GET['page']);
		$limit = 10;
		$count = D('Chahui_bm')->where($where)->count('id');
		if ($count > 0) {
			$pages = '';
			$total_pages = ceil($count / $limit);

			$page = min($page, $total_pages);
			$offset = ($page - 1) * $limit;
			$result = D('Chahui_bm')->where($where)->order('id DESC')->limit($offset.','.$limit)->select();
			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}
		$this->assign('count', $count);
		$this->assign('pages', $pages);
		$this->assign('result',$result);
		$this->assign('chahui',$chahui);
		$this->display();
	}
	
	private function _list_content(){
		$page = max(1, $_POST['pages']);
		$limit = 20;
		$count = D('Chahui')->where(array('store_id'=>$this->store_session['store_id']))->count('pigcms_id');
		if ($count > 0) {
			$pages = '';
			$total_pages = ceil($count / $limit);
			$page = min($page, $total_pages);
			$offset = ($page - 1) * $limit;
			$store_physical = D('Chahui')->where(array('store_id'=>$this->store_session['store_id']))->order('pigcms_id DESC')->limit($offset.','.$limit)->select();
			$events = array();
			foreach($store_physical as $k=>$value){
			    $events[$k]['images'] = $value['images'];
			    $events[$k]['last_time'] = $value['last_time'];
			    $events[$k]['pigcms_id'] = $value['pigcms_id'];
			    $events[$k]['store_id'] = $value['store_id'];
			    $events[$k]['name'] = $value['name'];
			    $events[$k]['sttime'] = $value['sttime'];
			    $events[$k]['endtime'] = $value['endtime'];
			    $events[$k]['tickets'] = $value['tickets'];
			    $events[$k]['price'] = $value['price'];
				$audit_count = D('Chahui_bm')->where(array('store_id'=>$this->store_session['store_id'],'cid'=>$value['pigcms_id'],'status'=>'1'))->count('id');
				$events[$k]['audit'] = $audit_count;
			}
			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}
		$this->assign('pages', $pages);
		$this->assign('events',$events);
	}
	
	private function _event_edit_content(){
		$store_physical = D('Chahui')->where(array('store_id'=>$this->store_session['store_id'],'pigcms_id'=>$_POST['pigcms_id']))->find();
		if(empty($store_physical)){
			exit('该茶会不存在！');
		}
		$store_physical['sttime']=date('Y-m-d H:i:s',$store_physical['sttime']);
		
		$store_physical['endtime']=date('Y-m-d H:i:s',$store_physical['endtime']);
		$store_physical['images_arr'] = explode(',',$store_physical['images']);
		foreach($store_physical['images_arr'] as &$physical_value){
			$physical_value = getAttachmentUrl($physical_value);
		}
		$physical = D('Store_physical')->where(array('store_id'=>$this->store_session['store_id']))->select();
		$this->assign('physical',$physical);
		$category = D('Chahui_category')->select();
		$this->assign('category', $category);
		$this->assign('store_physical',$store_physical);
	}
	
	private function _event_add_content(){
		$physical = D('Store_physical')->where(array('store_id'=>$this->store_session['store_id']))->select();
		$this->assign('physical',$physical);
		$category = D('Chahui_category')->select();
		$this->assign('category', $category);

	}
	
	//添加茶会
	public function physical_add(){
		if(IS_POST){
			$data_store_physical['store_id'] = $this->store_session['store_id'];
			$data_store_physical['name'] = $_REQUEST['name'];
			$data_store_physical['sttime'] = strtotime($_POST['start_time']);
			$data_store_physical['endtime'] = strtotime($_POST['end_time']);
			$data_store_physical['province'] = $_POST['province'];
			$data_store_physical['city'] = $_POST['city'];
			$data_store_physical['physical_id'] = $_POST['physical_id'];
			$data_store_physical['descs'] = $_POST['descs'];
			$data_store_physical['county'] = $_POST['county'];
			$data_store_physical['address'] = $_POST['address'];
			$data_store_physical['long'] = $_POST['map_long'];
			$data_store_physical['lat'] = $_POST['map_lat'];
			$data_store_physical['last_time'] = $_SERVER['REQUEST_TIME'];
			$data_store_physical['uid'] = $this->user_session['uid'];
			$data_store_physical['renshu'] = $_POST['renshu'];
			$data_store_physical['tickets'] = $_POST['tickets'];
			$data_store_physical['zt'] = $_POST['zt'];
			$data_store_physical['tj'] = $_POST['tj'];
			if(is_array($_POST['images'])){
				foreach($_POST['images'] as &$images_value){
					$images_value = getAttachment($images_value);
				}
				$data_store_physical['images'] = implode(',',$_POST['images']);
			}else {
				json_return(1,'门店照片不存在，添加失败');
			}
			$data=$data_store_physical['province'];

			$data_store_physical['price'] = $_POST['price'];
			$data_store_physical['description'] = $_POST['description'];
            $data_store_physical['tel'] = $_POST['tel'];
			$database_store_physical = D('Chahui');
			if($database_store_physical->data($data_store_physical)->add()){
				json_return(0,'添加成功');
			}else{
				json_return(1,'添加失败');
			}
		}else{
			json_return(1,'非法访问！');
		}
	}

	//茶会编辑
	public function physical_edit(){
		if(IS_POST){
			$condition_store_physical['pigcms_id'] = $_POST['pigcms_id'];	
			$condition_store_physical['store_id'] = $this->store_session['store_id'];
			$data_store_physical['name'] = $_REQUEST['name'];
			$data_store_physical['sttime'] = strtotime($_POST['start_time']);
			$data_store_physical['endtime'] = strtotime($_POST['end_time']);
			$data_store_physical['province'] = $_POST['province'];
			$data_store_physical['city'] = $_POST['city'];
			$data_store_physical['county'] = $_POST['county'];
			$data_store_physical['address'] = $_POST['address'];
			$data_store_physical['long'] = $_POST['map_long'];
			$data_store_physical['lat'] = $_POST['map_lat'];
			$data_store_physical['uid'] = $this->user_session['uid'];
			$data_store_physical['last_time'] = $_SERVER['REQUEST_TIME'];
			$data_store_physical['renshu'] = $_POST['renshu'];
			$data_store_physical['tickets'] = $_POST['tickets'];
			$data_store_physical['zt'] = $_POST['zt'];
			$data_store_physical['tj'] = $_POST['tj'];
			if(is_array($_POST['images'])){
				foreach($_POST['images'] as &$images_value){
					$images_value = getAttachment($images_value);
				}
				$data_store_physical['images'] = implode(',',$_POST['images']);
			}else {
				json_return(1,'门店照片不存在，修改失败');
			}
			
			
			$data_store_physical['images'] = implode(',',$_POST['images']);
			$data_store_physical['price'] = $_POST['price'];
			$data_store_physical['descs'] = $_POST['descs'];
			$data_store_physical['description'] = $_POST['description'];
			$data_store_physical['physical_id'] = $_POST['physical_id'];
			$data_store_physical['tel'] = $_POST['tel'];
			$database_store_physical = D('Chahui');
			if($database_store_physical->where($condition_store_physical)->data($data_store_physical)->save()){
				json_return(0,'修改成功');
			}else{
				json_return(1,'修改失败');
			}
		}else{
			json_return(1,'非法访问！');
		}
	}

	public function bm_edit(){
		
		$database_store_physical = D('Chahui_bm');
		$id = $_REQUEST['id'];
		$data['status'] = $_REQUEST['status'];
		$store_id  = $this->store_session['store_id'];
		$where=" id='$id' and store_id='$store_id'";
		
		$database_store_physical->where($where)->data($data)->save();


		$order = D('Chahui_bm')->where($where)->find();


		if($_REQUEST['status']==2){
			$id=13;
		}elseif($_REQUEST['status']==3){
			$id=12;
		}

		$now_store = D('Store')->where(array('store_id' => $this->store_session['store_id']))->find();
		$user=M('User')->getUserById($now_store['uid']);
		$power=M('Sms_by_code')->power($now_store['store_id'],$id);
		if($user['smscount']>0 && $power){
			
			$sms = D('Sms_tpl')->where(array('id'=>$id,'status'=>'1'))->find();

			if($sms){
				import('source.class.SendSms');

				$chahui = D('Chahui')->where(array('pigcms_id'=>$order['cid']))->find();
				$storename=$now_store['name']; 
				$content=$chahui['name']; 
				$mobile=$order['mobile'];
				$tel=$now_store['tel'];
				$times=date('Y-m-d H:i',$chahui['sttime']); 

				$str=$sms['text'];
				$str=str_replace('{storename}',$storename,$str);
				$str=str_replace('{content}',$content,$str); 
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

		$url='user.php?c=events&a=baoming&id='.$_REQUEST['cid'];
		redirect($url);
		
	}
	
	//删除茶会
	public function physical_del(){
		
		$database_store_physical = D('Chahui');
		$id = $_REQUEST['pigcms_id'];
		$store_id  = $this->store_session['store_id'];
		$where=" pigcms_id='$id' and store_id='$store_id'";
		
		$database_store_physical->where($where)->delete();
		
		json_return(0,'删除成功');
	}
	
	public function logistics() {
		$store = M('Store')->getStore($this->store_session['store_id']);
		$this->assign('store', $store);
		$user =M('User');
		$user = $user->getUserById($this->user_session['uid']);
		$this->assign('zqx', $user['zqx']);
		$this->display();
	}
	
	public function logistics_status() {
		$status = intval(trim($_POST['status']));
		$store_id = $this->store_session['store_id'];
		
		$store = M('Store');
		$result = D('Store')->where(array('store_id' => $store_id))->data(array('open_logistics' => $status))->save();
		if ($result) {
			json_return(0, '保存成功！');
		} else {
			json_return(4099, '保存失败，请重试！');
		}
	}
	
}
?>