<?php
class auto_controller extends base_controller{

	public $arrays=array();
	public $config;
	public $_G;
	public function __construct(){
		global $_G;
		$this->_G = $_G;
		$this->arrays['config'] = $this->config = $_G['config'];
	}
	
	
	
		public function jpush() {

	
					$sms = D('Sms_tpl')->where(array('id'=>'7','status'=>'1'))->find();

					
					 $physical = M('Store_physical')->getOne('1');	
		
				
					 $mobile=$physical['mobile'];
					
				
					 $value= 'store328';
					 
					 $pname=$physical['name'];
					 $name='李鸡邓';
					 
					 $str=$sms['text'];
					 $price='1111.5';
					 $times=date('Y-m-d H');
					$str=str_replace('{pname}',$pname,$str); 
			        $str=str_replace('{bname}',$bname,$str); 
			        $str=str_replace('{price}',$price,$str);
		            $str=str_replace('{name}',$name,$str);
			        $str=str_replace('{times}',$times,$str);
				
					            $n_title   =  $str;
								$n_content =  $str;		
								$receiver_value = $value;	
								$ios=array('sound'=>'default', 'content-available'=>1);
								$sendno = time();
								$platform = 'android,ios' ;
							
								$msg_content = json_encode(array('n_builder_id'=>0, 'n_title'=>$n_title, 'n_content'=>$n_content, 'n_extras'=>array('ios'=>$ios)));        
								import('source.class.Jpush');
				                $jpush = new Jpush();
								$xx=$jpush->send($sendno, 3, $receiver_value, 1, $msg_content, $platform, 1);	
								print_r($xx);
					
	}
	
	
	
	public function token() {
	  $results = array('result'=>'0','data'=>array(),'msg'=>'');
	    $uid = $_REQUEST['uid'];
	    $token = $_REQUEST['token'];
		if (empty($token)) {
		     $results['result']='1';
			$results['msg']='token不能为空';
			exit(json_encode($results));
		}
		$tokens = D('Users_token')->where(array('uid' => $uid))->find();
		if ($token!=$tokens['token']) {
		   $results['result']='1';
		   $results['msg']='token不正确';
		   exit(json_encode($results));
		}
		
       exit(json_encode($results)); 
	}
	
	
	
	
	public function ad() {
	  $results = array('result'=>'0','data'=>array(),'msg'=>'');
	     $ad = M('Adver')->get_adver_by_key('app_index',1);
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
	
	public function adver() {
	  $results = array('result'=>'0','data'=>array(),'msg'=>'');
	  $tag=$_REQUEST['tag'];
	  $size=$_REQUEST['size'];
	    $ad = M('Adver')->get_adver_by_key($tag,$size);
	    foreach ($ad as &$adver) {
	 $adver['content']=$adver['description'];
			unset($adver['id']);
			unset($adver['store_id']);
			unset($adver['bg_color']);
			unset($adver['cat_id']);
			unset($adver['status']);
			unset($adver['last_time']);
			unset($adver['description']);
			unset($adver['sort_order']);
		
		}
		   
		  $results['data']=$ad; 
		   
       exit(json_encode($results)); 
	}
	
	/**
	 * 通过手机号和密码登录
	 */
	public function yuding_over() {
	  
	    $time=time()-86400;
	    $where=" status < 3 and dd_time < '$time'";
		D('Meal_order')->where($where)->data(array('status' => '4'))->save();
		echo D('Meal_order')->last_sql;
	}
	
	
	public function app() {
	  $results = array('result'=>'0','data'=>array(),'msg'=>'');
	  $list['content']='更新没有';
	  $list['force']='0';
	  $list['url']='http://www.avvcd.com/';
	  $list['code']='1101191212';
	  $results['data']=$list;
      exit(json_encode($results));
	}
	
	
	public function yuding_send() {
	
	    $time=time();
		$etime=time()+3600;
	    $where=" status = 2 and dd_time > '$time' and dd_time <= '$etime' and sms=0";
		$orders=D('Meal_order')->where($where)->select();
		foreach($orders as $key => $r){
		
		$now_store = M('Store')->wap_getStore($r['store_uid']);		
		$user=M('User')->getUserById($now_store['uid']);
		$power=M('Sms_by_code')->power($now_store['store_id'],17);
		
			if($user['smscount']>0 && $power){	
			import('source.class.SendSms');
			$sms = D('Sms_tpl')->where(array('id'=>'17','status'=>'1'))->find();
			}	
			if($sms){
		
			$physical = M('Store_physical')->getOne($r['physical_id']);	

		 	
			
			 $mobile=$order['phone'];
			 
			 $pname=$physical['name'];
			 $bname=$r['tablename']; 
			 $storename=$now_store['name'];
			 $tel=$physical['mobile'];
			 if(empty($tel)) {
						$tel=$now_store['tel'];
					}
			$times=date('Y-m-d H:i:s',$r['dd_time']); 	
					
					
		     $str=$sms['text'];
			 $str=str_replace('{pname}',$pname,$str); 
			 $str=str_replace('{bname}',$bname,$str); 
			 $str=str_replace('{storename}',$storename,$str);
		     $str=str_replace('{tel}',$tel,$str);
			 $str=str_replace('{times}',$times,$str);
			
		 	 $return	= SendSms::send($mobile,$str);	
			 	$uid=array($now_store['uid']);
			if($return==0){
			M('User')->deduct_sms($uid,1);
			
				}
			$data = array(
						'uid' 	=> $r['uid'],
						'store_id' 	=> $r['store_uid'],
						'price' 	=> 10,
						'mobile' 	=> $mobile,
						'text'		=> $content,
						'status'	=> $return,
						'time' => time(),
						'type'	=> 17,
						'last_ip'	=> ip2long(get_client_ip())
				);
			D('Sms_record')->data($data)->add();	
		
				}
				}
		
		
		
		
		D('Meal_order')->where($where)->data(array('sms' => '1'))->save();
		
	}
}
?>