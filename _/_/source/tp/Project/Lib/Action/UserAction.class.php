<?php

/*
 * 用户中心
 *
 * @  Writers    Jaty
 * @  BuildTime  2014/12/29 10:25
 * 
 */

class UserAction extends BaseAction {

    public function index() {

        //搜索
        if (!empty($_GET['keyword'])) {
            if ($_GET['searchtype'] == 'uid') {
                $condition_user['uid'] = $_GET['keyword'];
            } else if ($_GET['searchtype'] == 'nickname') {
                $condition_user['nickname'] = array('like', '%' . $_GET['keyword'] . '%');
            } else if ($_GET['searchtype'] == 'phone') {
                $condition_user['phone'] = array('like', '%' . $_GET['keyword'] . '%');
            }
        }

        // 代理商 只能查看自己代理的用户
        if ($this->admin_user['type'] == 3) {
            $condition_user['invite_admin'] = $this->admin_user['id'];
        }

        if(!empty($_GET['pid'])){
            $condition_user['package_id'] = intval($_GET['pid']);
        }

        $database_user = D('User');
        $database_store = D('Store');

        $count_user = $database_user->where($condition_user)->count();
        import('@.ORG.system_page');
        $p = new Page($count_user, 15);
        $user_list = $database_user->field(true)->where($condition_user)->order('`uid` DESC')->limit($p->firstRow . ',' . $p->listRows)->select();

        if (!empty($user_list)) {
            import('ORG.Net.IpLocation');
            $IpLocation = new IpLocation();
            foreach ($user_list as &$value) {
                $last_location = $IpLocation->getlocation(long2ip($value['last_ip']));
                $value['last_ip_txt'] = iconv('GBK', 'UTF-8', $last_location['country']) . iconv('GBK', 'UTF-8', $last_location['area']);
                $count = $database_store->where(array('uid' => $value['uid']))->count('store_id');
                $value['stores'] = $count;
                $fans_forever = D('StoreFansForever')->where(array('uid' => $value['uid']))->find();
                if (!empty($fans_forever)) {
                    $value['fans_forever'] = $fans_forever['status'];
                }
            }
        }
        $this->assign('user_list', $user_list);
        $pagebar = $p->show();
        $this->assign('pagebar', $pagebar);

        //店铺套餐权限
        $this->packagelist = M('Package')->field(array('pigcms_id','name','status'))->where('status=1')->select();

        $this->display();
    }

    public function edit() {
        $this->assign('bg_color', '#F3F3F3');

        $database_user = D('User');
        $condition_user['uid'] = intval($_GET['uid']);
        $now_user = $database_user->field(true)->where($condition_user)->find();
        if (empty($now_user)) {
            $this->frame_error_tips('没有找到该用户信息！');
        }
        $this->assign('now_user', $now_user);

        //店铺套餐权限
        $this->packagelist = M('Package')->field(array('pigcms_id','name','status'))->where('status=1')->select();

        $this->display();
    }

    public function amend() {
        if (IS_POST) {
            $database_user = D('User');
            $condition_user['uid'] = intval($_POST['uid']);
            $now_user = $database_user->field(true)->where($condition_user)->find();
            if (empty($now_user)) {
                $this->error('没有找到该用户信息！');
            }
            
            if (empty($_POST['nickname'])) {
            	$this->error('昵称不能为空！');
            }
            
            $condition_user['uid'] = $now_user['uid'];
            $data_user['phone'] = $_POST['phone'];
            $data_user['nickname'] = $_POST['nickname'];
            if ($_POST['pwd']) {
                $data_user['password'] = md5($_POST['pwd']);
            }
            $data_user['status'] = $_POST['status'];
            $data_user['intro'] = $_POST['intro'];
            $data_user['package_id'] = $_POST['pid'];

            //检测修改的手机号 是否已经有用户
            if ($database_user->where("uid != '" . $now_user['uid'] . "' and phone='" . $_POST['phone'] . "'")->find()) {
                $this->error("您提交的用户手机号 已被别的账号占用！请重新修改");
            } else {
                if ($database_user->where($condition_user)->data($data_user)->save()) {
                //更新套餐初始时间
                if($data_user['package_id'] > 0 && $data_user['package_id'] != $now_user['package_id']){
                   $data = array('expiration'=>time(),'is_available'=>1);
                   M('Store')->where(array('uid'=>$now_user['uid']))->setField($data);
                }    
                    $this->success('修改成功！');
                
                } else {
                    $this->error('修改失败！请重试。');
                }
            }
        } else {
            $this->error('非法访问！');
        }
    }

