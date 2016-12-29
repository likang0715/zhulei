<?php
class wzc_controller extends base_controller {

	public function __construct() {
		parent::__construct();
		$this->user_session=$_SESSION['user'];
	        if(!empty($this->user_session)){
	            $this->user_session['avatar'] = !empty($this->user_session['avatar']) ? getAttachmentUrl($this->user_session['avatar']) : '/static/images/avatar.png';
	        }
	}

	// 加载
	public function load () {
		$action = strtolower(trim($_POST['page']));
		if (empty($action)) pigcms_tips('非法访问！', 'none');
		$id=!empty($_POST['id']) ? intval($_POST['id']) : 0;
		switch ($action) {
			case 'wzc_list' :
				$this->_wzc_list();
				break;
			case 'edit' :
				$this->_edit($id);
				break;
			case 'create' :
				$this->_create();
				break;
			case 'repaylist':
				$this->_repaylist($id);
				break;
			case 'create_repay':
				$this->_create_repay($id);
				break;
			case 'edit_repay':
				$this->_edit_repay($id);
				break;
			default:
				break;
		}
		// var_dump($action);
		$this->display($_POST['page']);
	}

	public function wzc_index () {
		M('Zc_product')->jihua();
		$this->display();
	}

	public function _wzc_list () {
		$type = $_REQUEST['type'];
		$type = !empty($type) ? $type : 'all';
		$where_wzc = '`store_id`='.$this->store_session['store_id'];
		switch ($type) {
			case 'all':
				$where_wzc.='';         //全部
				break;
			case 'on':
				$where_wzc.=' AND `status`=4';                //进行中 众筹中
				break;
			case 'end':
				$where_wzc.=' AND (`status`=6 OR `status`=7)';	//结束
				break;
			case 'future':
				$where_wzc.=' AND `status`=2';	        //未开始 预热中
				break;
			case 'apply':
				$where_wzc.=' AND `status`=1';	        //申请中
				break;
			default:
				$where_wzc.='';         //全部
				break;
		}
		$product_database = D("Product");
		$count = D('Zc_product')->where($where_wzc)->count('product_id');
		$s=import('source.class.user_page');
		$page = new Page($count, 10);
		$show = $page->show();

		$wzc_list = D('Zc_product')->where($where_wzc)->order("`product_id` desc")->limit($page->firstRow.','.$page->listRows)->order('product_id DESC')->select();
		$this->assign('type', $type);
		$this->assign("page", $show);
		$this->assign("wzc_list", $wzc_list);

	}
	// 开始众筹项目路演
	public function dostart(){
		if($_POST['product_id']){
			$product_id=intval($_POST['product_id']);
			$where='`product_id`='.$product_id.' AND `isSelfless`=0';
			$count=D('Zc_product_repay')->where($where)->count('repay_id');
			if($count<1){
				json_return(101, '请添加回报设置');
			}
			$effId=D('Zc_product')->where(array('product_id'=>$product_id))->data(array('status'=>2))->save();
			if(!empty($effId)){
				json_return(0, '操作成功');
			}else{
				json_return(1, '操作失败');
			}
		}else{
			json_return(1000, '参数错误');
		}
	}
	// 开始众筹项目筹资
	public function dostartcollect(){
		if($_POST['product_id']){
			$product_id=intval($_POST['product_id']);
			$effId=M("Zc_product")->startCollect($product_id);
			if(!empty($effId)){
				json_return(0, '操作成功');
			}else{
				json_return(1, '操作失败');
			}
		}else{
			json_return(1000, '参数错误');
		}
	}

	// 显示添加页
	public function _create () {
		$name_session_proid='save_repay_'.$user_session['uid'];
		if(isset($_SESSION[$name_session_proid])){
			unset($_SESSION[$name_session_proid]);
		}
		import('source.class.ZcFileConfig');
		$productConfig=ZcfileConfig::productFile();
		$this->assign('productConfig',$productConfig);

		// 产品项目分类
		$product_class=D('Zc_product_class')->select();
		$product_class=!empty($product_class) ? $product_class : array();
		$this->assign('product_class',$product_class);

		// 发起人信息填充
		$sponsorInfo=D('Zc_product_sponsor')->where(array('uid'=>$this->user_session['uid']))->find();
		$this->assign('sponsorInfo',$sponsorInfo);
	}

