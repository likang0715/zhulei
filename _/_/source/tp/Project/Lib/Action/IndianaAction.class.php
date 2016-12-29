<?php
/*
 * 一元夺宝管理
 */
class IndianaAction extends BaseAction{

    //PC端广告管理
    public function adver(){
        $adver = D('Adver');

        $cat_id = $this->getCatId('pc_indiana_adver',3);
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

        $cat_id = $this->getCatId('wap_indiana_adver',3);
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
            $adver_type = $this->getCatId('pc_indiana_adver',3);
        }elseif($type==2){
            $adver_type = $this->getCatId('wap_indiana_adver',3);
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
     * 导航分类列表
     */
    public function nav(){
        $database_slider_category  = D('Slider_category');
        $where['cat_type'] = 3;
        $category_list = $database_slider_category->field(true)->where($where)->order('`cat_id` ASC')->select();
        $this->assign('category_list',$category_list);
        $this->display('cat_list');
    }

    /**
     *导航列表
     */
    public function nav_list(){
        $nav_cat = D('Slider_category');
        $nav = D('Slider');

        $cat_id = isset($_REQUEST['cat_id'])? $_REQUEST['cat_id'] : 1 ;

        $now_category = $nav_cat->where(array('cat_id'=>$cat_id))->field('cat_id,cat_name')->find();

        $nav_lists = $nav->field(true)->where(array('cat_id'=>$cat_id))->order('`sort` asc,`id` asc')->select();
        foreach ($nav_lists as $k=>$v) {
            $nav_lists[$k]['pic'] = getAttachmentUrl($nav_lists[$k]['pic']);
        }

        $this->assign('now_category',$now_category);
        $this->assign('nav_lists',$nav_lists);

        $this->display();
    }

    /**
     * 一元夺宝首页
     */
    public function home(){
        $fid = isset($_REQUEST['fid'])? $_REQUEST['fid'] : 0 ;

        $activity_home_category = D('Activity_home_category');
        //获取父类信息
        $where['cat_id'] = $fid;
        $activity_category_detail = $activity_home_category->where($where)->find();
        $this->assign("activity_category_detail",$activity_category_detail);
        //
        unset($where);
        $where['fid'] = $fid;
        $where['cat_type'] = 2;
        $activity_category_list = $activity_home_category->where($where)->select();

        foreach($activity_category_list as $k=>$v){
            $child = $activity_home_category->where(array('fid'=>$v['cat_id']))->count('cat_id');
            if($child>0){
                $activity_category_list[$k]['show'] = 1;
            }else{
                $activity_category_list[$k]['show'] = 0;
            }
        }

        $this->assign('activity_category_list',$activity_category_list);

        $this->display('indianacat_list');
    }

    /**
     * 一元夺宝分类添加管理
     */
    public function indianacat_add(){
        $cat_id = isset($_REQUEST['cat_id'])? $_REQUEST['cat_id'] : 0 ;

        $activity_home_category = D("Activity_home_category");
        //获取商品一级分类
        $categoryList = array();
        $categoryList = M("Product_category")->where(array("cat_fid"=>0,"status"=>1))->field('cat_id,cat_name')->select();

        if(IS_POST){
            $_POST['cat_type'] = 2;
            $rs = $activity_home_category->data($_POST)->add();
            if($rs){
                $this->success('添加成功！');
            }else{
                $this->error('添加失败！请重试~');
            }
        }

        $this->assign("cat_id",$cat_id);
        $this->assign("categoryList",$categoryList);

        $this->display();
    }

    /**
     * 一元夺宝分类编辑管理
     */
    public function indianacat_edit(){
        $activity_home_category = D('Activity_home_category');

        $cat_id = isset($_REQUEST['cat_id'])? $_REQUEST['cat_id'] : 0 ;
        //获取商品一级分类
        $categoryList = array();
        $categoryList = M("Product_category")->where(array("cat_fid"=>0,"status"=>1))->field('cat_id,cat_name')->select();

        if(IS_POST){
            $data['cat_name'] = isset($_POST['cat_name'])? $_POST['cat_name'] : '' ;
            $data['cat_num'] = isset($_POST['cat_num'])? $_POST['cat_num'] : '5' ;
            $data['product_category'] = isset($_POST['product_category'])? $_POST['product_category'] : '1' ;
            $rs = $activity_home_category->where(array('cat_id'=>$cat_id))->data($data)->save();
            if($rs){
                $this->success('编辑成功！');
            }else{
                $this->error('编辑失败！请重试~');
            }
        }

        $where['cat_id'] = $cat_id;
        $activity_category_detail = $activity_home_category->where($where)->field('cat_name,cat_id,cat_num,product_category')->find();

        $this->assign('activity_category_detail',$activity_category_detail);
        $this->assign("categoryList",$categoryList);
        $this->display();
    }

    /**
     * 一元夺宝活动列表
     */
    public function indiana_list(){
        $cat_id = isset($_REQUEST['cat_id'])? $_REQUEST['cat_id'] : 1 ;
        //一元夺宝分类
        $activity_home_category = D('Activity_home_category');
        $where['cat_id'] = $cat_id;
        $now_category = $activity_home_category->where($where)->field('cat_id,cat_name,cat_num,fid')->find();
        $this->assign('now_category',$now_category);

        //一元夺宝列表
        $activity_home = D('Activity_home');
        $where['cat_id'] = $cat_id;

        import('@.ORG.system_page');

        $count = $activity_home->where($where)->count('id');

        $p = new Page($count,10);
        $activity_home_lists = $activity_home->where($where)->limit($p->firstRow.','.$p->listRows)->select();
        foreach ($activity_home_lists as $k=>$activity_home_list) {
            $activity_home_lists[$k]['activity_adver'] = getAttachmentUrl($activity_home_list['activity_adver']);
            $productinfo = $this->getProductById($activity_home_list['product_id']);
            $activity_home_lists[$k]['product_name'] = $productinfo['name'];
            $activity_home_lists[$k]['price'] = $productinfo['price'];
            $activity_home_lists[$k]['image'] = getAttachmentUrl($productinfo['image']);
            $activityinfo = $this->getUnitaryInfoById($activity_home_list['activity_id']);
            $activity_home_lists[$k]['activity_name'] = $activityinfo['name'];
            $activity_home_lists[$k]['activity_status'] = $activityinfo['state'];
        }
        $pagebar = $p->show();

        $this->assign('activity_home_lists',$activity_home_lists);
        $this->assign('pagebar',$pagebar);

        $this->display();
    }

    /**
     * 一元夺宝活动添加
     */
    public function indiana_add(){
        $cat_id = isset($_REQUEST['cat_id'])? $_REQUEST['cat_id'] : 1 ;

        $unitary = D('Unitary');
        $activityhome = D('Activity_home');
        $database_activityhomecategory = D('Activity_home_category');
        $activity_lists = array();
        $where = array();

        //筛选大类下的活动
        $activity_category = $database_activityhomecategory->where(array('cat_id'=>$cat_id))->field('product_category')->find();
        if($activity_category['product_category']!=0){
            $where['cat_fid'] = $activity_category['product_category'];
        }

        //筛选框
        if($_REQUEST['type']=='activity_id'){
            $where['name'] = array('like','%'.$_REQUEST['keyword'].'%');
        }elseif($_REQUEST['type']=='store_id' && $_REQUEST['keyword']!=''){
            $where['store_id'] = $this->getStoreIdByName($_REQUEST['keyword']);
            if(!$where['store_id']){
                $this->assign('cat_id',$cat_id);
                $this->assign('activity_lists',$activity_lists);
                $this->assign('pagebar',$pagebar);

                $this->display();return;
            }
        }

        //已经被添加的推荐活动在列表中筛选掉
        $activityhomelist = $activityhome->where(array('cat_id'=>$cat_id))->field('activity_id')->select();
        $homearr = array();
        foreach($activityhomelist as $k=>$v){
            array_push($homearr,$v['activity_id']);
        };
        if(!empty($homearr)){
            $where['id'] = array('not in',$homearr);
        };
        //$activityhome

        import('@.ORG.system_page');

        $where['state'] = 1;
        $count = $unitary->where($where)->count('id');

        $p = new Page($count,10);
        $activity_lists = $unitary->where($where)->limit($p->firstRow.','.$p->listRows)->select();
        foreach ($activity_lists as $k=>$activity_list) {
            $productinfo = $this->getProductById($activity_list['product_id']);
            $activity_lists[$k]['product_name'] = msubstr($productinfo['name'],0,25,false);
            $activity_lists[$k]['price'] = $productinfo['price'];
            $storeinfo = $this->getStoreById($activity_list['store_id']);
            $activity_lists[$k]['store_name'] = $storeinfo['name'];
        }
        $pagebar = $p->show();

        $this->assign('cat_id',$cat_id);
        $this->assign('activity_lists',$activity_lists);
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
     * 推荐一元夺宝活动
     */
    public function rcmd_indiana(){
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
     * 推荐多个一元夺宝活动
     */
    public function rcmd_indiana_all(){
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
     * 推荐和取消推荐一元夺宝活动
     */
    public function activity_status(){
        $activity_home = D('activity_home');

        $status = isset($_REQUEST['status'])?$_REQUEST['status']:0;
        $id = isset($_REQUEST['id'])?$_REQUEST['id']:0;

        $where['id'] = $id;
        $data['status'] = $status;

        $activity_home->where($where)->data($data)->save();
    }

    /**
     * 推荐和取消推荐一元夺宝活动
     */
    public function activity_rcmd(){
        $activity_home = D('activity_home');

        $rcmd = isset($_REQUEST['rcmd'])?$_REQUEST['rcmd']:0;
        $id = isset($_REQUEST['id'])?$_REQUEST['id']:0;

        $where['id'] = $id;
        $data['rcmd'] = $rcmd;

        $activity_home->where($where)->data($data)->save();
    }

    /**
     * 删除推荐活动
     */
    public function activity_del(){
        $activity_home = D('activity_home');

        $id = isset($_REQUEST['id'])?$_REQUEST['id']:0;

        $where['id'] = $id;

        $rs = $activity_home->where($where)->delete();
        if($rs){
            $this->success('删除成功！');
        }else{
            $this->success('删除失败！');
        }
    }

    public function indiana_adver_edit(){
        $activityhome = D('Activity_home');

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
            if($activityhome->where(array('id'=>$_POST['id']))->data(array('activity_adver'=>$_POST['pic']))->save()){
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

        $categorydetail = array();
        if(isset($_REQUEST['id'])){
            $id = isset($_REQUEST['id'])?$_REQUEST['id']:'0';
            $where = array();
            $where['id'] = $id;

            $categorydetail = $activityhome->where($where)->field('id,activity_adver')->find();
            $categorydetail['activity_adver'] = getAttachmentUrl($categorydetail['activity_adver']);
        }

        $this->assign('categorydetail', $categorydetail);

        $this->display();
    }

    public function icon(){
        $category = M('ProductCategory');

        $where = array();
        $where['cat_fid'] = 0;

        $category_count = $category->where($where)->count('cat_id');
        import('@.ORG.system_page');
        $page = new Page($category_count, 30);
        $categories = $category->where($where)->order('cat_fid ASC,`cat_sort` asc,`cat_id` ASC')->field('cat_id,cat_name,cat_indiana_pic,cat_indiana_adver')->select();
        foreach ($categories as $k=>$v) {
            $categories[$k]['cat_indiana_pic'] = getAttachmentUrl($v['cat_indiana_pic']);
            $categories[$k]['cat_indiana_adver'] = getAttachmentUrl($v['cat_indiana_adver']);
        }

        $this->assign('categories', $categories);
        $this->assign('page', $page->show());

        $this->display();
    }

    public function wap_banner_edit(){
        $category = M('ProductCategory');

        if (IS_POST) {
            //图标
            if ($_FILES['pic']['error'] != 4 || $_FILES['pic_adver']['error'] != 4) {
                //上传图片
                $rand_num = date('Y/m', $_SERVER['REQUEST_TIME']);
                $upload_dir = './upload/category/' . $rand_num . '/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                import('ORG.Net.UploadFile');
                $upload = new UploadFile();
                $upload->maxSize = 10 * 1024 * 1024;
                $upload->allowExts = array('jpg', 'jpeg', 'png', 'gif');
                $upload->allowTypes = array('image/png', 'image/jpg', 'image/jpeg', 'image/gif');
                $upload->savePath = $upload_dir;
                $upload->saveRule = 'uniqid';
                if ($upload->upload()) {
                    $uploadList = $upload->getUploadFileInfo();

                    // 上传到又拍云服务器
                    $attachment_upload_type = C('config.attachment_upload_type');
                    if ($attachment_upload_type == '1') {
                        import('upyunUser', './source/class/upload/');
                        upyunUser::upload('./upload/category/' . $rand_num . '/' . $uploadList[0]['savename'], '/category/' . $rand_num . '/' . $uploadList[0]['savename']);
                    }

                    $j = 0;
                    if ($_FILES['pic']['error'] != 4) {
                        $data['pic'] = 'category/' . $rand_num . '/' . $uploadList[$j]['savename'];
                        $j = 1;
                    }
                    if ($_FILES['pic_adver']['error'] != 4) {
                        $data['pic_adver'] = 'category/' . $rand_num . '/' . $uploadList[$j]['savename'];
                    }
                } else {
                    $this->frame_submit_tips(0, $upload->getErrorMsg());
                }
            }
            if(isset($data['pic'])){
                $_POST['cat_indiana_pic'] = $data['pic'];
            }
            if(isset($data['pic_adver'])){
                $_POST['cat_indiana_adver'] = $data['pic_adver'];
            }
            if($category->where(array('cat_id'=>$_POST['cat_id']))->data($_POST)->save()){

                if($_POST['pic']){
                    unlink('./upload/' . $_POST['pic']);

                    $attachment_upload_type = C('config.attachment_upload_type');
                    // 删除又拍云服务器
                    if ($attachment_upload_type == '1') {
                        import('upyunUser', './source/class/upload/');
                        upyunUser::delete('/' . $_POST['pic']);
                    }
                }
                if($_POST['pic_adver']){
                    unlink('./upload/' . $_POST['pic_adver']);

                    $attachment_upload_type = C('config.attachment_upload_type');
                    // 删除又拍云服务器
                    if ($attachment_upload_type == '1') {
                        import('upyunUser', './source/class/upload/');
                        upyunUser::delete('/' . $_POST['pic_adver']);
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

        $categorydetail = $category->where($where)->field('cat_id,cat_name,cat_indiana_pic,cat_indiana_adver')->find();
        $categorydetail['cat_indiana_pic_url'] = getAttachmentUrl($categorydetail['cat_indiana_pic']);
        $categorydetail['cat_indiana_adver_url'] = getAttachmentUrl($categorydetail['cat_indiana_adver']);

        $this->assign('categorydetail', $categorydetail);

        $this->display();
    }

    //活动图片列表
    public function activityIcon(){
        $database_activity_icon = D('Activity_icon');
        $activity_icon_list = $database_activity_icon->where(array('type'=>1))->select();
        foreach($activity_icon_list as $ack=>$acv){
            $activity_icon_list[$ack]['imgurl'] = getAttachmentUrl($acv['imgurl']);
        }
        $this->assign('activity_icon_list',$activity_icon_list);

        $this->display('indiana_activity_icon');
    }

    //活动图标添加
    public function activityIcon_add(){
        $database_activity_icon = D('Activity_icon');

        $record = $database_activity_icon->where(array('key'=>$_POST['key']))->find();

        if($record){
            $this->frame_submit_tips(0,'相同的图标价格已添加');
        }

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

                    $_POST['imgurl'] = 'adver/' . $rand_num.'/'.$uploadList[0]['savename'];
                    $_POST['type'] = 1;
                }else{
                    $this->frame_submit_tips(0,$upload->getErrorMsg());
                }
            }

            $rs = $database_activity_icon->data($_POST)->add();

            if($rs){
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

        $this->display('indiana_activity_icon_add');
    }

    //活动图标编辑
    public function activityIcon_edit(){
        $database_activity_icon = D('Activity_icon');

        $where['id'] = $_REQUEST['id'];
        $activity_icon_detail = $database_activity_icon->where($where)->find();
        $activity_icon_detail['imgurl'] = getAttachmentUrl($activity_icon_detail['imgurl']);

        if(IS_POST){

             $record = $database_activity_icon->where(array('key'=>$_POST['key']))->find();

            if($record && $_POST['key'] != $activity_icon_detail['key']){
                $this->frame_submit_tips(0,'相同的图标价格已添加');
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

                    $_POST['imgurl'] = 'adver/' . $rand_num.'/'.$uploadList[0]['savename'];
                }else{
                    $this->frame_submit_tips(0,$upload->getErrorMsg());
                }
            }
            $_POST['type'] = 1;

            $rs = $database_activity_icon->where(array('id'=>$_POST['id']))->data($_POST)->save();

            if($rs){
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

        $this->assign('activity_icon_detail',$activity_icon_detail);
        $this->display('indiana_activity_icon_edit');
    }

    //删除图标管理
    public function activityIcon_del(){
        $database_activity_icon = D('Activity_icon');

        $where['id'] = $_REQUEST['id'];

        $rs = $database_activity_icon->where($where)->delete();
        if($rs){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

    //获取一元夺宝基本信息
    public function getUnitaryInfoById($activity_id) {
        $unitary = D('Unitary');
        $where['id'] = $activity_id;
        $result = $unitary->where($where)->find();
        return $result;
    }

    //编辑什么是一元夺宝
    public function about(){
        $this->display();
    }
}
