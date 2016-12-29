<?php
/**
 * 店铺动态
 */
class article_controller extends base_controller {
	
	function index(){
		$this->display();
	}

	function load(){
		$action = strtolower(trim($_POST['page']));
		if (empty($action)) pigcms_tips('非法访问！', 'none');
	
		switch ($action) {
			case 'lists' :
				$this->_lists();
				break;
			case 'edit' :
				$this->_edit();
				break;
			case 'info' :
				$this->_info();
				break;
			case 'order' :
				$this->_order();
				break;
			case 'creates' :
				$this->_create();
				break;
			case 'data' :
				$this->_data();
				break;
			default:
				break;
		}
		$this->display($_POST['page']);
	}
	
	// 动态列表
	function _lists(){
		$keywords = trim($_POST['keyword']);
		$where['store_id'] = $_SESSION['store']['store_id'];
		if($keywords){
			$where['title'] = array('like','%'.$keywords.'%');
		}

		$article_lists = D('Article')->where($where)->order('status asc,id desc')->select();
		if($article_lists){
			foreach($article_lists as $key => $item){
				$product = D('Product')->field('name')->where(array('product_id'=>$item['product_id']))->find();
				$article_lists[$key]['product_name'] = $product['name'];
			}
		}
		$this->assign('article_lists',$article_lists);
	}

	// 添加活动
	function _create(){

	}

	// 编辑活动
	function _edit(){
		$aid = (int)$_POST['aid'];
		if($aid<=0){
			exit('参数ID错误');
		}
		$article = D('Article')->where(array('id'=>$aid,'store_id'=>$_SESSION['store']['store_id']))->find();
		if(!$article){
			exit('没有找到该记录');
		}
		$product = D('Product')->field('image')->where(array('product_id'=>$article['product_id']))->find();
		$this->assign('article',$article);
		$this->assign('product',$product);
	}

	// 保存
	function save(){
		$data = $_POST['data'];
		if($data['title']==''){
			json_return(1,'活动标题不能为空');
		}
		if($data['desc']==''){
			json_return(1,'活动简介不能为空');
		}
		if($data['pictures']==''){
			json_return(1,'请添加活动图片');
		}
		// 处理图片路径
		$pics = explode(',', $data['pictures']);
		$pic_arr = array();
		foreach ($pics as $key => $value) {
			$pic_arr[] = getAttachment($value);
		}
		$data['pictures'] = implode(',', $pic_arr);

		if($data['product_id']<=0&&$data['sku_id']<=0){
			json_return(1,'请添加商品');
		}
		$data['dateline'] = time();
		$data['store_id'] = $_SESSION['store']['store_id'];
		$aid = (int)$_POST['aid'];
		if($aid){
			D('Article')->where(array('id'=>$aid))->data($data)->save();
		}else{
			D('Article')->data($data)->add();
		}
		json_return(0,'保存成功');
	}

	// 删除
	function del(){
		$aid = (int)$_POST['aid'];
		if($aid<=0){
			json_return(1,'参数错误');
		}
		$article = D('Article')->where(array('id'=>$aid))->find();
		if(!$article){
			json_return(1,'没有找到该记录');
		}
		if($article['store_id']!=$_SESSION['store']['store_id']){
			json_return(1,'您只能删除自己店铺的活动');
		}
		D('Article')->where(array('id'=>$aid))->delete();
		json_return(0,'删除成功');
	}
}