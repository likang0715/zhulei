<?php

class TemplateMsgAction extends BaseAction{

	public function __construct(){
		parent::__construct();
	}


	public function index(){
		if(IS_POST){
			$data = array();
			$data['tempkey'] = $_REQUEST['tempkey'];
			$data['name'] = $_REQUEST['name'];
			$data['content'] = $_REQUEST['content'];
			$data['topcolor'] = $_REQUEST['topcolor'];
			$data['textcolor'] = $_REQUEST['textcolor'];
			$data['status'] = $_REQUEST['status'];
			$data['tempid'] = $_REQUEST['tempid'];
			
			foreach ($data as $key => $val){
				foreach ($val as $k => $v){
					$info[$k][$key] = $v;
				}
			}
			foreach ($info as $kk => $vv){
				if($vv['tempid'] == ''){
					$info[$kk]['status'] = 0;
				}
 				$info[$kk]['token'] = 'system';
				$where = "tempkey='{$info[$kk]['tempkey']}' AND token='system'";

				if(M('Tempmsg')->where($where)->getField('id')){
					M('Tempmsg')->where($where)->save($info[$kk]);
				}else{
					M('Tempmsg')->add($info[$kk]);
				}
			}
			$this->success('操作成功');
		} else {
			import("templateNews",'./source/class/');
			$model = new templateNews();
			$templs = $model->systemTemplates();
			$data = M('Tempmsg')->where("token='system'")->field(true)->order('id ASC')->select();
			foreach($data as $key=>$val){
				$data[$val['tempkey']] = $val;
			}
			$list 	= array();
			foreach ($templs as $k => $v){
				$dbtempls = M('Tempmsg')->where("token='system' AND tempkey='$k'")->find();
				if(empty($dbtempls)){
					$list[] 	= array(
						'tempkey' 	=> $k,
						'name'		=> $v['name'],
						'content'	=> $v['content'],
						'topcolor'	=> '#029700',
						'textcolor'	=> '#000000',
						'status'	=> 0,
					);
				}else{
					$list[] 	= $data[$k];
				}
			}
			$this->assign('list',$list);
			$this->display();
		}
	}
}