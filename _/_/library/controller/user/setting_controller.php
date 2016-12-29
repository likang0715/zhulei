<?php
class setting_controller extends base_controller{
  public function load(){
    $action = strtolower(trim($_POST['page']));
    if (empty($action)) pigcms_tips('非法访问！', 'none');
    switch ($action) {
      case 'store_content': //店铺信息
      $this->_store_content();
      break;
	  case 'contact_content': //联系我们
      $this->_contact_content();
      break;
	  case 'list_content': //门店管理列表
      $this->_list_content();
      break;
	  case 'physical_edit_content': //门店编辑
      $this->_physical_edit_content();
      break;
      case 'shop_mall': //店铺下单信息提示
      $this->_shop_mall();
      break;
      case 'assign_quantity': //分配门店库存
      $this->_assign_quantity();
      break;
      case 'notice_switch': //通知开关
      $this->_notice_switch();
      break;
      case 'store_notice_setting':
      $this->_store_notice_setting();
      break;
      case 'friend_content':
      $this->_friend_content();
      break;
      case 'address_add':
      $this->_address_add();
      break;
      case 'address_edit':
      $this->_address_edit();
      break;
      case 'admin_list': //门店管理员
      $this->_admin_list();
      break;
      case 'admin_add':
      $this->_admin_add();
      break;
      case 'admin_edit':
      $this->_admin_edit();
      break;
      case 'notice_sms'://短信管理
      $this->_notice_sms();
      break;
      case 'notice_recipient'://接收人设置
      $this->_notice_recipient();
      break;
      default:
      break;
    }
	 $keyword = D('Tag')->select();
     $this->assign('keyword',$keyword);
    $this->display($_POST['page']);
  }
	 //店铺名称唯一性检测
  public function store_name_check()
  {
    $store = M('Store');

    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $unique = $store->getUniqueName($name);
    echo $unique;
    exit;
  }
    //设置店铺
  public function store(){
    if (IS_POST) {
      $store = M('Store');
      $name    = isset($_POST['name']) ? trim($_POST['name']) : '';
      if(isset($_POST['logo'])){
				$logo = getAttachment($_POST['logo']);//str_replace(array(option('config.site_url').'/upload/images/','./upload/images/'),'',trim($_POST['logo']));
			}else{
				$logo = '';
			}
      $intro   = isset($_POST['intro']) ? trim($_POST['intro']) : '';
      $linkman = isset($_POST['linkman']) ? trim($_POST['linkman']) : '';
      $legal_person = isset($_POST['legal_person']) ? trim($_POST['legal_person']) : '';
      $qq      = isset($_POST['qq']) ? trim($_POST['qq']) : '';
      $mobile  = isset($_POST['mobile']) ? trim($_POST['mobile']) : '';
      $open_service  = isset($_POST['open_service']) ? intval(trim($_POST['open_service'])) : 0;
      $is_show_drp_tel  = isset($_POST['is_show_drp_tel']) ? trim($_POST['is_show_drp_tel']) : '';
      $price   = isset($_POST['price']) ? trim($_POST['price']) : '';
      $data = array();
      if($name) $data['name'] = $name;
      if($logo) $data['logo'] = $logo;
      $data['intro'] = $intro;
      $data['price'] = $price;
      $data['linkman'] = $linkman;
      $data['legal_person'] = $legal_person;
      $data['qq'] = $qq;
      $data['tel'] = $mobile;
      $data['is_show_drp_tel'] = $is_show_drp_tel;
      $data['open_service'] = $open_service;
      $data['sale_category_id']   = intval($_POST['sale_category_id']);
      $data['sale_category_fid']  = intval($_POST['sale_category_fid']);

      if ($_SESSION['store']['name'] != $name) {
                $data['edit_name_count'] = $_SESSION['store']['edit_name_count'] + 1; //店铺名称修改次数
              }
              $sale_category = M('Sale_category');
              $where = array();
              $where['store_id'] = $this->store_session['store_id'];

              $info = D('Store')->where($where)->find();
              if ($data['sale_category_id'] && $data['sale_category_fid']) {
                $sale_category->setStoreDec($info['sale_category_id']);
                $sale_category->setStoreDec($info['sale_category_fid']);
              } else if ($data['sale_category_fid'] && empty($data['sale_category_id'])) {
                $sale_category->setStoreDec($info['sale_category_id']);
                $sale_category->setStoreDec($info['sale_category_fid']);
                $data['sale_category_id']   = 0;
              }

              if ($store->setting($where, $data)) {
                $_SESSION['store']['name'] = $name;
                $_SESSION['store']['logo'] = $_POST['logo'];
                $_SESSION['store']['edit_name_count'] += 1;
                if ($data['sale_category_id']) {
                  $sale_category->setStoreInc($data['sale_category_id']);
                } 
                if ($data['sale_category_fid']) {
                  $sale_category->setStoreInc($data['sale_category_fid']);
                }
              }
              json_return(0, url('store:index'));
            }

            $id = $_GET['id'] + 0;
            if (!empty($id)) {
             $store = M('Store')->getStoreById($id, $_SESSION['user']['uid']);
             if (empty($store)) {
              pigcms_tips('未找到相应的店铺', 'none');
            }

            $_SESSION['store'] = $store;
          }
		  
		  
		 
		  
          $this->display();
        }
	//联系我们
        public function contact(){
          if(IS_POST){
           $data_store_contact['phone1'] = $_POST['phone1'];
           $data_store_contact['phone2'] = $_POST['phone2'];
           $data_store_contact['province'] = $_POST['province'];
           $data_store_contact['city'] = $_POST['city'];
           $data_store_contact['county'] = $_POST['county'];
           $data_store_contact['address'] = $_POST['address'];
           $data_store_contact['long'] = $_POST['map_long'];
           $data_store_contact['lat'] = $_POST['map_lat'];
           $data_store_contact['last_time'] = $_SERVER['REQUEST_TIME'];

           $database_store_contact = D('Store_contact');
           $condition_store_contact['store_id'] = $this->store_session['store_id'];
           if($database_store_contact->where($condition_store_contact)->find()){
                // 添加区域修改记录 用于区域管理员关联
            M('Store_contact')->setAreaRelation($condition_store_contact['store_id'], $data_store_contact);
            if($database_store_contact->where($condition_store_contact)->data($data_store_contact)->save()){
             json_return(0,'保存成功');
           }else{
             json_return(1,'保存失败');
           }
         }else{
          $data_store_contact['store_id'] = $this->store_session['store_id'];
                // 添加区域修改记录 用于区域管理员关联
          M('Store_contact')->setAreaRelation($condition_store_contact['store_id'], $data_store_contact);
          if($database_store_contact->data($data_store_contact)->add()){
           json_return(0,'保存成功');
         }else{
           json_return(1,'保存失败');
         }
       }
     }else{
       json_return(1,'非法访问！');
     }
   }
	//店铺详细
   private function _store_content(){
    $company = M('Company');
    $database_store = M('Store');

    $company = $company->getCompanyByUid($this->user_session['uid']);

        //店铺主营类目
    $sale_category = $database_store->getSaleCategory($this->store_session['store_id'], $this->user_session['uid']);
    $store = $database_store->getStoreById($this->store_session['store_id'], $this->user_session['uid']);

    $tmp_categories = M('Sale_category')->getCategoriesValid(0);
    $categories = array();
    foreach ($tmp_categories as $tmp_category) {
      $children = M('Sale_category')->getCategoriesValid($tmp_category['cat_id']);
      $categories[$tmp_category['cat_id']] = array(
        'cat_id' => $tmp_category['cat_id'],
        'name' => $tmp_category['name'],
        'children' => $children
        );
    }
    $this->assign('json_categories', json_encode($categories));
    $this->assign('categories', $categories);
        // dump($categories);exit;
    if ($store['drp_level'] > 0) {
      $sup_store          = M('Store')->getSupplier($this->store_session['store_id']);
      $store['update_drp_store_info']     = $sup_store['update_drp_store_info'];
    }

    $this->assign('company', $company);
    $this->assign('store', $store);
    $this->assign('sale_category', $sale_category);
  }
	//联系我们
  private function _contact_content(){
    $store_contact = D('Store_contact')->where(array('store_id'=>$this->store_session['store_id']))->find();
    $this->assign('store_contact',$store_contact);
  }

