<?php
/**
 * 订单控制器
 */
class storecashier_controller extends base_controller{

	
public function index(){ 
        $results = array('result'=>'0','data'=>array(),'msg'=>'');
        $physical_id = intval($_REQUEST['physical_id']);

        $store_id = $this->store_id;

         $where = array();
      
        $where['store_id'] = $store_id;
          if($physical_id){
		
       $where['pigcms_id'] = $physical_id;
            }

      $store_physical = D('Store_physical')->where($where)->select();

	  $list=array();
     foreach($store_physical as $key=>$val){
	$list[$key]['physical_id'] = $val['pigcms_id'];
	$list[$key]['name'] = $val['name']; 
	$list[$key]['logo']=getAttachmentUrl($val['images']);
	$list[$key]['address'] = $val['address']; 
	$list[$key]['phone'] = isset($val['phone1']) ? $val['phone1'].'-'.$val['phone2'] : $val['phone2']; 
	$list[$key]['qrcode'] = $this->config['wap_site_url']."/shoukuan.php?store_id=".$store_id."&pid=".$val['pigcms_id']; 
	 }
	 
	 
	 
	 $results['data']=$list;
	 
       exit(json_encode($results));    
   } 






public function cashier_list()
	{
	    $results = array('result'=>'0','data'=>array(),'msg'=>'');
        $physical_id = intval($_REQUEST['physical_id']);

        $store_id = $this->store_id;
	
	 
	    $page = max(1, $_REQUEST['page']);
	
		$limit = max(5, $_REQUEST['size']);;
		
		
	
        $state = array('0'=>'未付款','1'=>'已付款');
		$type = array('1'=>'平台收款','2'=>'店铺收款');
		$database = D('Order_cashier');
		$where['store_id'] = $store_id;
	   if($physical_id){
		
       $where['physical_id'] = $physical_id;
            }
	    $where['status'] = 1;
		$count = $database->where($where)->count('order_id');
		$list = array();
		$pages = '';
		$total_pages = ceil($count / $limit);
		
		$offset = ($page - 1) * $limit;

			$list = $database->where($where)->order('`order_id` DESC')->limit($offset.','.$limit)->select();
			 foreach ($list as $key => $store)
        {
		    $physical = M('Store_physical')->getOne($store['physical_id']);
			$list[$key]['physical_name'] = $physical['county_txt'].$physical['name'];
			$list[$key]['status'] = $state[$store['status']];
			$list[$key]['type'] = $type[$store['type']];
			$list[$key]['pay_dateline'] = !empty($store['pay_dateline']) ? date('Y-m-d H:i:s',$store['pay_dateline']):'';
			$list[$key]['dateline'] = date('Y-m-d H:i:s',$store['dateline']);
            $list[$key]['name'] = isset($store['name']) ? $store['name']:'';
			unset($list[$key]['store_id']);
			unset($list[$key]['physical_id']);
			unset($list[$key]['uid']);
			unset($list[$key]['openid']);
			unset($list[$key]['content']);
			unset($list[$key]['third_id']);
			unset($list[$key]['third_data']);
        }
		
	 $results['data']=$list;
	 $results['page_count']=(string)$total_pages;
	 $results['page_index']=(string)$page;
       exit(json_encode($results));
	}









}
