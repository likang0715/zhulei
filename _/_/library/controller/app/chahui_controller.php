<?php
class chahui_controller extends base_controller{
public $config;
	public $_G;
	
	public function __construct(){
		global $_G;
		$this->_G = $_G;
		$this->arrays['config'] = $this->config = $_G['config'];
	}
	public function index() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
	
		$store_id = isset($_REQUEST['store_id']) ? $_REQUEST['store_id'] : '';
		$pigcms_id = isset($_REQUEST['pigcms_id']) ? $_REQUEST['pigcms_id'] : '';
		if($store_id){
         $now_store = M('Store')->wap_getStore($store_id);
          }
		$where =' 1=1 ';
		if($_REQUEST['price']){
		$price=explode('-',$_REQUEST['price']);
		
		$minprice=$price['0'];
		$maxprice=$price['1'];
		}
		$provinceid=$_REQUEST['provinceid'];
		$cityid=$_REQUEST['cityid'];
		$countyid=$_REQUEST['countyid'];
		$type=$_REQUEST['type'];
		$tag=$_REQUEST['tag'];
		if($minprice){
		
			$where .= " AND price >='$minprice' ";
			
			}
		if($maxprice){
		
			$where .= " AND price <= '$maxprice' ";
			
			}	
		if($provinceid){
		
			$where .= " AND province ='$provinceid' ";
			
			}
		if($cityid){
		
			$where .= " AND city ='$cityid' ";
			
			}	
		if($countyid){
		
			$where .= " AND county ='$countyid' ";
			
			}		
			
		$time=strtotime($_REQUEST['time']);	
		$nowtime=strtotime(date('Y-m-d'));
		if($time){
		
		$today=$nowtime+86400;
		$where .= " AND sttime >='$nowtime'   AND sttime <='$today'";
			
			}	
			
		$sxtime=strtotime($_REQUEST['sxtime']);	
		
	switch($sxtime)
	{
		case 'week':
		   $weektime=$nowtime+86400*7;
			$where .= " AND sttime >='$nowtime'   AND sttime <='$weektime'";
			break;
		case 'month':
		    $monthtime=$nowtime+86400*30;
			$where .= " AND sttime >='$nowtime'   AND sttime <='$monthtime'";
			break;
		case 'today':
		    $today=$nowtime+86400;
			$where .= " AND sttime >='$nowtime'   AND sttime <='$today'";
			break;
		case 'tomorrow':
		$today=$nowtime+86400;
		$tomorrow=$nowtime+86400*2;
		$where .= " AND sttime >='$today'   AND sttime <='$tomorrow'";
			break;
		case 'after':
		$today=$nowtime+86400*2;
		$tomorrow=$nowtime+86400*3;
		$where .= " AND sttime >='$today'   AND sttime <='$tomorrow'";
			break;
	}	
			
			
			
			
			
		if($store_id){
		$where .= ' AND store_id = '.$store_id;
		}
		$zt=$_REQUEST['cat_id'];
		if($zt){
		$where .= ' AND zt = '.$zt;
		}
		if($pigcms_id){
		$where .= ' AND physical_id = '.$pigcms_id;
		}
		
		if($tag){
		$where .= " AND name like '%$tag%'";
		}
		
		
		
