<?php
/**
 * 订单控制器
 */
class storeyuding_controller extends base_controller{

	

	 /**
     * 茶座列表
     */
    public function table_list() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
         $database = D('Meal_cz');
        
        $keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';
     	$page = max(1, $_REQUEST['page']);
		$limit = max(1, $_REQUEST['size']);
		$cat_id=$_REQUEST['cat_id'];
	    $physical_id=$_REQUEST['physical_id'];
		
        $where = array();
        $where['seller_id'] = $this->store_id;
       
        if ($keyword) {
            $where['name'] = array('like', '%' . $keyword . '%');
        }
        if ($physical_id) {
            $where['physical_id'] = $physical_id;
        }
		if ($cat_id) {
            $where['wz_id'] = $cat_id;
        }

      

        $count = $database->where($where)->count('physical_id');
        $pages=ceil($count / $limit);
		$offset=($page - 1) * $limit;
		$lists = $database->where($where)->order('`cz_id` DESC')->limit($offset.','.$limit)->select();
		$table=array();
		 foreach($lists as $key=>$r){
		$table[$key]['cz_id']=$r['cz_id'];
	    $table[$key]['name']=$r['name'];
		$table[$key]['price']=$r['price'];
		$table[$key]['zno']=$r['zno'];
		$table[$key]['images']=explode(',',$r['images']);
		$table[$key]['status']=$r['status'];
				}
	
