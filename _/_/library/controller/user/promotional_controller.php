<?php
/**
 * 推广管理
 */
class promotional_controller extends base_controller {
    // 加载
    public function load() {
        $action = strtolower(trim($_POST['page']));

        if (empty($action)) pigcms_tips('非法访问！', 'none');

        switch ($action) {
            case 'promotional_list' :
                $this->promotional_list();
                break;
            default:
                break;
        }

        $this->display($_POST['page']);
    }

    public function index() {

        $this->display();
    }

    /**
     * 海报列表
     */
    private function promotional_list(){
        $store_promote_setting = D('Store_promote_setting');
        $name = !empty($_POST['keyword']) ? $_POST['keyword'] : '';
        $where = array();
        if($name){
            $where['name'] = array('like','%'.$name.'%');
         }
        $where['status'] = 1;
        $where['owner'] = 1;
        $where['store_id'] = $this->store_session['store_id'];
        $promote_list = $store_promote_setting->where($where)->select();

        $this->assign('promote_list', $promote_list);
    }

    /**
     * 添加海报
     */
    public function add()
    {
        $this->display();
    }

    /**
     * 添加数据处理
     */
    public function shop_promotion_add(){
        if (IS_POST) {
            $pigcms_id = !empty($_POST['pigcms_id']) ? $_POST['pigcms_id'] : '';

            $result = D('Store_promote_setting')->where(array('store_id'=>$this->store_session['store_id'],'pigcms_id'=>$pigcms_id))->find();
            $data['name'] = !empty($_POST['name']) ? $_POST['name'] : '';
            $data['store_nickname'] = !empty($_POST['store_name']) ? $_POST['store_name'] : '';
            $data['store_id'] = $this->store_session['store_id'];
            $data['start_time'] = !empty($_POST['start_time']) ? strtotime($_POST['start_time']) : '';
            $data['end_time'] = !empty($_POST['end_time']) ? strtotime($_POST['end_time']) : '';
            $data['descr'] = !empty($_POST['descr']) ? $_POST['descr'] : '';
            $data['banner_config'] = !empty($_POST['banner_config']) ? $_POST['banner_config'] : '';
            $data['status'] = 1;
            $data['poster_type'] = !empty($_POST['poster_type']) ? $_POST['poster_type'] : '';
            $data['owner'] = 1;

            if(!D('Store_promote_setting')->where(array('store_id'=>$this->store_session['store_id'],'type'=>1,'status'=>1))->find()){
                $data['type'] = 1;
            }

            if($pigcms_id && $result){
                $data['update_time'] = time();
                if(!empty($result['type'])){
                    /*编辑海报内容 清空 media_id */
                    D('Store_media')->where(array('supplier_id'=>$this->store_session['store_id']))->data(array('media_id'=>''))->save();
                }
                $result = D('Store_promote_setting')->where(array('pigcms_id'=>$pigcms_id))->data($data)->save();

            } else {
                $data['create_time'] = time();
                $data['update_time'] = time();
                $result = D('Store_promote_setting')->data($data)->add();
            }
            if($result){
                json_return('0','保存成功');
            }
        }
    }

    /**
     * 编辑海报
     */
    public function edit()
    {
        $id = $_GET['pigcms_id'];
        $store_info = D('Store')->where(array('store_id'=>$this->store_session['store_id']))->find();

        $promote = D('Store_promote_setting')->where(array('store_id'=>$this->store_session['store_id'],'pigcms_id'=>$id))->find();

        $this->assign('promote' ,$promote);
        $this->assign('store_info' ,$store_info);

        $this->display('add');
    }

    /**
     * 删除
     */
    public function detach(){

        $pigcms_id = !empty($_POST['pigcms_id']) ? $_POST['pigcms_id'] : '';
        $result = D('Store_promote_setting')->where(array('pigcms_id'=>$pigcms_id,'owner'=>1))->data(array('status'=>2))->save();
        if($result){
            json_return('0','删除成功');
        } else {
            json_return('1001','删除失败');
        }
    }