	//消息通知管理
  private function _notice_switch() {
    $store_id = $this->store_session['store_id'];

    $list = D('Sms_tpl')->where("type!='1' and status='1'")->order('id ASC')->select();

    $power= D('Sms_power')->where(array('store_id' => $store_id))->select();
    foreach($power as $key=>$r){

     $arr[$r[type]]=array($r['status'],$r['weixin']);

   }

   $power_info['has_power_arr'] = $arr;

   $this->assign("store_notice_manage",$power_info);
   $this->assign("notice_manage",$list);
   $this->assign("total_config", '1');
 }


 private function _notice_sms() {
  $store_id=$this->store_session['store_id'];
  $order_sms_model = M('Order_sms');
  $user = M('User')->getUserById($this->user_session['uid']);

  $limit = 20;
  $where=array();
  $where['store_id'] =$store_id;
  $where['status'] = array('<>','-21');
  $smsnum = D('Sms_record')->where($where)->count();

  //短信发送条数
  $send_list = D('Sms_record')->where($where)->order('time DESC')->limit(5)->select();
  $send_list_page = D('Sms_record')->where($where)->order('time DESC')->limit($limit)->select();

  $start_time=strtotime(date('Ymd'));
  $end_time=$start_time+86400;
  $where['time'] = array(array('>=',$start_time),array('<=',$end_time));
  $todaysms = D('Sms_record')->where($where)->count();// 今天发送条数

  $end_time=time();
  $start_time=$end_time-7948800;
  $where['time'] = array(array('>=',$start_time),array('<=',$end_time));
  $send_three_month = D('Sms_record')->where($where)->count();// 近三个月发送条数

  import('source.class.user_page');
  $user_send_page = new Page($send_three_month, $limit, 1);
  $send_pages = $user_send_page->show();// 近三个月发送条数 分页

  $where = array(
   'uid' => $this->user_session['uid']
   );

  $order_by = "dateline desc";	
  $sms_list = $order_sms_model->getsmsList($where,$order_by,7,0);
  $sms_list_page = $order_sms_model->getsmsList($where,$order_by,$limit,0);

  $sms_three_month = D('Order_sms')->where($where)->count();// 近三个月充值次数
  $user_sms_page = new Page($sms_three_month, $limit, 1);
  $sms_pages = $user_sms_page->show();// 近三个月充值次数 分页

  $this->assign("send_list", $send_list);
  $this->assign("sms_list", $sms_list);
  $this->assign("send_list_page", $send_list_page);
  $this->assign("sms_list_page", $sms_list_page);
  $this->assign("smsnum", $smsnum);
  $this->assign("todaysms", $todaysms);
  $this->assign("user", $user);
  $this->assign("send_pages", $send_pages);
  $this->assign("sms_pages", $sms_pages);

}




public function send_list () {

  $store_id = $this->store_session['store_id'];
  $starttime=$_REQUEST['starttime'];
  $endtime=$_REQUEST['endtime'];

  $page = max(1, $_REQUEST['page']);
  $limit = max(1, $_REQUEST['size']);

  $where=array();
  $where['store_id'] = $store_id;
  $where['status'] = array('<>','-21');
  if($starttime && $endtime){
    if ((time()-$endtime>7948800) || (time()-$starttime>7948800)) {
      json_return(1, '只可查询近3个月的记录');
    }
    $where['time'] = array(array('>=',$starttime),array('<=',$endtime));
  }
  $count = D('Sms_record')->where($where)->count();

  if (empty($count)) {
    json_return(1, '没有找到相关记录');
  }

  $max = ceil($count/$limit);

  $page = min($max, $page);

  $offset = ($page - 1) * $limit;

  $list = D('Sms_record')->where($where)->order('time DESC')->limit($offset.','.$limit)->select();
  foreach($list as $key=>$r){
    $send_list[$key]['id']=$r['id'];
    $send_list[$key]['time']=date('Y-m-d H:i:s',$r['time']);
    $send_list[$key]['text']=$r['text'];
    $send_list[$key]['mobile']=$r['mobile'];
    $send_list[$key]['status']=$r['status'];
  }

  import('source.class.user_page');
  $user_page = new Page($count, $limit, $page);
  $pages = $user_page->show();// 分页

  $total['count'] = $count;
  $total['pages'] = $pages;
  
  json_return(0, $send_list, $total);

}

public function sms_list() {
  $order_sms_model = M('Order_sms');
  $starttime=$_REQUEST['starttime'];
  $endtime=$_REQUEST['endtime'];

  $page = max(1, $_REQUEST['page']);
  $limit = max(1, $_REQUEST['size']);


  $where=array();

  $where['uid'] =$this->user_session['uid'];

  if($starttime && $endtime){
    if ((time()-$endtime>7948800) || (time()-$starttime>7948800)) {
      json_return(1, '只可查询近3个月的记录');
    }
    $where['dateline'] = array(array('>=',$starttime),array('<=',$endtime));
  }

  $count = $order_sms_model->getSmsTotal($where);

  $max = ceil($count/$limit);
  
  $page = min($max, $page);
  
  $offset = ($page - 1) * $limit;

  if (empty($count)) {
    json_return(1, '没有找到相关记录');
  }

  $order_by = "sms_order_id desc";	

  import('source.class.user_page');
  $user_page = new Page($count, $limit, $page);
  $pages = $user_page->show();// 分页

  $total['count'] = $count;
  $total['pages'] = $pages;

  $list = $order_sms_model->getsmsList($where,$order_by,$limit,$offset);
  foreach($list as $key=>$r){
    $sms_list[$key]['sms_order_id']=$r['sms_order_id'];
    $sms_list[$key]['dateline']=date('Y-m-d H:i:s',$r['dateline']);
    $sms_list[$key]['money']=$r['money'];
    $sms_list[$key]['smspay_no']=$r['smspay_no'];
    $sms_list[$key]['sms_num']=$r['sms_num'];
    $sms_list[$key]['status']=$r['status'];
  }
  json_return(0, $sms_list, $total);
}

