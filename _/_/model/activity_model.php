<?php
class activity_model extends base_model{

	public function getActivity($type,$num=10){
		$data 	= D('Activity_recommend')->where("model='$type'")->order('id DESC')->limit($num)->select();

		$res  	= array();
		
		foreach ($data as $key => $value) {
			$res[$key]['typename'] 	= $this->getTypeName($value['model']);
			$res[$key]['id'] 		= $value['id'];
			$res[$key]['name'] 		= $value['title'];
			$res[$key]['intro'] 	= array_pop(preg_split('/\r\n/',$value['info']));
			$res[$key]['token'] 	= $value['token'];
			$res[$key]['image'] 	= $value['image'];
			$res[$key]['count'] 	= $value['ucount'];
			$res[$key]['appurl'] 	= $this->createUrl($value,$type);
			//本地化$res[$key]['qcode'] 	=  $value['qcode']?getAttachmentUrl($value['qcode']):'./source/qrcode.php?type=activity&id=no&url='.$res[$key]['appurl'];
			$res[$key]['qcode'] 	=  $value['qcode']?$value['qcode']:'./source/qrcode.php?type=activity&id=no&url='.$res[$key]['appurl'];//微信端
			$res[$key]['modelId'] 	= $value['modelId'];
			$res[$key]['time'] 	= $value['time'];
		}

		return $res;

	}

	public function getHotActivity($num,$type="",$rank=""){
		$where 	= "is_rec=1";
		if($type != ''){
			$where	 .= " AND model='$type'";
			$order  = 'id DESC';
		}
		if($rank){
			$order 	= 'ucount DESC';
		}else{
			$order  = 'id DESC';
		}
		$data 	= D('Activity_recommend')->where($where)->order($order)->limit($num)->select();

		$res  	= array();
		
		foreach ($data as $key => $value) {
			$res[$key]['typename'] 	= $this->getTypeName($value['model']);
			$res[$key]['id'] 		= $value['id'];
			$res[$key]['name'] 		= $value['title'];
			$res[$key]['intro'] 	= array_pop(preg_split('/\r\n/',$value['info']));
			$res[$key]['token'] 	= $value['token'];
			$res[$key]['image'] 	= $value['image'];
			$res[$key]['count'] 	= $value['ucount'];
			$res[$key]['appurl'] 	= $this->createUrl($value,$type);
			//本地化$res[$key]['qcode'] 	=  $value['qcode']?getAttachmentUrl($value['qcode']):'./source/qrcode.php?type=activity&id=no&url='.$res[$key]['appurl'];
			$res[$key]['qcode'] 	=  $value['qcode']?$value['qcode']:'./source/qrcode.php?type=activity&id=no&url='.$res[$key]['appurl'];//微信端
			$res[$key]['modelId'] 	= $value['modelId'];
			$res[$key]['time'] 	= $value['time'];
		}

		return $res;
	}

	public function getTypeName($model){
		$array 	= array(
			'bargain'		=> '超级砍价',
			'seckill'		=> '极限秒杀',
			'crowdfunding'	=> '众筹',
			'unitary'		=> '一元夺宝',
			'cutprice'		=> '降价拍',
			'red_packet'	=> '红包',
		);
		return $array[$model];
	}

	// 获取有订单的活动数组
	public function getOrderArr(){
		$models = array(
			'bargain'		=> '超级砍价',
			// 'unitary'		=> '一元夺宝',
			// 'cutprice'		=> '降价拍',
		);
		return $models;
	}
	
	//生成

	public function createUrl($val,$type,$trueurl=0){
		$activity_url 	= option('config.syn_domain') ? rtrim(option('config.syn_domain'),'/').'/' : 'http://demo.pigcms.cn/';

		if($type == 'unitary'){
			$url 	= $activity_url.'/index.php?g=Wap&m='.ucfirst($val['model']).'&a=goods&token='.$val['token'].'&unitaryid='.$val['modelId'];
		}else if($type == 'cutprice'){
			$url 	= $activity_url.'/index.php?g=Wap&m='.ucfirst($val['model']).'&a=goods&token='.$val['token'].'&id='.$val['modelId'];
		}else{
			$url 	= $activity_url.'/index.php?g=Wap&m='.ucfirst($val['model']).'&a=index&token='.$val['token'].'&id='.$val['modelId'];
		}

		if($trueurl){
			return $url;
		}else{
			return urlencode($url);
		}
	}


}