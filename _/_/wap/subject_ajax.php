<?php
/**
 *  专题相关ajax
 */
require_once dirname(__FILE__).'/global.php';

$type = $_GET['type'];


switch($type) {
	//评论
	case 'pinlun':
			$data['uid'] = $wap_user['uid'];
			$data['store_id'] = $_REQUEST['store_id'];
			$store_id = $data['store_id'];
			$data['subject_id'] = $_REQUEST['subject_id'];
			$data['timestamp'] = time();
			$data['content'] = $_REQUEST['content'];
			if(!$data['store_id'] || !$data['subject_id'] || !$data['content'] || !$data['uid']) {
				json_return('1000',"缺少参数！");
			}
			
			$subject_info = D('Subject_comment')->where(array('uid'=>$data['uid'],"subject_id"=>$data['subject_id']))->find();
			if($subject_info) {
				json_return('2000',"您已评论过该专题！");
			} else {
				$result = D('Subject_comment')->data($data)->add();
				
				//评论数
				$subject_comment_model = M('Subject_comment');
				$where1 = "sc.store_id = '".$store_id."' and sc.subject_id = '".$data['subject_id']."' and sc.is_show=1";
				$subject_comment_count = $subject_comment_model->getCount($where1);
				$wheres = array('store_id'=>$store_id,'subject_id'=>$data['subject_id']);
				$store_subject_data = D('Store_subject_data')->where($wheres)->find();
				if($store_subject_data) {
					$datas = array(
							'pinlun_count' =>$subject_comment_count,
					);
					D('Store_subject_data')->data($datas)->where($wheres)->save();
				} else {
					$datas = array(
						'store_id' => $store_id,
						'subject_id' => $data['subject_id'],
						'pinlun_count' => 0
					);
					D('Store_subject_data')->data($datas)->add();
				}
				
				
				json_return('0',"评论专题成功！");
			}
		break;
	//点赞	
	case 'dianzan':
		$store_id = $_REQUEST['store_id'];
		$subject_id = $_REQUEST['subject_id'];
		$top_store_id = $_REQUEST['top_store_id'];
		$uid = $wap_user[uid];
		
		if(!$uid || !$store_id || !$subject_id) {
			json_return('1000',$uid."缺少参数！".$subject_id);
		}
		$where = array('user_id'=>$uid,'dataid'=>$subject_id,'store_id'=>$store_id,'type'=>3);
		$aleady_dianzan_info = D('User_collect')->where($where)->find();
		
		if($_REQUEST['types'] == 'qx') {
			if(!$aleady_dianzan_info) {
				json_return('2000',"该专题您还未点赞哦！");
			} else {
				D('User_collect')->where($where)->delete();
				D('Store_subject_data')->where(array('subject_id' => $subject_id,'store_id'=>$store_id))->setDec('dz_count');
				json_return('0',"专题取消点赞成功！");
			}

		} else {
			if($aleady_dianzan_info) {
				json_return('2000',"您已点赞过该专题咯！");
			} else {
				$data = array(
					'store_id'=> $store_id,
					'type' => 3,
					'dataid'=>$subject_id,
					'add_time'=>time(),
					'user_id'=>$uid
				);
				D('User_collect')->data($data)->add();

				if(D('Store_subject_data')->where(array('subject_id' => $subject_id,'store_id'=>$store_id))->find()) {
					D('Store_subject_data')->where(array('subject_id' => $subject_id,'store_id'=>$store_id))->setInc('dz_count');
				} else {
					D('Store_subject_data')->data(array('subject_id'=>$subject_id,'store_id'=>$store_id,'dz_count'=>1))->add();
				}
				json_return('0',"专题点赞成功！");
			}
		}
		break;
	
}