<?php
class link_controller extends base_controller {
	public $apiUrl;
	public $SALT;
	public $synType 	= 'weidian';
	public $token;

	public function __construct() {
		parent::__construct();
		if(empty($_SESSION['user'])){
			exit('非法访问！');
		}
		$this->apiUrl 	= option('config.syn_domain') ? rtrim(option('config.syn_domain'),'/').'/' : 'http://demo.pigcms.cn/';
		$this->SALT 	= option('config.encryption') ? option('config.encryption') : 'pigcms';
		$this->token = $this->getToken($_SESSION['store']['store_id']);
	}

	public function index(){
		import('Http');
		$postData 	= array(
			'token'=>$this->token,
			//'modules' => array('bargain', 'seckill', 'crowdfunding', 'unitary', 'cutprice', 'lottery', 'red_packet', 'guajiang', 'jiugong', 'luckyfruit', 'goldenegg')
		);
		$my_version = $this->my_version;

		if(in_array($my_version,array('3','4','7','8'))){
			$postData['modules'] = array('bargain', 'seckill', 'crowdfunding', 'unitary', 'cutprice',  'red_packet','lottery', 'guajiang', 'jiugong', 'luckyfruit', 'goldenegg');
		}else if(in_array($my_version,array('2','6'))){
			$postData['modules'] = array('unitary', 'bargain', 'crowdfunding', 'seckill', 'cutprice',  'red_packet');
		}else if(in_array($my_version,array('1','5'))){
			$postData['modules'] = array('');
		}

		$result 	= Http::curlPost($this->apiUrl.'index.php?g=Home&m=Links&a=index&auth=1',http_build_query($postData));
		if($result['status'] == 1){
			if (empty($result['data'][0]) && !is_array($result['data'][0])) {
				$result['data'][0] = array();
			}
			if (empty($result['data'][1]) && !is_array($result['data'][1])) {
				$result['data'][1] = array();
			}
			if (empty($result['data'][2]) && !is_array($result['data'][2])) {
				$result['data'][2] = array();
			}

			$this->assign('data',$result['data']);
			$this->display();
		}else{
			echo $result['msg'];
		}
	}

	public function new_activity(){

		$store_id = $_SESSION['store']['store_id'];
		import('source.class.Activtiy');
        $activtiy = new Activtiy($store_id);
		$activtiy_datas = $activtiy->get_allurl();

		foreach($activtiy_datas as $k=>$v) {

			$activtiy_data[$v['type']][$k] = $v;
		}


		$this->assign('data',$activtiy_data);
		$this->display();

	}