		$page = max(1, $_REQUEST['page']);
		$size	 = max(5, $_REQUEST['size']);
	   $limit = $size;
	   $count = D('Chahui')->where($where)->count('pigcms_id');
	   if ($count > 0) {
	    $pages = '';
		$total_pages = ceil($count / $limit);
		
		$page = min($page, $total_pages);
		$offset = ($page - 1) * $limit;
		$sql=' store_id,pigcms_id,name,address,price,images,sttime,endtime,descs ';
		$lat=$_REQUEST['lat'];
		$long=$_REQUEST['long'];
		$orderby=" pigcms_id DESC";
		if($lat && $long){
		
		/*import('Http');
		$http_class = new Http();
		$callback = $http_class->curlGet('http://api.map.baidu.com/geoconv/v1/?coords=' . $long . ',' . $lat . '&from=1&to=5&ak=4c1bb2055e24296bbaef36574877b4e2');
		$callback_arr = json_decode($callback, true);
		if(empty($callback_arr['result']) || !empty($callback_arr['status'])){
			$results['result']='1';
			$results['msg']='地理位置解析错误';
			exit(json_encode($results));
		}else{
			$long = $callback_arr['result'][0]['x'];
			$lat = $callback_arr['result'][0]['y'];
		}*/
		
		$sql.=",ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`long`*PI()/180)/2),2)))*1000) AS juli";
		$orderby=" juli asc , pigcms_id DESC";
		}

		$lists = D('Chahui')->field($sql)->where($where)->order($orderby)->limit($offset.','.$limit)->select();
		foreach($lists as $key =>$r){
		$physical = D('Store_physical')->where(array('pigcms_id'=>$r['physical_id']))->find();
	if(empty($physical)){
	
	$physical = M('Store')->wap_getStore($r['store_id']);
	}
		
		$list[$key]['pigcms_id']=$r['pigcms_id'];
		$list[$key]['name']=$r['name'];
		$list[$key]['desc']=$r['descs']?$r['descs']:'';
		$list[$key]['address']=$r['address'];
		if($r['price']>0){
		$list[$key]['price']=$r['price'];
		}else{
		$list[$key]['price']='免费';
		}
		if($lat && $long){
		$list[$key]['juli']=$r['juli'];
		}
		$list[$key]['images']=getAttachmentUrl($r['images']);
		$list[$key]['logo']=getAttachmentUrl($physical['logo']);
		$list[$key]['sttime']=date('m/d H:i',$r['sttime']);
		$list[$key]['endtime']=date('m/d H:i',$r['endtime']);
	
	//	$list[$key]['url']=$config['wap_site_url'] . '/chahui_show.php?id=' . $r['pigcms_id'];
		}
		
				}
	$page_info['page_count'] =  (string)$total_pages;;
	$page_info['page_index'] =  (string)$page;
	$results['page_info'] =  $page_info;
	if($page==1){
	$category = D('Chahui_category')->field('`cat_id`,`cat_name`,`cat_pic`')->where(array('cat_status' => 1))->order('cat_sort DESC,cat_id DESC')->select();

	foreach($category as $key=>$r){
	
	$category[$key]['cat_pic']=getAttachmentUrl($r['cat_pic']);
	}
	}
	
	$listz=array();
	
	if($type==1){
	
	
	
	  if(empty($price) && empty($tag) && empty($cityid)){
		 $listz[0]['r']	=  1;
		  if($page==1){
		 $listz[0]['data1']	=  $category;
	  
		 }else{
		  $listz[0]['data1']	= array();
		 }
		}
		 $count=count($list);
		
		   if(empty($price) && empty($tag) && empty($cityid)){
		 for($i=1;$i<=$count;$i++){
		 $x=$i-1;
		 $listz[$i]['r']	=  2;
		 $listz[$i]['data2']	=  $list[$x] ? $list[$x]: array();
	
		 }
	   }else{
	   for($i=0;$i<=$count;$i++){
			 $listz[$i]['r']	=  2;
		 $listz[$i]['data2']	=  $list[$i] ? $list[$i]: array();
	
		 }
	   
	   }
	
	}else{
	$listz['list']=$list ? $list : array();
	$listz['category']=$category;
	}
	$results['data']=$listz;

