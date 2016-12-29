<?php
/**
 * 前台Lbs
 * User: pigcms-s
 * Date: 2016/02/16
 * Time: 09:39
 */

class LbsAction extends BaseAction {
	
/*     public function index() {
        $bank = M('Bank');

        $bank_count = $bank->count('bank_id');
        import('@.ORG.system_page');
        $page = new Page($bank_count, 20);
        $banks = $bank->order('`bank_id` DESC')->limit($page->firstRow, $page->listRows)->select();
        $this->assign('banks',$banks);
        $this->assign('page', $page->show());

        $this->display();
    }
 */
	
/* 	public function  getones() {

		$name = "亳州市";
		import("ChineseSpell",'./source/class/');
		$chineseSpell = new ChineseSpell();		
		$aa = $chineseSpell->getFullSpell($name);
		$p =  ord(substr($name, $i, 1));

		if ($p > 160) {
			$q = ord(substr($chinese, ++$i, 1));
			$p = $p * 256 + $q - 65536;
		}

		$p = $chineseSpell->getChineseSpell($p);
		
		echo "<br/>";
		echo $p;
		echo "<br/>";
		echo $aa;
		
	} */
	
	public function index() {
		import("area",'./source/class/');
		$class_area = new area();
		$aleady_area_code = array();
		$alert_area_hot = array();
		$hot_code = array();
		
		
		if(IS_POST) {
			$count = M('LbsArea')->count('code');
			if ($count == 0) {
				$this->_lbs_area();
			}
			
			$city = $_POST['city'];
			$area = $_POST['area'];
			
			if (empty($city) && empty($area)) {
				$this->ajaxReturn(array('code' => 1000, 'msg' => '至少需要选择一个城市吧！'));
			}
			
			D('Lbs_area')->where(array('code' => array('in', $city . ',' . $area)))->data(array('is_open' => 1))->save();
			D('Lbs_area')->where(array('code' => array('not in', $city . ',' . $area)))->data(array('is_open' => 0))->save();
			D('Lbs_area')->where(array('is_open' => 0))->data(array('is_hot' => 0))->save();

            // 清空缓存
            import('ORG.Util.Dir');
            Dir::delDirnotself('./cache');
			
			if(preg_match("/^[0-9]{1,5}$/", $_POST['lbs_distance_limit1'])) {
				$lbs_distance_limit = $_POST['lbs_distance_limit1'];
			} else {
				$lbs_distance_limit = 0;
			}
			
			D('Config')->data(array('value'=>$lbs_distance_limit))->where(array('name'=>'lbs_distance_limit'))->save();
			$this->ajaxReturn(array('code' => 0, 'msg' => '操作成功'));
		} else {
			$count = M('LbsArea')->count('code');
			if ($count == 0) {
				$this->_lbs_area();
			}
			
			$area = $class_area->get_AllProvCityArea();
			
			$data_areas = M('LbsArea')->where(array('is_open'=>1))->select();
			if(is_array($data_areas)) {
				foreach($data_areas as $k=>$v) {
					$aleady_area_code[] = $v['code'];
					if($v['is_hot'] == 1) {
						$alert_area_hot[] = $v;
					}
				}
			}
		}
		
		
		$lbs_distance_limit = M('Config')->where(array('name'=>'lbs_distance_limit'))->find();
		
		
		$this->assign('lbs_distance_limit',$lbs_distance_limit);
		$this->assign('alert_area_hot',$alert_area_hot);
		$this->assign('aleady_area_code',$aleady_area_code);
		$this->assign('area',$area);
		$this->display();
	}
	
	

    /**
     * 将form提交过来的信息数组化
     * @param $str
     * @return array
     */
    function proper_parse_str($str) {
        $str = urldecode($str);
        $arr = array();

        $pairs = explode('&', $str);

        foreach ($pairs as $i) {
            list($name,$value) = explode('=', $i, 2);

            if( strpos($name,'[')>0 && strpos($name,']')>0 ) {
                $split = str_replace('[',']',$name);
                $splitarr = explode(']',$split);
                $arr[$splitarr[0]][$splitarr[1]] = urldecode($value);
            } else {
                $arr[$name] = $value;
            }
        }

        return $arr;
    }
	
	//热门城市 添加 删除
	public function set_to_hot() {
		
		$type = $this->_post('type');
		$code = $this->_post('code');
		
		if(!$code) {
			echo json_encode(array('code'=>2000,'msg'=>"操作异常，请联系系统管理员。"));exit;
		}
		switch($type) {
			
			case 'add_hot':
					$count = M('LbsArea')->where(array('is_hot'=>1))->count();
					if($count >=10) {
						echo json_encode(array('code'=>1000,'msg'=>"系统最多允许您设置10个热门城市，您已达上限。"));exit;
					}
					M('LbsArea')->where(array('code'=>$code))->data(array('is_hot'=>1))->save();
					echo json_encode(array('code'=>'0','msg'=>"操作成功"));exit;
				break;
				
			case 'delete_hot':
					M('LbsArea')->where(array('code'=>$code))->data(array('is_hot'=>0))->save();
					echo json_encode(array('code'=>'0','msg'=>"操作成功"));exit;
				break;
		}
	}
	
	function update() {
		$this->_lbs_area();
		$this->ajaxReturn(array('code' => 0, 'msg' => '操作成功'));
	}
	
	// 更新lbs城市
	private function _lbs_area() {
		import("area",'./source/class/');
		$class_area = new area();
		
		$default_area = $class_area->get_AllCityArea();
		$datas = array();
		import("ChineseSpell", './source/class/');
		$chineseSpell = new ChineseSpell();
		
		$lbs_area_list_tmp = M('LbsArea')->select();
		$lbs_area_list = array();
		foreach ($lbs_area_list_tmp as $tmp) {
			$lbs_area_list[$tmp['code']] = array('is_hot' => $tmp['is_hot'], $is_open => $tmp['is_open']);
		}
		
		foreach ($default_area as $k => $v) {
			unset($data);
			$data['code'] = $k;
			$data['name'] = $v;
			
			if (substr($k,-2,2) == '00') {
				$data['first_spell'] = $chineseSpell->getFirstSpell($v,1);
			} else {
				$data['first_spell'] = '';
			}
			
			$data['chinese_spell'] = $chineseSpell->getFullSpell($v);
			$data['is_hot'] = isset($lbs_area_list[$k]['is_hot']) ? $lbs_area_list[$k]['is_hot'] : 0;
			$data['is_open'] = isset($lbs_area_list[$k]['is_open']) ? $lbs_area_list[$k]['is_open'] : 0;
			$datas[] = $data;
		}
		
		D('LbsArea')->addAlls($datas);
	}
} 