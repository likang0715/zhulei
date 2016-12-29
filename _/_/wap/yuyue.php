<?php

require_once dirname(__FILE__) . '/global.php';

if($_POST['cz_id']){
$cz_id = $_POST['cz_id'];
}else{
$where = " physical_id='".$_POST['pigcms_id']."' and  name ='".$_POST['table']."'";
$meal = D('Meal_cz')->where($where)->find();
$cz_id = $meal['cz_id'];
}
            $dataorder = D('pigcms_meal_order');
	        	$date=array();
				$date['orderid'] = date("YmdHis",$_SERVER['REQUEST_TIME']).'0000'.$wap_user['uid'];
				$date['dateline'] = $_SERVER['REQUEST_TIME'];
				$date['store_uid'] = $_POST['store_id'];
				$date['physical_id'] = $_POST['pigcms_id'];
				$date['name'] = $_POST['name'];
				$date['uid'] = $wap_user['uid'];
				$date['phone'] = $_POST['tel'];
				$date['dd_time'] = strtotime($_POST['gotime']);
		     	$date['sc'] = $_POST['time'];
				$date['num'] = $_POST['num'];
				
				$date['tablename'] = $_POST['table'];
				$date['tableid'] = $cz_id;
				$date['food'] = $_POST['food'];
				
				$date['status'] = 1;

			if($dataorder->data($date)->add()){
					$ok_tips = '添加成功！';
			$now_store = M('Store')->wap_getStore($_POST['store_id']);		
			$user=M('User')->getUserById($now_store['uid']);
			
		
				
				$pj = D('Sms_power')->where(array('store_id' => $now_store['store_id'],'type' =>'7','app' => '1'))->find();
			
				if ($pj) {
					$sms = D('Sms_tpl')->where(array('id'=>'7','status'=>'1'))->find();

						if($sms){
				
					 $physical = M('Store_physical')->getOne($_POST['pigcms_id']);	
		
					 $bname=$_POST['table']; 
					 $times=$_POST['gotime']; 
					 $mobile=$physical['mobile'];
					
					 $receiver_send = D('User')->where(array('drp_store_id'=>$_POST['store_id'],'item_store_id'=>$_POST['pigcms_id']))->select();
					$value = '';
					foreach($receiver_send as $key =>$r){
					
					$value .= 'store'.$r['uid'].',';
					
					 }
					 $value .= 'store'.$now_store['uid'];
					 
					 $pname=$physical['name'];
					 $name=$_POST['name'];
					 
					 $str=$sms['text'];
					$str=str_replace('{pname}',$pname,$str); 
			        $str=str_replace('{bname}',$bname,$str); 
			        $str=str_replace('{price}',$price,$str);
		            $str=str_replace('{name}',$name,$str);
			        $str=str_replace('{times}',$times,$str);
				
					            $n_title   =  $str;
								$n_content =  $str;		
								$receiver_value = $value;	
								$ios=array('sound'=>'default', 'content-available'=>1);
								$sendno =(int)$date['orderid'];
								$platform = 'android,ios' ;
								$msg_content = json_encode(array('n_builder_id'=>0, 'n_title'=>$n_title, 'n_content'=>$n_content, 'n_extras'=>array('ios'=>$ios)));        
								import('source.class.Jpush');
						
						
						
						
				                $jpush = new Jpush();
								$jpush->send($sendno, 3, $receiver_value, 1, $msg_content, $platform, 1);	
								
								$data = array(
						'uid' 	=> $value,
						'store_id' 	=> $_POST['store_id'],
						'price' 	=> 10,
						'mobile' 	=> $mobile,
						'text'		=> $str,
						'status'	=> 1,
						'time' => time(),
						'type'	=> 7,
						'last_ip'	=> ip2long(get_client_ip())
			               	);
		          	D('Sms_jpush')->data($data)->add();


					}
				} 
	
			
			$power=M('Sms_by_code')->power($now_store['store_id'],7);
			if($user['smscount']>0 && $power){	
			import('source.class.SendSms');
			$sms = D('Sms_tpl')->where(array('id'=>'7','status'=>'1'))->find();
				
			if($sms){
		
			 $physical = M('Store_physical')->getOne($_POST['pigcms_id']);	

		 	 $bname=$_POST['table']; 
			 $times=$_POST['gotime']; 
			 $mobile=$physical['mobile'];
			 if(empty($mobile)) {
			 $m = D('Sms_mobile')->where(array('store_id'=>$_POST['store_id'],'type'=>'1'))->find();
			 if($m){
			 $mobile=$m['mobile'];
			 }else{
			 $mobile=$now_store['tel'];
			 }
			 }
			 $pname=$physical['name'];
			 $name=$_POST['name'];
			 
		     $str=$sms['text'];
			 $str=str_replace('{pname}',$pname,$str); 
			 $str=str_replace('{bname}',$bname,$str); 
			 $str=str_replace('{price}',$price,$str);
		     $str=str_replace('{name}',$name,$str);
			 $str=str_replace('{times}',$times,$str);
		 	 $return	= SendSms::send($mobile,$str);	
			if($return==0){
			$uid=array($now_store['uid']);
            M('User')->deduct_sms($uid,1);	
			
				}
			$data = array(
						'uid' 	=> $wap_user['uid'],
						'store_id' 	=> $_POST['store_id'],
						'price' 	=> 10,
						'mobile' 	=> $mobile,
						'text'		=> $content,
						'status'	=> $return,
						'time' => time(),
						'type'	=> 7,
						'last_ip'	=> ip2long(get_client_ip())
				);
			D('Sms_record')->data($data)->add();	
			
				}
				}
		$wxuser=M('User')->getUserById($wap_user['uid']);		
		$openid = $wxuser['openid'];
		if($openid){
			//发送模板消息
			import('source.class.Factory');
			import('source.class.MessageFactory');
			$template_data = array(
					'wecha_id' => $openid,
					'first'    => '亲，您的订单，包厢预定提交成功，请等待商家处理',
					'keyword1' => option('config.orderid_prefix') . $date['orderid'],
					'keyword2' => $physical['name'],
					'keyword3' => $physical['address'],
					'remark'   => '状态：' . "包厢预定中"
			);
			$params['template'] = array('template_id' => 'OPENTM20060617', 'template_data' => $template_data);
			$date = date('Y-m-d H:i:s', time());
		//	$params['sms'] = array('mobile'=>$phone,'token'=>'test','content'=>$msg,'sendType'=>1);
			MessageFactory::method($params, array('smsMessage', 'TemplateMessage'));
			
			}
					}else{
				
					$error_tips = '添加失败！请重试。';
					}
			

include display('yuyue');
 $url='./dcorder.php?id='.$_POST['store_id'].'&action=all';
header("Location: $url");
exit;
echo ob_get_clean();

?>
