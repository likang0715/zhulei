<?php
/*
 * 新闻管理
 */
class NewsAction extends BaseAction{
	public function index(){
		$count = D('News_category')->count();
		import('@.ORG.system_page');

		$p = new Page($count, 20);
		$category_list = D('News_category')->field(true)->order('`sort` asc,`cat_id` DESC')->limit($p->firstRow.','.$p->listRows)->select();

		$pagebar = $p->show();
		$this->assign('category_list',$category_list);

		$this->assign('pagebar',$pagebar);
		$this->display();

	}

	public function catAdd(){
		$this->assign('bg_color','#F3F3F3');
		$this->display();
	}
	public function catModify(){
		if(IS_POST){
			$database_News_category  = D('News_category');
			$_POST['icon']=getAttachment($_POST['icon']);
			if($database_News_category->data($_POST)->add()){
                                $this->frame_submit_tips(1,'添加成功！');
			}else{
                                $this->frame_submit_tips(0, '添加失败！请重试~');
			}
		}else{
			$this->error('非法提交,请重新提交~');
		}
	}
//        新闻分类修改
	public function catEdit(){
		$this->assign('bg_color','#F3F3F3');
                $news_category = M('news_category');
                $cat_id = intval($_GET['cat_id']);
                $now_category = $news_category->where('`cat_id` = '.$cat_id)->find();
                $now_category['icon']=getAttachmentUrl($now_category['icon']);
		$this->assign('now_category',$now_category);
		$this->display();
	}

//        产看新闻
        public function catShow (){
            $news_category = M('news_category');
            $cat_id = intval($_GET['cat_id']);
            $now_category = $news_category->where('`cat_id` = '.$cat_id)->find();
            $now_category['icon'] = getAttachmentUrl($now_category['icon']);
            $this->assign('now_category',$now_category);
            $this->display();
        }

	public function catAmend(){
		if(IS_POST){
//                    print_r($_POST);exit;
			$database_news_category  = D('News_category');
			$_POST['icon']=getAttachment($_POST['icon']);
			if($database_news_category->data($_POST)->save()){
                                $this->frame_submit_tips(1,'编辑成功！');
			}else{
                                $this->frame_submit_tips(0, '编辑失败！请重试~');
			}
		}else{
			$this->error('非法提交,请重新提交~');
		}
	}

	public function newsList(){
		$Db_news = D('News');
		$Db_News_category = D('News_category');
		$count = $Db_news->count();
		import('@.ORG.system_page');
		$p = new Page($count, 15);
		$news_list = $Db_news->field(true)->order('news_id DESC')->limit($p->firstRow.','.$p->listRows)->select();

		foreach($news_list as  $k=>$va){
                    $news_list[$k]['cates']= $Db_News_category->field('`cat_name`,`cat_id`,`cat_key`')->where(array('cat_key'=>$va['cat_key']))->find();
		}

		$pagebar = $p->show();
		$this->assign('news_list',$news_list);
		$this->assign('pagebar',$pagebar);
		$this->display();
	}




	public function newsAdd(){
		$this->assign('bg_color','#F3F3F3');
                $database_news = M('news');
                $database_news_category = M('News_category');
                if($_POST){
                    $_POST['imgUrl'] = getAttachment($_POST['imgUrl']);
                    $_POST['news_content']  = fulltext_filter($_POST['news_content']);
                    $_POST['add_time'] = time();
                    $row = $database_news->add($_POST);
                        if($row){
                            $this->frame_submit_tips(1,'添加成功！');
                        }  else {
                            $this->frame_submit_tips(0,'添加失败！请重试~');
                        }
                }
                $news_cat_list = $database_news_category->where(array('cat_state'=>1))->order('sort asc')->select();
                $this->assign('news_cat_list',$news_cat_list);
		$this->display();
	}