  //接收人设置
private function _notice_recipient(){
  $store_physical = D('Store_physical')->where(array('store_id'=>$this->store_session['store_id']))->select();
  $people_shop = D('Sms_mobile')->where(array('store_id'=>$this->store_session['store_id'],'type'=>1))->find();
  $people_events = D('Sms_mobile')->where(array('store_id'=>$this->store_session['store_id'],'type'=>2))->find();
  $this->assign('people_shop',$people_shop);
  $this->assign('people_events',$people_events);
  $this->assign('store_physical',$store_physical);
}


public function sms_mobile () {

  if (IS_POST) {

   $command =  isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");

   $json=json_decode($command,true);

   $store_id = $this->store_session['store_id'];

   //店铺通知人
   $name_shop=$json['name_shop'];
   $mobile_shop=$json['mobile_shop'];

   //茶会通知人
   $name_enents=$json['name_enents'];
   $mobile_enents=$json['mobile_enents'];

   //订座通知人
   $store=$json['store'];

   if(empty($name_shop) || empty($mobile_shop)){
    json_return(1, '店铺通知接收人信息不能为空');
  }

  if(empty($name_enents) || empty($mobile_enents)){
    json_return(1, '茶会通知接收人信息不能为空');
  }

   //存储店铺通知人信息
  $people_shop = D('Sms_mobile')->where(array('store_id'=>$store_id,'type'=>1))->find();
  $data_shop=array();
  $data_shop['name'] = $name_shop;
  $data_shop['mobile'] = $mobile_shop;

  if($people_shop) {
    $power_shop= D('Sms_mobile')->data($data_shop)->where(array('store_id' => $store_id,'type'=>1))->save();
  } else {
   $data_shop['store_id'] = $store_id;
   $data_shop['type'] = 1;
   $power_shop= D('Sms_mobile')->data($data_shop)->add();
 }

   //存储茶会通知人信息
 $people_enents = D('Sms_mobile')->where(array('store_id'=>$store_id,'type'=>2))->find();
 $data_enents=array();
 $data_enents['name'] = $name_enents;
 $data_enents['mobile'] = $mobile_enents;

 if($people_enents) {
  $power_enents= D('Sms_mobile')->data($data_enents)->where(array('store_id' => $store_id,'type'=>2))->save();
} else {
 $data_enents['store_id'] = $store_id;
 $data_enents['type'] = 2;
 $power_enents= D('Sms_mobile')->data($data_enents)->add();
}

   //存储订座通知人信息
if (!empty($store)) {
  foreach ($store as $key => $value) {
     $condition_store['pigcms_id'] = $store[$key]['store_id'];  
     $condition_store['store_id'] = $this->store_session['store_id'];
     $store_data = D('Store_physical')->where($condition_store)->find();
    if(empty($store_data)){
      json_return(1, '您提交的门店不存在');
    }
    $data_store['mobile'] =  $value['tel'];
    D('Store_physical')->where($condition_store)->data($data_store)->save();
  }
}
json_return(0, 'ok');
}

}

// public function sms_mobile () {

//   $store_id = $this->store_session['store_id'];
//   $mobile=$_REQUEST['mobile'];
//   $name=$_REQUEST['name'];
//   $type=$_REQUEST['type'];
//   if(empty($type)){
//     json_return(1, '类型不能为空');
//   }
//   if(empty($mobile)){
//     json_return(1, '手机不能为空');
//   }
//   $mobile = D('Sms_mobile')->where(array('store_id'=>$store_id,'type'=>$type))->find();
//   $data=array();
//   $data['mobile'] = $mobile;
//   $data['name'] = $name;
//   if($mobile) {
//     $power= D('Sms_mobile')->data($data)->where(array('store_id' => $store_id,'type'=>$type))->save();
//   } else {
//    $data['store_id'] = $store_id;
//    $data['type'] = $type;
//    $power= D('Sms_mobile')->data($data)->add();
//  }
//  json_return(0, 'ok');

// }



