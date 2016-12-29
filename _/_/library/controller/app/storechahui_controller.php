<?php
/**
 * 订单控制器
 */
class storechahui_controller extends base_controller{

	 /**
     * 茶座列表
     */
    public function chahui_list() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
       
        $keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';
     	$page = max(1, $_REQUEST['page']);
		$limit = max(1, $_REQUEST['size']);
		
		
        $where = array();
        $where['store_id'] = $this->store_id;
       
        if ($keyword) {
            $where['name'] = array('like', '%' . $keyword . '%');
        }
       

         $time=time();

        $count = D('Chahui')->where($where)->count('pigcms_id');
        $pages=ceil($count / $limit);
		$offset=($page - 1) * $limit;
		$lists = D('Chahui')->where($where)->order('`pigcms_id` DESC')->limit($offset.','.$limit)->select();
		$chahui=array();
		 foreach($lists as $key=>$r){
		$chahui[$key]['pigcms_id']=$r['pigcms_id'];
		$chahui[$key]['name']=$r['name'];
		$chahui[$key]['address']=$r['address'];
		if($r['price']>0){
		$chahui[$key]['price']=$r['price'];
		}else{
		$chahui[$key]['price']='免费';
		}
		$chahui[$key]['renshu']=$r['renshu'];
		$chahui[$key]['images']=getAttachmentUrl($r['images']);
		$chahui[$key]['sttime']=date('m/d H:i',$r['sttime']);
		$chahui[$key]['endtime']=date('m/d H:i',$r['endtime']);
		if($r['sttime'] >$time){
		$chahui[$key]['status']='1';
	
		if($bmcount>=$r['renshu']){
		$chahui[$key]['status']='2';
		}
		
		}else{
		$chahui[$key]['status']='3';
		}
		$dscount = D('Chahui_bm')->where(array('store_id' => $this->store_id,'cid' =>$r['pigcms_id'],'status' =>'1'))->count('id');
		$bmcount = D('Chahui_bm')->where(array('store_id' => $this->store_id,'cid' =>$r['pigcms_id']))->count('id');
		$chahui[$key]['bm']=$bmcount;
		$chahui[$key]['ds']=$dscount;
				}
	
		$results['page_count']=(string)$pages;
		$results['page_index']=(string)$page;
		$results['data']=$chahui;
		exit(json_encode($results));
		
    }

    /**
     *  茶会订单
     */
    public function chahui_show() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
        $database = D('Chahui');
        $page = max(1, $_REQUEST['page']);
		$limit = max(1, $_REQUEST['size']);
		$status = $_REQUEST['status'];
		$pigcms_id=$_REQUEST['pigcms_id'];
	    if (empty($pigcms_id)) {
		    $results['result']='1';
			$results['msg']='pigcms_id不能为空';
			exit(json_encode($results));
		}	
        $where = array();
        $where['store_id'] = $this->store_id;
        $where['pigcms_id'] = $pigcms_id;
      
	 
      

        $r = $database->where($where)->find();
		
        $chahui['name']=$r['name'];
		$chahui['address']=$r['address'];
		if($r['price']>0){
		$chahui['price']=$r['price'];
		}else{
		$chahui['price']='免费';
		}
		$chahui['renshu']=$r['renshu'];
		$chahui['images']=getAttachmentUrl($r['images']);
		$chahui['sttime']=date('m/d H:i',$r['sttime']);
		$chahui['endtime']=date('m/d H:i',$r['endtime']);
		
		$order="store_uid = '$this->store_id' and (tableid = '$cz_id' or tablename like '%$table[name]%')";
		if($status){
		$order .= " and status='$status'";
		}
		$count = D('Chahui_bm')->where(array('store_id' => $this->store_id,'cid' =>$r['pigcms_id']))->count('id');
		$chahui['bm']=$count;
		
		$order = array();
    	$order['store_id'] = $this->store_id;
		$order['cid'] = $pigcms_id;
		if (!empty($status)) {
		 $order['status'] = $status;
		}
		
		$count = D('Chahui_bm')->where($order)->count('id');

        $pages=ceil($count / $limit);
		$offset=($page - 1) * $limit;
		
		$orderList = D('Chahui_bm')->where($order)->order('id desc')->limit($offset . ', ' . $limit)->select();
		$lists=array();
		$statusname=array('','待审核','未通过','已通过');
		foreach ($orderList as $key => $value)
        {
           $lists[$key]['id']=$value['id'];
           $lists[$key]['name']=$value['name'];
		   $lists[$key]['dateline']=date('m-d H:i:s',$value['addtime']);
		   $lists[$key]['mobile']=$value['mobile'];
		   $lists[$key]['status']=$statusname[$value['status']];
        }
	    $results['chahui']=$chahui;
		$results['page_count']=(string)$pages;
		$results['page_index']=(string)$page;
		$results['data']=$lists;
		exit(json_encode($results));
    }

   /**
     *  茶会订单
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
		$order['dateline']=date('Y-m-d H:i:s',$order['dateline']);
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


	
	public function bm_edit() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
		$database_store_physical = D('Chahui_bm');
		$id = $_REQUEST['id'];
		$data['status'] = $_REQUEST['status'];
		$store_id  = $this->store_id;
		$where=" id='$id' and store_id='$store_id'";
		if(empty($_REQUEST['id'])){
	        $results['result']='1';
			$results['msg']='id不能为空';
			exit(json_encode($results));
			}
	
		if(empty($_REQUEST['status'])){
	        $results['result']='1';
			$results['msg']='status不能为空';
			exit(json_encode($results));
			}
		$database_store_physical->where($where)->data($data)->save();


		$order = D('Chahui_bm')->where($where)->find();


		if($_REQUEST['status']==2){
			$id=13;
		}elseif($_REQUEST['status']==3){
			$id=12;
		}

		$now_store = D('Store')->where(array('store_id' => $this->store_id))->find();
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
					'uid' 	=> $this->uid,
					'store_id' 	=> $order['store_id'],
					'price' 	=> 10,
					'mobile' 	=> $mobile,
					'text'		=> $str,
					'status'	=> $return,
					'type'	=> $id,
					'time' => time(),
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

}