    //商家店铺
    public function stores() {
        $store = M('Store');
        $sale_category = M('SaleCategory');

        $uid = $this->_get('id');
        $tmp_stores = $store->field(array('store_id', 'uid', 'name', 'income', 'balance', 'unbalance', 'sale_category_id', 'status', "logo"))->where(array('uid' => $uid))->select();

        $stores = array();
        foreach ($tmp_stores as $store) {
            $category = $sale_category->where(array('cat_id' => $store['sale_category_id']))->getField('name');
            
            if (empty($store['logo'])) {
            	$store['logo'] = getAttachmentUrl('images/default_shop.png', false);
            } else {
            	$store['logo'] = getAttachmentUrl($store['logo']);
            }
            
            $stores[] = array(
                'store_id' => $store['store_id'],
                'uid' => $store['uid'],
                'name' => $store['name'],
                'logo' => $store['logo'],
                'sale_category' => $category,
                'income' => number_format($store['income'], 2, '.', ''),
                'balance' => number_format($store['balance'], 2, '.', ''),
                'unbalance' => number_format($store['unbalance'], 2, '.', ''),
                'status' => $store['status']
            );
        }

        $this->assign('stores', $stores);
        $this->display();
    }

    //切换店铺
    public function tab_store() {
        if (!$_SESSION['system']) {
            return;
        }

        // 禁止超级/普通管理员 以外的对象访问用户店铺
        // if (empty($this->admin_user) || in_array($this->admin_user['type'], array(2,3))) {
        //     $this->error($this->admin_user['type_name'].'没有访问店铺权限！');
        // }

        $uid = $this->_get('uid', 'trim,intval');
        if (!$uid) {
            $this->error('传递参数有误！');
        }
        $where['uid'] = $uid;
        $user_info = M('User')->where($where)->find();
        if (!$user_info) {
            $this->error('该用户不存在!');
        }

        $_SESSION['user'] = $user_info;
        unset($_SESSION['store']);
        redirect('/user.php?c=store&a=select');
    }
    
    
    //导出
    public function checkout() {
		//统计用户数量
		if(IS_AJAX) {
			$searchtype = $_POST['searchtype'];
			$start_time = $_POST['start_time'];
			$end_time = $_POST['end_time'];
			
			$database_user = D('User');
			if(!in_array($searchtype,array('0','1','2'))) {
				
				$return = array('code'=>'100','msg'=>'筛选用户类别不正确');
				echo json_encode($return);exit;
			}
			switch($searchtype) {
				case '1':
					$condition_user['phone'] = array('gt', '0');
					break;
				
				case '2':
					$condition_user['openid'] = array('gt', '0');
			}
			
			if(!empty($start_time) && !empty($end_time)) {
				$starttime = strtotime($start_time);
				$endtime = strtotime($end_time);
				$condition_user['reg_time'] = array('between',array($starttime,$endtime));
			}
			
			if(IS_POST) {
				$count_user = $database_user->where($condition_user)->count();
				$a = $database_user->getLastsql();
				$return = array('code'=>'0','msg'=>$count_user,'mmm'=>$a);
				echo json_encode($return);exit;
			} elseif(IS_GET){
				$user_arr = $database_user->where($condition_user)->select();
				$this->_download_csv_byuser($user_arr);
			}	
		} 

		$this->display();
    }
    
  //download2
	public function download_csv_byuser() {
	
		$searchtype = $_GET['searchtype'];
		$start_time = $_GET['start_time'];
		$end_time = $_GET['end_time'];
		$condition_user = array();
		if(!in_array($searchtype,array('0','1','2'))) {
		
			$return = array('code'=>'100','msg'=>'筛选用户类别不正确');
			echo json_encode($return);exit;
		}
		switch($searchtype) {
			case '1':
				$condition_user['phone'] = array('gt', '0');
				break;
				 
			case '2':
				$condition_user['openid'] = array('gt', '0');
				break;
		
		}
		
		if(!empty($start_time) && !empty($end_time)) {
			$starttime = strtotime($start_time);
			$endtime = strtotime($end_time);
			$condition_user['reg_time'] = array('between',array($start_time,$end_time));
		}
		 
		$user_arr = D('User')->where($condition_user)->select();

		include 'source/class/execl.class.php';
		$execl = new execl();
		

		//$array = array('用户uid','用户昵称','用户手机号','是否微信用户','注册ip','注册时间','最后登陆时间','店铺数量','登录次数');
		//$execl->addHeader($array);
		$filename = date("用户信息_YmdHis",time()).'.xls';
		header ( 'Content-Type: application/vnd.ms-excel' );
		header ( "Content-Disposition: attachment;filename=$filename" );	
		header ( 'Cache-Type: charset=gb2312');		
		echo "<style>table td{border:1px solid #ccc;}</style>";
		echo "<table>";
		//dump($user_arr);
		echo '	<tr>';
		echo ' 		<th><b> 用户uid </b></th>';
		echo ' 		<th><b> 用户昵称 </b></th>';
		echo ' 		<th><b> 用户手机号 </b></th>';
		echo ' 		<th><b> 是否微信用户 </b></th>';
		echo ' 		<th><b> 注册ip </b></th>';
		echo ' 		<th><b> 注册时间 </b></th>';
		echo ' 		<th><b> 最后登陆时间 </b></th>';
		echo ' 		<th><b> 店铺数量 </b></th>';
		echo ' 		<th><b> 登录次数 </b></th>';
		echo '	</tr>';
		
    	foreach ($user_arr as $k => $v) {
			echo '	<tr>';
			echo ' 		<td align="center">' . $v['uid'] . '</td>';
			echo ' 		<td align="center">' . $v['nickname'] . '</td>';
			echo ' 		<td align="center">' . $v['phone'] . '</td>';
			if($v['is_weixin']=='1') {$is_weixin = "是";}else {$is_weixin = "否";}
			echo ' 		<td align="center">' . $is_weixin. '</td>';
			echo ' 		<td align="center">' . long2ip($v['reg_ip']) . '</td>';
			echo ' 		<td align="center">' . date("Y-m-d H:i:s",$v['reg_time']) . '</td>';
			echo ' 		<td align="center">' . date("Y-m-d H:i:s",$v['last_time']) . '</td>';
			echo ' 		<td align="center">' . $v['stores'] . '</td>';
			echo ' 		<td align="center">' . $v['login_count'] . '</td>';
			echo '	</tr>';
		}
		echo '</table>';
	}

