<?php
/**
 * 订单控制器
 */
class storetongji_controller extends base_controller{

public function yuyue_order()
	{ 
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
		$physical_id = intval($_REQUEST['physical_id']);
		$tableid = intval($_REQUEST['tableid']);
		$stime = $_REQUEST['stime'];
		$etime = $_REQUEST['etime'];
		$status = intval($_REQUEST['status']);
		$store_id = $this->store_id;
		if(empty($physical_id)){
            $physical_list = D('Store_physical')->where(array('store_id'=>$this->store_id))->order('`pigcms_id` ASC')->find();
            $physical_id=$physical_list['pigcms_id'];
            $physical_name=$physical_list['name'];
        }else{
            $physical_list = D('Store_physical')->where(array('store_id'=>$this->store_id,'pigcms_id'=>$physical_id))->order('`pigcms_id` ASC')->find();
            $physical_name=$physical_list['name'];
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

	     //  $results['list']=$list;
	      // $results['data']['count']=$count;
		   $results['data']['sevendays']=$sevendays;
		   $results['data']['wait']=$wait;
		   $results['data']['waitmoney']=$waitmoney;
		   $results['data']['today']=$today;
	
	
	

		$database = D('Meal_order');
		$where['store_uid'] = $store_id;


		if($physical_id){
			$where['physical_id'] = $physical_id;

		}

		$list = array();
         $waitmoney = array();
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

		$results['tongji']=$list;
	
	
	
	
		exit(json_encode($results));	
	}

	


/*public function seven_yuyue()
	{ 
	
	    $results = array('result'=>'0','data'=>array(),'msg'=>'');
		$physical_id = intval($_REQUEST['physical_id']);
		$starttime = $_REQUEST['stime'];
		$endtime = $_REQUEST['etime'];
		$store_id = $this->store_id;
	
		if(empty($physical_id)){
            $physical_list = D('Store_physical')->where(array('store_id'=>$this->store_id))->order('`pigcms_id` ASC')->find();
            $physical_id=$physical_list['pigcms_id'];
            $physical_name=$physical_list['name'];
        }else{
            $physical_list = D('Store_physical')->where(array('store_id'=>$this->store_id,'pigcms_id'=>$physical_id))->order('`pigcms_id` ASC')->find();
            $physical_name=$physical_list['name'];
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

		$results['data']=$list;
		exit(json_encode($results));	
	}*/



public function store_cz($cz_id)
	{
		$canz = D('pigcms_meal_cz');

		$canzn = $canz->where(array('cz_id'=>$cz_id))->find();
		$baoxiang =$canzn['name'];
		return $baoxiang;
	}	






}
