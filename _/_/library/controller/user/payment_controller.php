<?php
class payment_controller extends base_controller
{
	private $face = array(1 => '[微笑]', '[撇嘴]','[色]','[发呆]','[得意]','[流泪]','[害羞]','[闭嘴]','[睡]','[大哭]','[尴尬]','[发怒]','[调皮]','[呲牙]','[惊讶]','[难过]','[酷]','[冷汗]','[抓狂]','[吐]','[偷笑]','[愉快]','[白眼]','[傲慢]','[饥饿]','[困]','[惊恐]','[流汗]','[憨笑]','[悠闲]','[奋斗]','[咒骂]','[疑问]','[嘘]','[晕]','[疯了]','[衰]','[骷髅]','[敲打]','[再见]','[擦汗]','[抠鼻]','[鼓掌]','[糗大了]','[坏笑]','[左哼哼]','[右哼哼]','[哈欠]','[鄙视]','[委屈]','[快哭了]','[阴险]','[亲亲]','[吓]','[可怜]','[菜刀]','[西瓜]','[啤酒]','[篮球]','[乒乓]','[咖啡]','[饭]','[猪头]','[玫瑰]','[凋谢]','[嘴唇]','[爱心]','[心碎]','[蛋糕]','[闪电]','[炸弹]','[刀]','[足球]','[瓢虫]','[便便]','[月亮]','[太阳]','[礼物]','[拥抱]','[强]','[弱]','[握手]','[胜利]','[抱拳]','[勾引]','[拳头]','[差劲]','[爱你]','[NO]','[OK]','[爱情]','[飞吻]','[跳跳]','[发抖]','[怄火]','[转圈]','[磕头]','[回头]','[跳绳]','[投降]','[激动]','[乱舞]','[献吻]','[左太极]','[右太极]');
	private $face_key = array(1 => "/::)", "/::~", "/::B", "/::|", "/:8-)", "/::<", "/::$", "/::X", "/::Z", "/::'(", "/::-|", "/::@", "/::P", "/::D", "/::O", "/::(", "/::+", "/:--b", "/::Q", "/::T", "/:,@P", "/:,@-D", "/::d", "/:,@o", "/::g", "/:|-)", "/::!", "/::L", "/::>", "/::,@", "/:,@f", "/::-S", "/:?", "/:,@x", "/:,@@", "/::8", "/:,@!", "/:!!!", "/:xx", "/:bye", "/:wipe", "/:dig", "/:handclap", "/:&amp;-(", "/:B-)", "/:<@", "/:@>", "/::-O", "/:>-|", "/:P-(", "/::'|", "/:X-)", "/::*", "/:@x", "/:8*", "/:pd", "/:<W>", "/:beer", "/:basketb", "/:oo", "/:coffee", "/:eat", "/:pig", "/:rose", "/:fade", "/:showlove", "/:heart", "/:break", "/:cake", "/:li", "/:bome", "/:kn", "/:footb", "/:ladybug", "/:shit", "/:moon", "/:sun", "/:gift", "/:hug", "/:strong", "/:weak", "/:share", "/:v", "/:@)", "/:jj", "/:@@", "/:bad", "/:lvu", "/:no", "/:ok", "/:love", "/:<L>", "/:jump", "/:shake", "/:<O>", "/:circle", "/:kotow", "/:turn", "/:skip", "/:oY", "/:#-0", "/:hiphot", "/:kiss", "/:<&amp;", "/:&amp;>");
	private $face_image = array();
	private $weixin_bind_info = array();

	public function __construct()
	{
		parent::__construct();
		$bind = D('Weixin_bind')->where(array('store_id' => $this->store_session['store_id']))->find();

		if (!in_array(ACTION_NAME, array('auth', 'get_url', 'auth_ajax', 'auth_back')) && empty($bind)) {
			header('Location:' . $this->config['site_url'] . '/user.php?c=weixin&a=auth');
			exit();
		} elseif (ACTION_NAME == 'auth' && $bind) {
			header('Location:' . $this->config['site_url'] . '/user.php?c=weixin&a=index');
			exit();
		}
		
		$this->weixin_bind_info = $bind;
		$this->assign('weixin_bind_info',$this->weixin_bind_info);

		for ($i = 1; $i < 106; $i++) $this->face_image[$i] = '<img src="'.STATIC_URL.'/images/qq/' . $i . '.gif" />';
	}
	
	public function index()
	{
	      if($_SESSION['user']['group']>0){
	        die('您没有操作权限！');
	    }
		$nowStore = M('Store')->getStore($this->store_session['store_id']);
		$this->assign('wxpay',$nowStore['wxpay']);
		$this->display();
	}
	public function open_wxpay(){
		$database_store = D('Store');
		if($database_store->where(array('store_id'=>$this->store_session['store_id']))->data(array('wxpay'=>$_POST['wxpay']))->save()){
			json_return(0,'ok');
		}else{
			json_return(1,'保存失败，请检查是否有过修改');
		}
	}
	public function save_wxpay(){
		$post_data = array();
		foreach($_POST as $key=>$value){
			if(in_array($key,array('wxpay_appsecret','wxpay_mchid','wxpay_key','wxpay_test'))){
				$post_data[$key] = $value;
			}
		}
		if(!empty($post_data) && D('Weixin_bind')->where(array('store_id'=>$this->store_session['store_id']))->data($post_data)->save()){
			json_return(0,'ok');
		}else{
			json_return(1,'保存失败，请检查是否有过修改！');
		}
	}
}
