<?php
/**
 *  店铺动态
 */
require_once dirname(__FILE__).'/global.php';
$action = $_GET['action']?$_GET['action']:'index';
if(function_exists($action)){
	$action();
}else{
	pigcms_tips('方法不存在');
}

// 店铺所有动态
function index(){

	$is_ajax = (int)$_GET['is_ajax'];
	$aid = (int)$_GET['aid'];
	$store_id = (int)$_GET['store_id'];
	if(!$is_ajax){
		include display('article_list');
		echo ob_get_clean();
		return;
	}

	// 列表
	$where['status'] = 1;
	$where['dateline'] =array('>',time()-2592000);
	$store_id && $where['store_id'] = $store_id;


	$count = D('Article')->field('count(1) as count')->where($where)->find();
	$p = max(1,(int)$_GET['page']);
	$offset = 10;
	import('source.class.user_page');
	$page = new Page($count['count'], $offset,$p);
	$articles = D('Article')->where($where)->limit($page->firstRow.','.$page->listRows)->select();
	$product_ids = array();
	// 重组文章列表，默认文章放第一
	$default = false;
	foreach($articles as $key => $item){
		if(!in_array($item['product_id'],$product_ids)){
			$product_ids[] = $item['product_id'];
		}
		if($item['id']==$aid){
			$default = $item;
			unset($articles[$key]);
			continue;
		}
		$collects = D('My_collection_article')->field('count(*) as count')->where(array('article_id'=>$item['id']))->find();
		$collects['count'] && $articles[$key]['collect'] = $collects['count'];
		$mycollected = D('My_collection_article')->where(array('article_id'=>$item['id'],'uid'=>$_SESSION['wap_user']['uid']))->find();
		$mycollected && $articles[$key]['mycollected'] = 1;
	}
	if($default){
		$collects = D('My_collection_article')->field('count(*) as count')->where(array('article_id'=>$default['id']))->find();
		$collects['count'] && $default['collect'] = $collects['count'];
		$mycollected = D('My_collection_article')->where(array('article_id'=>$default['id'],'uid'=>$_SESSION['wap_user']['uid']))->find();
		$mycollected && $default['mycollected'] = 1;
		array_unshift($articles,$default);
	}
	// 商品
	$tmp_product_list = $product_list = false;
	if($product_ids){
		$where_product['product_id'] = array('in',$product_ids);
		$tmp_product_list = D('Product')->field('product_id,name,image')->where($where_product)->select();
		if($tmp_product_list){
			foreach($tmp_product_list as $k => $tmp_product){
				$product_list[$tmp_product['product_id']] = $tmp_product;
			}
		}
	}

	if(!$articles){
		json_return();
	}
	$html = '';
	foreach($articles as $article_item){
    	$html .='<div class="title clearfix">';
        $html .='<h2>'.$article_item['title'].'</h2>';
        $html .='<div class="button"> <a href="/wap/home.php?id='.$article_item['store_id'].'" ><span>逛店铺</span></a>';
        $is_active = $article_item['mycollected']?'active':'';
        $html .='    <button onclick="collections(this)" aid='.$article_item['id'].'  store_id='.$article_item['store_id'].'><i class="'.$is_active.'"></i><label>'.(int)$article_item['collect'].'</label></button>';
        $html .='</div>';
        $html .='<div style="clear:both"></div>';
        $html .='<p>'.getHumanTime(time()-$article_item['dateline']).'前'.'</p>';
    	$html .='</div>';
    	$html .='<div class="shopInfo">';
        $html .='<p>'.$article_item['desc'].'</p>';
        $html .='<ul class="clearfix">';
        $images = explode(',',$article_item['pictures']);
        	foreach($images as $img){
            	$html .= '<li><img src="'.getAttachmentUrl($img).'" width=110 height=110 /></li>';
            }
        $html .= '</ul>';
    	$html .= '</div>';
    	$html .= '<div class="shopShopping clearfix">';
    	$html .= '<div class="shopImg"><img src="'.getAttachmentUrl($product_list[$article_item['product_id']]['image']).'" /></div>';
    	$html .= '<h1>'.$product_list[$article_item['product_id']]['name'].'</h1>';
    	$html .= '<a href="/wap/good.php?id='.$article_item['product_id'].'&platform=1"><span>去购买<i></i></span></a>';
    	$html .= '</div>';
	}
	$result_content = array('html'=>$html,'hasmore'=>($p*$offset>=$count['count']?0:1));
	json_return(0,$result_content);
}

// 店铺动态详情
function detail(){
	$aid = (int)$_GET['aid'];
	$article = D('Article')->where(array('id'=>$aid,'status'=>1))->find();
	if(!$article){
		pigcms_tips('店铺动态不存在');
	}
	// 商品
	$product = D('Product')->where(array('product_id'=>$article['product_id']))->find();

	include display('article_detail');
	echo ob_get_clean();
}

function collect(){
	$aid = (int)$_POST['aid'];				// 文章ID
	$store_id = (int)$_POST['store_id'];		// 店铺ID
	$uid = $_SESSION['wap_user']['uid'];
	if($uid <= 0){
		json_return(1,'您还未登录，请先登录');
	}
	$where = array('uid'=>$uid,'article_id'=>$aid,'store_id'=>$store_id);
	$collect = D('My_collection_article')->where($where)->find();
	if($collect){
		D('My_collection_article')->where($where)->delete();
	}else{
		$data = array('store_id'=>$store_id,'article_id'=>$aid,'uid'=>$uid,'dateline'=>time());
		D('My_collection_article')->data($data)->add();
	}
	json_return(0,'操作成功');
}