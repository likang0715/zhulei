<?php
class bargain_controller extends base_controller {

    //加载
    public function load() {
        $action = strtolower(trim($_POST['page']));
        if (empty($action)) pigcms_tips('非法访问！', 'none');

        switch ($action) {
            case 'bargain_list': //砍价列表页
                $this->_bargain_list();
                break;
            case 'bargain_edit': //砍价编辑页面
                $this->_bargain_edit();
                break;
            case 'bargain_add' : //砍价添加页面
                $hash = rand(100000,999999);
                $_SESSION['hash'] = $hash;
                $this->assign('hash',$hash);
                break;
            default:
                break;
        }

        $this->display($_POST['page']);
    }

    /**
     * 砍价主页面
     */
    public function index(){
        $this->assign('select_sidebar','bargain');

        $this->display();
    }

    /**
     * 砍价商品列表
     */
    public function _bargain_list(){
        $token  = $this->getToken($_SESSION['store']['store_id']);
        $bargain_list = array();

        $page = $_REQUEST['p'] + 0;
        $page = max(1, $page);
        $limit = 10;
        $uid = $_SESSION['store']['uid'];
        $store_id = $_SESSION['store']['store_id'];
        $bargain = M('Bargain');

        $where = array();
        if(!empty($_REQUEST['keyword'])){
            $where['name'] = array("like","%".$_REQUEST['keyword']."%");
        }
        if(isset($token)){
            $where['token'] = $token;
        }
        $where['delete_flag'] = 0;

        $count = $bargain->getCount($where);

        if ($count > 0) {
            $page = min($page, ceil($count / $limit));
            $offset = ($page - 1) * $limit;
            $order_by = "pigcms_id desc";

            $bargain_list = $bargain->getList($where,$order_by,$limit,$offset);

            import('source.class.user_page');
            $user_page = new Page($count, $limit, $page);
            $pages = $user_page->show();
        }

        foreach($bargain_list as $k=>$v){
            $bargain_list[$k]['original'] = $v['original']/100;
            $bargain_list[$k]['minimum']  = $v['minimum']/100;
            $bargain_list[$k]['kan_min']  = $v['kan_min']/100;
            $bargain_list[$k]['kan_max']  = $v['kan_max']/100;
            unset($where);
            $where['product_id'] = $v['product_id'];
            $Product = M('Product')->get($where,'quantity,sales');
            $bargain_list[$k]['inventory'] = $Product['quantity'];

            //获取砍价总人数
            $sql = "SELECT count(bargain.token) as total FROM (SELECT DISTINCT(token) FROM ".option('system.DB_PREFIX')."bargain_kanuser WHERE bargain_id=".$v['pigcms_id'].") bargain";
            $result = D('')->query($sql);
            $bargain_list[$k]['count_canyu']  = empty($result)? 0:$result[0]['total'];
            //销量信息
            unset($where);
            $where = "activity_id='".$v['pigcms_id']."' and type=50 and paid_time !=0";
            $bargain_list[$k]['count_pay'] = D('Order')->where($where)->count('order_id');
        }

        $this->assign('pages', $pages);
        $this->assign('keyword', $_REQUEST['keyword']);
        $this->assign("bargain_list",$bargain_list);
    }

