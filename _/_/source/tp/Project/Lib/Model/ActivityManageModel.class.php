<?php
class ActivityManageModel extends Model{
	//数据转换
	public function bargainData($data){	//砍价
		$return = array();
		foreach($data as $key=>$val){
			$return[$key]['modelId'] = $val['pigcms_id'];
			$return[$key]['title'] = $val['name'];
			$return[$key]['info'] = $val['wxinfo'];
			$return[$key]['image'] = $val['wxpic'];
			$return[$key]['token'] = $val['token'];
			$return[$key]['time'] = $val['addtime'];
			$return[$key]['price'] = $val['minimum'];
            $return[$key]['original_price'] = $val['original'];
            $return[$key]['endtime'] = 0;
		}
		return $return;
	}
	public function crowdfundingData($data){	//众筹
		$return = array();
		foreach($data as $key=>$val){
			$return[$key]['modelId'] = $val['id'];
			$return[$key]['title'] = $val['name'];
			$return[$key]['info'] = $val['intro'];
			$return[$key]['image'] = $val['pic'];
			$return[$key]['token'] = $val['token'];
			$return[$key]['time'] = $val['start'];
			$return[$key]['price'] = $val['fund'];
            $return[$key]['original_price'] = 0;
            $return[$key]['endtime'] = $val['start'] + $val['day'] * 86400;
		}
		return $return;
	}
	public function cutpriceData($data){	//降价拍
		$return = array();
		foreach($data as $key=>$val){
			$return[$key]['modelId'] = $val['pigcms_id'];
			$return[$key]['title'] = $val['name'];
			$return[$key]['info'] = $val['wxinfo'];
			$return[$key]['image'] = $val['wxpic'];
			$return[$key]['token'] = $val['token'];
			$return[$key]['time'] = $val['addtime'];
			$return[$key]['price'] = $val['stopprice'];
			$return[$key]['original_price'] = $val['original'];
			$return[$key]['endtime'] = 0;		
		}
		return $return;
	}
	// public function red_packetData($data){	//红包
	// 	$return = array();
	// 	foreach($data as $key=>$val){
	// 		$return[$key]['modelId'] = $val['id'];
	// 		$return[$key]['title'] = $val['title'];
	// 		$return[$key]['info'] = $val['desc'];
	// 		$return[$key]['image'] = $val['msg_pic'];
	// 		$return[$key]['token'] = $val['token'];
	// 		$return[$key]['time'] = $val['start_time'];
	// 	}
	// 	return $return;
	// }
	public function seckillData($data){	//秒杀
		$return = array();
		foreach($data as $key=>$val){
			$return[$key]['modelId'] = $val['action_id'];
			$return[$key]['title'] = $val['reply_title'];
			$return[$key]['info'] = $val['reply_content'];
			$return[$key]['image'] = $val['action_header_img'];
			$return[$key]['token'] = $val['action_token'];
			$return[$key]['time'] = $val['action_sdate'];
            $return[$key]['endtime'] = $val['action_edate'];
			$return[$key]['original_price'] = 0;
		}
		return $return;
	}
	public function unitaryData($data){	//一元夺宝
		$return = array();
		foreach($data as $key=>$val){
			$return[$key]['modelId'] = $val['id'];
			$return[$key]['title'] = $val['name'];
			$return[$key]['info'] = $val['wxinfo'];
			$return[$key]['image'] = $val['logopic'];
			$return[$key]['token'] = $val['token'];
			$return[$key]['time'] = $val['addtime'];
		    $return[$key]['price'] = $val['price'];
            $return[$key]['original_price'] = $val['price'];
            $return[$key]['endtime'] = $val['endtime'];//?
		}
		return $return;
	}
	
	public function lotteryData($data){	//大转盘
		$return = array();
		foreach($data as $key=>$val){
			$return[$key]['modelId'] = $val['id'];
			$return[$key]['title'] = $val['title'];
			$return[$key]['info'] = $val['info'];
			$return[$key]['image'] = $val['starpicurl'];
			$return[$key]['token'] = $val['token'];
			$return[$key]['time'] = $val['statdate'];
			$return[$key]['price'] = $val['fist'];
			$return[$key]['original_price'] = 0;
			$return[$key]['type'] = $val['type'];
			$return[$key]['endtime'] = $val['enddate'];
		}
		return $return;
	}

	public function guajiangData($data){	//刮刮卡
		$return = array();
		foreach($data as $key=>$val){
			$return[$key]['modelId'] = $val['id'];
			$return[$key]['title'] = $val['title'];
			$return[$key]['info'] = $val['info'];
			$return[$key]['image'] = $val['starpicurl'];
			$return[$key]['token'] = $val['token'];
			$return[$key]['time'] = $val['statdate'];
			$return[$key]['original_price'] = 0;
			$return[$key]['type'] = $val['type'];
			$return[$key]['endtime'] = $val['enddate'];
		}
		return $return;
	}

	public function jiugongData($data){	//九宫格
		$return = array();
		foreach($data as $key=>$val){
			$return[$key]['modelId'] = $val['id'];
			$return[$key]['title'] = $val['title'];
			$return[$key]['info'] = $val['info'];
			$return[$key]['image'] = $val['starpicurl'];
			$return[$key]['token'] = $val['token'];
			$return[$key]['time'] = $val['statdate'];
			$return[$key]['original_price'] = 0;
			$return[$key]['type'] = $val['type'];
			$return[$key]['endtime'] = $val['enddate'];

		}
		return $return;
	}

	public function luckyFruitData($data){	//水果机
		$return = array();
		foreach($data as $key=>$val){
			$return[$key]['modelId'] = $val['id'];
			$return[$key]['title'] = $val['title'];
			$return[$key]['info'] = $val['info'];
			$return[$key]['image'] = $val['starpicurl'];
			$return[$key]['token'] = $val['token'];
			$return[$key]['time'] = $val['statdate'];
			$return[$key]['original_price'] = 0;
			$return[$key]['type'] = $val['type'];
			$return[$key]['endtime'] = $val['enddate'];
		}
		return $return;
	}

	public function goldenEggData($data){	//砸金蛋
		$return = array();
		foreach($data as $key=>$val){
			$return[$key]['modelId'] = $val['id'];
			$return[$key]['title'] = $val['title'];
			$return[$key]['info'] = $val['info'];
			$return[$key]['image'] = $val['starpicurl'];
			$return[$key]['token'] = $val['token'];
			$return[$key]['time'] = $val['statdate'];
			$return[$key]['original_price'] = 0;
			$return[$key]['type'] = $val['type'];
			$return[$key]['endtime'] = $val['enddate'];
		}
		return $return;
	}
}

?>