    //消息通知管理
public function notice() {
  $store_id = $this->store_session['store_id'];
  import("source.class.templateNews");
  $model = new templateNews();
  $templs = $model->systemTemplates();
  $data = D('Tempmsg')->where("token='system'")->order('id ASC')->select();
  foreach($data as $key=>$val){
   $data[$val['tempkey']] = $val;
 }
 $list   = array();
 foreach ($templs as $k => $v){
   $dbtempls = D('Tempmsg')->where("token='system' AND tempkey='$k'")->find();
   if(empty($dbtempls)){
    $list[]     = array(
     'tempkey'  => $k,
     'name'     => $v['name'],
     'content'  => $v['content'],
     'topcolor' => '#029700',
     'textcolor'    => '#000000',
     'status'   => 0,
     );
  }else{
    $list[]     = $data[$k];
  }
}   
        //获取当前店铺的短信/通知 权限
$store_notice_manager = M('Store_system_notice_manage')->get($store_id);

$this->assign("store_notice_manage",$store_notice_manager);
$this->assign("notice_manage",$list);
$this->assign("total_config", $data);
$this->display();
}

	//消息通知i消息 编辑/保存
private function _store_notice_setting() {

  $fields_seria = $_POST['fields_seria'];
  $store_id = $this->store_session['store_id'];
  $array=array();

  if(count($fields_seria)) {
   foreach($fields_seria as $k=>$v) {
    $arr[$v[name]][] = $v['value'];
  }
}

foreach($arr as $k=>$v) {
  $count = count($v);		
  $store_notice = D('Sms_power')->where(array('store_id'=>$store_id,'type'=>$k))->find();
  $array['type']=$k;
  if($count==1){
   $array['status']= 0;
   $array['weixin']= 0;
 }elseif($count==2){
   if($v['1']==1){
     $array['status']= 1;
     $array['weixin']= 0;
   }elseif($v['1']==2){
     $array['weixin']= 2;
     $array['status']= 0;
   }
 }else{
   $array['status']= 1;
   $array['weixin']= 2;
 }

 if($store_notice) {
  $power= D('Sms_power')->data($array)->where(array('store_id' => $store_id,'type'=>$k))->save();

} else {
 $array['store_id'] = $store_id;

 $power= D('Sms_power')->data($array)->add();
}
}
echo json_encode(array('status'=>0,'msg'=>$fields_seria));exit;
}

    //店铺下单提示信息设置
private function _shop_mall () {
  $store = M('Store')->getStoreById($this->store_session['store_id'], $this->user_session['uid']);
  $this->assign('store', $store);
}

    //ajax 店铺通知记录开关
public function set_shop_notice () {
  $status = intval(trim($_POST['status']));
  $store_id = $this->store_session['store_id'];

        // 【订单提醒管理】 开启同时关闭 【分销引导】
  $store = D('Store')->where(array('store_id'=>$this->store_session['store_id']))->find();
  $data['order_notice_open'] = $status;
  if ($data['order_notice_open']) {
    $data['open_drp_guidance'] = 0;
  }

  $result = D('Store')->where(array('store_id' => $store_id))->data($data)->save();
  if ($result) {
    json_return(0, '保存成功！');
  } else {
    json_return(4099, '保存失败，请重试！');
  }
}

    //店铺订单持续时间设置
public function set_notice_time () {

  $order_notice_time = intval(trim($_POST['order_notice_time']));
  $store_id = $this->store_session['store_id'];

  $store = M('Store');
  $result = D('Store')->where(array('store_id' => $store_id))->data(array('order_notice_time' => $order_notice_time))->save();
  if ($result) {
    json_return(0, '保存成功！');
  } else {
    json_return(4099, '保存失败，请重试！');
  }

}

