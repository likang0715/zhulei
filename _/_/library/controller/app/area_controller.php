<?php
class area_controller extends base_controller{

public $arrays=array();
	public $config;
	public $_G;
	public function __construct(){
		global $_G;
		$this->_G = $_G;
		$this->arrays['config'] = $this->config = $_G['config'];
		import('area');
        $this->areaClass = new area();
	}

	public function index() {
		 

	$i=0;
   foreach($this->areaClass->arrMArea as $key =>$r){
   
    $str = substr($key,-4);

	if($str=='0000'){
	$province[$i]['id']=$key;
	$province[$i]['name']=$r;
	$province[$i]['city']=$this->city($key);
	$i++;
	}
	
   }
   
   

   
   $results = array('result'=>'0','data'=>array(),'msg'=>'');
   $results['data']=$province;
	exit(json_encode($results));
	}
	
	
	private function city($id) {
	
	
	$id = substr($id,0,2);
	

	$i=0;
   foreach($this->areaClass->arrMArea as $key =>$r){
   
    $str = substr($key,0,2);
    $str2 = substr($key,-2);
	if($str==$id && $key!=$id.'0000' && $str2=='00'){
	$province[$i]['id']=$key;
	$province[$i]['name']=$r;
	$province[$i]['county']=$this->county($key);
	$i++;
	}
	
   }
   
    return $province;
	}
	
	
	
	
	private function county($id) {
	

	$id = substr($id,0,4);
	
		 

	$i=0;
   foreach($this->areaClass->arrMArea as $key =>$r){
   
    $str = substr($key,0,4);

	if($str==$id && $key!=$id.'00'){
	$province[$i]['id']=$key;
	$province[$i]['name']=$r;
	$i++;
	}
	
   }
   
   return $province;
	}
}
?>