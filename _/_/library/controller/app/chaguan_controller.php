<?php
class chaguan_controller extends base_controller{
    public $config;
	public $_G;
	
	public function __construct(){
		global $_G;
		$this->_G = $_G;
		$this->arrays['config'] = $this->config = $_G['config'];
	}
	// 附近店铺
	public function index() {
	   $results = array('result'=>'0','data'=>array(),'msg'=>'');
		$page = max($_REQUEST['page'], 1);
		$limit = $_REQUEST['size'];
		$long = $_REQUEST['long'];
		$lat = $_REQUEST['lat'];
	    $province_id=$_POST['provinceid'];
		$city_id=$_POST['cityid'];
		$area_id=$_POST['countyid'];
		
		if ($limit <= 0) {
			$limit = 5;
		}
		
		$sql=" `s`.`store_id`,`s`.`name`, `s`.`attention_num`, `s`.`logo`, `s`.`price`, `sc`.`address` ";
		
		if ($long && $lat) {
		/*import('Http');
		$http_class = new Http();
		$callback = $http_class->curlGet('http://api.map.baidu.com/geoconv/v1/?coords=' . $long . ',' . $lat . '&from=1&to=5&ak=4c1bb2055e24296bbaef36574877b4e2');
		$callback_arr = json_decode($callback, true);
		if(empty($callback_arr['result']) || !empty($callback_arr['status'])){
			$results['result']='1';
			$results['msg']='地理位置解析错误';
			exit(json_encode($results));
		}else{
			$long = $callback_arr['result'][0]['x'];
			$lat = $callback_arr['result'][0]['y'];
		}*/
		
		$sql.=",ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sc`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sc`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`sc`.`long`*PI()/180)/2),2)))*1000) AS juli";
		$orderby= " juli asc ";
		}
		
		
		
		
		
		
		$where = "`sc`.`store_id`=`s`.`store_id` AND `s`.`status`='1' ";
		if (!empty($name)) {
			$where .= " AND s.name like '%" . $name . "%'";
		}
		
		if (!empty($province_id)) {
			$where .= " AND sc.province = '" . $province_id . "'";
		}
		if (!empty($city_id)) {
			$where .= " AND sc.city = '" . $city_id . "'";
		}
		if (!empty($area_id)) {
			$where .= " AND sc.county = '" . $area_id . "'";
		}
		
	
		
		$offset = ($page - 1) * $limit;
	
	    if($_REQUEST['orderby']=='renqi'){
		$orderby="`s`.`attention_num` desc";
		
		}else{
		
		$orderby="`s`.`store_id` DESC";
		}
	   $count = D('')->table(array('Store_contact'=>'sc', 'Store'=>'s'))->where($where)->count();
		
		$pages = '';
		$total_pages = ceil($count / $limit);
		
		$page = min($page, $total_pages);
	
		$store_list = D('')->table(array('Store_contact'=>'sc', 'Store'=>'s'))->field($sql)->where($where)->order($orderby)->limit($offset . ',' . $limit)->select();
		foreach ($store_list as &$store) {
				
			if(empty($store['logo'])) {
				$store['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
			} else {
				$store['logo'] = getAttachmentUrl($store['logo']);
			}
		  
		}
		
		
		$slide 	= M('Adver')->get_adver_by_key('wap_index_slide_top',5);
		$ad=array();
		 $slide 	= M('Adver')->get_adver_by_key('wap_index_slide_top',5);
         $lists['list']	=  $store_list;
		 foreach($slide as $key=>$r){
		 $ad[$key]['name']	=  $r['name'];
		 $ad[$key]['pic']	=  $r['pic'];
		 $ad[$key]['url']	=  $r['url'];
		 $ad[$key]['description']	=  $r['description']?$r['description']:'';
		 }
		 $lists['ad']	=  $ad;
		$results['data']=$lists;
	$page_info['page_count'] =  (string)$total_pages;;
	$page_info['page_index'] =  (string)$page;
	$results['page_info'] =  $page_info;

	exit(json_encode($results));
		//json_return(0, $store_list);
	}
	
	// 附近店铺
	public function near() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
		$page = max($_REQUEST['page'], 1);
		$limit = $_REQUEST['size'];
		$long = $_REQUEST['long'];
		$lat = $_REQUEST['lat'];

		$province_id=$_POST['provinceid'];
		$city_id=$_POST['cityid'];
		$area_id=$_POST['countyid'];
		
		if($_REQUEST['price']){
		$price=explode('-',$_REQUEST['price']);
		
		$minprice=$price['0'];
		$maxprice=$price['1'];
		}
		$renshu=$_REQUEST['renshu'];
        $name=$_REQUEST['tag'];
		$keyword=$_REQUEST['keyword'];
		$where=" `sc`.`status`='1' AND `sc`.`public_display`='1' AND `s`.`pigcms_id`<>'37' ";
		
		if (!empty($name)) {
			$where .= " AND s.name like '%" . $name . "%'";
		}
		
		if (!empty($province_id)) {
			$where .= " AND s.province = '" . $province_id . "'";
		}
		if (!empty($city_id)) {
			$where .= " AND s.city = '" . $city_id . "'";
		}
		if (!empty($area_id)) {
			$where .= " AND s.county = '" . $area_id . "'";
		}
		
		
		
		if($minprice){
		
			$where .= " AND s.price >='$minprice' ";
			
			}
		if($maxprice){
		
			$where .= " AND s.price <= '$maxprice' ";
			
			}
		
		if($renshu){
		$renshus=explode(',',$renshu);
		foreach($renshus as $v){
		
		$vc=explode('-',$v);
		$minrs=$vc['0'];
		$maxrs=$vc['1'];
		if($minrs){
		
			$where .= " AND m.zno >='$minrs' ";
			
			}
		if($maxrs){
		
			$where .= " AND m.zno <= '$maxrs' ";
			
			}
		  }
		}
		
		if (!empty($keyword)) {
		$keytag=explode(',',$keyword);
		foreach($keytag as $v){
		
			$where .= " AND s.keyword like '%" . $name . "%'";
		}
		
		
		}
		if ($limit <= 0) {
			$limit = 1;
		}
		
		
		if($_REQUEST['orderby']=='renqi'){
		$orderby="`sc`.`attention_num` desc";
		
		}else{
		
		$orderby="`s`.`is_hot` DESC";
		}
	
		$sql=" `s`.`store_id`,`s`.`pigcms_id`,`s`.`name`, `s`.`images`, `s`.`price`, `s`.`address`, `sc`.`attention_num` ";
		
		if ($long && $lat) {
		/*import('Http');
		$http_class = new Http();
		$callback = $http_class->curlGet('http://api.map.baidu.com/geoconv/v1/?coords=' . $long . ',' . $lat . '&from=1&to=5&ak=4c1bb2055e24296bbaef36574877b4e2');
		$callback_arr = json_decode($callback, true);
		if(empty($callback_arr['result']) || !empty($callback_arr['status'])){
			$results['result']='1';
			$results['msg']='地理位置解析错误';
			exit(json_encode($results));
		}else{
			$long = $callback_arr['result'][0]['x'];
			$lat = $callback_arr['result'][0]['y'];
		}*/
		
		$sql.=" , `s`.`is_yuding`, ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`s`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`s`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`s`.`long`*PI()/180)/2),2)))*1000) AS juli";
		$orderby= " juli asc ";
		}
		
		$sslist = D('')->table(array('Store_physical'=>'s'))->join('Meal_cz as m on m.physical_id = s.pigcms_id', 'left')->join('Store as sc on sc.store_id = s.store_id', 'left')->field($sql)->where($where)->order($orderby)->group('m.physical_id')->select();
		$count=count($sslist);
		$total_pages = ceil($count / $limit);
		
		
		$offset = ($page - 1) * $limit;
		$store_list = D('')->table(array('Store_physical'=>'s'))->join('Meal_cz as m on m.physical_id = s.pigcms_id', 'left')->join('Store as sc on sc.store_id = s.store_id', 'left')->field($sql)->where($where)->order($orderby)->group('m.physical_id')->limit($offset . ',' . $limit)->select();
		
		foreach ($store_list as &$store) {
			
			
			if(empty($store['images'])) {
				$store['images'] = getAttachmentUrl('images/default_shop_2.jpg', false);
			} else {
				$store['images'] = getAttachmentUrl($store['images']);
			}
		   $store['juli']=$store['juli'] ? $store['juli']/1000 :'';
		}
		$lists=array();
		$ad=array();
		 $slide 	= M('Adver')->get_adver_by_key('wap_index_slide_top',5);
         $lists['list']	=  $store_list;
		 foreach($slide as $key=>$r){
		
		 $ad[$key]['name']	=  $r['name'];
		
		 $ad[$key]['pic']	=  $r['pic'];
		 $ad[$key]['url']	=  $r['url'];
		 $ad[$key]['description']	=  $r['description']?$r['description']:'';
		 }

		if ($page == 1) {
		if(!empty($ad) && empty($price) && empty($renshu) && empty($keyword) && empty($name) && empty($city_id)){
		 $lists['ad']	=  $ad;
		 }
		 }
		$results['data']=$lists;
		$page_info['page_count'] =  (string)$total_pages;;
	$page_info['page_index'] =  (string)$page;
	$results['page_info'] =  $page_info;
			exit(json_encode($results));
	}
	


public function alist() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
		$page = max($_REQUEST['page'], 1);
		$limit = $_REQUEST['size'];
		$long = $_REQUEST['long'];
		$lat = $_REQUEST['lat'];