    /**
     * 砍价商品编辑
     */
    public function _bargain_edit(){
        $bargain = array();
        $token  = $this->getToken($_SESSION['store']['store_id']);

        $id = $_REQUEST['id'];
        $uid = $_SESSION['store']['uid'];
        $store_id = $_SESSION['store']['store_id'];
        $bargain = M('Bargain');

        $where = array();
        if(isset($token)){
            $where['token'] = $token;
        }
        $where['delete_flag'] = 0;
        $where['pigcms_id'] = $id;

        $bargain = $bargain->getOne($where);

        $this->assign("bargain",$bargain);
    }
    /**
     * 添加砍价商品
     */
    public function _bargain_create(){
        if( $_SESSION['hash']!=$_POST['hash'] || !isset($_SESSION['hash']) || !isset($_POST['hash']) ){
            json_return(1001,'页面已经过期');
        };

        $token  	= $this->getToken($_SESSION['store']['store_id']);

        if (IS_POST && isset($_POST['is_submit'])) {
            $product_id = $_POST['product_id'];
            $sku_id = $_POST['sku_id'];
            $keyword = $_POST['keyword'];
            $name = $_POST['name'];
            $wxtitle = $_POST['wxtitle'];
            $wxinfo = $_POST['wxinfo'];
            $wxpic = $_POST['wxpic'];
            $logoimg1 = $_POST['logoimg1'];
            $logoimg2 = $_POST['logoimg2'];
            $logoimg3 = $_POST['logoimg3'];
            $starttime = $_POST['starttime'];
            $original = $_POST['original'];
            $minimum = $_POST['minimum'];
            $kan_min = $_POST['kan_min'];
            $kan_max = $_POST['kan_max'];
            $rank_num = $_POST['rank_num'];
            $inventory = $_POST['inventory'];
            $guize = $_POST['guize'];
            $is_attention = $_POST['is_attention'];
            $is_subhelp = $_POST['is_subhelp'];

            if (empty($keyword)) {
                json_return(1001,'关键字没有填写，请填写');
            };
            if (empty($name)) {
                json_return(1001,'请选择砍价商品');
            };
            if (empty($wxtitle)) {
                json_return(1001,'微信分享标题没有填写，请填写');
            };
            if (empty($starttime)) {
                json_return(1001,'每人砍价时间未填写，请填写');
            };
            if (empty($original)) {
                json_return(1001,'商品原价未填写，请填写');
            };
            if (empty($minimum)) {
                json_return(1001,'商品底价未填写，请填写');
            };
            if (empty($kan_min) || empty($kan_max)) {
                json_return(1001,'砍价范围未填写，请填写');
            };

            // 插入数据库
            $bargain = M('Bargain');
            $data['product_id'] = $product_id;
            $data['sku_id'] = $sku_id;
            $data['store_id'] = $_SESSION['store']['store_id'];
            $data['keyword'] = $keyword;
            $data['name'] = $name;
            $data['wxtitle'] = $wxtitle;
            $data['wxinfo'] = $wxinfo;
            $data['wxpic'] = $wxpic;
            $data['logoimg1'] = $logoimg1;
            $data['logoimg2'] = $logoimg2;
            $data['logoimg3'] = $logoimg3;
            $data['starttime'] = $starttime;
            $data['original'] = $original*100;
            $data['minimum'] = $minimum*100;
            $data['kan_min'] = $kan_min*100;
            $data['kan_max'] = $kan_max*100;
            $data['rank_num'] = $rank_num;
            $data['inventory'] = $inventory;
            $data['qdao'] = 0;
            $data['qprice'] = 0;
            $data['guize'] = $guize;
            $data['is_reg'] = 2;
            $data['is_attention'] = $is_attention;
            $data['is_subhelp'] = $is_subhelp;
            $data['addtime'] = time();
            $data['is_new'] = 2;
            $data['logotitle1'] = $name;
            $data['logotitle2'] = $name;
            $data['logotitle3'] = $name;;
            $data['is_reg'] = $is_subhelp;
            if(isset($token)){
                $data['token'] = $token;
            }

            $pid = $bargain->add($data);

            if ($pid) {
                unset($_SESSION['hash']);
                json_return(0, '添加成功');
            } else {
                json_return(1001, '添加失败，请重新');
            }
        }
    }

