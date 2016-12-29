<?php

require_once dirname(__FILE__) . '/global.php';

            $dataorder = D('Chahui_bm');
	        	$date=array();
				
				$date['addtime'] = $_SERVER['REQUEST_TIME'];
				$date['store_id'] = $_POST['store_id'];
				$date['cid'] = $_POST['cid'];
				$date['physical_id'] = $_POST['pigcms_id'];
				$date['name'] = $_POST['name'];
				$date['uid'] = $wap_user['uid'];
				$date['mobile'] = $_POST['mobile'];
				$date['status'] = 1;

			if($dataorder->data($date)->add()){
					$ok_tips = '添加成功！';
					
					
			$now_store = M('Store')->wap_getStore($_POST['store_id']);		
			$user=M('User')->getUserById($now_store['uid']);
			
			
			
			
			
			$pj = D('Sms_power')->where(array('store_id' => $now_store['store_id'],'type' => '6','app' => '1'))->find();
				if ($pj) {
					$sms = D('Sms_tpl')->where(array('id'=>'6','status'=>'1'))->find();

						if($sms){
				 $chahui = D('Chahui')->where(array('pigcms_id'=>$_POST['cid'],'store_id'=>$_POST['store_id']))->find();
		    	 $chname=$chahui['name']; 
					 $receiver_send = D('User')->where(array('drp_store_id'=>$_POST['store_id'],'group'=>'2'))->select();
					$value = '';
					foreach($receiver_send as $key =>$r){
					
					$value .= 'store'.$r['uid'].',';
					
					 }
					 $value .= 'store'.$now_store['uid'];
					
				
					 $name=$_POST['name'];
					 
					 $str=$sms['text'];
					 $str=str_replace('{chname}',$chname,$str); 
		        	 $str=str_replace('{name}',$name,$str);
				
					            $n_title   =  $str;
								$n_content =  $str;		
								$receiver_value = $value;	
								$ios=array('sound'=>'default', 'content-available'=>1);
								$sendno =time();
								$platform = 'android,ios' ;
								$msg_content = json_encode(array('n_builder_id'=>0, 'n_title'=>$n_title, 'n_content'=>$n_content, 'n_extras'=>array('ios'=>$ios)));        
								import('source.class.Jpush');
				                $jpush = new Jpush();
								$jpush->send($sendno, 3, $receiver_value, 1, $msg_content, $platform, 1);	
                        $data = array(
						'uid' 	=> $value,
						'store_id' 	=> $now_store['store_id'],
						'price' 	=> 10,
						'mobile' 	=> $mobile,
						'text'		=> $str,
						'status'	=> 1,
						'time' => time(),
						'type'	=> 6,
						'last_ip'	=> ip2long(get_client_ip())
			               	);
		          	D('Sms_jpush')->data($data)->add();

					}
				} 
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			$power=M('Sms_by_code')->power($now_store['store_id'],6);
			if($user['smscount']>0 && $power){	
			import('source.class.SendSms');
			$sms = D('Sms_tpl')->where(array('id'=>'6','status'=>'1'))->find();
				
			if($sms){
		
			 $chahui = D('Chahui')->where(array('pigcms_id'=>$_POST['cid'],'store_id'=>$_POST['store_id']))->find();
		 	 $chname=$chahui['name']; 
			 $m = D('Sms_mobile')->where(array('store_id'=>$_POST['store_id'],'type'=>'2'))->find();
			 if($m){
			 $mobile=$m['mobile'];
			 }else{
			 $mobile=$now_store['tel'];
			 }
			 $name=$_POST['name'];
			 
		     $str=$sms['text'];
			 $str=str_replace('{chname}',$chname,$str); 
			 $str=str_replace('{name}',$name,$str);
		 	 $return	= SendSms::send($mobile,$str);	
			 	$uid=array($now_store['uid']);
			if($return==0){
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
						'type'	=> 6,
						'last_ip'	=> ip2long(get_client_ip())
				);
			D('Sms_record')->data($data)->add();	
		
				}
				}
					
					}else{
				
					$error_tips = '添加失败！请重试。';
					}
			

include display('baoming');
 $url='./chorder.php?id='.$_POST['store_id'].'&action=all';
header("Location: $url");
exit;
echo ob_get_clean();

?>
