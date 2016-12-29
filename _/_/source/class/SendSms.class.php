<?php
//dezend by http://www.yunlu99.com/ QQ:270656184
class SendSms
{
	static public function send($mobile,$content)
	{
	
	//企业ID $userid
$userid = '1111';
//用户账号 $account
$account = 'AA00276';
//用户密码 $password
$password = 'AA0027652';
	
//发送到的目标手机号码 $mobile
$mobile = $mobile;
//短信内容 $content
$content = urlencode($content);
$gateway = "http://dx.ipyy.net/sms.aspx?action=send&userid={$userid}&account={$account}&password={$password}&mobile={$mobile}&content={$content}&sendTime=";

$result = file_get_contents($gateway);

$xml = simplexml_load_string($result);

if($xml->returnstatus=='Success'){
$result='0';
}else{
$result['err']=$xml->returnstatus;
$result['SmsMessage']=$xml->message;

}

		return $result;
	}


}

?>