    /**
     * 编辑砍价商品
     */
    public function _do_bargain_edit(){
        $token  	= $this->getToken($_SESSION['store']['store_id']);

        if (IS_POST && isset($_POST['is_submit'])) {
            $pigcms_id = $_POST['pigcms_id'];
            $product_id = $_POST['product_id'];
            $sku_id = $_POST['sku_id'];
            $keyword = $_POST['keyword'];
            $name = $_POST['name'];
            $wxtitle = $_POST['wxtitle'];
            $wxinfo = $_POST['wxinfo'];
            $wxpic = $_POST['wxpic'];
            $logoimg1 = $_POST['logoimg1'];
            $logoimg2 = $_POST['logoimg2'];
            $logoimg3 = $_POST['logoimg3'];
            $starttime = $_POST['starttime'];
            $original = $_POST['original'];
            $minimum = $_POST['minimum'];
            $kan_min = $_POST['kan_min'];
            $kan_max = $_POST['kan_max'];
            $rank_num = $_POST['rank_num'];
            $inventory = $_POST['inventory'];
            $guize = $_POST['guize'];
            $is_attention = $_POST['is_attention'];
            $is_subhelp = $_POST['is_subhelp'];

            if (empty($keyword)) {
                json_return(1001,'关键字没有填写，请填写');
            };
            if (empty($name)) {
                json_return(1001,'请选择砍价商品');
            };
            if (empty($wxtitle)) {
                json_return(1001,'微信分享标题没有填写，请填写');
            };
            if (empty($starttime)) {
                json_return(1001,'每人砍价时间未填写，请填写');
            };
            if (empty($original)) {
                json_return(1001,'商品原价未填写，请填写');
            };
            if (empty($minimum)) {
                json_return(1001,'商品底价未填写，请填写');
            };
            if (empty($kan_min) || empty($kan_max)) {
                json_return(1001,'砍价范围未填写，请填写');
            };

            // 修改数据库
            $bargain = M('Bargain');
            $data['product_id'] = $product_id;
            $data['sku_id'] = $sku_id;
            $data['keyword'] = $keyword;
            $data['name'] = $name;
            $data['wxtitle'] = $wxtitle;
            $data['wxinfo'] = $wxinfo;
            $data['wxpic'] = $wxpic;
            $data['logoimg1'] = $logoimg1;
            $data['logoimg2'] = $logoimg2;
            $data['logoimg3'] = $logoimg3;
            $data['starttime'] = $starttime;
            $data['original'] = $original*100;
            $data['minimum'] = $minimum*100;
            $data['kan_min'] = $kan_min*100;
            $data['kan_max'] = $kan_max*100;
            $data['rank_num'] = $rank_num;
            $data['guize'] = $guize;
            $data['is_attention'] = $is_attention;
            $data['is_subhelp'] = $is_subhelp;
            $data['logotitle1'] = $name;
            $data['logotitle2'] = $name;
            $data['logotitle3'] = $name;

            $where = array();
            $where['token'] = $token;
            $where['pigcms_id'] = $pigcms_id;
            $pid = $bargain->save($where,$data);

            if ($pid) {
                json_return(0, '编辑成功');
            } else {
                json_return(1001, '编辑失败，请重试');
            }
        }
    }

    public function edit_one(){
        $field = $_REQUEST['type'];
        $pigcms_id = $_REQUEST['pigcms_id'];
        $value = $_REQUEST['value'];

        $data[$field] = $value;
        $where['pigcms_id'] = $pigcms_id;

        if(isset($field) && isset($pigcms_id) && isset($value)){
            $bargain = M('Bargain');
            $result = $bargain->update($data,$where);

            if($result){
                $jsondata['error'] = $value;
            }
        }else{
            $jsondata['error'] = 2;
            $jsondata['msg'] = '请求参数不合法！';
        }

        if($_REQUEST['referurl']==1){
            redirect(url('user:bargain:index'));
        }else{
            echo json_encode($jsondata);
        }
    }

    //模拟公众号token
    public function getToken($id){
        return substr(md5(option('config.site_url').$id.$this->synType),8,16);
    }
}
