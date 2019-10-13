<?php
/**
* 
*/
class USER
{
	private $openId;
	private $nickname;
	private $sex;
	private $province;
	private $city;
	private $country;
	private $headimgurl;
	private $privilege;
	private $unionid;
	
	public function _construct($openId,$access_token)
	{
		
		$url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openId."&lang=zh_CN";

		$userInfo = $this->httpGet($url);
		$this->openId = $openId;
		$this->nickname = $userInfo['nickname'];
		$this->sex = $userInfo['sex'];
		$this->province = $userInfo['province'];
		$this->city = $userInfo['city'];
		$this->country = $userInfo['country'];
		$this->headimgurl = $userInfo['headimgurl'];
		$this->privilege = $userInfo['privilege'];
		$this->unionid = $userInfo['unionid'];

	}

	public function saveUserInfo($url)
	{
		# code...save UserInfo to server db
		$url = $url.'?openId='.$this->openId.'&nickname='.$this->nickname.'&headimgurl='.$this->headimgurl.'&unionid='.$this->unionid;
		$this->http_Get($url);
	}


	private function httpGet($url) {
      
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
	      
	    // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
	    // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
	    curl_setopt($curl, CURLOPT_URL, $url);

	    $res = curl_exec($curl);
	    curl_close($curl);

	    return $res;
    }

}

?>