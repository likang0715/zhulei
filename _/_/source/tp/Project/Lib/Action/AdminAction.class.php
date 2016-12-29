<?php

/**
 * 管理员管理
 * User: pigcms_89
 * Date: 2016/01/21
 * Time: 17:26
 */
class AdminAction extends BaseAction {

	protected function _initialize () {

		parent::_initialize();

		$action = ACTION_NAME;
		// $module = MODULE_NAME;
		
		// 代理商限制
		if ($this->admin_user['type'] == 3 && $action != 'agentcode') {
			$this->frame_error_tips("没有权限");
		}
		
		// 普通管理员限制
		if ($this->admin_user['type'] == 1) {	//禁止访问
			$filter_action = array(
				'index',
				'admin_add',
				'admin_edit',
				'group',
				'group_add',
				'group_edit',
				'group_access',
				'group_del',
				'area_rbac',
				'agent_rbac',
				'bonus_config',
				'agent_invite',
			);

			if (in_array($action, $filter_action)) {
				$this->frame_error_tips("没有权限");
			}
		}

		// 区县级区域管理员限制 - 修改为不允许修改 区域管理员|代理商
		if ($this->admin_user['type'] == 2) {	// 允许访问

			if ($this->admin_user['area_level'] == 3) {		
				$filter_action = array(
						'agent',
					);

			} else {
				$filter_action = array(
						'area',
						'agent',
					);

			}

			if (!in_array($action, $filter_action)) {
				$this->frame_error_tips("没有权限");
			}
		}


	}

	// 管理员列表
	public function index () {

		//搜索
		if (!empty($_GET['keyword'])) {
			if ($_GET['searchtype'] == 'id') {
				$condition_admin['id'] = $_GET['keyword'];
			} else if ($_GET['searchtype'] == 'account') {
				$condition_admin['account'] = array('like', '%' . $_GET['keyword'] . '%');
			}
		}

		$condition_admin['type'] = 1;

		$admin_result = D('Admin')->getList($condition_admin);

		$this->assign('admin_type_list', D('AdminGroup')->getAdminType());
		$this->assign('admin_list', $admin_result['list']);
		$pagebar = $admin_result['page']->show();
		$this->assign('pagebar', $pagebar);
		
		$this->display();
	}

	// 管理员添加
	public function admin_add () {

		if (IS_POST) {

			$database_admin = D('Admin');

			$data = array();
			$data['group_id'] = isset($_POST['group_id']) ? intval($_POST['group_id']) : 0;
			$data['account'] = isset($_POST['account']) ? htmlspecialchars($_POST['account']) : '';
			$data['pwd'] = isset($_POST['pwd']) ? $_POST['pwd'] : '';
			$data['repwd'] = isset($_POST['repwd']) ? $_POST['repwd'] : '';
			
			$data['status'] = isset($_POST['status']) ? intval($_POST['status']) : 0;
			$data['realname'] = isset($_POST['realname']) ? htmlspecialchars($_POST['realname']) : '';
			$data['phone'] = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '';
			$data['email'] = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
			$data['qq'] = isset($_POST['qq']) ? htmlspecialchars($_POST['qq']) : '';

			$data['type'] = 1;

			if (empty($data['group_id'])) {
				$this->error('请选择管理员组');
			}

			if (empty($data['account'])) {
				$this->error('缺少管理员名称');
			}

			if ($database_admin->where(array('account'=>$data['account']))->find()) {
				$this->error('用户名已经使用');
			}

			if (empty($data['pwd']) || empty($data['repwd'])) {
				$this->error('用户名密码未填写');
			}

			if ($data['pwd'] != $data['repwd']) {
				$this->error('重复密码错误');	//TODO?
			}

			$data['creator'] = $this->admin_user['id'];
			$data['pwd'] = md5($data['pwd']);
			if (D("Admin")->add($data)) {
				$this->success('添加成功');
			} else {
				$this->error('添加失败，稍后再试');
			}

		} else {

			$database_admin_group = D('Admin_group');

			// 管理员权限组
			$admin_group_list = $database_admin_group->where(array("status"=>1))->select();
			if (count($admin_group_list) < 1) {
				$this->frame_error_tips('请先添加管理员组');
			}

			$this->assign('group_list', $admin_group_list);
			$this->display();
		}
	}

	// 管理员编辑
	public function admin_edit () {

		if (IS_POST) {

			$database_admin = D('Admin');

			if ($this->admin_user['type'] != 0) {
				$this->error("没有修改权限");
			}

			$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

			$data = array();
			$data['group_id'] = isset($_POST['group_id']) ? intval($_POST['group_id']) : 0;
			$data['account'] = isset($_POST['account']) ? htmlspecialchars($_POST['account']) : '';
			$data['pwd'] = isset($_POST['pwd']) ? $_POST['pwd'] : '';
			
			$data['status'] = isset($_POST['status']) ? intval($_POST['status']) : 0;
			$data['realname'] = isset($_POST['realname']) ? htmlspecialchars($_POST['realname']) : '';
			$data['phone'] = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '';
			$data['email'] = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
			$data['qq'] = isset($_POST['qq']) ? htmlspecialchars($_POST['qq']) : '';

			$data['type'] = 1;

			if (empty($id) || !$admin = D('Admin')->where(array('id'=>$id, 'type'=>1))->find()) {
				$this->error('未找到该用户');
			}

			if (empty($data['group_id'])) {
				$this->error('请选择管理员组');
			}

			if (empty($data['account'])) {
				$this->error('缺少管理员名称');
			}

			if ($database_admin->where("`account` = '".$data['account']."' && `id` != $id")->find()) {
				$this->error('用户名已经被使用');
			}

			if (!empty($data['pwd'])) {
				$data['pwd'] = md5($data['pwd']);
			} else {
				unset($data['pwd']);
			}

			if ($database_admin->where(array('id'=>$id))->data($data)->save()) {
				$this->success("修改成功");
			} else {
				$this->error("修改失败，稍后再试");
			}

		} else {

			if ($this->admin_user['type'] != 0) {
				$this->frame_error_tips("没有修改权限");
			}

			$database_admin_group = D('Admin_group');
			$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

			if (empty($id) || !$admin = D('Admin')->where(array('id'=>$id, 'type'=>1))->find()) {
				$this->frame_error_tips('未找到该用户');
			}

			$admin_group_list = $database_admin_group->select();
			if (count($admin_group_list) < 1) {
				$this->frame_error_tips('请先添加管理员组');
			}

			$this->assign('admin', $admin);
			$this->assign('group_list', $admin_group_list);
			$this->display();
		}
	}