		$province_id=$_POST['provinceid'];
		$city_id=$_POST['cityid'];
		$area_id=$_POST['countyid'];
		
		
		if($_REQUEST['price']){
		$price=explode('-',$_REQUEST['price']);
		
		$minprice=$price['0'];
		$maxprice=$price['1'];
		}
		$renshu=$_REQUEST['renshu'];
        $name=$_REQUEST['tag'];
		$keyword=$_REQUEST['keyword'];
		$where=" `sc`.`status`='1' AND `sc`.`public_display`='1' AND `s`.`pigcms_id`<>'37' ";
		
		if (!empty($name)) {
			$where .= " AND s.name like '%" . $name . "%'";
		}
		
		if (!empty($province_id)) {
			$where .= " AND s.province = '" . $province_id . "'";
		}
		if (!empty($city_id)) {
			$where .= " AND s.city = '" . $city_id . "'";
		}
		if (!empty($area_id)) {
			$where .= " AND s.county = '" . $area_id . "'";
		}
		
		
		
		if($minprice){
		
			$where .= " AND s.price >='$minprice' ";
			
			}
		if($maxprice){
		
			$where .= " AND s.price <= '$maxprice' ";
			
			}
		
		if($renshu){
		$renshus=explode(',',$renshu);
		foreach($renshus as $v){
		
		$vc=explode('-',$v);
		$minrs=$vc['0'];
		$maxrs=$vc['1'];
		if($minrs){
		
			$where .= " AND m.zno >='$minrs' ";
			
			}
		if($maxrs){
		
			$where .= " AND m.zno <= '$maxrs' ";
			
			}
		  }
		}
		
