<?php
$appid = "wxe76a06a63e687acb";
$appsecret = "a594e4f4526e2b61863fc4b059b88a59";
$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";

$output = https_request($url);
$jsoninfo = json_decode($output, true);

$access_token = $jsoninfo["access_token"];
$jsonmenu = '{
      "button":[
      {  
         "type":"view",
         "name":"地图找桩",
         "url":"http://sksenk.cn/senkWechat/html/Map/webMap.html"
      },
      {

         "type":"view",
         "name":"扫码充电",
         "url":"http://sksenk.cn/senkWechat/html/SMCharging/Home.php"
      },
      {
         "name":"我的账户",
         "sub_button":[
           {
               "type":"view",
               "name":"我的账户",
               "url":"http://sksenk.cn/senkWechat/html/MY/myAccount.php"	
           },
           {
               "type":"view",
               "name":"充电记录",
               "url":"http://sksenk.cn/senkWechat/html/MY/recHome.php"
            }
         ]
      }]
    }';


$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
$result = https_request($url, $jsonmenu);
var_dump($result);

function https_request($url,$data = null){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}

?>