    // 添加用户关联代理商
    public function agent_invite () {

        // 限制权限
        if ($this->admin_user['type'] == 2 || $this->admin_user['type'] == 3) {
            $this->frame_error_tips("区域管理或客户经理(代理商)无修改权限");
        }

        $database_user = D("User");
        $database_admin = D("Admin");
        $database_agent_invite = D("Agent_invite");

        if (IS_POST) {

            $uid = isset($_POST['uid']) ? intval($_POST['uid']) : 0;
            $data['invite_admin'] = isset($_POST['invite_admin']) ? intval($_POST['invite_admin']) : 0;

            if (empty($data['invite_admin'])) {
                $this->frame_error_tips("缺少客户经理(代理商)id");
            }

            $result = $database_user->where(array('uid'=>$uid))->data($data)->save();
            if ($result) {
                D("Admin")->saveAgentUserRecord($uid, $data['invite_admin'], $this->admin_user['id']);
                $this->success("修改成功");
            }

            $this->error("修改失败，请修改后再试");

        } else {

            $uid = isset($_GET['uid']) ? intval($_GET['uid']) : 0;

            if (empty($uid) || !$user = $database_user->where(array('uid'=>$uid))->find()) {
                $this->frame_error_tips("用户参数错误");
            }

            $agent_list = $database_admin->where(array('type'=>3))->select();
            if (empty($agent_list)) {
                $this->frame_error_tips("缺少客户经理(代理商)，请先创建");
            }

            $this->assign('agent_list', $agent_list);
            $this->assign('user', $user);
            $this->display();
        }
    }

    // 将用户导入到UCenter
    function ImportUser_to_ucenter(){
        if(!C('config.ucenter_setting')){
            exit('未开启UCenter');
        }
        $page = max(1,$_GET['page']);
        $offset = 50;
        $count_user = D('User')->count();
        import('@.ORG.system_page');
        $p = new Page($count_user, $offset,$page);
        $user_list = D('User')->field('phone,password,reg_time')->order('`uid` asc')->limit($p->firstRow . ',' . $p->listRows)->select();

        // 连接UCenter数据库
        $dbhost = C('config.ucenter_dbhost');               // 数据库服务器
        $dbuser = C('config.ucenter_dbuser');               // 数据库用户名
        $dbpw = C('config.ucenter_pwd');                    // 数据库密码
        $dbname = C('config.ucenter_dbname');               // 数据库名
        $pconnect = 0;                                      // 数据库持久连接 0=关闭, 1=打开
        $tablepre = C('config.ucenter_dbtablepre');         // 表名前缀, 同一数据库安装多个论坛请修改此处
        $dbcharset = C('config.ucenter_dbcharset');
        include_once PIGCMS_PATH.'include/db_mysql.class.php';
        $db = new dbstuff;
        $db->connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
        unset($dbhost, $dbuser, $dbpw, $dbname, $pconnect);  
        foreach($user_list as $user){
            if($user['phone']==''||$user['password']==''){
                continue;
            }
            $remote_user = $db->fetch_first("SELECT * FROM ".$tablepre."members WHERE username='".$user['phone']."'");
            if(!$remote_user){
                $db->query("INSERT INTO ".$tablepre."members SET username='".$user['phone']."', password='".md5($user['password'])."', regdate='".$user['reg_time']."'");
            }
        }
        if(!$user_list || $offset*$page >= $count_user){
            $this->success('导入完成','/admin.php?c=Config&a=index');
            exit;
        }
        $page++;
        $response = '<div style="text-align:center;margin-top:20px;"><h2>正在导入第'.$page.'页</h2></div>'.'<script type="text/javascript">setTimeout(function(){window.location.href="/admin.php?c=User&a=ImportUser_to_ucenter&page='.$page.'";},1000);</script>';
        echo $response;
    }

    public function fans_forever()
    {
        $uid = $this->_post('id', 'intval');
        $status = $this->_post('status', 'intval');
        D('Store_fans_forever')->where(array('uid' => $uid))->data(array('status' => $status))->save();
    }

}