	// 管理员组列表
	public function group () {

		//搜索
		if (!empty($_GET['keyword'])) {
			if ($_GET['searchtype'] == 'id') {
				$condition_group['id'] = $_GET['keyword'];
			} else if ($_GET['searchtype'] == 'name') {
				$condition_group['name'] = array('like', '%' . $_GET['keyword'] . '%');
			}
		}
		
		$database_admin = D('Admin');
		$database_admin_group = D('Admin_group');

		$count_group = $database_admin_group->where($condition_group)->count();
		import('@.ORG.system_page');
		$p = new Page($count_group, 15);
		$group_list = $database_admin_group->field(true)->where($condition_group)->order('`id` DESC')->limit($p->firstRow . ',' . $p->listRows)->select();

		foreach ($group_list as &$value) {
			$count = $database_admin->where(array('group_id'=>$value['id']))->count("id");
			$value['count'] = $count;
		}

		$this->assign('group_list', $group_list);
		$pagebar = $p->show();
		$this->assign('pagebar', $pagebar);
		
		$this->display();
	}

	// 管理员组添加
	public function group_add () {

		if (IS_POST) {

			$database_admin_group = D('Admin_group');

			$data = array();
			$data['name'] = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
			$data['remark'] = isset($_POST['remark']) ? htmlspecialchars($_POST['remark']) : '';
			$data['status'] = isset($_POST['status']) ? intval($_POST['status']) : 0;

			if (empty($data['name'])) {
				$this->error('缺少组名');
			}

			if ($database_admin_group->where(array('name'=>$data['name']))->find()) {
				$this->error('该组名已经被使用');
			}

			$data['add_time'] = time();

			if ($database_admin_group->add($data)) {
				$this->success('添加成功');
			} else {
				$this->error('添加失败，稍后再试');
			}

		} else {
			$this->display();
		}
	}


	// 管理员组编辑
	public function group_edit () {
		if (IS_POST) {

			$database_admin_group = D('Admin_group');

			$condition_group['id'] = isset($_POST['id']) ? intval($_POST['id']) : 0;

			$data = array();
			$data['name'] = isset($_POST['name']) ? trim($_POST['name']) : '';
			$data['remark'] = isset($_POST['remark']) ? htmlspecialchars($_POST['remark']) : '';
			$data['status'] = isset($_POST['status']) ? intval($_POST['status']) : 0;

			$admin_group = $database_admin_group->where($condition_group)->find();
			if (empty($admin_group)) {
				$this->error('未找到该组');
			}

			if ($database_admin_group->where("`id` != ".$condition_group['id']." AND `name` = '".$data['name']."'")->find()) {
				$this->error('该组名已经被使用');
			}

			$data['update_time'] = time();
			if ($database_admin_group->where($condition_group)->data($data)->save()) {
				$this->success("修改成功");
			} else {
				$this->error("修改失败，稍后再试");
			}

		} else {

			$database_admin_group = D('Admin_group');

			$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
			if (empty($id)) {
				$this->frame_error_tips('缺少参数');
			}

			$admin_group = $database_admin_group->where(array('id'=>$id))->find();
			if (empty($admin_group)) {
				$this->frame_error_tips('该组不存在');
			}

			$this->assign('group', $admin_group);
			$this->display();
		}
	}

	// 组可显示列表
	public function group_menu () {

		$database_system_menu = D('System_menu');
		$database_admin_group = D('Admin_group');

		if (IS_POST) {

			$group_id = isset($_POST['id']) ? intval($_POST['id']) : 0;
			$menu = isset($_POST['menu']) ? $_POST['menu'] : array();

			if (empty($group_id) || !$admin_group = $database_admin_group->where(array("id"=>$group_id))->find()) {
				$this->error("未找到该组");
			}

			// 以存在的system_menu过滤
			$condition_system_menu = array(
				'status' => 1,
				'show' => 1,
				'is_admin' => 0,
			);
			$menu_list = $database_system_menu->field(true)->where($condition_system_menu)->order('`sort` DESC,`fid` ASC,`id` ASC')->select();

			$menu_filter = array();
			foreach ($menu_list as $val) {
				$menu_filter[] = $val['id'];
			}

			$change_menu = array_intersect($menu_filter, $menu);

			$data = array(
					'menu_ids' => '',
				);

			if (!empty($change_menu)) {
				$data['menu_ids'] = implode(',', $menu);
			}

			if ($database_admin_group->where(array('id'=>$group_id))->data($data)->save()) {
				$this->success("修改成功");
			} else {
				$this->frame_error_tips("请做出修改再提交");
			}

		} else {

			$group_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

			if (empty($group_id) || !$admin_group = $database_admin_group->where(array("id"=>$group_id))->find()) {
				$this->error("未找到该组");
			}

			$all_filter = array();

			// 准备当前group_menu
			$group_menu_list = !empty($admin_group['menu_ids']) ? explode(',', $admin_group['menu_ids']) : array();
			foreach ($group_menu_list as $val) {
				$all_filter[] = $val;
			}

			// 准备系统menu记录
			$condition_system_menu = array(
				'status' => 1,
				'show' => 1,
				'is_admin' => 0,
			);

			$menu_list = $database_system_menu->field(true)->where($condition_system_menu)->order('`sort` DESC,`fid` ASC,`id` ASC')->select();
			foreach ($menu_list as $key => $value) {
				if ($value['fid'] == 0) {
					$system_menu[$value['id']] = $value;
				} else {
					$system_menu[$value['fid']]['menu_list'][] = $value;
				}
			}

			$this->assign('all_filter', $all_filter);
			$this->assign('system_menu', $system_menu);
			$this->assign('group', $admin_group);

			$this->display();

		}

	}