		$results['page_count']=(string)$pages;
		$results['page_index']=(string)$page;
		$results['data']=$table;
		exit(json_encode($results));
		
    }

    /**
     *  茶桌订单
     */
    public function table_show() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
        $database = D('Meal_cz');
        $page = max(1, $_REQUEST['page']);
		$limit = max(1, $_REQUEST['size']);
		$status = $_REQUEST['status'];
		$cz_id=$_REQUEST['cz_id'];
	    if (empty($cz_id)) {
		    $results['result']='1';
			$results['msg']='cz_id不能为空';
			exit(json_encode($results));
		}	
        $where = array();
        $where['seller_id'] = $this->store_id;
        $where['cz_id'] = $cz_id;
      
      

        $table = $database->where($where)->find();
		 $category = D('Meal_category')->where(array('cat_id'=>$table['wz_id']))->find();
         $tables['cat_name'] = $category['cat_name'];
		$tables['name']=$table['name'];
		$tables['price']=$table['price'];
		$tables['zno']=$table['zno'];
		$tables['status']=$table['status'];
		$tables['images']=explode(',',$table['images']);
		
		$order="store_uid = '$this->store_id' and (tableid = '$cz_id' or tablename like '%$table[name]%')";
		if($status){
		$order .= " and status='$status'";
		}
		$count = D('Meal_order')->where($order)->count('order_id');
        $pages=ceil($count / $limit);
		$offset=($page - 1) * $limit;
		$orderList = D('Meal_order')->where($order)->order('order_id desc')->limit($offset . ', ' . $limit)->select();
		$lists=array();
		$statusname=array('','待审核','待消费','已完成','已关闭');
		foreach ($orderList as $key => $value)
        {
         	$lists[$key]['order_id']=$value['order_id'];
			$lists[$key]['ordersn']=$value['orderid'];
           $lists[$key]['name']=$value['name'];
		   $lists[$key]['mobile']=$value['phone'];
		   $lists[$key]['dd_time']=date('m-d H:i',$value['dd_time']);
		   $lists[$key]['sc']=$value['sc'] ? $value['sc']:'';
		   $lists[$key]['tablename']=$value['tablename'];
		    $lists[$key]['status']=$statusname[$value['status']];
        }
	    $results['table']=$tables;
		$results['page_count']=(string)$pages;
		$results['page_index']=(string)$page;
		$results['data']=$lists;
		exit(json_encode($results));
    }


 public function table_order() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
       
	    $database = D('Meal_cz');
        $page = max(1, $_REQUEST['page']);
		$limit = max(5, $_REQUEST['size']);
		$status = $_REQUEST['status'];
	
	
	    $physical_id = intval($_REQUEST['physical_id']);
	
		$store_id = $this->store_id;
		if(empty($physical_id)){
            $physical_list = D('Store_physical')->where(array('store_id'=>$this->store_id))->order('`pigcms_id` ASC')->find();
            $physical_id=$physical_list['pigcms_id'];
            $physical_name=$physical_list['name'];
        }else{
            $physical_list = D('Store_physical')->where(array('store_id'=>$this->store_id,'pigcms_id'=>$physical_id))->order('`pigcms_id` ASC')->find();
            $physical_name=$physical_list['name'];
        }
	
		
		$order="store_uid = '$this->store_id' and physical_id = '$physical_id'";
		if($status){
		$order .= " and status='$status'";
		}
	
		$count = D('Meal_order')->where($order)->count('order_id');
        $pages=ceil($count / $limit);
		$offset=($page - 1) * $limit;
		$orderList = D('Meal_order')->where($order)->order('order_id desc')->limit($offset . ', ' . $limit)->select();
		$lists=array();
		$statusname=array('','待审核','待消费','已完成','已关闭');
		foreach ($orderList as $key => $value)
        {
         	$lists[$key]['order_id']=$value['order_id'];
			$lists[$key]['ordersn']=$value['orderid'];
           $lists[$key]['name']=$value['name'];
		   $lists[$key]['mobile']=$value['phone'];
		   $lists[$key]['dd_time']=!empty($value['dd_time']) ? date('m-d H:i',$value['dd_time']):'';
		   $lists[$key]['sc']=$value['sc'] ? $value['sc']:'';
		   $lists[$key]['tablename']=$value['tablename'];
		   if($value['tableid']){
		    $where = array();
          $where['seller_id'] = $this->store_id;
           $where['cz_id'] = $value['tableid'];
        $table = $database->where($where)->find();
		$pic = explode(',',$table['images']);
		    $lists[$key]['logo']=$pic['0'];
		   }else{
		    $lists[$key]['logo']='';
		   }
		   $lists[$key]['status']=$statusname[$value['status']];
        }
	    $results['table']=$tables;
		$results['page_count']=(string)$pages;
		$results['page_index']=(string)$page;
		$results['data']=$lists;
		exit(json_encode($results));
    }




   /**
     *  茶桌订单
     */
    public function order_show() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
        $database = D('Meal_order');
        $page = max(1, $_REQUEST['page']);
		$limit = max(1, $_REQUEST['size']);
		$status = $_REQUEST['status'];
		$order_id=$_REQUEST['order_id'];
	    if (empty($order_id)) {
		    $results['result']='1';
			$results['msg']='order_id不能为空';
			exit(json_encode($results));
		}	
		$statusname=array('','待审核','待消费','已完成','已关闭');
        $where = array();
        $where['store_uid'] = $this->store_id;
        $where['order_id'] = $order_id;
      
      

        $order = $database->where($where)->find();
		$order['dateline']=date('m-d H:i:s',$order['dateline']);
		$order['dd_time']=!empty($order['dd_time']) ? date('m-d H:i',$order['dd_time']):'';
		$order['status']=$statusname[$order['status']];
		if(empty($order['food'])){
		   $order['food']='';
		   }
		   if(empty($order['num'])){
		   $order['num']='';
		   } 
		 if(empty($order['bz'])){
		   $order['bz']='';
		   }
	     unset($order['uid']); 
		 unset($order['physical_id']); 
		 unset($order['store_uid']);
		 unset($order['tableid']);
		 unset($order['use_time']);
		$results['data']=$order;
		exit(json_encode($results));
    }


	
	public function yuding_edit() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
		$database_store_physical = D('Meal_order');
		$id = $_REQUEST['order_id'];
		$store_id  = $this->store_id;
		$where=" order_id='$id' and store_uid='$store_id'";
		
		$data['use_time'] = $_SERVER['REQUEST_TIME'];
		$data['bz'] = $_REQUEST['bz'];
		$data['status'] = $_REQUEST['status'];
		$database_store_physical->where($where)->data($data)->save();


		$order = D('Meal_order')->where($where)->find();


		if($_REQUEST['status']==2){
			$id=15;
		}elseif($_REQUEST['status']==4){
			$id=16;
		}

		$now_store = D('Store')->where(array('store_id' => $this->store_id))->find();
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
					if(empty($tel)) {
						$tel=$now_store['tel'];
					}
					$times=$times=date('m-d H:i',$order['dd_time']); 

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
							'uid' 	=> $this->uid,
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
         
		$results['msg']='审核完成';
		exit(json_encode($results)); 
		 
	}

	
	// 茶座分组
	public function group() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
	
        $physical_id=$_REQUEST['physical_id'];
		$category=D('Meal_category');
		$cat_list = $category->where(array('store_id'=>$this->store_id,'physical_id'=>$physical_id))->order('cat_sort desc')->select();
		
			$results['data']= $cat_list;
			exit(json_encode($results));
       
         
	}
	
	
	
	
	
	public function order_edit(){
         $results = array('result'=>'0','data'=>array(),'msg'=>'');
	      if(empty($_REQUEST['order_id'])){
	        $results['result']='1';
			$results['msg']='order_id不能为空';
			exit(json_encode($results));
			}
			$database_category = D('Meal_order');
			$condition_category['order_id'] = $_REQUEST['order_id'];

			if($_REQUEST['tablename']){
				$data_category['tablename'] = $_REQUEST['tablename'];
			}
			
			if($_REQUEST['tableid']){
				$data_category['tableid'] = $_REQUEST['tableid'];
			}
			$data_category['use_time'] = time();
			if($_REQUEST['bz']){
			$data_category['bz'] = $_REQUEST['bz'];
			}
			if($_REQUEST['status']){
			$data_category['status'] = $_REQUEST['status'];
			}
			$database_category->where($condition_category)->data($data_category)->save();
			if($_POST['status']==2){
				$id=15;
			}elseif($_POST['status']==4){
				$id=16;
			}
			if($id){
				$dcz = D('pigcms_meal_order');
				$cz['order_id'] = $_REQUEST['order_id'];
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
						if(empty($tel)) {
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

	exit(json_encode($results));
	}
	
	
	
	
	
	
	
	
	public function order_cz() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
         $database = D('Meal_cz');
        
        $order_id=$_REQUEST['order_id'];
	    if(empty($_REQUEST['order_id'])){
	        $results['result']='1';
			$results['msg']='order_id不能为空';
			exit(json_encode($results));
			}
        $where = array();
        $where['store_uid'] = $this->store_id;
        $where['order_id'] = $order_id;
        $order = D('Meal_order')->where($where)->find();
	    $physical_id=$order['physical_id'];
	    $where = array();
        $where['seller_id'] = $this->store_id;
        $where['physical_id'] = $physical_id;
		
		
		$lists = D('Meal_cz')->where($where)->order('`cz_id` DESC')->select();
		$table=array();
		 foreach($lists as $key=>$r){
		$table[$key]['tableid']=$r['cz_id'];
	    $table[$key]['tablename']=$r['name'];
				}
	
		$results['data']=$table;
		exit(json_encode($results));
		
    }
	
	
	
	
	
	
	
	

}