		if (!empty($keyword)) {
		$keytag=explode(',',$keyword);
		foreach($keytag as $v){
		
			$where .= " AND s.keyword like '%" . $name . "%'";
		}
		
		
		}
		
		
		
		
		if ($limit <= 0) {
			$limit = 1;
		}
		
		
		

		if($_REQUEST['orderby']=='renqi'){
		$orderby="`sc`.`attention_num` desc";
		
		}else{
		
		$orderby="`s`.`is_hot` DESC";
		}
	
		$sql=" `s`.`store_id`,`s`.`pigcms_id`,`s`.`name`, `s`.`images`, `s`.`price`, `s`.`address`, `sc`.`attention_num` ";
		
		if ($long && $lat) {
		/*import('Http');
		$http_class = new Http();
		$callback = $http_class->curlGet('http://api.map.baidu.com/geoconv/v1/?coords=' . $long . ',' . $lat . '&from=1&to=5&ak=4c1bb2055e24296bbaef36574877b4e2');
		$callback_arr = json_decode($callback, true);
		if(empty($callback_arr['result']) || !empty($callback_arr['status'])){
			$results['result']='1';
			$results['msg']='地理位置解析错误';
			exit(json_encode($results));
		}else{
			$long = $callback_arr['result'][0]['x'];
			$lat = $callback_arr['result'][0]['y'];
		}*/
		
		$sql.=" , `s`.`is_yuding`, ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`s`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`s`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`s`.`long`*PI()/180)/2),2)))*1000) AS juli";
		$orderby= " juli asc ";
		}
		
		$sslist = D('')->table(array('Store_physical'=>'s'))->join('Meal_cz as m on m.physical_id = s.pigcms_id', 'left')->join('Store as sc on sc.store_id = s.store_id', 'left')->field($sql)->where($where)->order($orderby)->group('m.physical_id')->select();
		$count=count($sslist);
		$total_pages = ceil($count / $limit);
	
		
		$offset = ($page - 1) * $limit;

		$store_list = D('')->table(array('Store_physical'=>'s'))->join('Meal_cz as m on m.physical_id = s.pigcms_id', 'left')->join('Store as sc on sc.store_id = s.store_id', 'left')->field($sql)->where($where)->order($orderby)->group('m.physical_id')->limit($offset . ',' . $limit)->select();
		