	// 组权限修改 - TODO
	public function group_access () {

		$database_admin_rbac = D('Admin_rbac');
		$database_system_rbac_menu = D('System_rbac_menu');
		$database_admin_group = D('Admin_group');

		if (IS_POST) {

			$group_id = isset($_POST['id']) ? intval($_POST['id']) : 0;
			$data['pid'] = isset($_POST['pid']) ? $_POST['pid'] : array();
			$data['cid'] = isset($_POST['cid']) ? $_POST['cid'] : array();

			// 以存在的system_menu过滤
			$rbac_menu_list = $database_system_rbac_menu->field(true)->where(array('status'=>1))->order('`sort` DESC,`fid` ASC,`id` ASC')->select();

			$pid_filter = array();
			$cid_filter = array();
			foreach ($rbac_menu_list as $val) {
				if ($val['fid'] == 0) {
					$pid_filter[] = $val['module']."@".$val['id'];
				} else {
					$cid_filter[] = $val['module']."@".$val['action']."@".$val['id'];
				}
			}

			$change_pid = array_intersect($pid_filter, $data['pid']);
			$change_cid = array_intersect($cid_filter, $data['cid']);

			// 删除原先
			$database_admin_rbac->where(array('group_id'=>$group_id))->delete();

			// 添加rbac记录
			$time = time();

			foreach ($change_pid as $val) {

				$tmp_pid = explode("@", $val);
				$pid_data['group_id'] = $group_id;
				$pid_data['module'] = $tmp_pid[0];
				$pid_data['menu_id'] = $tmp_pid[1];
				$pid_data['is_module'] = 1;
				$pid_data['add_time'] = $time;

				$database_admin_rbac->data($pid_data)->add();
			}

			foreach ($change_cid as $val) {

				$tmp_cid = explode("@", $val);
				$cid_data['group_id'] = $group_id;
				$cid_data['module'] = $tmp_cid[0];
				$cid_data['action'] = $tmp_cid[1];
				$cid_data['menu_id'] = $tmp_cid[2];
				$cid_data['add_time'] = $time;

				$database_admin_rbac->data($cid_data)->add();
			}

			$this->success("权限修改成功");

		} else {

			$group_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

			if (empty($group_id) || !$admin_group = $database_admin_group->where(array("id"=>$group_id))->find()) {
				$this->error("未找到该组");
			}

			$all_filter = array();

			// 准备当前rbac记录
			$admin_rbac_list = $database_admin_rbac->where(array('group_id'=>$group_id))->select();
			foreach ($admin_rbac_list as $val) {
				$all_filter[] = $val['menu_id'];
			}

			// 准备系统rbac menu记录
			$menu_list = $database_system_rbac_menu->field(true)->where(array('status'=>1))->order('`sort` DESC,`fid` ASC,`id` ASC')->select();
			foreach ($menu_list as $key => $value) {
				if ($value['fid'] == 0) {
					$tmp_value = $value;
					$tmp_value['implode_val'] = $value['module']."@".$value['id'];
					$system_menu[$value['id']] = $tmp_value;
				} else {
					$tmp_value = $value;
					$tmp_value['implode_val'] = $value['module']."@".$value['action']."@".$value['id'];
					$system_menu[$value['fid']]['menu_list'][] = $tmp_value;

				}
			}

			$this->assign('all_filter', $all_filter);
			$this->assign('system_menu', $system_menu);
			$this->assign('group', $admin_group);

			$this->display();
		}
	}

	// 删除组
	public function group_del () {

		$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
		$count = M('Admin')->where(array('group_id'=>$id))->count();

		if (empty($count)) {
			$back = D('Admin_group')->where(array('id' => $id))->delete();
			if ($back == true) {
				$this->success('删除成功');
			} else {
				$this->error('删除失败' . $this->_get('id'));
			}
		} else {
			$this->error('请先移除该组下管理员');
		}

	}

	// 区域管理员列表
	public function area () {

		//搜索
		if (!empty($_GET['keyword'])) {
			if ($_GET['searchtype'] == 'id') {
				$condition_admin['id'] = $_GET['keyword'];
			} else if ($_GET['searchtype'] == 'account') {
				$condition_admin['account'] = array('like', '%' . $_GET['keyword'] . '%');
			}
		}

		// 登录者为区域管理员
		if ($this->admin_user['area_level'] == 1) {				//省级
			$condition_admin['province'] = $this->admin_user['province'];
			$condition_admin['area_level'] = array('gt', 1);
		} else if ($this->admin_user['area_level'] == 2) {		//市级
			$condition_admin['province'] = $this->admin_user['province'];
			$condition_admin['city'] = $this->admin_user['city'];
			$condition_admin['area_level'] = array('gt', 2);
		}

		if (!empty($_GET['area_level']) && $this->admin_user['type'] != 2) {
			$condition_admin['area_level'] = $_GET['area_level'];
		}
		
		$condition_admin['type'] = 2;
		$admin_result = D('Admin')->getList($condition_admin);

		$this->assign('admin_type_list', D('AdminGroup')->getAdminType());
		$this->assign('admin_list', $admin_result['list']);
		$pagebar = $admin_result['page']->show();
		$this->assign('pagebar', $pagebar);
		
		$this->display();
	}

