<?php
/*
 * 拼团管理
 */
class TuanAction extends BaseAction{

    //PC端广告管理
    public function adver(){
        $adver = D('Adver');

        $cat_id = $this->getCatId('pc_tuan_adver',2);
        $where['cat_id'] = $cat_id;

        import('@.ORG.system_page');

        $count = $adver->where($where)->count('id');

        $p = new Page($count,10);
        $adver_list = $adver->where($where)->limit($p->firstRow.','.$p->listRows)->select();
        foreach ($adver_list as $k=>$adver) {
            $adver_list[$k]['pic'] = getAttachmentUrl($adver['pic']);
        }
        $pagebar = $p->show();

        $this->assign('adver_list',$adver_list);
        $this->assign('pagebar',$pagebar);

        $this->display();
    }

    //移动端广告管理
    public function wap_adver(){
        $adver = D('Adver');

        $cat_id = $this->getCatId('wap_tuan_adver',2);
        $where['cat_id'] = $cat_id;

        import('@.ORG.system_page');

        $count = $adver->where($where)->count('id');

        $p = new Page($count,10);
        $adver_list = $adver->where($where)->limit($p->firstRow.','.$p->listRows)->select();
        foreach ($adver_list as &$adver) {
            $adver['pic'] = getAttachmentUrl($adver['pic']);
        }
        $pagebar = $p->show();

        $this->assign('adver_list',$adver_list);
        $this->assign('pagebar',$pagebar);

        $this->display();
    }