		foreach ($store_list as &$store) {
			
			
			
			if(empty($store['images'])) {
				$store['images'] = getAttachmentUrl('images/default_shop_2.jpg', false);
			} else {
				$store['images'] = getAttachmentUrl($store['images']);
			}
		
	    	$store['juli']=$store['juli'] ? $store['juli']/1000 :'';
		}
		$ad=array();
		 $slide 	= M('Adver')->get_adver_by_key('wap_index_slide_top',5);
    
		 foreach($slide as $key=>$r){
		
		 $ad[$key]['name']	=  $r['name'];
		
		 $ad[$key]['pic']	=  $r['pic'];
		 $ad[$key]['url']	=  $r['url'];
		 $ad[$key]['description']	=  $r['description']?$r['description']:'';
		 }
		 $p=array();
		
		  if(!empty($ad) && empty($price) && empty($renshu) && empty($keyword) && empty($name) && empty($city_id)){
		 $p[0]['r']	=  1;
		  if($page==1){
		 $p[0]['data1']	=  $ad;
	  
		 }else{
		  $p[0]['data1']	= array();
		 }
		}
		
		 $count=count($store_list);
		  if(!empty($ad) && empty($price) && empty($renshu) && empty($keyword) && empty($name) && empty($city_id)){
		 
		 for($i=1;$i<=$count;$i++){
		 $x=$i-1;
		 $p[$i]['r']	=  2;
		 $p[$i]['data2']	=  $store_list[$x] ? $store_list[$x]: array();
	
		 }
		
		}else{
		for($i=0;$i<$count;$i++){
	
		 $p[$i]['r']	=  2;
		 $p[$i]['data2']	=  $store_list[$i] ? $store_list[$i]: array();
	
		 }
		
		}
		
		
		
		
		
		 
		 
		 
		 
		 
	
