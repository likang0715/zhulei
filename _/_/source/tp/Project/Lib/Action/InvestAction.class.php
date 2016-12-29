<?php
/*
 * 众筹管理类
 * @  BuildTime  2016/2/16
 *
 */
class InvestAction extends BaseAction {
    	public function investCheck() {
    		$user_apply_invest=M('user_apply_invest');
	        import('@.ORG.system_page');
	        $count=$user_apply_invest->count();
	        $p = new Page($count, 15);
    		$user_list=$user_apply_invest->order('time DESC')->limit($p->firstRow . ',' . $p->listRows)->select();
    		$pagebar = $p->show();
    		$this->assign('pagebar',$pagebar);
    		$this->assign("user_list",$user_list);
        	$this->display();
    	}
        public function ajax_setBeilv(){
            	if($_POST){
	                $val=$_POST['val'];
	                if(intval($_POST['val'])!=$_POST['val']){
	                    echo json_encode(array('err_code'=>2,'msg'=>'请填写整数'));exit;
	                }
	                $beilv=intval($_POST['val']);
	                $uid=intval($_POST['kid']);
	                $effId=D('user_apply_invest')->where(array('uid'=>$uid))->data(array('beilv'=>$beilv))->save();
	                if($effId){
	                    echo json_encode(array('err_code'=>0,'msg'=>'修改成功'));exit;
	                }else{
	                    json_encode(array('err_code'=>3,'msg'=>'修改失败'));exit;
	                }
            	}else{
                	echo json_encode(array('err_code'=>1,'msg'=>'参数错误'));exit;
            	}
        }

        public function projectCheck(){
		import('@.ORG.system_page');
		$where = '`status`=0 or `status`=1 or  `status`=2 or `status`=3 or `status`=4 or `status`=5';
		$databases_project = D('Project');
		$count = $databases_project->where($where)->count();
		$p = new Page($count, 10);
		$projectList = $databases_project->where($where)->order('project_id DESC')->limit($p->firstRow . ',' . $p->listRows)->select();
		$this->assign('projectList',$projectList);
		$pagebar = $p->show();
		$this->assign('pagebar',$pagebar);
		$this->display();
        }

        public function projectShowData(){
		$projectId = intval($_GET['project_id']);

		import('ZcFileConfig', './source/class/');
		$projectConfig=ZcfileConfig::projectAddFile();
		$this->assign('projectConfig',$projectConfig);

		$projectShow = D('Project')->where(array('project_id'=>$projectId))->find();
		$this->assign('projectShow',$projectShow);
		$this->display();
        }

        public function projectShowTeam(){
		$projectId = intval($_GET['project_id']);
		$databases_project_team = D('Project_team');
		$teamList = $databases_project_team->where(array('project_id'=>$projectId))->select();
		$this->assign('teamList',$teamList);
		$this->display();
        }
        public function projectDelete(){
            	if(isset($_GET['id']) && !empty($_GET['id'])){
                	$project_id=intval($_GET['id']);
                	M('Project')->where(array('project_id'=>$project_id))->delete();
                	$this->success('操作成功');exit;
            	}
        }
        public function projectCheckOperate(){
            	$databases_project = D('Project');
            	$re = $databases_project->where(array('project_id'=>  intval($_GET['project_id'])))->data(array('status'=>  intval($_GET['status'])))->save();
            	if($re){
                	$this->success('审核成功');exit;
            	}else{
                	$this->error('审核失败');exit;
            	}
        }
        public function projectRecommend(){
            	$databases_project = D('Project');
            	if($_POST){
	                $info  = $databases_project->where(array('project_id'=>  intval($_POST['project_id'])))->data(array('is_recommend'=>  intval($_POST['is_recommend']),'recommend_order'=>  intval($_POST['recommend_order'])))->save();
	                if($info){
	                    $this->frame_submit_tips(1,'操作成功');
	                }  else {
	                    $this->error_tips('操作失败');
	                }
            	}
		$projectInfo = $databases_project->where(array('project_id'=>  intval($_GET['project_id'])))->find();
		$this->assign('projectInfo',$projectInfo);
		$this->assign('project_id',$_GET['project_id']);
		$this->display();
        }


