<?php
class activity_controller extends base_controller{

	public function index() {
		//热门活动
		$this->assign('hot_kanjia',M('Activity')->getActivity(array('model' => 'bargain', 'is_hot' => 1), 10));
		$this->assign('hot_miaosha',M('Activity')->getActivity(array('model' => 'seckill', 'is_hot' => 1), 10));
		$this->assign('hot_zhongchou',M('Activity')->getActivity(array('model' => 'crowdfunding', 'is_hot' => 1), 10));
		$this->assign('hot_duobao',M('Activity')->getActivity(array('model' => 'unitary', 'is_hot' => 1), 8));
		$this->assign('hot_jiangjia',M('Activity')->getActivity(array('model' => 'cutprice', 'is_hot' => 1), 10));
		$this->assign('hot_tuan',M('Activity')->getActivity(array('model' => 'tuan', 'is_hot' => 1), 10));
		$this->assign('hot_yushou',M('Activity')->getActivity(array('model' => 'presale', 'is_hot' => 1), 10));

		//附近活动

		$this->assign('kanjia',M('Activity')->getActivity(array('model' => 'bargain', 'is_rec' => 1), 10));
		$this->assign('miaosha',M('Activity')->getActivity(array('model' => 'seckill', 'is_rec' => 1), 10));
		$this->assign('zhongchou',M('Activity')->getActivity(array('model' => 'crowdfunding', 'is_rec' => 1), 10));
		$this->assign('duobao',M('Activity')->getActivity(array('model' => 'unitary', 'is_rec' => 1), 8));
		$this->assign('jiangjia',M('Activity')->getActivity(array('model' => 'cutprice', 'is_rec' => 1), 10));
		$this->assign('tuan',M('Activity')->getActivity(array('model' => 'tuan', 'is_rec' => 1), 10));
		$this->assign('yushou',M('Activity')->getActivity(array('model' => 'presale', 'is_rec' => 1), 10));

		$recommend	= M('Activity')->getActivity(array('is_rec' => 1), 1); //人气推荐
		//幻灯片
		$slider 	= M('Adver')->get_adver_by_key('pc_activity_slider',6);
		//热门活动
		$hot 		= M('Adver')->get_adver_by_key('pc_activity_hot',4);
		//附近活动
		$nearby 	= M('Adver')->get_adver_by_key('pc_activity_nearby',4);

		$this->assign('slider',$slider);
		$this->assign('recommend',$recommend[0]);
		$this->assign('hot',$hot);
		$this->assign('nearby',$nearby);

		$this->display();
	}
	
	
	//活动url
	public function activityurl() {
		
		$qid = "500000000";
		$get_qid = $_GET['get_qid'];
		$qid = (int)$qid+(int)$get_qid;

		$qrcode_return = M('Recognition')->get_tmp_qrcode($qid);
		if($qrcode_return['error_code'] == 0) {
			$ticket = urldecode($qrcode_return['ticket']);


			echo json_encode($qrcode_return);
		} else {//echo "失败";
			//return '0';
			echo json_encode($qrcode_return);
		}
	}
	
	/*@description：全站活动检测二维码	
	 */
	 public function check_qcode() {
			$aid = $_POST['activity_id'];
			$time = time();
			$time_7days_before = time()-60*60*24*7;
			if($aid>0) {
				$where['id'] = $aid;
				$info = D('Activity_recommend')->where($where)->order('id DESC')->find();
				
				if($info['qcode_starttime'] >$time_7days_before) {
					$qcode = $info['qcode'];
				} else {
					$qid = "500000000";//场景起始id
					$qid = (int)$qid+(int)$info['id'];
					/*
						//加入活动二维码进入本地
						import('source.class.upload.upyunUser');
						$attachment_upload_type = option('config.attachment_upload_type');
						//删除old pic
						
						if($info['qcode']) {
							if(file_exists('./upload/'.$info['qcode'])) @unlink('./upload/'.$info['qcode']);
							
							// 从又拍云服务器删除
							if ($attachment_upload_type == '1') {						
								upyunUser::delete('/' . $info['qcode']);
							}
						}
		
			
						//下载二维码图片 @simon
						$local_file = M('Recognition')->download_img_from_weixin($qid,'./upload/activity');
						$upyun_file = str_replace('./upload/' ,"", $local_file);
						// 上传到又拍云服务器
						if ($attachment_upload_type == '1') {
							upyunUser::upload($local_file, $upyun_file);
						}
							
							$datas['qcode'] = $upyun_file;
						$datas['qcode_starttime'] = time();	
					*/

					
					//存入 微信服务器端生成的临时二维码
					$qcode =  M('Recognition')->get_tmp_qrcode($qid);
					if($qcode['error_code']=='0') {
					
						$datas['qcode'] = $qcode['ticket'];
						$datas['qcode_starttime'] = time();
					}								
						
						
						$qcode =  $qcode['ticket'];
						D('Activity_recommend')->data($datas)->where(array('id'=>$aid))->save();

				}
				//本地二维码
				//$wx_img = getAttachmentUrl($qcode);	
				//微信端二维码
				$wx_img = $qcode;
				

				exit(json_encode(array('msg'=>'二维码更新成功！','code'=>'0','wx_img'=>$wx_img)));
			} else {
				
				exit(json_encode(array('msg'=>'获取错误,缺少活动id','code'=>'1')));
			}
	 }
	
	
}