		$results['data']=$p;
		$page_info['page_count'] =  (string)$total_pages;;
	$page_info['page_index'] =  (string)$page;
	$results['page_info'] =  $page_info;
			exit(json_encode($results));
	}

		
	public function show() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
	
		$pigcms_id = isset($_REQUEST['pigcms_id']) ? $_REQUEST['pigcms_id'] : '';
		if (empty($pigcms_id)) {
		     $results['result']='1';
			$results['msg']='pigcms_id不能为空';
			exit(json_encode($results));
		}
	     $where=array();
         $where['pigcms_id']=$pigcms_id;
		
		$r = D('Store_physical')->where($where)->find();
	
		$store = M('Store')->wap_getStore($r['store_id']);
		$list['store_id']=$r['store_id'];
		$list['physical_id']=$pigcms_id;
		$list['name']=$r['name'];
		$list['phone1']=$r['phone1'];
		$list['phone2']=$r['phone2'];
		$list['zlong']=$r['long'];
		$list['zlat']=$r['lat'];
	    $pics = explode(',',$r['pics']);
		foreach($pics as $v){
		$list['images'][]=getAttachmentUrl($v);
		}
		if($r['price']>0){
		$list['price']=$r['price'];
		}else{
		$list['price']='免费';
		}
		$res=$this->commentcount($pigcms_id,'STORE');
		$list['commentcount']=$res['count'];
		$list['commentscore']=$res['score'];
		$list['storename']=$store['name'];
		$list['business_hours']=$r['business_hours'];
		//$list['mobile']=$r['mobile'];
		$list['address']=$r['address'];
		
		$list['content']=$r['description'];
	    $list['shortdesc']=$r['shortdesc'];
	
	
    $xgs =D('Store_physical')->where(array('store_id'=>$r['store_id']))->limit(2)->select();
	foreach($xgs as $key =>$r){
	    $xg[$key]['pigcms_id']=$r['pigcms_id'];
		$xg[$key]['name']=$r['name'];
		$xg[$key]['images']=getAttachmentUrl($r['images']);
		$xg[$key]['address']=$r['address'];
	    $xg[$key]['price']=$r['price']?$r['price']:'免费';
	}
	 $bxs =D('Meal_cz')->where(array('physical_id'=>$pigcms_id))->select();
	 echo D('Meal_cz')->last_sql;
	foreach($bxs as $k =>$v){
	    $bx[$k]['cz_id']=$v['cz_id'];
		$bx[$k]['name']=$v['name'];
		$bx[$k]['renshu']=$v['zno'];
		$bx[$k]['price']=$v['price'];
		$bx[$k]['images']=getAttachmentUrl($v['image']);
	}
	
	
	
	
	$chd =D('Chahui')->field('store_id,pigcms_id,name,address,images,sttime,endtime,descs')->where(array('physical_id'=>$pigcms_id))->limit(3)->select();
	foreach($chd as $key =>$r){
	$store = M('Store')->wap_getStore($r['store_id']);
	    $ch[$key]['pigcms_id']=$r['pigcms_id'];
		$ch[$key]['name']=$r['name'];
		$ch[$key]['images']=getAttachmentUrl($r['images']);
	    $ch[$key]['storename']=$store['name'];
		$ch[$key]['sttime']=date('m/d H:i',$r['sttime']);
		$ch[$key]['endtime']=date('m/d H:i',$r['endtime']);
		$ch[$key]['address']=$r['address'];
	    $ch[$key]['desc']=$r['descs']?$r['descs']:'';
	}
	
	
	
	$lists['show']=$list;
	$lists['list']=$xg ? $xg :'';
	$lists['bx']=$bx ? $bx :'';
	$lists['chahui']=$ch ? $ch :'';
	$lists['comment']=$this->comment($pigcms_id,'STORE');
	    
		$share['logo']=getAttachmentUrl($r['images']);
		$share['name']=$r['name'];
		$share['url']=$this->config['wap_site_url'] . '/physical_show.php?id=' . $r['pigcms_id'];
		$share['info']=$r['shortdesc'] ? $r['shortdesc'] : $r['name'];
		
		
		$lists['share']=$share;
	$results['data']=$lists;

	exit(json_encode($results));
    }	
	
	
	
	
	
	public function bx_show() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
	
		$cz_id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
		if (empty($cz_id)) {
		     $results['result']='1';
			$results['msg']='id不能为空';
			exit(json_encode($results));
		}
		
		
		 $v =D('Meal_cz')->where(array('cz_id'=>$cz_id))->find();

	    $bx['cz_id']=$v['cz_id'];
		$bx['physical_id']=$v['physical_id'];
		$bx['name']=$v['name'];
		$bx['renshu']=$v['zno'];
		$bx['price']=$v['price'];
		$bx['images']=explode(',',$v['images']);
	    $bx['sale']=$v['sale'];
		$bx['conten']=$this->config['wap_site_url'] . '/baoxiang_app.php?id=' . $v['cz_id'];
		
		
		
	     $where=array();
         $where['pigcms_id']=$v['physical_id'];
		
		$r = D('Store_physical')->where($where)->find();
	    $bx['store_name']=$r['name'];
	    $bx['phone1']=$r['phone1'];
		$bx['phone2']=$r['phone2'];
		
		
		$share['logo']=getAttachmentUrl($v['image']);
		$share['name']=$v['name'];
		$share['url']=$this->config['wap_site_url'] . '/baoxiang.php?id='.$v['cz_id'];
		$share['info']=$v['description'] ? $v['description'] : $v['name'];
		
		
		$bx['share']=$share;
	    $results['data']=$bx;

	exit(json_encode($results));
    }	
	
	
	
	
	
	public function store_show() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
	     $page = max(1, $_REQUEST['page']);
		$store_id = $_REQUEST['storeid'];
		$type = $_REQUEST['type'];
		if (empty($store_id)) {
		     $results['result']='1';
			$results['msg']='storeid不能为空';
			exit(json_encode($results));
		}
		
		$data=array();
		 $store =D('Store')->field('store_id,name,logo,intro')->where(array('store_id'=>$store_id))->find();

	    $store['logo']=getAttachmentUrl($store['logo']);
	
		
		
		
		
		
		
		
		
		$limit=10;
		 $product_model = D('Product');
		$orderby='is_recommend DESC, product_id DESC';
	    $where=array();
    	$where['status'] = 1;
		$where['category_id'] = array('<>', 193);
		$where['quantity'] = array('>', 0);
		$where['store_id'] = $store_id;
		$count = $product_model->where($where)->count('product_id');
		
		$pages = '';
		$total_pages = ceil($count / $limit);
		
		$offset = ($page - 1) * $limit;
	$product_list = $product_model->where($where)->field('product_id, store_id, name, quantity, price, original_price, weight, image, intro, is_recommend, sales, recommend_title')->order($orderby)->limit($offset . ',' . $limit)->select();
	
		$share['logo']= $store['logo'];
		$share['name']=$store['name'];
		$share['url']=$this->config['wap_site_url'] . '/baoxiang.php?id='.$v['cz_id'];
		$share['info']=$store['intro'] ? $store['intro'] : $store['name'];
		
		
		
		

		
		
		
		$productlist=array();
		foreach ($product_list as $key=>$r) {
		   $productlist[$key]['product_id']=$r['product_id'];
		   $productlist[$key]['name']=$r['name'];
	      $productlist[$key]['image']=getAttachmentUrl($r['image']);
	      $productlist[$key]['price']=$r['price'];
          $productlist[$key]['original_price']=$r['original_price'];
		 $productlist[$key]['is_recommend']=$r['is_recommend']; 
		   $productlist[$key]['recommend_title']=$r['recommend_title'];
		  
	     }
		 
		 
		 if($type==1){
		  if($page==1){
		 $data['0']['r']=1;
		$data['0']['data1']=$store;
		 $data['1']['r']=2;
		$data['1']['data2']=$share;
		}
		 $count=count($productlist);
		 if($page==1){
		 $v=2+$count;
		  $x=0;
		 for($i=2;$i<$v;$i++){
		 
		 $data[$i]['r']	=  3;
		 $data[$i]['data3']	=  $productlist[$x] ? $productlist[$x] : array();
	    $x++;
		 }
		 
		 }else{
		 
		 for($i=0;$i<$count;$i++){
		 
		 $data[$i]['r']	=  3;
		 $data[$i]['data3']	=  $productlist[$i] ? $productlist[$i] : array();

		 }
		 
		 }
		 
		 }else{
		 
		 
		 if($page==1){
		 $data['data1']=$store;
    	$data['data2']=$share;
		}
		 $data['data3']	=  $productlist ? $productlist : array();
	  
	       }
	    $results['data']=$data;
       $page_info['page_count'] =  (string)$total_pages;
	$page_info['page_index'] =  (string)$page;
	$results['page_info'] =  $page_info;
	exit(json_encode($results));
    }	
	
	
	
	
	
	
	
	
	
       public function yuyue() {
	  $results = array('result'=>'0','data'=>array(),'msg'=>'');
	         
				$cz_id = $_REQUEST['cz_id'];
				$physical_id = $_REQUEST['physical_id'];
				$uid = $_REQUEST['uid'];
				$token = $_REQUEST['token'];
		$tokens = D('Users_token')->where(array('uid' => $uid))->find();
		
				if ($token!=$tokens['token']) {
					 $results['result']='1';
					$results['msg']='token不正确';
					exit(json_encode($results));
				}
				
				if (empty($uid)) {
				$results['result']='1';
				$results['msg']='uid不能为空';
				exit(json_encode($results));
				}
				
                if (empty($physical_id)) {
				$results['result']='1';
				$results['msg']='physical_id不能为空';
				exit(json_encode($results));
				}




            $meal = D('Meal_cz')->where(array('cz_id' => $cz_id))->find();
			if(empty($meal)){
			
			$physical = M('Store_physical')->getOne($physical_id);	
			
					$meal['seller_id'] = $physical['store_id'];
					$meal['physical_id'] = $physical_id;
					$meal['name']='未选择茶座';
			               
			}



            $dataorder = D('Meal_order');
	        	$date=array();
				$date['orderid'] = date("YmdHis",$_SERVER['REQUEST_TIME']).'0000'.$uid;
				$date['dateline'] = $_SERVER['REQUEST_TIME'];
				$date['store_uid'] = $meal['seller_id'];
				$date['physical_id'] = $meal['physical_id'];
				$date['name'] = $_REQUEST['name'];
				$date['uid'] = $uid;
				$date['phone'] = $_REQUEST['tel'];
				$date['dd_time'] = strtotime($_REQUEST['gotime']);
		     	$date['sc'] = $_REQUEST['time'];
				$date['num'] = $_REQUEST['num'];
				
				$date['tablename'] = $meal['name'];
				$date['tableid'] = $cz_id;
				$date['food'] = $_REQUEST['food'];
				
				$date['status'] = 1;

			if($dataorder->data($date)->add()){
				
			$now_store = M('Store')->wap_getStore($meal['seller_id']);		
			$user=M('User')->getUserById($now_store['uid']);
			
		
				
				$pj = D('Sms_power')->where(array('store_id' => $now_store['store_id'],'type' =>'7','app' => '1'))->find();
			
				if ($pj) {
					$sms = D('Sms_tpl')->where(array('id'=>'7','status'=>'1'))->find();

						if($sms){
				
					 $physical = M('Store_physical')->getOne($meal['physical_id']);	
		
					 $bname=$meal['name']; 
					 $times=$_REQUEST['gotime']; 
					 $mobile=$physical['mobile'];
					
					 $receiver_send = D('User')->where(array('drp_store_id'=>$meal['seller_id'],'item_store_id'=>$_POST['pigcms_id']))->select();
					$value = '';
					foreach($receiver_send as $key =>$r){
					
					$value .= 'store'.$r['uid'].',';
					
					 }
					 $value .= 'store'.$now_store['uid'];
					 
					 $pname=$physical['name'];
					 $name=$_REQUEST['name'];
					 
					 $str=$sms['text'];
					$str=str_replace('{pname}',$pname,$str); 
			        $str=str_replace('{bname}',$bname,$str); 
			        $str=str_replace('{price}',$price,$str);
		            $str=str_replace('{name}',$name,$str);
			        $str=str_replace('{times}',$times,$str);
				
					            $n_title   =  $str;
								$n_content =  $str;		
								$receiver_value = $value;	
								$ios=array('sound'=>'default', 'content-available'=>1);
								$sendno =(int)$date['orderid'];
								$platform = 'android,ios' ;
								$msg_content = json_encode(array('n_builder_id'=>0, 'n_title'=>$n_title, 'n_content'=>$n_content, 'n_extras'=>array('ios'=>$ios)));        
								import('source.class.Jpush');
						
						
						
						
				                $jpush = new Jpush();
								$jpush->send($sendno, 3, $receiver_value, 1, $msg_content, $platform, 1);	
								
								$data = array(
						'uid' 	=> $value,
						'store_id' 	=> $meal['seller_id'],
						'price' 	=> 10,
						'mobile' 	=> $mobile,
						'text'		=> $str,
						'status'	=> 1,
						'time' => time(),
						'type'	=> 7,
						'last_ip'	=> ip2long(get_client_ip())
			               	);
		          	D('Sms_jpush')->data($data)->add();


					}
				} 
	
			
			$power=M('Sms_by_code')->power($now_store['store_id'],7);
			if($user['smscount']>0 && $power){	
			import('source.class.SendSms');
			$sms = D('Sms_tpl')->where(array('id'=>'7','status'=>'1'))->find();
				
			if($sms){
		
			 $physical = M('Store_physical')->getOne($meal['physical_id']);	

		 	 $bname=$meal['name']; 
			 $times=$_REQUEST['gotime']; 
			 $mobile=$physical['mobile'];
			 if(empty($mobile)) {
			 $m = D('Sms_mobile')->where(array('store_id'=>$meal['seller_id'],'type'=>'1'))->find();
			 if($m){
			 $mobile=$m['mobile'];
			 }else{
			 $mobile=$now_store['tel'];
			 }
			 }
			 $pname=$physical['name'];
			 $name=$_REQUEST['name'];
			 
		     $str=$sms['text'];
			 $str=str_replace('{pname}',$pname,$str); 
			 $str=str_replace('{bname}',$bname,$str); 
			 $str=str_replace('{price}',$price,$str);
		     $str=str_replace('{name}',$name,$str);
			 $str=str_replace('{times}',$times,$str);
		 	 $return	= SendSms::send($mobile,$str);	
			if($return==0){
			$uid=array($now_store['uid']);
            M('User')->deduct_sms($uid,1);	
			
				}
			$data = array(
						'uid' 	=> $uid,
						'store_id' 	=> $meal['seller_id'],
						'price' 	=> 10,
						'mobile' 	=> $mobile,
						'text'		=> $content,
						'status'	=> $return,
						'time' => time(),
						'type'	=> 7,
						'last_ip'	=> ip2long(get_client_ip())
				);
			D('Sms_record')->data($data)->add();	
			
				}
				}


					}else{
				$results['result']='1';
			$results['msg']='添加失败';
			exit(json_encode($results));
				
					}
			

	exit(json_encode($results));
    }	
	
	
	
	
	public function search() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
	import('area');
	$areaClass = new area();
    $list =D('Store_physical')->field('city')->group('city')->select();

	foreach($list as $key =>$r){

		$lists[$key]['value']=$r['city'];
		$lists[$key]['name']=$areaClass->get_name($r['city']);
	    $lists[$key]['num']=D('Store_physical')->where(array('city'=>$r['city']))->count('pigcms_id');
	}
	
	foreach($lists as $arr2){
    $flag[]=$arr2["num"];
    }
	
    array_multisort($flag, SORT_DESC, $lists);

     foreach($lists as &$r){
    unset($r["num"]);
    }

      $tag =D('Tag')->field('`id` as value,`name`')->select(); 
	
	
	  $renshu[0]['name']='6人以下';
	  $renshu[0]['value']='0-6';
	  $renshu[1]['name']='6-10人';
	  $renshu[1]['value']='6-10';
	  $renshu[2]['name']='10-20人';
	  $renshu[2]['value']='10-20';
	  $renshu[3]['name']='20-50人';
	  $renshu[3]['value']='20-50';
	  $renshu[4]['name']='50人以上';
	  $renshu[4]['value']='50-200';
	  
	  
	  

  
      $price[0]['name']='0-50元';
	  $price[0]['value']='0-50';
	  $price[1]['name']='50-100元';
	  $price[1]['value']='50-100';
	  $price[2]['name']='100-200元';
	  $price[2]['value']='100-200';
	  $price[3]['name']='200-400元';
	  $price[3]['value']='200-400';
	  $price[4]['name']='400以上元';
	  $price[4]['value']='400-1000000';

		
		$re['0']['name']='城市';
		$re['0']['data']=$lists;
		$re['0']['key']='cityid';
		$re['1']['name']='特色';
		$re['1']['data']=$tag;
		$re['1']['key']='keyword';
		$re['2']['name']='人数';
		$re['2']['data']=$renshu;
		$re['2']['key']='renshu';
		$re['3']['name']='价格';
		$re['3']['data']=$price;
		$re['3']['key']='price';
	       $results['data']=$re;

	exit(json_encode($results));
    }
	
	
	
	
	
	
	
	private function commentcount($id,$type) {
	   $where = array();
		$where['type'] = $type;
		$where['relation_id'] = $id;
		$where['status'] = 1;
		$where['delete_flg'] = 0;
	$comment_model = M('Comment');
	$count = $comment_model->getCount($where);
	
	$sum = D('Comment')->where($where)->sum('score');

	$score=ceil($sum/$count);
	$re['count']=$count;
	$re['score']=$score;
	return $re;
	}
	private function comment($id,$type) {
	

		$page = 1;
		
				
		$where = array();
		$where['type'] = $type;
		$where['relation_id'] = $id;
		$where['status'] = 1;
		$where['delete_flg'] = 0;
		switch($tab) {
			case 'HAO' :
				$where['score'] = array('>=', 4);
				break;
			case 'ZHONG' :
				$where['score'] = 3;
				break;
			case 'CHA' :
				$where['score'] = array('<=', 2);
				break;
			case 'IMAGE' :
				$where['has_image'] = 1;
			default :
				break;
		}
			
		
		$comment_model = M('Comment');
		$count = $comment_model->getCount($where);
			
		$comment_list = array();
		$pages = '';
		$limit = 5;
		$total_page = ceil($count / $limit);
		if ($count > 0) {
			$page = min($page, ceil($count / $limit));
			$offset = ($page - 1) * $limit;
			$comment_list = $comment_model->getList($where, 'id desc', $limit, $offset, true);
		}
			
		$user_list = array();
		if ($comment_list['user_list']) {
			foreach ($comment_list['user_list'] as $key => $user) {
				$tmp = array();
				$tmp['nickname'] = anonymous($user['nickname']);
				$tmp['avatar'] = $user['avatar'];
				
				$user_list[$key] = $tmp;
			}
		}
		
		$list = array();
		if ($comment_list['comment_list']) {
			foreach ($comment_list['comment_list'] as $tmp) {
				$comment = array();
				$comment['content'] = htmlspecialchars($tmp['content']);
				$comment['score'] = $tmp['score'];
				$comment['date'] = date('Y-m-d', $tmp['dateline']);
				$comment['nickname'] = isset($user_list[$tmp['uid']]) ? $user_list[$tmp['uid']]['nickname'] : '匿名';
				$comment['avatar'] = isset($user_list[$tmp['uid']]) ? $user_list[$tmp['uid']]['avatar'] : getAttachmentUrl('images/touxiang.png', false);
				foreach ($tmp['attachment_list'] as &$r) {
				unset($r['id']);
				unset($r['cid']);
				unset($r['type']);
				unset($r['size']);
				unset($r['uid']);
				unset($r['width']);
				unset($r['height']);
				}
				$comment['price'] = $tmp['price'];
				$comment['attachment_list'] = $tmp['attachment_list'];
				
				$list[] = $comment;
			}
		}
	
		
		return $list;
		
	}
	
	
	
}
?> 