	// 区域管理员添加
	public function area_add () {

		if (IS_POST) {

			$database_admin = D('Admin');

			$data = array();
			$data['account'] = isset($_POST['account']) ? htmlspecialchars($_POST['account']) : '';
			$data['pwd'] = isset($_POST['pwd']) ? $_POST['pwd'] : '';
			$data['repwd'] = isset($_POST['repwd']) ? $_POST['repwd'] : '';
			$data['status'] = isset($_POST['status']) ? intval($_POST['status']) : 0;
			$data['group_id'] = isset($_POST['group_id']) ? intval($_POST['group_id']) : 0;
			
			$data['realname'] = isset($_POST['realname']) ? htmlspecialchars($_POST['realname']) : '';
			$data['phone'] = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '';
			$data['email'] = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
			$data['qq'] = isset($_POST['qq']) ? htmlspecialchars($_POST['qq']) : '';

			$data['type'] = 2;

			$data['area_level'] = isset($_POST['area_level']) ? intval($_POST['area_level']) : 0;
			$data['province'] = isset($_POST['province']) ? htmlspecialchars($_POST['province']) : '';
			$data['city'] = isset($_POST['city']) ? htmlspecialchars($_POST['city']) : '';
			$data['county'] = isset($_POST['county']) ? htmlspecialchars($_POST['county']) : '';

			// 区域管理员登录
			if ($this->admin_user['type'] == 2) {

				if ($this->admin_user['area_level'] == 1) {				//当前省级 创建市/区县级别
					(!empty($data['province']) && $data['province'] != $this->admin_user['province']) ? $this->error("不能修改下属的省份") : true;
					$data['province'] = $this->admin_user['province'];

				} else if ($this->admin_user['area_level'] == 2) {		//当前市级 区县级别
					(!empty($data['province']) && $data['province'] != $this->admin_user['province']) ? $this->error("不能修改下属的省份") : true;
					(!empty($data['city']) && $data['city'] != $this->admin_user['city']) ? $this->error("不能修改下属的城市") : true;
					$data['province'] = $this->admin_user['province'];
					$data['city'] = $this->admin_user['city'];

				}

			}

			if (empty($data['area_level'])) {
				$this->error('缺少区域等级');
			}

			if (empty($data['group_id'])) {
				$this->error('请选择管理员组');
			}

			if ($data['area_level'] > 0) {
				if (empty($data['province'])) {
					$this->error('缺少省份信息');
				}
			}

			if ($data['area_level'] > 1) {
				if (empty($data['city'])) {
					$this->error('缺少市区信息');
				}
			}

			if ($data['area_level'] > 2) {
				if (empty($data['county'])) {
					$this->error('缺少区县信息');
				}
			}

			if (empty($data['account'])) {
				$this->error('缺少管理员名称');
			}

			if ($database_admin->where(array('account'=>$data['account']))->find()) {
				$this->error('用户名已经使用');
			}

			switch ($data['area_level']) {
				case 1:
					$condition_area = array(
							'area_level' => 1,
							'province' => $data['province'],
						);
					break;
				case 2:
					$condition_area = array(
							'area_level' => 2,
							'province' => $data['province'],
							'city' => $data['city'],
						);
					break;
				case 3:
					$condition_area = array(
							'area_level' => 3,
							'province' => $data['province'],
							'city' => $data['city'],
							'county' => $data['county'],
						);
					break;
			}

			// 检测同一等级，同区域是否已经有区域管理员
			if ($database_admin->where($condition_area)->find()) {
				$this->error('该区域已经存在区域管理员');
			}

			if (empty($data['pwd']) || empty($data['repwd'])) {
				$this->error('用户名密码未填写');
			}

			if ($data['pwd'] != $data['repwd']) {
				$this->error('重复密码错误');
			}

			if (empty($data['phone'])) {
				$this->error('缺少手机号码');
			}

			$data['pwd'] = md5($data['pwd']);
			$data['creator'] = $this->admin_user['id'];

            if($_FILES['pic']['error'] != 4){
                //上传图片
                $rand_num = date('Y/m',$_SERVER['REQUEST_TIME']);
                $upload_dir = './upload/adver/'.$rand_num.'/';
                if(!is_dir($upload_dir)){
                    mkdir($upload_dir,0777,true);
                }
                import('ORG.Net.UploadFile');
                $upload = new UploadFile();
                $upload->maxSize = 10*1024*1024;
                $upload->allowExts = array('jpg','jpeg','png','gif');
                $upload->allowTypes = array('image/png','image/jpg','image/jpeg','image/gif');
                $upload->savePath = $upload_dir;
                $upload->saveRule = 'uniqid';
                if($upload->upload()){
                    $uploadList = $upload->getUploadFileInfo();

                    $attachment_upload_type = C('config.attachment_upload_type');
                    // 上传到又拍云服务器
                    if ($attachment_upload_type == '1') {
                        import('upyunUser', './source/class/upload/');
                        upyunUser::upload('./upload/adver/' . $rand_num.'/'.$uploadList[0]['savename'], '/adver/' . $rand_num.'/'.$uploadList[0]['savename']);
                    }

                    $data['avatar'] = 'adver/' . $rand_num.'/'.$uploadList[0]['savename'];
                }else{
                    $this->error($upload->getErrorMsg());
                }
            }

			if (D("Admin")->add($data)) {
                $this->frame_submit_tips(1,'添加成功');
			} else {
                $this->frame_submit_tips(0,'添加失败，稍后再试');
			}

		} else {

			$area_level_list = array(
				array('id' => 1, 'name' => '省级'),
				array('id' => 2, 'name' => '市级'),
				array('id' => 3, 'name' => '区县级'),
			);

			if ($this->admin_user['type'] == 2 && $this->admin_user['area_level'] == 1) {
				$area_level_list = array(
					array('id' => 2, 'name' => '市级'),
					array('id' => 3, 'name' => '区县级'),
				);

			} else if ($this->admin_user['type'] == 2 && $this->admin_user['area_level'] == 2) {
				$area_level_list = array(
					array('id' => 3, 'name' => '区县级'),
				);
			}

			$database_admin_group = D('Admin_group');

			// 管理员权限组
			$admin_group_list = $database_admin_group->where(array("status"=>1))->select();
			if (count($admin_group_list) < 1) {
				$this->frame_error_tips('请先添加管理员组');
			}

			$this->assign('group_list', $admin_group_list);
			$this->assign('area_level_list', $area_level_list);
			$this->display();
		}
	}

