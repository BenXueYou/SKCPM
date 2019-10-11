<?php
class JSSDK {
  private $appId;
  private $appSecret;

  public function __construct($appId, $appSecret) {
    $this->appId = $appId;
    $this->appSecret = $appSecret;
  }

// 返回签名
  public function getSignPackage() {
      
    $jsapiTicket = $this->getJsApiTicket();

    // 注意 URL 一定要动态获取，不能 hardcode.
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $timestamp = time();
    $nonceStr = $this->createNonceStr();

    // 这里参数的顺序要按照 key 值 ASCII 码升序排序
    $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

    $signature = sha1($string);

    $signPackage = array(
      "appId"     => $this->appId,
      "nonceStr"  => $nonceStr,
      "timestamp" => $timestamp,
      "url"       => $url,
      "signature" => $signature,
      "rawString" => $string
    );
    return $signPackage; 
  }

    //返回签名随机串
  private function createNonceStr($length = 16) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
  }

    
    //返回JS列表
  private function getJsApiTicket() {
      
      
    // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
    $time = json_decode($this->get_token_time());
      
    if ($time < time()) {
      $accessToken = $this->getAccessToken();
      // 如果是企业号用以下 URL 获取 ticket
      // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
      $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
      $res = json_decode($this->httpGet($url));
      $ticket = $res->ticket;
      if ($ticket) {
        $data->expire_time = time() + 7000;
        $data->jsapi_ticket = $ticket;
        $this->set_token_access(json_encode($data));
      }
    } else {
      $ticket = $data->jsapi_ticket;
    }

    return $ticket;
  }

    
    //返回accessToken
  private function getAccessToken() {
    // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
      
      
    //从数据库中取数据
    $time = json_decode($this->get_token_time());
       
    if ($time < time()) {
      // 如果是企业号用以下URL获取access_token
      // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
        
      $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
        
      $res = json_decode($this->httpGet($url));
        
        /*
        返回：
        	{"access_token":"ACCESS_TOKEN","expires_in":7200}
        */
      
      $access_token = $res->access_token;
      if ($access_token) {
        $data->expire_time = time() + 7000;
        $data->access_token = $access_token;
        $this->set_token_access(json_encode($data));
          
          //数据库操作、修改存储的数据
      }
    } else {
        
      $access_token = $data->access_token;
        
    }
      
    return $access_token;
  }

    //返回请求
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

  private function get_token_time() {
        // 连主库
      /*$db = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
        // 连从库
        // $db = mysql_connect(SAE_MYSQL_HOST_S.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
        if ($db) {
            mysql_select_db(SAE_MYSQL_DB, $db);
            // ...
            //查询数据库表格中所有字段
            $result = mysql_query("SELECT * FROM xyWCT");
            	
          while($row = mysql_fetch_array($result))
          { 
               $time = $row['time']; 
          }
        }
       mysql_close($db);
    return $time;
      */
  }
    
  private function set_token_access($content) {
      
     // 配置参数
      
      /*$SAE_MYSQL_USER = "0w2l0lz4k1";
      $SAE_MYSQL_PASS = "xz4ilz0wlhymwmlk14w140ii3zi4ykjh0j14k240";
      $SAE_MYSQL_PORT = "3307";
      $SAE_MYSQL_HOST_M = "w.rdc.sae.sina.com.cn";
      $SAE_MYSQL_DB = "app_pxywechat";
      
        // 连主库
      //$db = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
        // 连从库
        // $db = mysql_connect(SAE_MYSQL_HOST_S.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
        if ($odb) {
            mysql_select_db(SAE_MYSQL_DB, $db);
            // ...
            $access_token = $content->access_token;
            $access_time = time();
            $id = '1';
             $result = mysql_query("SELECT * FROM xyWCT");
            if($result){
            	
               mysql_query("UPDATE xyWCT SET time = $access_time,access_token = $access_token WHERE id = 1");
            }
            $sql="INSERT INTO xyWCT (id, time, access_token) VALUES ($id,$access_time,$access_token)";
            if (!mysql_query($sql,$db)) 
            { 
                die('Error: ' . mysql_error());
            } 
            echo "1 record added"; 
        }      
     mysql_close($db);
 
      */
  }
}