    	// 投资人查看，审核
    	public function investLook(){
    		if(isset($_GET['uid']) && !empty($_GET['uid']) ){
                import('ZcFileConfig', './source/class/');
                $person_type=ZcfileConfig::investorFile('person_type');
                $this->assign('person_type',$person_type);

    			$uid=intval($_GET['uid']);
    			$now_user=M('user_apply_invest')->where(array('uid'=>$uid))->find();
    			$this->assign('now_user',$now_user);
    			$this->display();exit;
    		}elseif(isset($_POST['uid']) && !empty($_POST['uid']) ){
    			if($_POST['isTrue']){
                    $data['status']=99;
                    $beilvInfo=D('invest_config')->where(array('key'=>'beilv'))->find();
                    $data['beilv'] = !empty($beilvInfo['value']) ? $beilvInfo['value'] : '';
    				M('user_apply_invest')->where(array('uid'=>intval($_POST['uid'])))->save($data);
    			}else{
                    $data['status']=97;
    				M('user_apply_invest')->where(array('uid'=>intval($_POST['uid'])))->save($data);
    			}
    			$this->frame_submit_tips(1,'操作成功');
    		}else{
    			$this->error_tips('错误页面');
    		}
    	}
        // 投资人删除
        public function investDel(){
            	if(isset($_GET['uid']) && !empty($_GET['uid'])){
	                $uid=intval($_GET['uid']);
	                M('user_apply_invest')->where(array('uid'=>$uid))->delete();
	                $this->success('操作成功');exit;
            	}
        }
        // 领投人列表
        public function leaderList(){
		$user_apply_leader=M('user_apply_invest');
		import('@.ORG.system_page');
		$where='`status`=99 AND `leader_status`!=0';
		$count=$user_apply_leader->where($where)->count();
		$p = new Page($count, 15);
		$user_list=$user_apply_leader->where($where)->order('apply_leader_time DESC')->limit($p->firstRow . ',' . $p->listRows)->select();
		$pagebar = $p->show();
		$this->assign('pagebar',$pagebar);
		$this->assign("user_list",$user_list);
		$this->display();
        }
        // 领投人列表
        public function leaderDel(){
            	if(isset($_GET['uid']) && !empty($_GET['uid'])){
	                $uid=intval($_GET['uid']);
	                $data=array();
	                $data['leader_status']=0;
	                M('user_apply_invest')->where(array('uid'=>$uid))->data($data)->save();
	                $this->success('操作成功');exit;
            	}
        }
        // 领投人申请信息
        public function leaderInfo(){
            	if(isset($_GET['uid']) && !empty($_GET['uid']) ){
	                import('ZcFileConfig', './source/class/');
	                $investorConfig=ZcfileConfig::investorFile();
	                $this->assign('investorConfig',$investorConfig);

	                $uid=intval($_GET['uid']);
	                $now_user=M('user_apply_invest')->where(array('uid'=>$uid))->find();
	                $this->assign('now_user',$now_user);
	                $this->display();exit;
            	}elseif(isset($_POST['uid']) && !empty($_POST['uid']) ){
	                $data=array();
	                if($_POST['isTrue']){
	                    $data['leader_status']=99;
	                    M('user_apply_invest')->where(array('uid'=>intval($_POST['uid'])))->save($data);
	                }else{
	                    $data['leader_status']=97;
	                    M('user_apply_invest')->where(array('uid'=>intval($_POST['uid'])))->save($data);
	                }
	                $this->frame_submit_tips(1,'操作成功');
            	}else{
                	$this->error_tips('错误页面');
            	}
        }
        public function question(){
		import('ZcFileConfig', './source/class/');
		$questionClass=ZcfileConfig::questionClass();
		$this->assign('questionClass',$questionClass);

		$invest_question=M('invest_question');
		import('@.ORG.system_page');
		$where='';
		$count=$invest_question->where($where)->count();
		$p = new Page($count, 15);
		$question_list=$invest_question->where($where)->order('sort DESC,id DESC')->limit($p->firstRow . ',' . $p->listRows)->select();
		$pagebar = $p->show();
		$this->assign('pagebar',$pagebar);
		$this->assign("question_list",$question_list);
		$this->display();
        }
        //修改常见问题
        public function editQuestion(){
		import('ZcFileConfig', './source/class/');
		$questionClass=ZcfileConfig::questionClass();
		$this->assign('questionClass',$questionClass);
            	if($_POST){
	                $info=$_POST['info'];
	                $info['time']=$_SERVER['REQUEST_TIME'];
	                if( isset($_POST['id']) && !empty($_POST['id']) ){
	                    $id=intval($_POST['id']);
	                    M('invest_question')->where(array('id'=>$id))->data($info)->save();
	                }else{
	                    M('invest_question')->data($info)->add();
	                }
	                $this->frame_submit_tips(1,'操作成功');
            	}else{
	                if(isset( $_GET['id'] ) && intval($_GET['id']) ){//修改
	                    $id=intval($_GET['id']);
	                    $info=M('invest_question')->where(array('id'=>$id))->find();
	                    $this->assign('info',$info);
	                }
	                $this->display();
            	}
        }
        public function questionDel(){
            	if(isset($_GET['id']) && !empty($_GET['id']) ){
	                $id=intval($_GET['id']);
	                M('invest_question')->where(array('id'=>$id))->delete();
	                $this->success('操作成功');exit;
            	}
        }
        public function config(){
            	if($_POST){
	                $info=$_POST['info'];
	                if(!empty($info)){
	                    $data=$where=array();
	                    foreach ($info as $k => $v) {
	                        $data['key']=$k;
	                        $data['value']=$v;
	                        $res=M('invest_config')->where(array('key'=>$k))->find();
	                        if(!empty($res)){
	                            M('invest_config')->where(array('id'=>$res['id']))->data($data)->save();
	                        }else{
	                            $lastID=M('invest_config')->data($data)->add();
	                        }
	                        unset($data['key']);
	                        unset($data['value']);
	                    }
	                }
	                $this->success('修改成功！');
            	}else{
	                $config_list=M('Invest_config')->select();
	                $config=array();
	                if(!empty($config_list)){
	                    foreach ($config_list as $k => $v) {
	                        $config[$v['key']]=$v['value'];
	                    }
	                }
	                $this->assign('config',$config);
	                $this->display();
            	}
        }
        // 产品众筹列表
        public function product(){
		$this->productDelDraft();//删除超过48小时的草稿
		$where='product.uid = sponsor.uid AND product.status!=0';
		$count=M()->table(array('pigcms_zc_product'=>'product','pigcms_zc_product_sponsor'=>'sponsor'))->where($where)->count();
		import('@.ORG.system_page');
		$p = new Page($count, 10);
		$product_list = M()->table(array('pigcms_zc_product'=>'product','pigcms_zc_product_sponsor'=>'sponsor'))->where($where)->order('product.time DESC')->limit($p->firstRow . ',' . $p->listRows)->select();
		$pagebar = $p->show();
		$this->assign('pagebar',$pagebar);
		$this->assign("product_list",$product_list);
		$this->display();
        }
        // 产品众筹审核
        public function productCheck(){
            	if(!empty($_GET['id'])){
	                $id=intval($_GET['id']);
	                $where='product.uid = sponsor.uid AND product.product_id='.$id;
	                $product_info = M()->table(array('pigcms_zc_product'=>'product','pigcms_zc_product_sponsor'=>'sponsor'))->where($where)->find();
	                $this->assign('product_info',$product_info);
	                import('ZcFileConfig', './source/class/');
	                $product_info=ZcfileConfig::productFile();
	                $this->assign('bankNo_info',$product_info['bankNo']);
	                $this->assign('product_laber',$product_info['productLabel']);
	                $this->display();
            	}elseif( !empty($_POST['product_id']) ){
	                $product_id=intval($_POST['product_id']);
	                $data=array();
	                if($_POST['isTrue']){
	                    $data['status']=2;
	                    M('zc_product')->where(array('product_id'=>$product_id))->save($data);
	                }else{
	                    $data['status']=3;
	                    M('zc_product')->where(array('product_id'=>$product_id))->save($data);
	                }
	                $this->frame_submit_tips(1,'操作成功');
            	}else{
                	$this->error_tips('错误页面');
            	}
        }
        // 产品众筹分类
        public function productClass(){
            	if(IS_POST){
	                $sort=$_POST['sort'];
	                foreach ($sort as $k => $v) {
	                    M('zc_product_class')->where(array('id'=>$k))->save(array('sort'=>$v));
	                }
	                $this->frame_main_ok_tips('操作成功');
            	}else{
	                $zc_product_class=M('zc_product_class');
	                import('@.ORG.system_page');
	                $count=$zc_product_class->count();
	                $p = new Page($count, 15);
	                $class_list=$zc_product_class->order('time DESC')->order('`sort` ASC')->limit($p->firstRow . ',' . $p->listRows)->select();
	                $pagebar = $p->show();
	                $this->assign('pagebar',$pagebar);
	                $this->assign('class_list',$class_list);
	                $this->display();
            	}
        }
        public function productSetclass(){
            	if($_POST){
	                $info=$_POST['info'];
	                $info['time'] = $_SERVER['REQUEST_TIME'];
	                $info['img']  = !empty($info['img'])   ? getAttachment($info['img'])  : '';
	                $info['icon'] = !empty($info['icon'])  ? getAttachment($info['icon']) : '';
	                if(!empty($_POST['id'])){
	                    $id=intval($_POST['id']);
	                    $lid=M('zc_product_class')->where(array('id'=>$id))->data($info)->save();
	                }else{
	                    $lid=M('zc_product_class')->data($info)->add();
	                }
	                if(!empty($lid)){
	                	$this->ajaxReturn(array('info'=>'操作成功！','status'=>1,'url'=>U('Invest/productClass')));
	                }else{
	                	$this->ajaxReturn(array('info'=>'操作成功！','status'=>0,'url'=>''));
	                }
            	}else{
                	if(!empty($_GET['id'])){
                    		$id=intval($_GET['id']);
                    		$class=M('zc_product_class')->where(array('id'=>$id))->find();
                    		$class['img']=getAttachmentUrl($class['img']);
                    		$class['icon']=getAttachmentUrl($class['icon']);
                    		$this->assign('class',$class);
                	}
                	$this->display();
            	}
        }
        // 产品众筹项目删除
        public function productDelete(){
            	if(!empty($_GET['id'])){
                	$id=intval($_GET['id']);
                	$effId=M('zc_product')->where(array('product_id'=>$id))->delete();
                	if(!empty($effId)){
                    		M('zc_product_repay')->where(array('product_id'=>$id))->delete();
                    		M('zc_product_load')->where(array('product_id'=>$id))->delete();
                    		M('zc_product_topic')->where(array('product_id'=>$id))->delete();
                	}
                	$this->success('操作成功！');
            	}else{
                	$this->error('操作成功！');
            	}
        }
        // 删除两天内的产品众筹草稿
        protected function productDelDraft(){
		$time_cha=$_SERVER['REQUEST_TIME']-(86400*2);
		$where='`time`<'.$time_cha.' AND `status`=0';
		M('zc_product')->where($where)->delete();
        }
        // 删除产品分类
        public function productDelClass(){
            	if(!empty($_GET['id'])){
	                $id=intval($_GET['id']);
	                $effId=M('zc_product_class')->where(array('id'=>$id))->delete();
	                $this->success('操作成功！');
            	}else{
                	$this->error('参数错误');
            	}
        }
        // 回报设置查看
        public function product_repay(){
            	if(!empty($_GET['payid'])){
                 	$repay_id=intval($_GET['payid']);
                 	$repayInfo=M('zc_product_repay')->where(array('repay_id'=>$repay_id))->find();
                 	$this->assign("repayInfo",$repayInfo);
                 	$this->display();
            	}else{
                	$this->error('参数错误');
            	}
        }
        // 回报设置列表
        public function product_repaylist(){
            	if(!empty($_GET['id'])){
	                $product_id=intval($_GET['id']);
	                $where='`product_id`='.$product_id.' AND  `isSelfless`=0';
	                $count=M('zc_product_repay')->where($where)->count();
	                import('@.ORG.system_page');
	                $p = new Page($count, 10);
	                $list=M('zc_product_repay')->where($where)->order('`repay_id` DESC')->limit($p->firstRow . ',' . $p->listRows)->select();
	                $this->assign('list',$list);
	                $pagebar = $p->show();
	                $this->assign('pagebar',$pagebar);
	                $this->display();
            	}else{
                	$this->error('参数错误');
            	}
        }


}