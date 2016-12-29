<?php
/**
 * 订单控制器
 */
class storemember_controller extends base_controller{



public function physical() {
	   $results = array('result'=>'0','data'=>array(),'msg'=>'');
		
		$list = M('Store_physical')->getList($this->store_id);
		

		

		$store_physical=array();
		foreach($list as $k=>$r) {
				$store_physical[$k]['pigcms_id'] = $r['pigcms_id'];
				$store_physical[$k]['phone1'] = $r['phone1'];
				$store_physical[$k]['phone2'] = $r['phone2'];
				$store_physical[$k]['address'] = $r['address'];
				$store_physical[$k]['images'] = $r['images'];
				$store_physical[$k]['name'] = $r['name'];

				$physical_id=$r['pigcms_id'];
				$category=D('Meal_category');
				$cat_list = $category->where(array('store_id'=>$this->store_id,'physical_id'=>$physical_id))->order('cat_sort desc')->select();
				$store_physical[$k]['cats']= $cat_list;
			}   
		$results['data']=$store_physical;

	exit(json_encode($results));

	}
	

	 /**
     * 茶座列表
     */
    public function member_list() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
       

     	$page = max(1, $_REQUEST['page']);
		$limit = max(1, $_REQUEST['size']);
		
	   $store_id = $this->store_id;
		
		$where_string = "";
		$count = "0";
		
		$select_type = $_POST['select_type'];
		$keyword = $_POST['keyword'];
		
		$select_degree = $_POST['select_degree'];
		$start_point = $_POST["start_point"];
		$end_point = $_POST["end_point"];
		
		$select_time_type = $_POST['select_time_type'];
		$start_time = $_POST['start_time'];
		$end_time = $_POST['end_time'];
		
		if ($keyword) {
			switch($select_type) {
				case 'uid':
					$where[] = "su.uid = '".$keyword."'";
					break;
					
				case 'nickname':
					$where[] = "u.nickname like '%".$keyword."%'";
					break;
					
				case 'phone':
					$where[] = "u.phone like '%".$keyword."%'";
					break;
			}
		}
		
		if ($select_degree) {
			$where[] = "su.degree_id = '" . $select_degree . "'";
		}

		if ($start_point!='' && $end_point!='') {
			$where[] = "su.point >= '" . $start_point . "' AND su.point <='" . $end_point . "'";
		}elseif($start_point!='' && $end_point==''){
            $where[] = "su.point >= '" . $start_point . "'";
        }elseif($start_point=='' && $end_point!=''){
            $where[] = "su.point <='" . $end_point . "'";
        }
		
		if(!empty($start_time) || !empty($end_time)) {
			if($select_time_type == 'add_time') {
				if (!empty($start_time) && !empty($end_time)) {
					$where[] = "u.reg_time >= '" . strtotime($start_time) . "' and u.reg_time <= '" . strtotime($end_time) . "'";
				} else if (!empty($start_time)) {
					$where[] = "u.reg_time >= '" . strtotime($start_time) . "'";
				} else {
					$where[] = "u.reg_time <= '" . strtotime($end_time) . "'";
				}
			} else if($select_time_type == 'last_time') {
				if (!empty($start_time) && !empty($end_time)) {
					$where[] = "u.last_time >= '" . strtotime($start_time) . "' and u.last_time <= '" . strtotime($end_time) . "'";
				} else if (!empty($start_time)) {
					$where[] = "u.last_time >= '" . strtotime($start_time) . "'";
				} else {
					$where[] = "u.last_time <= '" . strtotime($end_time) . "'";
				}
			}
		}
		
		$where[] = "su.store_id='" . $store_id . "'";
		if(is_array($where)) {
			$where_string = implode(" and ", $where);
		}
		
		$credit_setting = D('Credit_setting')->find();
		$platform_credit_name = $credit_setting['platform_credit_name'] ? $credit_setting['platform_credit_name'] : "平台币";

		$counts = D('')->table('User as u')->join("Store_user_data as su On u.uid=su.uid")->where($where_string)->field('count(u.uid) as count')->find();
		$count = $counts['count'] ? $counts['count'] : 0;
		if ($count) {
			
			$pages=ceil($count / $limit);
		    $offset=($page - 1) * $limit;
			$order_by = "";
			
			$list = D('')->table('User as u')->join("Store_user_data as su On u.uid=su.uid")->where($where_string)->field("su.*,u.point_unbalance,u.point_balance,u.nickname,u.avatar,u.login_count,u.last_time,u.phone,u.openid")->limit($offset . ',' . $limit)->select();
			if(is_array($list)) {
				foreach($list as $k=>$v) {
					$userDegree = M('Store_user_data')->getUserData($store_id, $v['uid']);
					$list[$k]['degree_name'] = $userDegree['degree_name'];
					$uid_arr[] = $v['uid'];
				}
			}

			if(is_array($uid_arr)) {
				$subsrcibe_store_list = M('Subscribe_store')->getFansByStore($store_id, $uid_arr);
				if(is_array($subsrcibe_store_list)) {
					foreach($subsrcibe_store_list as $k=>$v) {
						$guanzhu[$v['uid']] = $v;
					}
				}
			}
			
		}

		//调出店铺会员等级设定
		$user_degree = D('User_degree')->where(array('store_id'=>$store_id))->order("level_num asc")->select();
		if(is_array($user_degree)) {
			foreach($user_degree as $k=>&$v) {
				$user_info_degree[$v['id']] = $v;
			}
		}
		$memberlist=array();
			foreach($list as $k=>$r) {
				$memberlist[$k]['pigcms_id'] = $r['pigcms_id'];
				$memberlist[$k]['money'] = $r['money'];
				$memberlist[$k]['nickname'] = $r['nickname'];
				$memberlist[$k]['phone'] = $r['phone'];
			    $memberlist[$k]['avatar'] = isset($r['avatar'])?$r['avatar']:'';
			}   
	   
		$results['page_count']=(string)$pages;
		$results['page_index']=(string)$page;
		$results['data']=$memberlist;
		exit(json_encode($results));
		
    }


}