    public function enable(){
        $pigcms_id = !empty($_POST['pigcms_id']) ? $_POST['pigcms_id'] : '';
        $type = !empty($_POST['type']) ? $_POST['type'] : '';
        if($type == 1){
            $enable = D('Store_promote_setting')->where(array('store_id'=>$this->store_session['store_id'],'type'=>1,'owner'=>1))->find();
            if($enable){
                D('Store_promote_setting')->where(array('store_id'=>$this->store_session['store_id'],'type'=>1,'owner'=>1))->data(array('type'=>0))->save();
                $result = D('Store_promote_setting')->where(array('store_id'=>$this->store_session['store_id'],'pigcms_id'=>$pigcms_id,'owner'=>1))->data(array('type'=>1))->save();
                /*编辑海报内容 清空 media_id */
                D('Store_media')->where(array('supplier_id'=>$this->store_session['store_id']))->data(array('media_id'=>''))->save();
            } else {
                $result = D('Store_promote_setting')->where(array('store_id'=>$this->store_session['store_id'],'pigcms_id'=>$pigcms_id,'owner'=>1))->data(array('type'=>1))->save();
                /*编辑海报内容 清空 media_id */
                D('Store_media')->where(array('supplier_id'=>$this->store_session['store_id']))->data(array('media_id'=>''))->save();

            }
            if($result){
                json_return('0','启用成功');
            } else {
                json_return('1001','启用失败');
            }
        } elseif (empty($type)){
            $result = D('Store_promote_setting')->where(array('store_id'=>$this->store_session['store_id'],'pigcms_id'=>$pigcms_id,'owner'=>1))->data(array('type'=>0))->save();
            /*编辑海报内容 清空 media_id */
            D('Store_media')->where(array('supplier_id'=>$this->store_session['store_id']))->data(array('media_id'=>''))->save();
            if($result){
                json_return('0','关闭成功');
            } else {
                json_return('1001','关闭失败');
            }
        }

    }


    //上传文件
    public function uploadFile()
    {
        import('source.class.upload');
        import('source.class.Image');
        if(empty($_FILES['file']))
            $this->ajaxReturn(array('info'=>'上传文件不存在','status'=>0));
        $upload = new Upload();

        $upload->maxSize = 2*1024*1024;
        $upload->autoSub=true;
        $uploadPath='./upload/images/promote_qrcode'.$this->token.'/';// 设置附件上传目录
        $upload->savePath = $uploadPath;
        if(!file_exists($uploadPath))
        {
            mkdir($uploadPath,0777,true);
        }
        $upload->allowExts=array('jpg','jpeg','png','gif');
        if(!$upload->upload())
        {
            $this->ajaxReturn(array('status'=>0,'info'=>$upload->getErrorMsg()));
        }
        $info=$upload->getUploadFileInfo();
        $image = new Image();
        $imgPath=$info[0]['savepath'].$info[0]['savename'];
        $dirName=dirname($imgPath);
        $imgName=basename($imgPath);
        $sizeArr=array(array(400,256),array(320,500),array(320,320));
        $pathData=array('path'=>$this->siteUrl.ltrim($info[0]['savepath'],'.').$info[0]['savename']);
        $targetWidth=900;
        for($i=0;$i<count($sizeArr);$i++)
        {
            if(!file_exists($dirName."/{$sizeArr[$i][0]}_{$sizeArr[$i][1]}"))
                mkdir($dirName."/{$sizeArr[$i][0]}_{$sizeArr[$i][1]}",0777,true);
            $image->thumb2($imgPath,$dirName."/{$sizeArr[$i][0]}_{$sizeArr[$i][1]}/".$imgName,'',$sizeArr[$i][0],$sizeArr[$i][1]);
            $pathData["{$sizeArr[$i][0]}_{$sizeArr[$i][1]}"]=$this->siteUrl.ltrim($dirName,'.')."/{$sizeArr[$i][0]}_{$sizeArr[$i][1]}/".$imgName;
            //扩大到900
            $scale=$targetWidth/$sizeArr[$i][0];
            $scaleWidth=round($sizeArr[$i][0]*$scale);
            $scaleHeight=round($sizeArr[$i][1]*$scale);
            if(!file_exists($dirName."/{$scaleWidth}_{$scaleHeight}"))
                mkdir($dirName."/{$scaleWidth}_{$scaleHeight}",0777,true);
            $image->thumb2($imgPath,$dirName."/{$scaleWidth}_{$scaleHeight}/".$imgName,'',$scaleWidth,$scaleHeight);
        }

        //var_dump($pathData);
        $this->ajaxReturn(array('status'=>1,'info'=>'上传成功','data'=>$pathData));
    }

    /**
     * Ajax方式返回数据到客户端
     * @access protected
     * @param mixed $data 要返回的数据
     * @param String $type AJAX返回数据格式
     * @return void
     */
    protected function ajaxReturn($data,$type='') {
        if(func_num_args()>2) {// 兼容3.0之前用法
           // $args           =   func_get_args();
            array_shift($args);
            $info           =   array();
            $info['data']   =   $data;
            $info['info']   =   array_shift($args);
            $info['status'] =   array_shift($args);
            $data           =   $info;
           // $type           =   $args?array_shift($args):'';
        }

            // 返回JSON数据格式到客户端 包含状态信息
            header('Content-Type:text/html; charset=utf-8');
            exit(json_encode($data));
        /*}elseif(strtoupper($type)=='XML'){
            // 返回xml格式数据
            header('Content-Type:text/xml; charset=utf-8');
            exit(xml_encode($data));
        }elseif(strtoupper($type)=='EVAL'){
            // 返回可执行的js脚本
            header('Content-Type:text/html; charset=utf-8');
            exit($data);
        }else{
            // TODO 增加其它格式
        }*/
    }

}