    /***
     * 添加广告
     */
    public function adver_add(){
        $type = isset($_REQUEST['type'])?$_REQUEST['type']:'1';
        if($type==1){
            $adver_type = $this->getCatId('pc_tuan_adver',2);
        }elseif($type==2){
            $adver_type = $this->getCatId('wap_tuan_adver',2);
        }
        $this->assign('adver_type',$adver_type);
        if(IS_POST){
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

                $_POST['pic'] = 'adver/' . $rand_num.'/'.$uploadList[0]['savename'];
            }else{
                $this->frame_submit_tips(0,$upload->getErrorMsg());
            }
            $_POST['last_time'] = $_SERVER['REQUEST_TIME'];
            $database_adver = D('Adver');
            if($database_adver->data($_POST)->add()){
                // 清空缓存
                import('ORG.Util.Dir');
                Dir::delDirnotself('./cache');

                S('adver_list_'.$_POST['cat_id'],NULL);
                $this->frame_submit_tips(1,'添加成功！');
            }else{
                $this->frame_submit_tips(0,'添加失败！请重试~');
            }
        }
        $this->display();
    }

    /**
     * 广告编辑
     */
    public function adver_edit(){
        $database_adver = D('Adver');

        $condition_adver['id'] = $_REQUEST['id'];
        $now_adver = $database_adver->field(true)->where($condition_adver)->find();
        if(empty($now_adver)){
            $this->frame_error_tips('该广告不存在！');
        }
        $now_adver['pic'] = getAttachmentUrl($now_adver['pic']);

        if(IS_POST){
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

                    $_POST['pic'] = 'adver/' . $rand_num.'/'.$uploadList[0]['savename'];
                }else{
                    $this->frame_submit_tips(0,$upload->getErrorMsg());
                }
            }
            $_POST['last_time'] = $_SERVER['REQUEST_TIME'];
            $database_adver = D('Adver');
            if($database_adver->data($_POST)->save()){
                S('adver_list_'.$now_adver['cat_id'],NULL);
                if($_POST['pic']){
                    unlink('./upload/' . $now_adver['pic']);

                    $attachment_upload_type = C('config.attachment_upload_type');
                    // 删除又拍云服务器
                    if ($attachment_upload_type == '1') {
                        import('upyunUser', './source/class/upload/');
                        upyunUser::delete('/' . $now_adver['pic']);
                    }
                }

                // 清空缓存
                import('ORG.Util.Dir');
                Dir::delDirnotself('./cache');

                $this->frame_submit_tips(1,'编辑成功！');
            }else{
                $this->frame_submit_tips(0,'编辑失败！请重试~');
            }
        }

        $this->assign('now_adver',$now_adver);

        $this->display();
    }

    /**
     * 广告删除
     */
    public function adver_del(){
        $database_adver = D('Adver');
        $condition_adver['id'] = $_POST['id'];
        $now_adver = $database_adver->field(true)->where($condition_adver)->find();
        if($database_adver->where($condition_adver)->delete()){
            unlink('./upload/'.$now_adver['pic']);

            $attachment_upload_type = C('config.attachment_upload_type');
            // 删除又拍云服务器
            if ($attachment_upload_type == '1') {
                import('upyunUser', './source/class/upload/');
                upyunUser::delete('/' . $now_adver['pic']);
            }

            S('adver_list_'.$now_adver['cat_id'],NULL);

            // 清空缓存
            import('ORG.Util.Dir');
            Dir::delDirnotself('./cache');

            $this->success('删除成功');
        }else{
            $this->error('删除失败！请重试~');
        }
    }

    /**
     * 通过分类标示获得分类id
     * @param $cat_key
     * @param $cat_type
     * @return mixed
     */
    public function getCatId($cat_key,$cat_type){
        $adverCategory = D('Adver_category');

        $where = array();
        if(isset($cat_key)){
            $where['cat_key'] = $cat_key;
        };
        if(isset($cat_type)){
            $where['cat_type'] = $cat_type;
        }

        $rs = $adverCategory->where($where)->field('cat_id')->find();
        if($rs){
            return $rs['cat_id'];
        }
    }

    /**
     * 导航列表
     */
    public function nav(){
        $database_slider_category  = D('Slider_category');
        $category_list = $database_slider_category->field('cat_id,cat_name,cat_key')->where(array('cat_type'=>2))->select();
        $this->assign('category_list',$category_list);
        $this->display();
    }

    /**
     * 热门关键词分类
     */
    public function wordsList(){
        $database_search_hot = D('Search_hot');
        $search_hot_list = $database_search_hot->where(array('cat_type'=>2))->order('`sort` DESC,`id` ASC')->select();
        $this->assign('cat_id',$cat_id);
        $this->assign('search_hot_list',$search_hot_list);

        $this->display('words_list');
    }

    /**
     * 热门关键词添加
     */
    public function words_add(){
        $cat_id = isset($_REQUEST['cat_id'])? $_REQUEST['cat_id'] : 1 ;

        if(IS_POST){
            $_POST['add_time'] = $_SERVER['REQUEST_TIME'];
            $database_search_hot = D('Search_hot');
            if($database_search_hot->data($_POST)->add()){
                S('search_hot_list',NULL);

                // 清空缓存
                import('ORG.Util.Dir');
                Dir::delDirnotself('./cache');

                $this->success('添加成功！');
            }else{
                $this->error('添加失败！请重试~');
            }
        }

        $this->assign('cat_id',$cat_id);

        $this->display();
    }

    /**
     * 热门关键词编辑
     */
    public function cat_edit(){
        $search_hot_category = D('Search_hot_category');

        $where['id'] = $_GET['cat_id'];

        $now_category = $search_hot_category->where($where)->find();

        $this->assign('now_category',$now_category);

        $this->display();
    }

    /**
     * 拼团首页
     */
    public function home(){
        $fid = isset($_REQUEST['fid'])? $_REQUEST['fid'] : 0 ;

        $activity_home_category = D('Activity_home_category');
        $tuan_category_list = $activity_home_category->where(array('fid'=>$fid,'cat_type'=>1))->select();
        foreach($tuan_category_list as $k=>$v){
            $child = $activity_home_category->where(array('fid'=>$v['cat_id']))->count('cat_id');
            if($child>0){
                $tuan_category_list[$k]['show'] = 1;
            }else{
                $tuan_category_list[$k]['show'] = 0;
            }
        }

        $this->assign('tuan_category_list',$tuan_category_list);

        $this->display('tuancat_list');
    }

    /**
     * 拼团分类管理
     */
    public function tuancat_edit(){
        $activity_home_category = D('Activity_home_category');

        $cat_id = isset($_REQUEST['cat_id'])? $_REQUEST['cat_id'] : 0 ;

        if(IS_POST){
            $cat_name = isset($_REQUEST['cat_name'])? $_REQUEST['cat_name'] : '' ;
            $rs = $activity_home_category->where(array('cat_id'=>$cat_id))->data(array('cat_name'=>$cat_name))->save();
            if($rs){
                $this->success('编辑成功！');
            }else{
                $this->error('编辑失败！请重试~');
            }
        }

        $where['cat_id'] = $cat_id;
        $tuan_category_detail = $activity_home_category->where($where)->field('cat_name,cat_id')->find();

        $this->assign('tuan_category_detail',$tuan_category_detail);
        $this->display();
    }

    /**
     * 团购活动列表
     */
    public function tuan_list(){
        $cat_id = isset($_REQUEST['cat_id'])? $_REQUEST['cat_id'] : 1 ;
        //团购分类
        $activity_home_category = D('Activity_home_category');
        $where['cat_id'] = $_GET['cat_id'];
        $now_category = $activity_home_category->where($where)->field('cat_id,cat_name,cat_num,fid')->find();
        $this->assign('now_category',$now_category);
        //团购列表
        $activity_home = D('Activity_home');
        $where['cat_id'] = $cat_id;

        import('@.ORG.system_page');

        $count = $activity_home->where($where)->count('id');

        $p = new Page($count,10);
        $tuan_home_lists = $activity_home->where($where)->limit($p->firstRow.','.$p->listRows)->select();
        foreach ($tuan_home_lists as $k=>$tuan_home_list) {
            $productinfo = $this->getProductById($tuan_home_list['product_id']);
            $tuan_home_lists[$k]['product_name'] = $productinfo['name'];
            $tuan_home_lists[$k]['price'] = $productinfo['price'];
            $tuan_home_lists[$k]['image'] = getAttachmentUrl($productinfo['image']);
            $tuaninfo = $this->getTuanById($tuan_home_list['activity_id']);
            $tuan_home_lists[$k]['tuan_name'] = $tuaninfo['name'];
            $tuan_home_lists[$k]['tuan_status'] = $tuaninfo['status'];
            $tuan_home_lists[$k]['tuan_start_time'] = $tuaninfo['start_time'];
            $tuan_home_lists[$k]['tuan_end_time'] = $tuaninfo['end_time'];
        }

        $pagebar = $p->show();

        $this->assign('time',time());
        $this->assign('tuan_home_lists',$tuan_home_lists);
        $this->assign('pagebar',$pagebar);

        $this->display();
    }

    /**
     * 团购活动添加
     */
    public function tuan_add(){
        $cat_id = isset($_REQUEST['cat_id'])? $_REQUEST['cat_id'] : 1 ;

        $tuan = D('Tuan');
        $tuanhome = D('Activity_home');
        $tuan_lists = array();
        $where = array();
        $where['status'] = 1;
        $time = time();
        $where['end_time'] = array('gt',$time);
        $where['start_time'] = array('lt',$time);

        if($_REQUEST['type']=='tuan_id'){
            $where['name'] = array('like','%'.$_REQUEST['keyword'].'%');
        }elseif($_REQUEST['type']=='store_id'){
            $where['store_id'] = $this->getStoreIdByName($_REQUEST['keyword']);
            if(!$where['store_id']){
                $this->assign('cat_id',$cat_id);
                $this->assign('tuan_lists',$tuan_lists);
                $this->assign('pagebar',$pagebar);

                $this->display();return;
            }
        }

        //已经被添加的推荐活动在列表中筛选掉
        $tuanhomelist = $tuanhome->where(array('cat_id'=>$cat_id))->field('activity_id')->select();
        $homearr = array();
        foreach($tuanhomelist as $k=>$v){
            array_push($homearr,$v['activity_id']);
        };
        if(!empty($homearr)){
            $where['id'] = array('not in',$homearr);
        };

        import('@.ORG.system_page');

        $count = $tuan->where($where)->count('id');

        $p = new Page($count,10);
        $tuan_lists = $tuan->where($where)->limit($p->firstRow.','.$p->listRows)->select();
        foreach ($tuan_lists as $k=>$tuan_list) {
            $productinfo = $this->getProductById($tuan_list['product_id']);
            $tuan_lists[$k]['product_name'] = $productinfo['name'];
            $tuan_lists[$k]['price'] = $productinfo['price'];
            $storeinfo = $this->getStoreById($tuan_list['store_id']);
            $tuan_lists[$k]['store_name'] = $storeinfo['name'];
        }
        $pagebar = $p->show();

        $this->assign('cat_id',$cat_id);
        $this->assign('tuan_lists',$tuan_lists);
        $this->assign('pagebar',$pagebar);

        $this->display();
    }

    /**
     * 获取商品信息
     * @param $product_id
     * @return array|bool|mixed
     */
    public function getProductById($product_id){
        $product = D('Product');
        $where['product_id'] = $product_id;
        $rs = $product->where($where)->field('name,price,image')->find();
        return $rs;
    }

    /**
     * 获取店铺信息
     * @param $store_id
     * @return array|bool|mixed
     */
    public function getStoreById($store_id){
        $store = D('Store');
        $where['store_id'] = $store_id;
        $rs = $store->where($where)->field('name')->find();
        return $rs;
    }

    /**
     * 获取团购信息
     * @param $id
     * @return array|bool|mixed
     */
    public function getTuanById($id){
        $tuan = D('Tuan');
        $where['id'] = $id;
        $rs = $tuan->where($where)->field('name,store_id,status,end_time,start_time')->find();
        return $rs;
    }

    /**
     * 获取店铺id
     * @param $storeName
     * @return mixed
     */
    public function getStoreIdByName($storeName){
        $store = D('store');
        $where['name'] = $storeName;

        $rs = $store->where($where)->find();
        if($rs){
            return $rs['store_id'];
        }else{
            return false;
        }
    }

    /**
     * 推荐团购活动
     */
    public function rcmd_tuan(){
        $tid = isset($_REQUEST['tid'])? $_REQUEST['tid'] : 1 ;
        $cat_id = isset($_REQUEST['cat_id'])? $_REQUEST['cat_id'] : 1 ;
        $product_id = isset($_REQUEST['product_id'])? $_REQUEST['product_id'] : 1 ;

        $activity_home = D('Activity_home');
        $activity_home_data = $activity_home->where(array('cat_id'=>$cat_id,'activity_id'=>$tid))->find();
        if($activity_home_data){
            $this->frame_submit_tips(1,'重复点击！');
            return false;
        }

        $data['cat_id'] = $cat_id;
        $data['activity_id'] = $tid;
        $data['product_id'] = $product_id;
        $data['last_time'] = time();
        $data['status'] = 0;

        $rs = $activity_home->data($data)->add();
        if($rs){
            $this->frame_submit_tips(1,'推荐成功！');
        }else{
            $this->frame_submit_tips(0,'推荐失败！');
        }
    }

    /**
     * 推荐多个团购活动
     */
    public function rcmd_tuan_all(){
        $tid = isset($_REQUEST['tid'])? $_REQUEST['tid'] : 1 ;
        $cat_id = isset($_REQUEST['cat_id'])? $_REQUEST['cat_id'] : 1 ;
        $product_id = isset($_REQUEST['product_id'])? $_REQUEST['product_id'] : 1 ;

        $activity_home = D('Activity_home');

        foreach($tid as $key=>$value){
            $data = array();
            $data['cat_id'] = $cat_id[$key];
            $data['activity_id'] = $tid[$key];
            $data['product_id'] = $product_id[$key];
            $data['last_time'] = time();
            $data['status'] = 0;
            $datas[] = $data;
        }

        $rs = $activity_home->addAll($datas);
        if($rs){
            $this->frame_submit_tips(1,'推荐成功！');
        }else{
            $this->frame_submit_tips(0,'推荐失败！');
        }
    }

    /**
     * 推荐和取消推荐团购活动
     */
    public function tuan_status(){
        $activity_home = D('Activity_home');

        $status = isset($_REQUEST['status'])?$_REQUEST['status']:0;
        $id = isset($_REQUEST['id'])?$_REQUEST['id']:0;

        $where['id'] = $id;
        $data['status'] = $status;

        $activity_home->where($where)->data($data)->save();
    }

    /**
     * 删除推荐团购活动
     */
    public function tuan_del(){
        $activity_home = D('Activity_home');

        $id = isset($_REQUEST['id'])?$_REQUEST['id']:0;

        $where['id'] = $id;

        $rs = $activity_home->where($where)->delete();
        if($rs){
            $this->success('删除成功！');
        }else{
            $this->success('删除失败！');
        }
    }

    public function banner(){
        $category = M('ProductCategory');

        $where = array();
        $where['cat_fid'] = 0;

        $category_count = $category->where($where)->count('cat_id');
        import('@.ORG.system_page');
        $page = new Page($category_count, 30);
        $categories = $category->where($where)->order('cat_fid ASC,`cat_sort` asc,`cat_id` ASC')->field('cat_id,cat_name,cat_wap_banner')->select();
        foreach ($categories as $k=>$v) {
            $categories[$k]['cat_wap_banner'] = getAttachmentUrl($v['cat_wap_banner']);
        }

        $this->assign('categories', $categories);
        $this->assign('page', $page->show());

        $this->display('wap_banner_list');
    }

    public function wap_banner_edit(){
        $category = M('ProductCategory');

        if (IS_POST) {

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

                    $_POST['pic'] = 'adver/' . $rand_num.'/'.$uploadList[0]['savename'];
                }else{
                    $this->frame_submit_tips(0,$upload->getErrorMsg());
                }
            }
            if($category->where(array('cat_id'=>$_POST['cat_id']))->data(array('cat_wap_banner'=>$_POST['pic']))->save()){
                //S('adver_list_'.$now_adver['cat_id'],NULL);
                if($_POST['pic']){
                    unlink('./upload/' . $now_adver['pic']);

                    $attachment_upload_type = C('config.attachment_upload_type');
                    // 删除又拍云服务器
                    if ($attachment_upload_type == '1') {
                        import('upyunUser', './source/class/upload/');
                        upyunUser::delete('/' . $now_adver['pic']);
                    }
                }

                // 清空缓存
                import('ORG.Util.Dir');
                Dir::delDirnotself('./cache');

                $this->frame_submit_tips(1,'编辑成功！');
            }else{
                $this->frame_submit_tips(0,'编辑失败！请重试~');
            }

        }

        $cat_id = isset($_REQUEST['cat_id'])?$_REQUEST['cat_id']:'0';
        $where = array();
        $where['cat_id'] = $cat_id;

        $categorydetail = $category->where($where)->field('cat_id,cat_name,cat_wap_banner')->find();
        $categorydetail['cat_wap_banner'] = getAttachmentUrl($categorydetail['cat_wap_banner']);

        $this->assign('categorydetail', $categorydetail);

        $this->display();
    }
}
