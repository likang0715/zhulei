<?php
/**
 * 订单控制器
 */
class storeindex_controller extends base_controller{

	
public function index(){ 
        $results = array('result'=>'0','data'=>array(),'msg'=>'');
        $physical_id = intval($_REQUEST['physical_id']);
        $store_id = $this->store_id;


        $time = time();
      if($physical_id){
        $physical =  " AND physical_id = '$physical_id'";
            }
        $send=intval(D('Order')->where("store_id = '$store_id' AND status = 2")->count('order_id'));

        $refund=intval(D('Return')->where("store_id = '$store_id' AND status = 1")->count('id'));

        $seat=intval(D('Meal_order')->where("store_uid = '$store_id' AND status = 1 AND dd_time >= '$time' ".$physical)->count('order_id'));

        $meeting=intval(D('Chahui_bm')->where("store_id = '$store_id' AND status = 1")->count('order_id'));
       
	   
	   
	   
	      $order = M('Order');
		  $financial_record = M('Financial_record');
          $days = array();
        for ($i = 6; $i >= 0; $i--) {
            $day = date("Y-m-d", strtotime('-' . $i . 'day'));
            $days[] = $day;
        }
		
        //7天下单笔数
        $where = array();
        //开始时间
        $start_time = strtotime($days[0] . ' 00:00:00');
        //结束时间
        $stop_time = strtotime($days[count($days) - 1] . '23:59:59');
        $where['store_id'] = $store_id;
		
        $where['status'] = array('>', 0);
        $where['activity_data'] = array('is_null', "is_null");
        $where['_string'] = "add_time >= '" . $start_time . "' AND add_time <= '" . $stop_time . "'";
        $week_orders = $order->getOrderCount($where); 



       

       //7天收入
        $where = array();
        //开始时间
        $start_time = strtotime($days[0] . ' 00:00:00');
        //结束时间
        $stop_time = strtotime($days[count($days) - 1] . '23:59:59');
        $where['store_id'] = $store_id;
        $where['_string'] = "add_time >= '" . $start_time . "' AND add_time <= '" . $stop_time . "'";
        $days_7_income = $financial_record->getTotal($where);
        $days_7_income = ($days_7_income > 0) ? $days_7_income : 0;
        $days_7_income = number_format($days_7_income, 2, '.', '');

           $where = array();
		   $where['store_uid'] = $store_id;
          if($physical_id){
		$where['physical_id'] = $physical_id;
            }
			
		$time =strtotime(date('Y-m-d'));
			
		$where['dateline'] = array('>=', $time);
       $todayseat=intval(D('Meal_order')->where($where)->count('order_id'));



        $store = D('Store')->where(array('store_id'=>$this->store_id))->find();
	
	     $pstore['logo']=getAttachmentUrl($store['logo']);
	     $pstore['name']=$store['name'];
	
		   $results['data']['send']=(string)$send;
		   $results['data']['refund']=(string)$refund;
		   $results['data']['seat']=(string)$seat;
		   $results['data']['meeting']=(string)$meeting;
		   $results['data']['week']=(string)$week_orders;
		   $results['data']['weekincome']=(string)$days_7_income;
           $results['data']['todayseat']=(string)$todayseat;
		   $results['store']=$pstore;
		   
		   $ad = M('Adver')->get_adver_by_key('app_seller',1);
	    foreach ($ad as &$adver) {
	
			unset($adver['id']);
			unset($adver['store_id']);
			unset($adver['bg_color']);
			unset($adver['cat_id']);
			unset($adver['status']);
			unset($adver['last_time']);
			unset($adver['description']);
			unset($adver['sort_order']);
		
		}
		   
		  $results['ad']=$ad; 
		   
       exit(json_encode($results));    
   } 






public function store()
	{ 
        $results = array('result'=>'0','data'=>array(),'msg'=>'');
        $physical_id = intval($_REQUEST['physical_id']);
        $store_id = $this->store_id;


	      $order = M('Order');
		  $financial_record = M('Financial_record');
          $days = array();
        for ($i = 6; $i >= 0; $i--) {
            $day = date("Y-m-d", strtotime('-' . $i . 'day'));
            $days[] = $day;
        }

       

       //7天收入
        $where = array();
        //开始时间
        $start_time = strtotime($days[0] . ' 00:00:00');
        //结束时间
        $stop_time = strtotime($days[count($days) - 1] . '23:59:59');
        $where['store_id'] = $store_id;
        $where['_string'] = "add_time >= '" . $start_time . "' AND add_time <= '" . $stop_time . "'";
        $days_7_income = $financial_record->getTotal($where);
        $days_7_income = ($days_7_income > 0) ? $days_7_income : 0;
        $days_7_income = number_format($days_7_income, 2, '.', '');

           $where = array();
		   $where['store_id'] = $store_id;
          if($physical_id){
		$where['physical_id'] = $physical_id;
            }
			
		$where['dateline'] = array(array('<=',$stop_time),array('>=',$start_time));
  
         $cashier=intval(D('Order_cashier')->where($where)->sum('money'));

        $store = D('Store')->where(array('store_id'=>$this->store_id))->find();
	     $pstore['logo']=getAttachmentUrl($store['logo']);
	     $pstore['name']=$store['name'];
	
           $total=$days_7_income+$cashier;
		   $results['data']['weekincome']=(string)$days_7_income;
           $results['data']['cashier']=(string)$cashier;
		   $results['data']['total']=(string)$total;
		   $results['store']=$pstore;
       exit(json_encode($results));    
   }




public function show()
	{ 
        $results = array('result'=>'0','data'=>array(),'msg'=>'');
        $physical_id = intval($_REQUEST['physical_id']);
        $store_id = $this->store_id;


	 
    $database_store = M('Store');
    import('source.class.area');
	$area_class = new area();
	
    $sale_category = $database_store->getSaleCategory($store_id, $this->uid);
    $store = $database_store->getStoreById($store_id, $this->uid);
	$store_contact = D('Store_contact')->where(array('store_id'=>$store_id))->find();
	$company['name']=$store['name'];
	$company['province'] = $area_class->get_name($store_contact['province']);
	$company['province_code'] = $store_contact['province'];
	$company['city'] = $area_class->get_name($store_contact['city']);
	$company['city_code'] = $store_contact['city'];
	$company['county'] = $area_class->get_name($store_contact['county']);
	$company['county_code'] = $store_contact['county'];
	$company['address']=$store_contact['address'];
	$company['logo']=$store['logo'];
	$company['addtime']=date('Y-m-d',$store['date_added']);
	$company['catname']=$sale_category;
	$company['sale_category_fid']=$store['sale_category_fid'];
	$company['sale_category_id']=$store['sale_category_id'];
	$company['intro']=$store['intro'];
	$company['lxr']=$store['linkman'];
	$company['tel']=$store['tel'];
	$company['qq']=$store['qq'];
    $company['phone1']=$store_contact['phone1']?$store_contact['phone1']:'';
	$company['phone2']=$store_contact['phone2']?$store_contact['phone2']:'';


	 $results['data']=$company;
       exit(json_encode($results));    
   }

public function edit()
	{ 
        $results = array('result'=>'0','data'=>array(),'msg'=>'');
        $store_id = $this->store_id;
		if($_REQUEST['phone1']){
           $data_store_contact['phone1'] = $_REQUEST['phone1'];
		   }
		   if($_REQUEST['phone2']){
           $data_store_contact['phone2'] = $_REQUEST['phone2'];
		   }
		   if($_REQUEST['province']){
           $data_store_contact['province'] = $_REQUEST['province'];
		   }
		   if($_REQUEST['city']){
           $data_store_contact['city'] = $_REQUEST['city'];
		   }
		   if($_REQUEST['county']){
           $data_store_contact['county'] = $_REQUEST['county'];
		   }
		   if($_REQUEST['address']){
           $data_store_contact['address'] = $_REQUEST['address'];
		   }
		   if($_REQUEST['intro']){
           $data_store['intro'] = $_REQUEST['intro'];
		   }
		   if($_REQUEST['logo']){
           $data_store['logo'] = $_REQUEST['logo'];
		   }
		   
		   if($_REQUEST['name']){
           $data_store['name'] = $_REQUEST['name'];
		   }
		   if($_REQUEST['linkman']){
           $data_store['linkman'] = $_REQUEST['linkman'];
		   }
		   if($_REQUEST['tel']){
           $data_store['tel'] = $_REQUEST['tel'];
		   }
		   if($_REQUEST['qq']){
           $data_store['qq'] = $_REQUEST['qq'];
		   }
		
		   if($_REQUEST['sale_category_fid']){
           $data_store['sale_category_fid'] = $_REQUEST['sale_category_fid'];
		   }
		   if($_REQUEST['sale_category_id']){
           $data_store['sale_category_id'] = $_REQUEST['sale_category_id'];
		   }else{
		   $data_store['sale_category_id'] = 0;
		   }
		
		
		
		
		
           $data_store_contact['last_time'] = time();
           
           $database_store_contact = D('Store_contact');
           $condition_store_contact['store_id'] =$store_id;
           if($database_store_contact->where($condition_store_contact)->find()){
		
                // 添加区域修改记录 用于区域管理员关联
		         if($_REQUEST['logo'] || $_REQUEST['intro'] || $_REQUEST['name'] || $_REQUEST['linkman'] || $_REQUEST['tel'] || $_REQUEST['qq'] || $_REQUEST['sale_category_fid'] || $_REQUEST['sale_category_id']){		
		
                   M('Store_contact')->setAreaRelation($condition_store_contact['store_id'], $data_store_contact);
			       }
			}
			
            if($database_store_contact->where($condition_store_contact)->data($data_store_contact)->save()){
			
			D('Store')->where($condition_store_contact)->data($data_store)->save();
			
			}else{
	
			 $results['result']='1';
	    	$results['msg']='添加失败';
	       }
	   exit(json_encode($results));   

}


public function category()
	{ 
        $results = array('result'=>'0','data'=>array(),'msg'=>'');
       
        $store_id = $this->store_id;

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
    shuffle($categories);
	 $results['data']=$categories;
       exit(json_encode($results));    
   }

}
