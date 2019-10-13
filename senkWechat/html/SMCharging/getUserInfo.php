<?php
//全局变量
$appid = "wx031732af628faee0";
$appsecret = "5e8ccf52a81d427752241374212af303";
$access_token = getAccessToken($appid,$appsecret);
//getUserInfo();
// getAllUserInfo();
$allUserInfo = getAllUserInfo();
$url = "";
//http(url)
echo json_encode($allUserInfo);
//获取所有用户信息
    function getAllUserInfo(){
        $appid = "wx031732af628faee0";
    	$appsecret = "5e8ccf52a81d427752241374212af303";
		$access_token = getAccessToken($appid,$appsecret);
        //获取openId列表
        $userInfo = getUserInfo($access_token);
        $userArr = $userInfo->data;
        $openid = $userArr->openid;
		//从openID数组长度可以计算出用户数
        $userAccount = count($openid);
		$userArray = array();
        for($x=0;$x<$userAccount;$x++)
        {
            $userid = $openid[$x];
            //echo $userid;    
            //echo "<br>";
			//根据用户openId获取用户详细信息。
            $user = getUserInfoDetail($userid,$access_token);
            //echo var_dump($user);
            //echo "<br>";
            array_push($userArray,$user);
        }
        //echo var_dump($userArray);
        return $userArray;
    }
 //根据openid获取用户信息
	function getUserInfoDetail($e,$access_token) {
		$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$e&lang=zh_CN";
        $res = json_decode(httpGet($url));
     	return $res;
      	//echo json_encode($res);//json输出  	
	   // echo var_dump ($res);//array对象输出
	}

 //获取openId	
 function getUserInfo($access_token) {
		$url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=$access_token";
        $res = json_decode(httpGet($url));
        return $res;
       // echo json_encode($res);//json输出
	   // echo var_dump ($res);//array对象输出
	}

 //网络请求
	function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 2);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
        // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 2);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);
        //echo var_dump($res);
        return $res;
  }


//获取access_token值
	function getAccessToken($appid,$appsecret){
         $appid = "wxbf0346df51c10983";
   		 $appsecret = "ca9d609ac4341007bda1d5d59866cdb5";
  		 $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
      	 $res = json_decode(httpGet($url));
        /*
        返回：
        	{"access_token":"ACCESS_TOKEN","expires_in":7200}
        */
        $access_token = $res->access_token;
        //echo var_dump($access_token);
        return $access_token;
    }


	








?>