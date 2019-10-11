<?php
$appid = "wx0a766465ad74001e";
$appsecret = "49b67f9262e29328f83da924b68c1982";
$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";

$output = https_request($url);
$jsoninfo = json_decode($output, true);

$access_token = $jsoninfo["access_token"];


$jsonmenu = '{
      "button":[
       {
           "name":"充电助手",
           "sub_button":[
            {
               "type":"view",
               "name":"扫码充电",
               "url":"http://pxywechat.applinzi.com/wechatTest/Charge/Home.php"
            },
            {
               "type":"view",
               "name":"下载APP",
               "url":"http://pxywechat.applinzi.com/wechatTest/Charge/download.html"
            }]
           
       },
       {
         
             "type":"view",
             "name":"地图找桩",
             "url":"http://pxywechat.applinzi.com/wechatTest/WebMap/webMap.html"
          
       },
       {
              "type":"view",
              "name":"充电记录",
              "url":"http://pxywechat.applinzi.com/wechatTest/My/recHome.php"
           
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