	// 修改
	public function _edit ($id) {
		import('source.class.ZcFileConfig');
		$productConfig=ZcfileConfig::productFile();
		$this->assign('productConfig',$productConfig);

		if(empty($id)){  json_return(102, '参数错误'); }
		$proInfo=D('Zc_product')->where(array('product_id'=>$id))->find();
		// var_dump($proInfo);
		if(empty($proInfo)){  json_return(103, '参数错误');  }
		$this->assign('proInfo',$proInfo);

		$sponsorInfo=D('Zc_product_sponsor')->where(array('uid'=>$this->user_session['uid']))->find();
		$this->assign('sponsorInfo',$sponsorInfo);

		// 产品项目分类
		$product_class=D('Zc_product_class')->select();
		$product_class=!empty($product_class) ? $product_class : array();
		$this->assign('product_class',$product_class);
	}

	// 更新
	public function doupdate () {
		$info=$_POST;
		$sponsor = array();
		$sponsor['introduce']=$info['introduce'];
		$sponsor['sponsorDetails']=$info['sponsorDetails'];
		$sponsor['weiBo']=$info['weiBo'];
		$sponsor['thankMess']=$info['thankMess'];
		$sponsor['sponsorPhone']=$info['sponsorPhone'];
		unset($info['introduce'],$info['sponsorDetails'],$info['weiBo'],$info['thankMess'],$info['sponsorPhone']);
		$this->post_filter($info,$sponsor);

		// 发起人信息新增修改
		$sponsor['nickname']=$this->user_session['nickname'];
		$sponsor['avatar']=$this->user_session['avatar'];
            	$info_sponsor=D('Zc_product_sponsor')->where(array('uid'=>$this->user_session['uid']))->find();
            	if(empty($info_sponsor)){//添加项目申请人
                	$sponsor['uid']=$this->user_session['uid'];
                	$sponsor['time']=$_SERVER['REQUEST_TIME'];
                	D('Zc_product_sponsor')->data($sponsor)->add();
            	}else{
                	D('Zc_product_sponsor')->where(array('uid'=>$this->user_session['uid']))->data($sponsor)->save();
            	}

           	// 项目信息添加修改
		if($info['raiseType']==1){
			unset($info['amount'],$info['toplimit'],$info['collectDays']);
		}
		$info['uid']=$this->user_session['uid'];
		$info['time']=$_SERVER['REQUEST_TIME'];
		$info['status']=0;
		$info['store_id']=$this->store_session['store_id'];
            	$product_id=intval($info['product_id']);
            	$info['productThumImage']=getAttachment($info['productThumImage']);
            	$info['productListImg']=getAttachment($info['productListImg']);
            	$info['productFirstImg']=getAttachment($info['productFirstImg']);
            	$info['productImage']=getAttachment($info['productImage']);
            	$info['productImageMobile']=getAttachment($info['productImageMobile']);
            	unset($info['product_id']);
            	if(empty($product_id)){
	                $lastId=D('Zc_product')->data($info)->add();
	                if(!empty($lastId)){
	                    $name_session_proid='save_repay_'.$this->user_session['uid'];
	                    $_SESSION[$name_session_proid]=$lastId;
	                    json_return(0, $lastId);
	                }else{
	                    json_return(101, '操作失败');
	                }
            	}else{
            		unset($info['store_id']);
                	$effId=D('Zc_product')->where(array('product_id'=>$product_id))->data($info)->save();
                	json_return(0, $product_id);
            	}
	}
	// 回报设置列表
	public function _repaylist($id){
		if(empty($id)){   json_return(101, '参数错误'); }
		$where='`product_id`='.$id.' AND `isSelfless`=0';
		$count = D('Zc_product_repay')->where($where)->count('repay_id');
		import('source.class.user_page');
		$page = new Page($count, 10);
		$show = $page->show();

		$repay_list=D('Zc_product_repay')->where($where)->limit($page->firstRow.','.$page->listRows)->order('repay_id DESC')->select();
		$this->assign('repay_list',$repay_list);
		$this->assign('page',$show);

		$productInfo=D('Zc_product')->where(array('product_id'=>$id))->field('product_id,status')->find();
		$this->assign('productInfo',$productInfo);
	}
	// 添加回报设置页面
	public function _create_repay($id){//项目id
		if(empty($id)){   json_return(101, '参数错误'); }
		$this->assign('id',$id);

		// 自动添加一个无私奉献的回报设置
		$name_session_proid='save_repay_'.$this->user_session['uid'];
		$where=$info=array();
		$where['uid']        = $info['uid']        = $this->user_session['uid'];
		$where['product_id'] = $info['product_id'] = $_SESSION[$name_session_proid];
		$where['isSelfless'] = $info['isSelfless'] = 1;
		$selflessInfo=D('Zc_product_repay')->where($where)->find();
		if(empty($selflessInfo)){
			$info['time']=$_SERVER['REQUEST_TIME'];
            		$info['redoundContent']='无私奉献不需要回报';
			$lid=D('Zc_product_repay')->data($info)->add();
		}
	}
	// 回报设置修改页面
	public function _edit_repay($id){//回报设置id
		if(empty($id)){   json_return(101, '参数错误'); }
		$repay_info=D('Zc_product_repay')->where(array('repay_id'=>$id))->find();
		$this->assign('repay_info',$repay_info);
		$this->assign('id',$repay_info['product_id']);
	}
	// 设置回报
	public function setrepay(){
		if($_POST){
			$info=$_POST;
			$info['uid']=$this->user_session['uid'];
			$info['time']=$_SERVER['REQUEST_TIME'];
			$info['images']=getAttachment($info['images']);
			$proInfo=D('Zc_product')->where(array('product_id'=>intval($info['product_id'])))->field('product_id,status')->find();
			if($proInfo['status']!=0){
				json_return(101,"提交参数错误");
			}
			if($info['optType']=='add'){
				unset($info['optType'],$info['repay_id']);
				$lid=D('Zc_product_repay')->data($info)->add();
			}
			if($info['optType']=='edit'){
				$repay_id=intval($info['repay_id']);
				unset($info['optType'],$info['repay_id'],$info['product_id']);
				$lid=D('Zc_product_repay')->where(array('repay_id'=>$repay_id))->data($info)->save();
			}
			if(!empty($lid)){
				json_return(0,"操作成功");
			}else{
				json_return(101,"操作失败");
			}
		}else{
			echo json_return(0,"提交方式错误");
		}
	}
	// 众筹项目删除
	public function wzcdel(){
		if(!empty($_POST['product_id'])){
			$product_id=intval($_POST['product_id']);
			$effId=D('Zc_product')->where(array('product_id'=>$product_id))->delete();
			D('Zc_product_repay')->where(array('product_id'=>$product_id))->delete();
			if(!empty($effId)){
				json_return(0,"操作成功");
			}else{
				json_return(104,"操作成功");
			}
		}else{
			echo json_return(0,"提交参数错误");
		}
	}