	exit(json_encode($results));
    }
	
	
	public function show() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
	
		$pigcms_id = isset($_REQUEST['pigcms_id']) ? $_REQUEST['pigcms_id'] : '';
		if (empty($pigcms_id)) {
		     $results['result']='1';
			$results['msg']='pigcms_id不能为空';
			exit(json_encode($results));
		}
	     $where=array();
         $where['pigcms_id']=$pigcms_id;
		 $where['status']=1;
		$r = D('Chahui')->where($where)->find();
	$physical = D('Store_physical')->where(array('pigcms_id'=>$r['physical_id']))->find();
	if(empty($physical)){
	
	$physical = M('Store')->wap_getStore($r['store_id']);
	}
		
		$list['name']=$r['name'];
		$list['images']=getAttachmentUrl($r['images']);
		if($r['price']>0){
		$list['price']=$r['price'];
		}else{
		$list['price']='免费';
		}
		
		$list['storename']=$physical['name'];
		$list['physical_id']=$r['physical_id'];
		$list['zlong']=$r['long'];
		$list['zlat']=$r['lat'];
		$list['sttime']=date('m/d H:i',$r['sttime']);
		$list['endtime']=date('m/d H:i',$r['endtime']);
		$list['address']=$r['address'];
		$list['renshu']=$r['renshu'];
		$list['bm']=D('Chahui_bm')->where(array('cid'=>$r['pigcms_id']))->count('id');
		
		$list['content']=$this->config['wap_site_url'] . '/chahui_app.php?id=' . $pigcms_id;
	
	
    $xgs =D('Chahui')->field('store_id,pigcms_id,name,address,images,sttime,endtime,descs')->where(array('zt'=>$r['zt']))->limit(2)->select();
	foreach($xgs as $key =>$r){
	$phy = D('Store_physical')->where(array('pigcms_id'=>$r['physical_id']))->find();
	if(empty($physical)){
	
	$phy = M('Store')->wap_getStore($r['store_id']);
	}
	    $xg[$key]['pigcms_id']=$r['pigcms_id'];
		$xg[$key]['name']=$r['name'];
		$xg[$key]['images']=getAttachmentUrl($r['images']);
	    $xg[$key]['storename']=$phy['name'];
		$xg[$key]['sttime']=date('m/d H:i',$r['sttime']);
		$xg[$key]['endtime']=date('m/d H:i',$r['endtime']);
		$xg[$key]['address']=$r['address'];
	    $xg[$key]['desc']=$r['descs']?$r['descs']:'';
	}
	$lists['show']=$list;
	$lists['list']=$xg ? $xg :'';
	
    	$share['logo']=getAttachmentUrl($physical['images']);
		$share['name']=$r['name'];
		$share['url']=$this->config['wap_site_url'] . '/chahui_show.php?id=' . $r['pigcms_id'];
		$share['info']=$r['descs'] ? $r['descs'] : $r['name'];
		
		
		$lists['share']=$share;
	$results['data']=$lists;

	exit(json_encode($results));
    }
	
	
	
	public function search() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
	import('area');
	$areaClass = new area();
    $list =D('Chahui')->field('city')->group('city')->select();
	foreach($list as $key =>$r){
   
		$lists[$key]['value']=$r['city'];
		$lists[$key]['name']=$areaClass->get_name($r['city']);
	    $lists[$key]['num']=D('Chahui')->where(array('city'=>$r['city']))->count('pigcms_id');
	}
	
	foreach($lists as $arr2){
    $flag[]=$arr2["num"];
    }
	
    array_multisort($flag, SORT_DESC, $lists);



      $category = D('Chahui_category')->field('`cat_id` as value,`cat_name` as name')->where(array('cat_status' => 1))->order('cat_sort DESC,cat_id DESC')->select();
	  

      $day[0]['name']='今天';
	  $day[0]['value']='today';
	  $day[1]['name']='明天';
	  $day[1]['value']='tomorrow';
	  $day[2]['name']='后天';
	  $day[2]['value']='after';
	  $day[3]['name']='一周内';
	  $day[3]['value']='week';
	  $day[4]['name']='一月内';
	  $day[4]['value']='month';
	 
	  
	  
	  

  
      $price[0]['name']='0-100元';
	  $price[0]['value']='0-100';

	  $price[1]['name']='100-300元';
	  $price[1]['value']='100-300';

	  $price[2]['name']='300-500元';
	  $price[2]['value']='300-500';

	  $price[3]['name']='500-1000元';
	  $price[3]['value']='500-1000';

	  $price[4]['name']='1000以上元';
	  $price[4]['value']='1000-1000000';


     foreach($lists as &$r){
    unset($r["num"]);
    }
		
		$re['0']['name']='城市';
		$re['0']['data']=$lists;
		$re['0']['key']='cityid';
		$re['1']['name']='主题';
		$re['1']['data']=$category;
		$re['1']['key']='cat_id';
		$re['2']['name']='时间';
		$re['2']['data']=$day;
		$re['2']['key']='sxtime';
		$re['3']['name']='价格';
		$re['3']['data']=$price;
		$re['3']['key']='price';
	    $results['data']=$re;

	exit(json_encode($results));
    }
	
	
	public function baoming() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
	           $dataorder = D('Chahui_bm');
	        	$date=array();
				$date['addtime'] = time();
				
				$date['cid'] = $_REQUEST['cid'];
				$date['name'] = $_REQUEST['name'];
				$date['uid'] = $_REQUEST['uid'];
				$date['mobile'] = $_REQUEST['mobile'];
				$date['status'] = 1;
				
				if (empty($date['cid'])) {
				$results['result']='1';
				$results['msg']='cid不能为空';
				exit(json_encode($results));
				}
				
				if (empty($date['name'])) {
				$results['result']='1';
				$results['msg']='name不能为空';
				exit(json_encode($results));
				}
				
				if (empty($date['mobile'])) {
				$results['result']='1';
				$results['msg']='mobile不能为空';
				exit(json_encode($results));
				}
				
			$where = array();
			$where['uid'] = $date['uid'];
			$where['cid'] = $date['cid'];
        	$value = D('Chahui_bm')->where($where)->find();
			if (!empty($value)) {
				$results['result']='1';
				$results['msg']='已报名';
				exit(json_encode($results));
				}
			 $chahui = D('Chahui')->where(array('pigcms_id'=>$_REQUEST['cid']))->find();
			 
			 
			 
			 
                $date['store_id'] = $chahui['store_id'];
				$date['physical_id'] = $chahui['pigcms_id'];
			if($dataorder->data($date)->add()){
			
			$now_store = M('Store')->wap_getStore($chahui['store_id']);		
			$user=M('User')->getUserById($now_store['uid']);
			
			
			
			
			
			$pj = D('Sms_power')->where(array('store_id' => $now_store['store_id'],'type' => '6','app' => '1'))->find();
				if ($pj) {
					$sms = D('Sms_tpl')->where(array('id'=>'6','status'=>'1'))->find();

						if($sms){
				
		    	 $chname=$chahui['name']; 
					 $receiver_send = D('User')->where(array('drp_store_id'=>$chahui['store_id'],'group'=>'2'))->select();
					$value = '';
					foreach($receiver_send as $key =>$r){
					
					$value .= 'store'.$r['uid'].',';
					
					 }
					 $value .= 'store'.$now_store['uid'];
					
				
					 $name=$_REQUEST['name'];
					 
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
		
			 $chahui = D('Chahui')->where(array('pigcms_id'=>$_REQUEST['cid'],'store_id'=>$chahui['store_id']))->find();
		 	 $chname=$chahui['name']; 
			 $m = D('Sms_mobile')->where(array('store_id'=>$chahui['store_id'],'type'=>'2'))->find();
			 if($m){
			 $mobile=$m['mobile'];
			 }else{
			 $mobile=$now_store['tel'];
			 }
			 $name=$_REQUEST['name'];
			 
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
						'store_id' 	=> $chahui['store_id'],
						'price' 	=> 10,
						'mobile' 	=> $mobile,
						'text'		=> $content,
						'status'	=> $return,
						'time' => time(),
						'type'	=> 6,
						'last_ip'	=> $_SERVER['HTTP_CLIENT_IP']
				);
			D('Sms_record')->data($data)->add();	
		
				}
				}
					
					}else{
			
			 $results['result']='1';
			$results['msg']='添加失败';
			exit(json_encode($results));
					}


	exit(json_encode($results));
    }
	
}
?>