	// 编辑区域管理员
	public function area_edit () {

		if (IS_POST) {

			$database_admin = D('Admin');

			$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

			$data = array();
			$data['account'] = isset($_POST['account']) ? htmlspecialchars($_POST['account']) : '';
			$data['pwd'] = isset($_POST['pwd']) ? $_POST['pwd'] : '';
			$data['status'] = isset($_POST['status']) ? intval($_POST['status']) : 0;
			$data['group_id'] = isset($_POST['group_id']) ? intval($_POST['group_id']) : 0;
			
			$data['realname'] = isset($_POST['realname']) ? htmlspecialchars($_POST['realname']) : '';
			$data['phone'] = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '';
			$data['email'] = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
			$data['qq'] = isset($_POST['qq']) ? htmlspecialchars($_POST['qq']) : '';

			$data['type'] = 2;

			$data['area_level'] = isset($_POST['area_level']) ? intval($_POST['area_level']) : 0;
			$data['province'] = isset($_POST['province']) ? htmlspecialchars($_POST['province']) : '';
			$data['city'] = isset($_POST['city']) ? htmlspecialchars($_POST['city']) : '';
			$data['county'] = isset($_POST['county']) ? htmlspecialchars($_POST['county']) : '';

			// 区域管理员登录
			if ($this->admin_user['type'] == 2) {

				if ($this->admin_user['area_level'] == 1) {				//当前省级 创建市/区县级别
					(!empty($data['province']) && $data['province'] != $this->admin_user['province']) ? $this->error("不能修改下属的省份") : true;
					$data['province'] = $this->admin_user['province'];

				} else if ($this->admin_user['area_level'] == 2) {		//当前市级 区县级别
					(!empty($data['province']) && $data['province'] != $this->admin_user['province']) ? $this->error("不能修改下属的省份") : true;
					(!empty($data['city']) && $data['city'] != $this->admin_user['city']) ? $this->error("不能修改下属的城市") : true;
					$data['province'] = $this->admin_user['province'];
					$data['city'] = $this->admin_user['city'];
				}

			}

			if (empty($data['area_level'])) {
				$this->error('缺少区域等级');
			}

			if (empty($data['group_id'])) {
				$this->error('请选择管理员组');
			}

			if ($data['area_level'] > 0) {
				if (empty($data['province'])) {
					$this->error('缺少省份信息');
				}
			}

			if ($data['area_level'] > 1) {
				if (empty($data['city'])) {
					$this->error('缺少市区信息');
				}
			}

			if ($data['area_level'] > 2) {
				if (empty($data['county'])) {
					$this->error('缺少区县信息');
				}
			}

			if (empty($data['account'])) {
				$this->error('缺少管理员名称');
			}

			if ($database_admin->where("`account` = '".$data['account']."' && `id` != $id")->find()) {
				$this->error('用户名已经使用');
			}

			if (empty($data['phone'])) {
				$this->error('缺少手机号码');
			}

			switch ($data['area_level']) {
				case 1:
					$condition_area = "`area_level` = 1 AND `province` = '".$data['province']."' AND `id` != $id";
					break;
				case 2:
					$condition_area = "`area_level` = 2 AND `province` = '".$data['province']."' AND `city` = '".$data['city']."' AND `id` != $id";
					break;
				case 3:
					$condition_area = "`area_level` = 3 AND `province` = '".$data['province']."' AND `city` = '".$data['city']."' AND `county` = '".$data['county']."' AND `id` != $id";
					break;
			}

			// 检测同一等级，同区域是否已经有区域管理员
			if ($database_admin->where($condition_area)->find()) {
				$this->error('该区域已经存在区域管理员');
			}

			if (!empty($data['pwd'])) {
				$data['pwd'] = md5($data['pwd']);
			} else {
				unset($data['pwd']);
			}

            if($_FILES['pic']['error'] != 4){
                //上传图片
                $rand_num = date('Y/m',$_SERVER['REQUEST_TIME']);
                $upload_dir = './upload/adver/'.$rand_num.'/';
                if(!is_dir($upload_dir)){
                    mkdir($upload_dir,0777,true);
                }
                import('ORG.Net.UploadFile');
                $upload = new UploadFile();
                $upload->maxSize = 10*1024*1024;
                $upload->allowExts = array('jpg','jpeg','png','gif');
                $upload->allowTypes = array('image/png','image/jpg','image/jpeg','image/gif');
                $upload->savePath = $upload_dir;
                $upload->saveRule = 'uniqid';
                if($upload->upload()){
                    $uploadList = $upload->getUploadFileInfo();

                    $attachment_upload_type = C('config.attachment_upload_type');
                    // 上传到又拍云服务器
                    if ($attachment_upload_type == '1') {
                        import('upyunUser', './source/class/upload/');
                        upyunUser::upload('./upload/adver/' . $rand_num.'/'.$uploadList[0]['savename'], '/adver/' . $rand_num.'/'.$uploadList[0]['savename']);
                    }

                    $data['avatar'] = 'adver/' . $rand_num.'/'.$uploadList[0]['savename'];
                }else{
                    $this->error($upload->getErrorMsg());
                }
            }

			if (D("Admin")->where(array('id'=>$id))->data($data)->save()) {
                $this->frame_submit_tips(1,'修改成功~');
			} else {
                $this->frame_submit_tips(0,'修改失败！请重试~');
			}

		} else {

			$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
			
			$area_level_list = array(
				array('id' => 1, 'name' => '省级'),
				array('id' => 2, 'name' => '市级'),
				array('id' => 3, 'name' => '区县级'),
			);

			// 判断是否 可以编辑
			$condition_admin = array('id'=>$id, 'type'=>2);
			if ($this->admin_user['type'] == 2 && $this->admin_user['area_level'] == 1) {

				$condition_admin['province'] = $this->admin_user['province'];
				$area_level_list = array(
					array('id' => 2, 'name' => '市级'),
					array('id' => 3, 'name' => '区县级'),
				);

			} else if ($this->admin_user['type'] == 2 && $this->admin_user['area_level'] == 2) {

				$condition_admin['province'] = $this->admin_user['province'];
				$condition_admin['city'] = $this->admin_user['city'];
				$area_level_list = array(
					array('id' => 3, 'name' => '区县级'),
				);

			}

			if (empty($id) || !$admin = D('Admin')->where($condition_admin)->find()) {
				$this->frame_error_tips('未找到该用户');
			}
            $admin['avatar'] = getAttachmentUrl($admin['avatar']);

			$database_admin_group = D('Admin_group');
			$admin_group_list = $database_admin_group->select();
			if (count($admin_group_list) < 1) {
				$this->frame_error_tips('请先添加管理员组');
			}

			$this->assign('admin', $admin);
			$this->assign('group_list', $admin_group_list);
			$this->assign('area_level_list', $area_level_list);
			$this->display();
		}
	}