	//门店管理
private function _list_content(){
  $store_physical = D('Store_physical')->where(array('store_id'=>$this->store_session['store_id']))->select();
  $this->assign('store_physical',$store_physical);
}
	//门店编辑
private function _physical_edit_content(){
  $store_physical = D('Store_physical')->where(array('store_id'=>$this->store_session['store_id'],'pigcms_id'=>$_POST['pigcms_id']))->find();
  if(empty($store_physical)){
   exit('该门店不存在！');
 }

 $store_physical['images_arr'] = explode(',',$store_physical['images']);
 foreach($store_physical['images_arr'] as &$physical_value){
   $physical_value = getAttachmentUrl($physical_value);
 }
 $store_physical['pics'] = explode(',',$store_physical['pics']);
 foreach($store_physical['pics'] as &$physical_value){
   $physical_value = getAttachmentUrl($physical_value);
 }
 if(is_array($_POST['pics'])){
  foreach($_POST['pics'] as &$pics_value){
    $pics_value = getAttachment($pics_value);
  }
  $data_store_physical['pics'] = implode(',',$_POST['pics']);
}
$this->assign('store_physical',$store_physical);
}
    //分配库存
private function _assign_quantity(){
  $product = M('Product');
  $product_group = M('Product_group');
  $product_to_group = M('Product_to_group');
  $product_sku = M('Product_sku');

  $order_by_field = isset($_POST['orderbyfield']) ? $_POST['orderbyfield'] : '';
  $order_by_method = isset($_POST['orderbymethod']) ? $_POST['orderbymethod'] : '';
  $keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';
  $group_id = isset($_POST['group_id']) ? trim($_POST['group_id']) : '';

  $where = array();
  $where['store_id'] = $this->store_session['store_id'];
  $where['quantity'] = array('>', 0);
  $where['soldout'] = 0;
  if ($keyword) {
    $where['name'] = array('like', '%' . $keyword . '%');
  }
  if ($group_id) {
    $products = $product_to_group->getProducts($group_id);
    $product_ids = array();
    if (!empty($products)) {
      foreach ($products as $item) {
        $product_ids[] = $item['product_id'];
      }
    }
    $where['product_id'] = array('in', $product_ids);
  }
  $product_total = $product->getSellingTotal($where);
  import('source.class.user_page');
  $page = new Page($product_total, 15);
  $products = $product->getSelling($where, $order_by_field, $order_by_method, $page->firstRow, $page->listRows);

  $product_groups = $product_group->get_all_list($this->store_session['store_id']);

  foreach ($products as $key => $val) {

    if (empty($val['has_property'])) {
      $products[$key]['sku'] = array();
      continue;
    }

    $val_sku = $product_sku->getSkus($val['product_id']);
            // dump($val_sku);exit;
    foreach ($val_sku as $k => $v) {

      $tmpPropertiesArr = explode(';', $v['properties']);
      $properties = $propertiesValue = $productProperties = array();
      foreach($tmpPropertiesArr as $v){
        $tmpPro = explode(':',$v);
        $properties[] = $tmpPro[0];
        $propertiesValue[] = $tmpPro[1];
      }
      if(count($properties) == 1){
        $findPropertiesArr = D('Product_property')->field('`pid`,`name`')->where(array('pid'=>$properties[0]))->select();
        $findPropertiesValueArr = D('Product_property_value')->field('`vid`,`value`,`image`')->where(array('vid'=>$propertiesValue[0]))->select();
      }else{
        $findPropertiesArr = D('Product_property')->field('`pid`,`name`')->where(array('pid'=>array('in',$properties)))->select();
        $findPropertiesValueArr = D('Product_property_value')->field('`vid`,`value`,`image`')->where(array('vid'=>array('in',$propertiesValue)))->select();
      }
      foreach($findPropertiesArr as $v){
        $propertiesArr[$v['pid']] = $v['name'];
      }
      foreach($findPropertiesValueArr as $v){
        $propertiesValueArr[$v['vid']] = $v['value'];
      }
      foreach($properties as $kk=>$v){
        $productProperties[] = array('pid'=>$v,'name'=>$propertiesArr[$v],'vid'=>$propertiesValue[$kk],'value'=>$propertiesValueArr[$propertiesValue[$kk]], 'image'=>getAttachmentUrl($findPropertiesValueArr[$kk]['image']));
      }

      $val_sku[$k]['_property'] = $productProperties;
    }

    $products[$key]['sku'] = $val_sku;
  }

        // dump($products);exit;
  $this->assign('product_groups', $product_groups);
  $this->assign('product_groups_json', json_encode($product_groups));
  $this->assign('page', $page->show());
  $this->assign('products', $products);
}
    //ajax 弹层获取门店列表
public function assign_quantity_json() {

  $data = array();
  $product_id = $data['product_id'] = !empty($_POST['product_id']) ? intval(trim($_POST['product_id'])) : 0;
  $sku_id = $data['sku_id'] = !empty($_POST['sku_id']) ? intval(trim($_POST['sku_id'])) : 0;

  if (empty($product_id) && empty($sku_id)) {
    json_return(1,'缺少参数，稍后再试');
  }

  $where = array('product_id'=>$product_id);
  if (!empty($sku_id)) {
    $where = array('sku_id'=>$sku_id);
  }

  $store_id = $this->store_session['store_id'];
  $store_physical = D('Store_physical')->where(array('store_id'=>$store_id))->select();

  if (empty($store_physical)) {
    json_return(1,'请先添加门店');
  }

  $data['store_physical'] = $store_physical;

        //被分配的商品
  if (!empty($sku_id)) {
    $data['product_info'] = D('Product_sku')->where($where)->find();
  } else {
    $data['product_info'] = M('Product')->get($where);
  }

        //已经分配的
  $data['physical_quantity'] = M('Store_physical_quantity')->getQuantityByPid($where);

  echo json_encode($data, true);
  exit;
}
    //保存分配库存
public function quantity_set(){

  $store_id = $this->store_session['store_id'];

  $sku_id = !empty($_POST['sku_id']) ? intval(trim($_POST['sku_id'])) : 0;
  $product_id = !empty($_POST['product_id']) ? intval(trim($_POST['product_id'])) : 0;

  $nums = !empty($_POST['nums']) ? $_POST['nums'] : array();
  $physical_ids_new = !empty($_POST['physical_ids']) ? $_POST['physical_ids'] : array();

  if (empty($nums) || empty($physical_ids_new) || count($nums) != count($physical_ids_new)) {
    json_return(0, '数据错误，稍后再试');
  }

  if (!empty($sku_id)) {
    $where = array('sku_id'=>$sku_id);
  } else {
    $where = array('product_id'=>$product_id);
  }

  $num_physical = array_combine($physical_ids_new, $nums);

        //该产品分配过的门店array
  $physical_ids_old = M('Store_physical_quantity')->getPhysicalByPid($where);
  $physical_arr = array_diff($physical_ids_new, $physical_ids_old);

        //新增
  foreach ($physical_arr as $val) {
    $data = array(
      'store_id' => $store_id,
      'product_id' => $product_id,
      'sku_id' => $sku_id,
      'physical_id' => $val,
      'quantity' => $num_physical[$val],
      );
    $return = M('Store_physical_quantity')->add($data);
  }

        //修改
  foreach ($physical_ids_old as $val) {
    $where = array_merge($where, array('physical_id'=>$val));
    $data = array('quantity'=>$num_physical[$val]);
    $return = M('Store_physical_quantity')->edit($where, $data);
  }

  json_return(0, '修改成功');
}
	//门店添加
public function physical_add(){
  if(IS_POST){
   $data_store_physical['store_id'] = $this->store_session['store_id'];
   $data_store_physical['name'] = $_POST['name'];
   $data_store_physical['phone1'] = $_POST['phone1'];
   $data_store_physical['mobile'] = $_POST['mobile'];
   $data_store_physical['phone2'] = $_POST['phone2'];
   $data_store_physical['province'] = $_POST['province'];
   $data_store_physical['price'] = $_POST['price'];
   $data_store_physical['city'] = $_POST['city'];
   $data_store_physical['county'] = $_POST['county'];
   $data_store_physical['keyword'] = $_POST['keyword'];
   $data_store_physical['address'] = $_POST['address'];
   $data_store_physical['long'] = $_POST['map_long'];
   $data_store_physical['lat'] = $_POST['map_lat'];
   $data_store_physical['images'] = $_POST['images'];
   $data_store_physical['shortdesc'] = $_POST['shortdesc'];
   $data_store_physical['last_time'] = $_SERVER['REQUEST_TIME'];
   if(is_array($_POST['pics'])){
    foreach($_POST['pics'] as &$images_value){
     $images_value = getAttachment($images_value);
   }
   $data_store_physical['pics'] = implode(',',$_POST['pics']);
 }else {
  json_return(1,'门店照片不存在，添加失败');
}

$data_store_physical['business_hours'] = $_POST['business_hours'];
$data_store_physical['description'] = $_POST['description'];

$database_store_physical = D('Store_physical');
if($database_store_physical->data($data_store_physical)->add()){
  D('Store')->where(array('store_id'=>$this->store_session['store_id']))->setInc('physical_count');
  json_return(0,'添加成功');
}else{
  json_return(1,'添加失败');
}
}else{
 json_return(1,'非法访问！');
}
}
	//门店编辑
public function physical_edit(){
  if(IS_POST){
   $condition_store_physical['pigcms_id'] = $_POST['pigcms_id'];	
   $condition_store_physical['store_id'] = $this->store_session['store_id'];
   $data_store_physical['name'] = $_POST['name'];
   $data_store_physical['phone1'] = $_POST['phone1'];
   $data_store_physical['phone2'] = $_POST['phone2'];
   $data_store_physical['mobile'] = $_POST['mobile'];
   $data_store_physical['province'] = $_POST['province'];
   $data_store_physical['keyword'] = $_POST['keyword'];
   $data_store_physical['price'] = $_POST['price'];
   $data_store_physical['city'] = $_POST['city'];
   $data_store_physical['county'] = $_POST['county'];
   $data_store_physical['address'] = $_POST['address'];
   $data_store_physical['long'] = $_POST['map_long'];
   $data_store_physical['lat'] = $_POST['map_lat'];
   $data_store_physical['shortdesc'] = $_POST['shortdesc'];
   $data_store_physical['last_time'] = $_SERVER['REQUEST_TIME'];

   if(is_array($_POST['pics'])){
    foreach($_POST['pics'] as &$pics_value){
     $pics_value = getAttachment($pics_value);
   }
   $data_store_physical['pics'] = implode(',',$_POST['pics']);
 }
 $data_store_physical['images'] = $_POST['images'];
 $data_store_physical['business_hours'] = $_POST['business_hours'];
 $data_store_physical['description'] = $_POST['description'];

 $database_store_physical = D('Store_physical');
 if($database_store_physical->where($condition_store_physical)->data($data_store_physical)->save()){
  json_return(0,'修改成功');
}else{
  json_return(1,'修改失败');
}
}else{
 json_return(1,'非法访问！');
}
}
	//门店删除
public function physical_del(){
  if(IS_POST){
    $physical_id = $_POST['pigcms_id'];
    $store_id = $this->store_session['store_id'];
    $database_store_physical = D('Store_physical');
    $condition_store_physical['pigcms_id'] = $physical_id;
    $condition_store_physical['store_id']  = $store_id;
    if($database_store_physical->where($condition_store_physical)->delete()){
      D('Store')->where(array('store_id'=>$store_id))->setDec('physical_count');
                //清除门店库存 && 清除门店订单关系
      D('Store_physical_quantity')->where(array('physical_id'=>$physical_id, 'store_id'=>$store_id))->delete();
      D('Order_product_physical')->where(array('physical_id'=>$physical_id, 'store_id'=>$store_id))->delete();
      json_return(0,'删除成功');
    }else{
      json_return(1,'删除失败');
    }
  }else{
   json_return(1,'非法访问！');
 }
}

