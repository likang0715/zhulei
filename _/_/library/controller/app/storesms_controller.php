<?php
/**
 * 订单控制器
 */
class storesms_controller extends base_controller{

	
public function index(){ 
        $results = array('result'=>'0','data'=>array(),'msg'=>'');

        $store_id = $this->store_id;
		
    $list = D('Sms_tpl')->where("type='2' and status='1'")->order('id ASC')->select();

    $lists=array();
    foreach($list as $key=>$r){
	$lists[$key]['id']=$r['id'];
	$lists[$key]['name']=$r['name'];
	//$lists[$key]['text']=$r['text'];
	$k=$r['id'];
    $power= D('Sms_power')->where(array('store_id' => $store_id,'type'=>$k))->find();
	
    $lists[$key]['status']=$power['status'];
    $lists[$key]['app']=$power['app'];
   }

 
	  $results['data']=$lists;
       exit(json_encode($results));    
   } 




public function sms_setting() {

   $results = array('result'=>'0','data'=>array(),'msg'=>'');

   $store_id = $this->store_id;
   $name = $_REQUEST['id'];
  
   $status = $_REQUEST['status'];
   $app = $_REQUEST['app'];
        if(empty($name)){
	        $results['result']='1';
			$results['msg']='id不能为空';
			exit(json_encode($results));
			}
	
		
		  $store_notice = D('Sms_power')->where(array('store_id'=>$store_id,'type'=>$name))->find();
		   $array=array();
		   if(isset($status)){
		   $array['status']= $status;
		   }
		    if(isset($app)){
		   $array['app']= $app;
		   }
		   $array['weixin']= 0;
		   $array['type'] = $name;
		 if($store_notice) {
		  $power= D('Sms_power')->data($array)->where(array('store_id' => $store_id,'type'=>$name))->save();
		
		} else {
		 $array['store_id'] = $store_id;
		 
		 $power= D('Sms_power')->data($array)->add();
		}

 exit(json_encode($results));  
}



public function send_list () {

  $results = array('result'=>'0','data'=>array(),'msg'=>'');
  $store_id = $this->store_id;
  
  $starttime=$_REQUEST['starttime'];
  $endtime=$_REQUEST['endtime'];

  $page = max(1, $_REQUEST['page']);
  $limit = max(1, $_REQUEST['size']);

  $where=array();
  $where['store_id'] = $store_id;
  if($starttime && $endtime){
    if ((time()-$endtime>7948800) || (time()-$starttime>7948800)) {
      json_return(1, '只可查询近3个月的记录');
    }
    $where['time'] = array(array('>=',$starttime),array('<=',$endtime));
  }
  $where['type'] = array('in',array('5','6','7','18'));
  $count = D('Sms_jpush')->where($where)->count();


  $max = ceil($count/$limit);

 
  $offset = ($page - 1) * $limit;
$send_list=array();
  $list = D('Sms_jpush')->where($where)->order('time DESC')->limit($offset.','.$limit)->select();
  //echo D('Sms_record')->last_sql;
  foreach($list as $key=>$r){
    $send_list[$key]['id']=$r['id'];
    $send_list[$key]['time']=date('Y-m-d H:i:s',$r['time']);
    $send_list[$key]['text']=$r['text'];
  //  $send_list[$key]['mobile']=$r['mobile'];
    $send_list[$key]['status']=$r['show'];
	$send_list[$key]['type']=$r['type'];
  }


  
$results['page_count']=(string)$max;
$results['page_index']=(string)$page;
$results['data']=$send_list;
exit(json_encode($results));

}

public function send_save() {

   $results = array('result'=>'0','data'=>array(),'msg'=>'');

   $store_id = $this->store_id;
   $id = $_REQUEST['id'];

        if(empty($_REQUEST['id'])){
	        $results['result']='1';
			$results['msg']='id不能为空';
			exit(json_encode($results));
			}
$array=array();
$array['id']= $id;
$array['show']= 1;
$power= D('Sms_jpush')->data($array)->where(array('store_id' => $store_id,'id'=>$id))->save();

 exit(json_encode($results));  
}

}