	public function new_activity_list(){
		if($_GET['module']=='bargain'){
			//获取正在进行的砍价活动
			$store_id = $_REQUEST['store_id'];
			$page = $_REQUEST['p'] + 0;
			$page = max(1, $page);
			$limit = 10;
			$database_bargain = D("Bargain");

			$where = 'store_id='.$store_id.' and state=1 and delete_flag=0 and addtime+3600*starttime>'.time();

			$count = $database_bargain->where($where)->count("pigcms_id");

			if ($count > 0) {
			$page = min($page, ceil($count / $limit));
			$offset = ($page - 1) * $limit;
			$order_by = "pigcms_id desc";

			$bargain_list = $database_bargain->where($where)->order($order_by)->limit($limit,$offset)->field('pigcms_id,store_id,name')->select();

			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
			}

			$this->assign('pages', $pages);
			$this->assign("bargain_list",$bargain_list);
			$this->display("new_activity_bargain_list");
		}

		if ($_GET['module'] == 'unitary') {
			// 正在进行的夺宝活动
			$store_id = $_REQUEST['store_id'];
			$page = $_REQUEST['p'] + 0;
			$page = max(1, $page);
			$limit = 10;
			$database_unitary = D('Unitary');

			$where = array('state'=>1, 'store_id'=>$store_id);
			$count = $database_unitary->where($where)->count("id");
			if ($count > 0) {
				$page = min($page, ceil($count / $limit));
			$offset = ($page - 1) * $limit;
			$order_by = "id desc";

			$list = $database_unitary->where($where)->order($order_by)->limit($limit,$offset)->field('id,store_id,logopic,name,price,item_price')->select();

			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
			}

			$this->assign('pages', $pages);
			$this->assign("list", $list);
			$this->display("new_activity_unitary_list");
		}
		if($_GET['module']=='shakelottery'){
			$this->shakelottery();
		}
		if($_GET['module']=='crowdfunding'){
			$this->crowdfunding_product();
		}
	}
	// 摇一摇抽奖列表
	private function shakelottery(){
		$store_id = $_REQUEST['store_id'];
		$page = $_REQUEST['p'] + 0;
		$page = max(1, $page);
		$limit = 10;
		$database_shake = D('Shakelottery');
		$where = array('status'=>1, 'store_id'=>$store_id);
		$count = $database_shake->where($where)->count("id");
		if ($count > 0) {
			$page = min($page, ceil($count / $limit));
			$offset = ($page - 1) * $limit;
			$order_by = "id desc";
			$field='id,action_name';
			$list = $database_shake->where($where)->field($field)->order($order_by)->limit($offset.','.$limit)->select();
			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}
		$this->assign('pages', $pages);
		$this->assign("list", $list);
		$this->display("new_activity_shakelottery_list");
	}
	// 产品众筹列表
	private function crowdfunding_product(){
		$store_id = $_REQUEST['store_id'];
		$page = $_REQUEST['p'] + 0;
		$page = max(1, $page);
		$limit = 10;
		$database_product = D('Zc_product');
		$where = '`store_id`='.intval($store_id).' AND (`status`=2 OR `status`=4)';
		$count = $database_product->where($where)->count("product_id");
		if ($count > 0) {
			$page = min($page, ceil($count / $limit));
			$offset = ($page - 1) * $limit;
			$order_by = "product_id desc";
			$field='product_id,productName';
			$list = $database_product->where($where)->order($order_by)->limit($offset.','.$limit)->field($field)->select();
			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}
		$this->assign('pages', $pages);
		$this->assign("list", $list);
		$this->display("new_activity_crowdfunding_list");
	}
	public function detailed(){
		$data = array('module'=>htmlspecialchars($_GET['module']),'token'=>$this->token);
		$data['p'] = isset($_GET['p']) ? (int)$_GET['p'] : 1;
		if(isset($_GET['method'])){
			$data['method'] = htmlspecialchars($_GET['method']);
		}
		$result = $this->httpRequest($this->apiUrl.'index.php?g=Home&m=Links&a=detailed','POST',$data);
		if($result[0] == 200){
			$re = json_decode($result[1],true);
			if(isset($re['status']) && $re['status'] == 0){
				echo $re['msg'];
			}else{
				$retult = $result[1];
				preg_match('/<h4>([\s\S]+)<script>/U',$retult,$content);
				if(!empty($content[1])){
					$content = '<h4>'.$content[1];
					$content = str_replace(array('{siteUrl}','&wecha_id={wechat_id}','./tpl/Home/pigcms/common/'),array(rtrim($this->apiUrl,'/'),'',TPL_URL),$content);
					preg_match_all('/<a href=[\'\"]?([^\'\" ]+).*?>/',$content,$re);
					if($re[1]){
						foreach($re[1] as $val){
							$links = $this->parseUrl($val);
							if(!empty($links)){
								unset($links['g'],$links['m'],$links['a']);
								$link = '?c=link&a=detailed&'.http_build_query($links);
								$content = str_replace($val,$link,$content);
							}
						}
					}
					$this->assign('content',$content);
					$this->display();
				}else{
					echo '获取内容失败';
				}
			}
		}else{
			echo $result[1];
		}
	}
	public function httpRequest($url, $method, $postfields = null, $headers = array(), $debug = false) {
        /* $Cookiestr = "";  * cUrl COOKIE处理*
        if (!empty($_COOKIE)) {
            foreach ($_COOKIE as $vk => $vv) {
                $tmp[] = $vk . "=" . $vv;
            }
            $Cookiestr = implode(";", $tmp);
        }*/
		$method=strtoupper($method);
        $ci = curl_init();
        /* Curl settings */
        curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ci, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.2; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0");
        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 60); /* 在发起连接前等待的时间，如果设置为0，则无限等待 */
        curl_setopt($ci, CURLOPT_TIMEOUT, 7); /* 设置cURL允许执行的最长秒数 */
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
        switch ($method) {
            case "POST":
                curl_setopt($ci, CURLOPT_POST, true);
                if (!empty($postfields)) {
                    $tmpdatastr = is_array($postfields) ? http_build_query($postfields) : $postfields;
                    curl_setopt($ci, CURLOPT_POSTFIELDS, $tmpdatastr);
                }
                break;
            default:
                curl_setopt($ci, CURLOPT_CUSTOMREQUEST, $method); /* //设置请求方式 */
                break;
        }
		$ssl =preg_match('/^https:\/\//i',$url) ? TRUE : FALSE;
        curl_setopt($ci, CURLOPT_URL, $url);
		if($ssl){
		  curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
		  curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, FALSE); // 不从证书中检查SSL加密算法是否存在
		}
		//curl_setopt($ci, CURLOPT_HEADER, true); /*启用时会将头文件的信息作为数据流输出*/
		curl_setopt($ci, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ci, CURLOPT_MAXREDIRS, 2);/*指定最多的HTTP重定向的数量，这个选项是和CURLOPT_FOLLOWLOCATION一起使用的*/
        curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ci, CURLINFO_HEADER_OUT, true);
        /*curl_setopt($ci, CURLOPT_COOKIE, $Cookiestr); * *COOKIE带过去** */
        $response = curl_exec($ci);
		$requestinfo=curl_getinfo($ci);
        $http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
        if ($debug) {
            echo "=====post data======\r\n";
            var_dump($postfields);
            echo "=====info===== \r\n";
            print_r($requestinfo);

            echo "=====response=====\r\n";
            print_r($response);
        }
        curl_close($ci);
        return array($http_code, $response,$requestinfo);
    }
	public function parseUrl($url){
		$data = parse_url($url);
		$return = array();
		if(isset($data['host'])){
			$return['host'] = $data['scheme'].'://'.$data['host'];
		}
		if(isset($data['query'])){
			foreach(explode('&',$data['query']) as $key=>$val){
				$data = explode('=',$val);
				$return[$data[0]] = $data[1];
			}
		}
		return $return;
	}
	//模拟公众号token
	public function getToken($id){
		return substr(md5(option('config.site_url').$id.$this->synType),8,16);
	}
}