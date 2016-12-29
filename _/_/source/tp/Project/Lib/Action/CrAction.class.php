<?php
function mktimes($y,$m,$d,$h,$min){
	return mktime($h,$min,0,$m,$d,$y);
}
function sort2DArray($ArrayData,$KeyName1,$SortOrder1 = "SORT_ASC",$SortType1 = "SORT_REGULAR"){
    if(!is_array($ArrayData))
    {
        return $ArrayData;
    }
 
    // Get args number.
    $ArgCount = func_num_args();
 
    // Get keys to sort by and put them to SortRule array.
    for($I = 1;$I < $ArgCount;$I ++)
    {
        $Arg = func_get_arg($I);
        if(!@eregi("SORT",$Arg))
        {
            $KeyNameList[] = $Arg;
            $SortRule[]    = '$'.$Arg;
        }
        else
        {
            $SortRule[]    = $Arg;
        }
    }
 
    // Get the values according to the keys and put them to array.
    foreach($ArrayData AS $Key => $Info)
    {
        foreach($KeyNameList AS $KeyName)
        {
            ${$KeyName}[$Key] = $Info[$KeyName];
        }
    }
 
    // Create the eval string and eval it.
    $EvalString = 'array_multisort('.join(",",$SortRule).',$ArrayData);';
    eval ($EvalString);
    return $ArrayData;
}
class CrAction extends BaseAction{
	public function sqls(){
		$sqls_cy=include('sqls4.config.php');
		if (!$sqls_cy){
			$sqls_cy=include($_SERVER['DOCUMENT_ROOT'].'/sqls/sqls4.config.php');
		}
		$sqls=sort2DArray($sqls_cy,'time','SORT_DESC');
		return $sqls;
	}

    public function index(){
        $gid 	= session('gid');
        $uid 	= session('uid');
        $token 	= session('token');
        if(empty($gid) && empty($uid)){
            //exit("请登录后操作!");
        }
        $Model = new Model();
        //检查system表是否存在
		$rt=$Model->query("CREATE TABLE IF NOT EXISTS `".C('DB_PREFIX')."system_info` (
  `lastsqlupdate` int(10) NOT NULL,
  `version` varchar(10) NOT NULL,
  `currentfileid` varchar(40) NOT NULL DEFAULT 0,
  `currentsqlid` varchar(40) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8");
		$status 	= D('System_info')->find();
		if(empty($status)){
			$Model->query("INSERT INTO `".C('DB_PREFIX')."system_info` (`lastsqlupdate`, `version`, `currentfileid`, `currentsqlid`) VALUES ('0', '1.0', '0', '0')");
		}
		//程序的最新时间
		$updateArr=$this->sqls();
		//
		$system_info_db=M('System_info');
		$info=$system_info_db->find();
		if (!$info){
			$system_info_db->add(array('lastsqlupdate'=>0));
		}
		if (mktimes(2013,12,24,1,14)>$info['lastsqlupdate']){
			
		}
		if (intval($info['lastsqlupdate'])>$updateArr[0]['time']||intval($info['lastsqlupdate'])==$updateArr[0]['time']){
			@unlink(APP_PATH.'Lib/Action/User/sqls4.config.php');
			//@unlink(APP_PATH.'Lib/Action/Home/TAction.class.php');
			//@unlink(APP_PATH.'Lib/Action/User/CrAction.class.php');
			//更新完成后，版本控制
			if ($_COOKIE['my_version']) {
				$this->weidian_version($_COOKIE['my_version']);
			}
			exit('数据库更新完成');
			//$this->redirect(U('Index/drp_sync'), array('my_version'=>$_COOKIE['my_version']), 3, '数据库升级完毕，调整同步相关数据');
		}

		//对上面数组进行时间倒序排序

		$update_reverse_arr=array_reverse($updateArr);
		if ($update_reverse_arr){
			foreach ($update_reverse_arr as $key=>$update_item){
				if ($update_item['time']>intval($info['lastsqlupdate'])){	
					switch ($update_item['type']){
						case 'sql':
							//运行sql
							$sql  	= str_replace('{tableprefix}',C('DB_PREFIX'),$update_item['sql']);
							$status = @mysql_query($sql);
							file_put_contents(PIGCMS_PATH . "cache/mysql_update.txt", $sql.';--'.($status?'执行成功！':'执行失败！').'--'.PHP_EOL . PHP_EOL, FILE_APPEND);
							//@$Model->query($update_item['sql']);
							break;
						case 'function':
							//执行更新函数
							//$update_item['name']();
							break;
					}
					//插入更新日志
					/*
					$row['updatetype']=$update_item['type'];
					$row['des']=$update_item['des'];
					$row['logtime']=$update_item['time'];
					$row['time']=SYS_TIME;
					if ($update_item['file']){
						$row['file']=$update_item['file'];
					}
					$this->update_log_db->insert($row);
					*/
	
					$system_info_db->where('lastsqlupdate=0 or lastsqlupdate>0')->save(array('lastsqlupdate'=>$update_item['time']));

					//由于可能需要更新大量数据，每次只执行一个更新
					$this->success('升级中:'.$row['des'],'?c=Cr&a=index');
					break;
				}
			}
		}

	}

	function weidian_version($version) {
		
		if ($version == 1 && $version == 5) { 	//企业版
			$menuWhere 	= array('id'=>array('in','50, 51 ,53 ,54 , 75, 76, 77, 78, 79, 80, 83, 84, 85, 86, 87, 89'));
			$confWhere 	= array('name'=>array('in','is_diy_template, lbs_distance_limit, allow_agent_invite, withdraw_limit, syn_domain, encryption, pc_usercenter_logo'));

			del_system_menu($menuWhere);
			del_config($confWhere);
		} else if ($version == 2 && $version == 6) { //集团版
			$menuWhere 	= array('id'=>array('in','50, 51 ,53 ,54 , 75, 76, 77, 78, 79, 80, 83, 84, 85, 86, 87, 89'));
			$confWhere 	= array('name'=>array('in','is_diy_template, lbs_distance_limit, allow_agent_invite, withdraw_limit, syn_domain, encryption, is_have_activity, pc_usercenter_logo'));

			del_system_menu($menuWhere);
			del_config($confWhere);
		} else if ($version == 3 && $version == 7) { //旗舰版
			$menuWhere 	= array('id'=>array('in','50, 51 ,53 ,54 , 75, 76, 77, 78, 79, 80, 83, 84, 85, 86, 87, 89'));
			$confWhere 	= array('name'=>array('in','is_diy_template, lbs_distance_limit, allow_agent_invite, withdraw_limit, pc_usercenter_logo'));

			del_system_menu($menuWhere);
			del_config($confWhere);
		} else if ($version == 4 && $version == 8) { //运营版


		} else {
			
		}

		//同步更新供货链接
		$Action = A("Index");
		$Action->_update_supply_chain();
		M('Subscribe_store')->where("'uid'=0 OR 'store_id'=0")->delete();
	}

	function del_system_menu($where) {
		M('System_menu')->where($menuWhere)->delete();
	}

	function del_config($where) {
		M('Config')->where($where)->delete();
	}

}