	// 删除回报
	public function repaydel(){
		if($_POST){
			if(!empty($_POST['repayId'])){
				$repay_id=intval($_POST['repayId']);
				$repayInfo=D('Zc_product_repay')->where(array('repay_id'=>$repay_id))->field('repay_id,uid')->find();
				if($repayInfo['uid']==$this->user_session['uid']){
					D('Zc_product_repay')->where(array('repay_id'=>$repay_id))->delete();
					echo json_return(0,"操作成功");
				}else{
					echo json_return(101,"提交参数错误");
				}
			}else{
				echo json_return(101,"提交参数错误");
			}
		}else{
			echo json_return(101,"提交方式错误");
		}

	}
	protected function post_filter($info,$sponsor){
		if(empty($info['productName'])){
			json_return(101,"请填写项目名称");
		}
		// if(empty($info['class'])){
		// 	json_return(101,"请选择项目分类");
		// }
		if(empty($info['productAdWord'])){
			json_return(101,"请填写一句话说明");
		}
		if($info['raiseType']==0){
			if(empty($info['amount'])){
				json_return(101,"请填写筹资金额");
			}
			if(empty($info['toplimit'])){
				json_return(101,"请填写筹资上限");
			}
			if(empty($info['collectDays'])){
				json_return(101,"请填写筹资天数");
			}
		}
		if(empty($info['productThumImage'])){
			json_return(101,"请填写预热图片");
		}
		if(empty($info['productListImg'])){
			json_return(101,"请填写列表页图片");
		}
		if(empty($info['productFirstImg'])){
			json_return(101,"请填写首页图片");
		}
		if(empty($info['productImage'])){
			json_return(101,"请填写项目图片");
		}
		if(empty($info['productImageMobile'])){
			json_return(101,"请填写移动端图片");
		}
		if(empty($info['productSummary'])){
			json_return(101,"请填写项目简介");
		}
		if(empty($info['productDetails'])){
			json_return(101,"请填写项目详情");
		}
		if(empty($info['productThumImage'])){
			json_return(101,"请填写预热图片");
		}
		//
		if(empty($sponsor['introduce'])){
			json_return(101,"请填写自我介绍");
		}
		if(empty($sponsor['sponsorDetails'])){
			json_return(101,"请填写详细自我介绍");
		}
		if(empty($sponsor['thankMess'])){
			json_return(101,"请填写感谢信");
		}
		if(empty($sponsor['sponsorPhone'])){
			json_return(101,"请填写联系电话");
		}
	}
	// 生成二维码
	public function toCode(){
		import('source.class.phpqrcode');
		if($_GET['id']){
			$id=intval($_GET['id']);
			$url=option('config.site_url')."/webapp/chanping/index.html#/view/".$id;
			QRcode::png($url);
		}

	}

}
?>