	// 代理商列表
	public function agent () {

		//搜索
		if (!empty($_GET['keyword'])) {
			if ($_GET['searchtype'] == 'id') {
				$condition_admin['id'] = $_GET['keyword'];
			} else if ($_GET['searchtype'] == 'account') {
				$condition_admin['account'] = array('like', '%' . $_GET['keyword'] . '%');
			}
		}
		
		$condition_admin['type'] = 3;
		$admin_result = D('Admin')->getList($condition_admin);

		$this->assign('admin_type_list', D('AdminGroup')->getAdminType());
		$this->assign('admin_list', $admin_result['list']);
		$pagebar = $admin_result['page']->show();
		$this->assign('pagebar', $pagebar);
		
		$this->display();

	}

	// 添加代理商
	public function agent_add () {

		if (IS_POST) {

			$database_admin = D('Admin');

			$data = array();
			$data['account'] = isset($_POST['account']) ? htmlspecialchars($_POST['account']) : '';
			$data['pwd'] = isset($_POST['pwd']) ? $_POST['pwd'] : '';
			$data['repwd'] = isset($_POST['repwd']) ? $_POST['repwd'] : '';
			$data['status'] = isset($_POST['status']) ? intval($_POST['status']) : 0;
			
			$data['group_id'] = isset($_POST['group_id']) ? intval($_POST['group_id']) : 0;
			$data['realname'] = isset($_POST['realname']) ? htmlspecialchars($_POST['realname']) : '';
			$data['phone'] = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '';
			$data['email'] = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
			$data['qq'] = isset($_POST['qq']) ? htmlspecialchars($_POST['qq']) : '';

			$data['type'] = 3;

			if (empty($data['account'])) {
				$this->error('缺少管理员名称');
			}

			if (empty($data['group_id'])) {
				$this->error('请选择管理员组');
			}

			if ($database_admin->where(array('account'=>$data['account']))->find()) {
				$this->error('用户名已经使用');
			}

			if (empty($data['pwd']) || empty($data['repwd'])) {
				$this->error('用户名密码未填写');
			}

			if ($data['pwd'] != $data['repwd']) {
				$this->error('重复密码错误');	
			}

			$data['pwd'] = md5($data['pwd']);
			$data['creator'] = $this->admin_user['id'];

			if (D("Admin")->add($data)) {
                $this->frame_submit_tips(1,'添加成功');
			} else {
                $this->frame_submit_tips(0,'添加失败，稍后再试');
			}

		} else {

			$database_admin_group = D('Admin_group');

			// 管理员权限组
			$admin_group_list = $database_admin_group->where(array("status"=>1))->select();
			if (count($admin_group_list) < 1) {
				$this->frame_error_tips('请先添加管理员组');
			}

			$this->assign('group_list', $admin_group_list);
			$this->display();
		}
	}

	// 修改代理商
	public function agent_edit () {

		if (IS_POST) {

			$database_admin = D('Admin');

			$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

			$data = array();
			$data['group_id'] = isset($_POST['group_id']) ? intval($_POST['group_id']) : 0;
			$data['account'] = isset($_POST['account']) ? htmlspecialchars($_POST['account']) : '';
			$data['pwd'] = isset($_POST['pwd']) ? $_POST['pwd'] : '';
			$data['status'] = isset($_POST['status']) ? intval($_POST['status']) : 0;
			
			$data['group_id'] = isset($_POST['group_id']) ? intval($_POST['group_id']) : 0;
			$data['realname'] = isset($_POST['realname']) ? htmlspecialchars($_POST['realname']) : '';
			$data['phone'] = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '';
			$data['email'] = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
			$data['qq'] = isset($_POST['qq']) ? htmlspecialchars($_POST['qq']) : '';

			$data['type'] = 3;

			if (empty($id) || !$admin = D('Admin')->where(array('id'=>$id, 'type'=>3))->find()) {
				$this->error('未找到该用户');
			}

			if (empty($data['account'])) {
				$this->error('缺少管理员名称');
			}

			if (empty($data['group_id'])) {
				$this->error('请选择管理员组');
			}

			if ($database_admin->where("`account` = '".$data['account']."' && `id` != $id")->find()) {
				$this->error('用户名已经被使用');
			}

			if (!empty($data['pwd'])) {
				$data['pwd'] = md5($data['pwd']);
			} else {
				unset($data['pwd']);
			}

            if($_FILES['pic']['error'] != 4){
                //上传图片
                $rand_num = date('Y/m',$_SERVER['REQUEST_TIME']);
                $upload_dir = './upload/adver/'.$rand_num.'/';
                if(!is_dir($upload_dir)){
                    mkdir($upload_dir,0777,true);
                }
                import('ORG.Net.UploadFile');
                $upload = new UploadFile();
                $upload->maxSize = 10*1024*1024;
                $upload->allowExts = array('jpg','jpeg','png','gif');
                $upload->allowTypes = array('image/png','image/jpg','image/jpeg','image/gif');
                $upload->savePath = $upload_dir;
                $upload->saveRule = 'uniqid';
                if($upload->upload()){
                    $uploadList = $upload->getUploadFileInfo();

                    $attachment_upload_type = C('config.attachment_upload_type');
                    // 上传到又拍云服务器
                    if ($attachment_upload_type == '1') {
                        import('upyunUser', './source/class/upload/');
                        upyunUser::upload('./upload/adver/' . $rand_num.'/'.$uploadList[0]['savename'], '/adver/' . $rand_num.'/'.$uploadList[0]['savename']);
                    }

                    $data['avatar'] = 'adver/' . $rand_num.'/'.$uploadList[0]['savename'];
                }else{
                    $this->error($upload->getErrorMsg());
                }
            }

			if ($database_admin->where(array('id'=>$id))->data($data)->save()) {
                $this->frame_submit_tips(1,'修改成功');
			} else {
                $this->frame_submit_tips(0,'修改失败，稍后再试');
			}

		} else {

			$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

			if (empty($id) || !$admin = D('Admin')->where(array('id'=>$id, 'type'=>3))->find()) {
				$this->frame_error_tips('未找到该用户');
			}
            $admin['avatar'] = getAttachmentUrl($admin['avatar']);

			$database_admin_group = D('Admin_group');

			// 管理员权限组
			$admin_group_list = $database_admin_group->where(array("status"=>1))->select();
			if (count($admin_group_list) < 1) {
				$this->frame_error_tips('请先添加管理员组');
			}

			$this->assign('group_list', $admin_group_list);
			$this->assign('admin', $admin);
			$this->display();
		}
	}

