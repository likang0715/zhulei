<?php
/**
 * 订单控制器
 */
class storeadmin_controller extends base_controller{

	
public function index(){ 
        $results = array('result'=>'0','data'=>array(),'msg'=>'');
        $physical_id = intval($_REQUEST['physical_id']);
        $store_id = $this->store_id;


       if($_SESSION['user']['group']>0){
	        die('您没有操作权限！');
	    }

        $store_admin_list = D('User')->where(array(
          'drp_store_id'=>$store_id,
          'type' => 1
          ))->select();
		  
         $list = array();
        foreach($store_admin_list as $key=>$r)
        {
          $physical = D('Store_physical')->where(array('pigcms_id'=>$r['item_store_id']))->find();
		  
		  $list[$key]['userid'] = $r['uid'];
		  $list[$key]['avatar'] = $r['avatar']?$r['avatar']:'';
		  $list[$key]['nickname'] = $r['nickname'];
		  $list[$key]['phone'] = $r['phone'];
		  $list[$key]['physicalname'] = $physical['name'];
		  $list[$key]['item_store_id'] = $r['item_store_id'];
		  $list[$key]['addtime'] = date('Y-m-d H:i:s',$r['reg_time']);
		
		  $list[$key]['group'] = $r['group'];
		 
        }

      
	  $results['data']=$list;
       exit(json_encode($results));    
   } 






public function add()
	{ 

        $results = array('result'=>'0','data'=>array(),'msg'=>'');
        $physical_id = intval($_REQUEST['physical_id']);
        $store_id = $this->store_id;
		
			$user_model = M('User');
			$rbac_model = M('Rbac_action');
			$data_user['nickname'] = $_REQUEST['nickname'];
			$data_user['phone'] = $_REQUEST['phone'];
			$data_user['group'] = $_REQUEST['group'];
			$data_user['password'] = md5($_REQUEST['password']);
            $data_user['drp_store_id'] = $store_id; //用户所属店铺id
            $data_user['item_store_id'] = $_REQUEST['item_store']; //用户管理门店id
            $data_user['type'] = 1; //管理员类型 0 店铺总管理员 1 门店管理员
			
			
			if (empty($data_user['phone'])) {
            
			 $results['result']='1';
		     $results['msg']='手机号不能为空';
		     exit(json_encode($results)); 
           }
			
			if (empty($data_user['item_store_id'])) {
            
			 $results['result']='1';
		     $results['msg']='管理门店不能为空';
		     exit(json_encode($results)); 
           }
			if (empty($data_user['nickname'])) {
            
			 $results['result']='1';
		     $results['msg']='昵称不能为空';
		     exit(json_encode($results)); 
           }
			if (empty($data_user['password'])) {
            
			 $results['result']='1';
		     $results['msg']='密码不能为空';
		     exit(json_encode($results)); 
           }
			
           if($_POST['group']==2){
		   
		   $data_meal['meal'] = array('table','edit','order');
		   
		   }else{
            $data_goods['goods'] = array('index','stockout','soldout','category','product_comment','store_comment','create','edit','del_product','checkoutProduct','goods_category_add','goods_category_edit','goods_category_delete','edit_group','save_qrcode_activity','get_qrcode_activity','del_qrcode_activity','del_comment','set_comment_status');
            $data_order['order'] = array('dashboard','all','selffetch','codpay','order_return','order_rights','star','activity','add','create','orderprint','check','fx_bill_check','ws_bill_check','order_checkout_csv','save_bak','add_star','cancel_status','package_product','complate_status','selffetch_status','return_save','return_over');
            $data_trade['trade'] = array('delivery','income');
			
			$data_events['events'] =array('list','edit','order');
      		$data_meal['meal'] = array('table','edit','order');
			}
			
            if ($user_model->checkUser(array('phone' => $_REQUEST['phone']))) {
            
			 $results['result']='1';
		     $results['msg']='此手机号已经注册了';
		     exit(json_encode($results)); 
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
		  exit(json_encode($results));   
          }else{
	   	    $results['result']='1';
	    	$results['msg']='添加失败';
			  exit(json_encode($results));   
	       }
	 
   }


public function edit()
	{ 
        $results = array('result'=>'0','data'=>array(),'msg'=>'');
        $physical_id = intval($_REQUEST['physical_id']);
        $store_id = $this->store_id;

          $user_model = M('User');
          $rbac_model = M('Rbac_action');
          $data_user['uid'] = $_REQUEST['userid'];
          $data_user['type'] = 1;
          $data_user['nickname'] = $_REQUEST['nickname'];
          $data_user['phone'] = $_REQUEST['phone'];
		  $data_user['group'] = $_REQUEST['group'];

            $data_user['drp_store_id'] = $store_id; //用户所属店铺id
            $data_user['item_store_id'] = $_REQUEST['item_store']; //用户管理门店id
            $data_user['type'] = 1; //管理员类型 0 店铺总管理员 1 门店管理员

            // 去重
            $whereQ = "`phone` = ".$data_user['phone']." AND `uid` != ".$data_user['uid'];
            if (D('User')->where($whereQ)->find()) {
            $results['result']='1';
		     $results['msg']='此手机号已经注册了';
		     exit(json_encode($results));
           }

           $user = $user_model->edit_user($data_user);
		

           if($user['err_code'] != 0){
	   	    $results['result']='1';
	    	$results['msg']='添加失败';
	       }
	   exit(json_encode($results));   
   }


  public function del_admin()
      {
      $results = array('result'=>'0','data'=>array(),'msg'=>'');
          $user = D('User');
          $condition_store_admin['uid'] = $_REQUEST['userid'];
          $condition_store_admin['type']  = 1;
          if($user->where($condition_store_admin)->delete()){
		      exit(json_encode($results));
		  }else{
            $results['result']='1';
	    	$results['msg']='删除失败';
          }
   
      }



}