        public function newsEdit(){
		$this->assign('bg_color','#F3F3F3');
		$database_news = M('news');
                $database_news_category  = D('News_category');
		$condition_news['news_id'] = $_GET['id'];
		$now_news = $database_news->field(true)->where($condition_news)->find();
		if(empty($now_news)){
			$this->frame_error_tips('该新闻不存在！');
		}
		$now_news['imgUrl'] = getAttachmentUrl($now_news['imgUrl']);
		$this->assign('now_news',$now_news);
                $news_cat_list = $database_news_category->where(array('cat_state'=>1))->order('sort asc')->select();
		$this->assign('news_cat_list',$news_cat_list);
//                dump($news_cat_list);
		$this->display();
	}

        public function newsShow(){
            $database_news = M('news');
            $condition_news['news_id'] = $_GET['id'];
            $now_news = $database_news->field(true)->where($condition_news)->find();
            if(empty($now_news)){
                    $this->frame_error_tips('该新闻不存在！');
            }
            $now_news['imgUrl']=getAttachmentUrl($now_news['imgUrl']);
            $catInfo = D('News_category')->where(array('cat_key'=>$now_news['cat_key']))->find();
            $this->assign('catInfo',$catInfo);
            $this->assign('now_news',$now_news);
            $this->display();
        }

        public function newsEditData(){
            if($_POST){
                $database_news = M('news');
                unset ($_POST['dosubmit']);
	            $_POST['news_content']  = fulltext_filter($_POST['news_content']);
	            $_POST['imgUrl'] = getAttachment($_POST['imgUrl']);
                $row = $database_news->data($_POST)->save();
                if($row){
                            $this->frame_submit_tips(1,'修改成功！');
                        }  else {
                            $this->frame_submit_tips(0,'修改失败！请重试~');
                        }
            }
        }
	public function newsDel(){
		$database_adver = D('News');
		$condition_adver['news_id'] = intval($_POST['id']);
		$now_adver = $database_adver->field(true)->where($condition_adver)->find();
		if($database_adver->where($condition_adver)->delete()){
			unlink('./upload/adver/'.$now_adver['pic']);
			S('adver_list_'.$now_adver['cat_id'],NULL);
			$this->success('删除成功');
		}else{
			$this->error('删除失败！请重试~');
		}
	}
	public function slide(){
		import('ZcFileConfig', './source/class/');
		$slideClass=ZcfileConfig::slideClass();
		$this->assign('slideClass',$slideClass);

		import('@.ORG.system_page');
		$invest_slide=D('Invest_slide');
		$count = $invest_slide->count();
		$p = new Page($count, 20);
		$slide_list = $invest_slide->field(true)->order('`id` DESC')->limit($p->firstRow.','.$p->listRows)->select();
		$pagebar = $p->show();
		$this->assign('slide_list',$slide_list);
		$this->assign('pagebar',$pagebar);
		$this->display();
	}
	public function slideEdit(){
            import('ZcFileConfig', './source/class/');
            $slideClass=ZcfileConfig::slideClass();
            $this->assign('slideClass',$slideClass);
            if($_POST){
                $info=$_POST['info'];
                $info['time']=$_SERVER['REQUEST_TIME'];
                $info['url']=getAttachment($info['url']);
                $info['wapurl']=getAttachment($info['wapurl']);
                if( isset($_POST['id']) && !empty($_POST['id']) ){
                    $id=intval($_POST['id']);
                    M('Invest_slide')->where(array('id'=>$id))->data($info)->save();
                }else{
                    M('Invest_slide')->data($info)->add();
                }
                $this->frame_submit_tips(1,'操作成功');
            }else{
                if(isset( $_GET['id'] ) && intval($_GET['id']) ){//修改
                    $id=intval($_GET['id']);
                    $info=M('Invest_slide')->where(array('id'=>$id))->find();
                    $info['url']=getAttachmentUrl($info['url']);
                    $info['wapurl']=getAttachmentUrl($info['wapurl']);
                    $this->assign('info',$info);
                }
                $this->display();
            }
	}
        public function slideDel(){
            if(isset($_GET['id']) && !empty($_GET['id']) ){
                $id=intval($_GET['id']);
                $info=M('Invest_slide')->where(array('id'=>$id))->find();
                M('Invest_slide')->where(array('id'=>$id))->delete();
                unlink($info['url']);
                $this->success('操作成功');exit;
            }
        }

}