	// 增加代理商关联到区域管理员
	public function agent_area () {

		if (IS_POST) {

			$agent_aid = isset($_POST['uid']) ? intval($_POST['uid']) : 0;
			$area_aid = isset($_POST['admin_id']) ? intval($_POST['admin_id']) : 0;

			if (empty($agent_aid) || empty($area_aid)) {
				$this->error('请选择相应区域管理员');
			}

			$find_agent = D('Admin')->where(array('id'=>$agent_aid, 'type'=>3))->find();
			if (empty($find_agent)) {
				$this->error('参数错误');
			}

			$find_area = D('Admin')->where(array('id'=>$area_aid, 'type'=>2))->find();
			if (empty($find_agent)) {
				$this->error('参数错误');
			}

			$result = D('Admin')->where(array('id'=>$agent_aid, 'type'=>3))->data(array('area_admin'=>$area_aid))->save();
			if ($result) {
				$this->success('关联成功');
			} else {
				$this->error('关联失败，稍后再试');
			}

		} else {

			$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
			if (empty($id) || !$admin = D('Admin')->where(array('id'=>$id, 'type'=>3))->find()) {
				$this->frame_error_tips('未找到该用户');
			}

			import('area', './source/class');
			$areaClass = new area();
			$area_all = $areaClass->get_AllProvCityArea();
			// 所有区域管理员
			$admin_reset = array(
					'province' => array(),
					'city' => array(),
					'area' => array(),
				);
			$area_admin = D('Admin')->where(array('type'=>2))->select();
			// dump($area_admin);exit;
			foreach ($area_admin as $val) {

				if ($val['area_level'] == 1) {
					$admin_array['province'][$val['province']] = $val;
				}

				if ($val['area_level'] == 2) {
					$admin_array['city'][$val['city']] = $val;
				}

				if ($val['area_level'] == 3) {
					$admin_array['area'][$val['county']] = $val;
				}

			}

			$about_area_admin = array();
			if (!empty($admin['area_admin'])) {
				$about_area_admin = D('Admin')->where(array('id'=>$admin['area_admin'], 'type'=>2))->find();
			}

			// dump($admin_array);exit;
			$this->assign('now_admin', $admin);
			$this->assign('about_area_admin', $about_area_admin);
			$this->assign('area_all', $area_all);
			$this->assign('admin_array', $admin_array);
			$this->display();

		}


	}

	// 管理员奖金比例设置 [区域管理员/代理商]
	public function bonus_config () {

		$database_admin_bonus_config = D("Admin_bonus_config");

		if (IS_POST) {

			$data['type'] = isset($_POST['type']) ? intval($_POST['type']) : 0;
			$data['area_level'] = isset($_POST['area_level']) ? intval($_POST['area_level']) : 0;
			$data['self_online'] = isset($_POST['self_online']) ? (float)$_POST['self_online'] : 0;
			$data['self_offline'] = isset($_POST['self_offline']) ? (float)$_POST['self_offline'] : 0;
			$data['platform_online'] = isset($_POST['platform_online']) ? (float)$_POST['platform_online'] : 0;
			$data['platform_offline'] = isset($_POST['platform_offline']) ? (float)$_POST['platform_offline'] : 0;
			$data['foreign_online'] = isset($_POST['foreign_online']) ? (float)$_POST['foreign_online'] : 0;
			$data['foreign_offline'] = isset($_POST['foreign_offline']) ? (float)$_POST['foreign_offline'] : 0;

			if (!in_array($data['type'], array(2,3))) {
				$this->error('参数错误');
			}

			$bonus_config = $database_admin_bonus_config->where(array('type'=>$data['type'], 'area_level'=>$data['area_level'], 'status'=>1))->find();
			if ($bonus_config) {
				$database_admin_bonus_config->where(array('type'=>$data['type'], 'area_level'=>$data['area_level'], 'status'=>1))->data(array('status'=>0))->save();
			}

			$data['creator'] = $this->admin_user['id'];
			$data['status'] = 1;
			$data['add_time'] = time();
			$result = $database_admin_bonus_config->data($data)->add();
			if ($result) {
				$this->success('修改成功');
			} else {
				$this->error('修改失败，稍后再试');
			}

		} else {

			$gid = isset($_GET['gid']) ? intval($_GET['gid']) : 2;

			if (!in_array($gid, array(2,3))) {
				$this->error('参数错误');
			}

			$config = array();
			$config_init = array(
					'self_online' => 0.00,
					'self_offline' => 0.00,
					'platform_online' => 0.00,
					'platform_offline' => 0.00,
					'foreign_online' => 0.00,
					'foreign_offline' => 0.00,
				);
			$agent_tmp = $database_admin_bonus_config->where(array('type'=>3, 'status'=>1))->find();
			$area_province_tmp = $database_admin_bonus_config->where(array('type'=>2, 'status'=>1, 'area_level'=>1))->find();
			$area_city_tmp = $database_admin_bonus_config->where(array('type'=>2, 'status'=>1, 'area_level'=>2))->find();
			$area_county_tmp = $database_admin_bonus_config->where(array('type'=>2, 'status'=>1, 'area_level'=>3))->find();

			$config['agent'] = !empty($agent_tmp) ? $agent_tmp : $config_init;
			$config['area']['province'] = !empty($area_province_tmp) ? $area_province_tmp : $config_init;
			$config['area']['city'] = !empty($area_city_tmp) ? $area_city_tmp : $config_init;
			$config['area']['county'] = !empty($area_county_tmp) ? $area_county_tmp : $config_init;

			$info = M('credit_setting')->find();

			//平台服务费
			$service_fee = M('Config')->where(array('name' => 'sales_ratio'))->getField('value');

			$this->assign('gid', $gid);
			$this->assign('config', $config);
			$this->assign('info', $info);
			$this->assign('service_fee', number_format($service_fee, 2, '.', ''));
			$this->display();
		}

	}

