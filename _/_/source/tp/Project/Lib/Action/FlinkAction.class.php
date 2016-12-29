<?php
/*
 * 友情链接
 *
 * @  Writers    Jaty
 * @  BuildTime  2014/11/06 16:47
 * 
 */
class FlinkAction extends BaseAction{
	public function __construct(){
		parent::__construct();
		$this->top_menu = M('flink_config')->where('is_show=1')->select();
	}
	public function index(){
		$database_flink = D('Flink');
		$condition = array();
		$parent_key = trim($_GET['parent_key']);

		if(!empty($parent_key)){
			$condition['parent_key'] = $parent_key;
		}

		$count_flink = $database_flink->where($condition)->count();
		import('@.ORG.system_page');
		$p = new Page($count_flink,15);
		$flink_list = $database_flink->field(true)->where($condition)->order('`sort` DESC,`id` ASC')->limit($p->firstRow.','.$p->listRows)->select();
		$this->assign('flink_list',$flink_list);
		
		$pagebar = $p->show();
		$this->assign('pagebar',$pagebar);
		
		$this->display();
	}
	public function add(){
		$this->assign('bg_color','#F3F3F3');
		$this->display();
	}
	public function modify(){
		if(IS_POST){
			$_POST['add_time'] = $_SERVER['REQUEST_TIME'];
			$database_flink = D('Flink');
			if($database_flink->data($_POST)->add()){
				S('flink_list',NULL);
				$this->success('添加成功！');
			}else{
				$this->error('添加失败！请重试~');
			}
		}else{
			$this->error('非法提交,请重新提交~');
		}
	}
	public function edit(){
		$this->assign('bg_color','#F3F3F3');
		$database_flink = D('Flink');
		$condition['id'] = intval($_GET['id']);
		$flink = $database_flink->field(true)->where($condition)->find();
		$this->assign('flink',$flink);
		$this->display();
	}
	public function amend(){
		if(IS_POST){
			$_POST['add_time'] = $_SERVER['REQUEST_TIME'];
			$database_flink = D('Flink');
			if($database_flink->data($_POST)->save()){
				S('flink_list',NULL);
				$this->success('链接修改成功！');
			}else{
				$this->error('链接修改失败！请检查是否有过修改后重试~');
			}
		}else{
			$this->error('非法提交,请重新提交~');
		}
	}
	public function del(){
		if(IS_POST){
			$database_flink = D('Flink');
			$condition_flink['id'] = intval($_POST['id']);
			if($database_flink->where($condition_flink)->delete()){
				S('flink_list',NULL);
				$this->success('链接删除成功！');
			}else{
				$this->error('链接删除失败！请重试~');
			}
		}else{
			$this->error('非法提交,请重新提交~');
		}
	}

	public function config(){
		$config_list = M('flink_config')->select();
		$config_arr = array();
		foreach ($config_list as $key => $value) {
			$config_arr[$value['key']] = $value['value'];
		}
		$this->info = $config_arr;
		
		if(IS_POST){

			if(!empty($_FILES)){
				 if($_FILES['wx']['error'] != 4 || $_FILES['nav_1_pic']['error'] != 4 || $_FILES['nav_2_pic']['error'] != 4 || $_FILES['nav_3_pic']['error'] != 4){
					//上传图片
					$rand_num = date('Y/m',$_SERVER['REQUEST_TIME']);
					$upload_dir = './upload/flink/'.$rand_num.'/'; 
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
						foreach ($uploadList as $key => $value) {
							// 上传到又拍云服务器
							if ($attachment_upload_type == '1') {
								import('upyunUser', './source/class/upload/');
								upyunUser::upload('./upload/flink/' . $rand_num.'/'.$uploadList[$key]['savename'], '/flink/' . $rand_num.'/'.$uploadList[$key]['savename']);	
							}
							$_POST[$value['key']] = 'flink/' . $rand_num.'/'.$uploadList[$key]['savename'];

						}	
					}else{
						$this->error($upload->getErrorMsg());
					}
				}
			}
			unset($_POST['dosubmit']);
			//首页底部独立友情链接分类
			$allow_show_arr = array('menu_1','menu_2','menu_3','menu_4');
			$i = 0;
			foreach ($_POST as $key => $value) {
				$data['key'] = $key;
				$data['value'] = $value;
				if(in_array($key, $allow_show_arr)){
					$data['is_show'] = 1;
				}else{
					$data['is_show'] = 0;
				}
				$datas[$i] = $data;
				$i++;
			}

			if(M('flink_config')->addAll($datas,array(),true)){

				if($_POST['wx']){
					$this->unlinkImg($config_arr,'wx');
				}

				if($_POST['nav_1_pic']){
					$this->unlinkImg($config_arr,'nav_1_pic');
				}

				if($_POST['nav_2_pic']){
					$this->unlinkImg($config_arr,'nav_2_pic');
				}

				if($_POST['nav_3_pic']){
					$this->unlinkImg($config_arr,'nav_3_pic');
				}

				$this->success('修改配置成功！');
			}
		}else{	
			$this->display();
		}

	}

	public function delImg(){

		if(IS_POST){
			$key = $this->_post('key','trim');
			$value = $this->_post('val','trim');
			$config_arr[$key] = $value;		
			if(M('flink_config')->where(array('key'=>$key))->delete()){
				$this->unlinkImg($config_arr,$key);
			}
		}
	}

	private function unlinkImg($config_arr,$name){

		if(file_exists('./upload/' . $config_arr[$name])){
			unlink('./upload/' . $config_arr[$name]);

			$attachment_upload_type = C('config.attachment_upload_type');
			// 删除又拍云服务器
			if ($attachment_upload_type == '1') {
				import('upyunUser', './source/class/upload/');
				upyunUser::delete('/' . $config_arr[$name]);
			}
		}
		
	}

}