	// 物流配送相关
public function config() {
  $this->display();
}

public function logistics() {
  $store = M('Store')->getStore($this->store_session['store_id']);
  $this->assign('store', $store);
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

private function _friend_content(){
  $store = M('Store')->getStoreById($this->store_session['store_id'], $this->user_session['uid']);
  $this->assign('store', $store);

  $commonweal_address_list = M('Commonweal_address')->select($this->store_session['store_id']);
  $this->assign('commonweal_address_list', $commonweal_address_list);
}

private function _address_add() {
  $store = M('Store')->getStoreById($this->store_session['store_id'], $this->user_session['uid']);
  $this->assign('store', $store);
}

private function _address_edit() {
  $id = $_POST['id'];
  if (empty($id)) {
   pigcms_tips('缺少最基本的参数');
 }

 $store = M('Store')->getStoreById($this->store_session['store_id'], $this->user_session['uid']);
 $this->assign('store', $store);

 $commonweal_address = D('Commonweal_address')->where(array('store_id' => $this->store_session['store_id'], 'id' => $id))->find();
 $this->assign('commonweal_address', $commonweal_address);
}

public function commonweal_address() {
  $title = $_POST['title'];
  $name = $_POST['name'];
  $tel = $_POST['tel'];
  $province = $_POST['province'];
  $city = $_POST['city'];
  $area = $_POST['area'];
  $address = $_POST['address'];
  $zipcode = $_POST['zipcode'];
  $is_default = $_POST['is_default'];
  $address_id = $_POST['address_id'];

  if (empty($name)) {
   json_return(1000, '请填写收货人姓名');
 }

 if (empty($tel)) {
   json_return(1000, '请填写联系电话');
 }

 if (!preg_match("/\d{5,12}$/", $tel)) {
   json_return(1000, '请正确填写联系电话');
 }

 if (empty($province)) {
   json_return(1000, '请选择省份');
 }

 if (empty($city)) {
   json_return(1000, '请选择城市');
 }

 if (empty($area)) {
   json_return(1000, '请选择地区');
 }

 if (!empty($address_id)) {
   $commonweal_address = D('Commonweal_address')->where(array('id' => $address_id, 'store_id' => $this->store_session['store_id']))->find();
   if (empty($commonweal_address)) {
    json_return(1000, '未找到相应的公益地址');
  }
}

$default = $is_default ? 1 : 0;
$data = array();
$data['dateline'] = time();
$data['store_id'] = $this->store_session['store_id'];
$data['title'] = $title;
$data['name'] = $name;
$data['tel'] = $tel;
$data['province'] = $province;
$data['city'] = $city;
$data['area'] = $area;
$data['address'] = $address;
$data['zipcode'] = $zipcode;
$data['default'] = $default;

$result = false;
if (empty($address_id)) {
 $result = D('Commonweal_address')->data($data)->add();
 $address_id = $result;
} else {
 $result = D('Commonweal_address')->where(array('id' => $address_id))->data($data)->save();
}

if ($result) {
			// 更改其它的收货地址，不为默认收货地址
 if ($default) {
  D('Commonweal_address')->where(array('store_id' => $this->store_session['store_id'], 'id' => array('!=', $address_id)))->data(array('default' => 0))->save();
}
json_return(0, '操作成功');
} else {
 json_return(1000, '操作失败');
}
}

public function commonweal_address_delete () {
  $id = $_POST['id'];
  if (empty($id)) {
   json_return(1000, '缺少最基本的参数');
 }

 $commonweal_address = D('Commonweal_address')->where(array('store_id' => $this->store_session['store_id'], 'id' => $id))->find();
 if (empty($commonweal_address)) {
   json_return(1000, '未找到要删除的地址');
 }

 if (D('CommonWeal_address')->where(array('id' => $id))->delete()) {
   json_return(0, '删除成功');
 }

 json_return(1000, '删除失败');
}

public function friend_status() {
  $status = intval(trim($_POST['status']));
  $store_id = $this->store_session['store_id'];

  $store = M('Store');
  $result = D('Store')->where(array('store_id' => $store_id))->data(array('open_friend' => $status))->save();
  if ($result) {
   json_return(0, '保存成功！');
 } else {
   json_return(4099, '保存失败，请重试！');
 }
}

    //自动分配订单
public function assign_auto()
{
  $store = M('Store')->getStore($this->store_session['store_id']);
  $this->assign('store', $store);
  $this->display();
}

public function assign_status()
{
  $status = intval(trim($_POST['status']));
  $store_id = $this->store_session['store_id'];

  $store = M('Store');
  $result = D('Store')->where(array('store_id' => $store_id))->data(array('open_autoassign' => $status))->save();
  if ($result) {
    json_return(0, '保存成功！');
  } else {
    json_return(4099, '保存失败，请重试！');
  }
}

    //配置 使用本地化物流
public function local_logistic()
{
  $store = M('Store')->getStore($this->store_session['store_id']);
  $this->assign('store', $store);
  $this->display();
}

public function set_local_logistic()
{
  $status = intval(trim($_POST['status']));
  $store_id = $this->store_session['store_id'];

  $store = M('Store');
  $result = D('Store')->where(array('store_id' => $store_id))->data(array('open_local_logistics' => $status))->save();
  if ($result) {
    json_return(0, '保存成功！');
  } else {
    json_return(4099, '保存失败，请重试！');
  }
}

    //分配门店库存
public function set_stock()
{
  $this->display();
}

public function set_admin()
{
  $store_physical = D('Store_physical')->where(array('store_id'=>$this->store_session['store_id']))->select();
  $this->assign('store_physical',$store_physical);
  $this->display();
}

    // 添加店铺管理员
public function add_admin()
{
  if(IS_POST)
  {
    $user_model = M('User');
    $rbac_model = M('Rbac_action');
    $data_user['nickname'] = $_POST['nickname'];
    $data_user['phone'] = $_POST['phone'];
	$data_user['group'] = $_POST['group'];
    $data_user['password'] = md5($_POST['password']);
            $data_user['drp_store_id'] = $this->store_session['store_id']; //用户所属店铺id
            $data_user['item_store_id'] = $_POST['item_store']; //用户管理门店id
            $data_user['type'] = 1; //管理员类型 0 店铺总管理员 1 门店管理员
           if($_POST['group']==2){
		   
		   $data_meal['meal'] = array('table','edit','order');
		   
		   }else{
            $data_goods['goods'] = array('index','stockout','soldout','category','product_comment','store_comment','create','edit','del_product','checkoutProduct','goods_category_add','goods_category_edit','goods_category_delete','edit_group','save_qrcode_activity','get_qrcode_activity','del_qrcode_activity','del_comment','set_comment_status');
            $data_order['order'] = array('dashboard','all','selffetch','codpay','order_return','order_rights','star','activity','add','create','orderprint','check','fx_bill_check','ws_bill_check','order_checkout_csv','save_bak','add_star','cancel_status','package_product','complate_status','selffetch_status','return_save','return_over');
            $data_trade['trade'] = array('delivery','income');
			
			$data_events['events'] =array('list','edit','order');
      		$data_meal['meal'] = array('table','edit','order');
			}
			
            if ($user_model->checkUser(array('phone' => $data_user['phone']))) {
             json_return(3,'此手机号已经注册了');
           }

           $user = $user_model->add_user($data_user);

           if($user['err_code'] == 0){
            if(count($data_goods['goods'])>0)
            {
              foreach($data_goods['goods'] as $val)
              {
                $data_goods['uid'] = $user['err_msg']['uid'];
                $data_goods['goods_control'] = 'goods';
                $data_goods['goods_action'] = $val;
                $rbac_good = $rbac_model->add_rbac_goods($data_goods);
              }
            }
            if(count($data_order['order'])>0)
            {
              foreach($data_order['order'] as $value)
              {
                $data_order['uid'] = $user['err_msg']['uid'];
                $data_order['order_control'] = 'order';
                $data_order['order_action'] = $value;
                $rbac_orders = $rbac_model->add_rbac_order($data_order);
              }
            }
            if(count($data_trade['trade'])>0)
            {
              foreach($data_trade['trade'] as $value)
              {
                $data_trade['uid'] = $user['err_msg']['uid'];
                $data_trade['trade_control'] = 'trade';
                $data_trade['trade_action'] = $value;
                $rbac_trades = $rbac_model->add_rbac_trade($data_trade);
              }
            }
			
			// yfz@20160818
			if(count($data_events['events'])>0)
            {
              foreach($data_events['events'] as $value)
              {
                $data_events['uid'] =   $user['err_msg']['uid'];
                $data_events['events_control'] = 'events';
                $data_events['events_action'] = $value;
                $rbac_events = $rbac_model->add_rbac_events($data_events);
              }
            }
			
			if(count($data_meal['meal'])>0)
            {
              foreach($data_meal['meal'] as $value)
              {
                $data_meal['uid'] =   $user['err_msg']['uid'];
                $data_meal['meal_control'] = 'meal';
                $data_meal['meal_action'] = $value;
                $rbac_meal = $rbac_model->add_rbac_meal($data_meal);
              }
            }
			
            json_return(0,'添加成功');
          }else{
            json_return(1,'添加失败');
          }
        }

      }

    //店铺管理员列表
      private function _admin_list()
      {
      if($_SESSION['user']['group']>0){
	        die('您没有操作权限！');
	    }

        $store_admin_list = D('User')->where(array(
          'drp_store_id'=>$this->store_session['store_id'],
          'type' => 1
          ))->select();

        foreach($store_admin_list as $admin)
        {
          $store_physical_name[$admin['uid']] = D('Store_physical')->where(array('pigcms_id'=>$admin['item_store_id']))->find();
        }

        $this->assign('store_admin_list',$store_admin_list);
        $this->assign('store_physical_name',$store_physical_name);
      }

      private function _admin_add()
      {
        $store_physical = D('Store_physical')->where(array('store_id'=>$this->store_session['store_id']))->select();
        $this->assign('store_physical',$store_physical);
      }

      private function _admin_edit()
      {
        $uid = $_REQUEST['uid'];
		
        $goodsMethod = D('Rbac_action')->where(array(
          'uid'=>$uid,
          ))->select();

        $userInfo= D('User')->where(array(
          'uid'=>$uid,
          ))->find();

        $methodList = array();
        foreach($goodsMethod as $method)
        {
          $methodList[$method['controller_id']][] = $method['action_id'];
        }

        $store_physical_name = D('Store_physical')->where(array('pigcms_id'=>$userInfo['item_store_id']))->find();
        $store_physical = D('Store_physical')->where(array('store_id'=>$this->store_session['store_id']))->select();
        $this->assign('store_physical',$store_physical);
        $this->assign('userInfo',$userInfo);
        $this->assign('store_physical_name',$store_physical_name);
        $this->assign('methodList',$methodList);
      }
      public function edit_admin()
      {
        if(IS_POST)
        {
          $user_model = M('User');
          $rbac_model = M('Rbac_action');
          $data_user['uid'] = $_POST['uid'];
          $data_user['type'] = 1;
          $data_user['nickname'] = $_POST['nickname'];
          $data_user['phone'] = $_POST['phone'];
          $data_user['group'] = $_POST['group'];
            $data_user['drp_store_id'] = $this->store_session['store_id']; //用户所属店铺id
            $data_user['item_store_id'] = $_POST['item_store']; //用户管理门店id
            $data_user['type'] = 1; //管理员类型 0 店铺总管理员 1 门店管理员

            $data_goods['goods'] = $_POST['goods'];
            $data_order['order'] = $_POST['order'];
            $data_trade['trade'] = $_POST['trade'];
			// yfz@20160818
            $data_events['events'] = $_POST['events'];
      			$data_meal['meal'] = $_POST['meal'];
            // 去重
            $whereQ = "`phone` = ".$data_user['phone']." AND `uid` != ".$data_user['uid'];
            if (D('User')->where($whereQ)->find()) {
             json_return(3, '此手机号已经注册了');
           }

           $user = $user_model->edit_user($data_user);

           if($user['err_code'] == 0){
            if(count($data_goods['goods'])>0)
            {
              $goods_condition['uid'] =  $data_user['uid'];
              $goods_condition['controller_id'] = $_POST['goods_control'];
              $id = $rbac_model->delete_action($goods_condition);
              foreach($data_goods['goods'] as $val)
              {
                $data_goods['uid'] =  $data_user['uid'];
                $data_goods['goods_control'] = $_POST['goods_control'];
                $data_goods['goods_action'] = $val;
                $rbac_good = $rbac_model->add_rbac_goods($data_goods);
              }
            }
            if(count($data_order['order'])>0)
            {
              $order_condition['uid'] =  $data_user['uid'];
              $order_condition['controller_id'] = $_POST['order_control'];
              $id = $rbac_model->delete_action($order_condition);
              foreach($data_order['order'] as $value)
              {
                $data_order['uid'] =  $data_user['uid'];
                $data_order['order_control'] = $_POST['order_control'];
                $data_order['order_action'] = $value;
                $rbac_orders = $rbac_model->add_rbac_order($data_order);
              }
            }
            if(count($data_trade['trade'])>0)
            {
              $trade_condition['uid'] =  $data_user['uid'];
              $trade_condition['controller_id'] = $_POST['trade_control'];
              $id = $rbac_model->delete_action($trade_condition);
              foreach($data_trade['trade'] as $value)
              {
                $data_trade['uid'] =  $data_user['uid'];
                $data_trade['trade_control'] = $_POST['trade_control'];
                $data_trade['trade_action'] = $value;
                $rbac_trades = $rbac_model->add_rbac_trade($data_trade);
              }
            }
			// yfz@20160818
			if(count($data_events['events'])>0)
            {
              $events_condition['uid'] =  $data_user['uid'];
              $events_condition['controller_id'] = $_POST['events_control'];
              $id = $rbac_model->delete_action($events_condition);
              foreach($data_events['events'] as $value)
              {
                $data_events['uid'] =  $data_user['uid'];
                $data_events['events_control'] = $_POST['events_control'];
                $data_events['events_action'] = $value;
                $rbac_events = $rbac_model->add_rbac_events($data_events);
              }
            }
			
			if(count($data_meal['meal'])>0)
            {
              $meal_condition['uid'] =  $data_user['uid'];
              $meal_condition['controller_id'] = $_POST['meal_control'];
              $id = $rbac_model->delete_action($meal_condition);
              foreach($data_meal['meal'] as $value)
              {
                $data_meal['uid'] =  $data_user['uid'];
                $data_meal['meal_control'] = $_POST['meal_control'];
                $data_meal['meal_action'] = $value;
                $rbac_meal = $rbac_model->add_rbac_meal($data_meal);
              }
            }
            json_return(0,'修改成功');
          }else{
            json_return(1,'修改失败');
          }
        }
      }

      public function del_admin()
      {
        if(IS_POST){
          $user = D('User');
          $condition_store_admin['uid'] = $_POST['uid'];
          $condition_store_admin['type']  = 1;
          if($user->where($condition_store_admin)->delete()){
                //D('Store')->where(array('store_id'=>$this->store_session['store_id']))->setDec('physical_count');
            json_return(0,'删除成功');
          }else{
            json_return(1,'删除失败');
          }
        }else{
          json_return(1,'非法访问！');
        }
      }


    }