	/**
	 * 是否开启推广奖励
	 */
	public function chgBonusStatus()
	{

		$id = $this->_post('id', 'trim,intval');

		$name = $this->_post('name', 'trim');

		$status = $this->_post('status', 'trim,intval');

		if($name == 'open_promotion_reward') {
			M('credit_setting')->where(array('id' => $id))->save(array($name => $status));
		}

	}

	/**
	 * 默认推广奖励
	 */
	public function chgPromotionRewardRate() {

		$id = $this->_post('id', 'trim,intval');

		$promotion_reward_rate = $this->_post('promotion_reward_rate', 'trim');

		M('credit_setting')->where(array('id' => $id))->save(array('promotion_reward_rate' => $promotion_reward_rate));
	}

	// 添加用户关联代理商
	public function agent_invite () {

		$database_user = D("User");
		$database_admin = D("Admin");
		$database_agent_invite = D("Agent_invite");

		if (IS_POST) {

			$uid = isset($_POST['uid']) ? intval($_POST['uid']) : 0;
			$data['invite_admin'] = isset($_POST['invite_admin']) ? intval($_POST['invite_admin']) : 0;

			if (empty($data['invite_admin'])) {
				$this->frame_error_tips("缺少代理商id");
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
				$this->frame_error_tips("缺少代理商，请先创建");
			}

			$this->assign('agent_list', $agent_list);
			$this->assign('user', $user);
			$this->display();
		}
	}

	// 邀请码显示页面 [代理商]
	public function agentcode () {

		if ($this->admin_user["type"] != 3) {
			$this->frame_error_tips("邀请码为客户经理(代理商)专用");
		}

		$agent_code = D('Admin')->getAgentCode($this->admin_user);
		$agent_url = C('config.site_url')."/user.php?c=user&a=login&agent_code=".$agent_code;

		$this->assign('agent_code', $agent_code);
		$this->assign('agent_url', $agent_url);
		$this->display();

	}

	// 添加奖金记录
	public function send_reward () {
		if (IS_POST) {

			$amount = isset($_POST['amount']) ? intval($_POST['amount']) : 0;
			$admin_id = isset($_POST['id']) ? intval($_POST['id']) : 0;
			$send_type = isset($_POST['send_type']) ? intval($_POST['send_type']) : 0;
			$bak = isset($_POST['bak']) ? trim($_POST['bak']) : '';
			
			if (empty($admin_id) || !$admin = D("Admin")->where(array('id'=>$admin_id))->find()) {
				$this->frame_error_tips("不存在该管理员");
			}

			if ($admin['type'] != 2 && $admin['type'] != 3) {
				$this->frame_error_tips("只有区域管理员和客户经理(代理商)可以发送奖金");
			}

			$after_send = $admin['reward_balance'] - $amount;
			if ($after_send < 0) {
				$this->frame_error_tips("可用余额不足");
			}

			$result = D("Admin")->where(array("id"=>$admin_id))->data(array('reward_balance'=>$after_send))->save();

			if (!$result) {
				$this->error("发送奖金失败，稍后再试");
			}

			$time = time();
			$sendLogData = array(
					'admin_id' => $admin_id,
					'amount' => $amount,
					'type' => 1,
					'add_time' => $time,
					'send_type' => $send_type,
					'send_aid' => $this->admin_user['id'],
					'bak' => $bak,
				);
			D("PromotionRewardLog")->data($sendLogData)->add();

			$this->success("发送奖金成功");


		} else {

			$admin_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
			if (empty($admin_id) || !$admin = D("Admin")->where(array('id'=>$admin_id))->find()) {
				$this->frame_error_tips("不存在该管理员");
			}

			if ($admin['type'] != 2 && $admin['type'] != 3) {
				$this->frame_error_tips("只有区域管理员和客户经理(代理商)可以发送奖金");
			}

			if ($admin['reward_balance'] <= 0) {
				$this->frame_error_tips("可用余额不足，无法发送奖金");
			}

			$sendTypeArr = D("Admin")->getPromotionType();
			$this->assign('sendTypeArr', $sendTypeArr);
			$this->assign('admin', $admin);
			$this->display();
		}
	}

	// 修改管理员(普通/区域/代理商)状态
	public function admin_status () {
		if (IS_POST) {
			$admin = M('Admin');
			$admin_id = $this->_post('admin_id', 'trim,intval');
			$status = $this->_post('status', 'trim,intval');
			if ($admin->where(array('id' => $admin_id))->save(array('status' => $status))) {
				echo json_encode(array('error' => 0, 'message' => '状态修改成功'));
				exit;
			}

			echo json_encode(array('error' => 1, 'message' => '修改失败！请重试'));
			exit;
		}
	}

	// 修改admin_group状态
	public function group_status () {
		if (IS_POST) {
			$admin_group = M('AdminGroup');
			$group_id = $this->_post('group_id', 'trim,intval');
			$status = $this->_post('status', 'trim,intval');
			if ($admin_group->where(array('id' => $group_id))->save(array('status' => $status))) {
				echo json_encode(array('error' => 0, 'message' => '状态修改成功'));
				exit;
			}

			echo json_encode(array('error' => 1, 'message' => '修改失败！请重试'));
			exit;
		}
	}

}
